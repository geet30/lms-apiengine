<?php

namespace App\Http\Requests\MobileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ColorsRequest extends FormRequest
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
        $id = request('hidden_edit_id');

        $rules = [
            'title' => "required|min:0|max:50|unique:colors,title",
            'hexacode' => "required|regex:/^#[a-f0-9]{6}$/i|unique:colors,hexacode",
        ];

        if (isset($id)) {
            $rules = [
                'title' => 'required|min:0|max:50|unique:colors,title,'.$id,
                'hexacode' => 'required|regex:/^#[a-f0-9]{6}$/i|unique:colors,hexacode,'.$id,
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'hexcode.regex' => 'Choose a valid color hexa code.',
        ];
    }
}
