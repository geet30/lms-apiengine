<?php
namespace App\Repositories\PlansEnergy;
use App\Models\Plans\EnergyPlanRateLimit;
use App\Models\Plans\{PlanDmo,LpgPlanRate};
use Illuminate\Support\Facades\DB;

trait PlanRateCrud
{

   static function getPlanRates($planId){
       return self::select('id','type','status','distributor_id','is_deleted','provider_id')->where('plan_id',decryptGdprData($planId))->with('energyPlan')->where('is_deleted',0)->with('distributors')->get();
    }
    static function getLpgPlanRates($planId){
        return LpgPlanRate::select('id','status','distributor_id','is_deleted','provider_id')->where('plan_id',decryptGdprData($planId))->with('energyPlan')->where('is_deleted',0)->with('distributors')->get();

        return self::select('id','type','status','distributor_id','is_deleted','provider_id')->where('plan_id',decryptGdprData($planId))->with('energyPlan')->where('is_deleted',0)->with('distributors')->get();
     }

    static function getEditRates($rateId){
        return self::where('id',decryptGdprData($rateId))->where('is_deleted',0)->with('energyPlan')->first();
    }
    static function getLpgEditRates($rateId){
        return LpgPlanRate::where('id',decryptGdprData($rateId))->where('is_deleted',0)->with('energyPlan')->first();
    }
    static function UpdateRateDetails($rateRequest){
        switch ($rateRequest->action_type ) {

            case 'dmo_content':
                $planRateData['plan_rate_id'] = decryptGdprData($rateRequest->rate_id);
                $planRateData['dmo_vdo_content'] =$rateRequest->dmo_content;
                $planRateData['dmo_content_status'] =$rateRequest->dmo_content_status;
                $planRateData['consider_master_content'] =$rateRequest->consider_master_content;
                $planRateData['type'] =$rateRequest->type;
                $planRateData['variant'] =$rateRequest->variant;
                break;
            case 'telesale_content':
                $planRateData['dmo_vdo_content'] =$rateRequest->tele_dmo_content;
                $planRateData['dmo_content_status'] =$rateRequest->dmo_content_status;
                $planRateData['plan_rate_id'] = decryptGdprData($rateRequest->rate_id);
                $planRateData['type'] =$rateRequest->type;
                $planRateData['variant'] =$rateRequest->variant;
                break;
            case 'dmo_static_content':
                $planRateData['dmo_content_status'] =$rateRequest->dmo_static_content_status;
                $planRateData['type'] =$rateRequest->type;
                $planRateData['variant'] =$rateRequest->variant;
                $planRateData['plan_rate_id'] = decryptGdprData($rateRequest->rate_id);
                $planRateData['lowest_annual_cost'] = $rateRequest->lowest_annual_cost;
                $planRateData['without_conditional'] = $rateRequest->without_conditional;
                $planRateData['without_conditional_value'] = $rateRequest->without_conditional_value;
                $planRateData['with_conditional'] = $rateRequest->with_conditional;
                $planRateData['with_conditional_value'] = $rateRequest->with_conditional_value;

                unset($planRateData['action_type']);
                unset($planRateData['rate_id']);
                break;
            case 'withoutcondtionaldiscount':
                $planRateData['dmo_vdo_content'] =$rateRequest->dmo_content;
                $planRateData['type'] =$rateRequest->type;
                $planRateData['variant'] =$rateRequest->variant;
                $planRateData['plan_rate_id'] = NULL;
                break;
            case 'withpayontimediscount':
                $planRateData['dmo_vdo_content'] =$rateRequest->withpayontimediscount;
                $planRateData['type'] =$rateRequest->type;
                $planRateData['variant'] =$rateRequest->variant;
                $planRateData['plan_rate_id'] = NULL;
            break;
            case 'withdirectdebitdiscount':
                $planRateData['dmo_vdo_content'] =$rateRequest->withdirectdebitdiscountcontent;
                $planRateData['type'] =$rateRequest->type;
                $planRateData['variant'] =$rateRequest->variant;
                $planRateData['plan_rate_id'] = NULL;
            break;
            case 'withbothpayontimeanddirectdebitdiscount':
                $planRateData['dmo_vdo_content'] =$rateRequest->withbothpayontimeanddirectdebitdiscount;
                $planRateData['type'] =$rateRequest->type;
                $planRateData['variant'] =$rateRequest->variant;
                $planRateData['plan_rate_id'] = NULL;
            break;
            default:
                # code...
                break;
        }

        $id = decryptGdprData($rateRequest->id);

        return PlanDmo::updateOrCreate(['id' => $id], $planRateData);
    }

    static function  UpdateRateInfo($rateRequest){
        $planRateData =$rateRequest->all();
        unset($planRateData['action_type']);
        unset($planRateData['rate_id']);
       $id = decryptGdprData($rateRequest->rate_id);

        return self::where('id',$id)->update($planRateData);


    }
    static function  UpdateLpgRateInfo($rateRequest){
        $planRateData =$rateRequest->all();
        unset($planRateData['action_type']);
        unset($planRateData['rate_id']);
        $id = decryptGdprData($rateRequest->rate_id);

        return LpgPlanRate::where('id',$id)->update($planRateData);
    }

