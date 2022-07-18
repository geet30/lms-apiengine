<div class="d-flex flex-column gap-7 gap-lg-10">
    <form name="edit_plan_info" id="edit_plan_info" action="{{route('energyplans.update-rates')}}">
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
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.type') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <b>{{$editRate->type}}</b>

                </div>
            </div>
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
                            <input type="hidden" name="exit_fee" value="0">
                            <input class="form-check-input form-check-input radio-w-h-18

                            this" name="exit_fee_option" type="radio" value="0"@if($editRate['exit_fee_option'] == 0) checked @endif>
                            <span class="fw-bold ps-2 fs-6">
                                yes
                            </span>
                        </label>
                        <label class="form-check form-check-inline form-check-solid">
                            <input type="hidden" name="exit_fee_option" value="0">
                            <input class="form-check-input form-check-input radio-w-h-18

                            this" name="exit_fee_option" type="radio" value="1" @if($editRate['exit_fee_option'] == 1) checked @endif>
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
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.effective_form') }}</label>

                <div class="col-lg-8 fv-row field-holder">



                    <input type="date" class="form-control form-control-lg form-control-solid" value="{{Carbon::parse($editRate['effective_from'])->format('Y-m-d')}}"
                        placeholder="{{ __('plans/energyPlans.effective_form') }}" name="effective_from">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6 ">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.tariff_type_code') }}</label>

                <div class="col-lg-8 fv-row field-holder field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['tariff_type_code']}}"
                        placeholder="{{ __('plans/energyPlans.tariff_type_code') }}" name="tariff_type_code">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.tariff_type_title') }}</label>

                <div class="col-lg-8 fv-row field-holder ">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['tariff_type_title']}}"
                        placeholder="{{ __('plans/energyPlans.tariff_type_title') }}" name="tariff_type_title">
                        <span class="form_error_name form_error" style="color: red;"></span>

                </div>
            </div>
            @if (isset($timeOfUseArray) && in_array($editRate['type'], $timeOfUseArray))
                <!-- New field added only incase the rate type is TOU -->
                <div class="row mb-6 ">
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.time_of_use_type') }}</label>
                    <div class="col-lg-8 fv-row field-holder field-holder">
                        <div class="d-flex align-items-center mt-3">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input type="hidden" name="time_of_use_rate_type" value="1">
                                <input class="form-check-input form-check-input radio-w-h-18

                                this" name="time_of_use_rate_type" type="radio" value="0"@if($editRate['time_of_use_rate_type'] == 0) checked @endif>
                                <span class="fw-bold ps-2 fs-6">
                                    yes
                                </span>
                            </label>
                            <label class="form-check form-check-inline form-check-solid">
                                <input type="hidden" name="time_of_use_rate_type" value="2">
                                <input class="form-check-input form-check-input radio-w-h-18

                                this" name="time_of_use_rate_type" type="radio" value="1" @if($editRate['time_of_use_rate_type'] == 1) checked @endif>
                                <span class="fw-bold ps-2 fs-6">
                                    no
                                </span>
                            </label>

                        </div>
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </div>

                </div>
            @endif
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.tariff_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid"value="" name="tariff_desc">{{$editRate['tariff_desc']}}</textarea>
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
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.dual_fuel_discount_usage') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['dual_fuel_discount_usage']}}"
                        placeholder="{{ __('plans/energyPlans.dual_fuel_discount_usage') }}" name="dual_fuel_discount_usage">
                        <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.dual_fuel_discount_supply') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['dual_fuel_discount_supply']}}"
                        placeholder="{{ __('plans/energyPlans.dual_fuel_discount_supply') }}" name="dual_fuel_discount_supply">
                        <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.dual_fuel_discount_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid"value="" name="dual_fuel_discount_desc">{{$editRate['dual_fuel_discount_desc']}}</textarea>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.pay_day_discount_usage') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['pay_day_discount_usage']}}"
                    placeholder="{{ __('plans/energyPlans.pay_day_discount_usage') }}" name="pay_day_discount_usage">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.pay_day_discount_usage_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid"value="" name="pay_day_discount_usage_desc" id="pay_day_discount_usage_desc">{{$editRate['pay_day_discount_usage_desc']}}</textarea>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.pay_day_discount_supply') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['pay_day_discount_supply']}}"
                    placeholder="{{ __('plans/energyPlans.pay_day_discount_supply') }}" name="pay_day_discount_supply">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.pay_day_discount_supply_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid"value="" name="pay_day_discount_supply_desc" id ="pay_day_discount_supply_desc">{{$editRate['pay_day_discount_supply_desc']}} </textarea>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.guaranteed_discount_usage') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['gurrented_discount_usage']}}"
                    placeholder="{{ __('plans/energyPlans.guaranteed_discount_usage') }}" name="gurrented_discount_usage">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.guaranteed_discount_usage_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid"value="" id ="gurrented_discount_usage_desc" name="gurrented_discount_usage_desc">{{$editRate['gurrented_discount_usage_desc']}}</textarea>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.guaranteed_discount_supply') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['gurrented_discount_supply']}}"
                    placeholder="{{ __('plans/energyPlans.guaranteed_discount_supply') }}" name="gurrented_discount_supply" id="gurrented_discount_supply">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.guaranteed_discount_supply_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid"value="" name="gurrented_discount_supply_desc">{{$editRate['gurrented_discount_supply_desc']}}</textarea>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.direct_debit_discount_usage') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['direct_debit_discount_usage']}}"
                    placeholder="{{ __('plans/energyPlans.direct_debit_discount_usage') }}" name="direct_debit_discount_usage">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.direct_debit_discount_supply') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['direct_debit_discount_supply']}}"
                    placeholder="{{ __('plans/energyPlans.direct_debit_discount_supply') }}" name="direct_debit_discount_supply">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.direct_debit_discount_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid"value="" name="direct_debit_discount_desc">{{$editRate['direct_debit_discount_desc']}}</textarea>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.daily_supply_charges') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['daily_supply_charges']}}"
                    placeholder="{{ __('plans/energyPlans.daily_supply_charges') }}" name="daily_supply_charges">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.gst_rate') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['gst_rate']}}"
                    placeholder="Gst Rate" name="gst_rate">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.control_load_1_charges') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['control_load_1_daily_supply_charges']}}"
                    placeholder="{{ __('plans/energyPlans.control_load_1_charges') }}" name="control_load_1_daily_supply_charges">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.control_load_2_charges') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['control_load_2_daily_supply_charges']}}"
                    placeholder="{{ __('plans/energyPlans.control_load_2_charges') }}" name="control_load_2_daily_supply_charges">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.meter_type') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['meter_type']}}"
                    placeholder="{{ __('plans/energyPlans.meter_type') }}" name="meter_type">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.demand_usage_desc') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['demand_usage_desc']}}"
                    placeholder="{{ __('plans/energyPlans.demand_usage_desc') }}" name="demand_usage_desc">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.demand_supply_charges') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['demand_supply_charges_daily']}}"
                    placeholder="{{ __('plans/energyPlans.demand_supply_charges') }}" name="demand_supply_charges_daily">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.demand_usage_charges') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['demand_usage_charges']}}"
                    placeholder="{{ __('plans/energyPlans.demand_usage_charges') }}" name="demand_usage_charges">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.price_fact_sheet_bpid') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <textarea class="form-control form-control-lg form-control-solid"value="" name="price_fact_sheet">{{$editRate['price_fact_sheet']}}</textarea>
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.offer_id') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['offer_id']}}"
                    placeholder="{{ __('plans/energyPlans.offer_id') }}" name="offer_id">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label  Required  fw-bold fs-6">{{ __('plans/energyPlans.batch_id') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editRate['batch_id']}}"
                    placeholder="{{ __('plans/energyPlans.batch_id') }}" name="batch_id">
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <div class="row mb-0">

                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.demand_calculation') }}</label>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="form-check form-check-solid form-switch fv-row">
                        <input type="hidden" name="demand_usage_check" value="0">
                        <input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing" name="demand_usage_check" value="1" @if($editRate['demand_usage_check']) checked @endif>
                        <label class="form-check-label" for="allowmarketing"></label>
                    </div>
                </div>

            </div>
        </div>
        <input type="hidden" name="action_type" value="planinfo-rate-view">
        <input type="hidden" name="rate_id" value="{{$editRate['id']}}">
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/plan-rates/'.encryptGdprData($editRate['plan_id']))}}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>


            <button type="button" class="btn btn-primary submit_button" id="submit_rate_info">

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
