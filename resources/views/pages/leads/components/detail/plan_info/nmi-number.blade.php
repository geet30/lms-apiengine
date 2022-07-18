<div class="tab-pane fade show mb-5" role="tab-panel">
    <div id="nmi_number_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>NMI Numbers</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder me-6 text-primary show_history"
                        data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                        data-vertical_id="{{ $verticalId ?? '' }}" data-section='nmi_number'
                        data-for="nmi_number_history" data-initial="nmi_number_show">Show
                        History</a>

                        <a href="javascript:void(0);" class="fw-bolder text-primaryfloat-end edit_sales_btn" data-for="nmi_number_edit" data-initial="nmi_number_show">
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-pencil-square text-primary" aria-hidden="true"></i></span>Edit
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '1')
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">NMI Number:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_nmi_number_td">{{ $saleDetail->vie_nmi_number ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Skip NMI Number:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_nmi_skip_td">{{ isset($saleDetail->vie_nmi_skip) &&$saleDetail->vie_nmi_skip==1 ? 'True':'False'}}
                                                </td>
                                            </tr>
                                        @endif
                                        @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '2' || isset($gasSaleDetail))
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">DPI-MIRN Number:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_dpi_mirn_number_td">
                                                    {{ $saleDetail->vie_dpi_mirn_number ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Skip MIRN Number:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_mirn_skip_td">
                                                    {{ isset($saleDetail->vie_mirn_skip) && $saleDetail->vie_mirn_skip == 1 ? 'True':'False' }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Site Tariff Type:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_tariff_type_td">
                                                {{ $saleDetail->vie_tariff_type ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Site Network Tariff List:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_tariff_list_td">
                                                {{ $saleDetail->vie_tariff_list ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>

                        <!-- right side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '1')
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Meter Number Electricity:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_meter_number_e_td">{{ $saleDetail->vie_meter_number_e ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Site Electricity Network Code:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_electricity_network_code_td">{{ $saleDetail->vie_electricity_network_code ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Electricity Code:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_electricity_code_td">{{ $saleDetail->vie_electricity_code ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '2' || isset($gasSaleDetail))
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Meter No. Gas:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_meter_number_g_td">{{ $saleDetail->vie_meter_number_g ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Site Gas Network Code:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_gas_network_code_td">{{ $saleDetail->vie_gas_network_code ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Gas Code:</div>
                                                </td>
                                                <td class="fw-bolder text-end vie_gas_code_td">{{ $saleDetail->vie_gas_code ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="nmi_number_edit" style="display: none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>NMI Number Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                   <!--begin::Form-->
                    <form id = 'nmi_number_form' name = 'nmi_number_form' class="form">
                        <!--begin::Card body-->
                            <input type="hidden" name="visitor_info_energy_id" class="visitor_info_energy_id" id="visitor_info_energy_id" value="{{ isset($saleDetail) ? $saleDetail->vie_id : '' }}">
                            <input type="hidden" name="lead_id" value="{{ isset($saleDetail) ? $saleDetail->l_lead_id : '' }}">

                            <div class="card-body border-top p-9">
                                <div class="row">
                                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '1')
                                        <div class="col-md-6">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">NMI Number</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="nmi_number" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 41049999999" value="{{isset($saleDetail) ? $saleDetail->vie_nmi_number :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="nmi_number_error"></span>

                                                <div class="nmi_checkbox mt-2">
                                                    <label class="form-check form-check-inline form-check-solid">
                                                        <input class="form-check-input" id="nmi_skip" type="checkbox" name="nmi_skip" {{isset($saleDetail) && $saleDetail->vie_nmi_skip == 1 ? 'checked':''}} />
                                                        <span class="form-check-label">Skip NMI</span>
                                                    </label>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '2' || isset($gasSaleDetail))
                                        <div class="col-md-6">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">DPI MIRN Number</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="dpi_mirn_number" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 51059999999" value="{{isset($saleDetail) ? $saleDetail->vie_dpi_mirn_number :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="dpi_mirn_number_error"></span>

                                                    <div class="mirn_checkbox mt-2">
                                                        <label class="form-check form-check-inline form-check-solid">
                                                            <input class="form-check-input" id="mirn_skip" type="checkbox" name="mirn_skip" {{isset($saleDetail) &&$saleDetail->vie_mirn_skip == 1 ? 'checked':''}} />
                                                            <span class="form-check-label">Skip MIRN</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '1')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">Meter Number Electricity</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="meter_number_e" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. AB123456" value="{{isset($saleDetail) ? $saleDetail->vie_meter_number_e :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="meter_number_e_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">Site Electricity Network Code</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="electricity_network_code" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. GENR" value="{{isset($saleDetail) ? $saleDetail->vie_electricity_network_code :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="electricity_network_code_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">Electricity Code</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="electricity_code" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 1.1A" value="{{isset($saleDetail) ? $saleDetail->vie_electricity_code :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="electricity_code_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-6">

                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '2' || isset($gasSaleDetail))
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">Meter Number Gas</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="meter_number_g" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 1111AA" value="{{ isset($saleDetail) ? $saleDetail->vie_meter_number_g :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="meter_number_g_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">Site Gas Network Code</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="gas_network_code" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. ABCR" value="{{ isset($saleDetail) ? $saleDetail->vie_gas_network_code :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="gas_network_code_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">Gas Code</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="gas_code" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 2.2B" value="{{ isset($saleDetail) ? $saleDetail->vie_gas_code :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="gas_code_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-6">

                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Site Tariff Type</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="tariff_type" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. Peak" value="{{isset($saleDetail) ? $saleDetail->vie_tariff_type :''}}" autocomplete="off" />
                                                <span class="text-danger errors" id="tariff_type_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Site Network Tariff List</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="tariff_list" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. URTOU" value="{{isset($saleDetail) ? $saleDetail->vie_tariff_list :''}}" autocomplete="off" />
                                                <span class="text-danger errors" id="tariff_list_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">{{ __ ('sale_detail.view.customer.customer_info.comment.label')}}</label>
                                            <div class="col-lg-6 fv-row">
                                                <textarea name="comment" id="comment" placeholder="{{ __ ('sale_detail.view.customer.customer_info.comment.placeHolder')}}" class="form-control form-control-lg form-control-solid comment"></textarea>
                                                <span class="text-danger errors" id="comment_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="javascript:void(0);" type="button" class="btn btn-light btn-active-light-primary me-2 close_sales_form_btn" data-initial="nmi_number_edit" data-for="nmi_number_show" data-form="nmi_number_form">{{ __ ('handset.formPage.basicDetails.cancelButton')}}</a>
                            <button type="button" class="btn btn-primary submit_btn" id="nmi_number_form_submit_btn" data-form="nmi_number_form">{{ __ ('handset.formPage.basicDetails.submitButton')}}</button>
                        </div>
                    </form>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>

    <div id="nmi_number_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>NMI Numbers</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive customer_info_table">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                            <thead class="fw-bold text-gray-600">
                                <tr>
                                    <th class="text-muted text-capitalize text-nowrap">S No.</th>
                                    <th class="text-muted text-capitalize text-nowrap">User Name</th>
                                    <th class="text-muted text-capitalize text-nowrap">User role</th>
                                    <th class="text-muted text-capitalize text-nowrap">Comment</th>
                                    <th class="text-muted text-capitalize text-nowrap">Updated at</th>
                                    <th class="text-muted text-capitalize text-nowrap text-center">Show Update History
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="fw-bolder text-gray-600" id="nmi_number_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="nmi_number_history"
                        data-for="nmi_number_show">{{ __('buttons.close') }}</a>
                </div>

                <!--end::Documents-->
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="show_nmi_number_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">NMI Numbers Update History</h2>
                <div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '1')
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">NMI Number:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_nmi_number_history_td">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Skip NMI Number:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_nmi_skip_history_td">
                                            </td>
                                        </tr>
                                    @endif
                                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '2' || isset($gasSaleDetail))
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">DPI-MIRN Number:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_dpi_mirn_number_history_td">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Skip MIRN Number:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_mirn_skip_history_td">
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Site Tariff Type:</div>
                                        </td>
                                        <td class="fw-bolder text-end vie_tariff_type_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Site Network Tariff List:</div>
                                        </td>
                                        <td class="fw-bolder text-end vie_tariff_list_history_td">
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>

                    <!-- right side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '1')
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Meter Number Electricity:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_meter_number_e_history_td">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Site Electricity Network Code:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_electricity_network_code_history_td">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Electricity Code:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_electricity_code_history_td">
                                            </td>
                                        </tr>
                                    @endif
                                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type== '2' || isset($gasSaleDetail))
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Meter No. Gas:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_meter_number_g_history_td">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Site Gas Network Code:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_gas_network_code_history_td">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Gas Code:</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_gas_code_history_td">
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
