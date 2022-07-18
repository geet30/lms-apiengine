<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="delivery_address_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Delivery Address</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history" id="delivery
                        _address_history_link" data-address_id="{{ $deliveryAddress->id ?? '' }}"
                            data-vertical_id={{ $verticalId }} data-section='delivery_address'
                            data-for="delivery_address_history" data-initial="delivery_address_show">Show
                            History</a>

                        <a href="javascript:void(0);" class="fw-bolder text-primary update_section float-end"
                            data-lead_id={{ $saleDetail->l_lead_id }} data-service_id={{ $verticalId }}
                            data-for="delivery_address_edit" data-initial="delivery_address_show"><i
                                class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600" id="delivery_address_main_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap">Delivery Preference</div>
                                            </td>
                                            <td class="fw-bolder text-end delivery_preference_td">
                                                @if (isset($saleDetail->l_delivery_preference))
                                                    @switch($saleDetail->l_delivery_preference)
                                                        @case(1)
                                                            Connection
                                                            @php
                                                                $delivery = 'Connection';
                                                            @endphp
                                                        @break
                                                        @default
                                                            Other
                                                            @php
                                                                $delivery = 'Other';
                                                            @endphp
                                                    @endswitch
                                                @else
                                                    N/A
                                                    @php
                                                        $delivery = '';
                                                    @endphp
                                                @endif
                                            </td>
                                        </tr>
                                        <tr id="delivery_connection_tr"
                                            {{ $delivery == 'Connection' ? '' : 'style=display:none' }}>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap">Delivery Address</div>
                                            </td>
                                            <td class="fw-bolder text-end delivery_connection_td">
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
                                                    $connectionAddressName = (isset($connectionAddress->unit_number) ? 'Unit ' . $connectionAddress->unit_number : '') . ' ' . (isset($connectionAddress->street_number) ? $connectionAddress->street_number : '') . ' ' . (isset($connectionAddress->street_name) ? $connectionAddress->street_name : '') . ' ' . (isset($street_code) ? $street_code : '') . ',' . (isset($connectionAddress->suburb) ? $connectionAddress->suburb : '') . ' ' . (isset($state_code) ? $state_code : '');
                                                @endphp
                                                @if (isset($connectionAddress->address) && strlen($connectionAddress->address) > 0)
                                                    {{ $connectionAddress->address }}
                                                @elseif(strlen(trim($connectionAddressName)) > 1)
                                                    {{ $connectionAddressName }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    @if (isset($deliveryAddress->street_code))
                        @foreach ($streetTypeCodes as $streetTypeCode)
                            @if ($streetTypeCode->id == $deliveryAddress->street_code)
                                @php
                                    $street_code = $streetTypeCode->value;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    @if (isset($deliveryAddress->state))
                        @foreach ($states as $state)
                            @if ($state->state_id == $deliveryAddress->state)
                                @php
                                    $state_code = $state->state_code;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    @php
                        $deliveryAddressName = (isset($deliveryAddress->unit_number) ? 'Unit ' . $deliveryAddress->unit_number : '') . ' ' . (isset($deliveryAddress->street_number) ? $deliveryAddress->street_number : '') . ' ' . (isset($deliveryAddress->street_name) ? $deliveryAddress->street_name : '') . ' ' . (isset($street_code) ? $street_code : '') . ',' . (isset($deliveryAddress->suburb) ? $deliveryAddress->suburb : '') . ' ' . (isset($state_code) ? $state_code : '');
                    @endphp
                    <div class="row" id="delivery_address_body"
                        {{ $delivery == 'Other' ? '' : 'style=display:none' }}>
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600" id="left_delivery_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Address </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-address-td">
                                                @if (isset($deliveryAddress->address) && strlen($deliveryAddress->address) > 0)
                                                    {{ $deliveryAddress->address }}
                                                @elseif(strlen(trim($deliveryAddressName)) > 1)
                                                    {{ $deliveryAddressName }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Lot Number </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-lot-number">
                                                {{ isset($deliveryAddress->lot_number) && $deliveryAddress->lot_number != '' ? $deliveryAddress->lot_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Number </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-unit-number">
                                                {{ isset($deliveryAddress->unit_number) && $deliveryAddress->unit_number != '' ? $deliveryAddress->unit_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Type </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-unit-type">
                                                @if (isset($deliveryAddress->unit_type) && $deliveryAddress->unit_type != '')
                                                    @foreach ($unitTypes as $unitType)
                                                        @if ($unitType->id == $deliveryAddress->unit_type)
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
                                            <td class="fw-bolder text-end delivery-unit-type-code">
                                                {{ isset($deliveryAddress->unit_type_code) && $deliveryAddress->unit_type_code != '' ? $deliveryAddress->unit_type_code : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Number </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-floor-number">
                                                {{ isset($deliveryAddress->floor_number) && $deliveryAddress->floor_number != '' ? $deliveryAddress->floor_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Level Type </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-floor-level-type">
                                                {{ isset($deliveryAddress->floor_level_type) && $deliveryAddress->floor_level_type != '' ? $deliveryAddress->floor_level_type : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Type Code </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-floor-type-code">
                                                {{ isset($deliveryAddress->floor_type_code) && $deliveryAddress->floor_type_code != '' ? $deliveryAddress->floor_type_code : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Name </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-street-name">
                                                {{ isset($deliveryAddress->street_name) && $deliveryAddress->street_name != '' ? $deliveryAddress->street_name : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Number </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-street-number">
                                                {{ isset($deliveryAddress->street_number) && $deliveryAddress->street_number != '' ? $deliveryAddress->street_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Suffix </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-street-suffix">
                                                {{ isset($deliveryAddress->street_suffix) && $deliveryAddress->street_suffix != '' ? $deliveryAddress->street_suffix : 'N/A' }}
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
                                    <tbody class="fw-bold text-gray-600" id="right_delivery_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Code </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-street-code">

                                                @if (isset($deliveryAddress->street_code) && $deliveryAddress->street_code != '')
                                                    @foreach ($streetTypeCodes as $streetTypeCode)
                                                        @if ($streetTypeCode->id == $deliveryAddress->street_code)
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
                                            <td class="fw-bolder text-end delivery-house-number">
                                                {{ isset($deliveryAddress->house_number) && $deliveryAddress->house_number != '' ? $deliveryAddress->house_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">House Number Suffix </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-house-number-suffix">
                                                {{ isset($deliveryAddress->house_number_suffix) && $deliveryAddress->house_number_suffix != '' ? $deliveryAddress->house_number_suffix : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Suburb </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-suburb">
                                                {{ isset($deliveryAddress->suburb) && $deliveryAddress->suburb != '' ? $deliveryAddress->suburb : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Property Name </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-property-name">
                                                {{ isset($deliveryAddress->property_name) && $deliveryAddress->property_name != '' ? $deliveryAddress->property_name : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">State </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-state">
                                                @if (isset($deliveryAddress->state) && $deliveryAddress->state != '')
                                                    @foreach ($states as $state)
                                                        @if ($state->state_id == $deliveryAddress->state)
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
                                            <td class="fw-bolder text-end delivery-postcode">
                                                {{ isset($deliveryAddress->postcode) && $deliveryAddress->postcode != '' ? $deliveryAddress->postcode : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Site Location Descriptor </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-site-location">
                                                {{ isset($deliveryAddress->site_descriptor) && $deliveryAddress->site_descriptor != '' ? $deliveryAddress->site_descriptor : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Property Ownership </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-property-ownership">
                                                {{ isset($deliveryAddress->property_ownership) && $deliveryAddress->property_ownership != '' ? $deliveryAddress->property_ownership : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">DPID </div>
                                            </td>
                                            <td class="fw-bolder text-end delivery-dpid">
                                                {{ isset($deliveryAddress->dpid) && $deliveryAddress->dpid != '' ? $deliveryAddress->dpid : 'N/A' }}
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
                                            <td class="fw-bolder text-end delivery-address-validation">
                                                {{ isset($deliveryAddress->validate_address) && $deliveryAddress->validate_address == 1 ? 'Yes' : 'No' }}
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

    <div id="delivery_address_edit" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Delivery Address Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form role="form" name="deliveryinfo_form" id="deliveryinfo_form">
                        @csrf
                        <input type="hidden" name="deliveryAddressId" value="{{ $deliveryAddress->id ?? '' }}">
                        <input type="hidden" name="leadId" value={{ $saleDetail->l_lead_id }}>
                        <input type="hidden" name="visitorId" value={{ $saleDetail->l_visitor_id }}>
                        <div class="row mb-6 text-gray-600">
                            <div class="col-md-6">
                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid  mb-5">
                                    <input class="form-check-input solar" name="delivery_address_option" type="radio"
                                        value="1"
                                        {{ (isset($saleDetail->l_delivery_preference) && $saleDetail->l_delivery_preference == 1) || $delivery == 'Connection' ? 'checked' : '' }} />
                                    <span class="fw-bolder ps-2 fs-6">
                                        Connection
                                    </span>
                                </label>
                                <label class="form-check form-check-inline form-check-solid  mb-5">
                                    <input class="form-check-input solar" name="delivery_address_option" type="radio"
                                        value="2"
                                        {{ isset($saleDetail->l_delivery_preference) && $saleDetail->l_delivery_preference == 2 ? 'checked' : '' }} />
                                    <span class="fw-bolder ps-2 fs-6">
                                        Other
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div id="delivery_info_form"
                            {{ (isset($saleDetail->l_delivery_preference) && $saleDetail->l_delivery_preference == 1) || $delivery == 'Connection' ? 'style=display:none' : '' }}>
                            <div class="row mb-6 text-gray-600">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">Address:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input type="text" class="form-control" id="address"
                                                placeholder="Search Connection Address" name="delivery_address"
                                                autocomplete="off" value="{{ $deliveryAddress->address ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">House Number:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="delivery_house_num" class="form-control"
                                                name="delivery_house_num" type="text"
                                                value="{{ $deliveryAddress->house_number ?? '' }}">
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
                                            <input id="delivery_lot_number" class="form-control"
                                                name="delivery_lot_number" type="text"
                                                value="{{ $deliveryAddress->lot_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">House Number Suffix:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="delivery_house_number_suffix" class="form-control"
                                                name="delivery_house_number_suffix" type="text"
                                                value="{{ $deliveryAddress->house_number_suffix ?? '' }}">
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
                                            <input id="delivery_unit_no" class="form-control" name="delivery_unit_no"
                                                type="text" value="{{ $deliveryAddress->unit_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder required">Suburb:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="delivery_suburb" class="form-control" name="delivery_suburb"
                                                type="text" value="{{ $deliveryAddress->suburb ?? '' }}">
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
                                                name="delivery_unit_type" id="delivery_unit_type">
                                                <option value="">Select Unit Type</option>
                                                @foreach ($unitTypes as $unitType)
                                                    <option value="{{ $unitType->id }}"
                                                        {{ isset($deliveryAddress->unit_type) && $deliveryAddress->unit_type == $unitType->id ? 'selected' : '' }}>
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
                                                name="delivery_state" id="delivery_state">
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->state_id }}"
                                                        {{ isset($deliveryAddress->state) && $deliveryAddress->state == $state->state_id ? 'selected' : '' }}>
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
                                                name="delivery_unit_type_code" id="delivery_unit_type_code">
                                                <option value="">Select Unit type code</option>
                                                @foreach ($unitTypeCodes as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ isset($deliveryAddress->unit_type_code) && $deliveryAddress->unit_type_code == $key ? 'selected' : '' }}>
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
                                            <input id="delivery_property_name" class="form-control"
                                                name="delivery_property_name" type="text"
                                                value="{{ $deliveryAddress->property_name ?? '' }}">
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
                                            <input id="delivery_floor_no" class="form-control" name="delivery_floor_no"
                                                type="text" value="{{ $deliveryAddress->floor_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder required">Post Code:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="delivery_postcode" class="form-control" name="delivery_postcode"
                                                type="text" value="{{ $deliveryAddress->postcode ?? '' }}">
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
                                            <input id="delivery_floor_level_type" class="form-control"
                                                name="delivery_floor_level_type" type="text"
                                                value="{{ $deliveryAddress->floor_level_type ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">Street Code:</label>
                                        <div class="col-lg-9 fv-row">
                                            <select data-control="select2" class="form-select-solid form-select"
                                                id="delivery_street_code" name="delivery_street_code">
                                                <option value="">Select Street Type (optional)</option>
                                                @foreach ($streetTypeCodes as $streetTypeCode)
                                                    <option value="{{ $streetTypeCode->id }}"
                                                        {{ isset($deliveryAddress->street_code) && $deliveryAddress->street_code == $streetTypeCode->id ? 'selected' : '' }}>
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
                                                name="delivery_floor_type_code" id="delivery_floor_type_code">
                                                <option value="" selected="selected">Select floor type code</option>
                                                @foreach ($floorTypeCodes as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ isset($deliveryAddress->floor_type_code) && $deliveryAddress->floor_type_code == $key ? 'selected' : '' }}>
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
                                            <input id="delivery_site_descriptor" class="form-control"
                                                name="delivery_site_descriptor" type="text"
                                                value="{{ $deliveryAddress->site_descriptor ?? '' }}">
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
                                            <input id="delivery_street_name" class="form-control"
                                                name="delivery_street_name" type="text"
                                                value="{{ $deliveryAddress->street_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">Property Ownership:</label>
                                        <div class="col-lg-9 fv-row">
                                            <select data-control="select2" class="form-select-solid form-select"
                                                name="delivery_property_ownership" id="delivery_property_ownership">
                                                <option value="" selected="selected">Select</option>
                                                <option value="Own"
                                                    {{ isset($deliveryAddress->property_ownership) && $deliveryAddress->property_ownership == 'Own' ? 'selected' : '' }}>
                                                    Own</option>
                                                <option value="Rent"
                                                    {{ isset($deliveryAddress->property_ownership) && $deliveryAddress->property_ownership == 'Rent' ? 'selected' : '' }}>
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
                                            <input id="delivery_street_number" class="form-control"
                                                name="delivery_street_number" type="text"
                                                value="{{ $deliveryAddress->street_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">Street Number Suffix:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="delivery_street_number_suffix" class="form-control"
                                                name="delivery_street_number_suffix" type="text"
                                                value="{{ $deliveryAddress->street_number_suffix ?? '' }}">
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
                                            <input id="delivery_street_suffix" class="form-control"
                                                name="delivery_street_suffix" type="text"
                                                value="{{ $deliveryAddress->street_suffix ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">DPID:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="delivery_dpid" class="form-control" name="delivery_dpid"
                                                type="text" value="{{ $deliveryAddress->dpid ?? '' }}">
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
                                                <input class="form-check-input sweetalert_demos" type="checkbox"
                                                    value="1" name="delivery_is_qas_valid" id="delivery_is_qas_valid"
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
                                                    name="delivery_validate_address" id="delivery_validate_address"
                                                    {{ isset($connectionAddress->validate_address) && $connectionAddress->validate_address == 1 ? 'checked' : '' }}>
                                            </div>
                                            <!--end::Input-->
                                        </div>
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
                                data-initial="delivery_address_edit"
                                data-for="delivery_address_show">{{ __('buttons.cancel') }}</a>
                            <button type="submit" class="update_address_button"
                                class="btn btn-primary">{{ __('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="delivery_address_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Delivery Address</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="delivery_address_history_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="delivery_address_history"
                        data-for="delivery_address_show">{{ __('buttons.close') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_delivery_address_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">delivery Address Update History</h2>
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
                                <tbody class="fw-bold text-gray-600" id="delivery_address_main_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Delivery Preference</div>
                                        </td>
                                        <td class="fw-bolder text-end delivery_preference_history_td">
                                        </td>
                                    </tr>
                                    <tr id="delivery_connection_history_tr">
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Delivery Address</div>
                                        </td>
                                        <td class="fw-bolder text-end delivery_connection_history_td">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" id="delivery_address_history_table_body">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600" id="left_delivery_address_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Address </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-address-history-td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Lot Number </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-lot-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Number </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-unit-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Type </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-unit-type-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Type Code </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-unit-type-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Number </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-floor-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Level Type </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-floor-level-type-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Type Code </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-floor-type_code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Name </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-street-name-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Number </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-street-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Suffix </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-street-suffix-history">
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
                                <tbody class="fw-bold text-gray-600" id="right_delivery_address_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Code </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-street-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">House Number </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-house-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">House Number Suffix </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-house-number-suffix-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Suburb </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-suburb-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Property Name </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-property-name-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">State </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-state-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Post Code </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-postcode-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Site Location Descriptor </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-site-location-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Property Ownership </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-property-ownership-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">DPID </div>
                                        </td>
                                        <td class="fw-bolder text-end delivery-dpid-history">
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
                                        <td class="fw-bolder text-end delivery-address-validation-history">
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
