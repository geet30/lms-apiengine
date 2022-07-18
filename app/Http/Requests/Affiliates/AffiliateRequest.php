<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use App\Rules\Affiliates\UniqueEmailCustom;
use Illuminate\Validation\Rules\Password;

class AffiliateRequest extends FormRequest
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
        if($request['request_from'] == 'affiliate_basic_detail_form'){
            if(empty($request['id'])){

                $rules = [
                    'first_name'=>"bail|required|string|max:25",
                    'last_name'=>"bail|required|string|max:25",
                    'email'=>["required","regex:/(.+)@(.+)\.(.+)/i",new UniqueEmailCustom($request)],
                    'phone'=>'bail|required|numeric|digits_between:8,12',
                    'company_name'=>["bail","required","max:50"],
                    'legal_name'=>["required","string"],
                    'sender_id'=>"required|min:6|max:11|string",
                    'support_phone_number'=>'bail|required|numeric|digits_between:8,12',
                    'show_agent_portal' => 'required',
                    'company_address'=>'bail|required|max:200',
                ];

            }else{
                $rules = [
                    'first_name'=>"bail|required|string|max:25",
                    'last_name'=>"bail|required|string|max:25",
                    'email'=>["required","regex:/(.+)@(.+)\.(.+)/i",new UniqueEmailCustom($request)],
                    'phone'=>'bail|required|numeric|digits_between:8,12',
                    'company_name'=>["bail","required","max:50"],
                    'legal_name'=>["required","string"],
                    'sender_id'=>"required|min:6|max:11|string",
                    'support_phone_number'=>'bail|required|numeric|digits_between:8,12',
                    'show_agent_portal' => 'required',
                    'company_address'=>'bail|required|max:200',
                ];
            }


        }

        if($request['request_from'] == 'subaffiliate_basic_detail_form'){
            if(empty($request['id'])){
                $rules = [
                    'first_name'=>"bail|required|string|max:25",
                    'last_name'=>"bail|required|string|max:25",
                    'email'=>["required","regex:/(.+)@(.+)\.(.+)/i",new UniqueEmailCustom($request)],
                    'phone'=>'bail|required|numeric|digits_between:8,12',
                    'company_name'=>["bail","required","max:50"],
                    'company_address'=>'bail|required|max:200',
                    'show_agent_portal' => 'required',
                    'referral_code_url'=>'bail|required|url',
                    'referral_code_title'=>'bail|required|max:200',
                    'sub_affiliate_type' => 'required',
                ];

            }else{
                $rules = [
                    'first_name'=>"bail|required|string|max:25",
                    'last_name'=>"bail|required|string|max:25",
                    'email'=>["required","regex:/(.+)@(.+)\.(.+)/i",new UniqueEmailCustom($request)],
                    'phone'=>'bail|required|numeric|digits_between:8,12',
                    'company_name'=>["bail","required","max:50"],
                    'company_address'=>'bail|required|max:200',
                    'show_agent_portal' => 'required',
                    'referral_code_url'=>'bail|required|url',
                    'referral_code_title'=>'bail|required|max:200',
                    'sub_affiliate_type' => 'required',
                ];
            }

        }

        if($request['request_from'] == 'affiliate_logo_form'){
            $rules = [
                'logo'=>'bail|required|mimes:png|dimensions:width=300,height=130',
            ];
        }

        if($request['request_from'] == 'affiliate_bank_detail_form'){
            $rules = [
                'account_number'=>'bail|required|numeric|digits_between:1,30',
                'account_holder_name'=>"bail|required|string|max:50",
                'abn'=>'bail|required|numeric',
                'bsb_code'=>'bail|required|numeric|digits:6',
            ];
        }

        if($request['request_from'] == 'affiliate_social_links_form'){
        $rules = [
                'dedicated_page'=>'bail|required|url',
                'facebook_url'=>'nullable|url',
                'twitter_url'=>'nullable|url',
                'instagram_url'=>'nullable|url',
                'youtube_url'=>'nullable|url',
                'linkedin_url'=>'nullable|url',
                'google_plus_url'=>'nullable|url',
            ];
        }

        if($request['request_from'] == 'affiliate_additional_feature_form'){

            $rules = [
              'lead_data_in_cookie'=>'bail|required|numeric|between :0,500|regex:/^[0-9]+$/',
              'lead_ownership_days_interval'=>'bail|required|numeric|between :0,500|regex:/^[0-9]+$/',
              'lead_export_password' => ['nullable',Password::min(8),'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@^&#%]).*$/'],
              'sale_export_password' => ['nullable',Password::min(8),'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@^&#%]).*$/'],
            ];
        }

        if($request['request_from'] == 'affiliate_spark_post_feature_form'){
            $rules = [
              'affiliate_sparkpostkey'=>'bail|required',

            ];
        }

        if($request['request_from'] == 'affiliate_life_support_content_form'){
            $rules = [
              'content'=>'bail|required|string',

            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'service.required' => trans('affiliates.service_required'),
            'first_name.required' => trans('affiliates.first_name_required'),
            'last_name.required' => trans('affiliates.last_name_required'),
            'email.unique' => trans('affiliates.email_unique'),
            'email.required' => trans('affiliates.email_required'),

            'phone.required' => trans('affiliates.phone_required'),
            'phone.integer' => trans('affiliates.phone_integer'),
            'phone.numeric' => trans('affiliates.phone_integer'),
            'phone.digits_between' => trans('affiliates.phone_digits_between'),

            'company_name.required' => trans('affiliates.company_name_required'),
            'legal_name.required' => trans('affiliates.legal_name_required'),
            'sender_id.required' => trans('affiliates.sender_id_required'),
            'lead_export_password.min' => trans('affiliates.lead_export_password_min'),
            'lead_export_password.regex' => trans('affiliates.lead_export_password_regex'),
            'sale_export_password.min' => trans('affiliates.sale_export_password_min'),
            'sale_export_password.regex' => trans('affiliates.sale_export_password_regex'),
            'show_agent_portal.required' => trans('affiliates.show_agent_portal_required'),
            'company_address.required' => trans('affiliates.company_address_required'),


            'support_phone_number.required' => trans('affiliates.support_phone_number_required'),
            'support_phone_number.integer' => trans('affiliates.support_phone_number_integer'),
            'support_phone_number.numeric' => trans('affiliates.support_phone_number_integer'),
            'support_phone_number.digits_between' => trans('affiliates.support_phone_number_digits_between'),

            'logo.required' => trans('affiliates.logo_required'),
            'logo.dimensions' => trans('affiliates.logo_dimensions'),

            'dedicated_page.required' => trans('affiliates.dedicated_page_required'),
            'dedicated_page.url' => trans('affiliates.dedicated_page_url'),

            'lead_data_in_cookie.required' => trans('affiliates.lead_data_in_cookie_required'),
            'lead_data_in_cookie.numeric' => trans('affiliates.lead_data_in_cookie_numeric'),
            'lead_data_in_cookie.between' => trans('affiliates.lead_data_in_cookie_between'),
            'lead_data_in_cookie.regex' => trans('affiliates.lead_data_in_cookie_numeric'),

            'lead_ownership_days_interval.required' => trans('affiliates.lead_ownership_days_interval_required'),
            'lead_ownership_days_interval.numeric' => trans('affiliates.lead_ownership_days_interval_numeric'),
            'lead_ownership_days_interval.between' => trans('affiliates.lead_ownership_days_interval_between'),
            'lead_ownership_days_interval.regex' => trans('affiliates.lead_ownership_days_interval_numeric'),

            'referral_code_url.required' => trans('affiliates.referral_code_url_required'),
            'referral_code_url.url' => trans('affiliates.referral_code_url_url'),
            'referral_code_title.required' => trans('affiliates.referral_code_title_required'),
            'affiliate_sparkpostkey.required' => trans('affiliates.sparkpostkeyrequired'),

            'facebook_url.url' => trans('affiliates.facebook_url_url'),
            'twitter_url.url' => trans('affiliates.twitter_url_url'),
            'instagram_url.url' => trans('affiliates.instagram_url_url'),
            'youtube_url.url' => trans('affiliates.youtube_url_url'),
            'linkedin_url.url' => trans('affiliates.linkedin_url_url'),
            'google_plus_url.url' => trans('affiliates.google_plus_url'),
       ];
    }
}
