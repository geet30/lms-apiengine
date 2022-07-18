<div class="d-flex flex-column gap-7 gap-lg-10">
    <form name="edit_lpg_plan_info" id="edit_lpg_plan_info" action="{{route('energyplans.lpg-update-rates')}}">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>{{ __('plans/energyPlans.plan_rate_info') }}</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
          
           
            <div class="row mb-6 field-holder">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.distributor_name') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <select name="distributor_id" aria-label="{{ __('Select a Distributor') }}" data-control="select2"
                        data-placeholder="{{ __('Select a Distributor..') }}"
                        class="form-select form-select-solid form-select-lg">
                        <option value="">Select a Distributor</option>
                        @foreach ($distributorList as $key=>$value)
                        @if($editRate->distributor_id == $key)
                            <option value="{{$key}}" selected>{{$value}}</option>
                        @else
                            <option value="{{$key}}">{{$value}}</option>
                        @endif


                        @endforeach


                    </select>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>

            </div>
            <div class="row mb-6 ">
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.exit_fee_option') }}</label>
                <div class="col-lg-8 fv-row field-holder field-holder">
                    <div class="d-flex align-items-center mt-3">
                       <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input form-check-input radio-w-h-18

                            this" name="exit_fee_option" type="radio" value="1"@if($editRate['exit_fee_option'] == 1) checked @endif>
                            <span class="fw-bold ps-2 fs-6">
                                yes
                            </span>
                        </label>
                        <label class="form-check form-check-inline form-check-solid">
                            <input class="form-check-input form-check-input radio-w-h-18

                            this" name="exit_fee_option" type="radio" value="0" @if($editRate['exit_fee_option'] == 0) checked @endif>
                            <span class="fw-bold ps-2 fs-6">
                                no
                            </span>
                        </label>

                    </div>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>

            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.exit_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['exit_fee']}}"
                        placeholder="{{ __('plans/energyPlans.exit_fee') }}" name="exit_fee">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
           
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.late_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['late_payment_fee']}}"
                        placeholder="{{ __('plans/energyPlans.late_fee') }}" name="late_payment_fee">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.connection_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['connection_fee']}}"
                        placeholder="{{ __('plans/energyPlans.connection_fee') }}" name="connection_fee">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.disconnection_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['disconnection_fee']}}"
                        placeholder="{{ __('plans/energyPlans.disconnection_fee') }}" name="disconnection_fee">
                        <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.annual_equipment_fees_rental_fees') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['annual_equipment_fees_rental_fees']}}"
                        placeholder="{{ __('plans/energyPlans.annual_equipment_fees_rental_fees') }}" name="annual_equipment_fees_rental_fees">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.annual_equipment_fees_rental_fees_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['annual_equipment_fees_rental_fees_desc']}}"
                        placeholder="{{ __('plans/energyPlans.annual_equipment_fees_rental_fees_desc') }}" name="annual_equipment_fees_rental_fees_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.delivery_charges') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['delivery_charges']}}"
                        placeholder="{{ __('plans/energyPlans.delivery_charges') }}" name="delivery_charges">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.delivery_charges_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['delivery_charges_desc']}}"
                        placeholder="{{ __('plans/energyPlans.delivery_charges_desc') }}" name="delivery_charges_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.account_establishment_fees') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['account_establishment_fees']}}"
                        placeholder="{{ __('plans/energyPlans.account_establishment_fees') }}" name="account_establishment_fees">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.account_establishment_fees_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['account_establishment_fees_desc']}}"
                        placeholder="{{ __('plans/energyPlans.account_establishment_fees_desc') }}" name="account_establishment_fees_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.urgent_delivery_fees') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['urgent_delivery_fees']}}"
                        placeholder="{{ __('plans/energyPlans.urgent_delivery_fees') }}" name="urgent_delivery_fees">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.urgent_delivery_fees_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['urgent_delivery_fees_desc']}}"
                        placeholder="{{ __('plans/energyPlans.urgent_delivery_fees_desc') }}" name="urgent_delivery_fees_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.service_and_installation_charges') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['service_and_installation_charges']}}"
                        placeholder="{{ __('plans/energyPlans.service_and_installation_charges') }}" name="service_and_installation_charges">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.service_and_installation_charges_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['service_and_installation_charges_desc']}}"
                        placeholder="{{ __('plans/energyPlans.service_and_installation_charges_desc') }}" name="service_and_installation_charges_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.green_LPG_fees') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['green_LPG_fees']}}"
                        placeholder="{{ __('plans/energyPlans.green_LPG_fees') }}" name="green_LPG_fees">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.min_quantity_with_discount') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['min_quantity_with_discount']}}"
                        placeholder="{{ __('plans/energyPlans.min_quantity_with_discount') }}" name="min_quantity_with_discount">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.max_quantity_with_discount') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['max_quantity_with_discount']}}"
                        placeholder="{{ __('plans/energyPlans.max_quantity_with_discount') }}" name="max_quantity_with_discount">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.cash_discount_per_bottle') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['cash_discount_per_bottle']}}"
                        placeholder="{{ __('plans/energyPlans.cash_discount_per_bottle') }}" name="cash_discount_per_bottle">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.cash_credits') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['cash_credits']}}"
                        placeholder="{{ __('plans/energyPlans.cash_credits') }}" name="cash_credits">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.discount_percent') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['discount_percent']}}"
                        placeholder="{{ __('plans/energyPlans.discount_percent') }}" name="discount_percent">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_1') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_1']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_1') }}" name="optional_fees_1">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_1_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_1_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_1_desc') }}" name="optional_fees_1_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_2') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_2']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_2') }}" name="optional_fees_2">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_2_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_2_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_2_desc') }}" name="optional_fees_2_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_3') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_3']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_3') }}" name="optional_fees_3">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_3_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_3_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_3_desc') }}" name="optional_fees_3_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_4') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_4']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_4') }}" name="optional_fees_4">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_4_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_4_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_4_desc') }}" name="optional_fees_4_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_5') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_5']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_5') }}" name="optional_fees_5">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_5_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_5_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_5_desc') }}" name="optional_fees_5_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_6') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_6']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_6') }}" name="optional_fees_6">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_6_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_6_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_6_desc') }}" name="optional_fees_6_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_7') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_7']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_7') }}" name="optional_fees_7">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_7_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_7_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_7_desc') }}" name="optional_fees_7_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_8') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_8']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_8') }}" name="optional_fees_8">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_8_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_8_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_8_desc') }}" name="optional_fees_8_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_9') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_9']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_9') }}" name="optional_fees_9">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_9_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_9_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_9_desc') }}" name="optional_fees_9_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_10') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_10']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_10') }}" name="optional_fees_10">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.optional_fees_10_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['optional_fees_10_desc']}}"
                        placeholder="{{ __('plans/energyPlans.optional_fees_10_desc') }}" name="optional_fees_10_desc">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.urgent_delivery_window') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['urgent_delivery_window']}}"
                        placeholder="{{ __('plans/energyPlans.urgent_delivery_window') }}" name="urgent_delivery_window">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.late_payment_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['late_payment_fee']}}"
                        placeholder="{{ __('plans/energyPlans.late_payment_fee') }}" name="late_payment_fee">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.connection_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['connection_fee']}}"
                        placeholder="{{ __('plans/energyPlans.connection_fee') }}" name="connection_fee">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.disconnection_fee') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['disconnection_fee']}}"
                        placeholder="{{ __('plans/energyPlans.disconnection_fee') }}" name="disconnection_fee">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div> 
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.price_fact_sheet') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['price_fact_sheet']}}"
                        placeholder="{{ __('plans/energyPlans.price_fact_sheet') }}" name="price_fact_sheet">
                        <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>    
              
            
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.offer_id') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['offer_ID']}}"
                    placeholder="{{ __('plans/energyPlans.offer_id') }}" name="offer_ID">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label Required fw-bold fs-6">{{ __('plans/energyPlans.batch_id') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['batch_ID']}}"
                    placeholder="{{ __('plans/energyPlans.batch_id') }}" name="batch_ID">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
        </div>
        <input type="hidden" name="action_type" value="planlpginfo-rate-view">
        <input type="hidden" name="rate_id" value="{{$editRate['id']}}">
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/plan-rates/'.encryptGdprData($editRate['plan_id']))}}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>


            <button type="button" class="btn btn-primary submit_button" id="submit_lpgrate_info">

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
    <!--end::Card header-->

</div>
