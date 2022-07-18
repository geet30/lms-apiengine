<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;

class Vertical extends FormRequest
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
            "service" => "required"
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'service.required' => trans('affiliates.userservicerequired'),
        ];
    }
}
