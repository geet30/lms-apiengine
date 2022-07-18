<?php

namespace App\Http\Requests\Plan\Broadband;

use Illuminate\Foundation\Http\FormRequest;

class OtherAddonRequest extends FormRequest
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
            'amount.*' => 'bail|nullable|numeric|gte:0'
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
            'amount.*.numeric' => trans('plans/broadband.fees_amount.validation.numeric'),
            'amount.*.gte' => trans('plans/broadband.fees_amount.validation.gt'),
        ];
    }
}
