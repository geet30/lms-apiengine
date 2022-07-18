<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        {{-- <div class="card-header">
            <div class="card-title">
                <h2>Plan View</h2>
            </div>
        </div> --}}
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Input group-->

            <form  class="" method="post" action='{{route("energyplans.update")}}' id="plan_view_form">
            <div class="row mb-6 ">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.discount') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea name="view_discount" class="form-control form-control-lg form-control-solid ckeditor"
                       >{{$editPlan['view_discount']}}</textarea>
                        <span class="form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.bonus') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea name="view_bonus" id="view_bonus" class="form-control form-control-lg form-control-solid ckeditor "
                        > {{$editPlan['view_bonus']}} </textarea>
                        <span class="form_error_view_bonus form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.contract') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea name="view_contract" id="view_contract" class="form-control form-control-lg form-control-solid ckeditor"
                        value="">{{$editPlan['view_contract']}}</textarea>
                        <span class="form_error_view_contract form_error" style="color: red;"></span>
                </div>
            </div>

            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.exit_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea name="view_exit_fee" id="view_exit_fee" class="form-control form-control-lg form-control-solid ckeditor" value="">{{$editPlan['view_exit_fee']}}</textarea>
                        <span class="form_error_view_exit_fee form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.benefit_terms') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea name="view_benefit" row="10"
                        class="form-control form-control-lg form-control-solid ckeditor" id="view_benefit" value="">{{$editPlan['view_benefit']}}</textarea>
                        <span class="form_error_view_benefit form_error" style="color: red;"></span>
                    </div>
            </div>
            <input type="hidden"name = "action_form" value = "plan_view_form">
            <input type="hidden"name = "plan_id" value = {{$editPlan['id']}}>
            <!--end::Input group-->
        </div>

        <!--end::Card header-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/'.$editPlan['energy_type'].'/list/'.encryptGdprData($editPlan['provider_id'])) }}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>


            <button type="button" class="btn btn-primary submit_button" id="submit_plan_view">

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
