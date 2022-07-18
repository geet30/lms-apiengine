<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;

class TargetRequest extends FormRequest
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
        $Error = [];
        $Error = [
            'target_date' => 'required|date_format:m-Y',
            'target_value' => 'required|integer|min:1|max:32768',
        ];
        return $Error;
    }

    public function messages()
    {
        return [
            'target_date.required' => trans('affiliates.target.target_year_error'),
            'target_value.required' => trans('affiliates.target.target_value_error'),
        ];
    }
}
