<?php

namespace App\Http\Requests\Settings;
use Illuminate\Foundation\Http\FormRequest;
class WeekContentRequest extends FormRequest
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
                'holiday_title' => 'required|max:50',
                'holiday_content'=>'required|max:500',
            ];
            
		}
		
	
    
}
