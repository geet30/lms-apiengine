<?php

namespace App\Http\Controllers\Plans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plans\EnergyTariffInfo;
use App\Http\Requests\Plan\DemandRequest;
use App\Http\Requests\Plan\DemandRateRequest;
use App\Models\Distributor;
use App\Models\PlanEnergy;
use App\Models\Plans\EnergyPlanRate;
use App\Models\Providers;

class EnergyDemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rateId,$distributorId,$propertyType)
    {
        $demandList =  EnergyTariffInfo::getRateList($rateId,$distributorId);
        $url['planListUrl'] = \Session::get('planListUrl');
        $url['current'] = \Session::get('planRateUrl');
        $demand = \URL::current();
        session(['demandUrl' => $demand]);
        $energyPlan = EnergyPlanRate::where('id',decryptGdprData($rateId))->first();
        $selectedProvider = Providers::with([
            'providersLogo' => function($query){
                $query->select('user_id','name','category_id');
            },
        ])->where('user_id',$energyPlan->provider_id)->first();
        $selectedPlan = PlanEnergy::where('id',$energyPlan->plan_id)->get()->toArray();
        $selectedPlanRate = Distributor::where('id',$energyPlan->distributor_id)->get()->toArray();
        return view('pages.plans.energy.planRate.demand.index', compact('demandList','rateId','distributorId','url','selectedProvider','selectedPlan','selectedPlanRate','propertyType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DemandRequest $request)
    {
        try{
            EnergyTariffInfo::createOrUpdateTariff($request);

            return response()->json(['status'=>true,'message'=>trans('plans.createDemandTariff')],200);
        }catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],400);
       }

    }

    public function getDemandRate($rateId, $planRateId, $propertyType)
    {
        $url['planListUrl'] = \Session::get('planListUrl');
        $url['planRateUrl'] = \Session::get('planRateUrl');
        $url['current'] =\Session::get('demandUrl');
        $demandRateTypes = config('planData.demandRateType');
        $demandRates = EnergyTariffInfo::getTariffRate($rateId);
        $energyPlan = EnergyPlanRate::where('id',decryptGdprData($planRateId))->first();
        $selectedProvider = Providers::with([
            'providersLogo' => function($query){
                $query->select('user_id','name','category_id');
            },
        ])->where('user_id',$energyPlan->provider_id)->first();
        $selectedPlan = PlanEnergy::where('id',$energyPlan->plan_id)->get()->toArray();
        $selectedPlanRate = Distributor::where('id',$energyPlan->distributor_id)->get()->toArray();
        return view('pages.plans.energy.planRate.demand.rates.index', compact('demandRates','rateId','demandRateTypes','url','selectedProvider','selectedPlan','selectedPlanRate','planRateId','propertyType'));
    }

    public function createDemandRate(DemandRateRequest $request)
    {
        try{
            EnergyTariffInfo::createOrUpdateTariffRate($request);
            return response()->json(['status'=>true,'message'=>trans('plans/energyRates.createDemandTariffRate')],200);
        }catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],400);
       }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMasterTariff(Request $request)
    {
        return EnergyTariffInfo::getTariffCodes($request);
    }

    public function getDemandTariffLimit(Request $request)
    {
        return EnergyTariffInfo::getTariffLimits($request);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
