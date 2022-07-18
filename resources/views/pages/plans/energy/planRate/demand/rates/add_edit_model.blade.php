<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="add_plan_rate_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">{{ __('plans/energyPlans.add_new_tariff_rate') }}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_plan_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="add_plan_form" class="form" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.season_rateType') }}:</label>
                        <!--end::Label-->
                        <select data-control="select2" data-placeholder="Select Rate Type" data-hide-search="true"
                            name="season_rate_type" class="form-select form-select-solid select2-hidden-accessible"
                            tabindex="-1" aria-hidden="true">

                            <option value="">Select Rate Type</option>
                            <option value="1" >Rate_1</option>
                            <option value="2">Rate_2</option>
                            <option value="3" >Rate_3</option>
                        </select>
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.usage_type') }}:</label>
                        <!--end::Label-->
                        <select data-control="select2" data-placeholder="Select limit" data-hide-search="true"
                            name="usage_type" class="form-select form-select-solid select2-hidden-accessible"
                            tabindex="-1" aria-hidden="true">

                            <option value="">Select limit type</option>
                            <option value="energy" >peck</option>
                            <option value="broadband">off_peak</option>
                            <option value="mobile" >peck_c1</option>
                        </select>
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.usage_level') }}:</label>
                        <!--end::Label-->
                        <select data-control="select2" data-placeholder="Select limit" data-hide-search="true"
                            name="limit_level" class="form-select form-select-solid select2-hidden-accessible"
                             tabindex="-1" aria-hidden="true">
                            <option value="">Select limit</option>
                            <option value="energy" >limet_1</option>
                            <option value="broadband">limet_2</option>
                            <option value="mobile" >limet_3</option>
                        </select>
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.usage_charges') }}:</label>
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Limit Daily"
                            name="limit_charges" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_daily') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Limit Daily"
                            name="limit_daily" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_yearly') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Limit Yearly"
                            name="limit_yearly" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.usage_desc') }}:</label>

                        <textarea class="form-control" name="usage_discription"></textarea>

                    </div>
                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="cancel" class="btn btn-light me-3">{{ __('plans/energyPlans.discard') }}</button>
                        <button type="submit" id="add_plan_submit" class="btn btn-primary">
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
