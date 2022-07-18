<div class="modal fade" id="life-support-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <form id="life_support_form" class="form">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Add Life Support Equipment</h2>
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
                        <input type="hidden" id="life_support_status" name="status" value="0"/>
                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Title</label>
                                <input type="text" id="" autocomplete="off" name="title" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. title" value=""/>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Energy type</label>
                                <select class="form-control form-control-solid form-select userservice p-4" id="energy_type" name="energy_type" data-placeholder="Select">
                                    <option value="">Select</option>
                                    <option value="1">Electricity</option>
                                    <option value="2">Gas</option>
                                    <option value="3">Both</option>
                                </select>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="kt_modal_assigned_user_cancel2" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                    <button type="button" id="life_support_form_submit_btn" class="btn btn-primary" data-form="life_support_form">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="master-life-support-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <form id="affiliate_life_support_content_form" class="form">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Life Support Content</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                                </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label class="col-12 col-form-label fw-bold fs-6 required">Content:</label>
                        <div class="col-12 fv-row field-holder">
                            <textarea name="content" class="form-control form-control-lg form-control-solid ckeditor" id="content"></textarea>
                            <span class="errors text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="kt_modal_assigned_user_cancel2" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                    <button type="submit" id="master_life_support_form_submit_btn" class="btn btn-primary" data-form="master_life_support_form">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
