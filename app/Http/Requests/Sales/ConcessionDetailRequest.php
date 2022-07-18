<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ConcessionDetailRequest extends FormRequest
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
        $rules=[];
        $concessionType=$request['concession_type'];
        if($concessionType!=""  ){
            $rules['card_number'] = 'required|min:1|max:16';
            $rules['card_issue_date'] = 'required|before:card_expiry_date';
            $rules['card_expiry_date'] = 'required|after:card_start_date';
            $rules['concession_details_comment'] = 'max:500';
        }
        
        return $rules;

    }

    public function messages()
    {
        return [
            'card_number.required' => trans('sale_detail.card_number_required'),
            'card_issue_date.required' => trans('sale_detail.card_start_date_required'),
            'card_issue_date.before' => trans('sale_detail.card_start_date_before'),
            'card_expiry_date.required' => trans('sale_detail.card_expiry_date_required'),
            'card_expiry_date.after' => trans('sale_detail.card_expiry_date_after'),
            'concession_details_comment.max' => trans('sale_detail.comment_max_validation')


       ];
    }
}
