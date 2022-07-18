<div class="d-flex flex-column gap-7 gap-lg-10">
    @include('pages.plans.energy.edit.eic_model')
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        {{-- <div class="card-header">
            <div class="card-title">
                <h2>Plan Eic Content</h2>
            </div>
        </div> --}}
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Input group-->
            <form class="" method="post" action='{{ route('energyplans.update') }}' id="eic_content_form">
                <div class="row mb-0">

                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.enable_eic_plan') }}</label>
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch fv-row">
                            <input type="hidden" name="eic_status" value="0">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="eic_status"
                                name="eic_status" value="1">
                            <label class="form-check-label" for="eic_status"></label>
                        </div>
                    </div>

                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('plans/energyPlans.eic_parameters') }}</label>

                    <div class="col-lg-8 fv-row">
                        <select name="eic_parameter" id="eic_parameter" class="form-select form-select-solid form-select-lg"
                            multiple>
                            @foreach ($eicAttr as $attr)
                            <option value="{{$attr}}">{{$attr}} </option>
                            @endforeach

                        </select>

                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.eic_content') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea class="form-control form-control-lg form-control-solid ckeditor" value=""
                            placeholder="{{ __('plans/energyPlans.eic_content') }}" name="eic_editor"></textarea>
                        <span class="form_error" style="color: red;"></span>

                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->

                    <label class="col-lg-4 col-form-label   fw-bold fs-6"></label>
                    <div class="col-lg-8 fv-row" style="text-align: end;">
                        <input type="button" id="add_checkbox" data-bs-toggle="modal" data-bs-target="#eic_model"
                            value="Add Checkbox" class="btn btn-primary">


                    </div>
                </div>


                <div class="col-md-12 col-sm-offset-3 field-holder eic-checkbox-inner-loader">
                    <table id="eic_checkbox_table"class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class">
                        <thead>
                            <tr class="fw-bolder fs-7 text-gray-800 px-7">
                                <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.sr_no') }}</th>
                                <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.required') }}</th>

                                <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.validation_message') }}</th>
                                <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.eic_type') }}</th>
                                <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.save_checkbox_status') }}</th>
                                <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="eic_table_body">
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="plan_id" value="{{ $editPlan['id'] }}">
                <input type="hidden" name="action_form" value="eic_content_form">


                <!--end::Input group-->
        </div>
        <!--end::Card header-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/'.$editPlan['energy_type'].'/list/'.encryptGdprData($editPlan['provider_id'])) }}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>

            <button type="button" class="btn btn-primary submit_button" id="eic_content_btn">

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
