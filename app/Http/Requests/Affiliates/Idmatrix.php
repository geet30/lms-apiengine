<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;

class Idmatrix extends FormRequest
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
        $Error = [
            'matrix_content' => 'required',
            // 'services' => 'required',
        ];
        return $Error;
    }

    public function messages()
    {
        return [
            'matrix_content.required' => trans('affiliates.matrix.matrix_content_error'),
        ];
    }
}
