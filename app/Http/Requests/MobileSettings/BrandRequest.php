<?php

namespace App\Http\Requests\MobileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class BrandRequest extends FormRequest
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

        $rules=[];

        $rules = [
            'title' => "bail|required|string|min:0|max:50",
            'os_name' => "bail|required|string",
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => trans('mobile_settings.brandPage.brandsrequired'),
            'os_name.required' => trans('mobile_settings.brandPage.osrequired'),
        ];
    }
}
