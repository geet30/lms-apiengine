<?php

namespace App\Http\Requests\Plan\Broadband;

use Illuminate\Foundation\Http\FormRequest;

class EditTermConditionRequest extends FormRequest
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
            'title' => ['required','max:255'], 
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
            'title.required' => trans('plans/broadband.term_form_title.validation.required'),
            'title.max' => trans('plans/broadband.term_form_title.validation.max'), 
        ];
    }
}
