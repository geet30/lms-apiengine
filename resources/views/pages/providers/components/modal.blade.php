<!--begin::Modal - Adjust Balance-->
<div class="modal fade" data-bs-target="backdrop" data-bs-keyboard="false" id="add_provider_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder text-white fs-12">Add New Provider</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                <form id="kt_customers_export_form" class="form" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Select Srvice <span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select a Service" data-hide-search="true" name="format" class="form-select h-50px border form-select-solid" multiple>
                            <option value="">Select Service</option>
                            <option value="energy">energy</option>
                            <option value="broadband">broadband</option>
                            <option value="mobile">Mobile</option>


                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Business Name<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="Business Name" name="business_name" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">ABN/ACN<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="ABN/ACN" name="abn_acn" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Phone<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="Phone" name="provider_phone" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Email<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="Phone" name="provider_email" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Legal Name<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="Legal Name" name="provider_legal_name" />
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Support Email<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="Support Email" name="provider_suport_email" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Description<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type ="textera" class="form-control form-control-solid h-50px border" placeholder="Complaint Email" name="provider_complaint_email" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Address<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="Address" name="provider_address" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Provider Logo<span class="star">*</span></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type = "file" class="form-control form-control-solid h-50px border" placeholder="Logo" name="provider_logo" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Row-->

                    <!--end::Row-->
                    <!--begin::Actions-->
                    <div class="text-end">
                        <button type="reset" id="discard_btn" class="btn btn-light me-3">Discard</button>
                        <button type="submit" id="provider_detail_submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
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

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="provider-detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h4 class="fw-bolder fs-12 text-white">Provider Information</h4>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1 hideapkipopup">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <span class="indicator-progress">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </div>
        </div>
    </div>
</div>

