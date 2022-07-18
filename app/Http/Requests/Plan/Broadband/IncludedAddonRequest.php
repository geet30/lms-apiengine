<?php

namespace App\Http\Requests\Plan\Broadband;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;

class IncludedAddonRequest extends FormRequest
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
        $request =  Request::all();
        $rules = [
            'status' => 'required',
            'addon_id' => 'required_if:status,1',
            'is_mandatory' => 'required_if:status,1',
        ]; 
        if(isset($request['status']) && $request['status'] == 1)
        {
            $rules['price'] = 'bail|required_if:category,4,5|numeric|gte:0';
            $rules['cost_type_id'] = 'bail|required_if:category,4,5'; 
        }
        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $request =  Request::all();
        $messages = [
                    'status.required' => trans('plans/broadband.calling_plan_status.validation.required'),
                    'addon_id.required_if' => trans('plans/broadband.home_plan_included_name.validation.required'),
                    'price.numeric' => trans('plans/broadband.other_addon_cost.validation.numeric')
                    ];
        if($request['category'] == 4)
        {
            $messages['addon_id.required_if'] = trans('plans/broadband.included_modem.validation.required');
            $messages['price.gte'] = trans('plans/broadband.modem_cost.validation.gt');
            $messages['price.required_if'] = trans('plans/broadband.modem_cost.validation.required');
            $messages['cost_type_id.required_if'] = trans('plans/broadband.modem_cost_type.validation.required');
        }
        else if($request['category'] == 5)
        {
            $messages['addon_id.required_if'] = trans('plans/broadband.other_addon.validation.required');
            $messages['price.gte'] = trans('plans/broadband.other_addon_cost.validation.gt');
            $messages['price.required_if'] = trans('plans/broadband.other_addon_cost.validation.required');
            $messages['cost_type_id.required_if'] = trans('plans/broadband.other_addon_cost_type.validation.required');
        } 
        return $messages;
    }
}
