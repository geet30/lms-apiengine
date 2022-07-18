<?php

namespace App\Repositories\User;
use App\Http\Services\UserPermissionsService;
use App\Models\{
    User,Affiliate,Role,EmailTemplate,AssignUser,WhitelistAffiliateIp,Services,Permission,PermissionsTemplate,PermissionRoleTemplate,UserSetting,UserService
};
use Exception;
use App\Repositories\SparkPost\NodeMailer;
use Illuminate\Support\Facades\{DB,Redis};
trait ManageUserCrud
{
    static function getUserListing($request,$userPermissions,$appPermissions)
    {
        $role =  self::getRoleByPermissions($userPermissions,$appPermissions);
        $roles = Role::whereIn('id',$role)->pluck('name','id')->toArray(); 
        $users = User::with(['userService' => function($query)
                {
                    $query->select('id','user_id','service_id');
                }])->whereIn('role',$role)->orderBy('id','desc');
         
        if ($request->method() == 'POST') {

            if (isset($request->first_name)) 
            {
                $users =$users->where('first_name',encryptGdprData($request->first_name));
            }
            if (isset($request->email)) 
            {
                $users =$users->where('email',encryptGdprData($request->email));
            }
            if (isset($request->status) && $request->status != 2) 
            {
                $users =$users->where('status',$request->status);
            } 
            if (isset($request->role)) 
            {
                $users =$users->where('role',$request->role);
            }
            $users =$users->get()->toArray(); 
            $users = array_map(function ($user) use($roles) { 
                $user['id'] = encryptGdprData($user['id']);
                $user['first_name'] = decryptGdprData($user['first_name']);
                $user['first_name'] = decryptGdprData($user['first_name']);
                $user['last_name'] = decryptGdprData($user['last_name']);
                $user['email'] = decryptGdprData($user['email']);
                $user['phone'] = decryptGdprData($user['phone']);
                $user['assigned_service'] = implode(',',array_column($user['user_service'],'service_id'));
                $user['role_name'] = isset($roles[$user['role']]) ? ucwords($roles[$user['role']]):'N/A';
                
                return $user;
            }, $users); 
            return response()->json(['all_users' => $users,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions], 200);
        } 
        $users = $users->get(); 
        $services = Services::get();
        return view('pages.users.list',compact('users','services','roles','userPermissions','appPermissions'));
    }

    static function getRoleByPermissions($userPermissions,$appPermissions)
    { 
        $role = [1,4,5,6];
        if(auth()->user()->role != 7)
        { 
            $role = [];
            if(checkPermission('users_assign_admin_permission',$userPermissions,$appPermissions))
            { 
                $role[] = 1;
            }
            if(checkPermission('users_assign_qa_permission',$userPermissions,$appPermissions))
            {
                $role[] = 4;
            }
            if(checkPermission('users_assign_bdm_permission',$userPermissions,$appPermissions))
            {
                 $role[] = 5;
            }
            if(checkPermission('users_assign_accountant_permission',$userPermissions,$appPermissions))
            {
               $role[] = 6;
            } 
        }  
        return $role;
    }

