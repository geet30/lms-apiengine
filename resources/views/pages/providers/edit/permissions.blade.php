
@php
//dd($provider_details[0]['user_id']);
//$key = array_search('1', array_column($plan_connection_types, 'local_id'));
//dd($plan_connection_types[$key]['name']);

 //dd($permission); 
@endphp
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="provider_permission_form" class="provider_permission_form" name="provider_permission_form">
        @csrf
        <!--begin::General options-->
        <div class="card card-flush py-4">
            <!--begin::Card body-->
            <div class="card-body px-8">
                @if($account_detail['service_id'] != 1 && $account_detail['service_id'] != 4)
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-bold fs-6">New Connection Allowed:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 connection_allow">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <!-- <input type="hidden" name="connection_allow" value="yes"> -->
                                <input id="connection_allow_yes" class="form-check-input radio-w-h-18 connectionClass" name="connection_allow" type="radio" {{isset($permission["is_new_connection"]) && $permission["is_new_connection"]  ? 'checked' : ''}} value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <!-- <input type="hidden" name="connection_allow" value="No"> -->
                                <input id="connection_allow_no" class="form-check-input radio-w-h-18 connectionClass" name="connection_allow" type="radio" {{isset($permission["is_new_connection"]) && $permission["is_new_connection"] ? '' : 'checked'}} value="0"  />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                            <p><span class="error text-danger"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="mb-5 plan_permsn_connectn_script_class ">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label fw-bold fs-6">New connection Content:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12 plan_permsn_connectn_script">
                            <textarea type="text" id="plan_permsn_connectn_script" class="form-control form-control-lg form-control-solid ckeditor"
                                tabindex="8" placeholder="" rows="5"
                                name="plan_permsn_connectn_script">{{ isset($permission["connection_script"])?$permission['connection_script']:''}}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                     <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-bold fs-6">Port In Allowed:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-8 port_allow">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <!-- <input type="hidden" name="port_allow" value="yes"> -->
                                <input id="port_allow_yes" class="form-check-input radio-w-h-18 port_allow_class" name="port_allow" type="radio" {{isset($permission["is_port"]) && $permission["is_port"]  ? 'checked' : ''}} value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <!-- <input type="hidden" name="port_allow" value="No"> -->
                                <input id="port_allow_no" class="form-check-input radio-w-h-18 port_allow_class" name="port_allow" type="radio" {{isset($permission["is_port"]) && $permission["is_port"] ? '' : 'checked'}} value="0"  />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                            <p><span class="error text-danger"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="mb-5 port_script_class">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label fw-bold fs-6">Port in Content:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12 plan_port_in_script">
                            <textarea type="text" id="plan_port_in_script" class="form-control form-control-lg form-control-solid ckeditor"
                                tabindex="8" placeholder="" rows="5"
                                name="plan_port_in_script">{{ isset($permission["port_script"])?$permission['port_script']:''}}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                     <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-bold fs-6">Recontract Allowed:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-8 retention_allow">
                            <label class="form-check form-check-inline form-check-solid me-5" data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="If retention is allowed, then listing will show the plans of user's current provider also. If retention is not allowed, then listing will not show plans of user's current provider.">
                                <input id="retention_allow_yes" class="form-check-input radio-w-h-18 recontract_allow_radio_class" name="retention_allow" type="radio" {{isset($permission["is_retention"]) && $permission["is_retention"]  ? 'checked' : ''}} value="1"/>
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid" data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="If retention is allowed, then listing will show the plans of user's current provider also. If retention is not allowed, then listing will not show plans of user's current provider.">
                                <input id="retention_allow_no" class="form-check-input radio-w-h-18 recontract_allow_radio_class" name="retention_allow" type="radio" {{isset($permission["is_retention"]) && $permission["is_retention"] ? '' : 'checked'}} value="0"  />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                            <p><span class="error text-danger"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="mb-5 recontract_script_class">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label fw-bold fs-6">Recontract Content:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12 plan_recontract_script">
                            <textarea type="text" id="plan_recontract_script" class="form-control form-control-lg form-control-solid ckeditor"
                                tabindex="8" placeholder="" rows="5"
                                name="plan_recontract_script">{{ isset($permission["recontract_script"])?$permission['recontract_script']:''}}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                     <!--end::Input group-->
                @endif
                @if($account_detail['service_id'] == 1 || $account_detail['service_id'] == 4)
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-6">Life Support Allowed? <a href="#"  data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="If life support content is allowed, only then this provider plans are listed. If life support is not allowed, then this provider's plans will not be listed."><i class="bi bi-info-circle"></i></a> </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-6 life_support_allow">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <!-- <input type="hidden" name="life_support_allow" value="yes"> -->
                                    <input id="life_support_allow_yes" class="form-check-input radio-w-h-18 is_life_support_allow" name="life_support_allow" type="radio" {{isset($permission["is_life_support"]) && $permission["is_life_support"]  ? 'checked' : ''}} value="1" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Yes') }}
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid">
                                    <!-- <input type="hidden" name="life_support_allow" value="No"> -->
                                    <input id="life_support_allow_no" class="form-check-input radio-w-h-18 is_life_support_allow" name="life_support_allow" type="radio" {{isset($permission["is_life_support"]) && $permission["is_life_support"] ? '' : 'checked'}} value="0"  />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('No') }}
                                    </span>
                                </label>
                                <p><span class="error text-danger"></span></p>
                                @php
                                    $display = 'display:none;';
                                    $elec_only = '';
                                    $gas_only = '';
                                    $both_only = '';

                                    if(isset($permission["life_support_energy_type"]) && $permission["life_support_energy_type"]){
                                        $display = 'display:block;';
                                    }
                                    if(isset($permission["life_support_energy_type"]) && $permission["life_support_energy_type"] == 1){
                                        $elec_only = 'checked';
                                    } elseif(isset($permission["life_support_energy_type"]) && $permission["life_support_energy_type"] == 2){
                                        $gas_only = 'checked';
                                    } elseif(isset($permission["life_support_energy_type"]) && $permission["life_support_energy_type"] == 3){
                                        $both_only = 'checked';
                                    }
                                @endphp

                                <!--begin::Input group-->
                                <div class="life_support_type life_support_type_div life_support_energy_type" style="{{$display}}">
                                    <label class="form-check form-check-inline form-check-solid me-5">
                                        <input id="life_support_elec" class="form-check-input radio-w-h-18 life_support_energy_type" name="life_support_energy_type" type="radio" value="1" {{$elec_only}} />
                                        <span class="fw-bold ps-2 fs-6">
                                            {{ __('Electricity') }}
                                        </span>
                                    </label>
                                    <!--end::Option-->

                                    <!--begin::Option-->
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input id="life_support_gas" class="form-check-input radio-w-h-18 life_support_energy_type" name="life_support_energy_type" type="radio"  value="2"  {{$gas_only}} />
                                        <span class="fw-bold ps-2 fs-6">
                                            {{ __('Gas') }}
                                        </span>
                                    </label>
                                    <!--begin::Option-->
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input id="life_support_both" class="form-check-input radio-w-h-18 life_support_energy_type" name="life_support_energy_type" type="radio" value="3" {{$both_only}} />
                                        <span class="fw-bold ps-2 fs-6">
                                            {{ __('Both') }}
                                        </span>
                                    </label>
                                    <p><span class="error text-danger"></span></p>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-6">Retention Allowed? <a href="#"  data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="If retention is allowed, then listing will show the plans of user's current provider also. If retention is not allowed, then listing will not show plans of user's current provider"><i class="bi bi-info-circle"></i></a></label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 e_retention_allow">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input id="m_retention_allow_yes" class="form-check-input radio-w-h-18" name="e_retention_allow" type="radio" {{isset($permission["is_retention"]) && $permission["is_retention"]  ? 'checked' : ''}} value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <input id="m_retention_allow_no" class="form-check-input radio-w-h-18" name="e_retention_allow" type="radio" {{isset($permission["is_retention"]) && $permission["is_retention"] ? '' : 'checked'}} value="0"  />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                            <p><span class="error text-danger"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="row mb-3">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-6">Gas only sale allow? <a href="#"  data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="If gas only sale is allowed, then listing will show gas plans individually also. If gas only sale is not allowed then listing will show gas plans only with same provider's electricity plans."><i class="bi bi-info-circle"></i></a></label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-6 gas_sale_allow">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <!-- <input type="hidden" name="gas_sale_allow" value="yes"> -->
                                    <input id="gas_sale_allow_yes" class="form-check-input radio-w-h-18" name="gas_sale_allow" type="radio" {{isset($permission["is_gas_only"]) && $permission["is_gas_only"]  ? 'checked' : ''}} value="1" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Yes') }}
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid">
                                    <!-- <input type="hidden" name="gas_sale_allow" value="No"> -->
                                    <input id="gas_sale_allow_no" class="form-check-input radio-w-h-18" name="gas_sale_allow" type="radio" {{isset($permission["is_gas_only"]) && $permission["is_gas_only"] ? '' : 'checked'}} value="0"  />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('No') }}
                                    </span>
                                </label>
                                <p><span class="error text-danger"></span></p>
                            </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-6">Do you want to enable demand calculation? <a href="#"  data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="If demand calculation is allowed, plan details will show demand rates. If demand calculation is not allowed, then plan details will not show demand calculation."><i class="bi bi-info-circle"></i></a></label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-6">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <!-- <input type="hidden" name="manage_demand_status" value="1"> -->
                                    <input class="form-check-input radio-w-h-18" name="manage_demand_status" type="radio" {{isset($permission["is_demand_usage"]) && $permission["is_demand_usage"]  ? 'checked' : ''}} value="1"/>
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Yes') }}
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid">
                                    <!-- <input type="hidden" name="manage_demand_status" value="0"> -->
                                    <input class="form-check-input radio-w-h-18" name="manage_demand_status" type="radio" {{isset($permission["is_demand_usage"]) && $permission["is_demand_usage"] ? '' : 'checked'}} value="0"  />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('No') }}
                                    </span>
                                </label>
                                <p><span class="error text-danger"></span></p>
                            </div>
                            <!--end::Input-->
                    </div>
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-6">Allow credit score check for EnergyAustralia: <a href="#" data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="If credit score check is allowed, then system will check user's credit score and listing will consider only those provider's who accepts that credit score."><i class="bi bi-info-circle"></i></a></label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-6 ea_credit_score_check_allow">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <!-- <input type="hidden" name="ea_credit_score_check_allow" value="yes"> -->
                                    <input id="ea_credit_score_check_allow_yes" class="form-check-input radio-w-h-18 is_credit_allow" name="ea_credit_score_check_allow" type="radio" {{isset($permission["ea_credit_score_allow"]) && $permission["ea_credit_score_allow"]  ? 'checked' : ''}} value="1" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Yes') }}
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid">
                                    <!-- <input type="hidden" name="ea_credit_score_check_allow" value="No"> -->
                                    <input id="ea_credit_score_check_allow_no" class="form-check-input radio-w-h-18 is_credit_allow" name="ea_credit_score_check_allow" type="radio" {{isset($permission["ea_credit_score_allow"]) && $permission["ea_credit_score_allow"] ? '' : 'checked'}} value="0"  />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('No') }}
                                    </span>
                                </label>
                                <p><span class="error text-danger"></span></p>
                            </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    @php
                        $dispplay_cs = 'display:none;';
                        if(isset($permission["ea_credit_score_allow"]) && $permission["ea_credit_score_allow"]){
                            $dispplay_cs = 'display:block;';
                        }
                    @endphp
                    <!--begin::Input group-->
                    <div class="row mb-3 credit_score_div" style="{{$dispplay_cs}}">
                        <!--begin::Label-->
                        <label class="col-lg-6 required fw-bold fs-6">Credit score value:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 credit_score">
                            <input type="text" class="form-control form-control-solid credit_score_input" placeholder="e.g. 786" name="credit_score" tabindex="3" value="{{$permission["credit_score"]??''}}">
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                @endif
            </div>
            <!--begin::Actions-->
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <!--begin::Button-->
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">{{ __('Cancel') }}</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="provider_permission_submit" class="btn btn-primary">
                        <span class="indicator-label">{{ __('Save Changes') }}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <!--end::Actions-->
        </div>
    </form>
    <!--begin::General options-->
