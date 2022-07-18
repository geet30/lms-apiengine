<?php
namespace App\Http\Controllers\Affiliates;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  
use App\Models\{User}; 
use App\Http\Requests\Affiliates\{AffiliatePermissions,AddAffiliateBdmUser}; 

class AssignPermission extends Controller
{

    /**
     * get bdm affiliate listing 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAffiliateBDM(Request $request)
    { 
        return User::getAffiliateBDM($request);
    }
     
    /**
     * Store a newly created user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAffiliateBdm(AddAffiliateBdmUser $request)
    {
        try
        {    
            return User::storeAffiliateBdm($request);
        }
        catch(\Exception $err){
            $http_status = 400;
            $response['message'] = $err->getMessage();
            return response()->json($response, $http_status);
        }
    }

    /**
     * update user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAffiliateBdm(AddAffiliateBdmUser $request,$idVal)
    {
        try
        {
            return User::updateAffiliateBdm($request,$idVal); 
        }
        catch(\Exception $err){
            $http_status = 400;
            $response['message'] = $err->getMessage();
            return response()->json($response, $http_status);
        }
    }

     /**
     * get assign permission page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAffiliateBdmPermissions(Request $request)
    {
        try
        {
            return User::getAffiliateBdmPermissions($request);  
        }
        catch(\Exception $err){
            throw new \Exception($err->getMessage(),0,$err);
        }
    }

     /**
     * get list of all permissions and assigned permissions.
     *
     * @param  object  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServicePermissions(Request $request)
    {
        try {
             return User::getServicePermissions($request);
        }
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * save the permissions
     *
     * @param  object  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function SavePermissions(AffiliatePermissions $request)
    {
        try {
            return User::SavePermissions($request);
        }
        catch (\Exception $err) 
        {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }
}