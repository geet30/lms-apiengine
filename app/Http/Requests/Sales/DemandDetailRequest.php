<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DemandDetailRequest extends FormRequest
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
            case 'demand_details_form':
                if ($this->request->get('demand_tariff') == 0) {
                    $rules = [];
                    break;
                }
                $rules = [
                    'demand_usage_type' => 'bail|required|in:1,2',
                    'demand_tariff_code' => 'bail|required',
                    'demand_meter_type' => 'bail|required|in:1,2',
                    'demand_rate1_peak_usage' => 'bail|required|numeric|max:999999|gt:-1',
                    'demand_rate1_off_peak_usage' => 'nullable|numeric|max:999999|gt:-1',
                    'demand_rate1_shoulder_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                    'demand_rate2_peak_usage' => 'nullable|numeric|max:999999|gt:-1',
                    'demand_rate2_off_peak_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                    'demand_rate2_shoulder_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                    'demand_rate3_peak_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                    'demand_rate3_off_peak_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                    'demand_rate3_shoulder_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                    'demand_rate4_peak_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                    'demand_rate4_off_peak_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                    'demand_rate4_shoulder_usage' => 'bail|nullable|numeric|max:999999|gt:-1',
                ];
                $unitTypes = $this->request->get('demand_usage_type');
                if ($unitTypes == 1) {
                    $rules['demand_rate1_days'] = 'bail|nullable|integer|max:999|gt:-1';
                    $rules['demand_rate2_days'] = 'bail|nullable|integer|max:999|gt:-1';
                    $rules['demand_rate3_days'] = 'bail|nullable|integer|max:999|gt:-1';
                    $rules['demand_rate4_days'] = 'bail|nullable|integer|max:999|gt:-1';
                } else {
                    $rules['demand_rate1_days'] = 'nullable|bail|required_with:demand_rate2_peak_usage,demand_rate3_peak_usage,demand_rate4_peak_usage|integer|max:999|gt:-1';
                    $rules['demand_rate2_days'] = 'nullable|bail|required_with:demand_rate2_peak_usage|integer|max:999|gt:-1';
                    $rules['demand_rate3_days'] = 'nullable|bail|required_with:demand_rate3_peak_usage|integer|max:999|gt:-1';
                    $rules['demand_rate4_days'] = 'nullable|bail|required_with:demand_rate4_peak_usage|integer|max:999|gt:-1';
                }
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'demand_usage_type.required' => 'Please Enter Demand Usage Type',
            'demand_rate1_peak_usage.required' => 'Please Enter Demand Rate 1 Peak.',
            'demand_rate1_days.required_with' => 'Please Enter demand rate 1 days.',
            'demand_rate2_days.required_with' => 'Please Enter demand rate 2 days.',
            'demand_rate3_days.required_with' => 'Please Enter demand rate 3 days.',
            'demand_rate4_days.required_with' => 'Please Enter demand rate 4 days.',
            'demand_rate1_peak_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate1_off_peak_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate1_shoulder_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate2_peak_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate2_off_peak_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate2_shoulder_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate3_peak_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate3_off_peak_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate3_shoulder_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate4_peak_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate4_off_peak_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate4_shoulder_usage.numeric' => 'Only numeric values allowed.',
            'demand_rate1_days.integer' => 'Only integer values allowed.',
            'demand_rate2_days.integer' => 'Only integer values allowed.',
            'demand_rate3_days.integer' => 'Only integer values allowed.',
            'demand_rate4_days.integer' => 'Only integer values allowed.',
            'demand_rate1_peak_usage.max'=>'Demand Rate 1 Peak exceeding max value 999999.',
            'demand_rate2_peak_usage.max'=>'Demand Rate 2 Peak exceeding max value 999999.',
            'demand_rate3_peak_usage.max'=>'Demand Rate 3 Peak exceeding max value 999999.',
            'demand_rate4_peak_usage.max'=>'Demand Rate 4 Peak exceeding max value 999999.',
            'demand_rate1_off_peak_usage.max'=>'Demand Rate 1 Off Peak exceeding max value 999999.',
            'demand_rate2_off_peak_usage.max'=>'Demand Rate 2 Off Peak exceeding max value 999999.',
            'demand_rate3_off_peak_usage.max'=>'Demand Rate 3 Off Peak exceeding max value 999999.',
            'demand_rate4_off_peak_usage.max'=>'Demand Rate 4 Off Peak exceeding max value 999999.',
            'demand_rate1_shoulder_usage.max'=>'Demand Rate 1 Shoulder exceeding max value 999999.',
            'demand_rate2_shoulder_usage.max'=>'Demand Rate 2 Shoulder exceeding max value 999999.',
            'demand_rate3_shoulder_usage.max'=>'Demand Rate 3 Shoulder exceeding max value 999999.',
            'demand_rate4_shoulder_usage.max'=>'Demand Rate 4 Shoulder exceeding max value 999999.',
            'demand_rate1_days.max'=>'Demand Rate 1 Days exceeding max value 999.',
            'demand_rate2_days.max'=>'Demand Rate 2 Days exceeding max value 999.',
            'demand_rate3_days.max'=>'Demand Rate 3 Days exceeding max value 999.',
            'demand_rate4_days.max'=>'Demand Rate 4 Days exceeding max value 999.',
            'demand_rate1_peak_usage.gt'=>'Only positive values allowed.',
            'demand_rate2_peak_usage.gt'=>'Only positive values allowed.',
            'demand_rate3_peak_usage.gt'=>'Only positive values allowed.',
            'demand_rate4_peak_usage.gt'=>'Only positive values allowed.',
            'demand_rate1_off_peak_usage.gt'=>'Only positive values allowed.',
            'demand_rate2_off_peak_usage.gt'=>'Only positive values allowed.',
            'demand_rate3_off_peak_usage.gt'=>'Only positive values allowed.',
            'demand_rate4_off_peak_usage.gt'=>'Only positive values allowed.',
            'demand_rate1_shoulder_usage.gt'=>'Only positive values allowed.',
            'demand_rate2_shoulder_usage.gt'=>'Only positive values allowed.',
            'demand_rate3_shoulder_usage.gt'=>'Only positive values allowed.',
            'demand_rate4_shoulder_usage.gt'=>'Only positive values allowed.',
            'demand_rate1_days.gt'=>'Only positive values allowed.',
            'demand_rate2_days.gt'=>'Only positive values allowed.',
            'demand_rate3_days.gt'=>'Only positive values allowed.',
            'demand_rate4_days.gt'=>'Only positive values allowed.',
        ];
    }
}