    static function copyDmoContent($requestData){
        if($requestData->has('dmo_content') && $requestData->dmo_content != ''){
            return self::where('distributor_id',$requestData->distributor_id)->where('plan_id',$requestData->plan_id)->update(['dmo_vdo_content'=>$requestData->dmo_content]);
        }
            return self::where('distributor_id',$requestData->distributor_id)->where('plan_id',$requestData->plan_id)->update(['dmo_vdo_content'=>$requestData->tele_dmo_content]);

    }
    static function addEditRateLimit($requestData){
        $rateLimit =$requestData->all();
        $rateLimit['plan_rate_id'] = decryptGdprData($requestData->rate_id);

        if($requestData->has('id')&& $requestData->id != ''){
            unset($rateLimit['rate_id']);
            unset($rateLimit['id']);
            unset($rateLimit['action_type']);
        return EnergyPlanRateLimit::where('id',decryptGdprData($requestData->id))->update($rateLimit);
        }
        return EnergyPlanRateLimit::create($rateLimit);
    }

    static function getLimitList($requestData){
        return EnergyPlanRateLimit::where('plan_rate_id',decryptGdprData($requestData->rate_id))->get();
    }

    public static function getdmoContent($request){
        if($request->action == 'master'){
            return PlanDmo::where('type',2)->get();
        }

        $variant = [1,2,3];
        $query =  PlanDmo::where('plan_rate_id',decryptGdprData($request->plan_rate_id))->where('type',$request->type)->whereIn('variant',$variant)->get();
        return response()->json(['status' => 200, 'result' => $query]);
    }

    public static function saveIdMatrix($request){
        try {
            if(DB::table('settings')->where('type','settings_id_matrix')->count() == 0){
                DB::table('settings')->insert([
                    [
                        'key' => 'key_enable',
                        'value' => $request->status,
                        'user_id' => null,
                        'name' => 'Status',
                        'status' => 1,
                        'type' => 'settings_id_matrix',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'key' => 'drivers_license',
                        'value' => $request->has('Drivers Licence') ? 1 : 0,
                        'user_id' => null,
                        'name' => 'Drivers Licence',
                        'status' => 1,
                        'type' => 'settings_id_matrix',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'key' => 'passport',
                        'value' => $request->has('australian_passport') ? 1 : 0,
                        'user_id' => null,
                        'name' => 'Passport',
                        'status' => 1,
                        'type' => 'settings_id_matrix',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'key' => 'medicare_card',
                        'value' => $request->has('medicare_card') ? 1 : 0,
                        'user_id' => null,
                        'name' => 'Medicare Card',
                        'status' => 1,
                        'type' => 'settings_id_matrix',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'key' => 'foreign_passport',
                        'value' => $request->has('foreign_passport') ? 1 : 0,
                        'user_id' => null,
                        'name' => 'Foreign Passport',
                        'status' => 1,
                        'type' => 'settings_id_matrix',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'key' => 'matrix_content',
                        'value' => $request->matrix_content,
                        'user_id' => null,
                        'name' => 'Content',
                        'status' => 1,
                        'type' => 'settings_id_matrix',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]);
            } else {
                DB::table('settings')->where(['type' => 'settings_id_matrix', 'key'=> 'key_enable'])->update(['value' => $request->status]);

                DB::table('settings')->where(['type' => 'settings_id_matrix', 'key'=> 'drivers_license'])->update(['value' => $request->has('drivers_license') ? 1 : 0]);

                DB::table('settings')->where(['type' => 'settings_id_matrix', 'key'=> 'passport'])->update(['value' => $request->has('australian_passport') ? 1 : 0]);

                DB::table('settings')->where(['type' => 'settings_id_matrix', 'key'=> 'medicare_card'])->update(['value' => $request->has('medicare_card') ? 1 : 0]);

                DB::table('settings')->where(['type' => 'settings_id_matrix', 'key'=> 'foreign_passport'])->update(['value' => $request->has('foreign_passport') ? 1 : 0]);

                DB::table('settings')->where(['type' => 'settings_id_matrix', 'key' => 'matrix_content'])->update(['value' => $request->matrix_content]);
            }
            return DB::table('settings')->where('type','settings_id_matrix')->get();
        } catch (\Exception $e){
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public static function getIdMatrix(){
        try {
            $matrix_settings =  DB::table('settings')->where('type','settings_id_matrix')->get();
            if(count($matrix_settings)) {
                return response()->json(['status' => 200, 'matrix_settings' => $matrix_settings]);
            }
            return response()->json(['status' => 204, 'message' => 'No data'],204);
        } catch (\Exception $e){
            return response()->json(['status' => 500, 'message' => $e->getMessage()],500);
        }
    }
}
