<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use App\Rules\Providers\UniqueCode;

class LifeSupportRequest extends FormRequest
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
        $rules = [
            'life_support_code_id' => "nullable",
            'provider_id' => "required",
            'life_support_equip_id' => "required",
            'code' => ["required", "alpha_num", new UniqueCode($request)],
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'life_support_equip_id.required' => trans('providers.lifesupport.lifesupportid.errors.required'),
            'code.required' => trans('providers.lifesupport.code.errors.required'),
            'code.alpha_num' => trans('providers.lifesupport.code.errors.alpha_num'),
        ];
    }
}
