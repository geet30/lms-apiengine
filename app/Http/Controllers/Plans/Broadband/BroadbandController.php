<?php

namespace App\Http\Controllers\Plans\Broadband;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ 
    PlansBroadband, 
};
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Plan\Broadband\{
                AddPlanValidation,
                EditPlanValidation,
                IncludedAddonRequest,
                EditTermConditionRequest,
                PostPlanEICRequest,
                PostPlanEICCheckboxRequest,
                PlanBroadbandFeeRequest,
                OtherAddonRequest
        };
 
class BroadbandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    { 
        try 
        {
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            if(!checkPermission('show_broadband_plans',$userPermissions,$appPermissions) || !checkPermission('show_providers',$userPermissions,$appPermissions))
            {
                Session::flash('error', trans('auth.permission_error'));
                return redirect('/');
            }
            $response = PlansBroadband::getPlanListing($request,$userPermissions,$appPermissions); 
            return view('pages.plans.broadband.list',$response['compact']); 
        }
        catch (\Exception $err) {
            Session::flash('error', $err->getMessage()); 
            return redirect('/provider/list');
        }
    }

    /**
     * Display create plan blade file.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    { 
        try 
        {
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            if(!checkPermission('show_broadband_plans',$userPermissions,$appPermissions) || !checkPermission('show_providers',$userPermissions,$appPermissions) || !checkPermission('add_broadband_plan',$userPermissions,$appPermissions) )
            {
                Session::flash('error', trans('auth.permission_error'));
                return redirect('/provider/list');
            }
            $response = PlansBroadband::getCreatePlan($request);
            return view('pages.plans.broadband.create_update.index',$response['compact']);
        } 
        catch (\Exception $err) {
            Session::flash('error', $err->getMessage()); 
            return redirect('/provider/list');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $planId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($planId)
    { 
        try
        {
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            if(!checkPermission('show_broadband_plans',$userPermissions,$appPermissions) || !checkPermission('show_providers',$userPermissions,$appPermissions) || !checkPermission('edit_broadband_plan',$userPermissions,$appPermissions) )
            {
                Session::flash('error', trans('auth.permission_error'));
                return redirect('/provider/list');
            }
            $response = PlansBroadband::getEditPlan($planId);  
            return view('pages.plans.broadband.create_update.index',$response['compact']);
        } 
        catch (\Exception $err) {
            Session::flash('error', $err->getMessage()); 
            return redirect('/provider/list');
        }
    }
 
    /**
     * save the bradband plan form.
     *
     * @param  int  $providerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddPlanValidation $request,$providerId)
    {   
        try
        {
            $result = PlansBroadband::insertPlan($request,$providerId);
            return response()->json(['status' => $result,'message' => trans('plans/broadband.plan_saved_toastr')],200);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }
 
    /**
     * update the broadband plan form.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EditPlanValidation $request)
    {   
        try
        {
            $response = PlansBroadband::updatePlan($request);
            return response()->json(['status' => $response['status'],'plan_data' => $response['plan_data'],'addondata' => $response['addondata'],'message' => trans('plans/broadband.plan_updated_toastr')],200);   
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     * update the included addons data.
     * 
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response.
     */
    public function updateIncludedAddons(IncludedAddonRequest $request)
    {
        try
        {
            $response = PlansBroadband::updateIncludedAddonRepo($request);
            return $response;
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     * update the plan term and condition.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTermCondition(EditTermConditionRequest $request)
    {  
        try
        {
            $response = PlansBroadband::updateTermConditionRepo($request); 
            return response()->json(['status' => $response,'message' => trans('plans/broadband.term_condition_toastr')],200);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     * update the plan EIC content.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEicContent(PostPlanEICRequest $request)
    {  
        try
        {
            $response = PlansBroadband::updateEicContentRepo($request);
            return response()->json(['status' => $response,'message' => trans('plans/broadband.acknowledgement_toastr')],200);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     * update the EIC content checkbox.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEicContentCheckbox(PostPlanEICCheckboxRequest $request)
    {
        try
        {
            $response = PlansBroadband::updateEicContentCheckboxRepo($request);
            return response()->json($response['data'],$response['status']);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     * update the EIC content checkbox.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEicContentCheckbox(PostPlanEICCheckboxRequest $request)
    {
        try
        {
            $response = PlansBroadband::deleteEicContentCheckboxRepo($request);
            return response()->json($response['data'],$response['status']);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }
    
    /**
     * get list of technology by selected connection type.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTechnologyType(Request $request)
    {  
        try
        {
            $response = PlansBroadband::getTechType($request->id);
            return response()->json(['data' => $response],200);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     * store plan fees in database.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePlanFee(PlanBroadbandFeeRequest $request)
    {   
        try
        {
            $response = PlansBroadband::savePlanFeeRepo($request);
            return response()->json($response['data'],$response['status']);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     * store plan fees in database.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePlanFee(Request $request)
    {   
        try
        {
            $response = PlansBroadband::deletePlanFeeRepo($request);
            return response()->json($response['data'],$response['status']);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     *store other addons in database.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOtherAddon(OtherAddonRequest $request)
    {   
        try
        {
            $response = PlansBroadband::saveOtherAddonRepo($request);
            return response()->json(['status' => $response ,'message' => trans('plans/broadband.other_addon_toastr')],200);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     *change plan status in database.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {   
        try
        { 
            $response = PlansBroadband::changeStatusRepo($request);
            return response()->json(['status' => $response,'message' => trans('plans/broadband.change_status_toastr')],200);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }
}
