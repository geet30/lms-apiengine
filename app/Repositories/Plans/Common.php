<?php

namespace App\Repositories\Plans;

use App\Models\{PlansTelcoFee};
use DB;

trait Common
{
    /**
     * update the plan EIC content.
     * 
     * @return Array
     */
    public static function savePlanFeeRepo($request)
    {
        try {
            $planId = decryptGdprData($request->plan_id);
            $planFees = [ 
                        'plan_id' => $planId,
                        'service_id'=>  $request->service_id,
                        'cost_type_id'=>$request->cost_type,
                        'fee_id'=> $request->fee_id,
                        'fees' => $request->amount,
                        'additional_info' => $request->additional_info 
                    ];
            $feesId = $request->id;
            if($request->has('action') && ($request->action == 'add' || $request->action == 'edit')){ 
                PlansTelcoFee::updateOrCreate(['id' => $feesId],$planFees);

                $planFeesList = PlansTelcoFee::with(['feeType','costType'])->where('plan_id','=',$planId)->where('service_id',$request->service_id)->get(); 
                $response['data'] = array('status'=>true,'message'=> trans('plans/broadband.plan_fees_add_toastr') ,'planFeesList' => $planFeesList); 
                $response['status'] = 200;
                return $response;
            } 
            $response['data'] = array('success'=>'true','message' => trans('plans/broadband.server_error_toastr') ,'planFeesList' => []);
            $response['status'] = 400;
            return $response;
        } catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }
    }

     /**
     * delete the plan EIC content checkbox.
     * 
     * @return Array
     */
    public static function deletePlanFeeRepo($request)
    {   
        try
        {
            $feesId = $request->id;
            $planId = decryptGdprData($request->plan_id); 
            $fees = PlansTelcoFee::where('id',$feesId)->delete();    
            $feesList = PlansTelcoFee::with(['feeType','costType'])->where('plan_id','=',$planId)->where('service_id',$request->service_id)->get();
            if($fees)
            { 
                $response['data'] = array('success'=>true,'message' => trans('plans/broadband.plan_fees_delete_toastr') ,'planFeesList' => $feesList); 
                $response['status'] = 200;
                return $response;
            }
            $response['data'] = array('success'=>true,'message'=> trans('plans/broadband.plan_fees_not_delete_toastr') ,'planFeesList' => $feesList); 
            $response['status'] = 400;
            return $response;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }
}
