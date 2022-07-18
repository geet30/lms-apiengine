<?php

namespace App\Http\Controllers\Plans;

use App\Models\Plans\{EnergyPlanRate,LpgPlanRate};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plan\EnergyPlanRateRequest;
use App\Models\Distributor;
use App\Models\PlanEnergy;
use App\Repositories\Common\CommonRepository;
use App\Models\Plans\EnergyPlanRateLimit;
use App\Models\Plans\PlanDmo;
use App\Models\Providers;
use Illuminate\Support\Facades\Session;
class EnergyPlanRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($planId)
    {
      
        try {
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            if(!checkPermission('show_energy_plans',$userPermissions,$appPermissions) || !checkPermission('show_providers',$userPermissions,$appPermissions)  || !checkPermission('energy_plan_rate_detail',$userPermissions,$appPermissions))
            {
                Session::flash('error', trans('auth.permission_error'));
                return redirect('/provider/list');
            }
            $providerId = 0;
            $planRates = EnergyPlanRate::getPlanRates($planId);
            
            $plan = PlanEnergy::where('id',decryptGdprData($planId))->select('id','name','energy_type','provider_id','plan_type')->first();
            $energyType = 'electricity';
            if(isset($plan->energy_type)&& $plan->energy_type ==2){
                $energyType = 'gas';
            }
            if(isset($plan->energy_type)&& $plan->energy_type ==3){
                $energyType = 'lpg';
                $planRates = LpgPlanRate::getLpgPlanRates($planId);
            }

            if(isset($planRates[0]->provider_id)){
                $providerId =$planRates[0]->provider_id;
            }

            $url = URL('provider/plans/energy/'.$energyType.'/list'.'/'.encryptGdprData($plan['provider_id']));
            $selectedProvider = Providers::with([
                'providersLogo' => function($query){
                    $query->select('user_id','name','category_id');
                },
            ])->where('user_id',$plan['provider_id'])->first();
            session(['planListUrl' => $url]);
       
            return view('pages.plans.energy.planRate.plan-rate', compact('planRates','planId','url','energyType','selectedProvider','plan'));
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($rateId,$energy_type=null)
    {
        try {
         
            $timeOfUseArray = ['timeofuse_only', 'timeofuse_c1', 'timeofuse_c2', 'timeofuse_c1_c2'];
            $allLimitTypes =  config('planData.limitType');
            $energyType = 1; //elec
            $energyTypeVal = 'electricity'; //elec
            $editRate = EnergyPlanRate::getEditRates($rateId);
         
            if (isset($editRate->energyPlan->energy_type) && $editRate->energyPlan->energy_type == 'gas') {
                $allLimitTypes =  config('planData.limitTypeGas');
                $energyType = 2;
                $energyTypeVal = 'gas';
            }
             if(isset($energy_type) && $energy_type == 'lpg'){
                $allLimitTypes =  config('planData.limitTypeGas');
                $energyType = 3;
                $energyTypeVal = 'lpg';
                $editRate = LpgPlanRate::getLpgEditRates($rateId);
            }
            
            $distributorList = CommonRepository::getDistributorList($energyType);
            $dmoVdo['dmo_content_status'] = $editRate->dmo_content_status;
            $dmoVdo['dmo_vdo_content'] = $editRate->dmo_vdo_content;
            $teleDmoVdo['dmo_content_status'] = $editRate->telesale_dmo_content_status;
            $teleDmoVdo['dmo_vdo_content'] = $editRate->telesale_dmo_content;

            

            $planUrl = URL('provider/plans/energy/'.$energyTypeVal.'/list'.'/'.encryptGdprData($editRate->provider_id));
            $selectedProvider = Providers::where('user_id',$editRate->provider_id)->first();
            $selectedPlan = PlanEnergy::where('id',$editRate->plan_id)->get()->toArray();
            $selectedPlanRate = Distributor::where('id',$editRate->distributor_id)->get()->toArray();
            $url = URL('provider/plans/energy/plan-rates/'.encryptGdprData($editRate->plan_id));
            session(['planRateUrl' => $url]);
            // PlanDmo::getdmoContent($rateId);
          
            return view('pages.plans.energy.planRate.editRate.index', compact('editRate', 'teleDmoVdo', 'dmoVdo', 'allLimitTypes', 'timeOfUseArray', 'distributorList','url','planUrl','selectedProvider','selectedPlan','energyTypeVal','selectedPlanRate'));
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function postCopyDmoContent(Request $request)
    {
        try {
            EnergyPlanRate::copyDmoContent($request);
            return response()->json(['status' => 1, 'message' => trans('plans/energyRates.copyContent')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }


    public function createPlanRateLimit(EnergyPlanRateRequest $request)
    {
        try {
            EnergyPlanRate::addEditRateLimit($request);
            return response()->json(['status' => 1, 'message' => trans('plans/energyRates.createLimit')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getRateLimts(Request $request)
    {
        try {
            $rateLimits = EnergyPlanRate::getLimitList($request);
            return view('pages.plans.energy.planRate.editRate.rate_limit_list', compact('rateLimits'));
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }


    public function postPlanLimit(Request $request)
    {
        try {
            $rateId = decryptGdprData($request->rate_id);

            $limitType = $request->limit_type;
            if ($limitType == "peak") {
                $level_total = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 32768);
            } else if ($limitType == "c1_offpeak" || $limitType == "c1_shoulder" || $limitType == "c2_offpeak" || $limitType == "c2_shoulder") {
                $level_total = array(1, 2, 32768);
            } else {
                $level_total = array(1, 2, 3, 4, 5, 32768);
            }
            $planRateLimits = EnergyPlanRateLimit::where('plan_rate_id', $rateId)->where('limit_type', $limitType)->get(['limit_level']);

            if ($planRateLimits) {
                $Limit_type = array();
                foreach ($planRateLimits as $limit) {
                    array_push($Limit_type, $limit->limit_level);
                }
                $dropDown = array_diff($level_total, $Limit_type);

                return response()->json(['Limit_type_dropdown' => $dropDown], 200);
            } else {
                return response()->json(['message' => trans('plans/energyRates.noData')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EnergyPlanRateRequest $request)
    {

        if($request->action_type == 'planinfo-rate-view'){
            $update = EnergyPlanRate::UpdateRateInfo($request);

            if ($update) {
                return response()->json(['status' => true, 'message' => trans('plans/energyRates.rate_update')],200);
            } else {
                return response()->json(['status' => true, 'message' => trans('plans/energyRates.rate_update_error')], 400);
            }

        }else{
            $update = EnergyPlanRate::UpdateRateDetails($request);
            if ($update) {
                return response()->json(['status' => true, 'message' => trans('plans/energyRates.rate_update'),'id' => $update->id,'action'=> $request->action_type], 200);
            } else {
                return response()->json(['status' => true, 'message' => trans('plans/energyRates.rate_update_error')], 400);
            }
        }


    }
    
        /**
     * Update Lpg the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateLpgPlan(EnergyPlanRateRequest $request)
    {
       
        if($request->action_type == 'planlpginfo-rate-view'){
            $update = LpgPlanRate::UpdateLpgRateInfo($request);

            if ($update) {
                return response()->json(['status' => true, 'message' => trans('plans/energyRates.rate_update')],200);
            } else {
                return response()->json(['status' => true, 'message' => trans('plans/energyRates.rate_update_error')], 400);
            }

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

    /**
     * Get plan dmo
     *
     */
    public function getPlanDmo(Request $request){
        try {
            return PlanDmo::getdmoContent($request);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
