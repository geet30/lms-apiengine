<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class EnergyPlanRateRequest extends FormRequest
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
        switch ($this->request->get('action_type')) {
        case 'planlpginfo-rate-view':
            return [
                'exit_fee' => 'required|min:1',
                'late_payment_fee' => 'required|min:1',
            ];
        case 'planinfo-rate-view':
            return [
                'exit_fee' => 'required|min:1',
                // 'late_payment_fee' => 'required|min:1',
                // 'pay_day_discount_usage' => 'required|min:1',
                // 'pay_day_discount_usage_desc' => 'required|min:4|max:1000',
                // 'pay_day_discount_supply' => 'required|min:1',
                // 'pay_day_discount_supply_desc' => 'required|min:4|max:1000',
                // 'gurrented_discount_usage' => 'required|min:1',
                // 'gurrented_discount_usage_desc' => 'required|min:4|max:1000',
                // 'gurrented_discount_supply' => 'required|min:1',
                // 'gurrented_discount_supply_desc' => 'required|min:4|max:1000',
                // 'direct_debit_discount_usage' => 'required|min:1',
                // 'direct_debit_discount_supply' => 'required|min:1',
                // 'direct_debit_discount_desc' => 'required|min:4|max:1000',
                'gst_rate' => 'required|numeric|min:1',
                'daily_supply_charges' => 'required|numeric|min:1',
            ];
        case 'dmo_content':
            return [
                    'dmo_content'=>'required_if:dmo_content_status,==,1',
                    'dmo_content' => 'required'
            ];
        case 'telesale_content':
            return [
                    'tele_dmo_content'=>'required_if:dmo_content_status,==,1',
                    'tele_dmo_content' => 'required'
            ];
        case 'dmo_static_content':
            if($this->request->get('dmo_static_content_status') == 1){
                return [
                    'lowest_annual_cost'=>'required',
                    'lowest_annual_cost'=>'required',
                    'with_conditional'=>'required',
                    'without_conditional'=>'required',
                    'without_conditional_value'=>'required_unless:without_conditional,3',
                    'with_conditional_value'=>'required_unless:with_conditional,3',
            ];
            }
        case 'plan_rate_limit':
            if($this->request->get('id') != ''){
                return [
                        'limit_charges' => 'required|min:0|max:32768',
                        'limit_desc' => 'required|string|max:500',
                        'limit_year' => 'numeric|min:0|max:32768',
                        'limit_daily' => 'numeric|min:0|max:32768',
                ];
            }else{
                return [
                    'limit_type' => 'required',
                    'limit_level' => 'required',
                    'limit_charges' => 'required|min:0|max:32768',
                    'limit_desc' => 'required|string|max:500',
                    'limit_charges_description' => 'required|string|max:500',
                    'limit_year' => 'numeric|min:0|max:32768',
                    'limit_daily' => 'numeric|min:0|max:32768',
            ];

            }

        }
        return [];
    }

    public function messages()
    {
        return [
            'dmo_content.required' => trans('plans/energyPlans.dmocontenterror'),
            'tele_dmo_content.required' => trans('plans/energyPlans.dmocontenterror'),
        ];
    }
}
