<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Rules\CheckEmailValid;

class EmailFromLeadsRequest extends FormRequest
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
        $request = Request::all();
        $rules = [];
        $EmailCc = $request['emailCC'];
        $EmailBcc = $request['emailBcc'];

        $rules['emailFrom'] = ['required',new CheckEmailValid()];
        $rules['emailTo'] = 'required|email';
        $rules['emailFromName'] = 'required|max:500';
        $rules['emailSubject'] = 'required|max:500';
        $rules['emailContent'] = 'required|min:0|max:32768';


        if ($EmailCc != null) {
            $rules['emailCC'] = 'email';
        }
        if ($EmailBcc != null) {
            $rules['emailBcc'] = 'email';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'emailFrom.required' => 'Please Enter Your Email Address.',
            'emailTo.required' => 'Please Enter Your Email Address.',
            'emailCC.email' => 'Please Enter Valid Email Address for "CC". ',
            'emailBcc.email' => 'Please Enter Valid Email Address for "BCC".',
            'emailFromName.required' => 'Please Enter Your Name.',
            'emailSubject.required' => 'Email Subject is required.',
            'emailContent.required' => 'Email Message is required.',
            'emailContent.max' => 'Email Message Exceeded Max. Allowed Length',
        ];
    }
}
