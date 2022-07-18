<?php

namespace App\Http\Requests\Affiliates;

use App\Rules\Affiliates\CheckValidToken;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules;

class PasswordResetRequest extends FormRequest
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
        return [
            'token' => ['required','string', new CheckValidToken($request)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
