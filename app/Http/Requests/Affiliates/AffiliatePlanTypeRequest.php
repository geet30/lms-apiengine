<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;


class AffiliatePlanTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules=[];
        $request = Request::all();
        if($request['request_from']=='submit_plan_type_form'){
            if(!isset($request['aff_plan_type'])){
                $rules = [
                    'aff_plan_type'=>'required'
                    
                ];  
            }
        }
        if($request['request_from']=='lead_signup_form'){

            if(isset($request['lead_popup_name_required']) && $request['lead_popup_name_required']=='on'){
                $rules['lead_popup_name']='nullable';
            }else{
                $rules['lead_popup_name'] = 'required';
            }
            if(isset($request['lead_popup_email_required']) && $request['lead_popup_email_required']=='on'){
                $rules['lead_popup_email']=['nullable','email',"regex:/(.+)@(.+)\.(.+)/i"];
            }else{
                $rules['lead_popup_email'] = ['required','email',"regex:/(.+)@(.+)\.(.+)/i"];
            }
            if(isset($request['lead_popup_phone_required']) && $request['lead_popup_phone_required']=='on'){
                $rules['lead_popup_phone']=['nullable','numeric','regex:/(61|04)\d{8,10}$/'];
            }else{
                $rules['lead_popup_phone'] = ['required','numeric','regex:/(61|04)\d{8,10}$/'];
            }
           
        }
        if($request['request_from'] == 'submit_connection_type_form'){
            if(!isset($request['aff_connection_type'])){
                $rules = [
                    'aff_connection_type'=>'required'
                    
                ];  
            }
        }
       
        return $rules;
    }

    public function messages()
    {
        return [
            'aff_plan_type.required' => trans('affiliates.plantype_required'),
            'aff_connection_type.required' => trans('affiliates.connectiontype_required'),
            'lead_popup_email.email' => trans('affiliates.lead_popup_email_valid'),
            'lead_popup_email.required' => trans('affiliates.lead_popup_email_required'),
            'lead_popup_name.required' => trans('affiliates.lead_popup_name_required'),
            'lead_popup_phone.required' => trans('affiliates.lead_popup_phone_required'),
            'lead_popup_phone.numeric' => trans('affiliates.lead_popup_phone_numeric_valid'),
            'lead_popup_phone.digits_between' => trans('affiliates.lead_popup_phone_digits_btwn'),
            'lead_popup_phone.regex' => trans('affiliates.lead_popup_phone_invalid_format'),
            'lead_popup_email.regex' => trans('affiliates.lead_popup_email_valid')
            
       ];
    }
}
