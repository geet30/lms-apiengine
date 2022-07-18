<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        {{-- <div class="card-header">
            <div class="card-title">
                <h2>Plan Information</h2>
            </div>
        </div> --}}
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
           
            <form class="" method="post" action='{{ route('energyplans.update') }}' id="plan_info_form">
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.name') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['name']}}"
                            placeholder="{{ __('plans/energyPlans.name_placeholder') }}" name="name">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.plan_desc') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="plan_desc" id="plan_desc"
                            class="form-control form-control-lg form-control-solid ckeditor"
                            >{{$editPlan['plan_desc']}}</textarea>
                            <span class="form_error" style="color: red;"></span>
                    </div>

                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.plan_type') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <select name="plan_type" aria-label="{{ __('Plan Type options') }}" data-control="select2"
                            data-placeholder="{{ __('Plan Type options') }}"
                            class="form-select form-select-solid form-select-lg" data-hide-search="true">
                            <option value="1" @if($editPlan['plan_type'] == 1)selected @endif>Residential</option>
                            <option value="2" @if($editPlan['plan_type'] == 2)selected @endif>Business</option>

                        </select>
                        <span class="form_error" style="color: red;"></span>
                    </div>

                </div>
               @if($editPlan['energy_type']!=3)
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.billing_preference') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="billing_preference" value="1"@if($editPlan['billing_preference'] == 1) checked @endif />
                            <span class="form-check-label text-gray-600">Post</span>

                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="billing_preference" value="2" @if($editPlan['billing_preference'] == 2)checked @endif/>
                            <span class="form-check-label text-gray-600">Email</span>
                        </label>
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="billing_preference" value="3" @if($editPlan['billing_preference'] == 3)checked @endif/>
                            <span class="form-check-label text-gray-600">Both</span>
                        </label>
                        <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
               
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.show_this_plan_on') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                            @php 
                                $check3 = '';
                                $check4 = '';
                                if(isset($editPlan["show_this_plan_on"])) 
                                    {
                                    $options1 = explode(',',$editPlan["show_this_plan_on"]);
                                    foreach($options1 as $value1){
                                            $intValue = (int) filter_var($value1, FILTER_SANITIZE_NUMBER_INT);                                        
                                            if($intValue == 1){
                                                $check3 = 'checked';
                                            } else if($intValue == 2){
                                                $check4 = 'checked';
                                            }
                                        }
                                    }
                                @endphp
                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="show_this_plan_on[]" type="hidden" value="" />
                                    <input class="form-check-input radio-w-h-18" name="show_this_plan_on[]" type="checkbox" {{$check3}} value="1" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Frontend') }}
                                    </span>
                                </label>
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="show_this_plan_on[]" type="checkbox" {{$check4}} value="2" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Agent Portal') }}
                                    </span>
                                </label>   
                                <p><span class="error text-danger"></span></p>    
                    </div>
                </div>
               
               
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.show_price_sheet') }}</label>

                    <div class="col-lg-8 fv-row field-checbox">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="show_price_fact" value="1" @if($editPlan['show_price_fact'] == 1)checked @endif/>
                            <span class="form-check-label text-gray-600">Yes</span>
                            <span class="form_error" style="color: red;"></span>
                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="show_price_fact" value="0" @if($editPlan['show_price_fact'] == 0)checked @endif />
                            <span class="form-check-label text-gray-600">No</span>
                        </label>
                        <span class="form_error" style="color: red;"></span>
                    </div>


                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.recurring_meter_charges') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['recurring_meter_charges'] }} "
                            placeholder="{{ __('plans/energyPlans.recurring_meter_charges') }}" name="recurring_meter_charges">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                @endif
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.generate_token') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="generate_token" value="1"@if($editPlan['generate_token'] == 1) checked @endif />
                            <span class="form-check-label text-gray-600">Yes</span>

                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="generate_token" value="0" @if($editPlan['generate_token'] == 0)checked @endif/>
                            <span class="form-check-label text-gray-600">No</span>
                        </label>
                        <span class="form_error" style="color: red;"></span>
                    </div>


                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.dual_plan') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="dual_only" value="1" @if($editPlan['dual_only'] == 1)checked @endif/>
                            <span class="form-check-label text-gray-600">Yes</span>
                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="dual_only" value="0" @if($editPlan['dual_only'] == 0)checked @endif/>
                            <span class="form-check-label text-gray-600">No</span>
                        </label>
                    </div>
                    <span class="form_error" style="color: red;"></span>


                </div>
                @if($editPlan['energy_type'] == '1' ||$editPlan['energy_type'] == '3')
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.green_option') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="green_options" value="1" @if($editPlan['green_options'] == 1) checked @endif />
                            <span class="form-check-label text-gray-600">Yes</span>
                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="green_options" value="0"@if($editPlan['green_options'] == 0)checked @endif />
                            <span class="form-check-label text-gray-600">No</span>
                        </label>
                    </div>
                    <span class="form_error" style="color: red;"></span>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.green_option_desc') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="green_options_desc" id="green_options_desc" class="form-control form-control-lg form-control-solid "
                            value="">{{$editPlan['green_options_desc']}}</textarea>
                        <span class="form_error" style="color: red;"></span>
                    </div>

                </div>
                @endif
                @if($editPlan['energy_type'] == '1')
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.solar_compatible') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="solar_compatible" value="1" @if($editPlan['solar_compatible'] == 1)checked @endif/>
                            <span class="form-check-label text-gray-600">Yes</span>
                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="solar_compatible" value="0" @if($editPlan['solar_compatible'] == 0)checked @endif/>
                            <span class="form-check-label text-gray-600">No</span>
                        </label>
                        <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.show_solar_plan') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="show_solar_plan" value="1" @if($editPlan['show_solar_plan'] == 1)checked @endif />
                            <span class="form-check-label text-gray-600">Yes</span>
                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="show_solar_plan" value="0" @if($editPlan['show_solar_plan'] == 0)checked @endif/>
                            <span class="form-check-label text-gray-600">No</span>
                        </label>
                        <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                @endif
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.bundle_dual_plan') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="is_bundle_dual_plan" value="1" @if($editPlan['is_bundle_dual_plan'] == 1)checked @endif/>
                            <span class="form-check-label text-gray-600">Yes</span>
                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="is_bundle_dual_plan" value="0" @if($editPlan['is_bundle_dual_plan'] == 0)checked @endif />
                            <span class="form-check-label text-gray-600">No</span>
                        </label>
                    </div>
                    <span class="form_error" style="color: red;"></span>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.offer_code') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['offer_code'] }}"
                            placeholder="{{ __('plans/energyPlans.offer_code') }}" name="offer_code">
                        <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.bundle_code') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['bundle_code'] }}"
                            placeholder="{{ __('plans/energyPlans.bundle_code') }}" name="bundle_code">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.credit_yearly') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['credit_bonus'] }}"
                            placeholder="{{ __('plans/energyPlans.credit') }}" name="credit_bonus"  >
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                {{-- lpg fileds --}}
                
               
           
                @if($editPlan['energy_type'] == 3)
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.enable_plan_offer') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="plan_offer_status" value="1" @if($editPlan['plan_offer_status'] == 1)checked @endif/>
                            <span class="form-check-label text-gray-600">Yes</span>
                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" type="radio" name="plan_offer_status" value="0" @if($editPlan['plan_offer_status'] == 0)checked @endif />
                            <span class="form-check-label text-gray-600">No</span>
                        </label>
                    </div>
                    <span class="form_error" style="color: red;"></span>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('plans/energyPlans.plan_offer') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['plan_offer'] }}"
                            placeholder="{{ __('plans/energyPlans.plan_offer') }}" name="plan_offer">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('plans/energyPlans.eligibiltiy') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['eligibility'] }}"
                            placeholder="{{ __('plans/energyPlans.eligibiltiy') }}" name="eligibility">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.offer_details') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['offer_details']}}"
                            placeholder="{{ __('plans/energyPlans.offer_details') }}" name="offer_details"  >
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                @endif
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.plan_compaign_code') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['plan_campaign_code'] }}"
                            placeholder="{{ __('plans/energyPlans.plan_compaign_code') }}" name="plan_campaign_code" >
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.offer_type') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['offer_type'] }}"
                            placeholder="{{ __('plans/energyPlans.offer_type') }}" name="offer_type">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    @if($editPlan['energy_type'] == '1' || $editPlan['energy_type'] ==3)
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.product_code_e') }}</label>
                    @else
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.product_code_g') }}</label>
                    @endif

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['product_code'] }}"
                            placeholder="{{ __('plans/energyPlans.product_code') }}" name="product_code">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->

                    @if($editPlan['energy_type'] == 1)
                        @if($editPlan['plan_type'] == 1)
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.compaign_code_elec') }}</label>
                        @else
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.compaign_code_res_elec') }}</label>
                        @endif
                    @elseif($editPlan['energy_type'] == 3)
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.compaign_code_res_elec') }}</label>
                    @else
                        @if($editPlan['plan_type'] == 1)
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.compaign_code_gas') }}</label>
                        @else
                        <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.compaign_code_res_gas') }}</label>
                        @endif
                    @endif


                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['campaign_code'] }}"
                            placeholder="{{ __('plans/energyPlans.compaign_code') }}" name="campaign_code">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{ __('plans/energyPlans.promotion_code') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['promotion_code'] }}"
                            placeholder="{{ __('plans/energyPlans.promotion_code') }}" name="promotion_code">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.contract_length') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <select name="contract_length" aria-label="{{ __('Select a Currency') }}" data-control="select2"
                            data-placeholder="{{ __('Select a currency..') }}"
                            class="form-select form-select-solid form-select-lg">
                            @foreach ($contractLength as $contract)
                            @if($contract == $editPlan['contract_length'])
                                <option value="{{$contract}}" selected>{{$contract}}</option>
                            @else
                                <option value="{{$contract}}" selected>{{$contract}}</option>
                            @endif
                            @endforeach
                        </select>
                        <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.benefit_terms') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <select name="benefit_term" aria-label="{{ __('Select a Currency') }}" data-control="select2"
                            data-placeholder="{{ __('Select a currency..') }}"
                            class="form-select form-select-solid form-select-lg">
                            @foreach ($benefitTerms as $benefit)
                            @if($contract == $editPlan['benefit_term'])
                                <option value="{{$benefit}}" selected>{{$benefit}}</option>
                            @else
                                <option value="{{$benefit}}" selected>{{$benefit}}</option>
                            @endif
                            @endforeach
                        </select>
                        <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.paper_bill_fee') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="paper_bill_fee" id="paper_bill_fee"
                            class="form-control form-control-lg form-control-solid ckeditor"
                            >{{$editPlan['paper_bill_fee'] }}</textarea>
                            <span class="form_error" style="color: red;"></span>

                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.counter_fee') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="counter_fee" id="counter_fee"
                            class="form-control form-control-lg form-control-solid ckeditor"
                           >{{$editPlan['counter_fee'] }}</textarea>
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                 <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  required fw-bold fs-6">{{ __('plans/energyPlans.credit_card_fee') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="credit_card_service_fee" id="credit_card_service_fee"
                            class="form-control form-control-lg form-control-solid ckeditor"
                           >{{$editPlan['credit_card_service_fee'] }}</textarea>
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                @if($editPlan['energy_type'] != 3)
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  required fw-bold fs-6">{{ __('plans/energyPlans.cooling_off') }}</label>

                        <div class="col-lg-8 fv-row field-holder">
                            <textarea name="cooling_off_period" id="cooling_off_period"
                                class="form-control form-control-lg form-control-solid ckeditor"
                                >{{$editPlan['cooling_off_period'] }}</textarea>
                                <span class="form_error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('plans/energyPlans.billing_options') }}</label>

                        <div class="col-lg-8 fv-row field-holder">
                            <select name="billing_options" aria-label="{{ __('Select a Currency') }}"
                                data-control="select2" data-placeholder="{{ __('..') }}"
                                class="form-select form-select-solid form-select-lg">
                                @foreach ($billingOption as $billing)
                                @if($billing == $editPlan['benefit_term'])
                                    <option value="{{$billing}}" selected>{{$billing}}</option>
                                @else
                                    <option value="{{$billing}}">{{$billing}}</option>
                                @endif
                                @endforeach
                            </select>
                            <span class="form_error" style="color: red;"></span>
                        </div>
                    </div>
                @endif
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  required fw-bold fs-6">{{ __('plans/energyPlans.other_fee') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="other_fee_section" id="other_fee_section"
                            class="form-control form-control-lg form-control-solid ckeditor"
                            value="">{{$editPlan['other_fee_section'] }}</textarea>
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('plans/energyPlans.plan_bonus') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{$editPlan['plan_bonus'] }}"
                            placeholder="{{$editPlan['plan_bonus'] }}" name="Plan_bonus">
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('plans/energyPlans.plan_bonus_desc') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="plan_bonus_desc" id="plan_bonus_desc"
                            class="form-control form-control-lg form-control-solid ckeditor"
                            value="">{{$editPlan['plan_bonus_desc'] }}</textarea>
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.payment_options') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="payment_options" id="payment_options"
                            class="form-control form-control-lg form-control-solid ckeditor"
                            value="">{{$editPlan['payment_options'] }}</textarea>
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.plan_features') }}</label>
                    <div class="col-lg-8 show_planfeatures_on">
                            <div class="d-flex align-items-center mt-3">
                            @php 
                                $check1 = '';
                                $check2 = '';
                                if(isset($editPlan["show_planfeatures_on"])) 
                                    {
                                    $options = explode(',',$editPlan["show_planfeatures_on"]);
                                    foreach($options as $value){
                                            $intValue = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);                                        
                                            if($intValue == 1){
                                                $check1 = 'checked';
                                            } else if($intValue == 2){
                                                $check2 = 'checked';
                                            }
                                        }
                                    }
                                @endphp
                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="show_planfeatures_on[]" type="hidden" value="" />
                                    <input class="form-check-input radio-w-h-18" name="show_planfeatures_on[]" type="checkbox" {{$check1}} value="1" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Online') }}
                                    </span>
                                </label>
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="show_planfeatures_on[]" type="checkbox" {{$check2}} value="2" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Telesales') }}
                                    </span>
                                </label>   
                                <p><span class="error text-danger"></span></p>                         
                            </div>
                        </div>
                    <div class="col-lg-4 fv-row field-holder"></div>
                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="plan_features" id="plan_features"
                            class="form-control form-control-lg form-control-solid ckeditor"
                            >{{$editPlan['plan_features'] }}</textarea>
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  required fw-bold fs-6 ">{{ __('plans/energyPlans.T&C') }}</label>

                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="terms_condition" id="terms_condition"
                            class="form-control form-control-lg form-control-solid ckeditor"
                           id ="testeditor">{{$editPlan['terms_condition'] }}</textarea>
                            <span class="form_error" style="color: red;"></span>
                    </div>
                </div>
                @if($editPlan['energy_type'] != '3')
                <div class="row mb-0">

                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('plans/energyPlans.demand_calculation') }}</label>
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch fv-row">
                            <input type="hidden" name="demand_usage_check" value="0">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="allowdemand"
                                name="demand_usage_check" @if($editPlan['demand_usage_check']==1) checked @endif value="1">
                            <label class="form-check-label" for="allowdemand"></label>
                        </div>
                    </div>

                </div>
                @endif
                @if($editPlan['energy_type'] == '1')
                    <input type="hidden" name="action_form" value="plan_info">
                @elseif($editPlan['energy_type'] == '3')
                    <input type="hidden" name="action_form" value="plan_info_lpg">
                @else
                    <input type="hidden" name="action_form" value="plan_info_gas">
                @endif
                <input type="hidden" name="plan_id" value="{{$editPlan['id']}}">

        </div>


        <!--end::Card header-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/'.$editPlan['energy_type'].'/list/'.encryptGdprData($editPlan['provider_id'])) }}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>

            <button type="button" class="btn btn-primary submit_button" id="submit_plan_info">

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
</div>
