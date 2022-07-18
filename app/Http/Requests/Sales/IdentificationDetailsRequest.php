<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class IdentificationDetailsRequest extends FormRequest
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
        $rules=[];
        $request = Request::all();
        if(!empty($request['form_name']) && $request['form_name']=='table_primary_edit_form'){
           $rules=[
               'primary_identification_type'=>'required',
               'primary_comment' => 'max:500'
           ];
           if(in_array($request['primary_identification_type'],['DL', 'Drivers Licence'])){
               $rules['primary_licence_state']='required';
               $rules['primary_licence_number']= 'required';
               $rules['primary_lice_id_exp_date']='required| after:'.date('Y-m-d');
           }elseif(in_array($request['primary_identification_type'],['Foreign Passport'])){
                $rules['primary_foreign_passport_number']='required';
                $rules['primary_foreign_country_name']= 'required';
                $rules['primary_foreign_country_code']='required';
                $rules['primary_foreign_passport_expiry_date']='required| after:'.date('Y-m-d');
           }elseif(in_array($request['primary_identification_type'],['Passport'])){
                $rules['primary_passport_number']='required';
                $rules['primary_passport_exp_date']='required|after:'.date('Y-m-d');

           }elseif(in_array($request['primary_identification_type'],['Medicare Card'])){
                $rules['primary_medicare_number']='required|numeric|digits:10';
                $rules['primary_medicare_ref_num'] = 'required|numeric';
                $rules['primary_medicare_card_middle_name'] = 'required|max:100';
                $rules['primary_medicare_card_color']= 'required';
                $rules['primary_medicare_card_expiry_date'] = 'required| after:'.date('Y-m-d');
           }
          
        }
       
        elseif(!empty($request['form_name']) && $request['form_name']=='table_secondary_edit_form'){
            $rules=[
                'secondary_identification_type'=>'required',
                'secondary_comment' => 'max:500'
            ];
            if(in_array($request['secondary_identification_type'],['DL', 'Drivers Licence'])){
                $rules['secondary_licence_state']='required';
                $rules['secondary_licence_number']= 'required';
                $rules['secondary_lice_id_exp_date']='required| after:'.date('Y-m-d');
            }elseif(in_array($request['secondary_identification_type'],['Foreign Passport'])){
                 $rules['secondary_foreign_passport_number']='required';
                 $rules['secondary_foreign_country_name']= 'required';
                 $rules['secondary_foreign_country_code']='required';
                 $rules['secondary_foreign_passport_expiry_date']='required| after:'.date('Y-m-d');
        
            }elseif(in_array($request['secondary_identification_type'],['Passport'])){
                 $rules['secondary_passport_number']='required';
                 $rules['secondary_passport_exp_date']='required| after:'.date('Y-m-d');
        
            }elseif(in_array($request['secondary_identification_type'],['Medicare Card'])){
                 $rules['secondary_medicare_number']='required|numeric|digits:10';
                 $rules['secondary_medicare_ref_num'] = 'required|numeric|digits:1';
                 $rules['secondary_medicare_card_middle_name'] = 'required';
                 $rules['secondary_medicare_card_color']= 'required';
                 $rules['secondary_medicare_card_expiry_date'] = 'required| after:'.date('Y-m-d');
            }
          
         }
         return $rules;
       
        
       

    }

    public function messages()
    {
       
     return[
            'primary_identification_type.required' =>'Please Select Identity Type',
            'primary_comment.max' => 'Comment must be less than 500 characters',
            'primary_licence_state.required' =>'State is required',
            'primary_licence_number.required' => 'Licence Number is required',
            'primary_lice_id_exp_date.required' => 'Expiry Date is required',
            'primary_lice_id_exp_date.after' => 'Please enter a valid date',
            'primary_foreign_passport_number.required' =>'Foreign Passport Number is required',
            'primary_foreign_country_name.required' => 'Please Select Country',
            'primary_foreign_country_code.required' => 'Country Code is required',
            'primary_foreign_passport_expiry_date.required' => 'Passport Expiry Date is required',
            'primary_foreign_passport_expiry_date.after' => 'Please enter a valid date',
            'primary_passport_number.required' => 'Passport Number is required',
            'primary_passport_exp_date.required' => 'Passport Expiry Date is required',
            'primary_passport_exp_date.after' => 'Please enter a valid date',
            'primary_medicare_number.required' => 'Medicare Card Number is required',
            'primary_medicare_number.numeric' => 'The medicare card number must be a number.',
            'primary_medicare_number.digits' => 'The medicare card number must be 10 digits.',
            'primary_medicare_ref_num.required' => 'Reference Number is required',
            'primary_medicare_ref_num.numeric' => 'Please Enter Valid Reference Number',
            'primary_medicare_card_middle_name.required' => 'Please Enter Middle Name on Card',
            'primary_medicare_card_middle_name.max' => 'Maximum 100 Chracters are Allowed',
            'primary_medicare_card_expiry_date.required' => 'Card Expiry Date is required',
            'primary_medicare_card_expiry_date.after' => 'Please enter a valid date',
            'primary_medicare_card_color.required' => 'Please Select Card Color',
            'secondary_identification_type.required' =>'Please Select Identity Type',
            'secondary_comment.max' => 'Comment must be less than 500 characters',
            'secondary_licence_state.required' =>'State is required',
            'secondary_licence_number.required' => 'Licence Number is required',
            'secondary_lice_id_exp_date.required' => 'Expiry Date is required',
            'secondary_lice_id_exp_date.after' => 'Please enter a valid date',
            'secondary_foreign_passport_number.required' =>'Foreign Passport Number is required',
            'secondary_foreign_country_name.required' => 'Please Select Country',
            'secondary_foreign_country_code.required' => 'Country Code is required',
            'secondary_foreign_passport_expiry_date.required' => 'Passport Expiry Date is required',
            'secondary_foreign_passport_expiry_date.after' => 'Please enter a valid date',
            'secondary_passport_number.required' => 'Passport Number is required',
            'secondary_passport_exp_date.required' => 'Passport Expiry Date is required',
            'secondary_passport_exp_date.after' => 'Please enter a valid date',
            'secondary_medicare_number.required' => 'Medicare Card Number is required',
            'secondary_medicare_number.numeric' => 'The medicare card number must be a number.',
            'secondary_medicare_number.digits' => 'The medicare card number must be 10 digits.',
            'secondary_medicare_ref_num.required' => 'Reference Number is required',
            'secondary_medicare_ref_num.numeric' => 'Please Enter Valid Reference Number',
            'secondary_medicare_card_middle_name.required' => 'Please Enter Middle Name on Card',
            'secondary_medicare_card_middle_name.max' => 'Maximum 100 Chracters are Allowed',
            'secondary_medicare_card_expiry_date.required' => 'Card Expiry Date is required',
            'secondary_medicare_card_expiry_date.after' => 'Please enter a valid date',
            'secondary_medicare_card_color.required' => 'Please Select Card Color'

            
            

        ];
            

              
            
               
       
       
    }
}
