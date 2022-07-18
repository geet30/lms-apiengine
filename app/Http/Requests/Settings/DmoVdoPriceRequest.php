<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class DmoVdoPriceRequest extends FormRequest
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
            'distributor' => 'bail|required|string',
            'property_type' => 'bail|required|string',
            'tariff_type' => 'bail|required|string',
            'tariff_name' => 'bail|required|string',
            'offer_type' => 'bail|required|string',
            'annual_price' => 'bail|required|numeric',
            'peak_only' => 'bail|required|numeric',
            'peak_offpeak_offpeak' => 'bail|nullable|numeric',
            'peak_shoulder_peak' => 'bail|nullable|numeric',
            'peak_shoulder_offpeak' => 'bail|nullable|numeric',
            'peak_shoulder_shoulder' => 'bail|nullable|numeric',
            'peak_shoulder_1_2_peak' => 'bail|nullable|numeric',
            'peak_shoulder_1_2_offpeak' => 'bail|nullable|numeric',
            'peak_shoulder_1_2_shoulder_1' => 'bail|nullable|numeric',
            'peak_shoulder_1_2_shoulder_2' => 'bail|nullable|numeric',
            'control_load_1' => 'bail|nullable|numeric',
            'control_load_2' => 'bail|nullable|numeric',
            'control_load_1_2_1' => 'bail|nullable|numeric',
            'control_load_1_2_2' => 'bail|nullable|numeric',
            'annual_usage' => 'bail|required|numeric',
        ];
    }
}
