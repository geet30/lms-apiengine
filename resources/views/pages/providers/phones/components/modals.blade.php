<div class="modal fade" id="assign_phone_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">{{ __ ('plans/mobile.assign_phone_modal_title')}}</h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">
                <form id="assign_phone_form" accept-charset="UTF-8" class="form submit_apikey_form pb-0"> 
                <input type="hidden" name="provider_id" value="{{$providerId}}">
                <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label required">{{ __ ('plans/mobile.select_phone')}}</label> 
                            <select name="select_assign_handset[]" id ="select_assign_handset" aria-label="{{__('plans/broadband.technology_type.placeholder')}}" data-control="select2" data-placeholder="Select Phone" class="form-select form-select-solid form-select-lg all_handsets_list" multiple="multiple">
                            </select>
                            <span class="text-danger errors" id="term_title_content_error"></span>
                        </div>
                    </div> 
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">{{ __('buttons.save') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 