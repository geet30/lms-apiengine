<?php

namespace App\Repositories\Affiliate;  
use App\Http\Services\PermissionsService; 
use DB; 
use Illuminate\Support\Facades\Redis;  
use App\Models\{User,AssignedUsers,Role,EmailTemplate, UserService,Services}; 
use App\Repositories\SparkPost\NodeMailer; 

trait AssignAffiliateBdmPermission
{
     /**
     * get list of all permissions and assigned permissions.
     *
     * @param  object  $request
     * @return \Illuminate\Http\JsonResponse
     */
    static function getServicePermissions($request)
    {
        try {
            $userId = $request->user_id;    
            $assignPermissions = \DB::table('model_has_permissions')
                ->join('permissions', 'permissions.id', 'model_has_permissions.permission_id')
                ->where('model_has_permissions.model_id', $userId)  
                ->where('model_has_permissions.service_id',$request->service_id)
                ->pluck('permissions.name')
                ->toArray();

            $permissionList = new PermissionsService;
            $allPermission = $permissionList->getPermissionsList()['permissions_section'];

            return response()->json(['permissions' => $allPermission , 'assignPermissions' => $assignPermissions],200);
        }
        catch (\Exception $err) {
            throw new \Exception($err->getMessage(),0,$err);
        }
    }

     /**
     * save the bradband plan form.
     *
     * @param  object  $request
     * @return \Illuminate\Http\JsonResponse
     */
    static function SavePermissions($request)
    {
        try {
            $user_id =  $request->id; 
            $selectPerm = isset($request->permissions)?$request->permissions:[];
            $selectedPermissions = DB::table('permissions')->select('id')->whereIn('name', $selectPerm)->pluck('id')->toArray();
            $assignPermissions =  DB::table('model_has_permissions')->where('model_id', $user_id)->where('service_id',$request->service_id)->pluck('permission_id')->toArray();    
            
            $deletePermissions=array_diff($assignPermissions,$selectedPermissions);
            $insertPermissions = array_diff($selectedPermissions,$assignPermissions);
            DB::table('model_has_permissions')->where('model_id', $user_id)->whereIn('permission_id',$deletePermissions)->delete();
            
            $savepermission = [];
            foreach ($insertPermissions as $permission) {
                $Permission['permission_id'] = $permission;
                $Permission['model_id'] = $user_id;  
                $Permission['model_type'] = 'App\Models\User';  
                $Permission['service_id'] = $request->service_id; 
                $savepermission[] = $Permission;
            }
            DB::table('model_has_permissions')->insert($savepermission); 
            $userPermissions = getPermissions($user_id);
            Redis::set('user_permission:' . $user_id, json_encode($userPermissions)); 

            return response()->json(['status' => true ,'message' => 'Permissions updated successfully.'],200);
        }
        catch (\Exception $err) 
        {
            throw new \Exception($err->getMessage(),0,$err);
        }
    }

    static function getAffiliateBDM($request)
    {  
        $userId = $request->user_id;
        $userType = 7;
        if($request->user == 'sub-affiliates')
        { 
            $userType = 8;
        }
        $users = self::getAssignedBdmUser($userType,$userId); 
        $verticals = UserService::with('serviceName')->where('user_id',decryptGdprData($userId))->get();
        return response()->json(['all_users' => $users,'verticals' => $verticals,'userId' =>$userId],200);
    }

