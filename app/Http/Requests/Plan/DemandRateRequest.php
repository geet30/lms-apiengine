<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class DemandRateRequest extends FormRequest
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
        $rules['usage_type'] = ['required'];
        $rules['season_rate_type'] = ['required'];
        $rules['limit_level'] = ['required'];
        $rules['limit_charges'] = ['required', 'numeric'];
        $rules['limit_daily'] = ['required', 'numeric'];
        $rules['limit_yearly'] = ['numeric'];
        $rules['usage_discription'] = ['required', 'max:1000'];

        return $rules;
    }
    public function messages()
    {
        return [
            'usage_type.required' => trans('plans/demand.demand_rates.usage_type'),
            'season_rate_type.required' => trans('plans/demand.demand_rates.season_rate_type'),
            'limit_level.required' => trans('plans/demand.demand_rates.limit_level'),
            'limit_charges.required' => trans('plans/demand.demand_rates.limit_charges'),
            'limit_daily.required' => trans('plans/demand.demand_rates.limit_daily'),
            'limit_charges.numeric' => trans('plans/demand.demand_rates.limit_charges_numeric'),
            'limit_daily.numeric' => trans('plans/demand.demand_rates.limit_daily_numeric'),
            'limit_yearly.numeric' => trans('plans/demand.demand_rates.limit_yearly'),
            'usage_discription.required' => trans('plans/demand.demand_rates.usage_discription'),
        ];
    }
}
