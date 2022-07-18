<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        {{-- <div class="card-header">
            <div class="card-title">
                <h2>Remarketing Information</h2>
            </div>
        </div> --}}
        <!--end::Card header-->
        <!--begin::Card body-->

        <div class="card-body pt-0">
            <!--begin::Input group-->
            <form class="" method="post" action='{{ route('energyplans.update') }}' id="remarketing_info_form">

            <div class="row mb-0">

                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.remarketing_allow') }}</label>
                <div class="col-lg-8 d-flex align-items-center field-holder">
                    <div class="form-check form-check-solid form-switch fv-row">
                        <input type="hidden" name="remarketing_allow" value="0">
                        <input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing"
                            name="remarketing_allow" value="1">
                        <label class="form-check-label" for="allowmarketing"></label>
                        <span class="form_error" style="color: red;"></span>
                    </div>
                </div>

            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.discount') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value=""
                        placeholder="{{ __('plans/energyPlans.discount') }}" name="discount">
                        <span class="form_error" style="color: red;"></span>

                </div>
            </div>

            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.discount_title') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value=""
                        placeholder="{{ __('plans/energyPlans.discount_title') }}" name="discount_title">
                        <span class="form_error" style="color: red;"></span>

                </div>
            </div>


            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.contract_terms') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value=""
                        placeholder="{{ __('plans/energyPlans.contract_terms') }}" name="month_benfit_period">
                        <span class="form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.termination_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value=""
                        placeholder="{{ __('plans/energyPlans.termination_fee') }}" name="termination_fee">
                        <span class="form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('plans/energyPlans.remarketing_parameters') }}</label>

                <div class="col-lg-8 fv-row">
                    <select name="currency" id="remarketing_pearm" class="form-select form-select-solid form-select-lg" multiple>
                        @foreach ($remarketingAttr as $attr)
                        <option value="{{$attr}}">{{$attr}} </option>
                        @endforeach

                    </select>


                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.T&C') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid ckeditor" value=""
                        placeholder="{{ __('plans/energyPlans.T&C') }}" name="remarketing_terms_conditions"></textarea>
                        <span class="form_error" style="color: red;"></span>


                </div>
            </div>
            <input type="hidden" name="plan_id" value="{{$editPlan['id']}}">
            <input type="hidden" name="action_form" value="remarketing_form">



            <!--end::Input group-->
        </div>
    </form>
        <!--end::Card header-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/'.$editPlan['energy_type'].'/list/'.encryptGdprData($editPlan['provider_id'])) }}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>

            <button type="button" class="btn btn-primary submit_button" id="remarketing_info_btn">

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


    <!--end::Pricing-->
</div>
