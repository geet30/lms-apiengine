<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use App\Rules\Providers\TextBoxLengthCheck;

class CheckboxRequest extends FormRequest
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
    $rules = [];
    if ($request['form_name'] == "terms_condition_checkbox_form") {
      $rules = [
        "terms_checkbox_required"   =>   ['required'],
        "terms_condition_validates" =>   ['required_if:terms_checkbox_required,1'],
        "term_checkbox_status_save" =>   ['required'],
        "provider_id"               =>   ['required'],
        "terms_checkbox_content"    =>   ['required'],
        "order"                     => ['required','integer','min:1'],
        "type"                      =>   ['required'],
      ];
    }
    if ($request['form_name'] == "provider_ackn_checkbox_formm") {
      $rules = [
        // "ackn_checkbox_status_save" =>   ['required'],
        // "ackn_checkbox_required"    =>   ['required'],
        "ackn_validation_msg"       =>   ['required_if:ackn_checkbox_required,1'],
        "provider_id"               =>   ['required'],
        "order"                                  => ['required','integer','min:1'],
        "ackn_checkbox_content"     =>   ['required']

      ];
    }
    if ($request['form_name'] == "tele_sale_setting_checkbox_form") {
      $rules = [
        "tele_sale_setting_checkbox_content"     => ['required'],
        "tele_sale_setting_checkbox_required"    => ['required'],
        "tele_sale_setting_validation_msg"       => ['required_if:tele_sale_setting_checkbox_required,1'],
        "tele_sale_setting_checkbox_save_status" => ['required'],
        "tele_select_eic_type"                   => ['required'],
        "order"                                  => ['required','integer','min:1'],
        "provider_id"                            => ['required'],
      ];
    }

    if ($request['form_name'] == "state_checkbox_form") {
      $rules = [
        "state_eic_content_checkbox_content"     => ['required'],
        "state_eic_content_checkbox_required"    => ['required'],
        "state_eic_content_validation_msg"       => ['required_if:state_eic_content_checkbox_required,1'],
        "state_eic_content_checkbox_save_status" => ['required'],
        "statewise_select_eic_type"              => ['required'],
        "order"                                  => ['required','integer','min:1'],
        "provider_id"                            => ['required'],
        'state'                                  => ['required'],
      ];
    }
    if ($request['form_name'] == "master_checkbox_form") {
      $rules = [
        "state_eic_content_checkbox_content"     => ['required'],
        "state_eic_content_checkbox_required"    => ['required'],
        "state_eic_content_validation_msg"       => ['required_if:state_eic_content_checkbox_required,1'],
        "state_eic_content_checkbox_save_status" => ['required'],
        "statewise_select_eic_type"              => ['required'],
        "order"                                  => ['required','integer','min:1'],
        "provider_id"                            => ['required'],
        'state'                                  => ['required'],
      ];
    }
    if ($request['form_name'] == "debit_checkbox_form") {
      $rules = [
        "debit_checkbox_required" => ['required'],
        "debit_checkbox_content"  => ['required'],
        "debit_validation_msg"    => ['required_if:debit_checkbox_required,1'],
        "debit_info_type"         => ['required'],
        "provider_id"             => ['required'],
        "order"                   => ['required','integer','min:1'],
      ];
    }
    if($request['form_name'] == "post_submission_checkbox_form"){
      $rules=[
        'post_submission_checkbox_required' => ['required'],
        'post_submission_validation_msg' => ['required_if:post_submission_checkbox_required,1'],
        'post_submission_checkbox_content' => ['required'],
        "order"                   => ['required','integer','min:1'],
      ];
    }

    if($request['form_name'] == "plan_permission_checkbox_form"){
      $rules=[
        'plan_permission_checkbox_required' => ['required'],
        'provider_permission_validation_msg' => ['required_if:plan_permission_checkbox_required,1'],
        'plan_permission_checkbox_content' => ['required'],
        'plan_select_connection_type' => ['required'],
        "order"                   => ['required','integer','min:1'],
      ];
    }
    return $rules;
  }
  public function messages(){
    return [
      'statewise_select_eic_type.required' => trans('providers.statewise_select_eic_type'),
      'state_eic_content_checkbox_content.required' => trans('providers.state_eic_content_checkbox_content'),
      'ackn_validation_msg.required_if'=>trans('providers.acknowledgement_msg_required'),
      'ackn_checkbox_content.required' => trans('providers.acknowledgement_checkbox_content_required'),
      'ackn_checkbox_content.max' => trans('providers.acknowledgement_checkbox_content_length'),
      'debit_checkbox_content.required' =>trans('providers.debit_checkbox_content_required'),
      'debit_validation_msg.required_if' => trans('providers.debit_validation_msg_required'),
      'ackn_checkbox_status_save.required'=>trans('providers.acknowledgment_checkbox_status_required'),
      'ackn_checkbox_required.required'=>trans('providers.acknowledgment_checkbox_database_status_required'),
      
      'state_eic_content_validation_msg.required_if' => trans('providers.state_eic_content_validation_msg_required'),
      'tele_sale_setting_validation_msg.required_if' => trans('providers.tele_sale_validation_msg_required'),
      'debit_info_type.required' => trans('providers.debit_info_type_required'),
      'post_submission_validation_msg.required_if' =>trans('providers.post_submission_checkbox_validation_required'),
      'post_submission_checkbox_content.required' => trans('providers.post_submission_checkbox_content_required'),
      'plan_permission_checkbox_required.required' => trans('providers.permission_checkbox_required'),
      'provider_permission_validation_msg.required_if' => trans('providers.permission_checkbox_validation_message_required'),
      'plan_permission_checkbox_content.required' => trans('providers.permission_checkbox_content_required'),
      'plan_select_connection_type.required' => trans('providers.permission_connection_type_required')      
    ];
  }
}
