<div class="tab-pane fade" id="special_offer" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{__('plans/broadband.special_offer')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_special_offer_price" class="collapse show">
                <!--begin::Form-->
                <form id="special_offer_form" class="form">
                    <!--begin::Card body-->
                    <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                    <input type="hidden" name="formType" value="special_offer_form">
                    <div class="card-body border-top p-9">
                        <!--begin::Input group--> 
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.special_offer_status.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="special_offer_status" type="radio" value="1" {{(isset($plan) && $plan->special_offer_status == 1)?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.special_offer_status_show.label')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="special_offer_status" type="radio" value="0" {{(isset($plan) && $plan->special_offer_status != 1)?'checked':''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.special_offer_status_hide.label')}}</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <span class="error text-danger special_offer_status-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="special_offer_field {{(isset($plan) && $plan->special_offer_status != 1)?'d-none':''}}">
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.special_offer_cost_type.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="special_cost_id" aria-label="{{__('plans/broadband.special_offer_cost_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.special_offer_cost_type.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg">
                                            @foreach($costTypes as $costType)
                                                <option value="{{ $costType->id }}" {{(isset($plan) && $plan->special_cost_id == $costType->id)?'selected':''}}>{{ $costType->cost_name}} </option>
                                            @endforeach 
                                    </select>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.special_offer_price.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="special_offer_price" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.special_offer_price.placeholder')}}" value="{{isset($plan)? $plan->special_offer_price:''}}" />    
                                    <span class="error text-danger"></span>         
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.special_offer_script.label')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <textarea type="text" id="special_offer_id" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="special_offer" style="display: none;">{{isset($plan)? $plan->special_offer:''}}</textarea>
                                    <span class="error text-danger"></span>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                        <button type="submit" class="btn btn-primary">
                            {{__('plans/broadband.save_changes_button')}}
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
        </div>
    </div>
</div>