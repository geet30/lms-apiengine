<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AddPasswordProtectedProviderSaleSubmissionRequest extends FormRequest
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
        $data =  [
            'provider_id' => 'bail|required|string',
            'status' => 'bail|required|boolean',
            'password' => ['bail', 'nullable'],
        ];

        if(request()->status == 1){
            $data['password'] = ['bail', 'required', 'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*#?&^_-])/','min:8'];
        }

        return $data;
    }

    public function messages(){
        return [
            'password.regex'=>'The :attribute field should contain at least one A-Z, a-z, 0-9 and special character.',
        ];
    }
}
