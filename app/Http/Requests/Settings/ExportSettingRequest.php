<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use App\Rules\CheckIpFormat;

class ExportSettingRequest extends FormRequest
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
        $rules=[];
        if($request['request_from'] == 'reset_sale_lead_password'){
            $rules = [
                'reset_sale_export_password'=>'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@^&#%]).*$/',
                'reset_lead_export_password' => 'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@^&#%]).*$/',
                'ips' => [ new CheckIpFormat()]
            ];
        }
        if($request['request_from'] == 'export_setting_direct_debit_form'){
            $rules = [
                'export_setting_direct_debit_password'=>'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@^&#%]).*$/',
                'direct_debit_ips' => [new CheckIpFormat()],
                'export_setting_direct_debit_log_email' => 'required',
                'direct_debit_emails' => 'nullable'
            ];
        }
        if($request['request_from'] == 'export_setting_detokeniztion_form'){
            $rules = [
                'export_setting_detokenization_password'=>'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@^&#%]).*$/',
                'detokenization_ips' => [new CheckIpFormat()],
                'export_setting_detokenization_log_email' => 'required',
                'detokenization_emails' => 'nullable'
              
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'reset_sale_export_password.min' => trans('settings.reset_sale_export_password_min'),
            'reset_sale_export_password.regex' => trans('settings.reset_sale_export_password_regex'),
            'reset_lead_export_password.min' => trans('settings.reset_lead_export_password_min'),
            'reset_lead_export_password.regex' => trans('settings.reset_lead_export_password_regex'),
            'export_setting_direct_debit_password.min' => trans('settings.export_setting_direct_debit_password_min'),
            'export_setting_direct_debit_password.regex' => trans('settings.export_setting_direct_debit_password_regex'),
            'export_setting_detokenization_password.min' => trans('settings.export_setting_detokenization_password_min'),
            'export_setting_detokenization_password.regex' => trans('settings.export_setting_detokenization_password_regex'),
            'export_setting_direct_debit_log_email.required' => trans('settings.export_setting_direct_debit_log_email_required'),
            'export_setting_detokenization_log_email.required' => trans('settings.export_setting_detokenization_log_email_required')
        ];
    }
}
