<?php

namespace App\Http\Requests\Plan\Broadband;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Plan\Broadband\UniqueBroadbandPlan;

class EditPlanValidation extends FormRequest
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
        $request =  Request::all();
        $max10000 = 'max:10000';  
        $digits_between = 'between:0,9999999.99'; 
        $max150 = 'max:150';
        $rules = [];
        if($request['formType'] == 'basic_details_form')
        {
            $rules = [
                'name' => ['required',new UniqueBroadbandPlan($request)], 
                'inclusion' => 'bail|required|'.$max10000,
                'contract_id' => 'required',  
                'connection_type' => 'required', 
                'connection_type_info'=> 'bail|required|'.$max10000, 
                'plan_cost' => 'bail|required|numeric|gte:0',
                'plan_cost_info'=>'bail|required|'.$max10000,
                'nbn_key' => ['required'], 
                'nbn_key_file'=> 'required_if:nbn_key,2',
                'is_boyo_modem' => 'required',
                'internet_speed'=> 'bail|nullable|numeric|between:0,9999999.99',
            ];
        }
        else if($request['formType'] == 'plan_info_form')
        {
            $rules = [ 
                'download_speed'=> 'bail|nullable|numeric|'.$digits_between,
                'upload_speed'=> 'bail|nullable|numeric|'.$digits_between,
                'typical_peak_time_download_speed'=> 'required',
                'data_limit'=> 'required|numeric', 
                'speed_description'=>'nullable|'.$max10000,
                'additional_plan_information_text'=>'nullable|'.$max10000,
            ];
        }
        else if($request['formType'] == 'plan_data_form')
        {
            $rules = [
                'data_unit_id' => 'required',
                'total_data_allowance'=> 'bail|required|alpha_num|'.$max150,
                'off_peak_data'=> 'bail|nullable|alpha_num|'.$max150,
                'peak_data'=> 'bail|nullable|alpha_num|'.$max150,
            ];
        }
        else if($request['formType'] == 'critical_information_form')
        {
            $rules = [
                'critical_info_type' => 'required', 
                'critical_info_file'=> 'required_if:critical_info_type,2', 
            ]; 
        }
        else if($request['formType'] == 'remarketing_informatio_form')
        {
            $rules = [
                'remarketing_allow' => 'required',
            ]; 
        }
        else if($request['formType'] == 'special_offer_form')
        {
            $rules = [
                'special_offer_status' => 'required',
                'special_cost_id'=> 'required_if:special_offer_status,1',
                'special_offer'=> 'required_if:special_offer_status,1|'.$max10000,
                'special_offer_price'=> 'nullable|required_if:special_offer_status,1|numeric|'.$digits_between,
            ];
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('plans/broadband.name.validation.required'), 
            'inclusion.required' => trans('plans/broadband.plan_inclusion.validation.required'),
            'inclusion.max' => trans('plans/broadband.plan_inclusion.validation.max'),
            'contract_id.required' => trans('plans/broadband.plan_duration.validation.required'), 
            'connection_type.required' => trans('plans/broadband.connection_type.validation.required'), 
            'connection_type_info.required' => trans('plans/broadband.connection_type_info.validation.required'), 
            'connection_type_info.max' => trans('plans/broadband.connection_type_info.validation.max'), 
            'plan_cost.required' => trans('plans/broadband.plan_cost.validation.required'),
            'plan_cost.numeric' => trans('plans/broadband.plan_cost.validation.numeric'),
            'plan_cost.gte' => trans('plans/broadband.plan_cost.validation.gt'),
            'plan_cost_info.required' => trans('plans/broadband.plan_cost_info.validation.required'), 
            'plan_cost_info.max' => trans('plans/broadband.plan_cost_info.validation.max'), 
            'nbn_key.required' => trans('plans/broadband.nbn_key_facts.validation.required'),
            'nbn_key_url.required_if' => trans('plans/broadband.nbn_key_facts_url.validation.required'), 
            'nbn_key_url.url' => trans('plans/broadband.nbn_key_facts_url.validation.url'), 
            'nbn_key_file.required_if' => trans('plans/broadband.nbn_key_facts_file.validation.required'), 
            'is_boyo_modem.required' => trans('plans/broadband.is_boyo_modem.validation.required'), 
            
            'download_speed.numeric' => trans('plans/broadband.download_speed.validation.numeric'),
            'download_speed.between' => trans('plans/broadband.download_speed.validation.between'),

            'upload_speed.numeric' => trans('plans/broadband.upload_speed.validation.numeric'),
            'upload_speed.between' => trans('plans/broadband.upload_speed.validation.between'),

            'typical_peak_time_download_speed.required' => trans('plans/broadband.typical_peak_time_download_speed.validation.required'),

            'data_limit.required' => trans('plans/broadband.data_limit.validation.required'),
            'data_limit.numeric' => trans('plans/broadband.data_limit.validation.numeric'),

            'speed_description.max' => trans('plans/broadband.speed_description.validation.max'),
            'additional_plan_information_text.max' => trans('plans/broadband.additional_plan_information_text.validation.max'),

            'data_unit_id.required' => trans('plans/broadband.data_unit.validation.required'),
            'total_data_allowance.required' => trans('plans/broadband.total_data_allowance.validation.required'),

            'total_data_allowance.max' => trans('plans/broadband.total_data_allowance.validation.max'),
            'off_peak_data.max' => trans('plans/broadband.off_peak_data.validation.max'),
            'peak_data.max' => trans('plans/broadband.peak_data.validation.max'),
            
            'critical_info_type.required' => trans('plans/broadband.select_option.validation.required'),
            'critical_info_url.required_if'=> trans('plans/broadband.critical_info_url.validation.required'),
            'critical_info_url.url' => trans('plans/broadband.critical_info_url.validation.url'), 
            'critical_info_file.required_if'=> trans('plans/broadband.critical_info_file.validation.required'), 

            'remarketing_allow.required' => trans('plans/broadband.remarketing_allow.validation.required'),
            
            'special_offer_status.required' => trans('plans/broadband.special_offer_status.validation.required'),
            'special_cost_id.required_if' => trans('plans/broadband.special_offer_cost_type.validation.required'),

            'special_offer.required_if' => trans('plans/broadband.special_offer_script.validation.required'),
            'special_offer.max' => trans('plans/broadband.special_offer_script.validation.max'),

            'special_offer_price.required_if' => trans('plans/broadband.special_offer_price.validation.required'),
            'special_offer_price.numeric' => trans('plans/broadband.special_offer_price.validation.numeric'),
            'special_offer_price.between' => trans('plans/broadband.special_offer_price.validation.between'),
        ];
    }
}
