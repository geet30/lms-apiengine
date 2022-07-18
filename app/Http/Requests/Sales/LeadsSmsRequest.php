<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MessageTemplateInterval;
use Illuminate\Support\Facades\Request;

class LeadsSmsRequest extends FormRequest
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
        $validation = [];
        $input = Request::all();
        $validation['sms_to'] = 'required';
        $validation['message']  = 'required|min:3|max:1000';
        $validation['sender_id_method'] = 'required';
        if ($this->request->get('sender_id_method') == "2" && $this->request->has('method_content')) {
            $validation['method_content'] = 'required';
        }
        if ($this->request->get('sender_id_method') == "3" && $this->request->has('plivo_number')) {
            $validation['plivo_number'] = 'required';
        }

        return $validation;
    }
    public function messages()
    {
        return [
            'sms_to.required' => 'The name field is required.',
            'message.min' => 'The name field must have atleast 3 characters.',
            'message.max' => ' The name field should not be more than 50 characters.',
            'message.required' => 'The Message field is required.',
            'method_content.required' => 'This field is required.',
            'method_content.numeric' => 'Only Number Allow.',
            'method_content.digits_between' => 'Contact Number must be between 10 and 13 digits.',
            'sender_id_method.required' => 'Please Select One Option.',
        ];
    }
}
