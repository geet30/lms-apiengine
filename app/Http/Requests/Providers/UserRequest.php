<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UserRequest extends FormRequest
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
        $rules=[];

        $rules = [
            'providers' => "bail|required|array",
        ];
             
        return $rules;
    }

    public function messages()
    {
        return [
            'providers.required' => trans('providers.affiliatesrequired'),
        ];
    }
}