    static function storeUser($request)
    {
        try
        { 
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            $data = [
                'first_name' =>encryptGdprData($request->input('first_name')),
                'last_name' =>encryptGdprData($request->input('last_name')),
                'email' =>encryptGdprData($request->input('email')),
                'role' =>$request->input('role'),
                'phone' =>encryptGdprData($request->phone),
                'created_by' =>auth()->user()->id,
                'password' => ''
            ]; 
            $user = User::create($data); 
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
                User::where('email',encryptGdprData($request->email))->update(['token' => $token]);
            }  
            $roles = Role::pluck('name','id')->toArray(); 
            $users = User::with(['userService' => function($query)
                    {
                        $query->select('id','user_id','service_id');
                    }])->whereIn('role',[1,4,5,6])->orderBy('id','desc')->get()->toArray();
            $users = array_map(function ($user) use ($roles) { 
                $user['id'] = encryptGdprData($user['id']);
                $user['first_name'] = decryptGdprData($user['first_name']);
                $user['last_name'] = decryptGdprData($user['last_name']);
                $user['email'] = decryptGdprData($user['email']);
                $user['phone'] = decryptGdprData($user['phone']);
                $user['assigned_service'] = implode(',',array_column($user['user_service'],'service_id'));
                $user['role_name'] = isset($roles[$user['role']]) ? ucwords($roles[$user['role']]):'N/A';
                return $user;
            }, $users); 

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
            $nodeMailer->sendMail($mailData, true);    
            return response()->json(['status' => true,'all_users' => $users,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions], 200);
        }
        catch(\Exception $err){
            throw new Exception($err->getMessage(),0,$err);
        }
    }

    static function updateUser($request,$idVal)
    { 
        try
        {  
            $idVal = decryptGdprData($idVal);
            $users = [];
            $res = 0;
            switch ($request->input('update')) {
                case 'status': 
                    $res =  User::find($idVal)->update([
                                'status' =>$request->input('status')
                            ]);
                    break;
                case 'update':
                    $res = User::find($idVal)->update([
                                'first_name' =>encryptGdprData($request->input('first_name')),
                                'last_name' =>encryptGdprData($request->input('last_name')),
                                'email' =>encryptGdprData($request->input('email')),
                                'role' =>$request->role,
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
                    $users = User::with(['userService' => function($query)
                    {
                        $query->select('id','user_id','service_id');
                    }])->whereIn('role',[1,4,5,6])->orderBy('id','desc')->get()->toArray();
                    $roles = Role::pluck('name','id')->toArray(); 
                    $users = array_map(function ($user) use($roles) {
                        $user['id'] = encryptGdprData($user['id']);
                        $user['first_name'] = decryptGdprData($user['first_name']);
                        $user['last_name'] = decryptGdprData($user['last_name']);
                        $user['email'] = decryptGdprData($user['email']);
                        $user['phone'] = decryptGdprData($user['phone']);
                        $user['assigned_service'] = implode(',',array_column($user['user_service'],'service_id'));
                        $user['role_name'] = isset($roles[$user['role']]) ? ucwords($roles[$user['role']]):'N/A';
                        return $user;
                    }, $users); 
                    break;
            }
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            return response()->json(['status' => $res,'all_users'=> $users,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions], 200);
        }
        catch(\Exception $err){
            throw new \Exception($err->getMessage(),0,$err);
        }
    }

    static function getLinkUsersData($request,$idVal)
    {
        try
        {   
            $user_id = decryptGdprData($idVal);
            $user = self::whereId($user_id)->first(); 
             
            //get all ip's assigned to user
            $data_ips = WhitelistAffiliateIp::where('affiliate_id' ,$user_id )->pluck('ips')->toArray();
            $whitelist_ip = implode(',', $data_ips); 
            //get all affiliates
            $affiliates = Affiliate::has('user')->where('parent_id',0)->get(); 
            $assigned = AssignUser::where('source_user_id',$user_id)->get()->groupBy('relation_type'); 
            //get assigned affiliates
            $selectedAffiliates = isset($assigned[2])?array_column($assigned[2]->toArray(),'relational_user_id'):[];
            //get assigned sub affiliates  
            $selectedSubAff = isset($assigned[3])?array_column($assigned[3]->toArray(),'relational_user_id'):[]; 
            $selectSubAffData =Affiliate::whereIn('user_id',$selectedSubAff)->select('id','user_id','parent_id','status')->get()->toArray();

            $selectMasterAffData = Affiliate::whereIn('id',array_column($selectSubAffData,'parent_id'))->has('user')->select('id','user_id','parent_id')->get()->toArray(); 

            $selectedMasterAff = array_column($selectMasterAffData, 'user_id');
            $allSubAffiliatesData =Affiliate::with(
                    [
                     'user' => function ($query) {
                            $query->select('id','first_name','last_name','email','status');
                        },
                     'getParentAffiliate'=> function ($q) { $q->select('id', 'legal_name','company_name'); }
                    ])
                    ->has('user')
                    ->whereIn('parent_id',array_column($selectMasterAffData, 'id'))->select('id','user_id','parent_id','legal_name','company_name','status')->get(); 
            //get bdm date range
            $bdmDateRange = UserSetting::where('user_id',$user_id)->first();
            return view('pages.users.assign-affiliates',compact('user','idVal','affiliates','selectedAffiliates','whitelist_ip','bdmDateRange','selectedSubAff','selectedMasterAff','allSubAffiliatesData'));
        }
        catch(\Exception $err){
            throw new Exception($err->getMessage(),0,$err);
        }
    }

    static function getSubAffiliatesData($request)
    {
        try
        { 
            if($request->input('master_affiliate') == '' || $request->input('master_affiliate') ==null)
            {
                return response()->json(['status'=>false,'message'=>'Affiliate field is required'], 400);
            }
            $user_id = decryptGdprData($request->input('user_id'));
            $assigned_users = [];
            $parent_id = $request->input('master_affiliate');  

            $affiliates_id = Affiliate::whereIn('user_id',$parent_id)->get('id')->toArray();
            $aff_id = array_column($affiliates_id, 'id'); 
            $affiliates = Affiliate::orderBy('id','desc')
                ->whereIn('parent_id',$aff_id)
                ->with(
                [
                    'user',
                    'getParentAffiliate' => function ($q) { $q->select('id', 'legal_name','company_name'); }
                ])
                ->has('user')
                ->get()->toArray();

            $assigned_users = AssignUser::where('source_user_id', $user_id)->where('relation_type',3)->pluck('relational_user_id')->toArray();

           foreach ($affiliates as $key => $value) {
                $object =  new \stdClass();
                $object->legal_name = decryptGdprData($value['get_parent_affiliate']['legal_name']);
                $object->company_name = $value['get_parent_affiliate']['company_name'];
                $object->id = $value['get_parent_affiliate']['id'];
                $affiliates[$key]['get_parent_affiliate'] = $object;              
            }
            return ['status'=>1, 'data' => $affiliates, 'assigned_users' => $assigned_users];
        }
        catch(\Exception $err){ 
            throw new Exception($err->getMessage(),0,$err);
        }
    }

    static function postLinkUsersData($request)
    { 
            //convert ip's string to array
            $user_id = $request->input('user_id'); 

            //Delete all ip's affiliates
            WhitelistAffiliateIp::where('affiliate_id',$user_id)->delete();
            if($request->ip != null && $request->ip != '')
            {
                $ips = implode(', ', array_column(json_decode($request->ip), 'value'));
                $ips = explode(',', $ips);
                $insertIps = [];
                if(isset($request->ip) && $request->ip !=''){
                    foreach ($ips as $value)
                    {
                        $insertIps[] =  [
                                            'affiliate_id'=>$user_id,
                                            'ips'=>$value,
                                        ];
                    }
                    //Insert all new ip's
                    WhitelistAffiliateIp::insert($insertIps);
                }
            } 

            $assignedBy = auth()->user()->id; 
            self::assignAffOrSubAff($request,'affiliates',$user_id,2,$assignedBy);
            
            self::assignAffOrSubAff($request,'sub_affiliates',$user_id,3,$assignedBy);

            //Date range
            $startDate = $request->input('date_range_from');
            if ($startDate !=null && $startDate !='')
            {
                $endDate = '';
                $date_range_checkbox = 1;
                if (!$request->has('date_range_checkbox')) {
                    $endDate = $request->input('date_range_to');
                    $date_range_checkbox = 0;
                }
                $userSetting = UserSetting::firstOrCreate(['user_id' => $user_id]);
                $userSetting->date_range_from = $startDate;
                $userSetting->user_id = $user_id;
                $userSetting->date_range_to = $endDate;
                $userSetting->date_range_checkbox = $date_range_checkbox;
                $userSetting->save();
            }
    }

    static function assignAffOrSubAff($request,$type,$user_id,$relationType,$assignedBy)
    { 
            AssignUser::where('source_user_id', $user_id)->where('relation_type',$relationType)->delete();
            $data = []; 
            $subAffSelected = $request->input($type); 
            if ($request->has($type)) {
                foreach ($subAffSelected as $value) {
                    $data[] = [
                                'source_user_id' => $user_id,
                                'relational_user_id' => $value,
                                'relation_type' => $relationType,
                                'assigned_by' => $assignedBy
                               ];
                }
                AssignUser::insert($data);  
            }
    }

    static function getPermissionsData($request,$idVal)
    {
        try
        {     
            $templates = [];
            $user_id = decryptGdprData($idVal);
            $permissionList = new UserPermissionsService;
            $allPermission = $permissionList->getPermissionsList()['permissions_section'];   
            $user = User::whereId($user_id)->first();
            $assignPermissions = $user->getAllPermissions()->toArray();   
            $assignPermissions = array_column($assignPermissions,'name'); 
 
            $templateData = PermissionsTemplate::where('role_id',$user->role)->get(); 
            foreach($templateData as $template){
                $templates[$template->id]=$template->name;
            }
            $role =  $user->roles->pluck('name')[0];
            $allServices = Services::get();  
            return view('pages.users.assign-permissions',compact('user','idVal','role','allPermission','templates','user_id','assignPermissions','allServices'));
        }
        catch(\Exception $err){
             throw new Exception($err->getMessage(),0,$err);
        }
    }

    static function postSetPermissionsData($request)
    {
        try
        { 
            $user_id = $request->id;
            $user = User::find($user_id);
            $selectPerm = isset($request->template_permission)?$request->template_permission:[];
            $selectedPermissions = Permission::select('id')->whereIn('name', $selectPerm)->pluck('id')->toArray(); 
                
            $assignPermissions = array_column($user->getAllPermissions()->toArray(),'id');    
            
            $deletePermissions=array_diff($assignPermissions,$selectedPermissions); 
            $insertPermissions = array_diff($selectedPermissions,$assignPermissions);  
 
            DB::table('model_has_permissions')->where('model_id', $user_id)->whereIn('permission_id',$deletePermissions)->delete();
            
            $savepermission = [];
            foreach ($insertPermissions as $permission) {
                $Permission['permission_id'] = $permission;
                $Permission['model_id'] = $user_id;  
                $Permission['model_type'] = 'App\Models\User';
                $Permission['service_id'] = '0';  
                $savepermission[] = $Permission;
            } 
            DB::table('model_has_permissions')->insert($savepermission); 
            if (Redis::exists('user_permission:' . $user_id)) {
                $userPermissionsObj = getPermissions($user_id);  
                Redis::set('user_permission:' . $user_id, json_encode($userPermissionsObj)); 
            }   
            User::where('id',$user_id)->update(['permission_services'=>implode(',', $request->service_id),'permission_template'=>$request->permission_template]); 
            return response()->json(['message' => 'Permissions updated successfully'],200);
        }
        catch(\Exception $err){ 
            throw new Exception($err->getMessage(),0,$err);
        }
    }

    static function postTemplatePermissionsData($request)
    {
        try
        {
            $allPermission=[];
            $permissoionData = PermissionRoleTemplate::where('template_id',$request->template_id)->with('permissionName')->get();
            foreach($permissoionData as $permission){
                $allPermission[]=$permission['permissionName']['name'];
            }
            return response()->json(['permissions' => $allPermission],200);
        }
        catch(\Exception $err){ 
            throw new Exception($err->getMessage(),0,$err);
        }
    }
}
