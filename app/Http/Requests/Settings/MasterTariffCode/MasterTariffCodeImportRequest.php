<?php

namespace App\Http\Requests\Settings\MasterTariffCode;

use Illuminate\Foundation\Http\FormRequest;

class MasterTariffCodeImportRequest extends FormRequest
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
            'file' => 'bail|required|mimes:csv,txt|max:2048',
            'method' => 'bail|required|string|in:replace_all,replace_existing'
        ];
    }

    public function messages()
    {
        return [
          'file.required' => 'Please choose a file',
          'file.mimes' => 'The file must be a file of type: csv.',
          'file.method' => 'The method field is invalid.',
        ];
    }
}
