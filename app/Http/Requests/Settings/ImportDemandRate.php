<?php

namespace App\Http\Requests\Settings;
use App\Rules\Settings\DemandTariffFormat;
use Illuminate\Foundation\Http\FormRequest;

class ImportDemandRate extends FormRequest
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
            'tariff_code_file' => ['required', new DemandTariffFormat]
        ];
    }
}
