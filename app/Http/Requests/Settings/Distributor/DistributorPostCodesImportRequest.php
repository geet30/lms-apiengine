<?php

namespace App\Http\Requests\Settings\Distributor;

use Illuminate\Foundation\Http\FormRequest;

class DistributorPostCodesImportRequest extends FormRequest
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
            'file' => 'bail|required|max:2048|mimes:csv,txt',
            'distributor_id' => 'bail|required|string'
        ];
    }

    public function messages()
    {
        return [
          'file.required' => 'Please choose a file',
          'file.mimes' => 'The file must be a file of type: csv.',
        ];
    }
}
