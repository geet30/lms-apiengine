<?php

namespace App\Http\Controllers\Plans;

use App\Http\Controllers\Controller;
use App\Models\PlanEnergy;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\SolarRate;
use App\Http\Requests\Plan\SolarRateRequest;
use App\Models\Providers;
use Illuminate\Support\Facades\Session;

class EnergySolarPlanRate extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($providerId, $planId)
    {
        try {
            $userPermissions = getUserPermissions(); 
            $appPermissions = getAppPermissions();
            if(!checkPermission('show_energy_plans',$userPermissions,$appPermissions) || !checkPermission('show_providers',$userPermissions,$appPermissions)  || !checkPermission('energy_solar_rate',$userPermissions,$appPermissions))
            {
                Session::flash('error', trans('auth.permission_error'));
                return redirect('/provider/list');
            }
            $planId = decryptGdprData($planId);
            $solarRate = SolarRate::getSolarRateList($planId);
            $url = URL('provider/plans/energy/electricity/list'.'/'.encryptGdprData(5));
            $planData = [];
            $type = 'normal';
            $show_solar_plan = SolarRate::getSolarPlanStatus($planId);
            $selectedPlan = PlanEnergy::where('id',$planId)->get()->toArray();
            $selectedProvider = Providers::with([
                'providersLogo' => function($query){
                    $query->select('user_id','name','category_id');
                },
            ])->where('user_id',decryptGdprData($providerId))->first();
            return view('pages.plans.energy.planRate.index', compact('solarRate', 'planData', 'planId', 'url', 'type', 'show_solar_plan','selectedProvider','selectedPlan'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function indexPremium($providerId, $planId)
    {
        // dd(decryptGdprData($planId));
        try {
            $planId = decryptGdprData($planId);
            $solarRate = SolarRate::getSolarRateListPremium($planId);
            $url = URL('provider/plans/energy/electricity/list'.'/'.encryptGdprData(5));
            $planData = [];
            $type = 'premium';
            $show_solar_plan = SolarRate::getSolarPlanStatus($planId);
            $selectedPlan = PlanEnergy::where('id',$planId)->get()->toArray();
            $selectedProvider = Providers::with([
                'providersLogo' => function($query){
                    $query->select('user_id','name','category_id');
                },
            ])->where('user_id',decryptGdprData($providerId))->first();
            return view('pages.plans.energy.planRate.index', compact('solarRate', 'planData', 'planId', 'url', 'type', 'show_solar_plan','selectedProvider','selectedPlan'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUpdateSolar(SolarRateRequest $request)
    {
        try {
            $result = SolarRate::saveSolarRate($request);

            if ($result) {
                return response()->json(['status' => true, 'message' => trans('plan.solarUpdate'), 'reload_page' => true], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'something went wrong'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);


        }

    }

    public function postChangeStatus(Request $request)
    {
        try {
            $result = SolarRate::updateStatus($request);

            if ($result) {
                return response()->json(['status' => true, 'message' => 'Solar Rate active successfuly', 'reload_page' => true], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'something went wrong'], 400);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);

        }

    }

    public function setSolarPlanStatus($id)
    {
        try {
            SolarRate::setSolarPlanStatus($id);
            return response()->json(['status' => true, 'message' => 'Solar plan status changed successfuly', 'reload_page' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSolar($id)
    {
        try {
            SolarRate::deleteSolar($id);
            return response()->json(['status' => true, 'message' => 'solar Rate deleted successfuly', 'reload_page' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
