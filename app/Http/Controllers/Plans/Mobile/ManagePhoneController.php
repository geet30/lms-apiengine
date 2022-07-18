<?php

namespace App\Http\Controllers\Plans\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

use App\Models\{  
    PlanMobileHandset, 
};
use App\Http\Requests\Plan\Mobile\EditPlanVariantRequest;
class ManagePhoneController extends Controller
{
    /**
     * Display a listing of the assigned handsets.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try 
        {  
            $response = PlanMobileHandset::getHandsetListing($request); 
            return view('pages.plans.mobile.phones.list', $response);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * get list of alls handsets which will be assigned to plans
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchHandsetsToAssignPlan(Request $request)
    {
        try 
        {  
            $response = PlanMobileHandset::gethandsetsToAssign($request); 
            return response()->json(['data' => $response],200);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * assign handset to plans.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAssignPhone(Request $request)
    { 
        try 
        {  
            $response = PlanMobileHandset::postAssignPhones($request);  
            return response()->json($response,200);  
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * change phone status
     * 
     * @return \Illuminate\Http\JsonResponse
    */
   public function changePhoneStatus(Request $request)
   {
        try 
        {  
            $response = PlanMobileHandset::changePhoneStatus($request);  
            return response()->json($response,$response['status']);  
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display variant listing.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function getPhoneVariant(Request $request)
    { 
        try 
        {  
            $response = PlanMobileHandset::getVariantListing($request); 
            return view('pages.plans.mobile.phones.variants.list', $response);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display edit variant form.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editPhoneVariant(Request $request)
    {
        try 
        {  
            $response = PlanMobileHandset::getEditPhoneVariant($request); 
            return view('pages.plans.mobile.phones.variants.create_update.edit', $response);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display variant status.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeVariantStatus(Request $request){
        try 
        {  
            $response = PlanMobileHandset::changeVariantStatus($request);  
            return response()->json($response,$response['status']);  
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * assign variant detail
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function postEditAssignedVariantDetail(EditPlanVariantRequest $request)
    {
        try
        {  
            return PlanMobileHandset::updateAssignedPlanVariantDetails($request);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    } 
}