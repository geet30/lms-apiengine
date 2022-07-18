<!--begin::Main column-->
@php //dd($direct_debit_detail); @endphp
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="direct_debit_setting_form" class="direct_debit_setting_form" name="direct_debit_setting_form">
        @csrf
        <!--begin::General options-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body px-8">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-6 fw-bold fs-6">Do you want to enable direct debit/payment settings for this provider?</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-6 direct_debit_status">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <!-- <input type="hidden" name="direct_debit_status" value="1"> -->
                            <input class="form-check-input radio-w-h-18 direct_debit_status_input" name="direct_debit_status" type="radio" {{isset($direct_debit_detail["status"]) && $direct_debit_detail["status"] ? 'checked' : ''}} value="1" />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('Yes') }}
                            </span>
                        </label>
                        <!--end::Option-->

                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid">
                            <!-- <input type="hidden" name="direct_debit_status" value="0"> -->
                            <input class="form-check-input radio-w-h-18 direct_debit_status_input" name="direct_debit_status" type="radio" {{isset($direct_debit_detail["status"]) && $direct_debit_detail["status"] ? '' : 'checked'}} value="0" />
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
                @php
                        $check1 = '';
                        $check2 = '';
                        $payment_method_hidden = $card_info_content_hidden = $bank_info_content_hidden = '';$creditDebitStatus=$bankAccountStatus='';
                        if(isset($direct_debit_detail["status"])){
                            $payment_method_type=$direct_debit_detail["payment_method_type"];
                           // $options = explode(',',$direct_debit_detail["payment_method_type"]);
                            //foreach($options as $value){
                                if($payment_method_type == 1){
                                    $check1 = 'checked';
                                    $creditDebitStatus='d-block';
                                    $bankAccountStatus='d-none';
                                } else if($payment_method_type == 2){
                                    $check2 = 'checked';
                                    $creditDebitStatus='d-none';
                                    $bankAccountStatus='d-block';
                                }else if($payment_method_type== 3){
                                    $check1='checked';
                                    $check2='checked';
                                    $creditDebitStatus='d-block';
                                    $bankAccountStatus='d-block';
                                }
                           // }
                            //if($direct_debit_detail["status"] == 0)
                            //{
                                //$payment_method_hidden = 'payment_method_hidden';
                            //}
                            if(isset($direct_debit_detail["is_card_content"]) && $direct_debit_detail["is_card_content"] == 0)
                            {
                                $card_info_content_hidden = 'card_info_content_hidden';
                            }
                            if(isset($direct_debit_detail["is_bank_content"]) && $direct_debit_detail["is_bank_content"] == 0)
                            {
                                $bank_info_content_hidden = 'bank_info_content_hidden';
                            }
                        }
                    @endphp
                <div class="payment_method_hideable">
                    <div class="row mb-6  ">
                        <!--begin::Label-->
                        <label class="col-lg-6 required fw-bold fs-6">Select Payment Method</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 payment_method">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <!-- <input type="hidden" name="payment_method" value="yes"> -->
                                <input class="form-check-input radio-w-h-18 payCheckbox" name="payment_method[]" type="checkbox" {{$check1}} value="1" id="creditCardCheckbox"/>
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Credit/Debit Card') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <!-- <input type="hidden" name="payment_method" value="No"> -->
                                <input class="form-check-input radio-w-h-18 payCheckbox" name="payment_method[]" type="checkbox" {{$check2}} value="2" id="bankCheckBox"/>
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Bank Account') }}
                                </span>
                            </label>
                            <p><span class="error text-danger"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div id="creditDebitStatus">
                    <div class="row mb-5 {{$creditDebitStatus}}">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-6">Disclamer Status For Credit/Debit Card:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 card_info_status">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <!-- <input type="hidden" name="card_info_status" value="1"> -->
                                <input class="form-check-input radio-w-h-18 card_info_status_input" name="card_info_status" type="radio" {{isset($direct_debit_detail["is_card_content"]) && $direct_debit_detail["is_card_content"] ? 'checked' : ''}} value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Enable') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <!-- <input type="hidden" name="card_info_status" value="0"> -->
                                <input class="form-check-input radio-w-h-18 card_info_status_input" name="card_info_status" type="radio" {{isset($direct_debit_detail["is_card_content"]) && $direct_debit_detail["is_card_content"] ? '' : 'checked'}} value="0" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Disable') }}
                                </span>
                            </label>
                            <p><span class="error text-danger"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                <!--end::Input group-->
                  <!--begin::Input group-->
                    <div class="row mb-5 card_info_content_hideable {{$card_info_content_hidden}}">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label required fw-bold fs-6">Credit/Debit Card Information:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 card_info_content">
                            <textarea type="text" id="card_info_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="card_info_content">{{$direct_debit_detail["card_information"] ?? ''}}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div id="bankAccountStatus">
                    <div class="row mb-5 {{$bankAccountStatus}}" >
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-6">Disclamer Status For Bank Account:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 bank_info_status">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <!-- <input type="hidden" name="bank_info_status" value="1"> -->
                                <input class="form-check-input radio-w-h-18 bank_info_status_input" name="bank_info_status" type="radio" {{isset($direct_debit_detail["is_bank_content"]) && $direct_debit_detail["is_bank_content"] ? 'checked' : ''}} value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Enable') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <!-- <input type="hidden" name="bank_info_status" value="0"> -->
                                <input class="form-check-input radio-w-h-18 bank_info_status_input" name="bank_info_status" type="radio" {{isset($direct_debit_detail["is_bank_content"]) && $direct_debit_detail["is_bank_content"] ? '' : 'checked'}} value="0" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Disable') }}
                                </span>
                            </label>
                            <p><span class="error text-danger"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                    <div class="row mb-5 bank_info_content_hideable  {{$bank_info_content_hidden}}">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label required fw-bold fs-6">Bank Account Information</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 bank_info_content">
                            <textarea type="text" id="bank_info_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="bank_info_content">{{$direct_debit_detail["bank_information"] ?? ''}}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->
                </div>


            </div>
            <!--end::Card body-->
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">{{ __('Cancel') }}</a>
                    <button type="submit" id="direct_debit_setting_submit" class="btn btn-primary">
                        <span class="indicator-label">{{ __('Save Changes') }}</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->
    </form>
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-0 px-8">
            <div class="card-title">
                <h2>Checkbox Content for Direct Debit</h2>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <button type="button" id="direct_debit_checkbox_add" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#add_provider_direct_debit_checkbox">+Add Checkbox</button>
                </div>
            </div>
        </div>

        <div class="pt-0 table-responsive px-8">
            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="provider_debit_checkbox_table">
                <thead>
                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                        <th class="text-capitalize text-nowrap">Sr. No.</th>
                        <th class="text-capitalize text-nowrap">Required</th>
                        <th class="text-capitalize text-nowrap">Content</th>
                        <th class="text-left text-capitalize text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600" id="direct_debit_list">

                    @if(!empty($direct_debit_checkboxs) && count($direct_debit_checkboxs) > 0)
                        @foreach($direct_debit_checkboxs as $key => $value)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value["checkbox_required"] ? 'Yes' : 'No'}}</td>
                            <td title="{{ strip_tags($value['content']) }}">
                                <span class="ellipses_table"> {{ strip_tags($value['content'])}}</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon--></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a class="menu-link px-3 checkBoxEdit" id="direct_debit_checkbox_edit" data-bs-toggle="modal"
                                        data-bs-target="#add_provider_direct_debit_checkbox" data-id="{{$value["id"]}}" checkbox-value="{{$value["checkbox_required"]}}" data-required_checkbox="{{$value["checkbox_required"]}}"  
                                        data-order="{{$value['order']}}" data-validation_message="{{$value["validation_message"]}}" data-checkbox_content="{{$value["content"]}}" data-connection_type="{{$value['connection_type']}}">Edit</a>
                                        <a type="button" id="direct_debit_checkbox_delete" class="menu-link px-3" data-id="{{$value["id"]}}">Delete</a>
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
</div>
<!--end::Main column-->
    <!--begin::General options-->

    <!--end::Pricing-->

