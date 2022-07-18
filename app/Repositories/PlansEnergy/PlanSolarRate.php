<?php
namespace App\Repositories\PlansEnergy;


use App\Models\PlanEnergy;

trait PlanSolarRate
{
    static function getSolarRateList($planId)
    {

        return self::where('plan_id', $planId)
            ->where('type',1)
            ->OrderByDesc('id')
            ->get();
    }

    static function getSolarRateListPremium($planId)
    {

        return self::where('plan_id', $planId)
            ->where('type',0)
            ->OrderByDesc('id')
            ->get();
    }

    static function saveSolarRate($requestData)
    {
        $solarRate['solar_price'] = $requestData->solar_rate;
        $solarRate['solar_description'] = $requestData->solar_desc;
        $solarRate['is_show_frontend'] = ($requestData->has('show_on_frontend') && ($requestData->show_on_frontend == 1)) ? 1 : 0;
        $solarRate['charge'] = $requestData->charge;
        $solarRate['plan_id'] = $requestData->plan_id;
        $solarRate['type'] = $requestData->type;
        $solarRate['status'] = 0;
        $solarRate['solar_rate_price_description'] = $requestData->solar_rate_price_description;
        $solarRate['solar_supply_charge_description'] = $requestData->solar_supply_charge_description;

        if ($requestData->has('id') && $requestData->id == '') {
            return self::create($solarRate);
        }
        return self::where('id', decryptGdprData($requestData->id))->update($solarRate);
    }

    static function updateStatus($requestData)
    {
        try {
            if ($requestData->has('change_show_frontend')) {
                return self::where('id', decryptGdprData($requestData->id))->update(['is_show_frontend' => $requestData->change_show_frontend]);
            }
            self::where('plan_id', $requestData->plan_id)->where('status', 1)->update(['status' => 0]);

            return self::where('id', decryptGdprData($requestData->id))->update(['status' => $requestData->status]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function deleteSolar($id){
        try {
            return self::find(decryptGdprData($id))->delete();
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public static function getSolarPlanStatus($planId){
        try {
            return PlanEnergy::whereId($planId)->pluck('show_solar_plan')->toArray();
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public static function setSolarPlanStatus($planId){
        try {
            $status = PlanEnergy::where('id', $planId)->pluck('show_solar_plan');
            PlanEnergy::where('id', $planId)->update(['show_solar_plan' => !$status[0]]);
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }
}

?>
