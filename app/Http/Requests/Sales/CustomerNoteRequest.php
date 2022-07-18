<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class CustomerNoteRequest extends FormRequest
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
        $request = Request::all();
        $rules=[
            'comment'=>'max:500'
        ];
        if(!empty($request['elec_note'])){
            $rules['elec_note'] = 'required|min:1|max:256';
        }
        if(!empty($request['gas_note'])){
            $rules['gas_note'] = 'required|min:1|max:256';
        }
        return $rules;

    }

    public function messages()
    {
        return [
            'elec_note.required' => trans('sale_detail.customer_elec_note_required'),
            'gas_note.required' => trans('sale_detail.customer_gas_note_required'),
            'comment.max' => trans('sale_detail.comment_max_validation')
       ];
    }
}
