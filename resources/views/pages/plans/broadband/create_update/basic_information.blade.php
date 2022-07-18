<div class="tab-pane fade show active" id="basic_details" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">
                    {{__('plans/broadband.basic_detail')}} 
                    </h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->
                <form id="basic_details_form" class="form">
                    <!--begin::Card body-->
                    <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                    <input type='hidden' name='provider_id' value="{{encryptGdprData($providerUser['user_id'])}}" id="provider_id_field">
                    <input type="hidden" name="action" value="{{$type}}">
                    <input type="hidden" name="formType" value="basic_details_form">
                    <div class="card-body border-top p-9">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.name.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.name.placeholder')}}" value="{{isset($plan)?$plan->name:''}}" />
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.plan_duration.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select name="contract_id" aria-label="{{__('plans/broadband.plan_duration.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.plan_duration.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg">
                                    <option value=""></option>
                                    @foreach($contracts as $contract)
                                        <option value="{{ $contract->id }}" {{(isset($plan) && $plan->contract_id == $contract->id)?'selected':''}}>{{ $contract->contract_name }} </option>
                                    @endforeach 
                                </select>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.connection_type.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select name="connection_type" aria-label="{{__('plans/broadband.connection_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.connection_type.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg connection_type_event">
                                    <option value=""></option>
                                    @foreach($connectionTypes as $connectionType)
                                    <option value="{{$connectionType->id}}" {{(isset($plan) && $plan->connection_type == $connectionType->id)?'selected':''}}>{{$connectionType->name}}</option>  
                                    @endforeach
                                </select>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6 ">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.technology_type.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                            
                                <select name="tech_type[]" aria-label="{{__('plans/broadband.technology_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.technology_type.placeholder')}}" class="form-select form-select-solid form-select-lg tech_type_event" multiple="multiple">
                                    @foreach($technologyTypes as $technologyType)
                                    <option value="{{$technologyType->id}}" {{in_array($technologyType->id,$assignedTechnolgy)?'selected':''}}>{{$technologyType->name}}</option>  
                                    @endforeach
                                </select>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.satellite_inclusion.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <textarea type="text" id="satellite_inclusion" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="satellite_inclusion" style="display: none;">{{isset($plan)?$plan->satellite_inclusion:''}}</textarea>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.plan_inclusion.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <textarea type="text" id="plan_inclusion" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="inclusion" style="display: none;">{{isset($plan)?$plan->inclusion:''}}</textarea>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.connection_type_info.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="connection_type_info" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.connection_type_info.placeholder')}}" value="{{isset($plan)?$plan->connection_type_info:''}}" />
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.internet_speed.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="internet_speed" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.internet_speed.placeholder')}}" value="{{isset($plan)?$plan->internet_speed:''}}" />
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>
                        
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.internet_speed_info.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="internet_speed_info" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.internet_speed_info.placeholder')}}" value="{{isset($plan)?$plan->internet_speed_info:''}}" />
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.plan_cost_type.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select name="plan_cost_type_id" aria-label="{{__('plans/broadband.plan_cost_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.plan_cost_type.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg">
                                    @foreach($costTypes as $costType)
                                        <option value="{{ $costType->id }}" {{(isset($plan) && $plan->plan_cost_type_id == $costType->id)?'selected':''}}>{{ $costType->cost_name}} </option>
                                    @endforeach 
                                </select>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.plan_cost.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="plan_cost" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.plan_cost.placeholder')}}" value="{{isset($plan)?$plan->plan_cost:''}}" />
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.plan_cost_info.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <textarea type="text" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="plan_cost_info" style="display: none;">{{isset($plan)?$plan->plan_cost_info:''}}</textarea>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.plan_cost_description.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <textarea type="text" id="plan_cost_description" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="plan_cost_description" style="display: none;">{{isset($plan)?$plan->plan_cost_description:''}}</textarea>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <!--begin::Input group--> 
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.is_boyo_modem.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="is_boyo_modem" type="radio" value="1" {{(isset($plan) && $plan->is_boyo_modem == 1)?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.yes')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="is_boyo_modem" type="radio" value="0" {{((isset($plan) && $plan->is_boyo_modem == 0 || !isset($plan)))?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.no')}}</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <span class="error text-danger is_boyo_modem-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                        </div>

                        <!--begin::Input group--> 
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.billing_preference.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid nbn_key">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="billing_preference" type="radio" value="1" {{((isset($plan) && $plan->billing_preference == 1) || !isset($plan))?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.billing_preference_email')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="billing_preference" type="radio" value="2" {{(isset($plan) && $plan->billing_preference == 2)?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.billing_preference_sms')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="billing_preference" type="radio" value="3" {{(isset($plan) && $plan->billing_preference == 3)?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.billing_preference_both')}}</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <span class="error text-danger billing_preference-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                        </div>

                        <!--begin::Input group--> 
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.nbn_key_facts.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid nbn_key">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="nbn_key" type="radio" value="1" checked>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.nbn_key_facts_url.label')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="nbn_key" type="radio" value="2">
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.nbn_key_facts_file.label')}}</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <span class="error text-danger nbn_key-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.nbn_key_facts_url.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="nbn_key_url" placeholder="{{__('plans/broadband.nbn_key_facts_url.placeholder')}}" class="form-control form-control-lg form-control-solid" value="{{isset($plan) ? $plan->nbn_key_url:''}}" />
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.nbn_key_facts_file.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="file" name="nbn_key_file" class="form-control form-control-lg form-control-solid" value="" />
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>
                        
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                        <button type="submit" class="btn btn-primary" id="basic_details_submit">{{__('plans/broadband.save_changes_button')}}</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
    </div>
    <!--end::Content-->
    @if($type == 'edit')
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{__('plans/broadband.plan_information')}} </h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Content-->
                <div id="kt_account_plan_info" class="collapse show">
                        <!--begin::Form-->
                        <form id="plan_info_form" class="form">
                            <!--begin::Card body-->
                            <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                            <input type="hidden" name="formType" value="plan_info_form">
                            <div class="card-body border-top p-9">
                                <!--begin::Input group--> 
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.download_speed.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="download_speed" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.download_speed.placeholder')}}" value="{{isset($plan)?$plan->download_speed:''}}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.upload_speed.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="upload_speed" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.upload_speed.placeholder')}}" value="{{isset($plan)?$plan->upload_speed:''}}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.typical_peak_time_download_speed.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="typical_peak_time_download_speed" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.typical_peak_time_download_speed.placeholder')}}" value="{{isset($plan)?$plan->typical_peak_time_download_speed:''}}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.data_limit.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <select name="data_limit" aria-label="{{__('plans/broadband.data_limit.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.data_limit.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg">
                                        @if(!empty($dataLimit))
                                            @foreach($dataLimit as $key=>$val) 
                                                <option value="{{$key}}" {{(isset($plan) && $plan->data_limit == $key)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                        @endif  
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.speed_description.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <textarea type="text" id="speed_description" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="speed_description" style="display: none;">{{isset($plan)?$plan->speed_description:''}}</textarea>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.additional_plan_information_text.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <textarea type="text" id="additional_plan_information" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="additional_plan_information" style="display: none;">{{isset($plan)?$plan->additional_plan_information:''}}</textarea>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.script')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <textarea type="text" id="plan_script" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="plan_script" style="display: none;">{{isset($plan)?$plan->plan_script:''}}</textarea>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                                <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                </div>
            </div>

            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{__('plans/broadband.plan_data')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Content-->
                <div id="kt_account_plan_data" class="collapse show">
                        <!--begin::Form-->
                        <form id="plan_data_form" class="form">
                            <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                            <input type="hidden" name="formType" value="plan_data_form">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group--> 
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.data_unit.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <select class="form-select form-select-solid" name="data_unit_id" data-control="select2" data-hide-search="true" aria-label="{{ __ ('plans/broadband.data_unit.placeHolder')}}" data-placeholder="{{ __ ('plans/broadband.data_unit.placeHolder')}}" aria-hidden="true" tabindex="-1">
                                            <option value=""></option>
                                            @foreach($dataUnit as $id => $name)
                                            <option value="{{$id}}" {{isset($plan) && $plan->data_unit_id == $id ? 'selected' :''}}>{{$name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.total_data_allowance.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="total_data_allowance" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.total_data_allowance.placeholder')}}" value="{{isset($plan)?$plan->total_data_allowance:''}}" autocomplete="off"/>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.off_peak_data.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="off_peak_data" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.off_peak_data.placeholder')}}" value="{{isset($plan)?$plan->off_peak_data:''}}" autocomplete="off" />
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.peak_data.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="peak_data" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.peak_data.placeholder')}}" value="{{isset($plan)?$plan->peak_data:''}}" autocomplete="off" />
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                                <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                </div>
            </div>

            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{__('plans/broadband.critical_information')}} </h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Content-->
                <div id="kt_account_remarketing_information" class="collapse show">
                        <!--begin::Form-->
                        <form id="critical_information_form" class="form">
                            <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                            <input type="hidden" name="formType" value="critical_information_form">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group--> 
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.select_option.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col--> 
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid critical_info_type">
                                            <!--begin::Options-->
                                            <div class="d-flex align-items-center mt-3">
                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                                    <input class="form-check-input" name="critical_info_type" type="radio" value="1" checked>
                                                    <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.critical_info_url.label')}}</span>
                                                </label>
                                                <!--end::Option-->
                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid is-valid">
                                                    <input class="form-check-input" name="critical_info_type" type="radio" value="2" >
                                                    <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.critical_info_file.label')}}</span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                            <span class="error text-danger critical_info_type-error"></span>
                                            <!--end::Options-->
                                        <div class="fv-plugins-message-container invalid-feedback"></div> 
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.critical_info_url.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" placeholder="{{__('plans/broadband.critical_info_url.placeholder')}}" name="critical_info_url" class="form-control form-control-lg form-control-solid" value="{{isset($plan)?$plan->critical_info_url:''}}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div> 

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/broadband.critical_info_file.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="file" name="critical_info_file" class="form-control form-control-lg form-control-solid" />
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Col-->
                                </div> 
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                                <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                </div>
            </div>

            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{__('plans/broadband.remarketing_information')}} </h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Content-->
                <div id="kt_account_plan_info" class="collapse show">
                        <!--begin::Form-->
                        <form id="remarketing_informatio_form" class="form">
                            <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                            <input type="hidden" name="formType" value="remarketing_informatio_form">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group--> 
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.remarketing_allow.label')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col--> 
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid remarketing_allow">
                                            <!--begin::Options-->
                                            <div class="d-flex align-items-center mt-3">
                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                                    <input class="form-check-input" name="remarketing_allow" type="radio" value="1" {{(isset($plan) && $plan->remarketing_allow == 1)?'checked':''}}>
                                                    <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.remarketing_allow_yes.label')}}</span>
                                                </label>
                                                <!--end::Option-->
                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid is-valid">
                                                    <input class="form-check-input" name="remarketing_allow" type="radio" value="0" {{(isset($plan) && $plan->remarketing_allow == 0)?'checked':''}}>
                                                    <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.remarketing_allow_no.label')}}</span>
                                                </label> 
                                                <!--end::Option-->
                                            </div>
                                            <span class="error text-danger remarketing_allow-error"></span> 
                                            <!--end::Options-->
                                        <div class="fv-plugins-message-container invalid-feedback"></div> 
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                                <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                </div>
            </div>
    @endif
</div>