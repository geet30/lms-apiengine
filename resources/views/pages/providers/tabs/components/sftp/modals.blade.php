
<div class="modal fade" id="sftp-logs-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <form id="sftp_logs_form" class="form">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder">Manage SFTP Log Emails</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                                </svg>
                            </span>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">

                        <input type="hidden" name="provider_id" value="{{$providerId}}">

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">From Email</label>
                                <input type="text" autocomplete="off" name="log_from_email" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. admin@cimet.com.au" value=""/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">From Name</label>
                                <input type="text" autocomplete="off" name="log_from_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. cimet" value=""/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Subject</label>
                                <input type="text" autocomplete="off" name="log_subject" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. sFTP upload logs" value=""/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">To</label>
                                <textarea autocomplete="off" name="log_to_emails" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. admin@cimet.com.au,qa@cimet.com.au" cols="30" rows="3"></textarea>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="kt_modal_assigned_user_cancel1" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.tnc.modalCancelButton')}}</button>
                    <button type="button" id="sftp_logs_form_submit_btn" class="btn btn-primary" data-form="plan_term_condition_form">
                        {{ __ ('mobile.formPage.tnc.modalSubmitButton')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="add-sftp-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <form id="add_sftp_form" class="form">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Add SFTP</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                                </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                        <input type="hidden" name="provider_id" value="{{$providerId}}">
                        <input type="hidden" id="sftp_status" name="status" value="0"/>
                        <input type="hidden" id="sftp_id" name="sftp_id" value=""/>
                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Destination Name</label>
                                <input type="text" id="destination_name" autocomplete="off" name="destination_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. destination one" value=""/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <label class="form-label required">Authentication Type</label>
                            <div class="col-12">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" name="auth_type" id="key-auth" type="radio" value="0" checked/>
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Key Auth') }}
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input" name="auth_type" id="password-auth" type="radio" value="1"/>
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Password') }}
                                    </span>
                                </label>
                            </div>
                            <span class="form_error" style="color: red; display: none;"></span>
                        </div>

                        <div class="row mb-4 field-holder">
                            <label class="form-label required">Protocol Type</label>
                            <div class="col-12">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" name="protocol_type" id="ftp" type="radio" value="0" checked/>
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('FTP') }}
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input" name="protocol_type" id="sftp" type="radio" value="1"/>
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('SFTP') }}
                                    </span>
                                </label>
                            </div>
                            <div class="text-danger errors" id="protocol_type_error"></div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required m-0">Remote Host</label>
                                <input type="text" autocomplete="off" name="remote_host" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. cimet.com.au or 192.168.11.22"/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required m-0">Port</label>
                                <input type="number" min="1" max="65535" autocomplete="off" name="port" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 22" value="22"/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required m-0">Remote Account User Name</label>
                                <input type="text" autocomplete="off" name="username" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. cimet2022"/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required m-0">Remote Password</label>
                                <input type="password" autocomplete="off" name="password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder=""/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label m-0">Timeout Time</label>
                                <input type="number" min="0" step="5" autocomplete="off" name="timeout" value="30" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="30"/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label">Upload Directory.</label>
                                <input type="text" autocomplete="off" name="directory" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="" value="/"/>
                                <span class="form_error" style="color: red; display: none;"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="kt_modal_assigned_user_cancel2" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.tnc.modalCancelButton')}}</button>
                    <button type="button" id="add_sftp_form_submit_btn" class="btn btn-primary" data-form="add_sftp_form">
                        {{ __ ('mobile.formPage.tnc.modalSubmitButton')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
