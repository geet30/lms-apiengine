<?php

namespace App\Http\Requests\MobileSettings;

use App\Rules\Settings\MobileSettings\UniqueStorageValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StorageRequest extends FormRequest
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
            'value' => ['bail', 'required', 'numeric', 'min:0', 'max:1024', new UniqueStorageValue()],
            'unit' => ['bail', 'required', 'string', new UniqueStorageValue()],
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'value.required' => trans('mobile_settings.storagePage.storageNameRequired'),

            'unit.required' => trans('mobile_settings.storagePage.storageUnitRequired'),
        ];
    }
}
