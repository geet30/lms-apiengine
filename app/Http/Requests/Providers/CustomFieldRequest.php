<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class CustomFieldRequest extends FormRequest
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
        $rules = [];
        $request = Request::all();
        if ($request['form_request'] == 'personal_form') {
            $rules = [
                'custom_field_label' => 'required',
                'custom_field_placeholder' => 'required',
                'custom_field_message' => 'required',
                'user_id' => 'required',
                'section_id' => 'required',
            ];
        } else if ($request['form_request'] == 'connection_form') {
            $rules = [
                'connection_custom_field_quest' => 'required',
                'connection_custom_field_message' => 'required',
                'connection_custom_field_type' => 'required',
                'connection_custom_field_count' => 'required_if:connection_custom_field_type,2'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'custom_field_label.required' => 'Label is required.',
            'custom_field_placeholder.required' => 'Placeholder is required.',
            'custom_field_message.required' => 'Message is required.',
            'user_id.required' => 'User id is required.',
            'section_id.required' => 'Section id is required.',
            'connection_custom_field_quest.required' => 'Question is required.',
            'connection_custom_field_message.required' => 'Message is required.',
            'connection_custom_field_type.required' => 'Type is required.',
            'connection_custom_field_count.required_if' => 'Count is required.',
        ];
    }
}
