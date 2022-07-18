<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class LifeSupportEquipmentRequest extends FormRequest
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
        $data = [
            'title' => ['bail', 'required', 'string'],
            'energy_type' => 'bail|required|string|in:1,2,3',
        ];

        if (isset($this->life_support_id)) {
            $data['title'][] = 'unique:life_support_equipments,title,'.$this->life_support_id;
        } else {
            $data['title'][] = 'unique:life_support_equipments,title';
        }

        return $data;
    }
}
