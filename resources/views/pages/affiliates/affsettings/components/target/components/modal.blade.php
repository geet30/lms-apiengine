<div class="modal fade" id="settargetmodel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">{{ __('affiliates_label.targets.target_info') }}</h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y">
                <form id="add_update_targetform" name="add_update_targetform" accept-charset="UTF-8" class="form submit_target_form">
                    <input class="" id="hidden_edit_id" type="hidden" value="" />
                    @csrf
                    <div class="fv-row mb-5 field-holder">
                        <label class="fs-5 fw-bold  required form-label mb-1">{{ __('affiliates_label.targets.target_month') }}</label>
                        <input class="form-control targetinput form-control-solid h-50px border" placeholder="{{ __('affiliates_label.targets.month_year_placeholder') }}" name="target_date" readonly="true" id="date_picker" />
                        <span class="form_error" style="color: red; display: none;"></span>
                    </div>
                    <div class="fv-row mb-5 field-holder">
                        <label class="fs-5 fw-bold required form-label mb-1">{{ __('affiliates_label.targets.target_value') }}</label>
                        <input class="form-control targetinput form-control-solid h-50px border" placeholder="{{ __('affiliates_label.targets.value_placeholder') }}" id="target_value" name="target_value" />
                        <span class="form_error" style="color: red; display: none;"></span>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-bold form-label mb-1">{{ __('affiliates_label.targets.comment') }}</label>
                        <textarea class="form-control targetinput form-control-solid h-50px border" rows="4" id="comment" cols="40" name="comment" placeholder="{{ __('affiliates_label.targets.comment_placeholder') }}"></textarea>
                        <span class="form_error" style="color: red; display: none;"></span>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>

                        <button type="submit" id="savetargetData" class="btn btn-primary">
                            <span class="indicator-label">{{ __('buttons.save') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>