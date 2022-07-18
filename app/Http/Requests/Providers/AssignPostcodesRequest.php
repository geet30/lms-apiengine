<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;

class AssignPostcodesRequest extends FormRequest
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
            'user_id' => 'bail|required|string',
            'energy_type' => 'bail|required|string|in:1,2,3',
            'distributor_id' => 'bail|required|string',
            'provider_postcodes' => 'bail|nullable|array|min:0',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'energy_type.required' => 'Please select energy type',
            'energy_type.in' => 'Please select energy type',
            'distributor_id.required' => 'Please select distributor',
        ];
    }

    protected function prepareForValidation()
    {
        if (!request()->has('provider_postcodes')) {
            $this->merge(['provider_postcodes' => []]);
        }
    }
}
