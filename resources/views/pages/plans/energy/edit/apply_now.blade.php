<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        {{-- <div class="card-header">
            <div class="card-title">
                <h2>Apply Now Content</h2>
            </div>
        </div> --}}
        <!--end::Card header-->
        <!--begin::Card body-->
        <form class="" method="post" action='{{ route('energyplans.update') }}' id="apply_now_form">
        <div class="card-body pt-0">
            <!--begin::Input group-->
            <div class="row mb-0">

                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.apply_now_content') }}</label>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="form-check form-check-solid form-switch fv-row">
                        <input type="hidden" name="apply_now_status" value="0">
                        <input class="form-check-input w-45px h-30px" type="checkbox" id="apply_now_status"
                            name="apply_now_status" value="1" @if($editPlan['apply_now_status']==1) checked @endif>
                        <label class="form-check-label" for="apply_now_status"></label>
                    </div>
                </div>

            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.apply_now_attributes') }}</label>

                <div class="col-lg-8 fv-row">
                    <select name="apply_now_parameters" id="apply_now_parameters" class="form-select form-select-solid form-select-lg" multiple>
                        @foreach ($applyNowAttr as $attr)
                        <option value="{{$attr}}">{{$attr}} </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.apply_now_content') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid ckeditor" value=""
                        placeholder="{{ __('plans/energyPlans.apply_now_content') }}" name="apply_now_content" id="apply_now_content">{{$editPlan['apply_now_content']}}</textarea>
                        <span class="form_error" style="color: red;"></span>
                </div>
            </div>
            <input type="hidden" name="plan_id" value="{{$editPlan['id']}}">
            <input type="hidden" name="action_form" value="apply_now_content_form">



            <!--end::Input group-->
        </div>
        <!--end::Card header-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/'.$editPlan['energy_type'].'/list/'.encryptGdprData($editPlan['provider_id'])) }}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>

            <button type="button" class="btn btn-primary submit_button" id="apply_now_btn">

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
