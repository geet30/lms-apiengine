<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;


class AffiliateParametersRequest extends FormRequest
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
        $rules = [
          'planlisting'=>'required',
          'plandetail'=>'required',
          'remarketing'=>'required',
          'slug'=>'required',
          'terms'=>'required',
          'journey' => 'nullable|numeric'
          
        ];  
        
       
        return $rules;
    }

    public function messages()
    {
        return [
            'planlisting.required' => trans('affiliates.planlisting_required'),
            'plandetail.required' => trans('affiliates.plandetail_required'),
            'remarketing.required' => trans('affiliates.remarketing_required'),
            'slug.required' => trans('affiliates.slugrequired'),
            'terms.required' => trans('affiliates.termsrequired'),
            'journey.numeric' => trans('affiliates.journeynumber'),
       ];
    }
}