<div class="card card-flush py-0 px-0">
    <div class="card-header border-0 pt-0 px-8">
        <div class="card-title">
            <h2>Plan/Permission Checkboxes</h2>
        </div>
        <div class="pull-right card-toolbar">
            <button type="button" data-user-id="{{isset($provider_details) && $provider_details[0]['user_id']!='' ?$provider_details[0]['user_id']:''}}"class="btn btn-light-primary me-3" id="add_plan_permission_checkbox_button">+Add
                Checkbox</button>
        </div>
    </div>
    <div class="card-body  pt-0 table-responsive">
        <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class"
            id="provider_plan_permission_checkbox_table">
            <thead>
                <tr class="fw-bolder fs-6 text-gray-600 px-7">
                    <th class="text-capitalize text-nowrap">Sr. No.</th>
                    <th class="text-capitalize text-nowrap">Required</th>
                    <th class="text-capitalize text-nowrap">Connection Type</th>
                    <th class="text-capitalize text-nowrap">Content</th>
                    <!-- <th>Status</th> -->
                    <th class="text-left text-capitalize text-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600" id="provider_plan_checkbox_list">
              
                    @if(!empty($permission['get_permission_checkbox']) && count($permission['get_permission_checkbox'])>0)
                        @foreach($permission['get_permission_checkbox'] as $key => $value)
               
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$value["checkbox_required"] ? 'Yes' : 'No'}}</td>
                                    @php
                                        $conn_name='';
                                        if(!empty($plan_connection_types)){
                                        $key = array_search($value['connection_type'], array_column($plan_connection_types, 'local_id'));
                                        $conn_name=$plan_connection_types[$key]['name'];
                                        }
                                    @endphp
                                <td>{{$conn_name}}</td>
                                    
                                <td title="{!! strip_tags($value['content']) !!}">
                                    <span class="ellipses_table"> {!! strip_tags($value['content']) !!}</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3" id="plan_permission_checkbox_edit" data-bs-toggle="modal"
                                                data-bs-target="#add_provider_plan_permission_checkbox"
                                                data-id="{{$value["id"]}}" data-connection-type="{{$value["connection_type"]}}" 
                                                data-order="{{$value['order']}}" data-required_checkbox="{{$value["checkbox_required"]}}" data-save_checkbox="{{$value["status"]}}" data-validation_message="{{$value["validation_message"]}}" data-checkbox_content="{{$value["content"]}}" >Edit</a>
                                            <a type="button" id="plan_permission_checkbox_delete" data-id="{{$value["id"]}}" 
                                                class="menu-link px-3">Delete</a>
                                        </div>
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                       </tr>
                    @endif
              
            </tbody>
        </table>
    </div>
