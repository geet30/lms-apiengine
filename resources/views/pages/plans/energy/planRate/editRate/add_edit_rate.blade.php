<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="add_plan_rate_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <form name="edit_plan_info" id="add_plan_rate_limt" action="{{ route('energyplans.aad.rate.limt') }}">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">{{ __('plans/energyPlans.add_new_plan') }}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="add_plan_close" class="btn btn-icon btn-sm btn-active-icon-primary"
                        data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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
                        <div class="fv-row mb-10 field-holder field-holder">
                            <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_type') }}:</label>
                            <!--begin::Label-->
                            <!--end::Label-->
                            <select name="limit_type" class="form-control form-control-solid form-select hide_limit"
                                id="limit_type" aria-hidden="true">
                                @foreach ($allLimitTypes as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            <span class=" limit_type"style="display:none;">
                            </span>
                            <span class="form_error" style="color:red"></span>
                        </div>
                        <div class="fv-row mb-10 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_level') }}:</label>
                            <!--end::Label-->
                            <select name="limit_level" id="limit_level"
                                class="form-control form-control-solid form-select hide_limit" aria-hidden="true">

                            </select>
                            <div class=" limit_level"style="display:none;">
                            </div>
                            <span class="form_error" style="color:red"></span>
                        </div>
                        <div class="fv-row mb-10 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_desc') }}:</label>
                            <!--begin::Input-->
                            <textarea class="form-control" name="limit_desc"></textarea>
                            <span class="form_error" style="color:red"></span>
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-10 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_daily') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control" placeholder="Limit Daily" name="limit_daily" />
                            <span class="form_error" style="color:red"></span>
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-10 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_charges') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control" placeholder="Limit Charges" name="limit_charges" />
                            <span class="form_error" style="color:red"></span>
                            <!--end::Input-->
                        </div>
                        <!-- Add Text Field Limit Charges Description 26-05-2022 -->
                        <div class="fv-row mb-10 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_charges_description') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class="form-control" name="limit_charges_description"></textarea>
                            <span class="form_error" style="color:red"></span>
                            <!--end::Input-->
                        </div>
                        <!-- Limit Charges Description -->
                        <div class="fv-row mb-10 field-holder">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.limit_yearly') }}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control" placeholder="Limit Yearly" name="limit_year" />
                            <span class="form_error" style="color:red"></span>
                            <!--end::Input-->
                        </div>
                        <input type="hidden" name="id">
                        <input type="hidden" name="action_type" value="plan_rate_limit">

                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="cancel" data-bs-dismiss="modal"
                                class="btn btn-light me-3">{{ __('plans/energyPlans.discard') }}</button>
                            <button type="button" id="plan_limt_btn"
                                class="btn btn-primary plan_limt_btn submit_button">
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
    </form>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->
