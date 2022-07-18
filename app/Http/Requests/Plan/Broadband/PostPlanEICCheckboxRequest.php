<?php

namespace App\Http\Requests\Plan\Broadband;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class PostPlanEICCheckboxRequest extends FormRequest
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
        $request =  Request::all(); 
        $rules = [
            'checkbox_id' => 'required'
        ];
        if($request['action'] == 'edit' || $request['action'] == 'add')
        {
            $rules = [
                    'checkbox_id' => 'required_if:action,edit',
                    'required' => 'required',
                    'status' => 'required',
                    'checkbox_content' => 'required',
                    'validation_message' => 'required_if:required,1|max:100',
                ]; 
        }
        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => trans('plans/broadband.checkbox_required.validation.required'), 
            'status.required' => trans('plans/broadband.ack_form_save_checkbox_status_in_database.validation.required'), 
            'checkbox_content.required' => trans('plans/broadband.ack_form_content.validation.required'), 
            'validation_message.required_if' => trans('plans/broadband.ack_form_validation_message.validation.required'), 
            'validation_message.max' => trans('plans/broadband.ack_form_validation_message.validation.max'), 
        ];
    }
}