<!--begin::Modal - Adjust Balance-->
<div class="modal fade editorClass"  data-bs-backdrop="static" data-bs-keyboard="false"  id="add_provider_direct_debit_checkbox" tabindex="-1" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">Direct Debit Information Checkbox</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
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
                <form role="form" id="provider_debit_checkbox_form" class="provider_debit_checkbox_form" name="provider_debit_checkbox_form">
                    @csrf
                    <!--begin::Input group-->
                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="col-lg-4 required fw-bold fs-6 mb-5">Checkbox Required</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 debit_checkbox_required">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input id="debit_checkbox_required_yes" class="form-check-input radio-w-h-18 debit_checkbox_required" name="debit_checkbox_required" type="radio" value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <input id="debit_checkbox_required_no" class="form-check-input radio-w-h-18 debit_checkbox_required" name="debit_checkbox_required" type="radio" value="0" checked />
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
                    <div class="fv-row mb-5 field-holder debit_checkbox_validation_message">
                        <!--begin::Label-->
                        <label class="col-lg-12 required col-form-label fw-bold fs-6">Validation Message</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 debit_validation_msg">
                            <textarea type="text" id="debit_validation_msg" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="3" name="debit_validation_msg"></textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-3 col-form-label required fw-bold fs-6 mb-5">Select type </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 debit_info_type">
                            <select data-control="select2" class="form-select form-select-solid" name="debit_info_type" id="debit_info_type">
                                <option value="" class=""></option>
                                <option value="1"> Debit information </option>
                                <option value="2"> Bank information </option>
                            </select>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label required fs-5 fw-bold mb-1">Order </label>

                        <div class="col-lg-6 order">
                            <input type="number" class="form-control form-control-lg form-control-solid h-50px border" id="direct_debit_checkbox_order" placeholder="e.g. 5" name="order">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Checkbox Content Parameters</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                            <select data-control="select2" data-placeholder="" data-hide-search="true" name="direct_debit_select_checkbox" id="select_selectsplitter1"  class="form-select direct_debit_select_checkbox" data-id="direct_debit_select_checkbox" size="5">
                                <option value="@Affiliate-Name@" class="debit_checkbox_parameter">@Affiliate-Name@</option>
                                <option value="@Provider-Name@" class="debit_checkbox_parameter">@Provider-Name@</option>
                                <option value="@Provider-Phone-Number@" class="debit_checkbox_parameter">@Provider-Phone-Number@</option>
                                <option value="@Provider-Address@" class="debit_checkbox_parameter">@Provider-Address@</option>
                                <option value="@Provider-Email@" class="debit_checkbox_parameter">@Provider-Email@</option>
                                <option value="@Customer-Name@" class="debit_checkbox_parameter">@Customer-Name@</option>
                                <option value="@Customer-Email@" class="debit_checkbox_parameter">@Customer-Email@</option>
                                <option value="@Customer-Phone@" class="debit_checkbox_parameter">@Customer-Phone@</option>
                            </select>
                        <!--end::Input-->
                    </div>

                    <!--begin::Input group-->
                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1 required">Checkbox Content</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="debit_checkbox_content">
                            <textarea type="text" id="debit_checkbox_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="3" name="debit_checkbox_content"></textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="debit_checkbox_submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
                <!--end::Form-->

                </div>
            </div>
            <!--end::Modal body-->

        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
