<?php

namespace App\Http\Requests\Plan\Broadband;

use Illuminate\Foundation\Http\FormRequest;

class PostPlanEICRequest extends FormRequest
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
            'status'=> 'required',
            'content'=> 'required_if:status,1'
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
            'status.required' => trans('plans/broadband.enable_plan_acknowledgement.validation.required'), 
            'content.required_if' => trans('plans/broadband.description.validation.required'), 
        ];
    }
}
