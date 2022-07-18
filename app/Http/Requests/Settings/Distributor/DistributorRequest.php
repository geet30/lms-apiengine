<?php

namespace App\Http\Requests\Settings\Distributor;

use Illuminate\Foundation\Http\FormRequest;

class DistributorRequest extends FormRequest
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
            'distributor_id' => 'nullable',
            'distributor_name' => 'bail|required|string|unique:distributors,name',
            'energy_type' => 'bail|required|string|in:1,2,3',
            'post_codes' => 'bail|nullable|array',
            'post_codes.*' => 'bail|numeric|digits_between:3,4',
        ];

        if (isset($this->distributor_id)) {
            $rules['distributor_id'] = 'bail|required|string';
            $rules['distributor_name'] = 'bail|required|string|unique:distributors,name,'.$this->distributor_id;
            $rules['post_codes'] = 'bail|required|array|min:1';
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        if (isset($this->post_codes)) {
            $post_codes = json_decode($this->post_codes);
            foreach ($post_codes as $post_code) {
                $codes[] = $post_code->value;
            }
            $this->merge([
                'post_codes' => $codes,
            ]);
        } else {
            $this->merge([
                'post_codes' => [],
            ]);
        }
    }

    public function messages()
    {
        return [
            'post_codes.*.numeric' => 'The post codes must be numbers.',
            'post_codes.*.digits_between' => 'The post codes must be of 3 or 4 digits.',
        ];
    }
}
