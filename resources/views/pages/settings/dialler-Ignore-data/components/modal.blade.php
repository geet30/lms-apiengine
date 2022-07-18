<div class="modal fade" id="dialler_ignore_data_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="dialler_ignore_data_form" class="form">
                @csrf
                <input type="hidden" id="data_id" name="data_id">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title" id="modal_title">Add Dialler Ignore Data</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row mb-4 field-holder">
                            <div class="col-12 type">
                                <label class="form-label required">Type</label>
                                <h2 name="content_type" id="content_type"></h2>
                                <input type="hidden" id="type" name="type">
                                <!-- <input type="text" name="diallerContentType" id="diallerContentType" class="form-control form-control-lg form-control-solid" style="cursor: not-allowed;"> -->
                                <!-- <select id="type" name="type" class="form-select form-select-solid" data-placeholder="Select" data-dropdown-parent="#dialler_ignore_data_modal" data-allow-clear="true" aria-hidden="true">
                                    <option></option>
                                    <option value="1">Name</option>
                                    <option value="2">Email</option>
                                    <option value="3">Phone</option>
                                    <option value="4">Domain</option>
                                    <option value="5">Ips</option>
                                    <option value="6">Ip Range</option>
                                </select> -->
                                <span class="text-danger" id="type_error"></span>
                            </div>
                        </div>
                        <div id="content_section">
                            <div class="row mb-12">
                                <label id="content_name_label" name="content_name_label" class="col-lg-12 col-form-label required fw-bold fs-6"></label>
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="content_name" id="content_name" class="form-control form-control-lg form-control-solid" placeholder="Enter" />
                                    <span id="content_name_error" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label">Comment</label>
                                <div class="col-lg-12 fv-row">
                                    <textarea class="form-control" name="comment" id="comment"></textarea>
                                    <span class="error" id="comment_error" style="color: red;"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.tnc.modalCancelButton')}}</button>
                    <button type="button" id="dialler_ignore_data_form_submit_btn" class="btn btn-primary" data-form="dialler_ignore_data_form">
                        {{ __ ('mobile.formPage.tnc.modalSubmitButton')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>