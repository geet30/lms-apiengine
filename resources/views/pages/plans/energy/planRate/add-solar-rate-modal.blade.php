@if($type == 'normal')

<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="add_solar_rate_modal"  tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">{{ __('plans/energyPlans.add_new_solar') }} (Normal)</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_plan_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill"data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y">
                <!--begin::Form-->
                <form id="add_edit_solar" class="form" action="{{route('solar.add-edit')}}">
                    <input type="hidden" name="type" value="1">
                    <!--begin::Input group-->
                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_price') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid h-50px border" placeholder="e.g. 10.99" name="solar_rate" maxlength="100" autocomplete="off" />
                        <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_price_desc') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea name="solar_rate_price_description" placeholder="e.g. New Offer" class="form-control form-control-lg form-control-solid solar_rate_price_description"></textarea>
                        <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_charge') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid h-50px border" placeholder="e.g. 10" name="charge" maxlength="100" autocomplete="off" />
                        <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_charge_desc') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea name="solar_supply_charge_description" placeholder="e.g. 25 percent less than before" class="form-control form-control-lg form-control-solid solar_supply_charge_description"></textarea>
                        <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>

                    <!--begin::Input group-->
                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_desc') }}:</label>
                        <!--end::Label-->
                        <textarea class="form-control ckeditor" id="solar_desc" name="solar_desc" placeholder="e.g. GST exempted"></textarea>
                        <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.show_on_front') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-check form-check-solid form-switch fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="show_on_frontend" name="show_on_frontend" value="1">
                            <label class="form-check-label" for="show_on_frontend"></label>
                        </div>
                        <!--end::Input-->
                    </div>
                    <input type="hidden" name="id" value="">



                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-end">
                        <button type="reset" id="cancel"  data-bs-dismiss="modal" class="btn btn-light me-3">{{ __('plans/energyPlans.discard') }}</button>
                        <button type="button" id="solar_rate_btn" class="btn btn-primary submit_button">
                            <span class="indicator-label">{{ __('plans/energyPlans.submit') }}</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->

@else

    <!--begin::Modal - Adjust Balance-->
    <div class="modal fade" id="add_solar_rate_modal_premium"  tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header bg-primary px-5 py-4">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">{{ __('plans/energyPlans.add_new_solar') }} (Premium)</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="add_plan_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill"data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y">
                    <!--begin::Form-->
                    <form id="add_edit_solar" class="form" action="{{route('solar.add-edit')}}">
                        <input type="hidden" name="type" value="0">
                        <!--begin::Input group-->
                        <div class="fv-row mb-5 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_price') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid h-50px border" placeholder="e.g. 10.99" name="solar_rate" maxlength="100" autocomplete="off" />
                            <span class="form_error" style="color: red;"></span>
                            <!--end::Input-->
                        </div>

                        <div class="fv-row mb-5 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_price_desc') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="solar_rate_price_description" placeholder="e.g. New Offer" class="form-control form-control-lg form-control-solid solar_rate_price_description"></textarea>
                            <span class="form_error" style="color: red;"></span>
                            <!--end::Input-->
                        </div>

                        <div class="fv-row mb-5 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_charge') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid h-50px border" placeholder="e.g. 10" name="charge" maxlength="100" autocomplete="off" />
                            <span class="form_error" style="color: red;"></span>
                            <!--end::Input-->
                        </div>

                        <div class="fv-row mb-5 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_charge_desc') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="solar_supply_charge_description" placeholder="e.g. 25 percent less than before" class="form-control form-control-lg form-control-solid solar_supply_charge_description"></textarea>
                            <span class="form_error" style="color: red;"></span>
                            <!--end::Input-->
                        </div>

                        <!--begin::Input group-->
                        <div class="fv-row mb-5 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.solar_rate_desc') }}:</label>
                            <!--end::Label-->
                            <textarea class="form-control ckeditor" id="solar_desc" name="solar_desc" placeholder="e.g. GST exempted"></textarea>
                            <span class="form_error" style="color: red;"></span>
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-5">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-1">{{ __('plans/energyPlans.show_on_front') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="form-check form-check-solid form-switch fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox" id="show_on_frontend" name="show_on_frontend" value="1">
                                <label class="form-check-label" for="show_on_frontend"></label>
                            </div>
                            <!--end::Input-->
                        </div>
                        <input type="hidden" name="id" value="">



                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-end">
                            <button type="reset" id="cancel"  data-bs-dismiss="modal" class="btn btn-light me-3">{{ __('plans/energyPlans.discard') }}</button>
                            <button type="button" id="solar_rate_btn" class="btn btn-primary submit_button">
                                <span class="indicator-label">{{ __('plans/energyPlans.submit') }}</span>
                                <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Card-->

@endif
