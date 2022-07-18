<!-- <div class="d-flex flex-column gap-7 gap-lg-10"> -->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="statewise_consent_form" class="statewise_consent_form" name="statewise_consent_form">
        @csrf
        <!--begin::General options-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body px-8">
                <!--begin::Input group-->

                <div class="row mb-8">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-bold fs-6">Provider Name :</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <strong
                        class="col-lg-8 text-capitalize">{{ decryptGdprData($account_detail['name'] ?? '') }}</strong>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <div class="row mb-3">
                    <!--begin::Input-->
                    <label class="col-lg-4 fw-bold fs-6">EIC Type</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 eic_type_checkbox">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input" name="eic_type_checkbox" id="eic_type_checkbox_yes"
                                class="eic_type_checkbox" type="radio" value="state" checked />
                            <span class="fw-bold ps-2 fs-6">
                                State
                            </span>
                        </label>
                        <!--end::Option-->

                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid">
                            <input class="form-check-input" id="eic_type_checkbox_no" name="eic_type_checkbox"
                                class="eic_type_checkbox" type="radio" value="master" />
                            <span class="fw-bold ps-2 fs-6">
                                Master
                            </span>
                        </label>
                        <p><span class="error text-danger"></span></p>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--end::Input-->
                <!--begin::Input group-->
                <div class="row mb-3 select_state">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6 mb-5">State </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 select_consent_state">
                        <select data-control="select2" class="form-select form-select-solid sss"
                            name="select_consent_state" id="select_consent_state"
                          >
                            <option value="">Select State</option>
                            @if (count($states) > 0)
                                @foreach ($states as $row)
                                    <option value="{{ $row->id }}"
                                        {{ isset($state_consent['state_id']) && $row->id == $state_consent['state_id'] ? 'selected' : '' }}>
                                        {{ $row->name }}</option>
                                @endforeach
                                <p><span class="error text-danger"></span></p>
                            @endif
                        </select>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>

                <div class="row mb-5">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label fw-bold fs-6">Parameters</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12">
                        <select data-control="select2" data-placeholder="Select Parameters" data-hide-search="true"
                            name="statewise_select" id="select_selectsplitter1" class="form-select statewise_select"
                            data-id="statewise_select" size="5">
                            <option value="@Affiliate-Abn@" class="post_sub_parameter">@Affiliate-Abn@</option>
                            <option value="@Affiliate-Name@" class="post_sub_parameter">@Affiliate-Name@</option>
                            <option value="@Affiliate-Address@" class="post_sub_parameter">@Affiliate-Address@</option>
                            <option value="@Affiliate-Contact-Number@" class="post_sub_parameter">
                                @Affiliate-Contact-Number@</option>
                            <option value="@Plan-Name@" class="post_sub_parameter">@Plan-Name@</option>
                            <option value="@Plan-Type@" class="post_sub_parameter">@Plan-Type@</option>
                            <option value="@Connection-Type@" class="post_sub_parameter">@Connection-Type@</option>
                            <option value="@Provider-Name@" class="post_sub_parameter">@Provider-Name@</option>
                            <option value="@Reference-ID@" class="post_sub_parameter">@Reference-ID@</option>
                            <option value="@Customer-Name@" class="post_sub_parameter">@Customer-Name@</option>
                            <option value="@Customer-Email@" class="post_sub_parameter">@Customer-Email@</option>
                            <option value="@Customer-Contact-Number@" class="post_sub_parameter">
                                @Customer-Contact-Number@</option>
                            <option value="@Service-Type@" class="post_sub_parameter">@Service-Type@</option>
                            <option value="@Plan-Monthly-Cost@" class="post_sub_parameter">@Plan-Monthly-Cost@</option>
                            <option value="@Customer-Last-Name@" class="post_sub_parameter">@Customer-Last-Name@
                            </option>
                            <option value="@Provider-Contact-Number@" class="post_sub_parameter">
                                @Provider-Contact-Number@</option>
                        </select>
                    </div>
                    <!--end::Input-->
                </div>
                <div class=" mb-5" style="display:none;">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label required fw-bold fs-6">Paper Bill Content Parameter </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12">
                        <select data-control="select2" data-placeholder="Select Tag" data-hide-search="true"
                            name="select_selectsplitter1" id="select_selectsplitter1" class="form-select" size="5">
                            <option value="@Provider_Name@" class="post_sub_parameter2">@Provider_Name@</option>
                            <option value="@Provider_Logo@" class="post_sub_parameter2">@Provider_Logo@</option>
                            <option value="@name@" class="post_sub_parameter2">@name@</option>
                            <option value="@Provider_Phone_Number@" class="post_sub_parameter2">@Provider_Phone_Number@
                            </option>
                            <option value="@Provider_Email@" class="post_sub_parameter2">@Provider_Email@</option>
                            <option value="@Affiliate_Name@" class="post_sub_parameter2">@Affiliate_Name@</option>
                            <option value="@Affiliate_Logo@" class="post_sub_parameter2">@Affiliate_Logo@</option>
                            <option value="@Customer_Full_Name@" class="post_sub_parameter2">@Customer_Full_Name@
                            </option>
                            <option value="@Customer_Mobile_Number@" class="post_sub_parameter2">
                                @Customer_Mobile_Number@</option>
                            <option value="@Customer_Email@" class="post_sub_parameter2">@Customer_Email@</option>
                        </select>
                    </div>
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <div class="mb-5">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label required fw-bold fs-6">Content:</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12 statewise_consent_content">
                        <textarea type="text" id="statewise_consent_content" class="form-control form-control-lg form-control-solid ckeditor"
                            tabindex="8" placeholder="" rows="5"
                            name="statewise_consent_content">{{ $state_consent['description'] ?? '' }}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <!--begin::Button-->
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}"
                        class="btn btn-light me-3">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="statewise_consent_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
        </div>
        <!--end::Card header-->

