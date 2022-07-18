<?php
namespace App\Http\Controllers\ManageUser;
use App\Http\Requests\User\{AddUserValidation,AssignUserRequest};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Services,Role,EmailTemplate};
use Hash; 
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{ 
    public function index(Request $request)
    {
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('show_users',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/');
        } 
        return User::getUserListing($request,$userPermissions,$appPermissions);  
    }

     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserValidation $request)
    {
        try
        { 
            return User::storeUser($request);
        }
        catch(\Exception $err){ 
            $response['message'] = $err->getMessage();
            return response()->json($response, 400);
        }
    }

    public function update(AddUserValidation $request,$idVal)
    { 
        try
        {  
            return User::updateUser($request,$idVal); 
        }
        catch(\Exception $err){
            $response['message'] = $err->getMessage();
            return response()->json($response, 400);
        }
    }

    /**
     * Render Assign Affiliate page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getLinkUser(Request $request,string $id)
    {
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('assign_affliate',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error')); 
            return redirect('/manage-user/list');
        }
        return User::getLinkUsersData($request,$id);    
    }

    /*
     * Name: getSubAffiliates()
     * Purpose: get all sub affiliates based on affiliate selected.
    */
    public function getSubAffiliates(Request $request)
    {
        try
        {
            $responseData = User::getSubAffiliatesData($request);
            if($responseData['status'])
            {
                return response()->json(['data' => $responseData['data'], 'assigned_users' => $responseData['assigned_users']], 200);
            }
            return response()->json([ 'message' => trans('admin/common.error_message')], 400);
        }
        catch(\Exception $err){ 
            $response['message'] = $err->getMessage();
            return response()->json($response,400);
        }
    }

    public function postLinkUser(AssignUserRequest $request)
    {
        User::postLinkUsersData($request);
        return response()->json([ 'message' => 'Affiliate Assigned Successfully.'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPermissions(Request $request,string $id)
    {
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('assign_permissions',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error')); 
            return redirect('/manage-user/list');
        }
        return User::getPermissionsData($request,$id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postPermissions(Request $request)
    {
        return User::postSetPermissionsData($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTemplatePermissions(Request $request)
    {
        return User::postTemplatePermissionsData($request);
    }
}