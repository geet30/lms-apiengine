<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <form name="dmo_static_form"  id="dmo_static_form" action="{{route('energyplans.update-rates')}}">
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>{{ __('plans/energyPlans.dmo_static_content') }}</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="row mb-0">

                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.enable_dmo_static') }}</label>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="form-check form-check-solid form-switch fv-row field-holder">
                        <input type="hidden" name="dmo_static_content_status" value="0">
                        <input class="form-check-input w-45px h-30px static_checked_status" type="checkbox" id="dmo_content_status" name="dmo_static_content_status" value="1">
                        <label class="form-check-label" for="dmo_static_content_status"></label>
                    </div>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>

            </div>

            <div class="row mb-6">

                <label class="col-lg-4 col-form-label  fw-bold fs-4">{{ __('plans/energyPlans.lowest_possible_cost') }}</label>

                <div class="col-lg-4 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid lowest_annual_cost" placeholder="" name="lowest_annual_cost" >
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">

                <label class="col-lg-4 col-form-label  fw-bold fs-4">{{ __('plans/energyPlans.difference_to_reference_bill_without_discount') }}</label>

                <div class="col-lg-4 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid without_conditional_value"  placeholder="" name="without_conditional_value">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
                <div class="d-flex align-items-center mt-3 field-holder">
                    <label class="form-check form-check-inline form-check-solid me-5">

                        <input class="form-check-input without_conditional without_conditionalfirst" name="without_conditional" type="radio" value="1" >
                        <span class="fw-bold ps-2 fs-6">
                            {{ __('plans/energyPlans.less_than') }}
                        </span>
                    </label>
                    <label class="form-check form-check-inline form-check-solid">

                        <input class="form-check-input without_conditional without_conditionalsecond"  name="without_conditional" type="radio" value="2" >
                        <span class="fw-bold ps-2 fs-6">
                            {{ __('plans/energyPlans.more_than') }}
                        </span>
                    </label>
                    <label class="form-check form-check-inline form-check-solid field-holder">

                        <input class="form-check-input without_conditional without_conditionalthird" name="without_conditional" type="radio" value="3">
                        <span class="fw-bold ps-2 fs-6">
                            {{ __('plans/energyPlans.equal_to') }}
                        </span>
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </label>
                </div>
            </div>
            <div class="row mb-6">

                <label class="col-lg-4 col-form-label  fw-bold fs-4">{{ __('plans/energyPlans.difference_to_reference_bill_without_discount') }}</label>

                <div class="col-lg-4 fv-row field-holder field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid with_conditional_value"  placeholder="" name="with_conditional_value"/>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>

                <div class="d-flex align-items-center mt-3">
                    <label class="form-check form-check-inline form-check-solid me-5 ">

                        <input class="form-check-input with_conditional with_conditionalfirst" name="with_conditional" type="radio" value="1" >

                        <span class="fw-bold ps-2 fs-6">
                            {{ __('plans/energyPlans.less_than') }}
                        </span>

                    </label>
                    <label class="form-check form-check-inline form-check-solid">

                        <input class="form-check-input with_conditional with_conditionalsecond" name="with_conditional" type="radio" value="2" >
                        <span class="fw-bold ps-2 fs-6">
                            {{ __('plans/energyPlans.more_than') }}
                        </span>
                    </label>
                    <label class="form-check form-check-inline form-check-solid field-holder">

                        <input class="form-check-input with_conditional with_conditionalthird" name="with_conditional" type="radio" value="3" >
                        <span class="fw-bold ps-2 fs-6">
                            {{ __('plans/energyPlans.equal_to') }}
                        </span>
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </label>

                </div>
                <span class="form_error_name form_error" style="color: red;"></span>
            </div>
        </div>
        <input type="hidden" name="action_type" value="dmo_static_content">
        <input type="hidden" name="type" value="1">
        <input type="hidden" name="variant" value="3">
        <input type="hidden" name="id" value="" class="static_pid">
        <!--end::Card header-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/plan-rates/'.encryptGdprData($editRate['plan_id']))}}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>

            <button type="button" class="btn btn-primary submit_button" id="dmo_static_btn">

                <span class="indicator-label">
                    {{ __('plans/energyPlans.save_changes') }}
                </span>
                <span class="indicator-progress">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>

            </button>
        </div>
    </div>
    </form>

    <!--end::Pricing-->
</div>