<!--end::Pricing-->
</form>
<!-- </div> -->

<!--begin::General options-->
<div class="card card-flush py-0 px-0">
    <div class="card-header border-0 pt-0 px-8">
        <div class="card-title">
            <h2>EIC Checkboxes</h2>
        </div>
        <div class="pull-right card-toolbar">
            <button type="button" class="btn btn-light-primary me-3"  id="add_statewise_checkbox_button">+Add
                Checkbox</button>
        </div>
    </div>
    <div class="card-body  pt-0 table-responsive">
        <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class"
            id="provider_state_eic_content_checkbox_table">
            <thead>
                <tr class="fw-bolder fs-6 text-gray-600 px-7">
                    <th class="text-capitalize text-nowrap">Sr. No.</th>
                    <th class="text-capitalize text-nowrap">Required</th>
                    <th class="text-capitalize text-nowrap">Content</th>
                    <!-- <th>Status</th> -->
                    <th class="text-left text-capitalize text-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600" id="statewise_list">
                @php
                    //dd($state_consent);
                @endphp
                @if (!empty($state_consent_checkboxs) && count($state_consent_checkboxs) > 0)
                    @foreach ($state_consent_checkboxs as $key => $value)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $value['checkbox_required'] ? 'Yes' : 'No' }}</td>
                            <td title="{{ strip_tags($value['content']) }}">
                                <span class="ellipses_table"> {{ strip_tags($value['content'])}}</span>
                            </td>
                            <!-- <td>{{ $value['status'] ? 'Yes' : 'No' }}</td> -->
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
                                        <a class="menu-link px-3" id="statewise_checkbox_edit" data-bs-toggle="modal"
                                            data-bs-target="#add_provider_state_eic_content_checkbox"
                                            data-id="{{ $value['id'] }}" data-eic="{{ $value['type'] }}"
                                            data-required_checkbox="{{ $value['checkbox_required'] }}"
                                            data-order="{{$value['order']}}"
                                            data-save_checkbox="{{ $value['status'] }}"
                                            data-validation_message="{{ $value['validation_message'] }}"
                                            data-checkbox_content="{{ $value['content'] }}">Edit</a>
                                        <a type="button" id="statewise_checkbox_delete" data-id="{{ $value['id'] }}"
                                            class="menu-link px-3">Delete</a>
                                    </div>
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<!--end::Pricing-->
</div>
<!--begin::Modal - Adjust Balance-->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"  id="add_provider_state_eic_content_checkbox" tabindex="-1" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">EIC Checkbox</h2>
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
                <form id="provider_state_eic_content_checkbox_form" class="form">
                    @csrf
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-6 required fw-bold fs-6 mb-5">Does this checkbox is required? </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 state_eic_content_checkbox_required">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input" name="state_eic_content_checkbox_required"
                                    id="statewise_checkbox_required_yes" type="radio" value="1" checked />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <input class="form-check-input" id="statewise_checkbox_required_no"
                                    name="state_eic_content_checkbox_required" type="radio" value="0" />
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
                    <div class="row mb-8 validation_message">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label fw-bold fs-6">Validation Message</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 state_eic_content_validation_msg">
                            <textarea type="text" id="state_eic_content_validation_msg"
                                class="form-control form-control-lg form-control-solid ckeditor" tabindex="8"
                                placeholder="" rows="3" name="state_eic_content_validation_msg"></textarea>
                            <span class="error"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-6 required fs-5 fw-bold mb-1">Save Checkbox Status in Database?</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 state_eic_content_checkbox_save_status">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <!-- <input type="hidden" name="state_eic_content_checkbox_save_status" value="1"> -->
                                <input class="form-check-input" name="state_eic_content_checkbox_save_status"
                                    id="statewise_save_status_yes" type="radio" value="1" checked />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <!-- <input type="hidden" name="state_eic_content_checkbox_save_status" value="0"> -->
                                <input class="form-check-input" id="statewise_save_status_no"
                                    name="state_eic_content_checkbox_save_status" type="radio" value="0" />
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
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-3 col-form-label required fs-5 fw-bold mb-1">Select EIC type </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-9 statewise_select_eic_type">
                            <select data-control="select2" class="form-select form-select-solid"
                                name="statewise_select_eic_type" id="state_select_eic_type">
                                <option value="" class="">Select EIC Type</option>
                                <option value="1"> Credit Check Consent </option>
                                <option value="2"> Move In </option>
                                <option value="3"> Paper Bill </option>
                                <option value="4"> Tele Sale </option>
                                <option value="5"> Terms & Conditions </option>
                                <option value="6"> Others </option>
                                <option value="7"> Bolt On </option>
                            </select>
                            <span class="error"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-6 col-form-label required fs-5 fw-bold mb-1">Order </label>

                        <div class="col-lg-6 order">
                            <input type="number" class="form-control form-control-lg form-control-solid h-50px border" id="state_consent_checkbox_order" placeholder="e.g. 5" name="order">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label required fs-5 fw-bold mb-1">Checkbox Content
                            Parameters:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12">
                            <select data-control="select2" data-placeholder="" data-hide-search="true"
                                name="statewise_select_checkbox" id="select_selectsplitter1"
                                class="form-select statewise_select_checkbox" data-id="statewise_select_checkbox"
                                size="5">
                                <option value="@Affiliate-Name@" class="statewise_checkbox_parameter">@Affiliate-Name@
                                </option>
                                <option value="@Provider-Name@" class="statewise_checkbox_parameter">@Provider-Name@
                                </option>
                                <option value="@Provider-Phone-Number@" class="statewise_checkbox_parameter">
                                    @Provider-Phone-Number@</option>
                                <option value="@Provider-Address@" class="statewise_checkbox_parameter">
                                    @Provider-Address@</option>
                                <option value="@Provider-Email@" class="statewise_checkbox_parameter">@Provider-Email@
                                </option>
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>

                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label required fs-5 fw-bold mb-1">Checkbox Content</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 state_eic_content_checkbox_content">
                            <textarea type="text" id="state_eic_content_checkbox_content"
                                class="form-control form-control-lg form-control-solid ckeditor" tabindex="8"
                                placeholder="" rows="3" name="state_eic_content_checkbox_content"></textarea>
                            <span class="error"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="state_eic_content_checkbox_submit" class="btn btn-primary">Save
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
