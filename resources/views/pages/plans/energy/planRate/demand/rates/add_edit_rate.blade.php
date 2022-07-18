<!--begin::Modal - Adjust Balance-->
<div class="modal fade " id="add_plan_rate_modal"  tabindex="-1" role="dialog" aria-hidden="false" data-bs-backdrop="static" data-bs-keyboard="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">{{ __('plans/energyPlans.add_new_plan') }}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_plan_close" data-bs-dismiss="modal"  class="btn btn-icon btn-sm btn-active-icon-primary">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="add_demand_rate_form" class="form" action="{{route('energyplans.demand.rate.create-update')}}">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10 field-holder field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Season/Rate Type:</label>
                        <!--end::Label-->
                        <select data-control="select2"  id="season_rate_type" data-placeholder="Select Rate Type" data-hide-search="true"
                            name="season_rate_type" class="form-select form-select-solid select2-hidden-accessible hide_selects"
                            tabindex="-1" aria-hidden="true">
                            @foreach ($demandRateTypes as $key=>$value)
                            <option value="{{$key}}" >{{$value}}</option>
                            @endforeach
                        </select>
                        <span class="season_rate_type_text" style="display:none;"></span>
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Usage Type:</label>


                        <!--end::Label-->
                        <select data-control="select2" id="usage_type"  data-placeholder="Select limit" data-hide-search="true"
                            name="usage_type" class="form-select form-select-solid select2-hidden-accessible hide_selects"
                            tabindex="-1" aria-hidden="true">
                            <option value="">Select limit type</option>
                        </select>
                        <span class="usage_type_text" style="display:none;"></span>
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Usage Level:</label>
                        <!--end::Label-->
                        <select data-control="select2" data-placeholder="Select limit" data-hide-search="true"
                            name="limit_level" id="limit_level" class="form-select form-select-solid select2-hidden-accessible hide_selects"
                             tabindex="-1" aria-hidden="true">
                            <option value="">Select limit</option>
                        </select>
                        <span class="limit_level_text" style="display:none;"></span>
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Usage Charges:</label>
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Usage Charges"
                            name="limit_charges" />
                            <span class="form_error_name form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Limit Daily:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Limit Daily"
                            name="limit_daily" />
                            <span class="form_error_name form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Limit Yearly:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control" placeholder="Limit Yearly"
                            name="limit_yearly" />
                            <span class="form_error_name form_error" style="color: red;"></span>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-10 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-5">Usage Description:</label>

                        <textarea class="form-control" name="usage_discription"></textarea>
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </div>
                    <input type="hidden"name="id"/>
                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="cancel" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
                        <button type="button" id="add_demand_rate_btn" class="btn btn-primary submit_button">
                            <span class="indicator-label">Submit</span>
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
