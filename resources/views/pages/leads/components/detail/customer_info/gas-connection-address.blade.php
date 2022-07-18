<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="gas_address_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Gas Connection Address</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history" id="gas_connection
                        _address_history"
                            data-address_id="{{ $gasConnectionAddress->id ?? '' }}" data-vertical_id={{ $verticalId }} data-section='gas_address'
                            data-for="gas_address_history" data-initial="gas_address_show">Show
                            History</a>
                        <a href="javascript:void(0);" class="fw-bolder text-primary update_section float-end"
                            data-lead_id={{ $saleDetail->l_lead_id }} data-service_id={{ $verticalId }}
                            data-for="gas_address_edit" data-initial="gas_address_show"><i
                                class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Is Gas Connection Different?
                                                </div>
                                            </td>
                                            <td class="fw-bolder text-end gas_connection_td">
                                                {{ isset($gasConnectionAddress->is_same_gas_connection) && $gasConnectionAddress->is_same_gas_connection == 1 ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if (isset($gasConnectionAddress->street_code))
                                                    @foreach ($streetTypeCodes as $streetTypeCode)
                                                        @if ($streetTypeCode->id == $gasConnectionAddress->street_code)
                                                            @php
                                                                $street_code = $streetTypeCode->value
                                                            @endphp
                                                        @endif
                                                    @endforeach
                    @endif
                    @if (isset($gasConnectionAddress->state))
                                                @foreach ($states as $state)
                                                    @if ($state->state_id == $gasConnectionAddress->state)
                                                    @php
                                                                $state_code = $state->state_code
                                                            @endphp
                                                    @endif
                                                @endforeach
                                                @endif
                                                @php
                    $gasConnectionAddressName = (isset($gasConnectionAddress->unit_number) ? 'Unit ' . $gasConnectionAddress->unit_number : '').' '.
                                             (isset($gasConnectionAddress->street_number) ? $gasConnectionAddress->street_number : '').' '.
                                             (isset($gasConnectionAddress->street_name) ? $gasConnectionAddress->street_name : '').' '.
                                             (isset($street_code) ? $street_code :'').','.(isset($gasConnectionAddress->suburb) ? $gasConnectionAddress->suburb : '').' '.
                                             (isset($state_code) ? $state_code : '');
             @endphp
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600" id="left_gas_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Address </div>
                                            </td>
                                            <td class="fw-bolder text-end gas_connection-address-td">
                                                @if(isset($gasConnectionAddress->address) && strlen($gasConnectionAddress->address) > 1)
                                                {{ $gasConnectionAddress->address }}
                                                @elseif(strlen(trim($gasConnectionAddressName)) > 1)
                                                {{ $gasConnectionAddressName }}
                                                @else
                                                N/A
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Lot Number </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-lot-number">
                                                {{ isset($gasConnectionAddress->lot_number) && $gasConnectionAddress->lot_number != '' ? $gasConnectionAddress->lot_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Number </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-unit-number">
                                                {{ isset($gasConnectionAddress->unit_number) && $gasConnectionAddress->unit_number != '' ? $gasConnectionAddress->unit_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Type </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-unit-type">
                                                @if (isset($gasConnectionAddress->unit_type) && $gasConnectionAddress->unit_type != '')
                                                    @foreach ($unitTypes as $unitType)
                                                        @if ($unitType->id == $gasConnectionAddress->unit_type)
                                                            {{ $unitType->name }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Type Code </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-unit-type-code">
                                                {{ isset($gasConnectionAddress->unit_type_code) && $gasConnectionAddress->unit_type_code != '' ? $gasConnectionAddress->unit_type_code : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Number </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-floor-number">
                                                {{ isset($gasConnectionAddress->floor_number) && $gasConnectionAddress->floor_number != '' ? $gasConnectionAddress->floor_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Level Type </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-floor-level-type">
                                                {{ isset($gasConnectionAddress->floor_level_type) && $gasConnectionAddress->floor_level_type != '' ? $gasConnectionAddress->floor_level_type : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Type Code </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-floor-type-code">
                                                {{ isset($gasConnectionAddress->floor_type_code) && $gasConnectionAddress->floor_type_code != '' ? $gasConnectionAddress->floor_type_code : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Name </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-street-name">
                                                {{ isset($gasConnectionAddress->street_name) && $gasConnectionAddress->street_name != '' ? $gasConnectionAddress->street_name : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Number </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-street-number">
                                                {{ isset($gasConnectionAddress->street_number) && $gasConnectionAddress->street_number != '' ? $gasConnectionAddress->street_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Suffix </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-street-suffix">
                                                {{ isset($gasConnectionAddress->street_suffix) && $gasConnectionAddress->street_suffix != '' ? $gasConnectionAddress->street_suffix : 'N/A' }}
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
                                    <tbody class="fw-bold text-gray-600" id="right_connection_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Code </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-street-code">

                                                @if (isset($gasConnectionAddress->street_code) && $gasConnectionAddress->street_code != '')
                                                    @foreach ($streetTypeCodes as $streetTypeCode)
                                                        @if ($streetTypeCode->id == $gasConnectionAddress->street_code)
                                                            {{ $streetTypeCode->value }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">House Number </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-house-number">
                                                {{ isset($gasConnectionAddress->house_number) && $gasConnectionAddress->house_number != '' ? $gasConnectionAddress->house_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">House Number Suffix </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-house-number-suffix">
                                                {{ isset($gasConnectionAddress->house_number_suffix) && $gasConnectionAddress->house_number_suffix != '' ? $gasConnectionAddress->house_number_suffix : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Suburb </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-suburb">
                                                {{ isset($gasConnectionAddress->suburb) && $gasConnectionAddress->suburb != '' ? $gasConnectionAddress->suburb : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Property Name </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-property-name">
                                                {{ isset($gasConnectionAddress->property_name) && $gasConnectionAddress->property_name != '' ? $gasConnectionAddress->property_name : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">State </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-state">
                                                @if (isset($gasConnectionAddress->state) && $gasConnectionAddress->state != '')
                                                    @foreach ($states as $state)
                                                        @if ($state->state_id == $gasConnectionAddress->state)
                                                            {{ $state->state_code }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Post Code </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-postcode">
                                                {{ isset($gasConnectionAddress->postcode) && $gasConnectionAddress->postcode != '' ? $gasConnectionAddress->postcode : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Site Location Descriptor </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-site-location">
                                                {{ isset($gasConnectionAddress->site_descriptor) && $gasConnectionAddress->site_descriptor != '' ? $gasConnectionAddress->site_descriptor : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Property Ownership </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-property-ownership">
                                                {{ isset($gasConnectionAddress->property_ownership) && $gasConnectionAddress->property_ownership != '' ? $gasConnectionAddress->property_ownership : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">DPID </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-dpid">
                                                {{ isset($gasConnectionAddress->dpid) && $gasConnectionAddress->dpid != '' ? $gasConnectionAddress->dpid : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Ignore address validation ( Only
                                                    for
                                                    AGL
                                                    )
                                                </div>
                                            </td>
                                            <td class="fw-bolder text-end gas-connection-address-validation">
                                                {{ isset($gasConnectionAddress->validate_address) && $gasConnectionAddress->validate_address == 1 ? 'Yes' : 'No' }}
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
    <div id="gas_address_edit" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Gas Connection Address Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form role="form" name="gas_connection_form" id="gas_connection_form">
                        @csrf
                        <input type="hidden" name="gasConnectionAddressId"
                            value="{{ $gasConnectionAddress->id ?? '' }}">
                        <input type="hidden" name="leadId" value={{ $saleDetail->l_lead_id }}>
                        <input type="hidden" name="visitorId" value={{ $saleDetail->l_visitor_id }}>
                        <input type="hidden" name="addressType"
                            value={{ isset($saleDetail->journey_property_type) && $saleDetail->journey_property_type == 0 ? 1 : 2 }}>
                        <div class="row mb-6 text-gray-600">
                            <div class="col-md-12 mb-6 text-gray-600">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-md-4 fw-bolder">Is Gas Connection Different?</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-md-8">
                                        <label class="form-check form-check-inline form-check-solid mb-5">
                                            <input class="form-check-input" name="gas_connection" type="radio" value="1"
                                                {{ isset($gasConnectionAddress->is_same_gas_connection) && $gasConnectionAddress->is_same_gas_connection == 1 ? 'checked' : '' }} />
                                            <span class="fw-bolder ps-2 fs-6">
                                                Yes
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid  mb-5">
                                            <input class="form-check-input" name="gas_connection" type="radio" value="0"
                                                {{ isset($gasConnectionAddress->is_same_gas_connection) && $gasConnectionAddress->is_same_gas_connection == 0 ? 'checked' : '' }} />
                                            <span class="fw-bolder ps-2 fs-6">
                                                No
                                            </span>
                                        </label>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Address:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input type="text" class="form-control" id="address"
                                            placeholder="Search Connection Address" name="gas_connection_address"
                                            autocomplete="off" value="{{ $gasConnectionAddress->address ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">House Number:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="house_num" class="form-control" name="house_num" type="text"
                                            value="{{ $gasConnectionAddress->house_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Lot Number:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="lot_number" class="form-control" name="lot_number" type="text"
                                            value="{{ $gasConnectionAddress->lot_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">House Number Suffix:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="house_number_suffix" class="form-control" name="house_number_suffix"
                                            type="text"
                                            value="{{ $gasConnectionAddress->house_number_suffix ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Unit Number:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="unit_no" class="form-control" name="unit_no" type="text"
                                            value="{{ $gasConnectionAddress->unit_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder required">Suburb:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="suburb" class="form-control" name="suburb" type="text"
                                            value="{{ $gasConnectionAddress->suburb ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Unit Type:</label>
                                    <div class="col-lg-9 fv-row">
                                        <select data-control="select2" class="form-select-solid form-select"
                                            name="unit_type" id="gas_unit_type">
                                            <option value="">Select Unit Type</option>
                                            @foreach ($unitTypes as $unitType)
                                                <option value="{{ $unitType->id }}"
                                                    {{ isset($gasConnectionAddress->unit_type) && $gasConnectionAddress->unit_type == $unitType->id ? 'selected' : '' }}>
                                                    {{ $unitType->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder required">State:</label>
                                    <div class="col-lg-9 fv-row">
                                        <select data-control="select2" class="form-select-solid form-select"
                                            name="state" id="state">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->state_id }}"
                                                    {{ isset($gasConnectionAddress->state) && $gasConnectionAddress->state == $state->state_id ? 'selected' : '' }}>
                                                    {{ $state->state_code }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Unit Type Code:</label>
                                    <div class="col-lg-9 fv-row">
                                        <select data-control="select2" class="form-select-solid form-select"
                                            name="unit_type_code" id="gas_unit_type_code">
                                            <option value="">Select Unit type code</option>
                                            @foreach ($unitTypeCodes as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ isset($gasConnectionAddress->unit_type_code) && $gasConnectionAddress->unit_type_code == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Property Name:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="property_name" class="form-control" name="property_name" type="text"
                                            value="{{ $gasConnectionAddress->property_name ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Floor Number:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="floor_no" class="form-control" name="floor_no" type="text"
                                            value="{{ $gasConnectionAddress->floor_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder required">Post Code:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="postcode" class="form-control" name="postcode" type="text"
                                            value="{{ $gasConnectionAddress->postcode ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Floor Level type:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="floor_level_type" class="form-control" name="floor_level_type"
                                            type="text" value="{{ $gasConnectionAddress->floor_level_type ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Street Code:</label>
                                    <div class="col-lg-9 fv-row">
                                        <select data-control="select2" class="form-select-solid form-select"
                                            id="street_code" name="street_code">
                                            <option value="">Select Street Type (optional)</option>
                                            @foreach ($streetTypeCodes as $streetTypeCode)
                                                <option value="{{ $streetTypeCode->id }}"
                                                    {{ isset($gasConnectionAddress->street_code) && $gasConnectionAddress->street_code == $streetTypeCode->id ? 'selected' : '' }}>
                                                    {{ $streetTypeCode->value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Floor Type Code:</label>
                                    <div class="col-lg-9 fv-row">
                                        <select data-control="select2" class="form-select-solid form-select"
                                            name="floor_type_code" id="floor_type_code">
                                            <option value="" selected="selected">Select floor type code</option>
                                            @foreach ($floorTypeCodes as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ isset($gasConnectionAddress->floor_type_code) && $gasConnectionAddress->floor_type_code == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Site Location Descriptor:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="site_descriptor" class="form-control" name="site_descriptor"
                                            type="text" value="{{ $gasConnectionAddress->site_descriptor ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder required">Street Name:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="street_name" class="form-control" name="street_name" type="text"
                                            value="{{ $gasConnectionAddress->street_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Property Ownership:</label>
                                    <div class="col-lg-9 fv-row">
                                        <select data-control="select2" class="form-select-solid form-select"
                                            name="property_ownership" id="property_ownership">
                                            <option value="" selected="selected">Select</option>
                                            <option value="Own"
                                                {{ isset($gasConnectionAddress->property_ownership) && $gasConnectionAddress->property_ownership == 'Own' ? 'selected' : '' }}>
                                                Own</option>
                                            <option value="Rent"
                                                {{ isset($gasConnectionAddress->property_ownership) && $gasConnectionAddress->property_ownership == 'Rent' ? 'selected' : '' }}>
                                                Rent</option>
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder required">Street Number:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="street_number" class="form-control" name="street_number" type="text"
                                            value="{{ $gasConnectionAddress->street_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Street Number Suffix:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="street_number_suffix" class="form-control"
                                            name="street_number_suffix" type="text"
                                            value="{{ $gasConnectionAddress->street_number_suffix ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Street Suffix:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="street_suffix" class="form-control" name="street_suffix" type="text"
                                            value="{{ $gasConnectionAddress->street_suffix ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">DPID:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="dpid" class="form-control" name="dpid" type="text"
                                            value="{{ $gasConnectionAddress->dpid ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <!--begin::Label-->
                            <label class="col-md-4 fw-bolder">Ignore address validation ( Only for AGL ) :</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input class="form-check-input sweetalert_demo" type="checkbox"
                                        name="validate_address" id="validate_address"
                                        {{ isset($gasConnectionAddress->validate_address) && $gasConnectionAddress->validate_address == 1 ? 'checked' : '' }}>
                                </div>
                                <!--end::Input-->
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
                                data-initial="gas_address_edit"
                                data-for="gas_address_show">{{ __('buttons.cancel') }}</a>
                            <button type="submit" class="update_address_button"
                                class="btn btn-primary">{{ __('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="gas_address_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Gas Connection Address</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="gas_address_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="gas_address_history"
                        data-for="gas_address_show">{{ __('buttons.close') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_gas_connection_address_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Gas Connection Address Update History</h2>
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
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Is Gas Connection Different?
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection_history_td">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600" id="left_gas_address_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Address </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-address-history-td">
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Lot Number </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-lot-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Number </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-unit-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Type </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-unit-type-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Type Code </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-unit-type-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Number </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-floor-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Level Type </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-floor-level-type-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Type Code </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-floor-type-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Name </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-street-name-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Number </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-street-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Suffix </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-street-suffix-history">
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
                                <tbody class="fw-bold text-gray-600" id="right_gas_address_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Code </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-street-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">House Number </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-house-number-history">
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">House Number Suffix </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-house-number-suffix-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Suburb </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-suburb-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Property Name </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-property-name-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">State </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-state-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Post Code </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-postcode-history">
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Site Location Descriptor </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-site-location-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Property Ownership </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-property-ownership-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">DPID </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-dpid-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Ignore address validation ( Only
                                                for
                                                AGL
                                                )
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end gas_connection-address-validation-history">
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
