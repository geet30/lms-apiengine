<?php
namespace App\Http\Controllers\Plans;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plan\EditPlanRequest;
use App\Models\PlanEnergy;
use App\Models\PlanEicContent;
use App\Models\CheckBoxContent;
use App\Models\PlanRemarketingInformation;
use App\Models\PlanTag;
use App\Models\Providers;
use App\Models\Tag;
use Config;
use Illuminate\Support\Facades\Session;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($energy,$providerId, Request $request)
    {
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('show_energy_plans',$userPermissions,$appPermissions) || !checkPermission('show_providers',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/');
        }
        $info = auth()->user()->info;
        $providerId = decryptGdprData($providerId);
        $allStatus = config::get('planData.statusList');

        if($request->has('filter_status'))
            $activeStatus = $request->filter_status;
        else
            $activeStatus = 1;

        $allPlans = PlanEnergy::getPlans($energy,$providerId,$request);
        $selectedProvider = Providers::with([
            'providersLogo' => function($query){
                $query->select('user_id','name','category_id');
            },
        ])->where('user_id',$providerId)->first();
        if(!empty($allPlans)){
            $allPlans =$allPlans->toArray();
        }

        return view('pages.plans.energy.list', compact('selectedProvider','info', 'providerId','allPlans','energy','allStatus','activeStatus','userPermissions','appPermissions'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($planId)
    {
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('show_energy_plans',$userPermissions,$appPermissions) || !checkPermission('show_providers',$userPermissions,$appPermissions)  || !checkPermission('edit_energy_plan',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/provider/list');
        }
        $planId = decryptGdprData($planId);
        $contractLength = Config::get('planData.contract_length');
        $benefitTerms = Config::get('planData.benefit_terms');
        $billingOption = Config::get('planData.billing_option');
        $applyNowAttr = Config::get('planData.apply_now_attributes');
        $eicAttr = Config::get('planData.eic_attributes');
        $remarketingAttr = Config::get('planData.remarketing_attributes');
        $moduleTypes = Config::get('planData.moduleTypes');
        $editPlan = PlanEnergy::getEditPlan($planId);
        if(!empty($editPlan)){
            $editPlan =$editPlan->toArray();
        }else{
            return view('errors.404');

        }
        $headArr["link"] = URL('provider/plans/energy/'.$editPlan['energy_type'].'/list'.'/'.encryptGdprData($editPlan['provider_id']));
        $headArr["title"] = "Edit Plan";
       // dd($editPlan);
       $selectedProvider = Providers::where('user_id',$editPlan['provider_id'])->first();
        return view('pages.plans.energy.edit.index', compact('selectedProvider','planId','editPlan','contractLength','benefitTerms','billingOption','applyNowAttr','eicAttr','remarketingAttr','headArr','moduleTypes'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPlanRequest $request)
    {
        $editPlan = PlanEnergy::updatePlan($request);
        return $editPlan;
    }
    public function postChangeStatus(EditPlanRequest $request)
    {
        $cahngeStatus = PlanEnergy::changeStatus($request);
        $message=trans('plans.chnageStatus');
        if($cahngeStatus){
            return response()->json(['status' => 200, 'message' => $message ]);
        }
    }
    public function getRemarketingData(Request $request){
        try{
            return PlanRemarketingInformation::where('plan_id',$request->plan_id)->first();
        } catch(\Exception $err){
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getEicData(Request $request){
        try{
            return PlanEicContent::where('plan_id',$request->plan_id)->first();
        } catch(\Exception $err){
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public function getEicCheckboxData(Request $request){
        try{
            return CheckBoxContent::where('type_id',$request->type_id)->where('type',1)->get();
        } catch(\Exception $err){
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getPlanTagData(Request $request){
        try{
           $allTags= Tag::select('id','name')->where('is_deleted',0)->where('status',1)->get();
           $planTags = PlanTag::where('plan_id',$request->plan_id)->pluck('tag_id');

            return response()->json(['allTags'=>$allTags,'planTags'=>$planTags,'status'=>200],200);
        } catch(\Exception $err){
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateAgentStatus(Request $request)
    {
        try {
            return PlanEnergy::updateAgentPortal($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
}
