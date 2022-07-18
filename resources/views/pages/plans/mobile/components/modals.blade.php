<!--begin::Modal - plan-reference-->
<div class="modal fade" id="plan-reference-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form id="plan_reference_form" class="form">
                <!--begin::Modal header-->
                <div class="modal-header bg-primary px-5 py-4" id="kt_modal_assigned_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">{{ __ ('mobile.formPage.planRef.modal.modalTitle')}}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
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
                <div class="modal-body">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.planRef.modal.s_no.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select class="form-select fsorm-select-transsparent" disabled="disabled" name="s_no" data-control="select2" data-hide-search="false" aria-label="{{ __ ('mobile.formPage.planRef.modal.s_no.placeHolder')}}" data-placeholder="{{ __ ('mobile.formPage.planRef.modal.s_no.placeHolder')}}">
                                    @for($i = 1; $i<= count($plan->planMobileReferences)+1; $i++)
                                        <option value="{{$i}}" @if($i==count($plan->planMobileReferences)+1) selected @endif >{{$i}}</option>
                                        @endfor
                                </select>
                                <input type="hidden" class="form-control" name="current_s_no" id="current_s_no" />
                                <span class="text-danger errors" id="s_no_error"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.planRef.modal.title.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" autocomplete="off" name="title" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.planRef.modal.title.placeHolder')}}" value="" />
                                <span class="text-danger errors" id="title_error"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.planRef.modal.linktype.label')}}</label>

                            <div class="col-lg-8 fv-row">
                                <div class="row">
                                    <div class="col-3 text-right">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="1" name="linktype" id="linktype_url" checked />
                                            <label class="form-check-label" for="linktype_url">
                                                {{ __ ('mobile.formPage.planRef.modal.linktype.url')}}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-3 text-left">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="2" name="linktype" id="linktype_file" />
                                            <label class="form-check-label" for="linktype_file">
                                                {{ __ ('mobile.formPage.planRef.modal.linktype.file')}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-left">
                                        <span class="text-danger errors" id="linktype_error"></span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="url_box">
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.planRef.modal.url.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" autocomplete="off" name="url" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.planRef.modal.url.placeHolder')}}" value="" />
                                    <span class="text-danger errors" id="url_error"></span>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div id="file_box" style="display: none;">
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.planRef.modal.file.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="file" name="file" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                                    <span class="text-danger errors" id="file_error"></span>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>



                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer text-end">
                    <!--begin::Button-->
                    <button type="reset" id="plan_reference_form_reset_btn" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.planRef.modal.cancelButton')}}</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="plan_reference_form_submit_btn" class="btn btn-primary submit_btn" data-form="plan_reference_form" data-title="Plan References">
                        <span class="indicator-label">{{ __ ('mobile.formPage.planRef.modal.submitButton')}}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--begin::Modal - plan-reference-modal-->


<!--begin::Modal - terms-conditions-modal-->
<div class="modal fade" id="terms-conditions-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form id="plan_term_condition_form" class="form">
                <!--begin::Modal header-->
                <div class="modal-header bg-primary px-5 py-4" id="kt_modal_assigned_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">{{ __ ('mobile.formPage.tnc.tncModalTitle')}}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
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
                <div class="modal-body">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label required">{{ __ ('mobile.formPage.tnc.term_title_content.label')}}</label>
                                <input type="text" autocomplete="off" name="term_title_content" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.tnc.term_title_content.placeHolder')}}" value="" />
                                <span class="text-danger errors" id="term_title_content_error"></span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">{{ __ ('mobile.formPage.tnc.term_content.label')}}</label>
                                <textarea name="term_content" id="term_content" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.tnc.term_content.placeHolder')}}"></textarea>
                                <span class="text-danger errors" id="term_content_error"></span>
                            </div>
                        </div>
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer text-end">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_assigned_user_cancel" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.tnc.modalCancelButton')}}</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="plan_term_condition_form_submit_btn" class="btn btn-primary submit_btn" data-form="plan_term_condition_form" data-title="Terms & Conditions">
                        <span class="indicator-label">{{ __ ('mobile.formPage.tnc.modalSubmitButton')}}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--begin::Modal - terms-conditions-modal-->