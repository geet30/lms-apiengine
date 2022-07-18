<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;

class AddSftpRequest extends FormRequest
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
        $rules =  [
            'destination_name' => 'bail|required|string',
            'auth_type' => 'bail|required',
            'protocol_type' => 'bail|required',
            'remote_host' => 'bail|required|string',
            'port' => 'bail|required|numeric|min:1|max:65535',
            'username' => 'bail|required|string',
            'password' => ['bail', 'required', 'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*#?&^_-])/','min:8'],
            'timeout' => 'bail|nullable|numeric:|gt:0',
            'directory' => 'bail|nullable|string',
            'status' => 'bail|sometimes',
            'sftp_id' => 'bail|sometimes',
        ];

        return $rules;
    }

    public function messages(){
        return [
            'password.regex'=>'The :attribute field should contain at least one A-Z, a-z, 0-9 and special character.',
        ];
    }
}
