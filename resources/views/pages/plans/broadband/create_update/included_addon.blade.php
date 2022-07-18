<div class="tab-pane fade" id="included_addons" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{__('plans/broadband.home_plan_included')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_included_addon_form" class="collapse show">
                <!--begin::Form-->
                <form id="kt_account_included_home_connection" class="form included_addon_common">
                    <!--begin::Card body-->
                    <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                    <input type='hidden' name='category' value="3">
                    <div class="card-body border-top p-9">
                        <!--begin::Input group--> 
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.calling_plan_status.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="status" type="radio" value="1" {{(isset($defaultIncludedAddon[3][0]['status']) && $defaultIncludedAddon[3][0]['status'] == 1)?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.show')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="status" type="radio" value="0" {{(!isset($defaultIncludedAddon[3][0]['status']))?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.hide')}}</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <span class="error text-danger status-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="included_home_connection_fields {{(!isset($defaultIncludedAddon[3][0]['status']))?'d-none':''}}">
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.home_plan_included_name.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="addon_id" aria-label="{{__('plans/broadband.home_plan_included_name.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.home_plan_included_name.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg" id="included_home_id">
                                        <option value=""></option>
                                        @foreach($phoneHomeConnection as $connection)
                                            <option value="{{ $connection->id }}" {{(isset($defaultIncludedAddon[3][0]['addon_id']) && $defaultIncludedAddon[3][0]['addon_id'] == $connection->id)?'selected':''}}>{{ $connection->name}} </option>
                                        @endforeach
                                    </select>
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
                                    <textarea type="text" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="script" style="display: none;">{{isset($defaultIncludedAddon[3][0]['script'])?$defaultIncludedAddon[3][0]['script']:''}}</textarea>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.home_plan_included_is_mandatory.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                        <!--begin::Options-->
                                        <div class="d-flex align-items-center mt-3">
                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                                <input class="form-check-input" name="is_mandatory" type="radio" value="1" {{(isset($defaultIncludedAddon[3][0]['is_mandatory']) && $defaultIncludedAddon[3][0]['is_mandatory'] == 1)?'checked':''}}>
                                                <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.yes')}}</span>
                                            </label>
                                            <!--end::Option-->
                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid is-valid">
                                                <input class="form-check-input" name="is_mandatory" type="radio" value="0" {{((isset($defaultIncludedAddon[3][0]['is_mandatory']) && $defaultIncludedAddon[3][0]['is_mandatory'] != 1) || !isset($defaultIncludedAddon[3][0]))?'checked':''}}>
                                                <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.no')}}</span>
                                                </label> 
                                                <!--end::Option-->
                                            </div>
                                            <span class="error text-danger is_mandatory-error"></span>
                                            <!--end::Options-->
                                        <div class="fv-plugins-message-container invalid-feedback"></div> 
                                    </div>
                                </div>
                            <!--end::Col-->
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                        <button type="submit" class="btn btn-primary" >{{__('plans/broadband.save_changes_button')}}</button>
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
                <h3 class="fw-bolder m-0">{{__('plans/broadband.modem_included')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_included_modem_form" class="collapse show">
                <!--begin::Form-->
                <form id="included_modem_form" class="form included_addon_common">
                    <!--begin::Card body-->
                    <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                    <input type='hidden' name='category' value="4">
                    <div class="card-body border-top p-9">
                        <!--begin::Input group--> 
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.include_modem_status.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="status" type="radio" value="1" {{(isset($defaultIncludedAddon[4][0]['status']) && $defaultIncludedAddon[4][0]['status'] == 1)?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.show')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="status" type="radio" value="0" {{(!isset($defaultIncludedAddon[4][0]['status']))?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.hide')}}</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <span class="error text-danger status-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="included_modems_fields {{(!isset($defaultIncludedAddon[4][0]['status']))?'d-none':''}}">
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.included_modem.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="addon_id" aria-label="{{__('plans/broadband.included_modem.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.included_modem.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg"  id="included_modem_id">
                                    <option value=""></option>
                                        @foreach($broadbandModem as $modem)
                                            <option value="{{ $modem->id }}" {{(isset($defaultIncludedAddon[4][0]['addon_id']) && $defaultIncludedAddon[4][0]['addon_id'] == $modem->id)?'selected':''}}>{{ $modem->name}} </option>
                                        @endforeach
                                    </select>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.modem_cost_type.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="cost_type_id" aria-label="{{__('plans/broadband.modem_cost_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.modem_cost_type.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg">
                                    <option value=""></option>
                                            @foreach($costTypes as $costType)
                                                <option value="{{ $costType->id }}" {{(isset($defaultIncludedAddon[4][0]['cost_type_id']) && $defaultIncludedAddon[4][0]['cost_type_id'] == $costType->id)?'selected':''}}>{{ $costType->cost_name}} </option>
                                            @endforeach
                                    </select>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.modem_cost.label')}} </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="price" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.modem_cost.placeholder')}}" value="{{isset($defaultIncludedAddon[4][0]['price'])? $defaultIncludedAddon[4][0]['price']:''}}" />
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
                                    <textarea type="text" id="modem_script" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="script" style="display: none;">{{isset($defaultIncludedAddon[4][0]['script'])? $defaultIncludedAddon[4][0]['script']:''}}</textarea>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.modem_included_is_mandatory.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                        <!--begin::Options-->
                                        <div class="d-flex align-items-center mt-3">
                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                                <input class="form-check-input" name="is_mandatory" type="radio" value="1" {{(isset($defaultIncludedAddon[4][0]['is_mandatory']) && $defaultIncludedAddon[4][0]['is_mandatory'] == 1)?'checked':''}}>
                                                <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.yes')}}</span>
                                            </label>
                                            <!--end::Option-->
                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid is-valid">
                                                <input class="form-check-input" name="is_mandatory" type="radio" value="0" {{((isset($defaultIncludedAddon[4][0]['is_mandatory']) && $defaultIncludedAddon[4][0]['is_mandatory'] != 1) || !isset($defaultIncludedAddon[4][0]))?'checked':''}}>
                                                <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.no')}}</span>
                                                </label> 
                                                <!--end::Option-->
                                            </div>
                                            <span class="error text-danger is_mandatory-error"></span>
                                            <!--end::Options-->
                                        <div class="fv-plugins-message-container invalid-feedback"></div> 
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
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
                <h3 class="fw-bolder m-0">{{__('plans/broadband.other_addon_included')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_included_addon_form" class="collapse show">
                <!--begin::Form-->
                <form id="included_addon_form" class="form included_addon_common">
                    <!--begin::Card body-->
                    <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                    <input type='hidden' name='category' value="5">
                    <div class="card-body border-top p-9">
                        <!--begin::Input group--> 
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.include_other_addon_status.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="status" type="radio" value="1" {{(isset($defaultIncludedAddon[5][0]['status']) && $defaultIncludedAddon[5][0]['status'] == 1)?'checked':''}} >
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.show')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="status" type="radio" value="0" {{(!isset($defaultIncludedAddon[5][0]['status']))?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.hide')}}</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <span class="error text-danger status-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="included_addons_fields {{(!isset($defaultIncludedAddon[5][0]['status']))?'d-none':''}}">
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.other_addon.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="addon_id" aria-label="{{__('plans/broadband.other_addon.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.other_addon.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg" id="included_addon_id">
                                    <option value=""></option>
                                        @foreach($additionalAddons as $addon)
                                            <option value="{{ $addon->id }}" {{(isset($defaultIncludedAddon[5][0]['addon_id']) && $defaultIncludedAddon[5][0]['addon_id'] == $addon->id)?'selected':''}}>{{ $addon->name}} </option>
                                        @endforeach
                                    </select>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.other_addon_cost_type.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="cost_type_id" aria-label="{{__('plans/broadband.other_addon_cost_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.other_addon_cost_type.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg">
                                    <option value=""></option>
                                        @foreach($costTypes as $costType)
                                            <option value="{{ $costType->id }}" {{(isset($defaultIncludedAddon[5][0]['cost_type_id']) && $defaultIncludedAddon[5][0]['cost_type_id'] == $costType->id)?'selected':''}}>{{ $costType->cost_name}} </option>
                                        @endforeach
                                    </select>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.other_addon_cost.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="price" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.other_addon_cost.placeholder')}}" value="{{isset($defaultIncludedAddon[5][0]['price'])? $defaultIncludedAddon[5][0]['price']:''}}" />
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
                                    <textarea type="text" id="addon_script" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="script" style="display: none;">{{isset($defaultIncludedAddon[5][0]['script'])? $defaultIncludedAddon[5][0]['script']:''}}</textarea>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Is Mandatory</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                        <!--begin::Options-->
                                        <div class="d-flex align-items-center mt-3">
                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                                <input class="form-check-input" name="is_mandatory" type="radio" value="1" {{(isset($defaultIncludedAddon[5][0]['is_mandatory']) && $defaultIncludedAddon[5][0]['is_mandatory'] == 1)?'checked':''}}>
                                                <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.yes')}}</span>
                                            </label>
                                            <!--end::Option-->
                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid is-valid">
                                                <input class="form-check-input" name="is_mandatory" type="radio" value="0" {{((isset($defaultIncludedAddon[5][0]['is_mandatory']) && $defaultIncludedAddon[5][0]['is_mandatory'] != 1) || !isset($defaultIncludedAddon[5][0]))?'checked':''}}>
                                                <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.no')}}</span>
                                                </label> 
                                                <!--end::Option-->
                                            </div>
                                            <span class="error text-danger is_mandatory-error"></span>
                                            <!--end::Options-->
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                        <button type="submit" class="btn btn-primary" >{{__('plans/broadband.save_changes_button')}}</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
        </div>
    </div>
  
</div>