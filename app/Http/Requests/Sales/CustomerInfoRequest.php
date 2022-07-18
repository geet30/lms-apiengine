<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerInfoRequest extends FormRequest
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
            case 'customer_info_form':
                $rules['first_name'] = ['bail', 'required', 'max:50',"regex:/^(?!\d+$)(?:[a-zA-Z0-9][a-zA-Z0-9 !@#$&'()-`.+]*)?+$/"];
                $rules['middle_name'] = ['nullable','bail', 'max:50',"regex:/^(?!\d+$)(?:[a-zA-Z0-9][a-zA-Z0-9 !@#$&'()-`.+]*)?+$/"];
                $rules['last_name'] = ['bail', 'required', 'max:50',"regex:/^(?!\d+$)(?:[a-zA-Z0-9][a-zA-Z0-9 !@#$&'()-`.+]*)?+$/"];
                $rules['email'] = ['bail', 'required', 'email'];
                $rules['phone'] = ['bail', 'required', 'numeric','digits_between:8,12'];
                $rules['alternate_phone'] = ['nullable','bail','numeric','digits_between:8,12'];
                $rules['dob'] = ['nullable','bail','date'];
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => trans('sale_detail.view.customer.customer_info.first_name.errors.required'),
            'first_name.max' => trans('sale_detail.view.customer.customer_info.first_name.errors.max'),
            'middle_name.max' => trans('sale_detail.view.customer.customer_info.middle_name.errors.max'),
            'last_name.required' => trans('sale_detail.view.customer.customer_info.last_name.errors.required'),
            'last_name.max' => trans('sale_detail.view.customer.customer_info.last_name.errors.max'),
            'email.required' => trans('sale_detail.view.customer.customer_info.email.errors.required'),
            'email.email' => trans('sale_detail.view.customer.customer_info.email.errors.email'),
            'phone.required' => trans('sale_detail.view.customer.customer_info.phone.errors.required'),
            'phone.numeric' => trans('sale_detail.view.customer.customer_info.phone.errors.numeric'),
            'phone.digits_between' => trans('sale_detail.view.customer.customer_info.phone.errors.digits_between'),
            'phone.required' => trans('sale_detail.view.customer.customer_info.phone.errors.required'),
            'alternate_phone.numeric' => trans('sale_detail.view.customer.customer_info.alternate_phone.errors.numeric'),
            'alternate_phone.digits_between' => trans('sale_detail.view.customer.customer_info.alternate_phone.errors.digits_between'),
            'dob.date' => trans('sale_detail.view.customer.customer_info.dob.errors.date'),
        ];
    }
}
