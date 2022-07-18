<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;

class ProviderDisallowPlansRequest extends FormRequest
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
            /*'assigned_plans' => 'bail|required|array|min:1',*/
            'affiliate_id' => 'required',
            'provider_id' => 'required',
        ];
    }
}
