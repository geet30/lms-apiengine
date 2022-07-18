<?php

namespace App\Http\Requests\Settings\MasterTariffCode;

use Illuminate\Foundation\Http\FormRequest;

class MasterTariffCodeRequest extends FormRequest
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
            'tariff_code' => 'bail|required|string',
            'units_type' => 'bail|required|string',
            'status' => 'bail|required|string',
        ];
    }
}
