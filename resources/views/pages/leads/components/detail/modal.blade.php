<!--begin::Modals-->
<!--begin::Modal - Customers - Add-->

<div class="modal fade" id="kt_assign_change_affiliate" tabindex="-1" role="dialog" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="assigned_user_form">
                <!--begin::Modal header-->
                <div class="modal-header px-5 py-4" id="kt_modal_assigned_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 dynamic_affiliate_heading">Change Affiliate</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_close"
                        class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill"
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
                <div class="modal-body">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_assigned_user_header"
                        data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">

                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5 select-affiliate-heading"> Select Affiliate:
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="verticalId" value="{{ $verticalId }}">
                            <input type="hidden" name="lead_id"
                                value="{{ isset($saleDetail) ? $saleDetail->l_lead_id : 'N/A' }}">
                            <input type="hidden" name="email"
                                value="{{ isset($saleDetail->v_email) ? $saleDetail->v_email : 'N/A' }}"
                                id="affiliate_visitor_email">
                            <input type="hidden" name="phone"
                                value="{{ isset($saleDetail->v_phone) ? $saleDetail->v_phone : 'N/A' }}"
                                id="affiliate_visitor_phone">
                            <input type="hidden" name="type" value="" id="affiliate_select_type">

                            <select data-control="select2"
                                class="form-select-solid form-select select2-hidden-accessible" name="affiliate_id"
                                data-placeholder="Affiliate Name" id="affiliate_select_options"
                                data-select2-id="select2-data-52-mkdi" tabindex="-1" aria-hidden="true">

                            </select>
                            <span class="error text-danger"></span>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <div class="text-end">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_assigned_user_cancel" data-bs-dismiss="modal"
                            class="btn btn-light me-3">Discard</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_modal_assigned_user_submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->

            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Customers - Add-->

<!-- The Modal -->
<div class="modal fade" id="api_response_popup" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">API Response</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="/*overflow:scroll;*/word-break: break-all;">
                <div id="api_header_here" style="display: none">
                </div>
                <pre id="api_request_data" style="word-wrap: break-word; white-space: pre-wrap; display:none;">
                <div id="api_request_here">
                </div>
            </pre>
            <pre id="api_response_data" style="word-wrap: break-word; white-space: pre-wrap; display:none;">
                <div id="api_response_here">
                </div>
            </pre>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="kt_modal_resend_mail" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">Resend Welcome Email</h2>
                <div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>

            <div class="modal-body px-5">
                <div class="row mb-6">
                    <label class="col-lg-12 col-form-label fw-bold fs-12">Are you sure you want to send welcome email to
                        {{ isset($saleDetail->v_email) ? strtolower(decryptGdprData($saleDetail->v_email)) : '' }}
                        ?</label>

                </div>
                <input type="hidden" id="lead_id"
                    value="{{ isset($saleDetail->l_lead_id) ? $saleDetail->l_lead_id : '' }}">
                <input type="hidden" id="service_id"
                    value="{{ isset($saleDetail->sale_product_service_id) ? $saleDetail->sale_product_service_id : '' }}">

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a class="btn btn-light btn-active-light-primary me-2" href="" data-bs-dismiss="modal">Cancel</a>
                    <button type="button" id="send_resend_email" class="submit_button"
                        class="btn btn-primary">Send</button>
                </div>

            </div>
        </div>
    </div>
</div>
