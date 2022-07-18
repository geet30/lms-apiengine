<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="eic_model" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">Eic Checbox</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
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
                <form class="" method="post" action='{{ route('energyplans.update') }}' id="eic_content_checkbox_form">
                    <!--begin::Input group-->

                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold  required form-label mb-1">Checkbox Required</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-check form-check-solid form-switch fv-row field-holder">
                            <input type="hidden" name="demand_usage_check" value="0">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="checkbox_required" name="checkbox_required" value="1">
                            <label class="form-check-label" for="checkbox_required"></label>
                            <span class="form_error" style="color: red;"></span>
                        </div>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label  required mb-1">Validation Message </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="" name="validation_message"/>
                        <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold  required form-label mb-1"> Save Checkbox Status in Database ?</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-check form-check-solid form-switch fv-row field-holder">
                            <input type="hidden" name="save_checkbox_status" value="0">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="save_checkbox_status" name="save_checkbox_status" value="1">
                            <label class="form-check-label" for="save_checkbox_status"></label>
                            <span class="form_error" style="color: red;"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold  required form-label mb-1"> Select EIC Type:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                            <select name="eic_type" id ="eic_type" class="form-select form-select-solid form-select-lg h-50px border">
                            @foreach ($moduleTypes as $attr)
                                <option value="{{$attr}}">{{$attr}} </option>
                            @endforeach
                        </select>

                        <span class="form_error" style="color: red;"></span>

                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-5 ">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold  required form-label mb-1"> Select EIC Type:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select name="eic_parameter" id="eic_parameter_checkbox" class="form-select form-select-solid form-select-lg h-50px border"
                        multiple>
                        @foreach ($eicAttr as $attr)
                        <option value="{{$attr}}">{{$attr}} </option>
                        @endforeach

                    </select>



                        <!--end::Input-->
                    </div>


                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label  required mb-1">Checkbox Content* </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea  class="form-control form-control-lg form-control-solid ckeditor" value=""
                     name="checbox_content"></textarea>
                        <!--end::Input-->
                        <span class="form_error" style="color: red;"></span>
                    </div>
                    <!--end::Row-->
                    <!--begin::Actions-->
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="type_id" value="">
                    <input type="hidden" name="action_form" value="eic_content_checkbox_form">
                    <div class="text-end">
                        <button type="reset" id="kt_customers_export_cancel" data-bs-dismiss="modal"

                        class="btn btn-light me-3">Cancel</button>
                        <button type="button" id="eic_content_checkbox_btn" class="btn btn-primary submit_button">
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
