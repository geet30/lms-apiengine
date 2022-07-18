<?php

namespace App\Http\Requests\Settings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Crypt;
class StateHolidayRequest extends FormRequest
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
            return [
                'date' => 'required|date',
                'state' => 'required',
                'holiday_title' => 'required|max:50',
                'holiday_content'=>'required|max:500',
            ];
            
		}
		
	
    
}
