<?php

namespace App\Http\Requests\MobileSettings;

use App\Rules\Settings\MobileSettings\UniqueRamValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class RamRequest extends FormRequest
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
        $rules = [
            'value' => ['bail', 'required', 'numeric', 'min:1', 'max:1024', new UniqueRamValue()],
            'unit' => ['bail', 'required', 'string', new UniqueRamValue()],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'value.required' => trans('mobile_settings.ramPage.capacityNameRequired'),
            'value.number' => 'Capacity must be a number',
            'value.min' => 'Capacity must must be at least 1',
            'value.max' => 'Capacity may not be greater than 1024.',
            'unit.required' => trans('mobile_settings.ramPage.capacityUnitRequired'),
        ];
    }
}
