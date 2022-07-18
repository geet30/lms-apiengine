<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Providers\StoreVhaCodeRequest;
use App\Models\{  
    ProviderHandset, 
};
use Illuminate\Support\Facades\Session;

class ManageProviderPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {  
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            if(!checkPermission('provider_action',$userPermissions,$appPermissions) || !checkPermission('show_providers',$userPermissions,$appPermissions) || !checkPermission('provider_assigned_phones',$userPermissions,$appPermissions))
            {
                Session::flash('error', trans('auth.permission_error'));
                return redirect('/provider/list');
            }
            $response = ProviderHandset::getHandsetListing($request); 
            return view('pages.providers.phones.list', $response); 
        } catch (\Throwable $th) {
            throw $th;
        }
    }
  
    /**
     * change status
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function changeStatus(Request $request)
    { 
        try {  
            $response = ProviderHandset::changePhoneStatus($request); 
            return response()->json($response,$response['status']);
        } catch (\Throwable $th) {
            throw $th;
        } 
    }

    /**
     * delete assigned handset 
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function deleteHandsetProvider(Request $request){
        try {  
            $response = ProviderHandset::deleteHandsetProvider($request); 
            return response()->json($response,$response['status']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


   /**
     * return variant listintg
     *
     * @return \Illuminate\View\View
     */
   public function getVariantListing(Request $request)
   { 
        try {  
            $response = ProviderHandset::getVariantListing($request); 
            return view('pages.providers.phones.variants.list', $response); 
        } catch (\Throwable $th) {
            throw $th;
        } 
   }
 
    /**
     * change variant status
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function changeProviderVariantStatus(Request $request)
    {    
        try {  
            $response = ProviderHandset::changeProviderVariantStatus($request); 
            return response()->json($response,$response['status']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * delete provider variant
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function deleteProviderVariant(Request $request){ 
        try {  
            $response = ProviderHandset::deleteProviderVariant($request); 
            return response()->json($response,$response['status']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * store vha code
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function storeVHACode(StoreVhaCodeRequest $request){ 
        try {  
            $response = ProviderHandset::storeVHACode($request); 
            return response()->json($response,$response['status']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }  

    /**
     * show images
     * note:- common method used to display variant images
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function showVariantImages(StoreVhaCodeRequest $request){ 
        try {  
            $response = ProviderHandset::showVariantImages($request); 
            return response()->json($response,$response['status']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
