<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class DemandRequest extends FormRequest
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

        $rules['tariff_discount'] = ['numeric'];
        $rules['tariff_code_ref_id'] = ['required'];
        $rules['tariff_daily_supply'] = ['numeric'];
        $rules['tariff_supply_discount'] = ['numeric'];
        $rules['daily_supply_charges_description'] = ['required', 'max:200'];
        $rules['discount_on_usage_description'] = ['required', 'max:200'];
        $rules['discount_on_supply_description'] = ['required', 'max:200'];
        return $rules;
    }
    public function messages()
    {
        return [
            'tariff_discount.numeric' => trans('plans/demand.tariff_discount'),
            'tariff_daily_supply.numeric' => trans('plans/demand.tariff_daily_supply'),
            'tariff_supply_discount.numeric' => trans('plans/demand.tariff_supply_discount'),
            'tariff_code_ref_id.required' => trans('plans/demand.demand_tariff_code'),
            'daily_supply_charges_description.required' => trans('plans/demand.daily_supply_charge_desc'),
            'discount_on_usage_description.required' => trans('plans/demand.discount_on_usage_desc'),
            'discount_on_supply_description.required' => trans('plans/demand.discount_on_supply_desc'),

        ];
    }
}
