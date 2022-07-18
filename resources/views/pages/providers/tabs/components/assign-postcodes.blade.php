<div class="card mb-5 mb-xl-10">
    <!-- Amazing Extra Facilities -->

    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#amazing_extra_facilities_section">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('providers.assignPostcodeSection.tabSectionTitle') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="assign_postcode_section" class="collapse show">
        <!--begin::Form-->
        <form id="assign_postcode_form" class="form">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">

                <input type="hidden" name="provider_id" value="{{isset($providerdetails[0]) ? encryptGdprData($providerdetails[0]['id']) : ''}}">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('providers.assignPostcodeSection.energy_type.label') }}</label>
                    <div class="col-lg-8 fv-row">
                        <select class="form-select fsorm-select-transsparent" id="energy_type" name="energy_type" data-control="select2" data-hide-search="false" aria-label="{{ __('providers.assignPostcodeSection.energy_type.placeHolder') }}" data-placeholder="{{ __('providers.assignPostcodeSection.energy_type.placeHolder') }}">
                            <option value=""></option>
                            <option value="0">Electricity</option>
                            <option value="1">Gas</option>
                        </select>
                        <span class="text-danger errors" id="energy_type_error"></span>
                    </div>
                </div>
                <div id="distributor_box" style="display: none;">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('providers.assignPostcodeSection.distributor.label') }}</label>
                        <div class="col-lg-8 fv-row">
                            <select class="form-select fsorm-select-transsparent" id="distributor" name="distributor" data-control="select2" data-hide-search="false" aria-label="{{ __('providers.assignPostcodeSection.distributor.placeHolder') }}" data-placeholder="{{ __('providers.assignPostcodeSection.distributor.placeHolder') }}">
                                <option value=""></option>
                            </select>
                            <span class="text-danger errors" id="distributor_error"></span>
                        </div>

                    </div>
                </div>
                <div id="postcode_box" style="display: none;">
                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('providers.assignPostcodeSection.postcodes.label') }}</label>
                        <div class="col-lg-8 fv-row">
                            <select class="form-select fsorm-select-transsparent" id="postcode" name="postcodes" data-control="select2" data-hide-search="false" aria-label="{{ __('providers.assignPostcodeSection.postcodes.placeHolder') }}" data-placeholder="{{ __('providers.assignPostcodeSection.postcodes.placeHolder') }}" multiple>
                                <option value=""></option>
                            </select>
                            <span class="text-danger errors" id="postcodes_error"></span>
                        </div>

                    </div>
                </div>

            </div>
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="button" class="btn btn-primary submit_btn" id="assign_postcode_form_submit_btn" data-form="assign_postcode_form">{{ __('providers.assignPostcodeSection.submitBtn') }}</button>
                <a href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light btn-active-light-primary me-2">{{ __('providers.assignPostcodeSection.cancelBtn') }}</a>
            </div>

        </form>
        <!--end::Input group-->
    </div>
</div>
