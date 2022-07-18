<?php

namespace App\Http\Requests\MobileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ContractRequest extends FormRequest
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
            'contract_name' => "required|min:0|max:50|unique:contract,contract_name",
            'validity' => "required|numeric|min:1|unique:contract,validity",
            'description' => "nullable|string",
        ];

        if (isset($id)) {
            $rules = [
                'contract_name' => 'required|min:0|max:50|unique:contract,contract_name,'.$id,
                'validity' => 'required|numeric|min:1|unique:contract,validity,'.$id,
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
