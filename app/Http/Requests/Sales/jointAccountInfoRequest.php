<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class jointAccountInfoRequest extends FormRequest
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
        $rules = [
                    'joint_account_title' => 'required',
                    'joint_account_dob' => 'date|required',
                    'joint_account_first_name' => 'required|regex:/^[A-Za-z\W_]+$/|min:2|max:50',
                    'joint_account_last_name' => 'required|regex:/^[A-Za-z\W_]+$/|min:2|max:50',
                    'joint_account_email' => 'required|email',
                    'joint_account_phone' => 'required|numeric|digits_between:5,10',
                    'joint_account_home_phone' => 'numeric|digits_between:5,12',
                    'joint_account_office_phone' => 'numeric|digits_between:5,12'
        ];
       
        return $rules;
    }

    public function messages()
    {
        return [
           
            'joint_account_title.required' => 'The title field is required.',
            'joint_account_dob.required' => 'The dob field is required.',
            'joint_account_dob.date' => 'The dob field should be date.',

            'joint_account_first_name.required' => 'Please enter first name.',
            'joint_account_first_name.regex' => 'First name should not contain numbers.',
            'joint_account_first_name.min' => 'Minimum two characters are required.',
            'joint_account_first_name.max' => 'Maximum 50 characters are allowed.',

            'joint_account_last_name.required' => 'Please enter last name.',
            'joint_account_last_name.regex' => 'Last name should not contain numbers.',
            'joint_account_last_name.min' => 'Minimum two characters are required.',
            'joint_account_last_name.max' => 'Maximum 50 characters are allowed.',

            'joint_account_email.required' => 'Please enter email address.',
            'joint_account_email.email' => 'Please enter a valid Email address.',
            'joint_account_phone.required' => 'Please enter phone number.',
            'joint_account_phone.digits_between' => 'The phone no must be 10 digits.',
            'joint_account_phone.regex' => 'The phone no format is invalid.',
            'joint_account_phone.numeric' => 'The phone no must be a number.',

            'joint_account_home_phone.required' => 'Please enter home phone number.',
            'joint_account_home_phone.digits_between' => 'The home phone no must be between 5 and 12 digits.',
            'joint_account_home_phone.regex' => 'The home phone no format is invalid.',
            'joint_account_home_phone.numeric' => 'The home phone no must be a number.',

            'joint_account_office_phone.required' => 'Please enter office phone number.',
            'joint_account_office_phone.digits_between' => 'The office phone no must be between 5 and 12 digits.',
            'joint_account_office_phone.regex' => 'The office phone no format is invalid.',
            'joint_account_office_phone.numeric' => 'The office phone no must be a number.',
        ];
    }
}
