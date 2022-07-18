<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="add_plan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">Add New Provider</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_plan_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
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
                <form id="add_plan_form" class="form" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Plan Name:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid h-50px border" placeholder="Enter Plan Name" name="name" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Select Export Format:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select Plan Duration" data-hide-search="true" name="contract_id" id="contract_id" class="form-select form-select-solid h-50px border">
                            <option value="">Select Plan Duration</option>
                            <option value="37">1 Months </option>
                            <option value="27">3 Months </option>
                            <option value="26">6 Months </option>
                            <option value="25">12 Months </option>
                            <option value="43">24 Months </option>
                            <option value="42">36 Months </option>
                            <option value="41">200 Months </option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Connection Type:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select Connection Type" data-hide-search="true" name="connection_type" id="connection_type" class="form-select form-select-solid h-50px border">
                            <option value="1">NBN</option>
                            <option value="2">ADSL</option>
                            <option value="3">CABLE</option>
                            <option value="4">4G Home Internet</option>
                            <option value="5">5G Home Internet</option>
                            <option value="34">OptiComm</option>
                            <option value="53">LBN</option>
                            <option value="62">Mobile Broadband</option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Connection Type Info:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid h-50px border" placeholder="Enter connection type info" name="connection_type_info" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Internet Speed:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid h-50px border" placeholder="Enter internet speed" name="internet_speed" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Internet Speed Info:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid h-50px border" placeholder="Enter internet speed info" name="internet_speed_info" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Plan Cost:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid h-50px border" placeholder="Enter plan cost" name="plan_cost" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">BYO Modem:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="checkbox" class="form-control form-control-solid h-50px border" id="planBoyoModem" name="is_boyo_modem" value="0">
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Plan Cost Info:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control" rows="3" name="plan_cost_info" id="plan_cost_info" style=""></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Plan Cost Description:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control" rows="3" name="cost_description" id="cost_description" style=""></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Plan Inclusion:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control" rows="3" name="inclusion" id="inclusion" style=""></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->



                    <!--begin::Actions-->
                    <div class="text-end">
                        <button type="reset" id="cancel" class="btn btn-light me-3">Discard</button>
                        <button type="submit" id="add_plan_submit" class="btn btn-primary">
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