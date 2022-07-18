<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;

class AssignPostcodeRequest extends FormRequest
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
            'provider_id' => 'required',
            'assign_postcode_state_id' => 'required',
            'assign_postcode_suburb_id' => 'required',
            'assign_postcode_postcode_id' => 'required',
            // 'energy_type' => 'required',
            // 'distributor' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'provider_id.required' => trans('providers.assignPostcodeSection.provider_id.errors.required'),
            'assign_postcode_state_id.required' => trans('providers.assignPostcodeSection.assign_postcode_state_id.errors.required'),
            'assign_postcode_suburb_id.required' => trans('providers.assignPostcodeSection.assign_postcode_suburb_id.errors.required'),
            'assign_postcode_postcode_id.required' => trans('providers.assignPostcodeSection.assign_postcode_postcode_id.errors.required'),
        ];
    }
}
