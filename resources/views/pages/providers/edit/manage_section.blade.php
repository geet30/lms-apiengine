@php
//dd($selected_service);
$hideSecOption = $hideOption = '';
if(isset($identification_details_section["get_section_option"][0]['section_option_status']) && $identification_details_section["get_section_option"][0]['section_option_status'] == 1)
{
if(isset($identification_details_section["get_section_option"][0]['section_option_status']) && $identification_details_section["get_section_option"][0]['section_option_status'] == 1)
{}
else
{
$hideSecOption = 'hideSecOption';
}
}
else
{
$hideOption = 'hideOption';
if(isset($identification_details_section["get_section_option"][0]['section_option_status']) && $identification_details_section["get_section_option"][0]['section_option_status'] == 1)
{}
else
{
$hideSecOption = 'hideSecOption';
}
}
$billing_address_hidden = $delivery_address_hidden = '';
if(isset($billing_and_delivery_address_section["get_section_option"][0]['is_required']) && $billing_and_delivery_address_section["get_section_option"][0]['is_required'] == 0)
{
$billing_address_hidden = 'billing_address_hidden';
}
if(isset($billing_and_delivery_address_section["get_section_option"][1]['is_required']) && $billing_and_delivery_address_section["get_section_option"][1]['is_required'] == 0)
{
$delivery_address_hidden = 'delivery_address_hidden';
}

$connection_details_hidden = $identification_details_hidden = $employment_details_hidden = $connection_address_hidden = $billing_delivery_details_hidden = 'hiddenSection';
if(isset($connection_details_section["section_status"]) && $connection_details_section["section_status"] == 1)
{
$connection_details_hidden = '';
}
if(isset($identification_details_section["section_status"]) && $identification_details_section["section_status"] == 1)
{
$identification_details_hidden = '';
}
if(isset($employment_details_section["section_status"]) && $employment_details_section["section_status"] == 1)
{
$employment_details_hidden = '';
}
if(isset($connection_address_section["section_status"]) && $connection_address_section["section_status"] == 1)
{
$connection_address_hidden = '';
}
if(isset($billing_and_delivery_address_section["section_status"]) && $billing_and_delivery_address_section["section_status"] == 1)
{
$billing_delivery_details_hidden = '';
}
@endphp

