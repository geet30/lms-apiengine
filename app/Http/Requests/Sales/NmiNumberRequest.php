<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class NmiNumberRequest extends FormRequest
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
            case 'nmi_number_form':
                $rules['nmi_number'] = ['nullable','bail','gt:-1','digits_between:10,11'];
                $rules['dpi_mirn_number'] = ['nullable','bail','gt:-1','digits_between:10,11'];
                $rules['meter_number_e'] = ['nullable','bail', 'alpha_num', 'max:10'];
                $rules['meter_number_g'] = ['nullable','bail', 'alpha_num', 'max:10'];
                $rules['electricity_network_code'] = ['nullable','bail', 'string','max:30'];
                $rules['gas_network_code'] = ['nullable','bail', 'string','max:30'];
                $rules['gas_code'] = ['nullable','bail', 'string','max:30'];
                $rules['electricity_code'] = ['nullable','bail', 'string','max:30'];
                $rules['tariff_type'] = ['nullable','bail', 'string','max:500'];
                $rules['tariff_list'] = ['nullable','bail', 'string','max:500'];
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'nmi_number.gt'=>'Only positive values allowed.',
            'nmi_number.digits_between'=>'NMI Number must be between 10 to 11 digits.',
            'dpi_mirn_number.gt'=>'Only positive values allowed.',
            'dpi_mirn_number.digits_between'=>'DPI MIRN Number must be between 10 to 11 digits.',
            'meter_number_e.max' => "Meter Number Electricity exceeding max length 10",
            'meter_number_e.alpha_num' => "Meter Number Electricity must contain letters and numbers only",
            'meter_number_g.max' => "Meter Number Gas exceeding max length 10",
            'meter_number_g.alpha_num' => "Meter Number Gas must contain letters and numbers only",
            'tariff_type.max' => 'Tariff Type exceeding max length 500',
            'tariff_list.max' => 'Tariff Type exceeding max length 500',
            'electricity_network_code.max' => 'Electricity Network Code exceeding max length 30',
            'electricity_code.max' => 'Electricity Code exceeding max length 30',
            'gas_network_code.max' => 'Gas Network Code exceeding max length 30',
            'gas_code.max' => 'Gas Code exceeding max length 30',
        ];
    }
}
