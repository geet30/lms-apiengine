<x-base-layout>
    <!--begin::Row-->
    <form id="kt_customers_export_form" class="form" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Plan Name:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Enter Plan Name" name="name" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Select Export Format:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select Plan Duration" data-hide-search="true" name="contract_id" id="contract_id" class="form-select form-select-solid">
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
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Connection Type:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select Connection Type" data-hide-search="true" name="connection_type" id="connection_type" class="form-select form-select-solid">
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
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Connection Type Info:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Enter connection type info" name="connection_type_info" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Internet Speed:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Enter internet speed" name="internet_speed" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Internet Speed Info:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Enter internet speed info" name="internet_speed_info" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Plan Cost:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Enter plan cost" name="plan_cost" maxlength="100" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">BYO Modem:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="checkbox" class="form-control" id="planBoyoModem" name="is_boyo_modem" value="0">
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Plan Cost Info:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control" rows="3" name="plan_cost_info" id="plan_cost_info" style=""></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Plan Cost Description:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control" rows="3" name="cost_description" id="cost_description" style=""></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Plan Inclusion:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control" rows="3" name="inclusion" id="inclusion" style=""></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->



                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="close" class="btn btn-light me-3">Discard</button>
                        <button type="submit" id="update_plan" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
    <!--end::Row-->
</x-base-layout>
