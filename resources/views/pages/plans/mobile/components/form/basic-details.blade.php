<div class="tab-pane fade show active" id="basic_details" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#basic_details_section">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.basicDetails.sectionTitle')}}</h3>
            </div>
        </div>
        <div id="basic_details_section" class="collapse show">
            <!--begin::Form-->
            <form id="plan_basic_details_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.name.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.basicDetails.name.placeHolder')}}" value="{{isset($plan) ? $plan->name :''}}" autocomplete="off" />
                            <span class="text-danger errors" id="name_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.connection_type.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <select class="form-select fsorm-select-transsparent" name="connection_type" data-control="select2" data-hide-search="false" aria-label="{{ __ ('mobile.formPage.basicDetails.connection_type.placeHolder')}}" data-placeholder="{{ __ ('mobile.formPage.basicDetails.connection_type.placeHolder')}}">
                                <option value=""></option>
                                @foreach($connectionTypes as $connectionType)
                                @if($connectionType->connection_type_id == 1)
                                <option value="{{$connectionType->local_id}}" {{isset($plan) && $plan->connection_type == $connectionType->local_id ? 'selected' :''}}>{{$connectionType->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            <span class="text-danger errors" id="connection_type_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.plan_type.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <select class="form-select fsorm-select-transsparent" name="plan_type" data-control="select2" data-hide-search="false" aria-label="{{ __ ('mobile.formPage.basicDetails.plan_type.placeHolder')}}" data-placeholder="{{ __ ('mobile.formPage.basicDetails.plan_type.placeHolder')}}">
                                <option value=""></option>

                                @foreach($connectionTypes as $connectionType)
                                @if($connectionType->connection_type_id == 2)
                                <option value="{{$connectionType->local_id}}" {{isset($plan) && $plan->plan_type == $connectionType->local_id ? 'selected' :''}}>{{$connectionType->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            <span class="text-danger errors" id="plan_type_error"></span>
                        </div>
                    </div>

                    <div class="business">
                        <div id="business_size_box" style="display: none;">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.business_size.label')}}</label>
                                <div class="col-lg-8 fv-row">
                                    <select class="form-select fsorm-select-transsparent" name="business_size" data-control="select2" data-hide-search="false" aria-label="{{ __ ('mobile.formPage.basicDetails.plan_type.placeHolder')}}" data-placeholder="{{ __ ('mobile.formPage.basicDetails.business_size.placeHolder')}}">
                                        <option value=""></option>
                                        @foreach($businessSizes as $id => $businessSize)
                                        <option value="{{$id}}" {{isset($plan) && $plan->business_size == $id ? 'selected' :''}}>{{$businessSize}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger errors" id="business_size_error"></span>
                                </div>
                            </div>
                        </div>

                        <div id="bdm_available_box" style="display: none;">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.bdm_available.label')}}</label>
                                <div class="col-lg-8 fv-row">
                                    <div class="row">
                                        <div class="col-2 text-right">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="1" name="bdm_available" id="bdm_available_yes" {{isset($plan) && $plan->bdm_available == 1 ? 'checked':''}} />
                                                <label class="form-check-label" for="bdm_available_yes">
                                                    {{ __ ('mobile.formPage.basicDetails.bdm_available.yes')}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-2 text-left">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="0" name="bdm_available" id="bdm_available_no" {{isset($plan) && $plan->bdm_available == 0 ? 'checked':''}} />
                                                <label class="form-check-label" for="bdm_available_no">
                                                    {{ __ ('mobile.formPage.basicDetails.bdm_available.no')}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="text-danger errors" id="bdm_available_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="bdm_contact_number_box" style="display: none;">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.bdm_contact_number.label')}}</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="bdm_contact_number" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.basicDetails.bdm_contact_number.placeHolder')}}" value="{{isset($plan)?$plan->bdm_contact_number:''}}" autocomplete="off" />
                                    <span class="text-danger errors" id="bdm_contact_number_error"></span>
                                </div>
                            </div>
                        </div>

                        <div id="bdm_details_box" style="display: none;">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.bdm_details.label')}}</label>
                                <div class="col-lg-8 fv-row">
                                    <textarea name="bdm_details" id="bdm_details" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.basicDetails.bdm_details.placeHolder')}}">{{isset($plan)?$plan->bdm_details:''}}</textarea>
                                    <span class="text-danger errors" id="bdm_details_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="personal">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.cost_type_id.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <select class="form-select fsorm-select-transsparent" name="cost_type_id" aria-label="{{ __ ('mobile.formPage.basicDetails.cost_type_id.placeHolder')}}" id="cost_type_id" data-control="select2" data-hide-search="true" data-placeholder="{{ __ ('mobile.formPage.basicDetails.cost_type_id.placeHolder')}}">
                                    <option value=""></option>
                                    @foreach($costTypes as $costType)
                                    <option value="{{$costType->id}}" {{isset($plan) && $plan->cost_type_id == $costType->id ? 'selected' :''}}>{{$costType->cost_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger errors" id="cost_type_id_error"></span>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.cost.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="cost" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.basicDetails.cost.placeHolder')}}" value="{{isset($plan)?$plan->cost:''}}" autocomplete="off" />
                                <span class="text-danger errors" id="cost_error"></span>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.plan_data.label')}}</label>
                            <div class="col-lg-3 fv-row">
                                <input type="text" name="plan_data" id="plan_data" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.basicDetails.plan_data.placeHolder')}}" value="{{isset($plan)?$plan->plan_data:''}}" autocomplete="off" />
                                <span class="text-danger errors" id="plan_data_error"></span>
                            </div>
                            <!-- New Field Unlimited 30-05-2022 -->
                            <div class="col-lg-3 fv-row mt-3">
                                <input type="checkbox" id="plan_data_1" class="form-check-input" placeholder="{{ __ ('mobile.formPage.basicDetails.plan_data.placeHolder')}}" @if(isset($plan) && $plan->plan_data == $dataPerMonth) checked @endif autocomplete="off" />
                                <span class="fw-bold ps-2 fs-6">Unlimited</span>
                                <span class="text-danger errors" id="plan_data_error"></span>
                            </div>
                            <!-- New Field Unlimited 30-05-2022 -->
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.plan_data_unit.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <select class="form-select fsorm-select-transsparent" name="plan_data_unit" id="plan_data_unit" data-control="select2" data-hide-search="false" aria-label="{{ __ ('mobile.formPage.basicDetails.plan_data_unit.placeHolder')}}" data-placeholder="{{ __ ('mobile.formPage.basicDetails.plan_data_unit.placeHolder')}}">
                                    <option value=""></option>
                                    @foreach($planDataUnits as $id => $name)
                                    <option value="{{$id}}" {{isset($plan) && $plan->plan_data_unit == $id ? 'selected' :''}}>{{$name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger errors" id="plan_data_unit_error"></span>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.network_host.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <select class="form-select fsorm-select-transsparent" name="host_type" data-control="select2" data-hide-search="false" aria-label="{{ __ ('mobile.formPage.basicDetails.network_host.placeHolder')}}" data-placeholder="{{ __ ('mobile.formPage.basicDetails.network_host.placeHolder')}}">
                                    <option value=""></option>
                                    @foreach($hostTypes as $id => $name)
                                    <option value="{{ $name['local_id']}}" {{isset($plan) && $plan->host_type == $name['local_id'] ? 'selected' :''}}>{{$name['name']}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger errors" id="host_type_error"></span>
                            </div>
                        </div>

                        <!-- 20-05-2022 -->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.network_host_information.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <textarea name="network_host_information" id="network_host_information" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.basicDetails.network_host_information.placeHolder')}}">{{isset($plan)?$plan->network_host_information:''}}</textarea>
                            <span class="text-danger errors" id="network_host_information_error"></span>
                            </div>
                        </div>
                        <!-- 20-05-2022 -->

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.network_type.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <select class="form-select fsorm-select-transsparent" name="network_type[]" aria-label="{{ __ ('mobile.formPage.basicDetails.network_type.placeHolder')}}" id="network_type" data-control="select2" data-hide-search="true" data-placeholder="{{ __ ('mobile.formPage.basicDetails.network_type.placeHolder')}}" multiple>
                                    <option value=""></option>
                                    @foreach($networkTypes as $id => $name)
                                    <option value="{{$id}}" {{isset($plan) && in_array($id,explode(',',$plan->network_type))  ? 'selected' :''}}>{{$name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger errors" id="network_type_error"></span>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.contract_id.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <select class="form-select fsorm-select-transsparent" name="contract_id" aria-label="{{ __ ('mobile.formPage.basicDetails.contract_id.placeHolder')}}" id="contract_id" data-control="select2" data-hide-search="false" data-placeholder="{{ __ ('mobile.formPage.basicDetails.contract_id.placeHolder')}}">
                                    <option value=""></option>
                                    @foreach($contracts as $contract)
                                    <option value="{{$contract->id}}" {{isset($plan) && $plan->contract_id == $contract->id ? 'selected' :''}}>{{$contract->contract_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger errors" id="contract_id_error"></span>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.sim_type.label')}}</label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid nbn_key">
                                <div class="d-flex align-items-center mt-3">
                                    <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                        <input class="form-check-input" name="sim_type" type="radio" value="1" {{isset($plan) && $plan->sim_type == 1 ? 'checked' :''}}>
                                        <span class="fw-bold ps-2 fs-6">{{ __ ('mobile.formPage.basicDetails.sim_type.esim')}}</span>
                                    </label>
                                    <label class="form-check form-check-inline form-check-solid is-valid">
                                        <input class="form-check-input" name="sim_type" type="radio" value="2" {{isset($plan) && $plan->sim_type == 2 ? 'checked' :''}}>
                                        <span class="fw-bold ps-2 fs-6">{{ __ ('mobile.formPage.basicDetails.sim_type.phy')}}</span>
                                    </label>
                                    <label class="form-check form-check-inline form-check-solid is-valid">
                                        <input class="form-check-input" name="sim_type" type="radio" value="3" {{isset($plan) && $plan->sim_type == 3 ? 'checked' :''}}>
                                        <span class="fw-bold ps-2 fs-6">{{ __ ('mobile.formPage.basicDetails.sim_type.both')}}</span>
                                    </label>
                                </div>
                                <span class="text-danger errors" id="billing_preference_error"></span>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.basicDetails.inclusion.label')}}</label>
                            <div class="col-lg-8 fv-row">
                                <textarea name="inclusion" id="inclusion" class="form-control form-control-lg form-control-solid ckeditor" placeholder="{{ __ ('mobile.formPage.basicDetails.inclusion.placeHolder')}}">{{isset($plan)?$plan->inclusion:''}}</textarea>
                                <span class="text-danger errors" id="inclusion_error"></span>
                            </div>
                        </div>



                    </div>
                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-primary submit_btn" id="plan_basic_details_form_submit_btn" data-form="plan_basic_details_form" data-title="Plan Details">{{ __ ('mobile.formPage.basicDetails.submitButton')}}</button>
                    <a href="{{url('/provider/plans/mobile/'.$providerId)}}" type="button" class="btn btn-light btn-active-light-primary me-2">{{ __ ('mobile.formPage.basicDetails.cancelButton')}}</a>
                </div>
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!--end::Card body-->
    @if(isset($plan))
    <!-- Begin Special offer ---->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#special_offer_section">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.specialOffer.sectionTitle')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--End::Card header-->
        <div id="special_offer_section" class="collapse show">
            <!--begin::Form-->
            <form id="plan_special_offer_form" class="form" >
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('mobile.formPage.specialOffer.status.label')}}</label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid nbn_key">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5 is-valid"> 
                                    <input class="form-check-input radio-w-h-18" name="special_offer_status" type="radio" value="1" {{ isset($plan) && $plan->special_offer_status == 1 ? 'checked' : ''}} /><span>{{ __ ('mobile.formPage.specialOffer.status.enableRadioLabel')}}</span>
                                </label>
                                    
                                <label class="form-check form-check-inline form-check-solid me-5 is-valid"> 
                                    <input class="form-check-input radio-w-h-18" name="special_offer_status" type="radio" value="0" {{ isset($plan) && $plan->special_offer_status == 0 ? 'checked' : ''}}/><span>{{ __ ('mobile.formPage.specialOffer.status.disableRadioLabel')}}</span>
                                </label>
                                    
                                
                                <span class="text-danger errors" id="special_offer_status_error"></span>
                            </div>
                        
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.specialOffer.specialOfferTitle.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="special_offer_title" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.specialOffer.specialOfferTitle.placeHolder')}}" value="{{ isset($plan) ? $plan->special_offer_title : ''}}"/>
                            <span class="text-danger errors" id="special_offer_title_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.specialOffer.specialOfferCost.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="special_offer_cost" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.specialOffer.specialOfferCost.placeHolder')}}" value="{{ isset($plan) ? $plan->special_offer_cost : ''}}" />
                            <span class="text-danger errors" id="special_offer_cost_error"></span>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('mobile.formPage.specialOffer.specialOfferDescription.label')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-8 fv-row">
                            <textarea type="text" id="special_offer_description" class="form-control form-control-lg form-control-solid ckeditor"
                                tabindex="8" placeholder="{{ __ ('mobile.formPage.specialOffer.specialOfferDescription.placeHolder')}}" rows="5"
                                name="special_offer_description">{{ isset($plan) ? $plan->special_offer_description : ''}}</textarea>
                                <span class="text-danger errors" id="special_offer_description_error"></span>
                        </div>
                        <!--end::Input-->
                    </div>

                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-primary submit_btn" id="plan_special_offer_form_submit_btn" data-form="plan_special_offer_form" data-title="Special Offers" >{{ __ ('mobile.formPage.specialOffer.submitButton')}}</button>
                    <a href="{{url('/provider/plans/mobile/'.$providerId)}}" class="btn btn-light btn-active-light-primary me-2">{{ __ ('mobile.formPage.specialOffer.cancelButton')}}</a>
                </div>

            </form>
            <!--end::Input group-->
        </div>
    </div>

    <!--- End Special offer --->
    @endif
</div>
<!--end::Content-->