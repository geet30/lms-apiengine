<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="pobox_address_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>PO Box Address</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history" id="pobox
                        _address_history"
                            data-address_id="{{ $saleDetail->l_visitor_id ?? '' }}" data-vertical_id={{ $verticalId }} data-section='pobox_address'
                            data-for="pobox_address_history" data-initial="pobox_address_show">Show
                            History</a>

                        <a href="" class="fw-bolder text-primary update_section float-end"
                            data-lead_id={{ $saleDetail->l_lead_id }} data-service_id={{ $verticalId }}
                            data-for="pobox_address_edit" data-initial="pobox_address_show"><i
                                class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                <div class="card-body pt-0" id="po-box-body">
                    <div class="row" id="po_box_row" {{ isset($poBoxAddress) ? '' : 'style=display:none' }}>
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600" id="left_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">PO Box Address Status
                                                </div>
                                            </td>
                                            <td class="fw-bolder po-address-status">
                                                {{ isset($saleDetail->l_billing_po_box_id) ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">PO Box Number</div>
                                            </td>
                                            <td class="fw-bolder po-address-number">
                                                {{ isset($poBoxAddress->po_box) && $poBoxAddress->po_box != '' ? $poBoxAddress->po_box : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">PO Box Suburb</div>
                                            </td>
                                            <td class="fw-bolder po-address-suburb">
                                                {{ isset($poBoxAddress->suburb) && $poBoxAddress->suburb != '' ? $poBoxAddress->suburb : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">PO Box State Code</div>
                                            </td>
                                            <td class="fw-bolder po-address-state-code">
                                                @if (isset($poBoxAddress->state) && $poBoxAddress->state != '')
                                                    @foreach ($states as $state)
                                                        @if ($state->state_id == $poBoxAddress->state)
                                                            {{ $state->state_code }}
                                                        @endif
                                                    @endforeach
                                                    @else
                                                    N/A
                                                @endif
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
                                    <tbody class="fw-bold text-gray-600" id="right_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">PO Box Post Code</div>
                                            </td>
                                            <td class="fw-bolder po-address-postcode">
                                                {{ isset($poBoxAddress->postcode) && $poBoxAddress->postcode != '' ? $poBoxAddress->postcode : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Is QAS Valid</div>
                                            </td>
                                            <td class="fw-bolder po-address-qas">
                                                {{ isset($poBoxAddress->is_qas_valid) && $poBoxAddress->is_qas_valid == 1 ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Ignore address validation (
                                                    Only
                                                    for
                                                    AGL
                                                    )</div>
                                            </td>
                                            <td class="fw-bolder po-address-validate-address">
                                                {{ isset($poBoxAddress->validate_address) && $poBoxAddress->validate_address == 1 ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">DPID</div>
                                            </td>
                                            <td class="fw-bolder po-address-dpid">
                                                {{ isset($poBoxAddress->dpid) && $poBoxAddress->dpid != '' ? $poBoxAddress->dpid : 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>

                        </div>

                    </div>
                    <div class="row" id="pobox_row" {{ isset($poBoxAddress) ? 'style=display:none' : '' }}>
                        <div class="col-md-4 m-auto fw-bolder text-gray-600"> No PO Box Address Available
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pobox_address_edit" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>PO Box Address Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form role="form" name="pobox_form" id="pobox_form">
                        @csrf
                        <input type="hidden" name="poBoxAddressId" value="{{ $poBoxAddress->id ?? '' }}">
                        <input type="hidden" name="leadId" value={{ $saleDetail->l_lead_id }}>
                        <input type="hidden" name="visitorId" value={{ $saleDetail->l_visitor_id }}>
                        <input type="hidden" name="addressType"
                            value={{ isset($saleDetail->journey_property_type) && $saleDetail->journey_property_type == 0 ? 1 : 2 }}>
                        <div class="row mb-10 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-md-5 fw-bolder">Enable PO Box Address :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7 fv-row">
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input sweetalert_demo" type="checkbox"
                                                name="enable_pobox"
                                                {{ isset($saleDetail->l_billing_po_box_id) ? 'checked' : '' }}>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-lg-5 required fw-bolder">PO Box Address Status :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7 fw-bolder po_box_status">
                                        {{ isset($saleDetail->l_billing_po_box_id) ? 'Enable' : 'Disable' }}
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-lg-5 required fw-bolder">PO Box Number :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7">
                                        <input id="address" class="form-control" name="address" type="text"
                                            value="{{ $poBoxAddress->po_box ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-lg-5 required fw-bolder">PO Box Suburb :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7">
                                        <input id="suburb" class="form-control" name="suburb" type="text"
                                            value="{{ $poBoxAddress->suburb ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-lg-5 required fw-bolder">PO Box State Code :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7">
                                        <select data-control="select2" class="form-select-solid form-select"
                                            name="state" id="state">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->state_id }}"
                                                    {{ isset($poBoxAddress->state) && $poBoxAddress->state == $state->state_id ? 'selected' : '' }}>
                                                    {{ $state->state_code }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-lg-5 required fw-bolder">Post Code :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7">
                                        <input id="postcode" class="form-control" name="postcode" type="text"
                                            value="{{ $poBoxAddress->postcode ?? '' }}">
                                        <span id="emailSpan" class="error text-danger"></span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-lg-5 required fw-bolder">DPID :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7">
                                        <input id="po_box_dpid" class="form-control" name="po_box_dpid" type="text"
                                            value="{{ $poBoxAddress->dpid ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-md-5 fw-bolder">Is QAS Valid ( Only for Origin ) :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7 fv-row">
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input sweetalert_demos" type="checkbox"
                                                name="is_qas_valid" id="is_qas_valid"
                                                {{ isset($poBoxAddress->is_qas_valid) && $poBoxAddress->is_qas_valid == 1 ? 'checked' : '' }}>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-md-5 fw-bolder">Ignore address validation ( Only for AGL )
                                        :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-7 fv-row">
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input sweetalert_demo" type="checkbox"
                                                name="validate_address" id="validate_address"
                                                {{ isset($poBoxAddress->validate_address) && $poBoxAddress->validate_address == 1 ? 'checked' : '' }}>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6 text-gray-600">
                            <label class="col-lg-2 fw-bolder">Comment :</label>
                            <div class="col-lg-10 fv-row">
                                <textarea class="form-control" rows="2" name="comment"
                                    placeholder="{{ __('sale_detail.view.customer.customer_info.comment.placeHolder') }}"></textarea>
                                <span class="help-block fw-bolder">Give your comment for this updation. </span>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2 close_section"
                                data-initial="pobox_address_edit"
                                data-for="pobox_address_show">{{ __('buttons.cancel') }}</a>
                            <button type="submit" class="update_address_button"
                                class="btn btn-primary">{{ __('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="pobox_address_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>PO Box Connection Address</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
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
                            <tbody class="fw-bolder text-gray-600" id="pobox_address_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="pobox_address_history"
                        data-for="pobox_address_show">{{ __('buttons.close') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_pobox_address_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">PO Box Address Update History</h2>
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
                <div class="row" id="po_box_row_history">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">PO Box Address Status
                                            </div>
                                        </td>
                                        <td class="fw-bolder po-address-status-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">PO Box Number</div>
                                        </td>
                                        <td class="fw-bolder po-address-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">PO Box Suburb</div>
                                        </td>
                                        <td class="fw-bolder po-address-suburb-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">PO Box State Code</div>
                                        </td>
                                        <td class="fw-bolder po-address-state-code-history">
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
                                            <div class="d-flex align-items-center">PO Box Post Code</div>
                                        </td>
                                        <td class="fw-bolder po-address-postcode-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Is QAS Valid</div>
                                        </td>
                                        <td class="fw-bolder po-address-qas-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Ignore address validation (
                                                Only
                                                for
                                                AGL
                                                )</div>
                                        </td>
                                        <td class="fw-bolder po-address-validate-address-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">DPID</div>
                                        </td>
                                        <td class="fw-bolder po-address-dpid-history">
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>

                    </div>

                </div>
                <div class="row" id="pobox_row_history" {{ isset($poBoxAddress) ? 'style=display:none' : '' }}>
                    <div class="col-md-4 m-auto fw-bolder text-gray-600">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

