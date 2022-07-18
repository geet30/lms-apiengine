<?php

namespace App\Http\Requests\Providers;

use App\Models\States;
use Illuminate\Foundation\Http\FormRequest;

class AddSuburbRequest extends FormRequest
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
            'postcode' => 'required|numeric|digits_between:3,4',
            'state' => 'required|string|in:'.implode(',', States::pluck('state_code')->toArray()),
            'suburb' => 'required|string',
            'status' => 'required|string|in:0,1',
        ];
    }
    public function messages()
    {
        return [
            'post_code.digits_between' => 'Post Code must be of 3 or 4 digits'
        ];
    }
}
