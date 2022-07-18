<div class="modal fade" id="suburb-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form id="assign_suburb_form" class="form">
                <!--begin::Modal header-->
                <div class="modal-header bg-primary px-5 py-4" id="kt_modal_assigned_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">{{ __('providers.assignSuburbSection.tabSectionTitle') }}</h2>
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
                                <label class="form-label required">{{ __('providers.assignSuburbSection.state_id.label') }}</label>
                                <select class="form-select form-select-solid" id="state_id" name="state_id" data-control="select2" data-hide-search="false" data-placeholder="{{ __('providers.assignSuburbSection.state_id.placeHolder') }}">
                                    <option value=""></option>
                                    @foreach($userStates as $userState )
                                        @if($userState->status == 1)
                                            <option value="{{$userState->state_id}}">{{$userState->state->state_code}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="text-danger errors" id="state_id_error"></span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label required">{{ __('providers.assignSuburbSection.suburbs.label') }}</label>
                                <select class="form-select form-select-solid suburbModal" id="suburbs" name="suburbs[]" data-control="select2"  data-allow-clear="true" data-hide-search="false" data-placeholder="{{ __('providers.assignSuburbSection.suburbs.placeHolder') }}" multiple>

                                </select>
                                <span class="text-danger errors" id="suburb_error"></span>
                            </div>
                        </div>
                    </div>
                    <!--end::Scroll-->

                    <!--begin::Modal footer-->
                    <div class="text-end pt-4">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_assigned_user_cancel" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="button" id="plan_term_condition_form_submit_btn" class="btn btn-primary assign_suburb_submit_btn">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </div>
                <!--end::Modal body-->

            </form>
            <!--end::Form-->
        </div>
    </div>
</div>

<div class="modal fade" id="add-suburb-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form id="add_suburb_form" class="form">
                <!--begin::Modal header-->
                <div class="modal-header bg-primary px-5 py-4" id="kt_modal_assigned_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">Add Suburb</h2>
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
                                <label class="form-label required">Postcode</label>
                                <input type="text" autocomplete="off" name="postcode" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="e.g. 1000">
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label required">Suburb</label>
                                <input type="text" autocomplete="off" name="suburb" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="e.g. SYDNEY">
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label required">{{ __('providers.assignSuburbSection.state_id.label') }}</label>
                                <select class="form-select form-select-solid" id="state" name="state" data-control="select2" data-hide-search="false" data-placeholder="{{ __('providers.assignSuburbSection.state_id.placeHolder') }}">
                                    <option value=""></option>
                                    @foreach($userStates as $userState )
                                        <option value="{{$userState->state->state_code}}">{{$userState->state->state_code}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-6 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Status</label>
                            </div>
                            <div class="col-12 text-center" id="status">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" id="suburb_status_enabled" name="status" type="radio" value="1" checked/>
                                    <span class=" fw-bold ps-2 fs-6">
                                        Enabled
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input radio-w-h-18" id="suburb_status_disabled" name="status" type="radio" value="0"/>
                                    <span class="fw-bold ps-2 fs-6">
                                        Disabled
                                    </span>
                                </label>
                            </div>
                            <span class="text-danger errors text-center"></span>
                        </div>

                    </div>
                    <!--end::Scroll-->

                    <!--begin::Modal footer-->
                    <div class="text-end">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_assigned_user_cancel" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="button" id="plan_term_condition_form_submit_btn" class="btn btn-primary add_suburb_submit_btn">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </div>
                <!--end::Modal body-->

            </form>
            <!--end::Form-->
        </div>
    </div>
</div>

<div class="modal fade" id="import_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="import_form" class="form" enctype="multipart/form-data">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Import Suburb</h2>
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
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <div class="from-group">
                                    {!! Form::file('file', ['class'=>'form-control', 'name'=>'file' , 'id' => 'file']) !!}
                                    <span class="text-danger errors"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
                    <button type="button" id="import_form_submit_btn" class="btn btn-primary" data-form="import_form">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
