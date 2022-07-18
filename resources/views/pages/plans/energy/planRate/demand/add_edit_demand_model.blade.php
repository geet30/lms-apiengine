<!--begin::Modal - Adjust Balance-->

<div class="modal fade" id="add_edit_demand" tabindex="-1" role="dialog" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">{{ __('plans/energyPlans.add_new_tariff') }}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_plan_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <form id= "demand_form" name="demand_form" action="{{route('energyplans.demand.create-update')}}">
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="add_plan_form" class="form" action="#">
                    <input type="hidden" id="distributorId" value="{{isset($distributorId)?decryptGdprData($distributorId):''}}">
                    <input type="hidden" id="property_type" value="{{isset($property_type)?$property_type:''}}">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.demand_tariff_code') }}:</label>
                        <!--end::Label-->
                        <select data-control="select2" data-placeholder="Select Demand Tariff" data-hide-search="true"
                            name="tariff_code_ref_id" id="tariff_code_ref_id" class="form-select form-select-solid select2-hidden-accessible"
                            tabindex="-1" aria-hidden="true">
                            <option value="">Select Tariff Code</option>
                        </select>
                        <span class="form_error" style="color: red;"></span>
                    </div>


                    <div class="fv-row mb-10 field-holder field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.demand_tariff_discount') }}:</label>
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="{{ __('plans/energyPlans.demand_tariff_discount') }}"
                            name="tariff_discount" />
                        <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.demand_tariff_daily_supply') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="{{ __('plans/energyPlans.demand_tariff_daily_supply') }}"
                            name="tariff_daily_supply" />
                            <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.tariff_supply_discount') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="{{ __('plans/energyPlans.tariff_supply_discount') }}"
                            name="tariff_supply_discount" />
                            <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.relational_demand_tariff') }}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select Demand aliases" data-hide-search="true"
                            name="tariff_code_aliases[]" id="tariff_code_aliases" class="form-select form-select-solid select2-hidden-accessible"
                            tabindex="-1" aria-hidden="true" multiple>
                                <option value="">Select Tariff Code</option>

                        </select>
                        <span class="form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.daily_supply_charges_desc') }}:</label>

                        <textarea class="form-control" name="daily_supply_charges_description"></textarea>
                        <span class="form_error" style="color: red;"></span>

                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.discount_usage_desc') }}:</label>

                        <textarea class="form-control" name="discount_on_usage_description"></textarea>
                        <span class="form_error" style="color: red;"></span>

                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('plans/energyPlans.discount_supply_desc') }}:</label>

                        <textarea class="form-control" name="discount_on_supply_description"></textarea>
                        <span class="form_error" style="color: red;"></span>

                    </div>
                    <input type="hidden"name="rate_id" value="{{$rateId}}"/>
                  
                    <input type="hidden"name="id" value=""/>

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="cancel" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('plans/energyPlans.discard') }}</button>
                        <button type="button" id="add_demand" data-id="" class="btn btn-primary submit_button">
                            <span class="indicator-label">{{ __('plans/energyPlans.submit') }}</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->
