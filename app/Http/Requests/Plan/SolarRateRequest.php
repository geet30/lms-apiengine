<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class SolarRateRequest extends FormRequest
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
        return [
            'solar_rate'=>'bail|required|numeric',
            'solar_desc'=>'bail|required|string',
            'type'=>'bail|required|string',
            'plan_id'=>'bail|required|string',
            'show_on_frontend'=>'bail|nullable|string',
            'charge'=>'bail|nullable|numeric',
            'solar_rate_price_description' => "bail|nullable|string|max:1000",
            'solar_supply_charge_description' => "bail|nullable|string|max:1000",
        ];
    }

    public function messages()
    {
        return [
            'solar_rate.required'=>'Please Enter Solar Rate Price',
            'solar_rate.numeric'=>'Only Numeric Values Allowed',
            'solar_desc.required'=>'Please Enter Solar Rate Description',
            'charge.numeric'=>'Only Numeric Values Allowed',
            'solar_rate_price_description.max' => "Solar Rate Price Description exceeding max character length 1000",
            'solar_supply_charge_description.max' => "Solar Supply Charge Description exceeding max character length 1000",
        ];
    }
   
}