</div>
<!--end::Pricing-->
</div>

<!--begin::Modal - Adjust Balance-->
<div class="modal fade editorClass" data-bs-backdrop="static" data-bs-keyboard="false"  id="add_provider_plan_permission_checkbox" tabindex="-1" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">Plan/Permission Checkbox</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_provider_close"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill"
                    data-bs-dismiss="modal">
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
            <div class="modal-body scroll-y">
                <!--begin::Form-->
                <form id="provider_plan_permission_checkbox_form" name="provider_plan_permission_checkbox_form" class="form">
                    @csrf
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-6 required fw-bold fs-6 mb-5">Checkbox required? </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 _checkbox_required">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input permsn_checkbox_class" name="plan_permission_checkbox_required"
                                    id="plan_permission_checkbox_required_yes" type="radio" value="1"  />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <input class="form-check-input permsn_checkbox_class" id="plan_permission_checkbox_required_no"
                                    name="plan_permission_checkbox_required" type="radio" value="0" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                            <p><span class="error"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-8 plan_permission_checkbox_validation_message">
                        <!--begin::Label-->
                        <label class="col-lg-12 required col-form-label fw-bold fs-6">Validation Message</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 provider_permission_validation_msg">
                            <textarea type="text" id="provider_permission_validation_msg"
                                class="form-control form-control-lg form-control-solid ckeditor" tabindex="8"
                                placeholder="" rows="3" name="provider_permission_validation_msg"></textarea>
                            <span class="error"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-5 col-form-label required fs-5 fw-bold mb-1">Select Connection Type</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-7 plan_select_connection_type">
                            <select  class="form-select form-select-solid"
                                name="plan_select_connection_type" id="plan_select_connection_type">
                                <option value="" class="">Select Type</option>
                                @if(!empty($plan_connection_types))
                                    @foreach($plan_connection_types as $key=>$value)
                                        <option value="{{ $value['local_id']}}" {{ isset($value['connection_type']) && $value['local_id'] == $value['connection_type'] ? 'selected' : ''}}>{{ $value['name']}}</option>
                                    @endforeach
                                @endif
                              
                            </select>
                            <span class="error"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-6 col-form-label required fs-5 fw-bold mb-1">Order </label>

                        <div class="col-lg-6 order">
                            <input type="number" class="form-control form-control-lg form-control-solid h-50px border" id="plan_permission_checkbox_order" placeholder="e.g. 5" name="order">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label required fs-5 fw-bold mb-1">Checkbox Content</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 plan_permission_checkbox_content">
                            <textarea type="text" id="plan_permission_checkbox_content"
                                class="form-control form-control-lg form-control-solid ckeditor" tabindex="8"
                                placeholder="" rows="3" name="plan_permission_checkbox_content"></textarea>
                            <span class="error"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="plan_permission_checkbox_submit" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->

        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>