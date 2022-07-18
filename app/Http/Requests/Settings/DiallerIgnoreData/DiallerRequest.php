<?php

namespace App\Http\Requests\Settings\DiallerIgnoreData;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckIpRangeFormat;

class DiallerRequest extends FormRequest
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
        $rules = [
            'type' => 'required',
        ];

        if ($this->type == 1) {
            $rules['content_name'] = 'bail|required|string|max:30';
        }
        if ($this->type == 2) {
            $rules['content_name'] = 'bail|required|email';
        }
        if ($this->type == 3) {
            $rules['content_name'] = 'required|numeric|digits_between:5,10';
        }
        if ($this->type == 4) {
            $rules['content_name'] = 'required|regex:/^([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        }
        if ($this->type == 5) {
            $rules['content_name'] = ['bail','required' , new CheckIpRangeFormat()];

        }
        if ($this->type == 6) {
            $rules['content_name'] = ['bail','required', new CheckIpRangeFormat()];
        }
        return $rules;
    }

    // public function prepareForValidation()
    // {
    //     if (isset($this->post_codes)) {
    //         $post_codes = json_decode($this->post_codes);
    //         foreach ($post_codes as $post_code) {
    //             $codes[] = $post_code->value;
    //         }
    //         $this->merge([
    //             'post_codes' => $codes,
    //         ]);
    //     } else {
    //         $this->merge([
    //             'post_codes' => [],
    //         ]);
    //     }
    // }

    public function messages()
    {
        return [
            'content_type.required' => 'Please Select Type.',
            'content_name.required' => 'Please Enter Some Data.',
            'content_name.string' => 'Please Enter Valid Name.',
            'content_name.max' => 'Name field should not be more than 30 characters.',
            'content_name.email' => 'Please Enter Valid Email Address.',
            'content_name.numeric' => 'The phone number must be a number.',
            'content_name.digits_between' => 'The Phone Number must be between 5 and 10 digits.',
            'content_name.regex' => 'Please Enter Valid Domain Name',
            'content_name.CheckIpFormat' => 'Please Enter Valid IP Address.',
            
        ];
    }
}
