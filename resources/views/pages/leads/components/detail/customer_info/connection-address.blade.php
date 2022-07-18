<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="connection_address_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Connection Address</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history" id="connection
                        _address_history_link" data-address_id="{{ $connectionAddress->id ?? '' }}"
                            data-vertical_id={{ $verticalId }} data-section='connection_address'
                            data-for="connection_address_history" data-initial="connection_address_show">Show
                            History</a>

                        <a href="javascript:void(0);" class="fw-bolder text-primary update_section float-end"
                            data-lead_id={{ $saleDetail->l_lead_id }} data-service_id={{ $verticalId }}
                            data-for="connection_address_edit" data-initial="connection_address_show"><i
                                class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @if (isset($connectionAddress->street_code))
                        @foreach ($streetTypeCodes as $streetTypeCode)
                            @if ($streetTypeCode->id == $connectionAddress->street_code)
                                @php
                                    $street_code = $streetTypeCode->value;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    @if (isset($connectionAddress->state))
                        @foreach ($states as $state)
                            @if ($state->state_id == $connectionAddress->state)
                                @php
                                    $state_code = $state->state_code;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    @php
                           $connectionAddressName = (isset($connectionAddress->unit_number) ? 'Unit ' . $connectionAddress->unit_number : '').' '.
                                                    (isset($connectionAddress->street_number) ? $connectionAddress->street_number : '').' '.
                                                    (isset($connectionAddress->street_name) ? $connectionAddress->street_name : '').' '.
                                                    (isset($street_code) ? $street_code :'').','.(isset($connectionAddress->suburb) ? $connectionAddress->suburb : '').' '.
                                                    (isset($state_code) ? $state_code : '');
                    @endphp
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600" id="left_connection_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Address </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-address-td">
                                                @if (isset($connectionAddress->address) && strlen($connectionAddress->address) > 0)
                                                    {{ $connectionAddress->address }}
                                                @elseif(strlen(trim($connectionAddressName)) > 1)
                                                    {{ $connectionAddressName }}
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
                                                {{ isset($connectionAddress->lot_number) && $connectionAddress->lot_number != '' ? $connectionAddress->lot_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Number </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-unit-number">
                                                {{ isset($connectionAddress->unit_number) && $connectionAddress->unit_number != '' ? $connectionAddress->unit_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Type </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-unit-type">
                                                @if (isset($connectionAddress->unit_type) && $connectionAddress->unit_type != '')
                                                    @foreach ($unitTypes as $unitType)
                                                        @if ($unitType->id == $connectionAddress->unit_type)
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
                                                <div class="d-flex text-nowrap text-nowrap align-items-center">Unit Type Code </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-unit-type-code">
                                                {{ isset($connectionAddress->unit_type_code) && $connectionAddress->unit_type_code != '' ? $connectionAddress->unit_type_code : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Number </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-floor-number">
                                                {{ isset($connectionAddress->floor_number) && $connectionAddress->floor_number != '' ? $connectionAddress->floor_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Level Type </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-floor-level-type">
                                                {{ isset($connectionAddress->floor_level_type) && $connectionAddress->floor_level_type != '' ? $connectionAddress->floor_level_type : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Type Code </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-floor-type-code">
                                                {{ isset($connectionAddress->floor_type_code) && $connectionAddress->floor_type_code != '' ? $connectionAddress->floor_type_code : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Name </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-street-name">
                                                {{ isset($connectionAddress->street_name) && $connectionAddress->street_name != '' ? $connectionAddress->street_name : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Number </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-street-number">
                                                {{ isset($connectionAddress->street_number) && $connectionAddress->street_number != '' ? $connectionAddress->street_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Suffix </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-street-suffix">
                                                {{ isset($connectionAddress->street_suffix) && $connectionAddress->street_suffix != '' ? $connectionAddress->street_suffix : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Code </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-street-code">

                                                @if (isset($connectionAddress->street_code) && $connectionAddress->street_code != '')
                                                    @foreach ($streetTypeCodes as $streetTypeCode)
                                                        @if ($streetTypeCode->id == $connectionAddress->street_code)
                                                            {{ $streetTypeCode->value }}
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
                                    <tbody class="fw-bold text-gray-600" id="right_connection_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">House Number </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-house-number">
                                                {{ isset($connectionAddress->house_number) && $connectionAddress->house_number != '' ? $connectionAddress->house_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">House Number Suffix </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-house-number-suffix">
                                                {{ isset($connectionAddress->house_number_suffix) && $connectionAddress->house_number_suffix != '' ? $connectionAddress->house_number_suffix : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Suburb </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-suburb">
                                                {{ isset($connectionAddress->suburb) && $connectionAddress->suburb != '' ? $connectionAddress->suburb : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Property Name </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-property-name">
                                                {{ isset($connectionAddress->property_name) && $connectionAddress->property_name != '' ? $connectionAddress->property_name : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">State </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-state">
                                                @if (isset($connectionAddress->state) && $connectionAddress->state != '')
                                                    @foreach ($states as $state)
                                                        @if ($state->state_id == $connectionAddress->state)
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
                                            <td class="fw-bolder text-end connection-postcode">
                                                {{ isset($connectionAddress->postcode) && $connectionAddress->postcode != '' ? $connectionAddress->postcode : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Site Location Descriptor </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-site-location">
                                                {{ isset($connectionAddress->site_descriptor) && $connectionAddress->site_descriptor != '' ? $connectionAddress->site_descriptor : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Property Ownership </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-property-ownership">
                                                {{ isset($connectionAddress->property_ownership) && $connectionAddress->property_ownership != '' ? $connectionAddress->property_ownership : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">DPID </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-dpid">
                                                {{ isset($connectionAddress->dpid) && $connectionAddress->dpid != '' ? $connectionAddress->dpid : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Is Qas Valid
                                                </div>
                                            </td>
                                            <td class="fw-bolder text-end connection-qas">
                                                {{ isset($connectionAddress->is_qas_valid) && $connectionAddress->is_qas_valid == 1 ? 'Yes' : 'No' }}
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
                                            <td class="fw-bolder text-end connection-address-validation">
                                                {{ isset($connectionAddress->validate_address) && $connectionAddress->validate_address == 1 ? 'Yes' : 'No' }}
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
    <div id="connection_address_edit" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Connection Address Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form role="form" name="connectioninfo_form" id="connectioninfo_form">
                        @csrf
                        <input type="hidden" name="connectionAddressId" value="{{ $connectionAddress->id ?? '' }}">
                        <input type="hidden" name="leadId" value={{ $saleDetail->l_lead_id }}>
                        <input type="hidden" name="visitorId" value={{ $saleDetail->l_visitor_id }}>
                        <input type="hidden" name="addressType"
                            value={{ isset($saleDetail->journey_property_type) && $saleDetail->journey_property_type == 0 ? 1 : 2 }}>
                        <div class="row mb-6 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">Address:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input type="text" class="form-control" id="address"
                                            placeholder="Search Connection Address" name="connection_address"
                                            autocomplete="off" value="{{ $connectionAddress->address ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">House Number:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="house_num" class="form-control" name="house_num" type="text"
                                            value="{{ $connectionAddress->house_number ?? '' }}">
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
                                            value="{{ $connectionAddress->lot_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">House Number Suffix:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="house_number_suffix" class="form-control" name="house_number_suffix"
                                            type="text" value="{{ $connectionAddress->house_number_suffix ?? '' }}">
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
                                            value="{{ $connectionAddress->unit_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder required">Suburb:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="suburb" class="form-control" name="suburb" type="text"
                                            value="{{ $connectionAddress->suburb ?? '' }}">
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
                                            name="unit_type" id="unit_type">
                                            <option value="">Select Unit Type</option>
                                            @foreach ($unitTypes as $unitType)
                                                <option value="{{ $unitType->id }}"
                                                    {{ isset($connectionAddress->unit_type) && $connectionAddress->unit_type == $unitType->id ? 'selected' : '' }}>
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
                                            name="state">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->state_id }}"
                                                    {{ isset($connectionAddress->state) && $connectionAddress->state == $state->state_id ? 'selected' : '' }}>
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
                                            name="unit_type_code" id="unit_type_code">
                                            <option value="">Select Unit type code</option>
                                            @foreach ($unitTypeCodes as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ isset($connectionAddress->unit_type_code) && $connectionAddress->unit_type_code == $key ? 'selected' : '' }}>
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
                                            value="{{ $connectionAddress->property_name ?? '' }}">
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
                                            value="{{ $connectionAddress->floor_number ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder required">Post Code:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="postcode" class="form-control" name="postcode" type="text"
                                            value="{{ $connectionAddress->postcode ?? '' }}">
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
                                            type="text" value="{{ $connectionAddress->floor_level_type ?? '' }}">
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
                                                    {{ isset($connectionAddress->street_code) && $connectionAddress->street_code == $streetTypeCode->id ? 'selected' : '' }}>
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
                                                    {{ isset($connectionAddress->floor_type_code) && $connectionAddress->floor_type_code == $key ? 'selected' : '' }}>
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
                                            type="text" value="{{ $connectionAddress->site_descriptor ?? '' }}">
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
                                            value="{{ $connectionAddress->street_number ?? '' }}">
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
                                                {{ isset($connectionAddress->property_ownership) && $connectionAddress->property_ownership == 'Own' ? 'selected' : '' }}>
                                                Own</option>
                                            <option value="Rent"
                                                {{ isset($connectionAddress->property_ownership) && $connectionAddress->property_ownership == 'Rent' ? 'selected' : '' }}>
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
                                            value="{{ $connectionAddress->street_number ?? '' }}">
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
                                            value="{{ $connectionAddress->street_number_suffix ?? '' }}">
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
                                            value="{{ $connectionAddress->street_suffix ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 fw-bolder">DPID:</label>
                                    <div class="col-lg-9 fv-row">
                                        <input id="dpid" class="form-control" name="connection_dpid" type="text"
                                            value="{{ $connectionAddress->dpid ?? '' }}">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-8 text-gray-600">
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-md-6 fw-bolder">Is QAS Valid ( Only for Origin ) :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-6 fv-row">
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input sweetalert_demos" type="checkbox" value="1"
                                                name="is_qas_valid" id="is_qas_valid"
                                                {{ isset($connectionAddress->is_qas_valid) && $connectionAddress->is_qas_valid == 1 ? 'checked' : '' }}>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <!--begin::Label-->
                                    <label class="col-md-6 fw-bolder">Ignore address validation ( Only for AGL )
                                        :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-6 fv-row">
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input sweetalert_demo" type="checkbox"
                                                name="validate_address" id="validate_address"
                                                {{ isset($connectionAddress->validate_address) && $connectionAddress->validate_address == 1 ? 'checked' : '' }}>
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
                                data-initial="connection_address_edit"
                                data-for="connection_address_show">{{ __('buttons.cancel') }}</a>
                            <button type="submit" class="update_address_button"
                                class="btn btn-primary">{{ __('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="connection_address_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Connection Address</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="connection_address_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="connection_address_history"
                        data-for="connection_address_show">{{ __('buttons.close') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_connection_address_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Connection Address Update History</h2>
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
                                <tbody class="fw-bold text-gray-600" id="left_connection_address_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Address </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-address-history-td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Lot Number </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-lot-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Number </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-unit-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Type </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-unit-type-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Type Code </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-unit-type-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Number </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-floor-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Level Type </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-floor-level-type-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Type Code </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-floor-type-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Name </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-street-name-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Number </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-street-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Suffix </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-street-suffix-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Code </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-street-code-history">
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
                                            <div class="d-flex align-items-center">House Number </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-house-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">House Number Suffix </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-house-number-suffix-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Suburb </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-suburb-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Property Name </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-property-name-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">State </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-state-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Post Code </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-postcode-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Site Location Descriptor </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-site-location-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Property Ownership </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-property-ownership-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">DPID </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-dpid-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Is Qas Valid
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end connection-qas-history">
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
                                        <td class="fw-bolder text-end connection-address-validation-history">
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
