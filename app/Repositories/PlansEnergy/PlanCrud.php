<?php
namespace App\Repositories\PlansEnergy;
use App\Models\PlanRemarketingInformation;
use App\Models\PlanEicContent;
use App\Models\CheckBoxContent;
use App\Models\PlanTag;
use App\Models\Tag;

trait PlanCrud
{
    public static function getPlans($energy,$providerId,$request){

        $energyType = 1;
        if($energy == 'gas')
        {
            $energyType= 2;
        }
        if($energy == 'lpg')
        {
            $energyType= 3;
        }
        $status = 1;
        if($request->has('filter_status')){
            $status = $request->filter_status;
        }
        if($request->has('filter_status') && ($request->filter_status == 'all')){
            return self::select('id','name','plan_type','energy_type','upload_on','active_on','status','show_on_agents')->where('provider_id',$providerId)->where('energy_type',$energyType)->get();
        }
        return self::select('id','name','plan_type','energy_type','upload_on','active_on','status','show_on_agents')->where('provider_id',$providerId)->where('energy_type',$energyType)->where('status',$status)->get();

    }

    public static function getEditPlan($planId){
        return self::where('id',$planId)->first();
    }
    public static function updatePlan($requestData){
        try {
            $updatePlan =[];
            $success = false;
            switch ($requestData->action_form) {
                case 'plan_view_form':
                    $updatePlan['view_discount'] = $requestData->view_discount;
                    $updatePlan['view_bonus'] = $requestData->view_bonus;
                    $updatePlan['view_exit_fee'] = $requestData->view_exit_fee;
                    $updatePlan['view_benefit'] = $requestData->view_benefit;
                    $updatePlan['view_discount'] = $requestData->view_discount;
                    $updatePlan['view_contract'] = $requestData->view_contract;
                    break;
                case 'plan_info':
                    $updatePlan= $requestData->all();
                    unset( $updatePlan['action_form']);
                    unset( $updatePlan['plan_id']);
                    break;
                case 'plan_info_gas':
                    $updatePlan= $requestData->all();
                    unset( $updatePlan['action_form']);
                    unset( $updatePlan['plan_id']);
                    break;
                case 'plan_info_lpg':
                    $updatePlan= $requestData->all();
                    unset( $updatePlan['action_form']);
                    unset( $updatePlan['plan_id']);
                    break;
                case 'apply_now_content_form':
                    $updatePlan['apply_now_status'] = $requestData->apply_now_status;
                    $updatePlan['apply_now_content'] = $requestData->apply_now_content;
                    break;
                case 'remarketing_form':
                    return self::updateplanRemarketing($requestData);
                    break;
                case 'plan_tag_from':
                    return self::updateplanTag($requestData);
                    break;
                case 'eic_content_form':
                    return self::planEicContent($requestData);
                    break;
                case 'eic_content_checkbox_form':
                    return self::planEicContent($requestData);
                    break;
            }

            if(count($updatePlan)){

                $success=self::where('id',$requestData->plan_id)->update($updatePlan);
              }

              if($success){
                $message =trans('plans.planUpdate');
                return response()->json(['status' => 200, 'message' => $message ]);
              }


        }catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['status' => 400, 'message' => $e->getMessage() ]);
            return $e->getMessage();
    }

    }



    public static function updateplanRemarketing($requestData){
        try {

        if($requestData->remarketing_allow == 1){

            $remarketingData['plan_id']= $requestData->plan_id;

            $remarketingData['remarketing_allow']= $requestData->remarketing_allow;
            $remarketingData['discount']= $requestData->discount;
            $remarketingData['discount_title']= $requestData->discount_title;
            $remarketingData['contract_term']= $requestData->month_benfit_period;
            $remarketingData['termination_fee']= $requestData->termination_fee;
            $remarketingData['remarketing_terms_conditions']= $requestData->remarketing_terms_conditions;

            $remarketingDatas['remarketing_terms_conditions']= $requestData->remarketing_terms_conditions;
        }else{
            $remarketingData['remarketing_allow']= 0;
            $remarketingData['discount']= '';
            $remarketingData['discount_title']= '';
            $remarketingData['month_benfit_period']= '';
            $remarketingData['contract_term']= '';
            $remarketingData['plan_id']= $requestData->plan_id;
            $remarketingData['remarketing_terms_conditions']= '';
        }

      $success=PlanRemarketingInformation::updateOrCreate(['plan_id'=>$requestData->plan_id],$remarketingData);
      if($success){
        $message =trans('plans.updateRemareting');
        return response()->json(['status' => 200, 'message' => $message ]);
    }

    }catch (\Exception $e) {
        return $e->getMessage();
    }
    }

    public static function planEicContent($requestData){
        try{
            if($requestData->action_form == 'eic_content_checkbox_form'){
                $eicCheckbox['type'] =  '1';

                $eicCheckbox['required'] =  $requestData->checkbox_required;
                $eicCheckbox['validation_message']=  $requestData->validation_message;
                $eicCheckbox['save_checkbox_status']=  $requestData->save_checkbox_status;
                $eicCheckbox['module_type']=  $requestData->eic_type;
                $eicCheckbox['content']=  $requestData->checbox_content;
                if($requestData->has('id') && $requestData->id != ''){
                    $success=CheckBoxContent::where('id',$requestData->id)->update($eicCheckbox);

                    if($success){
                        $message =trans('plans.updateCheckboxContent');
                        return response()->json(['status' => 200, 'message' => $message ]);
                    }
                }else{
                    $eicCheckbox['type_id'] = $requestData->type_id;
                    $success =  CheckBoxContent::create($eicCheckbox);
                    if($success){
                        $message =trans('plans.createCheckboxContent');
                        return response()->json(['status' => 200, 'message' => $message ]);
                    }
                }

            }else{
                $eic['status'] =  $requestData->eic_status;
                $eic['content']=  $requestData->eic_editor;
                $eic['plan_id']=  $requestData->plan_id;
                $success =  PlanEicContent::updateOrCreate(['plan_id'=>$requestData->plan_id],$eic);
                if($success){
                    $message =trans('plans.updateEic');
                    return response()->json(['status' => 200, 'message' => $message ]);
                }
            }


            return  $success;
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function updateplanTag($requestData){
        try{
            $saveTags =[];
            $selectedTags = $requestData->plan_tags;
            PlanTag::where('plan_id',$requestData->plan_id)->delete();
            foreach($selectedTags as $tag){
                $saveTag['tag_id'] = $tag;
                $saveTag['plan_id'] = $requestData->plan_id;
                array_push($saveTags,$saveTag);
            }
            $success = PlanTag::insert($saveTags);
            if($success){
                $message =trans('plans.planTagUpdate');
                return response()->json(['status' => 200, 'message' => $message ]);
            }
            return $success;
        }catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    public static function changeStatus($requestData){

        if($requestData->status == 1){
            $updateStatus['status'] = $requestData->status;
            $updateStatus['active_on'] =\Carbon\Carbon::now()->toDateTimeString();
        }else{
            $updateStatus['status'] = $requestData->status;
        }
        $update  = self::where('id',$requestData->plan_id)->update($updateStatus);
        if($update){
           return true;

        return false;

    }

}

    public static function updateAgentPortal($request){
        try {
            $status = self::where('id',$request->plan_id)->update(['show_on_agents' => $request->status]);
            if($status){
                return response()->json(['status' => 200, 'message' => trans('plans.agentsuccess')]);
            }
            return response()->json(['status' => 400, 'message' => trans('plans.agentnot')]);
        }catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

}

?>
