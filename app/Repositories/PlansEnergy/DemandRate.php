<?php
namespace App\Repositories\PlansEnergy;
use App\Models\Plans\EnergyTariffInfo;
use App\Models\Plans\EnergyTariffRate;
use App\Models\Plans\EnergyMasterTariff;
trait DemandRate
{
     static function getRateList($rateId,$request=null){

        $tariffInfos = EnergyTariffInfo::where('plan_rate_ref_id', decryptGdprData($rateId))->with('tariffName');

        if (!empty($request->filterTariffCode)) {
            if (strpos($request->filterTariffCode, ',') !== false) {
                $refIds = explode(',', $request->filterTariffCode);

                $refIds =  array_map('trim', $refIds);
                $tariffInfos =  $tariffInfos->whereIn('tariff_code_ref_id', $refIds);
            } else {
                $tariffInfos->where('tariff_code_ref_id', 'like', '%' . $request->filterTariffCode . '%');
            }
        }
        return $tariffInfos = $tariffInfos->orderBy('id', 'desc')->get();


    }

    static function getTariffCodes($request)
    {
        try {

            $propertyTypes = ['business' => 1, 'residential' => 2];
            $tariffInfos = EnergyTariffInfo::select('tariff_code_ref_id', 'tariff_code_aliases')->where('plan_rate_ref_id', $request->plan_rate_ref_id);

            if (!empty($request->id)) {
                $tariffInfos = $tariffInfos->where('id', '!=', decryptGdprData($request->id));
            }
            $tariffInfos = $tariffInfos->get();
            $tariffInfos = count($tariffInfos) ? $tariffInfos->toArray() : [];

            $usedMasterTariffCodeIds = [];
            foreach ($tariffInfos as $tariffInfo) {

                if (!in_array($tariffInfo['tariff_code_ref_id'], $usedMasterTariffCodeIds)) {
                    $usedMasterTariffCodeIds[] = $tariffInfo['tariff_code_ref_id'];
                    $arrTariffCodeRelIds = explode(',', $tariffInfo['tariff_code_aliases']);
                    foreach ($arrTariffCodeRelIds as $arrTariffCodeRelId) {
                        if (!in_array((int)$arrTariffCodeRelId, $usedMasterTariffCodeIds) && $arrTariffCodeRelId != '')
                            $usedMasterTariffCodeIds[] = (int)$arrTariffCodeRelId;
                    }
                }
            }
            $masterTariffs = EnergyMasterTariff::select('id', 'tariff_code')->whereNotIn('id', $usedMasterTariffCodeIds)->where('distributor_id', $request->distriibutor_id)->where('property_type',$request->property_type)->where('status', 1)->get()->pluck('tariff_code', 'id')->toArray();

            return response(['masterTariffCodes' => $masterTariffs, 'status' => 1], 200);
        } catch (\Exception $err) {
            return response(['status' => 0, 'message' => 'Whoops! something went wrong', 'exception_message' => $err->getMessage()], 400);
        }
    }

     static function getTariffLimits( $request)
    {
        $totalUsageType = config('planData.demandUsageType');
        $limitLevel= config('planData.demandUsageLevel');
        if ($request->inputField == 'season_rate_type') {

            $peakArray = array();
            $offPeakArray = array();
            $shoulderArray = array();
            $demnadUsageTypes = EnergyTariffRate::where('tariff_info_ref_id',decryptGdprData($request->tariff_info_ref_id))->where('season_rate_type', $request->season_rate_type)->get(['usage_type', 'limit_level']);

            if ($demnadUsageTypes) {
                foreach ($demnadUsageTypes as $demnadUsageType) {
                    if ($demnadUsageType->usage_type == 'peak') {
                        array_push($peakArray, $demnadUsageType->limit_level);
                    } else if ($demnadUsageType->usage_type == 'off_peak') {
                        array_push($offPeakArray, $demnadUsageType->limit_level);
                    } else if ($demnadUsageType->usage_type == 'shoulder') {
                        array_push($shoulderArray, $demnadUsageType->limit_level);
                    }
                }
                $limitType = array();

                if (empty(array_diff($limitLevel, $peakArray))) {
                    array_push($limitType, 'peak');
                }

                if (empty(array_diff($limitLevel, $offPeakArray))) {
                    array_push($limitType, 'off_peak');
                }
                if (empty(array_diff($limitLevel, $shoulderArray))) {
                    array_push($limitType, 'shoulder');
                }

                $usage_type_dropdown = array_diff($totalUsageType, $limitType);
                return response()->json(['usage_type_dropdown' => $usage_type_dropdown]);
            }
            return response()->json(['usage_type_dropdown' => $totalUsageType]);
        } else {
            $plan_rate_limits = EnergyTariffRate::where('tariff_info_ref_id', decryptGdprData($request->tariff_info_ref_id))->where('season_rate_type', $request->season_rate_type)->where('usage_type', $request->usage_type)->get(['limit_level']);

            if ($plan_rate_limits) {
                $LimitType = array();
                foreach ($plan_rate_limits as $plan_rate_limit) {

                    array_push($LimitType, $plan_rate_limit->limit_level);
                }

                $LimitTypeDropdown = array_diff($limitLevel, $LimitType);
                return response()->json(['Limit_type_dropdown' => $LimitTypeDropdown]);
            }
            return response()->json(['Limit_type_dropdown' => $limitLevel]);
        }
        return response()->json(['message' => 'Sorry we are not able to fulfill you requirement']);
    }


     static function createOrUpdateTariff($requestData){
        $demandData = $requestData->all();

        $demandData['plan_rate_ref_id'] = decryptGdprData($requestData->rate_id);
        unset($demandData['rate_id']);
        unset($demandData['id']);
        if(isset($demandData['tariff_code_aliases']))
            $demandData['tariff_code_aliases'] = implode(',', $demandData['tariff_code_aliases']);

        if($requestData->id != ''){
           return self::where('id',decryptGdprData($requestData->id))->update($demandData);
        }
         return self::create($demandData);
     }

     static  function getTariffRate($rateId){

        return EnergyTariffRate::where('tariff_info_ref_id', decryptGdprData($rateId))->get();
     }

     static function createOrUpdateTariffRate($requestData){
        $demandRate = $requestData->all();
        $demandRate['tariff_info_ref_id'] =decryptGdprData($requestData->tariff_info_ref_id);
        if($requestData->id != ''){
            unset($demandRate['id']);
           return EnergyTariffRate::where('id',decryptGdprData($requestData->id))->update($demandRate);
        }
         return EnergyTariffRate::create($demandRate);
     }

}
