<div class="tab-pane fade" id="specifications" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#specifications_section">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('handset.formPage.specifications.network.subSectionTitle')}}</h3>
            </div>
        </div>
        <div id="specifications_section" class="collapse show">
            <!--begin::Form-->
            <form id="phone_network_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.network.technology.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="technology" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('handset.formPage.specifications.network.technology.placeHolder')}}" value="{{isset($phone) ? $phone->technology :''}}" autocomplete="off" />
                            <span class="text-danger errors" id="technology_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.network.network_manageability.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="network_managebility" id="network_managebility" placeholder="{{ __ ('handset.formPage.specifications.network.network_manageability.placeHolder')}}" class="form-control form-control-lg form-control-solid">{{isset($phone) ? $phone->network_managebility : ''}}</textarea>
                            <span class="text-danger errors" id="network_managebility_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.network.extra_technologies.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="extra_technology" id="extra_technology" placeholder="{{ __ ('handset.formPage.specifications.network.extra_technologies.placeHolder')}}" class="form-control form-control-lg form-control-solid">{{isset($phone) ? $phone->extra_technology : ''}}</textarea>
                            <span class="text-danger errors" id="extra_technology_error"></span>
                        </div>
                    </div>
                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ theme()->getPageUrl('/mobile/handsets') }}" type="button" class="btn btn-light btn-active-light-primary me-2">{{ __ ('handset.formPage.specifications.cancelButton')}}</a>
                    <button type="button" class="btn btn-primary submit_btn" id="phone_network_form_submit_btn" data-form="phone_network_form">{{ __ ('handset.formPage.specifications.submitButton')}}</button>
                </div>
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!--end::Card body-->

    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('handset.formPage.specifications.body.subSectionTitle')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div>
            <!--begin::Form-->
            <form id="phone_body_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.body.dimensions.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->dimension:''}}" placeholder="{{ __ ('handset.formPage.specifications.body.dimensions.placeHolder')}}" name="dimension" autocomplete="off"/>
                            <span class="text-danger errors" id="dimension_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.body.weight.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->weight:''}}" placeholder="{{ __ ('handset.formPage.specifications.body.weight.placeHolder')}}" name="weight" autocomplete="off" />
                            <span class="text-danger errors" id="weight_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.specifications.body.body_protection_build.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->body_protection_build:''}}" placeholder="{{ __ ('handset.formPage.specifications.body.body_protection_build.placeHolder')}}" name="body_protection_build" autocomplete="off" />
                            <span class="text-danger errors" id="body_protection_build_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.body.sim_compatibility.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" placeholder="{{ __ ('handset.formPage.specifications.body.sim_compatibility.placeHolder')}}" value="{{isset($phone) ? $phone->sim_compatibility:''}}" name="sim_compatibility" autocomplete="off" />
                            <span class="text-danger errors" id="sim_compatibility_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.specifications.body.card_slot.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" type="radio" name="is_card_slot" {{isset($phone) && $phone->is_card_slot == 1 ? 'checked':''}} value="1" />
                                    <span class="form-check-label">Yes</span>
                            </label>
                            <!--end::Option-->
                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input" type="radio" name="is_card_slot" {{isset($phone) && $phone->is_card_slot == 0 ? 'checked':''}} value="0" checked />
                                <span class="form-check-label">No</span>
                            </label>
                            <span class="text-danger errors" id="is_card_slot_error"></span>
                        </div>
                    </div>

                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ theme()->getPageUrl('/mobile/handsets') }}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('handset.formPage.specifications.cancelButton')}}</a>
                    <button type="button" class="btn btn-primary submit_btn" id="phone_body_form_submit_btn" data-form="phone_body_form">{{ __ ('handset.formPage.specifications.submitButton')}}</button>
                </div>
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!--end::Card body-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('handset.formPage.specifications.screen_display.subSectionTitle')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div>
            <!--begin::Form-->
            <form id="phone_screen_display_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.screen_display.screen_type.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->screen_type:''}}" placeholder="{{ __ ('handset.formPage.specifications.screen_display.screen_type.placeHolder')}}" name="screen_type" autocomplete="off" />
                            <span class="text-danger errors" id="screen_type_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.screen_display.screen_size.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->screen_size:''}}" placeholder="{{ __ ('handset.formPage.specifications.screen_display.screen_size.placeHolder')}}" name="screen_size" autocomplete="off" />
                            <span class="text-danger errors" id="screen_size_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.screen_display.screen_resolution.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->screen_resolution:''}}" placeholder="{{ __ ('handset.formPage.specifications.screen_display.screen_resolution.placeHolder')}}" name="screen_resolution" autocomplete="off" />
                            <span class="text-danger errors" id="screen_resolution_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.specifications.screen_display.multitouch.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->multitouch:''}}" placeholder="{{ __ ('handset.formPage.specifications.screen_display.multitouch.placeHolder')}}" name="multitouch" autocomplete="off" />
                            <span class="text-danger errors" id="multitouch_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.specifications.screen_display.screen_protection.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->screen_protection:''}}" placeholder="{{ __ ('handset.formPage.specifications.screen_display.screen_protection.placeHolder')}}" name="screen_protection" autocomplete="off" />
                            <span class="text-danger errors" id="screen_protection_error"></span>
                        </div>
                    </div>
                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">    
                    <a href="{{ theme()->getPageUrl('/mobile/handsets') }}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('handset.formPage.specifications.cancelButton')}}</a>
                    <button type="button" class="btn btn-primary submit_btn" id="phone_screen_display_form_submit_btn" data-form="phone_screen_display_form">{{ __ ('handset.formPage.specifications.submitButton')}}</button>
                </div>
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!--end::Card body-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('handset.formPage.specifications.operating_system.subSectionTitle')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div>
            <!--begin::Form-->
            <form id="phone_os_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.operating_system.operating_system.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <select class="form-select form-select-solid" name="os" data-control="select2" data-hide-search="false" aria-label="{{ __ ('handset.formPage.specifications.operating_system.operating_system.placeHolder')}}" data-placeholder="{{ __ ('handset.formPage.specifications.operating_system.operating_system.placeHolder')}}" aria-hidden="true" tabindex="-1">
                                <option value=""></option>
                                @foreach($operatingSystemNames as $id => $name)
                                <option value="{{$id}}" {{isset($phone) && $phone->os == $id ? 'selected' :''}}>{{$name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger errors" id="os_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.operating_system.version.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->version:''}}" placeholder="{{ __ ('handset.formPage.specifications.operating_system.version.placeHolder')}}" name="version" autocomplete="off" />
                            <span class="text-danger errors" id="version_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.specifications.operating_system.chipset.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->chipset:''}}" placeholder="{{ __ ('handset.formPage.specifications.operating_system.chipset.placeHolder')}}" name="chipset" autocomplete="off" />
                            <span class="text-danger errors" id="chipset_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.specifications.operating_system.cpu.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" type="text" value="{{isset($phone) ? $phone->cpu:''}}" placeholder="{{ __ ('handset.formPage.specifications.operating_system.cpu.placeHolder')}}" name="cpu" autocomplete="off" />
                            <span class="text-danger errors" id="cpu_error"></span>
                        </div>
                    </div>
                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ theme()->getPageUrl('/mobile/handsets') }}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('handset.formPage.specifications.cancelButton')}}</a>
                    <button type="button" class="btn btn-primary submit_btn" id="phone_os_form_submit_btn" data-form="phone_os_form">{{ __ ('handset.formPage.specifications.submitButton')}}</button>
                </div>
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!--end::Card body-->

</div>
<!--end::Content-->