<!--begin::Main column-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-0">
        <div class="card-body px-0 pt-0">
            <div class="mb-5 detail_options">
                <ul class="flex-nowrap nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fw-bold mb-n2">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="ms-md-4 nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#personal_details">Personal Details</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    @if(isset($selected_service) && $selected_service['service_id']==3)
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 fs-7 text-center" data-bs-toggle="tab" href="#connection_details">Connection Details</a>
                    </li>
                    @endif
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 fs-7 text-center" data-bs-toggle="tab" href="#identification_details">Identification Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 fs-7 text-center" data-bs-toggle="tab" href="#employment_details">Employment Details</a>
                    </li>
                    @if(isset($selected_service) && $selected_service['service_id']!=1)
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 fs-7 text-center" data-bs-toggle="tab" href="#connection_address">Connection Address</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 fs-7 text-center" data-bs-toggle="tab" href="#billing_and_delivery_address">Billing and Delivery Address</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 fs-7 text-center" data-bs-toggle="tab" href="#life_support_equipments">Life Support Equipment</a>
                    </li> -->
                    @if(isset($selected_service) && $selected_service['service_id']==1)
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 fs-7 text-center" data-bs-toggle="tab" href="#other_settings">Other Settings</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="mb-5">
                <div class="tab-content my-6">
                    <input type="hidden" name="form_type" value="provider_manage_section_form">
                    <!--begin::Tab pane-->
                    <div class="tab-pane fade show active" id="personal_details" role="tab-panel">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <form role="form" id="personal_details_form" class="personal_details_form" name="personal_details_form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="section_type_id" value="1">
                                    <!--end::Input group-->
                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 fw-bold fs-6">Which personal details are to be collected from the customer?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6 personal_details">
                                            <select data-control="select2" class="form-select form-select-solid select_options" name="personal_details[]" id="personal_details" data-placeholder="Select options" multiple>
                                                @foreach($master_personal_details as $key=>$val)
                                                <option value="{{$key}}" @php if(!empty($personal_details_section['get_section_option'])){ $found=array_search($key, array_column($personal_details_section['get_section_option'], 'section_option_id' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Input group-->
                                    <div class="row">
                                        <!--begin::Label-->
                                        <label class="col-lg-12 col-form-label fw-bold fs-6">Tele-Sales Script</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-12">
                                            <textarea type="text" id="personal_detail_script" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="personal_detail_script">{{$personal_details_section['section_script'] ?? ''}}</textarea>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card body-->
                                <div class="card-footer border-0">
                                    <div class="pull-right">
                                        <!--begin::Button-->
                                        <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="personal_detail_submit" class="btn btn-primary">
                                            <span class="indicator-label">Save Changes</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                                <!--end::Card body-->
                            </form>
                            <!--begin::Main column-->
                            <div class="card card-flush">
                                <div class="card-header">
                                    <h2></h2>
                                    <div class="pull-right card-toolbar">
                                        <button type="button" class="btn btn-light-primary me-3 add_edit_custom_field" data-bs-toggle="modal" data-bs-target="#add_provider_custom_field" data-action="add">+Add</button>
                                    </div>
                                </div>
                                <div class="card-body px-8 pt-0 table-responsive">
                                    <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="custom_field_head">
                                        <thead>
                                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                                <th class="text-capitalize text-nowrap">Sr. No.</th>
                                                <th class="text-capitalize text-nowrap">Label</th>
                                                <th class="text-capitalize text-nowrap">Placeholder</th>
                                                <th class="text-capitalize text-nowrap">Mandatory</th>
                                                <th class="text-capitalize text-nowrap">Plans</th>
                                                <th class="text-center text-capitalize text-nowrap">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600" id="custom_field_body">
                                            @if (!empty($custom_details) && count($custom_details) > 0)
                                            @foreach ($custom_details as $key => $value)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$value['label']}}</td>
                                                <td>{{$value['placeholder']}}</td>
                                                <td>{{$value['mandatory'] == 1 ? "Yes" : "No"}}</td>
                                                @php
                                                $plan = array_column($value['custom_plan_section'],'plan_id');
                                                $plan = implode(",",$plan);
                                                @endphp
                                                <td> <button type="button" class="btn btn-light-primary me-3 custom_field_assign_plan" data-id='{{$value["id"]}}' data-plans="{{$plan}}">+Assign</button></td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                        <span class="svg-icon svg-icon-5 m-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a type="button" class="menu-link px-3 edit_custom_fields" data-placeholder='{{$value["placeholder"]}}' data-label='{{$value["label"]}}' data-id='{{$value["id"]}}' data-mandatory='{{$value["mandatory"]}}' data-message='{{$value["message"]}}'>Edit</a>
                                                            <a type="button" class="menu-link delete_custom_fields" data-id='{{$value["id"]}}'>Delete</a>
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

                        <!--begin::Modal - addedit column-->
                        <div class="modal fade" id="add_provider_custom_field" tabindex="-1" role="dialog">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-500px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <form role="form" id="custom_field_form" name="custom_field_form" method="post">
                                        @csrf
                                        <input type="hidden" id="custom_action_type" name="custom_action_type" value="">
                                        <!--begin::Modal header-->
                                        <div class="modal-header bg-primary px-5 py-4">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bolder fs-12 text-white">Custom sections</h2>
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
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-5">
                                                <!--begin::Label-->
                                                <label class="fs-5 fw-bold required form-label mb-1">Label</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="fv-row link_title">
                                                    <input type="text" class="form-control form-control-lg form-control-solid h-50px border" name="custom_field_label" id="custom_field_label" placeholder="e.g. Middle Name">
                                                    <span class="error text-danger"></span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-5">
                                                <!--begin::Label-->
                                                <label class="fs-5 fw-bold required form-label mb-1">Placeholder</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="fv-row link_url">
                                                    <input type="text" class="form-control form-control-lg form-control-solid h-50px border" name="custom_field_placeholder" id="custom_field_placeholder" placeholder="e.g. Middle Name*">
                                                    <span class="error text-danger"></span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label  fw-bold fs-6">Mandatory</label>

                                                <div class="col-lg-8 fv-row field-holder">
                                                    <label class="form-check form-check-inline form-check-solid me-5">
                                                        <input class="form-check-input" type="radio" name="custom_field_mandatory" class="custom_field_mandatory" value="1" checked="true">
                                                        <span class="form-check-label text-gray-600">Yes</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-inline form-check-solid me-5">
                                                        <input class="form-check-input" type="radio" name="custom_field_mandatory" class="custom_field_mandatory" value="0" />
                                                        <span class="form-check-label text-gray-600">No</span>
                                                    </label>
                                                    <span class="error text-danger"></span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="fs-5 fw-bold required form-label mb-1">Validation Message</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="fv-row order">
                                                    <input type="text" class="form-control form-control-lg form-control-solid h-50px border" name="custom_field_message" id="custom_field_message" placeholder="e.g. Middle Name is required">
                                                    <span class="error text-danger"></span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <div class="text-end">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <!--begin::Button-->
                                                <button type="submit" id="custom_field_submit" class="btn btn-primary">
                                                    <span class="indicator-label">Save Changes</span>
                                                    <span class="indicator-progress">Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                                <!--end::Button-->
                                            </div>
                                        </div>
                                        <!--end::Modal body-->

                                    </form>
                                </div>
                                <!--end::Modal content-->
                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!-- End::Modal - addedit column-->

                        <!--begin::Modal Add plan -->
                        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="add_custom_fields_plans" tabindex="-1" role="dialog">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-500px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header bg-primary px-5 py-4">
                                        <h2 class="fw-bolder fs-12 text-white">Assign Plans</h2>
                                    </div>
                                    <!--begin::Modal body-->
                                    <div class="modal-body scroll-y">
                                        <div class="fv-row mb-10">
                                            <form role="form" id="custom_field_plan_form" name="custom_field_plan_form" method="post">
                                                @csrf
                                                <!--begin::Label-->
                                                <label class="fs-5 fw-bold form-label mb-1">Selected Plans</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="fv-row order">
                                                    <select id="connection_custom_field_plan" class="form-control form-control-solid form-select connection_custom_field_plans" name="connection_custom_field_plans" data-placeholder="Select Plans" data-control="select2" multiple>
                                                    </select>
                                                    <span class="error text-danger"></span>
                                                </div>
                                                <!--end::Input-->
                                                <div class="text-end mt-5">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <!--begin::Button-->
                                                    <button type="button" id="custom_field_plan_submit" class="btn btn-primary">
                                                        <span class="indicator-label">Save Changes</span>
                                                        <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                    <!--end::Button-->
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal content-->
                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--End::Modal Add plan -->



                    </div>
                    @if(isset($selected_service) && $selected_service['service_id']!=2)
                        <div class="tab-pane fade show " id="connection_details" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <form role="form" id="connection_details_form" class="connection_details_form" name="connection_details_form">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="section_type_id" value="2">
                                        <!--begin::Input group-->
                                        <div class="row mb-5 py-1">
                                            <!--begin::Label-->
                                            <label class="col-lg-6  fw-bold fs-6">Do you want to enable this section for this provider?</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-lg-6 fv-row">
                                                <label class="form-check form-check-inline form-check-solid me-5">@php //dd($master_connection_details,$connection_details_section); @endphp
                                                    <input class="form-check-input" class="conn_detail_status" name="conn_detail_status" type="radio" value="1" {{isset($connection_details_section["section_status"]) && $connection_details_section["section_status"] ? 'checked' : ''}} />
                                                    <span class="fw-bold fs-6">
                                                        {{ __('Yes') }}
                                                    </span>
                                                </label>
                                                <!--end::Option-->

                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid">
                                                    <input class="form-check-input" class="conn_detail_status" name="conn_detail_status" type="radio" value="0" {{isset($connection_details_section["section_status"]) && $connection_details_section["section_status"] ? '' : 'checked'}} />
                                                    <span class="fw-bold fs-6">
                                                        {{ __(('No')) }}
                                                    </span>
                                                </label>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-8 connection_details_hideable {{$connection_details_hidden}}">
                                            <div class="row mb-8">
                                                <!--begin::Label-->
                                                <label class="col-lg-6 required fw-bold fs-6">Which connection details will be collected from the customer?</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="col-lg-6 connection_detail">
                                                    <select data-control="select2" class="form-select form-select-solid select_options" name="connection_detail[]" id="connection_detail" data-placeholder="Select options" multiple>
                                                        @foreach($master_connection_details as $key=>$val)
                                                        <option value="{{$key}}" @php if(!empty($connection_details_section['get_section_option'])){ $found=array_search($key, array_column($connection_details_section['get_section_option'], 'section_option_id' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$val}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error text-danger"></span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <!--begin::Label-->
                                            <label class="col-lg-12 col-form-label fw-bold fs-6">Tele-Sales Script</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-lg-12 col-xxl-12">
                                                <textarea type="text" id="connection_detail_script" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="connection_detail_script">{{ $connection_details_section["section_script"] ?? ''}}</textarea>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card body-->
                                    <div class="card-footer border-0">
                                        <div class="pull-right">
                                            <!--begin::Button-->
                                            <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                                            <!--end::Button-->
                                            <!--begin::Button-->
                                            <button type="submit" id="connection_detail_submit" class="btn btn-primary">
                                                <span class="indicator-label">Save Changes</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </form>
                                <!--begin::Main column-->
                                <div class="card card-flush">
                                    <div class="card-header">
                                        <h2></h2>
                                        <div class="pull-right card-toolbar">
                                            <button type="button" class="btn btn-light-primary me-3 connection_custom_fields_add" data-bs-toggle="modal" data-bs-target="#connection_custom_field_add">+Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-8 pt-0 table-responsive">
                                        <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="connection_custom_field_head">
                                            <thead>
                                                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                                    <th class="text-capitalize text-nowrap">Sr. No.</th>
                                                    <th class="text-capitalize text-nowrap">Answer-Type</th>
                                                    <th class="text-capitalize text-nowrap">Mandatory</th>
                                                    <th class="text-center text-capitalize text-nowrap">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600" id="connection_custom_field_body">
                                                @if (!empty($connection_custom_details) && count($connection_custom_details) > 0)
                                                @foreach ($connection_custom_details as $key => $value)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$value["answer_type"] == 1?'Radio Button':'Textbox'}}</td>
                                                    <td>{{$value["mandatory"] == 1?'Yes':'No'}}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                            <span class="svg-icon svg-icon-5 m-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </a>
                                                        <!--begin::Menu-->
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a type="button" class="menu-link px-3 edit_connection_custom_fields" data-mandatory='{{$value["mandatory"]}}' data-answer_type='{{$value["answer_type"]}}' data-id='{{$value["id"]}}' data-question='{{$value["question"]}}' data-message='{{$value["message"]}}' data-count='{{$value["count"]}}'>Edit</a>
                                                                <a type="button" class="menu-link delete_custom_fields" data-id='{{$value["id"]}}'>Delete</a>
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
                            <!--begin::Modal - addedit column-->
                            <div class="modal fade" id="connection_custom_field_add" tabindex="-1" role="dialog">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-500px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <form role="form" id="connection_custom_field_form" name="connection_custom_field_form" method="post">
                                            @csrf

                                            <!--begin::Modal header-->
                                            <div class="modal-header bg-primary px-5 py-4">
                                                <!--begin::Modal title-->
                                                <h2 class="fw-bolder fs-12 text-white">Custom sections</h2>
                                                <!--end::Modal title-->
                                                <!--begin::Close-->
                                                <div id="add_provider_connection_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
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
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="fs-5 fw-bold form-label mb-1">Question</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="fv-row link_title">
                                                        <input type="text" class="form-control form-control-lg form-control-solid h-50px border" name="connection_custom_field_quest" id="connection_custom_field_quest">
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="fv-row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="fs-5 fw-bold form-label mb-1">Mandatory</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="fv-row order">
                                                        <input type="checkbox" class="form-check-input radio-w-h-18" name="connection_custom_field_mandatory" value="1" id="connection_custom_field_mandatory">
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="fv-row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="fs-5 fw-bold form-label mb-1">Validation Message</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="fv-row order">
                                                        <input type="text" class="form-control form-control-lg form-control-solid h-50px border" name="connection_custom_field_message" id="connection_custom_field_message">
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="fv-row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="fs-5 fw-bold form-label mb-1">Answer Type</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="fv-row order">
                                                        <select class="form-select form-select-solid" name="connection_custom_field_type" id="connection_custom_field_type" data-placeholder="Select options">
                                                            <option value="">Select option</option>
                                                            <option value="1">Radio Button</option>
                                                            <option value="2">Textbox</option>
                                                        </select>
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="fv-row mb-10 count">
                                                    <!--begin::Label-->
                                                    <label class="fs-5 fw-bold form-label mb-1">Count</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="fv-row order">
                                                        <select class="form-select form-select-solid" name="connection_custom_field_count" id="connection_custom_field_count" data-placeholder="Select options">
                                                            <option value="">Select option</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                        </select>
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <!--begin::Button-->
                                                    <button type="submit" id="connection_custom_field_submit" class="btn btn-primary">
                                                        <span class="indicator-label">Save Changes</span>
                                                        <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                    <!--end::Button-->
                                                </div>
                                            </div>
                                            <!--end::Modal body-->

                                        </form>
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>
                            <!-- End::Modal - addedit column-->
                        </div>
                    @endif
                    <div class="tab-pane fade show " id="identification_details" role="tab-panel">
                        <form role="form" id="identification_details_form" class="identification_details_form" name="identification_details_form">
                            @csrf
                            <!--start::Card body-->
                            <div class="card-body">
                                <input type="hidden" name="section_type_id" value="3">
                                <!--begin::Input group-->
                                <div class="row mb-8">
                                    <!--begin::Label-->
                                    <label class="col-lg-6 fw-bold fs-6">Do you want to enable primary identification details section for this provider?</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-6">
                                        <label class="form-check form-check-inline form-check-solid me-5">
                                            <input class="form-check-input" id="primary_identification_details1" class="primary_identification_details" name="identification_details[1]" type="radio" value="1" {{isset($identification_details_section["get_section_option"][0]) && $identification_details_section["get_section_option"][0]['section_option_status'] ? 'checked' : ''}} />
                                            <span class="fw-bold fs-6">
                                                {{ __('Yes') }}
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid">
                                            <input class="form-check-input" id="primary_identification_details0" class="primary_identification_details" name="identification_details[1]" type="radio" value="0" {{isset($identification_details_section["get_section_option"][0]) && $identification_details_section["get_section_option"][0]['section_option_status'] ? '' : 'checked'}} />
                                            <span class="fw-bold fs-6">
                                                {{ __(('No')) }}
                                            </span>
                                        </label>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="mb-8 identification_details_hideable {{$identification_details_hidden}}">
                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 fw-bold fs-6">Primary identification details</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6">
                                            <label class="form-check form-check-inline form-check-solid me-5">
                                                <input class="form-check-input is_required" id="is_required1" name="is_required[1]" type="radio" value="1" {{isset($identification_details_section["get_section_option"][0]) && $identification_details_section["get_section_option"][0]['is_required'] ? 'checked' : ''}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __('Mandatory') }}
                                                </span>
                                            </label>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid">
                                                <input class="form-check-input is_required" id="is_required0" name="is_required[1]" type="radio" value="0" {{isset($identification_details_section["get_section_option"][0]) && $identification_details_section["get_section_option"][0]['is_required'] ? '' : 'checked'}} />
                                                <span class="fw-bold fs-6">
                                                    <span class="fw-bold fs-6">
                                                        {{ __(('Optional')) }}
                                                    </span>
                                            </label>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-8 optional_ids {{$hideOption}}">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 fw-bold fs-6">Do you want to enable Secondary Identification details?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6">
                                            <label class="form-check form-check-inline form-check-solid me-5">
                                                <input class="form-check-input" id="secondary_identification_details1" class="secondary_identification_details" name="identification_details[2]" type="radio" value="1" {{isset($identification_details_section["get_section_option"][1]) && $identification_details_section["get_section_option"][1]['section_option_status'] ? 'checked' : ''}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __('Yes') }}
                                                </span>
                                            </label>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid">
                                                <input class="form-check-input" id="secondary_identification_details0" class="secondary_identification_details" name="identification_details[2]" type="radio" value="0" {{isset($identification_details_section["get_section_option"][1]) && $identification_details_section["get_section_option"][1]['section_option_status'] ? '' : 'checked'}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __(('No')) }}
                                                </span>
                                            </label>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-8 optional_ids optional_second_ids {{$hideOption}} {{$hideSecOption}}">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 fw-bold fs-6">Secondary identification details</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6">
                                            <label class="form-check form-check-inline form-check-solid me-5">
                                                <input class="form-check-input is_required" id="is_required_sec1" name="is_required[2]" type="radio" value="1" {{isset($identification_details_section["get_section_option"][1]) && $identification_details_section["get_section_option"][1]['is_required'] ? 'checked' : ''}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __('Mandatory') }}
                                                </span>
                                            </label>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid">
                                                <input class="form-check-input is_required" id="is_required_sec0" name="is_required[2]" type="radio" value="0" {{isset($identification_details_section["get_section_option"][1]) && $identification_details_section["get_section_option"][1]['is_required'] ? '' : 'checked'}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __(('Optional')) }}
                                                </span>
                                            </label>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-8 optional_ids {{$hideOption}}">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 required fw-bold fs-6">Which primary identification details can be accepted from the customer?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6 identification_details_sub_option 1">
                                            <select data-control="select2" class="form-select form-select-solid select_options" name="identification_details_sub_option[1][]" id="identification_details_sub_option" data-placeholder="Select options" multiple>
                                                @foreach($master_identification_details as $key=>$val)
                                                <option value="{{$key}}" @php if(!empty($identification_details_section['get_section_option']) && isset($identification_details_section['get_section_option'][0]) && !empty($identification_details_section['get_section_option'][0])){ $found=array_search($key, array_column($identification_details_section['get_section_option'][0]['get_section_sub_option'], 'section_sub_option_id' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-8 optional_ids optional_second_ids {{$hideOption}} {{$hideSecOption}}">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 required fw-bold fs-6">Which secondary identification details can be accepted from the customer?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6 identification_details_sub_option 2">
                                            <select data-control="select2" class="form-select form-select-solid select_options" name="identification_details_sub_option[2][]" id="identification_details_sub_option2" data-placeholder="Select options" multiple>
                                                @foreach($master_identification_details as $key=>$val)
                                                <option value="{{$key}}" @php if(isset($identification_details_section['get_section_option'][1]) && !empty($identification_details_section['get_section_option'][1]) && !empty($identification_details_section['get_section_option'][1])){ $found=array_search($key, array_column($identification_details_section['get_section_option'][1]['get_section_sub_option'], 'section_sub_option_id' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="col-lg-12 col-form-label fw-bold fs-6">Tele-Sales Script</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-12 col-xxl-12">
                                        <textarea type="text" id="identity_detail_script" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="identity_detail_script">{{$identification_details_section['section_script'] ?? ''}}</textarea>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="col-lg-12 col-form-label fw-bold fs-6">Acknowledgement</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-12 col-xxl-12">
                                        <textarea type="text" id="identification_details_acknowledgement" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="identification_details_acknowledgement">{{$identification_details_section['acknowledgement'] ?? ''}}</textarea>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->

                            <!--start::Card footer-->
                            <div class="card-footer border-0">
                                <div class="pull-right">
                                    <!--begin::Button-->
                                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" id="identification_detail_submit" class="btn btn-primary">
                                        <span class="indicator-label">Save Changes</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                            </div>
                            <!--end::Card footer-->
                        </form>
                    </div>
                    <div class="tab-pane fade show " id="employment_details" role="tab-panel">
                        <form role="form" id="employment_details_form" class="employment_details_form" name="employment_details_form">
                            @csrf
                            <div class="card-body   ">
                                <input type="hidden" name="section_type_id" value="4">
                                <!--begin::Input group-->
                                <div class="row mb-5 py-4">
                                    <!--begin::Label-->
                                    <label class="col-lg-6 fw-bold fs-6">Do you want to enable this section for this provider?</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-6 fv-row">
                                        <label class="form-check form-check-inline form-check-solid me-5">
                                            <input class="form-check-input" class="employment_detail_status" name="employment_detail_status" type="radio" value="1" {{isset($employment_details_section["section_status"]) && $employment_details_section["section_status"] ? 'checked' : ''}} />
                                            <span class="fw-bold fs-6">
                                                {{ __('Yes') }}
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid">
                                            <input class="form-check-input" class="employment_detail_status" name="employment_detail_status" type="radio" value="0" {{isset($employment_details_section["section_status"]) && $employment_details_section["section_status"] ? '' : 'checked'}} />
                                            <span class="fw-bold fs-6">
                                                {{ __(('No')) }}
                                            </span>
                                        </label>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <div class="mb-8 employment_details_hideable {{$employment_details_hidden}}">
                                    <!--begin::Input group-->
                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 required fw-bold fs-6">Which employment details will be collected from the customer?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6 employment_details">
                                            <select data-control="select2" class="form-select form-select-solid select_options" name="employment_details[]" id="employment_details" data-placeholder="Select options" multiple>
                                                @foreach($master_employment_details as $key=>$val)
                                                <option value="{{$key}}" @php if(isset($employment_details_section['get_section_option']) && !empty($employment_details_section['get_section_option']) ){ $found=array_search($key, array_column($employment_details_section['get_section_option'], 'section_option_id' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger"></span>

                                            <div class="col-lg-6 employment_details_sub_option" @php if(isset($employment_details_section['get_section_option']) && !empty($employment_details_section['get_section_option']) ){ $found=array_search(4, array_column($employment_details_section['get_section_option'], 'section_option_id' )); if(is_numeric($found)){echo 'style="display:block;"' ; } else {echo 'style="display:none;"' ; } } @endphp>
                                                <label class="col-lg-6 fw-bold fs-6">Years</label>
                                                <select data-control="select2" class="form-select form-select-solid select_options" name="employment_details_year_option" id="employment_details_year_option" data-placeholder="Select Year">
                                                    @for($i=0;$i<=10;$i++) <option value="{{$i}}" @php if(isset($employment_details_section['get_section_option']) && !empty($employment_details_section['get_section_option']) ){ $found=array_search($i, array_column($employment_details_section['get_section_option'], 'max_value_limit' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$i}}</option>
                                                        @endfor
                                                </select>
                                                <label class="col-lg-6 fw-bold fs-6">Months</label>
                                                <select data-control="select2" class="form-select form-select-solid select_options" name="employment_details_month_option" id="employment_details_month_option" data-placeholder="Select Month">
                                                    @for($i=0;$i<=11;$i++) <option value="{{$i}}" @php if(isset($employment_details_section['get_section_option']) && !empty($employment_details_section['get_section_option']) ){ $found=array_search($i, array_column($employment_details_section['get_section_option'], 'min_value_limit' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$i}}</option>
                                                        @endfor
                                                </select>
                                            </div>






                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--begin::Input group-->
                                <div class="row mb-5">
                                    <!--begin::Label-->
                                    <label class="col-lg-12 col-form-label fw-bold fs-6">Tele-Sales Script</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-12 col-xxl-12">
                                        <textarea type="text" id="employment_detail_script" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="employment_detail_script">{{$employment_details_section['section_script'] ?? ''}}</textarea>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <div class="card-footer border-0">
                                <div class="pull-right">
                                    <!--begin::Button-->
                                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" id="employment_detail_submit" class="btn btn-primary">
                                        <span class="indicator-label">Save Changes</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                            </div>
                            <!--end::Card body-->
                        </form>
                    </div>
                    <div class="tab-pane fade show " id="connection_address" role="tab-panel">
                        <form role="form" id="connection_address_form" class="connection_address_form" name="connection_address_form">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="section_type_id" value="5">
                                <!--begin::Input group-->
                                <div class="row mb-5 py-4">
                                    <!--begin::Label-->
                                    <label class="col-lg-6 fw-bold fs-6">Do you want to enable this section for this provider?</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-6">
                                        <label class="form-check form-check-inline form-check-solid me-5">
                                            <input class="form-check-input" class="conn_address_detail_status" name="conn_address_detail_status" type="radio" value="1" {{isset($connection_address_section["section_status"]) && $connection_address_section["section_status"] ? 'checked' : ''}} />
                                            <span class="fw-bold fs-6">
                                                {{ __('Yes') }}
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid">
                                            <input class="form-check-input" class="conn_address_detail_status" name="conn_address_detail_status" type="radio" value="0" {{isset($connection_address_section["section_status"]) && $connection_address_section["section_status"] ? '' : 'checked'}} />
                                            <span class="fw-bold fs-6">
                                                {{ __(('No')) }}
                                            </span>
                                        </label>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-8 connection_address_hideable {{$connection_address_hidden}}">
                                    <div class="row mb-5">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 required fw-bold fs-6">Which connection details will be collected from the customer?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6 connection_address">
                                            <select data-control="select2" class="form-select form-select-solid select_options" name="connection_address[]" id="connection_address" data-placeholder="Select options" multiple>
                                                @foreach($master_connection_address as $key=>$val)
                                                <option value="{{$key}}" @php if(isset($connection_address_section['get_section_option']) && !empty($connection_address_section['get_section_option']) ){ $found=array_search($key, array_column($connection_address_section['get_section_option'], 'section_option_id' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger"></span>
                                            <div class="col-lg-6 connection_address_sub_option" @php if(isset($connection_address_section['get_section_option']) && !empty($connection_address_section['get_section_option']) ){ $found=array_search(1, array_column($connection_address_section['get_section_option'], 'section_option_id' )); if(is_numeric($found)){echo 'style="display:block;"' ; } else {echo 'style="display:none;"' ; } }else {echo 'style="display:none;"' ; } @endphp>
                                                <label class="col-lg-6 fw-bold fs-6">Years</label>
                                                <select data-control="select2" class="form-select form-select-solid select_options" name="connection_address_year_option" id="connection_address_year_option" data-placeholder="Select Year">
                                                    @for($i=0;$i<=10;$i++) <option value="{{$i}}" @php if(isset($connection_address_section['get_section_option']) && !empty($connection_address_section['get_section_option']) ){ $found=array_search($i, array_column($connection_address_section['get_section_option'], 'max_value_limit' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$i}}</option>
                                                        @endfor
                                                </select>
                                                <label class="col-lg-6 fw-bold fs-6">Months</label>
                                                <select data-control="select2" class="form-select form-select-solid select_options" name="connection_address_month_option" id="connection_address_month_option" data-placeholder="Select Month">
                                                    @for($i=0;$i<=11;$i++) <option value="{{$i}}" @php if(isset($connection_address_section['get_section_option']) && !empty($connection_address_section['get_section_option']) ){ $found=array_search($i, array_column($connection_address_section['get_section_option'], 'min_value_limit' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$i}}</option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-5">
                                    <!--begin::Label-->
                                    <label class="col-lg-12 col-form-label fw-bold fs-6">Tele-Sales Script</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-12 col-xxl-12">
                                        <textarea type="text" id="connection_address_script" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="connection_address_script">{{$connection_address_section['section_script'] ?? ''}}</textarea>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <div class="card-footer border-0">
                                <div class="pull-right">
                                    <!--begin::Button-->
                                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" id="connection_address_submit" class="btn btn-primary">
                                        <span class="indicator-label">Save Changes</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                            </div>
                            <!--end::Card body-->
                        </form>
                    </div>
                    <div class="tab-pane fade show " id="billing_and_delivery_address" role="tab-panel">
                        <form role="form" id="billing_and_delivery_address_form" class="billing_and_delivery_address_form" name="billing_and_delivery_address_form">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="section_type_id" value="6">
                                <!--begin::Input group-->
                                <div class="row mb-5">
                                    <!--begin::Label-->
                                    <label class="col-lg-6 fw-bold fs-6">Do you want to enable this section for this provider?</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-6">
                                        <label class="form-check form-check-inline form-check-solid me-5">
                                            <input class="form-check-input" class="billing_delivery_detail_status" name="billing_delivery_detail_status" type="radio" value="1" {{isset($billing_and_delivery_address_section["section_status"]) && $billing_and_delivery_address_section["section_status"] ? 'checked' : ''}} />
                                            <span class="fw-bold fs-6">
                                                {{ __('Yes') }}
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid">
                                            <input class="form-check-input" class="billing_delivery_detail_status" name="billing_delivery_detail_status" type="radio" value="0" {{isset($billing_and_delivery_address_section["section_status"]) && $billing_and_delivery_address_section["section_status"] ? '' : 'checked'}} />
                                            <span class="fw-bold fs-6">
                                                {{ __(('No')) }}
                                            </span>
                                        </label>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="mb-8 billing_delivery_details_hideable {{$billing_delivery_details_hidden}}">
                                    <div class="row mb-5">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 fw-bold fs-6">Do you want to enable Billing Address?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6">
                                            <label class="form-check form-check-inline form-check-solid me-5">
                                                <input class="form-check-input billing_address" id="billing_address1" name="billing_and_delivery_required[1]" type="radio" value="1" {{isset($billing_and_delivery_address_section["get_section_option"][0]) && $billing_and_delivery_address_section["get_section_option"][0]["is_required"] ? 'checked' : ''}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __('Yes') }}
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline form-check-solid">
                                                <input class="form-check-input billing_address" id="billing_address0" name="billing_and_delivery_required[1]" type="radio" value="0" {{isset($billing_and_delivery_address_section["get_section_option"][0]) && $billing_and_delivery_address_section["get_section_option"][0]["is_required"] ? '' : 'checked'}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __(('No')) }}
                                                </span>
                                            </label>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-5">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 fw-bold fs-6">Do you want to enable Delivery Address?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6">
                                            <label class="form-check form-check-inline form-check-solid me-5">
                                                <input class="form-check-input delivery_address" id="delivery_address1" name="billing_and_delivery_required[2]" type="radio" value="1" {{isset($billing_and_delivery_address_section["get_section_option"][1]) && $billing_and_delivery_address_section["get_section_option"][1]["is_required"] ? 'checked' : ''}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __('Yes') }}
                                                </span>
                                            </label>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid">
                                                <input class="form-check-input delivery_address" id="delivery_address0" name="billing_and_delivery_required[2]" type="radio" value="0" {{isset($billing_and_delivery_address_section["get_section_option"][1]) && $billing_and_delivery_address_section["get_section_option"][1]["is_required"] ? '' : 'checked'}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __(('No')) }}
                                                </span>
                                            </label>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-5 billing_address_dropdown {{$billing_address_hidden}}">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 required fw-bold fs-6">Which billing address details will be collected from the customer?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6 billing_and_delivery_address_sub_opt 1">
                                            <select data-control="select2" class="form-select form-select-solid select_options" name="billing_and_delivery_address_sub_opt[1][]" id="billing_address_sub_opt" data-placeholder="Select options" multiple>
                                                @foreach($master_billing_address as $key=>$val)
                                                <option value="{{$key}}" @php if(isset($billing_and_delivery_address_section['get_section_option'][0]) && !empty($billing_and_delivery_address_section['get_section_option'][0]) && !empty($billing_and_delivery_address_section['get_section_option'][0]['get_section_sub_option'])){ $found=array_search($key, array_column($billing_and_delivery_address_section['get_section_option'][0]['get_section_sub_option'], 'section_sub_option_id' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-5 delivery_address_dropdown {{$delivery_address_hidden}}">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 required fw-bold fs-6">Which delivery address details will be collected from the customer?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6 billing_and_delivery_address_sub_opt 2">
                                            <select data-control="select2" class="form-select form-select-solid select_options" name="billing_and_delivery_address_sub_opt[2][]" id="delivery_address_sub_opt" data-placeholder="Select options" multiple>
                                                @foreach($master_delivery_address as $key=>$val)
                                                <option value="{{$key}}" @php if(isset($billing_and_delivery_address_section['get_section_option'][1]) && !empty($billing_and_delivery_address_section['get_section_option'][1]) && !empty($billing_and_delivery_address_section['get_section_option'][1]['get_section_sub_option'])){ $found=array_search($key, array_column($billing_and_delivery_address_section['get_section_option'][1]['get_section_sub_option'], 'section_sub_option_id' )); if(is_numeric($found)){ echo 'selected' ; } } @endphp>{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="col-lg-12 col-form-label fw-bold fs-6">Tele-Sales Script</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-12 col-xxl-12">
                                        <textarea type="text" id="billing_delivery_detail_script" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="billing_delivery_detail_script">
                                        {{$billing_and_delivery_address_section['section_script'] ?? ''}}
                                        </textarea>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <div class="card-footer border-0">
                                <div class="pull-right">
                                    <!--begin::Button-->
                                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" id="billing_delivery_detail_submit" class="btn btn-primary">
                                        <span class="indicator-label">Save Changes</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="tab-pane fade show " id="life_support_equipments" role="tab-panel">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <div class="card card-flush">
                                    <div class="card-header">
                                        <h2></h2>
                                        <div class="pull-right card-toolbar">
                                            <button type="button" class="btn btn-light-primary me-3 add_edit_equipment" data-bs-toggle="modal" data-bs-target="#life_support_equipments_modal" data-action="add">+Assign Aquipments</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-8 pt-0 table-responsive">
                                        <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="life_support_equipments_table">
                                            <thead>
                                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                                <th class="text-capitalize text-nowrap">Sr. No.</th>
                                                <th class="text-capitalize text-nowrap">Title</th>
                                                <th class="text-capitalize text-nowrap">Status</th>
                                                <th class="text-capitalize text-nowrap">Order</th>
                                                <th class="text-center text-capitalize text-nowrap">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-gray-600" id="life_support_equipments_body">
                                                @forelse($provider_equipments as $key => $value)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$value->title}}</td>
                                                    <td><span>
                                                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input change-life-support-status" data-id="{{$value->id}}" type="checkbox" data-status="{{$value->status}}" title="{{$value->status ? 'Click to disable' : 'Click to enable'}}" name="notifications" {{$value->status== 1 ? 'checked' : ''}}></div>
                                                        </span></td>
                                                    <td>{{$value->order}}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                            <span class="svg-icon svg-icon-5 m-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                            <div class="menu-item px-3">
                                                                <a type="button" class="menu-link px-3 add_edit_equipment" data-bs-toggle="modal" data-bs-target="#life_support_equipments_modal" data-status="{{$value->status}}" data-order="{{$value->order}}" data-title="{{$value->title}}" data-action="edit" data-id="{{$value->id}}" data-equipment_id="{{$value->life_support_equipment_id}}">Edit</a>
                                                                <a type="button" class="menu-link px-3 delete_equipment" data-provider_id="{{$value->provider_id}}" data-id="{{$value->id}}">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="life_support_equipments_modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered mw-500px">
                                    <div class="modal-content">
                                        <form role="form" id="life_support_equipments_form" class="life_support_equipments_form" name="life_support_equipments_form">
                                            @csrf
                                            <input type="hidden" class="status" id="status" name="status" value="0">
                                            <input type="hidden" class="action_type" id="action_type" name="action_type" value="">
                                            <input type="hidden" class="equipment_id" id="equipment_id" name="equipment_id" value="">
                                            <div class="modal-header bg-primary px-5 py-4">
                                                <h2 class="fw-bolder fs-12 text-white">Assign Equipments</h2>
                                                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                                                    <span class="svg-icon svg-icon-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="modal-body scroll-y">
                                                <div class="fv-row mb-5">
                                                    <label class="fs-5 fw-bold form-label mb-1">Equipment</label>
                                                    <div class="fv-row equipment">
                                                        <select class="form-control form-control-solid form-select p-4" id="equipment" name="equipment" data-placeholder="Select">
                                                            <option value="">Select</option>
                                                            @forelse($all_equipments as $equipment)
                                                            <option value="{{$equipment->id}}">{{$equipment->title}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="fv-row mb-10">
                                                    <label class="fs-5 fw-bold form-label mb-1">Order</label>
                                                    <div class="fv-row order">
                                                        <input type="number" class="form-control form-control-lg form-control-solid h-50px border" id="order" placeholder="" name="order" min="1">
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" id="life_support_equipments_submit" class="btn btn-primary">
                                                        <span class="indicator-label">Save Changes</span>
                                                        <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    @if(isset($selected_service) && $selected_service['service_id']==1)
                        <div class="tab-pane fade show " id="other_settings" role="tab-panel">
                            <form role="form" id="other_settings_form" class="other_settings_form" name="other_settings_form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="form_type" value="provider_manage_section_form">
                                    <input type="hidden" name="section_type_id" value="8">
                                    <!--begin::Input group-->
                                    <div class="row mb-5">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 fw-bold fs-6">Do you want to enable Sclerosis question for this provider </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6">
                                            <label class="form-check form-check-inline form-check-solid me-5">   </label>
                                                <input class="form-check-input" class="other_setting_sclerosis_status" name="other_setting_sclerosis_status" type="radio" value="1" id="other_setting_sclerosis_status_yes" {{ isset($permission) && $permission['is_sclerosis'] == 1 ? 'checked' : ''}}/>
                                                <span class="fw-bold fs-6">
                                                    {{ __('Yes') }}
                                                </span>
                                                <span class="error text"></span>
                                        
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid"></label>
                                                <input class="form-check-input" class="other_setting_sclerosis_status" name="other_setting_sclerosis_status" type="radio" value="0"  id="other_setting_sclerosis_status_no" {{ isset($permission) && $permission['is_sclerosis'] == 0 ? 'checked' : ''}} />
                                                <span class="fw-bold fs-6">
                                                    {{ __(('No')) }}
                                                </span>
                                                <span class="error text"></span>
                                        
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-5 other_setting_sclerosis_title" style="display:none;">
                                        <!--begin::Label-->
                                        <label class="col-lg-12  col-form-label required fw-bold fs-6">Sclerosis Title </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-12 col-xxl-12">
                                            <label class="form-check form-check-inline form-check-solid me-5"> </label>
                                            <div class="col-lg-12 col-xxl-12 ">
                                                <textarea type="text" id="other_setting_sclerosis_title" class="form-control form-control-lg form-control-solid ckeditor"
                                                    tabindex="8" placeholder="" rows="5"
                                                    name="other_setting_sclerosis_title">{{ isset($permission) ?$permission['sclerosis_title']: ''}}</textarea>
                                                <span class="error text-danger"></span>
                                            </div>
                                                
                                            <!--end::Option-->

                                        </div>
                                        <!--end::Input-->
                                    </div>


                                    <div class="row mb-5">
                                        <!--begin::Label-->
                                        <label class="col-lg-6 fw-bold fs-6">Do you want to enable Medical Cooling question for this provider
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-6">
                                            <label class="form-check form-check-inline form-check-solid me-5"></label>
                                                <input class="form-check-input other_setting_medical_cooling_status"  name="other_setting_medical_cooling_status" type="radio" value="1" id="other_setting_medical_cooling_status_yes" {{ isset($permission) && $permission['is_medical_cooling'] == 1 ? 'checked' : ''}}/>
                                                <span class="fw-bold fs-6">
                                                    {{ __('Yes') }}
                                                </span>
                                                <span class="error text"></span>
                                        
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid"></label>
                                                <input class="form-check-input other_setting_medical_cooling_status" name="other_setting_medical_cooling_status" type="radio" value="0"  id="other_setting_medical_cooling_status_no" {{ isset($permission) && $permission['is_medical_cooling'] == 0 ? 'checked' : ''}}/>
                                                <span class="fw-bold fs-6">
                                                    {{ __(('No')) }}
                                                </span>
                                                <span class="error text"></span>
                                        
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="row mb-5 other_setting_medical_cooling_title" style="display:none;">
                                        <!--begin::Label-->
                                        <label class="col-lg-12  col-form-label required fw-bold fs-6">Medical Cooling Title </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-12 col-xxl-12">
                                            <label class="form-check form-check-inline form-check-solid me-5"> </label>
                                            <div class="col-lg-12 col-xxl-12">
                                                <textarea type="text" id="other_setting_medical_cooling_title" class="form-control form-control-lg form-control-solid ckeditor"
                                                    tabindex="8" placeholder="" rows="5"
                                                    name="other_setting_medical_cooling_title">{{ isset($permission) ?$permission['medical_cooling_title']: ''}}</textarea>
                                                <span class="error text-danger"></span>
                                            </div>
                                                
                                            <!--end::Option-->

                                        </div>
                                        <!--end::Input-->
                                    </div>
                                
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card body-->
                                <div class="card-footer border-0">
                                    <div class="pull-right">
                                        <!--begin::Button-->
                                        <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="other_setting_form_submit" class="btn btn-primary">
                                            <span class="indicator-label">Save Changes</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    
                </div>
                <!--end::Tab content-->
            </div>
        </div>
    </div>
    <!--end::Pricing-->
    </form>
</div>
<!--end::Main column-->