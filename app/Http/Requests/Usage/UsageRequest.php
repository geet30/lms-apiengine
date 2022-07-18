<?php

namespace App\Http\Requests\Usage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use App\Rules\Usage\CheckPostcodes;

class UsageRequest extends FormRequest
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
        if(!empty($request['id'])){
            $rules = [
                'elec_low_range'=>'required',
                'elec_medium_range'=>'required',
                'elec_high_range'=>'required',
                'gas_low_range'=>'required',
                'gas_medium_range'=>'required',
                'gas_high_range'=>'required',
                'post_codes'=>["required",new CheckPostcodes($request['post_codes'])],
            ];
            
        }else{
            $rules = [
                'usage_type'=>'required',
                'state'=>'required',
                'elec_low_range'=>'required',
                'elec_medium_range'=>'required',
                'elec_high_range'=>'required',
                'gas_low_range'=>'required',
                'gas_medium_range'=>'required',
                'gas_high_range'=>'required',
                'post_codes'=>["required",new CheckPostcodes($request['post_codes'])],
            ];
        } 

        return $rules;

    }

    public function messages()
    {
        return [
            'usage_type.required' => trans('usagelimits.usage_type'),
            'state.required' => trans('usagelimits.staterequired'),
            'elec_low_range.required' => trans('usagelimits.elec_low_range'),
            'elec_medium_range.required' => trans('usagelimits.elec_medium_range'),
            'elec_high_range.required' => trans('usagelimits.elec_high_range'),
            'gas_low_range.required' => trans('usagelimits.gas_low_range'),
            'gas_medium_range.required' => trans('usagelimits.gas_medium_range'),
            'gas_high_range.required' => trans('usagelimits.gas_high_range'),
            'post_codes.required' => trans('usagelimits.post_codesrequired'),
       ];
    }
}
