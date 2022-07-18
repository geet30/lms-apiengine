<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class EditPlanRequest extends FormRequest
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
        $data_arr=[];
        switch ($this->get('action_form')) {
            case "plan_view_form":
                    return [
                        'view_discount' => 'required',
                        'view_bonus' => 'required',
                        'view_contract' => 'required',
                        'view_exit_fee' => 'required',
                        'view_benefit' => 'required'
                    ];
            case 'plan_info':
                return [
                    'name' => 'required|min:4|max:100',
                    'plan_type' => 'required',
                    'green_options' => 'required',
                    'green_options_desc' => 'required_if:green_options,==,1|max:1500',
                    'solar_compatible' => 'required',
                    'is_bundle_dual_plan' => 'required|in:1,0',
                    'show_solar_plan' => 'required|in:1,0',
                    'bundle_code' => 'required_if:is_bundle_dual_plan,==,1',
                    'plan_desc' => 'required|max:1000',
                    'show_price_fact' => 'required',
                    'generate_token' => 'required',
                    'contract_length' => 'required|min:4',
                    'benefit_term' => 'required|max:2500',
                    'paper_bill_fee' => 'required|min:4|max:5000',
                    'counter_fee' => 'required|min:4|max:5000',
                    'credit_card_service_fee' => 'required|min:4|max:5000',
                    'cooling_off_period' => 'required|min:4|max:5000',
                    'other_fee_section' => 'required|min:4|max:5000',
                    'plan_bonus'      => 'max:250',
                    'plan_bonus_desc' => 'max:1500',
                    'billing_options' => 'required|min:4|max:1500',
                    'payment_options' => 'required|min:4|max:1500',
                    'plan_features' => 'required|max:5000',
                    'terms_condition' => 'required|min:4|max:5000',
                    'recurring_meter_charges' => 'numeric|max:100',
                    'credit_bonus' => 'numeric|max:100',
                    'plan_campaign_code' => 'max:100',
                    'product_code_e' => 'max:100',
                    'campaign_code_res_elec' => 'max:100',
                    'promotion_code' => 'max:100',
                    'demand_usage_check' => 'required',
                ];
            case 'plan_info_gas':
                return [
                    'name' => 'required|min:4|max:100',
                    'plan_type' => 'required',
                    'contract_length' => 'required|min:4',
                    'benefit_term' => 'required|min:4|max:2500',
                    'is_bundle_dual_plan' => 'required|in:1,0',
                    'show_price_fact' => 'required',
                    'generate_token' => 'required',
                    'bundle_code' => 'required_if:is_bundle_dual_plan,==,1',
                    'paper_bill_fee' => 'required|min:4|max:5000',
                    'counter_fee' => 'required|min:4|max:5000',
                    'credit_card_service_fee' => 'required|min:4|max:5000',
                    'cooling_off_period' => 'required|min:4|max:5000',
                    'other_fee_section' => 'required|min:4|max:5000',
                    'plan_desc' => 'required|max:1000',
                    'plan_campaign_code' => 'max:100',
                    'product_code_e' => 'max:100',
                    'plan_bonus' => 'max:250',
                    'plan_bonus_desc' => 'max:1000',
                    'billing_options' => 'required|min:4|max:1000',
                    'payment_options' => 'required|min:4|max:1000',
                    'plan_features' => 'required|max:5000',
                    'terms_condition' => 'required|min:4|max:5000',
                    'recurring_meter_charges' => 'numeric',
                    'credit_bonus' => 'numeric',
                ];
            case 'plan_info_lpg':
                return [
                    'name' => 'required|min:4|max:100',
                    'plan_type' => 'required',
                    'contract_length' => 'required|min:4',
                    'benefit_term' => 'required|min:4|max:2500',
                    'is_bundle_dual_plan' => 'required|in:1,0',
                    'generate_token' => 'required',
                    'bundle_code' => 'required_if:is_bundle_dual_plan,==,1',
                    'paper_bill_fee' => 'required|min:4|max:5000',
                    'counter_fee' => 'required|min:4|max:5000',
                    'credit_card_service_fee' => 'required|min:4|max:5000',
                    'other_fee_section' => 'required|min:4|max:5000',
                    'plan_desc' => 'required|max:1000',
                    'plan_campaign_code' => 'max:100',
                    'product_code_e' => 'max:100',
                    'plan_bonus' => 'max:250',
                    'plan_bonus_desc' => 'max:1000',
                    'payment_options' => 'required|min:4|max:1000',
                    'plan_features' => 'required|max:5000',
                    'terms_condition' => 'required|min:4|max:5000',
                    'credit_bonus' => 'numeric',
                ];
                case 'apply_now_content_form':
                return [
                    'apply_now_status'=> 'required',
                    'apply_now_content'=> 'required_if:apply_now_status,==,1'
                ];
                case 'eic_content_form':
                    return [
                        'eic_status'=> 'required',
                        'eic_editor'=> 'required'
                    ];
                case 'eic_content_checkbox_form':
                    return [
                        'validation_message'=> 'required_if:checkbox_required,==,1',
                        'eic_type'=> 'required',
                        'checbox_content'=> 'required'
                    ];


                case 'remarketing_form':

                if ($this->request->get('remarketing_allow') == '1') {
                    $data_arr = [
                        'remarketing_allow' => 'required',
                        'discount' => 'required|max:10',
                        'discount_title' => 'required|max:150',
                        'termination_fee' => 'required|max:5',
                        'month_benfit_period' => 'required|max:5',
                        'remarketing_terms_conditions' => 'required'
                    ];
                }
                return $data_arr;

        }

        return [];

    }
    public function messages()
    {
        return [
            'view_discount.required' => trans('plans.view_discount_required'),
            'view_bonus.required' => trans('plans.view_bonust_required'),
            'view_contract.required' => trans('plans.view_contractt_required'),
            'view_exit_fee.required' => trans('plans.view_exit_feet_required'),
            'view_benefit.required' => trans('plans.view_benefitt_required'),

            'name.required' => trans('plans.name'),
            'name.min' => trans('plans.name_min'),
            'name.max' => trans('plans.name_max'),
            'plan_type.plan_type' => trans('plans.plan_type'),
            'contract_length.required' => trans('plans.contract_length'),
            'contract_length.max' => trans('plans.contract_length_max'),
            'benefit_term.required' => trans('plans.benefit_term'),
            'benefit_term.max' => trans('plans.benefit_term_max'),
            'is_bundle_dual_plan.required' => trans('plans.is_bundle_dual_plan'),
            'show_price_fact.required' => trans('plans.show_price_fact'),
            'generate_token.required' => trans('plans.generate_token'),
            'bundle_code.required' => trans('plans.bundle_code'),
            'paper_bill_fee.required' => trans('plans.paper_bill_fee'),
            'paper_bill_fee.max' => trans('plans.paper_bill_fee_max'),
            'counter_fee.required' => trans('plans.counter_fee'),
            'counter_fee.max' => trans('plans.counter_fee_max'),
            'credit_card_service_fee.required' => trans('plans.credit_card_service_fee'),
            'credit_card_service_fee.max' => trans('plans.credit_card_service_fee_max'),
            'cooling_off_period.required' => trans('plans.cooling_off_period'),
            'cooling_off_period.max' => trans('plans.cooling_off_period_max'),
            'other_fee_section.required' => trans('plans.other_fee_section'),
            'other_fee_section.max' => trans('plans.other_fee_section_max'),
            'plan_desc.required' => trans('plans.plan_desc'),
            'plan_desc.max' => trans('plans.plan_desc_max'),
            'plan_campaign_code.max' => trans('plans.plan_campaign_code_max'),
            'product_code_e.max' => trans('plans.product_code_e'),
            'plan_bonus.max' => trans('plans.plan_bonus_max'),
            'plan_bonus_desc.max' => trans('plans.plan_bonus_desc_max'),
            'billing_options.required' => trans('plans.billing_options'),
            'payment_options.required' => trans('plans.payment_options'),
            'plan_features.required' => trans('plans.plan_features'),
            'plan_features.max' => trans('plans.plan_features'),
            'terms_condition.required' =>  trans('plans.terms_condition'),
            'terms_condition.max' =>  trans('plans.terms_condition.max'),
            'recurring_meter_charges.numeric' => trans('plans.recurring_meter_charges'),
            'credit_bonus.numeric' => trans('plans.credit_bonus'),
            'eligibility.required' => trans('plans.eligibility'),
            'discount.required' => trans('plans.discount_title'),
            'discount.max' => trans('plans.discount_title_max'),
            'discount_title.required' => trans('plans.discount_title_max'),
            'discount_title.max' => trans('plans.discount_title_max'),
            'termination_fee.required' => trans('plans.termination_fee'),
            'termination_fee.max' => trans('plans.termination_fee_max'),
            'month_benfit_period.required' => trans('plans.month_benfit_period'),
            'month_benfit_period.max' => trans('plans.month_benfit_period_max'),
            'remarketing_terms_conditions.required' => trans('plans.remarketing_terms_conditions'),
            'remarketing_terms_conditions.max' => trans('plans.remarketing_terms_conditions_max'),
            'apply_now_content.required_if'=>trans('plans.apply_now_content'),
            'eic_editor.required'=>trans('plans.eic_editor'),
            'validation_message.required'=>trans('plans.validation_message'),

       ];
    }
}