    static function getAssignedBdmUser($userType,$userId)
    { 
            $assignedUserId = AssignedUsers::where('relation_type',$userType)->where('source_user_id',decryptGdprData($userId))->pluck('relational_user_id')->toArray();
 
            $users = User::with(['userService' => function($query)
            {
                $query->select('id','user_id','service_id');
            }])->whereIn('id',$assignedUserId)->orWhere('id',decryptGdprData($userId))->get()->toArray();

            $users = array_map(function ($user) { 
                $user['first_name'] = decryptGdprData($user['first_name']);
                $user['last_name'] = decryptGdprData($user['last_name']);
                $user['email'] = decryptGdprData($user['email']);
                $user['phone'] = decryptGdprData($user['phone']); 
                $user['assigned_service'] = implode(',',array_column($user['user_service'],'service_id'));
                return $user;
            }, $users); 
            
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function storeAffiliateBdm($request)
    {
        try
        {    
            $userId = $request->user_id;
            $role = 8; 
            $userType = 7;
            if($request->user == 'sub-affiliates')
            {
                $role = 9;
                $userType = 8; 
            }
            $data = [
                'first_name' => encryptGdprData($request->input('first_name')),
                'last_name' => encryptGdprData($request->input('last_name')),
                'email' => encryptGdprData($request->input('email')), 
                'phone' => encryptGdprData($request->phone),
                'role' => $role,
                'created_by' => auth()->user()->id,
                'password' => ''
            ];
            $user = self::create($data);
            if($user)
            {
                $services =[];
                foreach ($request->input('service') as $service) { 
                    $services[$service] = ['user_type' => '3'];
                }
                $user->services()->sync($services);
                $role = Role::where('id',$user->role)->pluck('name')->first();
                $user->assignRole($role);
                $token = app('auth.password.broker')->createToken($user); 
                self::where('email',encryptGdprData($request->email))->update(['token' => $token]);

                AssignedUsers::create(
                    [
                        'source_user_id' => decryptGdprData($request->user_id),
                        'relational_user_id' => $user->id,
                        'relation_type' => $userType,
                        'service_id' => '1',
                        'assigned_by' => auth()->user()->id,
                        'status' => 1
                    ]
                );
            }  
             
            $email = EmailTemplate::whereId(3)->select("title","subject","description","from_email","status")->first();
            $find = ['@Name@', '@Phone@','@Link@','@Email@'];
            $time=time()+strtotime('2 day', 0);
            $url = encryptGdprData($time.'+'.$token);
            $link = url('/generate-password/' . $url);
            $values = [$user->name,$request->phone,$link,$request->email];
            $html = str_replace($find, $values, $email->description); 
            $mailData = [];
            $mailData['text'] = '';
            $mailData['from_email'] = 'support@cimet.com.au';
            $mailData['from_name'] = 'CIMET Support Team'; 
            $mailData['subject'] =$email->subject;  
            $mailData['html']  = $html;
            $mailData['user_email'] = $request->email;
            $mailData['service_id'] = '1';  
            $mailData['cc_mail'] =[];  
            $mailData['bcc_mail'] =[];  
            $mailData['attachments'] =[];  
            $nodeMailer = new NodeMailer();
            $response  = $nodeMailer->sendMail($mailData, true);  
            $userType = 7;
            if($request->user == 'sub-affiliates')
            { 
                $userType = 8;
            }
            $users = self::getAssignedBdmUser($userType,$request->user_id); 
            return response()->json(['status' => true,'all_users' => $users,'userId' => $userId], 200);
        }
        catch(\Exception $err){
            throw new \Exception($err->getMessage(),0,$err);
        }
    }

    static function updateAffiliateBdm($request,$idVal)
    {
        try
        { 
            $userId = $request->user_id;
            $users = [];
            $res = 0;
            switch ($request->input('update')) {
                case 'status': 
                    $res =  User::find($idVal)->update([
                                'status' =>$request->input('status')
                            ]);
                    break;
                case 'update':
                    $role = 8;  
                    $userType = 7;
                    if($request->user == 'sub-affiliates')
                    {
                        $role = 9; 
                        $userType = 8;
                    }
                    $res = User::find($idVal)->update([
                                'first_name' =>encryptGdprData($request->input('first_name')),
                                'last_name' =>encryptGdprData($request->input('last_name')),
                                'email' =>encryptGdprData($request->input('email')),
                                'role' =>$role,
                                'phone' =>encryptGdprData($request->phone),
                            ]);
                    $user = User::find($idVal);
                    $services =[];
                    if(isset($request->service))
                    {
                        foreach ($request->input('service') as $service) { 
                            $services[$service] = ['user_type' => '3'];
                        }
                    }
                    $user->services()->sync($services);
                    $role = Role::where('id',$user->role)->pluck('name')->first();
                    $user->syncRoles($role);
                    
                    $users = self::getAssignedBdmUser($userType,$request->user_id);  
                    break;
            }
            return response()->json(['status' => $res,'all_users'=> $users, 'userId' => $userId], 200);
        }
        catch(\Exception $err){
            throw new \Exception($err->getMessage(),0,$err);
        }
    }

    static function getAffiliateBdmPermissions($request)
    {
        try
        { 
            $mainAffId = $request->userId;
            $userId = $request->id; 
            $user = auth()->user();
            $userRole=$user->roles[0]->id?? '';
            $records = User::select('first_name', 'last_name', 'email', 'phone', 'id', 'status','role')->with([ 
                'affiliate' => function ($q) {
                    $q->select('id', 'user_id', 'referral_code_title', 'referral_code_url', 'parent_id', 'referal_code', 'logo', 'company_name');
                }
            ])->where('id', decryptGdprData($mainAffId))->first();  
            
            $records['logo'] = $records->affiliate->logo;
            $verticals=UserService::where(['user_id'=>$userId,'status' =>1])->with('serviceName')->get();  
            
            return view('pages.affiliates.affsettings.components.permissions.assign-permission',compact('verticals','userId','records','mainAffId','userRole'));
        }
        catch(\Exception $err){
            throw new \Exception($err->getMessage(),0,$err);
        }
    }
}
