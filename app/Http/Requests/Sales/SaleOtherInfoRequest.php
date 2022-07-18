<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaleOtherInfoRequest extends FormRequest
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
        $rules = [];
        $rules['form'] = ['required'];
        
        $request = Request::all();
        switch ($request['form']) {
            case 'other_info_form':
                $rules['token'] = ['nullable','bail','max:100'];
                $rules['qa_notes'] = ['nullable','bail','max:1000'];
                $rules['life_support_notes'] = ['nullable','bail','max:1000'];
                $rules['qa_notes_created_date'] = ['nullable','bail','date'];
                $rules['retailers_resubmission_comment'] = ['nullable','bail','max:1000','string'];
                $rules['pin_number'] = ['nullable','bail','integer','gt:-1','digits:10'];
                $rules['simply_reward_id'] = ['bail','nullable','integer','gt:-1','min:1'];
                $rules['sale_agent'] = ['bail','required'];
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'token.max' => 'Token exceeding max length 100',
            'qa_notes.max' => 'Note From CIMET exceeding max length 1000',
            'life_support_notes.max' => 'Life support Notes exceeding max length 1000',
            'qa_notes_created_date.date' => 'Please enter a valid date.',
            'retailers_resubmission_comment.max' => 'Resubmission comment exceeding max length 1000',
            'pin_number.integer' => 'Only Integer values allowed',
            'pin_number.gt' => 'Only Positive values allowed',
            'pin_number.digits' => 'Pin Number must be of 10 digits',
            'simply_reward_id.integer' => 'Only Integer values allowed',
            'simply_reward_id.gt' => 'Only Positive values allowed',
            'simply_reward_id.min' => 'Simply Reward ID must be greater than 0.',
            'sale_agent.required' => 'Please select Sale Agent',
        ];
    }
}
