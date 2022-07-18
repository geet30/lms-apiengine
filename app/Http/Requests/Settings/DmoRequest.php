<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class DmoRequest extends FormRequest
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
        if($request['action_type'] == 'withoutcondtionaldiscount'){
            $rules = [
                'dmo_content'=>'bail|required',
            ];
        }

        if($request['action_type'] == 'withpayontimediscount'){
            $rules = [
                'withpayontimediscount'=>'bail|required',
            ];
        }

        if($request['action_type'] == 'withdirectdebitdiscount'){
            $rules = [
                'withdirectdebitdiscountcontent'=>'bail|required',
            ];
        }

        if($request['action_type'] == 'withbothpayontimeanddirectdebitdiscount'){
            $rules = [
                'withbothpayontimeanddirectdebitdiscount'=>'bail|required',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'dmo_content.required' => trans('settings.dmocontenterror'),
            'withpayontimediscount.required' => trans('settings.dmocontenterror'),
            'withdirectdebitdiscountcontent.required' => trans('settings.dmocontenterror'),
            'withbothpayontimeanddirectdebitdiscount.required' => trans('settings.dmocontenterror'),
        ];
    }
}
