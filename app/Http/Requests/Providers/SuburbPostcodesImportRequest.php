<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;

class SuburbPostcodesImportRequest extends FormRequest
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
