<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MessageTemplateInterval;
use Illuminate\Support\Facades\Request;

class AffiliateEmailSmsRequest extends FormRequest
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
        $validation['template_name'] = 'required|min:3|max:50|regex:/^[a-zA-Z0-9 "-]+$/';
        switch ($this->request->get('type')) {
            case '1':
                if ($this->request->get('email_type') == '2') {
                    if ($this->request->has('interval')) {
                        if ($this->request->get('select_remarketing_type') == '2') {
                            $validation['interval'] = ['required', 'numeric', 'min:1', new MessageTemplateInterval($input)];
                        } else {
                            $validation['interval'] = ['required', 'numeric', 'min:0', new MessageTemplateInterval($input)];
                        }
                    }

                    if ($this->request->get('interval') != 0) {
                        $validation['remarketing_time'] = 'required';
                    } else {
                        if ($this->request->get('instant') != '1') {
                            $validation['delay_time'] = 'required|numeric|min:10|max:120';
                        }
                    }
                }

                $validation['from_name'] = 'required';
                $validation['from_email'] = ['bail', 'required'];
                $validation['ip_pool'] = 'required';
                $validation['description'] = 'bail|required|min:3|max:500';
                $validation['subject'] = 'bail|required|min:3|max:100';
                $validation['contents'] = 'bail|required|min:3';
                $validation['type'] = 'required';
                $validation['reply_to'] = 'nullable|email';
                break;
            case '2':
                $validation['contents']  = 'required|min:3|max:1000';
                if ($this->request->get('sender_id_method') == "2" && $this->request->has('sender_id')) {
                    $validation['sender_id'] = 'required|regex:/^[a-zA-Z0-9 "-]+$/|max:11';
                }
                if ($this->request->get('sender_id_method') == "3" && $this->request->has('plivo_number')) {
                    $validation['plivo_number'] = 'required';
                }
                if ($this->request->get('email_type') == '2') {
                    if ($this->request->has('interval')) {
                        if ($this->request->get('select_remarketing_type') == '2') {
                            $validation['interval'] = ['required', 'numeric', 'min:1', new MessageTemplateInterval($input)];
                        } else {
                            $validation['interval'] = ['required', 'numeric', 'min:0', new MessageTemplateInterval($input)];
                        }
                    }

                    if ($this->request->get('interval') != 0) {
                        $validation['remarketing_time'] = 'required';
                    } else {
                        if ($this->request->get('instant') != '1') {
                            $validation['delay_time'] = 'required|numeric|min:10|max:120';
                        }
                    }
                }
                break;
        }
        return $validation;
    }
    protected function prepareForValidation()
    {
        if ($this->has('delay_time')) {
            $parts = explode(":", $this->delay_time);
            $hours = intval($parts[0]);
            $minutes = 00;
            if (isset($parts[1])) {
                $minutes = intval($parts[1]);
            }
            //dd($hours * 60 + $minutes);
            $this->merge(['delay_time' => $hours * 60 + $minutes]);
        }
    }
    public function messages()
    {
        return [
            'template_name.required' => 'The name field is required.',
            'template_name.min' => 'The name field must have atleast 3 characters.',
            'template_name.max' => ' The name field should not be more than 50 characters.',
            'template_name.regex' => 'The name field may only contain letters , numbers and whitespaces.',
            'subject.required' => 'The subject field is required.',
            'subject.min' => ' Subject Name field must have atleast 3 characters.',
            'subject.max' => ' Subject Name field should not be more than 100 characters.',
            'content.min' => 'Content field must have atleast 3 characters.',
            'content.max' => 'Content field should not be more than 500 characters.',
            'interval.required' => 'Please enter the days interval',
            'interval.email_template_interval' => 'Template with same days interval already exists',
            'delay_time.required' => 'Please either select Instant checkbox or enter delay time',
            'delay_time.max' => 'Delay time should not be more than 120.',
            'delay_time.min' => 'Delay time should not be less than 10.',
            'ip_pool' => 'The IP pool field is required.',
            'contents.required' => "The content field is required."
        ];
    }
}
