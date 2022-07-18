<?php

namespace App\Http\Requests\Plan\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class EditPlanVariantRequest extends FormRequest
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
            'lease_cost'=> 'bail|required_if:lease,1|numeric|min:1|between:1,99999.99', 
            'own_cost'=> 'bail|required_if:own,1|numeric|min:1|between:1,99999.99', 
            'contract_own_cost.*' => 'bail|nullable|numeric|min:0|between:1,99999.99',
            'contract_lease_cost.*' => 'bail|nullable|numeric|min:0|between:1,99999.99'
        ];
    }

    public function messages()
    {
        return [
            'contract_own_cost.*.numeric' => 'Please enter valid Contract Cost.',
            'contract_own_cost.*.min' => 'Contract Cost must be a positive value.',
            'contract_own_cost.*.between' => 'Contract Cost should be between 1-5 numbers and upto 2 decimal places are allowed.',

            'contract_lease_cost.*.numeric' => 'Please enter valid Contract Cost.',
            'contract_lease_cost.*.min' => 'Contract Cost must be a positive value.',
            'contract_lease_cost.*.between' => 'Contract Cost should be between 1-5 numbers and upto 2 decimal places are allowed.'
        ]; 
    }
}
