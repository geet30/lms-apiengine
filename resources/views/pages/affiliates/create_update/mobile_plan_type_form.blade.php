<form role="form" name="submit_plan_type_form" id="submit_plan_type_form">
    @csrf
    <input type="hidden" name="userId" value="{{encryptGdprData($affiliateuser[0]['user']['id'])}}" />
    <div class="row mb-6">
        <label class="col-lg-2 col-form-label required fw-bold fs-6">Plan Type</label>
        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="aff_plan_type[]" type="checkbox" value="1" {{isset($planTypes[2][1]) && $planTypes[2][1] != 1 ? '':'checked'}}/>
                    <span class="fw-bold ps-2 fs-6">
                        SIM
                    </span>
                </label>
                <label class="form-check form-check-inline form-check-solid me-5">
                    <input class="form-check-input" name="aff_plan_type[]" type="checkbox" value="2"  {{isset($planTypes[2][2]) && $planTypes[2][2] != 1 ? '':'checked'}}/>
                    <span class="fw-bold ps-2 fs-6">
                    SIM+Mobile
                    </span>
                </label>
            </div>
            <span class="error text-danger aff_plan_type_error"></span>

        </div>
       
    </div>
                   
                  
    <div class="text-end">
        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
        <button type="submit" class="btn btn-primary" id="plan_type_submit_btn">
            @include('partials.general._button-indicator', ['label' => __('buttons.save')])
        </button>
    </div>
</form>