<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SalesQaSectionRequest extends FormRequest
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
            case 'qa_section_form':
                $rules['qa_comment'] = ['nullable','bail','string','max:1000'];
                $rules['sale_comment'] = ['nullable','bail','string','max:1000'];
                $rules['rework_comment'] = ['nullable','bail','max:1000'];
                $rules['assigned_agent'] = ['nullable','bail','max:100'];
                $rules['sale_completed_by'] = ['bail','required'];
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
           
            'qa_comment.max' => 'QA Comment exceeding max length 1000',
            'sale_comment.max' => 'Sale Comment exceeding max length 1000',
            'rework_comment.max' => 'Rework Comment exceeding max length 1000',
            'assigned_agent.max' => 'Dog Code exceeding max length 100',
            'sale_completed_by.required' => 'Please Select Sale Completed By',
        ];
    }
}
