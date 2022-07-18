<div class="tab-pane fade show mb-5" role="tab-panel">
    <!--begin::Order details-->
    @if ($verticalId == '1')
        <div id="demand_details_show">
            <div id="demand_details_disable_section"
                {{ isset($saleDetail->ebd_demand_tariff) && $saleDetail->ebd_demand_tariff == 1 ? 'style=display:none' : '' }}>
                <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Demand Details Info</h2>
                            </div>
                            <div class="my-auto me-4 py-3">
                                <a href="javascript:void(0);" class="fw-bolder me-6 text-primary show_history"
                        data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                        data-vertical_id="{{ $verticalId ?? '' }}" data-section='demand_details'
                        data-for="demand_details_history" data-initial="demand_details_show">Show
                        History</a>

                                <a href="javascript:void(0);" class="fw-bolder text-primary float-end edit_sales_btn"
                                    data-for="demand_details_edit" data-initial="demand_details_show">
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-pencil-square text-primary" aria-hidden="true"></i></span>Edit
                                </a>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td valign="top" colspan="6" class="text-center">No demands added by
                                                customer yet.</td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->

                    </div>
                </div>
            </div>
            <div id="demand_details_enable_section"
                {{ isset($saleDetail->ebd_demand_tariff) && $saleDetail->ebd_demand_tariff == 1 ? '' : 'style=display:none' }}>
                <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
                    <div class="card col-md-12 card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Demand Details Info</h2>
                            </div>
                            <div class="my-auto me-4 py-3">
                                <a href="javascript:void(0);" class="fw-bolder me-6 text-primary show_history"
                                    data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                                    data-vertical_id="{{ $verticalId ?? '' }}" data-section='demand_details'
                                    data-for="demand_details_history" data-initial="demand_details_show">Show
                                    History</a>

                                <a href="javascript:void(0);" class="fw-bolder text-primary float-end edit_sales_btn"
                                    data-for="demand_details_edit" data-initial="demand_details_show">
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-pencil-square text-primary" aria-hidden="true"></i></span>Edit
                                </a>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Usage Type</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_usage_type_td">
                                                {{ isset($saleDetail) && $saleDetail->ebd_demand_usage_type == 2 ? 'kWh' : 'KVA' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Tariff Code</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_tariff_code_td">
                                                @if (isset($masterTariffs))
                                                    @foreach ($masterTariffs as $id => $name)
                                                        @if (isset($saleDetail) && $saleDetail->ebd_demand_tariff_code == $id)
                                                            {{ $name }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Meter Type</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_meter_type_td">
                                                {{ isset($saleDetail) && $saleDetail->ebd_demand_meter_type == 1 ? 'Single' : 'Time Of Use' }}
                                            </td>
                                        </tr>


                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->

                    </div>

                </div>
                <div class="d-flex flex-column flex-xl-row gap-7 py-5 gap-lg-10">
                    <!--begin::Order details-->
                    <div class="card col-md-6 card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Demand Rate 1</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 1 Peak</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate1_peak_usage_td">
                                                {{ $saleDetail->ebd_demand_rate1_peak_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 1 OffPeak</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate1_off_peak_usage_td">
                                                {{ $saleDetail->ebd_demand_rate1_off_peak_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 1 Shoulder</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate1_shoulder_usage_td">
                                                {{ $saleDetail->ebd_demand_rate1_shoulder_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 1 Days</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate1_days_td">
                                                {{ $saleDetail->ebd_demand_rate1_days ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <div class="card col-md-6 card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Demand Rate 2</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 2 Peak</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate2_peak_usage_td">
                                                {{ $saleDetail->ebd_demand_rate2_peak_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 2 OffPeak</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate2_off_peak_usage_td">
                                                {{ $saleDetail->ebd_demand_rate2_off_peak_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 2 Shoulder</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate2_shoulder_usage_td">
                                                {{ $saleDetail->ebd_demand_rate2_shoulder_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 2 Days</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate2_days_td">
                                                {{ $saleDetail->ebd_demand_rate2_days ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                 <div class="d-flex flex-column flex-xl-row gap-7 py-5 gap-lg-10">
                    <!--begin::Order details-->
                    <div class="card col-md-6 card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Demand Rate 3</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 3 Peak</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate3_peak_usage_td">
                                                {{ $saleDetail->ebd_demand_rate3_peak_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 3 OffPeak</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate3_off_peak_usage_td">
                                                {{ $saleDetail->ebd_demand_rate3_off_peak_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 3 Shoulder</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate3_shoulder_usage_td">
                                                {{ $saleDetail->ebd_demand_rate3_shoulder_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 3 Days</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate3_days_td">
                                                {{ $saleDetail->ebd_demand_rate3_days ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <div class="card col-md-6 card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Demand Rate 4</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 4 Peak</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate4_peak_usage_td">
                                                {{ $saleDetail->ebd_demand_rate4_peak_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 4 OffPeak</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate4_off_peak_usage_td">
                                                {{ $saleDetail->ebd_demand_rate4_off_peak_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 4 Shoulder</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate4_shoulder_usage_td">
                                                {{ $saleDetail->ebd_demand_rate4_shoulder_usage ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Demand Rate 4 Days</div>
                                            </td>
                                            <td class="fw-bolder text-end ebd_demand_rate4_days_td">
                                                {{ $saleDetail->ebd_demand_rate4_days ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
            </div>
        </div>
        <div id="demand_details_edit" style="display: none;">
            <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
                <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Demand Detail Edit</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <!--begin::Form-->
                        <form id='demand_details_form' name='demand_details_form' class="form">
                            <!--begin::Card body-->
                            <input type="hidden" name="lead_id" id="lead_id"
                                value="{{ isset($saleDetail) ? $saleDetail->l_lead_id : '' }}">
                            <input type="hidden" name="energy_bill_details_id" id="energy_bill_details_id"
                                value="{{ isset($saleDetail) ? $saleDetail->ebd_id : '' }}">

                            <div class="card-body border-top p-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.demand_details.demand_tariff.label') }}</label>
                                            <div class="col-lg-6 fv-row py-3">
                                                <label class="form-check form-check-inline form-check-solid">
                                                    <input class="form-check-input" type="radio" name="demand_tariff"
                                                        {{ isset($saleDetail) && $saleDetail->ebd_demand_tariff == 1 ? 'checked' : '' }}
                                                        value="1" />
                                                    <span class="form-check-label">Enable</span>
                                                </label>
                                                <!--end::Option-->
                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid">
                                                    <input class="form-check-input" type="radio" name="demand_tariff"
                                                        {{ isset($saleDetail) && $saleDetail->ebd_demand_tariff == 0 ? 'checked' : '' }}
                                                        value="0" />
                                                    <span class="form-check-label">Disable</span>
                                                </label>
                                                <span class="text-danger errors" id="demand_tariff_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.demand_details.demand_usage_type.label') }}</label>
                                            <div class="col-lg-6 fv-row  py-3">
                                                <label class="form-check form-check-inline form-check-solid">
                                                    <input class="form-check-input" type="radio"
                                                        name="demand_usage_type"
                                                        {{ isset($saleDetail) && $saleDetail->ebd_demand_usage_type == 2 ? 'checked' : '' }}
                                                        value="2" />
                                                    <span class="form-check-label">kWh</span>
                                                </label>
                                                <!--end::Option-->
                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid">
                                                    <input class="form-check-input" type="radio"
                                                        name="demand_usage_type"
                                                        {{ isset($saleDetail) && $saleDetail->ebd_demand_usage_type == 1 ? 'checked' : '' }}
                                                        value="1" />
                                                    <span class="form-check-label">KVA</span>
                                                </label>
                                                <span class="text-danger errors" id="demand_usage_type_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.demand_details.demand_tariff_code.label') }}</label>
                                            <div class="col-lg-6 fv-row">
                                                <select class="form-select form-select-solid" name="demand_tariff_code"
                                                    data-control="select2" data-hide-search="false"
                                                    aria-label="{{ __('sale_detail.view.demand_details.demand_tariff_code.placeHolder') }}"
                                                    data-placeholder="{{ __('sale_detail.view.demand_details.demand_tariff_code.placeHolder') }}"
                                                    aria-hidden="true" tabindex="-1">
                                                    <option value=""></option>
                                                    @foreach ($masterTariffs as $id => $name)
                                                        <option value="{{ $id }}"
                                                            {{ isset($saleDetail) && $saleDetail->ebd_demand_tariff_code == $id ? 'selected' : '' }}>
                                                            {{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger errors" id="demand_tariff_code_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.demand_details.demand_meter_type.label') }}</label>
                                            <div class="col-lg-6 fv-row py-3">
                                                <label class="form-check form-check-inline form-check-solid">
                                                    <input class="form-check-input" type="radio"
                                                        name="demand_meter_type"
                                                        {{ isset($saleDetail) && $saleDetail->ebd_demand_meter_type == 1 ? 'checked' : '' }}
                                                        value="1" />
                                                    <span class="form-check-label">Single</span>
                                                </label>
                                                <!--end::Option-->
                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid">
                                                    <input class="form-check-input" type="radio"
                                                        name="demand_meter_type"
                                                        {{ isset($saleDetail) && $saleDetail->ebd_demand_meter_type == 2 ? 'checked' : '' }}
                                                        value="2" />
                                                    <span class="form-check-label">Time Of Use</span>
                                                </label>
                                                <span class="text-danger errors" id="demand_meter_type_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <h2 style="text-decoration: underline;"><strong>Demand Rate 1</strong>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <h2 style="text-decoration: underline;"><strong>Demand Rate 3</strong>
                                            </h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 1
                                                Peak</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate1_peak_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_peak_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate1_peak_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate1_peak_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 3
                                                Peak</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate3_peak_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_peak_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate3_peak_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate3_peak_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 1
                                                Offpeak</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate1_off_peak_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_off_peak_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate1_off_peak_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate1_off_peak_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 3
                                                Offpeak</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate3_off_peak_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_off_peak_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate3_off_peak_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate3_off_peak_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 1
                                                Shoulder</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate1_shoulder_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_shoulder_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate1_shoulder_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate1_shoulder_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 3
                                                Shoulder</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate3_shoulder_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_shoulder_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate3_shoulder_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate3_shoulder_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 1
                                                Days</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate1_days"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_days.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate1_days : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors" id="demand_rate1_days_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 3
                                                Days</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate3_days"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_days.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate3_days : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors" id="demand_rate3_days_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row py-3">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <h2 style="text-decoration: underline;"><strong>Demand Rate 2</strong>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <h2 style="text-decoration: underline;"><strong>Demand Rate 4</strong>
                                            </h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 2
                                                Peak</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate2_peak_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_peak_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate2_peak_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate2_peak_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 4
                                                Peak</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate4_peak_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_peak_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate4_peak_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate4_peak_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 2
                                                Offpeak</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate2_off_peak_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_off_peak_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate2_off_peak_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate2_off_peak_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 4
                                                Offpeak</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate4_off_peak_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_off_peak_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate4_off_peak_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate4_off_peak_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 2
                                                Shoulder</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate2_shoulder_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_shoulder_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate2_shoulder_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate2_shoulder_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 4
                                                Shoulder</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate4_shoulder_usage"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_shoulder_usage.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate4_shoulder_usage : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors"
                                                    id="demand_rate4_shoulder_usage_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 2
                                                Days</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate2_days"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_days.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate2_days : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors" id="demand_rate2_days_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Demand Rate 4
                                                Days</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="demand_rate4_days"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{ __('sale_detail.view.demand_details.demand_rate1_days.placeHolder') }}"
                                                    value="{{ isset($saleDetail) ? $saleDetail->ebd_demand_rate4_days : '' }}"
                                                    autocomplete="off" />
                                                <span class="text-danger errors" id="demand_rate4_days_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.comment.label') }}</label>
                                            <div class="col-lg-6 fv-row">
                                                <textarea name="comment" id="comment"
                                                    placeholder="{{ __('sale_detail.view.customer.customer_info.comment.placeHolder') }}"
                                                    class="form-control form-control-lg form-control-solid comment"></textarea>
                                                <span class="text-danger errors" id="comment_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="javascript:void(0);" type="button"
                                    class="btn btn-light btn-active-light-primary me-2 close_sales_form_btn"
                                    data-initial="demand_details_edit" data-for="demand_details_show"
                                    data-form="demand_details_form">{{ __('handset.formPage.basicDetails.cancelButton') }}</a>
                                <button type="button" class="btn btn-primary submit_btn"
                                    id="demand_details_form_submit_btn"
                                    data-form="demand_details_form">{{ __('handset.formPage.basicDetails.submitButton') }}</button>
                            </div>
                        </form>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
        <div id="demand_details_history" style="display:none;">
            <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Demand Details</h2>
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
                                <tbody class="fw-bolder text-gray-600" id="demand_details_body">
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                            data-initial="demand_details_history"
                            data-for="demand_details_show">{{ __('buttons.close') }}</a>
                    </div>

                    <!--end::Documents-->
                </div>
            </div>

        </div>
    @endif
</div>

<div class="modal fade" id="show_demand_details_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Demand Details Update History</h2>
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
                <div class="row" id="demand_details_disable_history">

                </div>
                <div class="row" id="demand_details_enable_history">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Usage Type</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_usage_type_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Tariff Code</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_tariff_code_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Meter Type</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_meter_type_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 1 Peak</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate1_peak_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 1 OffPeak</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate1_off_peak_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 1 Shoulder</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate1_shoulder_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 1 Days</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate1_days_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 2 Peak</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate2_peak_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 2 OffPeak</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate2_off_peak_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 2 Shoulder</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate2_shoulder_usage_history_td">
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
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 2 Days</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate2_days_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 3 Peak</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate3_peak_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 3 OffPeak</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate3_off_peak_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 3 Shoulder</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate3_shoulder_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 3 Days</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate3_days_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 4 Peak</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate4_peak_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 4 OffPeak</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate4_off_peak_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 4 Shoulder</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate4_shoulder_usage_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Demand Rate 4 Days</div>
                                        </td>
                                        <td class="fw-bolder text-end ebd_demand_rate4_days_history_td">
                                        </td>
                                    </tr>
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
