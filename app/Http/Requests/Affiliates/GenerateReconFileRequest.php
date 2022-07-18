<?php

namespace App\Http\Requests\Affiliates;
use Illuminate\Foundation\Http\FormRequest;
class GenerateReconFileRequest extends FormRequest
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
                'selected_month' => 'required',
                'generate_monthrecon_checkbox' => 'required'
            ];
            
		}
	
    
}
