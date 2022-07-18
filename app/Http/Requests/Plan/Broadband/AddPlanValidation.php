<?php

namespace App\Http\Requests\Plan\Broadband;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Plan\Broadband\UniqueBroadbandPlan;

class AddPlanValidation extends FormRequest
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

        return [
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
        ];
    }
}
