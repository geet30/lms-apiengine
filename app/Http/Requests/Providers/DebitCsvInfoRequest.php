<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;

class DebitCsvInfoRequest extends FormRequest
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
            'sale_export_password' => 'sometimes|nullable|min:8',
           
        ];
    }
    public function messages()
    {
        return [
           
          
        ];
    }
}
