<!--begin::Modals-->
<!--begin::Modal - Customers - Add-->
<div class="modal fade" id="assign_handset_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="assigned_handset_form">
                <!--begin::Modal header-->
                <div class="modal-header px-5 py-4" id="kt_modal_assigned_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12">Assign Provider</h2>
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
                            <div class="col-md-3">
                                <label class="form-label">Provider</label>
                                <select class="form-select mb-2 provider-list h-50px border" id="assign_provider_drop_down" data-control="select2" data-hide-search="true" data-placeholder="Provider" data-arial="Provider">
                                    <option value=""></option>
                                    @foreach($providers as $provider)
                                    <option value="{{encryptGdprData($provider->user_id)}}">{{$provider->legal_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h5>Selected Phones</h5>
                        <div class="row mb-4" id="selected_phone_section"></div>
                        <div class="row mb-4" id="selected_phone_to_assign_section"></div>
                    </div>
                    <!--end::Scroll-->
                    <div class="text-end">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_assigned_user_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="button" id="assigned_handset_provider_submit" class="btn btn-primary">
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