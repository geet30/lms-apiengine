<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        {{-- <div class="card-header">
            <div class="card-title">
                <h2>Tag Information</h2>
            </div>
        </div> --}}
        <!--end::Card header-->
        <!--begin::Card body-->
        <form class="" method="post" action='{{ route('energyplans.update') }}' id="plan_tag_form">
        <div class="card-body pt-0">
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.select_tag') }} </label>
                <!--end::Label-->
                <!--begin::Input-->


                <select data-control="select2" data-placeholder="Select Tag" data-control="select2"data-placeholder="{{ __('Plan Type options') }}" class="form-select form-select-solid" name="plan_tags[]" id="plan_tags" multiple>
                    <option value="">Select Tag </option>


                </select>
                <!--end::Input-->
            </div>
        </div>
                 <input type="hidden" name="plan_id" value="{{$editPlan['id']}}">
                 <input type="hidden" name="action_form" value="plan_tag_from">

        <!--end::Card header-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/'.$editPlan['energy_type'].'/list/'.encryptGdprData($editPlan['provider_id'])) }}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>

            <button type="button" class="btn btn-primary submit_button" id="set_tag_btn">

                <span class="indicator-label">
                    {{ __('plans/energyPlans.save_changes') }}
                </span>
                <span class="indicator-progress">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>

            </button>
        </div>
        </form>
    </div>


    <!--end::Pricing-->
</div>
