<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\User\UniqueEmailCustom;
use Illuminate\Http\Request; 
class AddAffiliateBdmUser extends FormRequest
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
        if(Request::Input('update') != 'status'){
            return [
                'first_name' => ['required','min:2','max:100'], 
                'last_name' => ['required','min:2','max:100'], 
                'service' => ['required'], 
                'phone' =>['nullable','bail','numeric','digits:10'],
                'email' => ['required','email','max:100',new UniqueEmailCustom($request)],
            ];
        }
        else{
            return [];
        } 
    }
}
