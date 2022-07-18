<div class="tab-pane fade" id="inclusions" role="tab-panel">

    <div class="card mb-5 mb-xl-10">
            <!-- National Inclusion -->
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#plan_information_section">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.planInformation.sectionTitle')}}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <div id="plan_information_section" class="collapse show">
                <!--begin::Form-->
                <form id="plan_information_form" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.planInformation.planDetail.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <textarea name="details" id="details" class="form-control form-control-lg form-control-solid ckeditor" placeholder="e.g. This service has a 1-month minimum term.">{{isset($plan)?$plan->details:''}}</textarea>
                                <span class="text-danger errors" id="details_error"></span>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.planInformation.extraFacilities.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <textarea name="amazing_extra_facilities" id="amazing_extra_facilities" placeholder="e.g. All SMS and calls within Australia" class="form-control form-control-lg form-control-solid ckeditor" >{{isset($plan) ? $plan->amazing_extra_facilities : ''}}</textarea>
                                <span class="text-danger errors" id="amazing_extra_facilities_error"></span>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-primary submit_btn" id="plan_information_form_submit_btn" data-form="plan_information_form" data-title="Plan Information">{{ __ ('mobile.formPage.planInformation.submitButton')}}</button>
                        <a href="{{url('/provider/plans/mobile/'.$providerId)}}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('mobile.formPage.planInformation.cancelButton')}}</a>
                    </div>
                </form>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!-- End National Inclusion -->
    </div>
    <div class="card mb-5 mb-xl-10">
        <!-- National Inclusion -->
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#national_inclusion_section">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.nationalInclusion.sectionTitle')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="national_inclusion_section" class="collapse show">
            <!--begin::Form-->
            <form id="plan_national_inclusion_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_voice_calls.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_voice_calls" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_voice_calls.placeHolder')}}" value="{{isset($plan)?$plan->national_voice_calls:''}}" />
                            <span class="text-danger errors" id="national_voice_calls_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_video_calls.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_video_calls" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_video_calls.placeHolder')}}" value="{{isset($plan)?$plan->national_video_calls:''}}" />
                            <span class="text-danger errors" id="national_video_calls_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_text.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_text.placeHolder')}}" value="{{isset($plan)?$plan->national_text:''}}" />
                            <span class="text-danger errors" id="national_text_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_mms.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_mms" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_mms.placeHolder')}}" value="{{isset($plan)?$plan->national_mms:''}}" />
                            <span class="text-danger errors" id="national_mms_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_directory_assist.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_directory_assist" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_directory_assist.placeHolder')}} Assistance" value="{{isset($plan)?$plan->national_directory_assist:''}}" />
                            <span class="text-danger errors" id="national_directory_assist_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_diversion.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_diversion" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_diversion.placeHolder')}}" value="{{isset($plan)?$plan->national_diversion:''}}" />
                            <span class="text-danger errors" id="national_diversion_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_call_forwarding.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_call_forwarding" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_call_forwarding.placeHolder')}}" value="{{isset($plan)?$plan->national_call_forwarding:''}}" />
                            <span class="text-danger errors" id="national_call_forwarding_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_voicemail_deposits.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_voicemail_deposits" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_voicemail_deposits.placeHolder')}}" value="{{isset($plan)?$plan->national_voicemail_deposits:''}}" />
                            <span class="text-danger errors" id="national_voicemail_deposits_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_toll_free_numbers.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="national_toll_free_numbers" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 1800" value="{{isset($plan)?$plan->national_toll_free_numbers:''}}" />
                            <span class="text-danger errors" id="national_toll_free_numbers_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!-- 20-05-2022 -->
                    <!-- <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.details.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="details" id="details" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.nationalInclusion.details.placeHolder')}}">{{isset($plan)?$plan->details:''}}</textarea>
                            <span class="text-danger errors" id="details_error"></span>
                        </div>
                    </div> -->

                    <!-- <div class="row mb-6">
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_internet_data.label')}}</label>
                    <div class="col-lg-8 fv-row">
                        <textarea name="national_internet_data" id="national_internet_data" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_internet_data.placeHolder')}}" >{{isset($plan)?$plan->national_internet_data:''}}</textarea>
                        <span class="text-danger errors" id="national_internet_data_error"></span>
                    </div>
                    </div> -->

                    <!-- 20-05-2022 -->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_special_features.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <textarea name="national_special_features" id="national_special_features" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_special_features.placeHolder')}}">{{isset($plan)?$plan->national_special_features:''}}</textarea>
                            <span class="text-danger errors" id="national_special_features_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.nationalInclusion.national_additonal_info.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <textarea name="national_additonal_info" id="national_additonal_info" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.nationalInclusion.national_additonal_info.placeHolder')}}">{{isset($plan)?$plan->national_additonal_info:''}}</textarea>
                            <span class="text-danger errors" id="national_additonal_info_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>


                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-primary submit_btn" id="plan_national_inclusion_form_submit_btn" data-form="plan_national_inclusion_form" data-title="National Inclusion">{{ __ ('mobile.formPage.nationalInclusion.submitButton')}}</button>
                    <a href="{{url('/provider/plans/mobile/'.$providerId)}}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('mobile.formPage.nationalInclusion.cancelButton')}}</a>
                </div>
            </form>
            <!--end::Input group-->
        </div>
        <!--end::Card body-->
        <!-- End National Inclusion -->
    </div>

    <div class="card mb-5 mb-xl-10">
        <!-- International Inclusion -->
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#international_inclusion_section">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.internationalInclusion.sectionTitle')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="international_inclusion_section" class="collapse show">
            <!--begin::Form-->
            <form id="plan_international_inclusion_form" class="form">
                <!--begin::Card body-->
                <input type="hidden" name="plan_id" id="plan_id" value="{{ isset($plan) ? encryptGdprData($plan->id) : '' }}">
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.internationalInclusion.international_voice_calls.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="international_voice_calls" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.internationalInclusion.international_voice_calls.placeHolder')}}" value="{{isset($plan)?$plan->international_voice_calls:''}}" />
                            <span class="text-danger errors" id="international_voice_calls_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.internationalInclusion.international_video_calls.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="international_video_calls" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.internationalInclusion.international_video_calls.placeHolder')}}" value="{{isset($plan)?$plan->international_video_calls:''}}" />
                            <span class="text-danger errors" id="international_video_calls_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.internationalInclusion.international_text.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="international_text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.internationalInclusion.international_text.placeHolder')}}" value="{{isset($plan)?$plan->international_text:''}}" />
                            <span class="text-danger errors" id="international_text_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.internationalInclusion.international_mms.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="international_mms" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.internationalInclusion.international_mms.placeHolder')}}" value="{{isset($plan)?$plan->international_mms:''}}" />
                            <span class="text-danger errors" id="international_mms_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.internationalInclusion.international_diversion.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" autocomplete="off" name="international_diversion" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.internationalInclusion.international_diversion.placeHolder')}}" value="{{isset($plan)?$plan->international_diversion:''}}" />
                            <span class="text-danger errors" id="international_diversion_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.internationalInclusion.international_roaming.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <textarea name="international_roaming" id="international_roaming" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.internationalInclusion.international_roaming.placeHolder')}}">{{isset($plan) ? $plan->international_roaming : ''}}</textarea>
                            <span class="text-danger errors" id="international_roaming_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.internationalInclusion.international_additonal_info.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <textarea name="international_additonal_info" id="international_additonal_info" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.internationalInclusion.international_additonal_info.placeHolder')}}">{{isset($plan)?$plan->international_additonal_info:''}}</textarea>
                            <span class="text-danger errors" id="international_additonal_info_error"></span>
                        </div>
                        <!--end::Col-->
                    </div>


                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-primary submit_btn" id="plan_international_inclusion_form_submit_btn" data-form="plan_international_inclusion_form" data-title="International Inclusion">{{ __ ('mobile.formPage.internationalInclusion.submitButton')}}</button>
                    <a href="{{url('/provider/plans/mobile/'.$providerId)}}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('mobile.formPage.internationalInclusion.cancelButton')}}</a>
                </div>
            </form>
            <!--end::Form - international_inclusion_section-->
        </div>
        <!--end::Card body-->
    </div>

    
    <div class="card mb-5 mb-xl-10">
        <!-- Permissions & Authorizations -->
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#plan_settings_section">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Plan Settings</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="plan_settings_section" class="collapse show">
            <!--begin::Form-->
            <form id="plan_settings_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row my-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.activation_date_time.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="activation_date_time" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 dateTimePicker" placeholder="{{ __ ('mobile.formPage.basicDetails.activation_date_time.placeHolder')}}" value="{{isset($plan)?$plan->activation_date_time:''}}" id="activation_date_time" autocomplete="off" />
                            <span class="text-danger errors" id="activation_date_time_error"></span>
                        </div>
                    </div>
                    <div class="row my-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.deactivation_date_time.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="deactivation_date_time" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 dateTimePicker" placeholder="{{ __ ('mobile.formPage.basicDetails.deactivation_date_time.placeHolder')}}" value="{{isset($plan)?$plan->deactivation_date_time:''}}" id="deactivation_date_time" autocomplete="off" />
                            <span class="text-danger errors" id="deactivation_date_time_error"></span>
                        </div>
                    </div>
                    <div class="row my-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.billing_preference.label')}}</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid nbn_key">
                                <div class="d-flex align-items-center mt-3">
                                    <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                        <input class="form-check-input" name="billing_preference_checkbox" type="checkbox" value="1" 
                                        @if (isset($plan) && ($plan->billing_preference == 1 || $plan->billing_preference == 3))
                                        checked 
                                        @endif>
                                        <span class="fw-bold ps-2 fs-6">{{ __ ('mobile.formPage.basicDetails.billing_preference.email')}}</span>
                                    </label>
                                    <label class="form-check form-check-inline form-check-solid is-valid">
                                        <input class="form-check-input" name="billing_preference_checkbox" type="checkbox" value="2" @if (isset($plan) && ($plan->billing_preference == 2 || $plan->billing_preference == 3)) checked @endif>
                                        <span class="fw-bold ps-2 fs-6">{{ __ ('mobile.formPage.basicDetails.billing_preference.post')}}</span>
                                    </label>
                                </div>
                                <span class="text-danger errors" id="billing_preference_error"></span>
                                <input type="hidden" name="billing_preference" id="billing_preference_value">
                            </div>
                        </div>
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-primary submit_btn mx-2" id="plan_settings_form_submit_btn" data-form="plan_settings_form" data-title="Plan Settings">{{ __ ('mobile.formPage.permissions_authorizations.submitButton')}}</button>
                        <a href="{{url('/provider/plans/mobile/'.$providerId)}}" class="btn btn-light btn-active-light-primary me-2" id="plan_settings_form_reset_btn">{{ __ ('mobile.formPage.other_info.cancelButton')}}</a>
                    </div>
                    <!--end::Actions-->
                </div>
                
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!-- End Plan Settings -->    

    <div class="card mb-5 mb-xl-10">
        <!-- Permissions & Authorizations -->
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#permissions_authorizations_section">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Permissions & Authorizations</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="permissions_authorizations_section" class="collapse show">
            <!--begin::Form-->
            <form id="plan_permissions_authorizations_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('mobile.formPage.permissions_authorizations.override_permission.label')}}</label>
                        <div class="col-lg-8 fv-row mt-3">
                            <div class="row">
                                <div class="col-2 text-right">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input override_provider_permission" type="radio" value="1" name="override_provider_permission" id="override_provider_permission_yes" {{isset($plan) && $plan->override_provider_permission == 1 ? 'checked':''}} />
                                        <label class="form-check-label" for="override_provider_permission_yes">
                                            {{ __ ('mobile.formPage.permissions_authorizations.override_permission.enable')}}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-2 text-left">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input override_provider_permission" type="radio" value="0" name="override_provider_permission" id="override_provider_permission_no" {{isset($plan) && $plan->override_provider_permission == 0 ? 'checked':''}} />
                                        <label class="form-check-label" for="override_provider_permission_no">
                                            {{ __ ('mobile.formPage.permissions_authorizations.override_permission.disable')}}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-4 text-right">
                                    <span class="text-danger errors" id="override_provider_permission_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide_permission_disable_fields" style="display: none;">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('mobile.formPage.permissions_authorizations.new_connection_allowed.label')}}</label>
                            <div class="col-lg-8 fv-row mt-3">
                                <div class="row">
                                    <div class="col-2 text-right">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="1" name="new_connection_allowed" id="new_connection_allowed_yes" {{isset($plan) && $plan->new_connection_allowed == 1 ? 'checked':''}} />
                                            <label class="form-check-label" for="new_connection_allowed_yes">
                                                {{ __ ('mobile.formPage.permissions_authorizations.new_connection_allowed.yes')}}
                                            </label>
                                        </div>
                                    </div>
    
                                    <div class="col-2 text-left">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="0" name="new_connection_allowed" id="new_connection_allowed_no" {{isset($plan) && $plan->new_connection_allowed == 0 ? 'checked':''}} />
                                            <label class="form-check-label" for="new_connection_allowed_no">
                                                {{ __ ('mobile.formPage.permissions_authorizations.new_connection_allowed.no')}}
                                            </label>
                                        </div>
                                    </div>
    
                                    <div class="col-4 text-right">
                                        <span class="text-danger errors" id="new_connection_allowed_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('mobile.formPage.permissions_authorizations.port_allowed.label')}}</label>
                            <div class="col-lg-8 fv-row mt-3">
                                <div class="row">
                                    <div class="col-2 text-right">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="1" name="port_allowed" id="port_allowed_yes" {{isset($plan) && $plan->port_allowed == 1 ? 'checked':''}} />
                                            <label class="form-check-label" for="port_allowed_yes">
                                                {{ __ ('mobile.formPage.permissions_authorizations.port_allowed.yes')}}
                                            </label>
                                        </div>
                                    </div>
    
                                    <div class="col-2 text-left">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="0" name="port_allowed" id="port_allowed_no" {{isset($plan) && $plan->port_allowed == 0 ? 'checked':''}} />
                                            <label class="form-check-label" for="port_allowed_no">
                                                {{ __ ('mobile.formPage.permissions_authorizations.port_allowed.no')}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="text-danger errors" id="port_allowed_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('mobile.formPage.permissions_authorizations.retention_allowed.label')}}</label>
                            <div class="col-lg-8 fv-row mt-3">
                                <div class="row">
                                    <div class="col-2 text-right">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="1" name="retention_allowed" id="retention_allowed_yes" {{isset($plan) && $plan->retention_allowed == 1 ? 'checked':''}} />
                                            <label class="form-check-label" for="retention_allowed_yes">
                                                {{ __ ('mobile.formPage.permissions_authorizations.retention_allowed.yes')}}
                                            </label>
                                        </div>
                                    </div>
    
                                    <div class="col-2 text-left">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="0" name="retention_allowed" id="retention_allowed_no" {{isset($plan) && $plan->retention_allowed == 0 ? 'checked':''}} />
                                            <label class="form-check-label" for="retention_allowed_no">
                                                {{ __ ('mobile.formPage.permissions_authorizations.retention_allowed.no')}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="text-danger errors" id="retention_allowed_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-primary submit_btn" id="plan_permissions_authorizations_form_submit_btn" data-form="plan_permissions_authorizations_form" data-title="Permissions & Authorizations">{{ __ ('mobile.formPage.permissions_authorizations.submitButton')}}</button>
                    <a href="{{url('/provider/plans/mobile/'.$providerId)}}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('mobile.formPage.permissions_authorizations.cancelButton')}}</a>
                </div>
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!-- End International Inclusion -->

    <!-- Roaming Inclusion -->
    <!-- <div class="card mb-5 mb-xl-10"> -->
    <!-- begin::Card header -->
    <!-- <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#roaming_inclusion_section"> -->
    <!--begin::Card title-->
    <!-- <div class="card-title m-0"> -->
    <!-- <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.roamingInclusion.sectionTitle')}}</h3> -->
    <!-- </div> -->
    <!--end::Card title-->
    <!-- </div> -->
    <!--end::Card header-->
    <!--begin::Content-->
    <!-- <div id="roaming_inclusion_section" class="collapse show"> -->
    <!--begin::Form-->
    <!-- <form id="plan_roaming_inclusion_form" class="form"> -->
    <!--begin::Card body-->
    <!-- <div class="card-body border-top p-9"> -->
    <!-- <div class="row mb-6"> -->
    <!--begin::Label-->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_charge.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row"> -->
    <!-- <input type="text" autocomplete="off" name="roaming_charge" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_charge.placeHolder')}}" value="{{isset($plan)?$plan->roaming_charge:''}}" /> -->
    <!-- <span class="text-danger errors" id="roaming_charge_error"></span> -->
    <!-- </div> -->
    <!--end::Col-->
    <!-- </div> -->

    <!-- <div class="row mb-6"> -->
    <!--begin::Label-->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_voice_incoming.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row"> -->
    <!-- <input type="text" autocomplete="off" name="roaming_voice_incoming" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_voice_incoming.placeHolder')}}" value="{{isset($plan)?$plan->roaming_voice_incoming:''}}" /> -->
    <!-- <span class="text-danger errors" id="roaming_voice_incoming_error"></span> -->
    <!-- </div> -->
    <!--end::Col-->
    <!-- </div> -->

    <!-- <div class="row mb-6"> -->
    <!-- begin::Label -->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_voice_outgoing.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row"> -->
    <!-- <input type="text" autocomplete="off" name="roaming_voice_outgoing" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_voice_outgoing.placeHolder')}}" value="{{isset($plan)?$plan->roaming_voice_outgoing:''}}" /> -->
    <!-- <span class="text-danger errors" id="roaming_voice_outgoing_error"></span> -->
    <!-- </div> -->
    <!--end::Col-->
    <!-- </div> -->


    <!-- <div class="row mb-6"> -->
    <!-- begin::Label -->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_video_calls.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row"> -->
    <!-- <input type="text" autocomplete="off" name="roaming_video_calls" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_video_calls.placeHolder')}}" value="{{isset($plan)?$plan->roaming_video_calls:''}}" /> -->
    <!-- <span class="text-danger errors" id="roaming_video_calls_error"></span> -->
    <!-- </div> -->
    <!--end::Col-->
    <!-- </div> -->

    <!-- <div class="row mb-6"> -->
    <!--begin::Label-->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_text.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row"> -->
    <!-- <input type="text" autocomplete="off" name="roaming_text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_text.placeHolder')}}" value="{{isset($plan)?$plan->roaming_text:''}}" /> -->
    <!-- <span class="text-danger errors" id="roaming_text_error"></span> -->
    <!-- </div> -->
    <!--end::Col-->
    <!-- </div> -->

    <!-- <div class="row mb-6"> -->
    <!--begin::Label-->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_mms.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row"> -->
    <!-- <input type="text" autocomplete="off" name="roaming_mms" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_mms.placeHolder')}}" value="{{isset($plan)?$plan->roaming_mms:''}}" /> -->
    <!-- <span class="text-danger errors" id="roaming_mms_error"></span> -->
    <!-- </div> -->
    <!--end::Col-->
    <!-- </div> -->

    <!-- <div class="row mb-6"> -->
    <!--begin::Label-->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_voicemail_deposits.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row"> -->
    <!-- <input type="text" autocomplete="off" name="roaming_voicemail_deposits" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_voicemail_deposits.placeHolder')}}" value="{{isset($plan)?$plan->roaming_voicemail_deposits:''}}" /> -->
    <!-- <span class="text-danger errors" id="roaming_voicemail_deposits_error"></span> -->
    <!-- </div> -->
    <!--end::Col-->
    <!-- </div> -->

    <!-- <div class="row mb-6"> -->
    <!--begin::Label-->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_internet_data.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row"> -->
    <!-- <textarea name="roaming_internet_data" id="roaming_internet_data" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_internet_data.placeHolder')}}">{{isset($plan)?$plan->roaming_internet_data:''}}</textarea> -->
    <!-- <span class="text-danger errors" id="roaming_internet_data_error"></span> -->
    <!-- </div> -->
    <!--end::Col-->
    <!-- </div> -->

    <!-- <div class="row mb-6"> -->
    <!--begin::Label-->
    <!-- <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __ ('mobile.formPage.roamingInclusion.roaming_additonal_info.label')}}</label> -->
    <!--end::Label-->
    <!--begin::Col-->
    <!-- <div class="col-lg-8 fv-row">
                            <textarea name="roaming_additonal_info" id="roaming_additonal_info" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.roamingInclusion.roaming_additonal_info.placeHolder')}}">{{isset($plan)?$plan->roaming_additonal_info:''}}</textarea>
                            <span class="text-danger errors" id="roaming_additonal_info_error"></span>
                        </div> -->
    <!--end::Col-->
    <!-- </div> -->


    <!-- </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-primary submit_btn" id="plan_roaming_inclusion_form_submit_btn" data-form="plan_roaming_inclusion_form">{{ __ ('mobile.formPage.roamingInclusion.submitButton')}}</button>
                    <a href="{{url('/provider/plans/mobile/'.$providerId)}}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('mobile.formPage.roamingInclusion.cancelButton')}}</a>
                </div>
            </form> -->
    <!--end::Form - plan_roaming_inclusion_form-->
    <!-- </div> -->
    <!--end::Card body-->
    <!-- </div> -->
    <!-- End Roaming Inclusion -->


</div>
<!--end::Content-->