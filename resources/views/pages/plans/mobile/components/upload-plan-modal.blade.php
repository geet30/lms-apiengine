<!--begin::Modal - Adjust Balance-->
<div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" id="upload_mobile_plan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">{{ __('plans/energyPlans.upload_plan') }}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_plan_close"aria-label="Close" class=" close btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
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
                <form id="add_mobile_plan_form" class="form">
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5"> {{ __('plans/mobile.uploadFile') }}: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" name="type" value="mobile">
                        <input type="hidden" name="providerId" value="{{$providerId}}">
                        <input type = "file" class="form-control" rows="3" name=upload_plan >
                        <span class="error text-danger upload_plan_error"></span>
                        <!--end::Input-->
                    </div>
                    <div class="text-end">
                        <button type="reset" id="cancel" class="btn btn-light me-3"data-bs-dismiss="modal">{{ __('plans/energyPlans.upload_discard') }}</button>
                        <button type="submit" id="add_plan_submit" class="btn btn-primary">
                            <span class="indicator-label">{{ __('plans/energyPlans.upload_submit') }}</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
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


<!--begin::Modal - Adjust Balance-->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"  id="error-plan-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">{{ __('plans/energyPlans.upload_validation') }}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_plan_close"aria-label="Close" class=" close btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
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
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class no-footer dtr-inline">
                        <thead>
                            <tr>
                                <th class="text-capitalize text-nowrap">
                                {{ __('plans/energyPlans.upload_row') }}
                                </th>
                                <th class="text-capitalize text-nowrap">
                                {{ __('plans/energyPlans.upload_column_name') }}
                                </th>
                                <th class="text-capitalize text-nowrap">
                                {{ __('plans/energyPlans.upload_validation_message') }}
                                </th>
                            </tr>
                    </thead>
                    <tbody id="error_body">

                    </tbody>
				</table>
                <div class="record_info" style="text-align:center">
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->
