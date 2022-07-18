<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;

class ProviderMovin extends FormRequest
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
         $rules = [
             'day_interval_residenced'=>'required',
             'day_interval_bussiness'=>'required',
             'distributor'=>'required',
             'providerid'=>'required',
             'energy_type'=>'required'
         ];
       return $rules;
    }
}
