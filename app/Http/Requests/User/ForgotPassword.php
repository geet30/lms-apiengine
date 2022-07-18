<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ForgotPassword extends FormRequest
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
            'email' => 'required|exists:users',
        ];
    }

    protected function prepareForValidation()
    {  
        Request::merge([
            'email' => encryptGdprData($this->email)
        ]);
    }
}
