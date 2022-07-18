<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SiteAccessInfoRequest extends FormRequest
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
            case 'site_access_info_form':
                $rules['meter_hazard'] = ['nullable','bail','string','max:60'];
                $rules['dog_code'] = ['nullable','bail','string','max:60'];
                $rules['site_access_electricity'] = ['nullable','bail','min:1','max:60'];
                $rules['site_access_gas'] = ['nullable','bail','min:1','max:60'];
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
           
            'meter_hazard.max' => 'Meter Hazard exceeding max length 60',
            'dog_code.max' => 'Dog Code exceeding max length 60',
            'site_access_electricity.min' => 'Minimum 2 characters are required',
            'site_access_electricity.max' => 'Maximum 60 characters are allowed',
            'site_access_gas.min' => 'Minimum 2 characters are required',
            'site_access_gas.max' => 'Maximum 60 characters are allowed',
        ];
    }
}
