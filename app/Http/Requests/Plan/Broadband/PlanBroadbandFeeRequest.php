<?php

namespace App\Http\Requests\Plan\Broadband;
use Illuminate\Foundation\Http\FormRequest; 
use App\Rules\Plan\Common\UniqueFeeType;
class PlanBroadbandFeeRequest extends FormRequest
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
            'fee_id' => ['required',new UniqueFeeType()],
            'cost_type' => 'required',
            'amount' => 'bail|required|numeric|gte:0|regex:/^\d+(\.\d{1,2})?$/|max:10000'
        ];
    }
    
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'fee_id.required' => trans('plans/broadband.fees.validation.required'), 
            'cost_type.required' => trans('plans/broadband.fees_cost_type.validation.required'),
            'amount.required' => trans('plans/broadband.fees_amount.validation.required'),
            'amount.numeric' => trans('plans/broadband.fees_amount.validation.numeric'),
            'amount.gte' => trans('plans/broadband.fees_amount.validation.gt'),
            'amount.regex' => 'Amount is allowed till two decimal places',
        ];
    }
}

