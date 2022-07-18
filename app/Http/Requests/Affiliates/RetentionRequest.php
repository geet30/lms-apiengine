<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;

class RetentionRequest extends FormRequest
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
        $Error = [];
        $Error = [
            'service_id'
            => "bail|required",
            'provider_id'
            => "required",
        ];
        return $Error;
    }
    public function messages()
    {
        return [
            'service_id.required' => trans('affiliates.userservicerequired'),
            'provider_id.required' => trans('affiliates.provider_idrequired'),
        ];
    }
}
