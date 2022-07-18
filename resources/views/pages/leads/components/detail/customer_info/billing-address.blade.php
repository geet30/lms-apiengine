<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="billing_address_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Billing Address</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history" id="billing
                        _address_history" data-address_id="{{ $billingAddress->id ?? '' }}"
                            data-vertical_id={{ $verticalId }} data-section='billing_address'
                            data-for="billing_address_history" data-initial="billing_address_show">Show
                            History</a>

                        <a href="javascript:void(0);" class="fw-bolder text-primary update_section float-end"
                            data-lead_id={{ $saleDetail->l_lead_id }} data-service_id={{ $verticalId }}
                            data-for="billing_address_edit" data-initial="billing_address_show"><i
                                class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600" id="billing_address_main_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex">Billing Preference</div>
                                            </td>
                                            <td class="fw-bolder text-end billing_preference_td">
                                                @if (isset($saleDetail->l_billing_preference))
                                                    @switch($saleDetail->l_billing_preference)
                                                        @case(1)
                                                            Email
                                                            @php
                                                                $billing = 'Email';
                                                            @endphp
                                                        @break
                                                        @case(2)
                                                            Connection
                                                            @php
                                                                $billing = 'Connection';
                                                            @endphp
                                                        @break
                                                        @default
                                                            Other
                                                            @php
                                                                $billing = 'Other';
                                                            @endphp
                                                    @endswitch
                                                @else
                                                    N/A
                                                    @php
                                                        $billing = '';
                                                    @endphp
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="billing_email_tr"
                                            {{ isset($billing) && $billing == 'Email' ? '' : 'style=display:none;' }}>
                                            <td class="text-muted">
                                                <div class="d-flex">Billing Email</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ isset($saleDetail->v_email) ? strtolower(decryptGdprData($saleDetail->v_email)) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr id="billing_connection_tr"
                                            {{ isset($billing) && $billing == 'Connection' ? '' : 'style=display:none;' }}>
                                            <td class="text-muted">
                                                <div class="d-flex">Billing Address</div>
                                            </td>
                                            <td class="fw-bolder text-end billing_connection_td">
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
                        </div>
                        <div class="col-md-6 px-5 email_welcome_pack"
                            {{ isset($billing) && $billing == 'Email' ? '' : 'style=display:none;' }}>
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Is Postal Address Available
                                                </div>
                                            </td>
                                            <td class="fw-bolder text-end email_welcome_pack_td">
                                                {{ isset($saleDetail->l_email_welcome_pack) && $saleDetail->l_email_welcome_pack == 1 ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if (isset($billingAddress->street_code))
                        @foreach ($streetTypeCodes as $streetTypeCode)
                            @if ($streetTypeCode->id == $billingAddress->street_code)
                                @php
                                    $street_code = $streetTypeCode->value;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    @if (isset($billingAddress->state))
                        @foreach ($states as $state)
                            @if ($state->state_id == $billingAddress->state)
                                @php
                                    $state_code = $state->state_code;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    @php
                        $billingAddressName = (isset($billingAddress->unit_number) ? 'Unit ' . $billingAddress->unit_number : '') . ' ' . (isset($billingAddress->street_number) ? $billingAddress->street_number : '') . ' ' . (isset($billingAddress->street_name) ? $billingAddress->street_name : '') . ' ' . (isset($street_code) ? $street_code : '') . ',' . (isset($billingAddress->suburb) ? $billingAddress->suburb : '') . ' ' . (isset($state_code) ? $state_code : '');
                    @endphp
                    <div class="row" id="billing_address_body"
                        {{ ($billing == 'Email' && (isset($saleDetail->l_email_welcome_pack) && $saleDetail->l_email_welcome_pack == 1)) || $billing == 'Other' ? '' : 'style=display:none' }}>
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600" id="left_billing_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Address </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-address-td">
                                                @if (isset($billingAddress->address) && strlen($billingAddress->address) > 0)
                                                    {{ $billingAddress->address }}
                                                @elseif(strlen(trim($billingAddressName)) > 1)
                                                    {{ $billingAddressName }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Lot Number </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-lot-number">
                                                {{ isset($billingAddress->lot_number) && $billingAddress->lot_number != '' ? $billingAddress->lot_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Number </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-unit-number">
                                                {{ isset($billingAddress->unit_number) && $billingAddress->unit_number != '' ? $billingAddress->unit_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Unit Type </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-unit-type">
                                                @if (isset($billingAddress->unit_type) && $billingAddress->unit_type != '')
                                                    @foreach ($unitTypes as $unitType)
                                                        @if ($unitType->id == $billingAddress->unit_type)
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
                                            <td class="fw-bolder text-end billing-unit-type-code">
                                                {{ isset($billingAddress->unit_type_code) && $billingAddress->unit_type_code != '' ? $billingAddress->unit_type_code : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Number </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-floor-number">
                                                {{ isset($billingAddress->floor_number) && $billingAddress->floor_number != '' ? $billingAddress->floor_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Level Type </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-floor-level-type">
                                                {{ isset($billingAddress->floor_level_type) && $billingAddress->floor_level_type != '' ? $billingAddress->floor_level_type : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Floor Type Code </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-floor-type-code">
                                                {{ isset($billingAddress->floor_type_code) && $billingAddress->floor_type_code != '' ? $billingAddress->floor_type_code : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Name </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-street-name">
                                                {{ isset($billingAddress->street_name) && $billingAddress->street_name != '' ? $billingAddress->street_name : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Number </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-street-number">
                                                {{ isset($billingAddress->street_number) && $billingAddress->street_number != '' ? $billingAddress->street_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Suffix </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-street-suffix">
                                                {{ isset($billingAddress->street_suffix) && $billingAddress->street_suffix != '' ? $billingAddress->street_suffix : 'N/A' }}
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
                                    <tbody class="fw-bold text-gray-600" id="right_billing_address_body">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Street Code </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-street-code">

                                                @if (isset($billingAddress->street_code) && $billingAddress->street_code != '')
                                                    @foreach ($streetTypeCodes as $streetTypeCode)
                                                        @if ($streetTypeCode->id == $billingAddress->street_code)
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
                                            <td class="fw-bolder text-end billing-house-number">
                                                {{ isset($billingAddress->house_number) && $billingAddress->house_number != '' ? $billingAddress->house_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">House Number Suffix </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-house-number-suffix">
                                                {{ isset($billingAddress->house_number_suffix) && $billingAddress->house_number_suffix != '' ? $billingAddress->house_number_suffix : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Suburb </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-suburb">
                                                {{ isset($billingAddress->suburb) && $billingAddress->suburb != '' ? $billingAddress->suburb : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Property Name </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-property-name">
                                                {{ isset($billingAddress->property_name) && $billingAddress->property_name != '' ? $billingAddress->property_name : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">State </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-state">
                                                @if (isset($billingAddress->state) && $billingAddress->state != '')
                                                    @foreach ($states as $state)
                                                        @if ($state->state_id == $billingAddress->state)
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
                                            <td class="fw-bolder text-end billing-postcode">
                                                {{ isset($billingAddress->postcode) && $billingAddress->postcode != '' ? $billingAddress->postcode : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Site Location Descriptor </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-site-location">
                                                {{ isset($billingAddress->site_descriptor) && $billingAddress->site_descriptor != '' ? $billingAddress->site_descriptor : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Property Ownership </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-property-ownership">
                                                {{ isset($billingAddress->property_ownership) && $billingAddress->property_ownership != '' ? $billingAddress->property_ownership : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">DPID </div>
                                            </td>
                                            <td class="fw-bolder text-end billing-dpid">
                                                {{ isset($billingAddress->dpid) && $billingAddress->dpid != '' ? $billingAddress->dpid : 'N/A' }}
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
                                            <td class="fw-bolder text-end billing-address-validation">
                                                {{ isset($billingAddress->validate_address) && $billingAddress->validate_address == 1 ? 'Yes' : 'No' }}
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
    <div id="billing_address_edit" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Billing Address Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form role="form" name="billinginfo_form" id="billinginfo_form">
                        @csrf
                        <input type="hidden" name="billingAddressId" value="{{ $billingAddress->id ?? '' }}">
                        <input type="hidden" name="leadId" value={{ $saleDetail->l_lead_id }}>
                        <input type="hidden" name="visitorId" value={{ $saleDetail->l_visitor_id }}>
                        <input type="hidden" name="addressType"
                            value={{ isset($saleDetail->journey_property_type) && $saleDetail->journey_property_type == 0 ? 1 : 2 }}>
                        <div class="row mb-6 text-gray-600">
                            <div class="col-md-6">
                                <label class="form-check form-check-inline form-check-solid mb-5">
                                    <input class="form-check-input solar" name="billing_address_option" type="radio"
                                        value="1"
                                        {{ (isset($saleDetail->l_billing_preference) && $saleDetail->l_billing_preference == 1) || $billing == 'Email' ? 'checked' : '' }} />
                                    <span class="fw-bolder ps-2 fs-6">
                                        Email
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid  mb-5">
                                    <input class="form-check-input solar" name="billing_address_option" type="radio"
                                        value="2"
                                        {{ isset($saleDetail->l_billing_preference) && $saleDetail->l_billing_preference == 2 ? 'checked' : '' }} />
                                    <span class="fw-bolder ps-2 fs-6">
                                        Connection
                                    </span>
                                </label>
                                <label class="form-check form-check-inline form-check-solid  mb-5">
                                    <input class="form-check-input solar" name="billing_address_option" type="radio"
                                        value="3"
                                        {{ isset($saleDetail->l_billing_preference) && $saleDetail->l_billing_preference == 3 ? 'checked' : '' }} />
                                    <span class="fw-bolder ps-2 fs-6">
                                        Other
                                    </span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-6 text-gray-600 email_welcome_check"
                                    {{ (isset($saleDetail->l_billing_preference) && $saleDetail->l_billing_preference == 1) || $billing == 'Email' ? '' : 'style=display:none' }}>
                                    <!--begin::Label-->
                                    <label class="col-md-8 fw-bolder">Add postal address for welcome pack :</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-4 fv-row">
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input sweetalert_demo" type="checkbox"
                                                name="email_welcome_pack"
                                                {{ isset($saleDetail->l_email_welcome_pack) && $saleDetail->l_email_welcome_pack == 1 ? 'checked' : '' }}>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="billing_info_form"
                            {{ isset($saleDetail->l_billing_preference) && $saleDetail->l_billing_preference == 2 ? 'style=display:none' : '' }}>
                            <div class="row mb-6 text-gray-600">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">Address:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input type="text" class="form-control" id="address"
                                                placeholder="Search Connection Address" name="billing_address"
                                                autocomplete="off" value="{{ $billingAddress->address ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">House Number:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="billing_house_num" class="form-control" name="billing_house_num"
                                                type="text" value="{{ $billingAddress->house_number ?? '' }}">
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
                                            <input id="billing_lot_number" class="form-control"
                                                name="billing_lot_number" type="text"
                                                value="{{ $billingAddress->lot_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">House Number Suffix:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="billing_house_number_suffix" class="form-control"
                                                name="billing_house_number_suffix" type="text"
                                                value="{{ $billingAddress->house_number_suffix ?? '' }}">
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
                                            <input id="billing_unit_no" class="form-control" name="billing_unit_no"
                                                type="text" value="{{ $billingAddress->unit_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder required">Suburb:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="billing_suburb" class="form-control" name="billing_suburb"
                                                type="text" value="{{ $billingAddress->suburb ?? '' }}">
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
                                                name="billing_unit_type" id="billing_unit_type">
                                                <option value="">Select Unit Type</option>
                                                @foreach ($unitTypes as $unitType)
                                                    <option value="{{ $unitType->id }}"
                                                        {{ isset($billingAddress->unit_type) && $billingAddress->unit_type == $unitType->id ? 'selected' : '' }}>
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
                                                name="billing_state" id="billing_state">
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->state_id }}"
                                                        {{ isset($billingAddress->state) && $billingAddress->state == $state->state_id ? 'selected' : '' }}>
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
                                                name="billing_unit_type_code" id="billing_unit_type_code">
                                                <option value="">Select Unit type code</option>
                                                @foreach ($unitTypeCodes as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ isset($billingAddress->unit_type_code) && $billingAddress->unit_type_code == $key ? 'selected' : '' }}>
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
                                            <input id="billing_property_name" class="form-control"
                                                name="billing_property_name" type="text"
                                                value="{{ $billingAddress->property_name ?? '' }}">
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
                                            <input id="billing_floor_no" class="form-control" name="billing_floor_no"
                                                type="text" value="{{ $billingAddress->floor_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder required">Post Code:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="billing_postcode" class="form-control" name="billing_postcode"
                                                type="text" value="{{ $billingAddress->postcode ?? '' }}">
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
                                            <input id="billing_floor_level_type" class="form-control"
                                                name="billing_floor_level_type" type="text"
                                                value="{{ $billingAddress->floor_level_type ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">Street Code:</label>
                                        <div class="col-lg-9 fv-row">
                                            <select data-control="select2" class="form-select-solid form-select"
                                                id="billing_street_code" name="billing_street_code">
                                                <option value="">Select Street Type (optional)</option>
                                                @foreach ($streetTypeCodes as $streetTypeCode)
                                                    <option value="{{ $streetTypeCode->id }}"
                                                        {{ isset($billingAddress->street_code) && $billingAddress->street_code == $streetTypeCode->id ? 'selected' : '' }}>
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
                                                name="billing_floor_type_code" id="billing_floor_type_code">
                                                <option value="" selected="selected">Select floor type code</option>
                                                @foreach ($floorTypeCodes as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ isset($billingAddress->floor_type_code) && $billingAddress->floor_type_code == $key ? 'selected' : '' }}>
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
                                            <input id="billing_site_descriptor" class="form-control"
                                                name="billing_site_descriptor" type="text"
                                                value="{{ $billingAddress->site_descriptor ?? '' }}">
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
                                            <input id="billing_street_name" class="form-control"
                                                name="billing_street_name" type="text"
                                                value="{{ $billingAddress->street_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">Property Ownership:</label>
                                        <div class="col-lg-9 fv-row">
                                            <select data-control="select2" class="form-select-solid form-select"
                                                name="billing_property_ownership" id="billing_property_ownership">
                                                <option value="" selected="selected">Select</option>
                                                <option value="Own"
                                                    {{ isset($billingAddress->property_ownership) && $billingAddress->property_ownership == 'Own' ? 'selected' : '' }}>
                                                    Own</option>
                                                <option value="Rent"
                                                    {{ isset($billingAddress->property_ownership) && $billingAddress->property_ownership == 'Rent' ? 'selected' : '' }}>
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
                                            <input id="billing_street_number" class="form-control"
                                                name="billing_street_number" type="text"
                                                value="{{ $billingAddress->street_number ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">Street Number Suffix:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="billing_street_number_suffix" class="form-control"
                                                name="billing_street_number_suffix" type="text"
                                                value="{{ $billingAddress->street_number_suffix ?? '' }}">
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
                                            <input id="billing_street_suffix" class="form-control"
                                                name="billing_street_suffix" type="text"
                                                value="{{ $billingAddress->street_suffix ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 fw-bolder">DPID:</label>
                                        <div class="col-lg-9 fv-row">
                                            <input id="billing_dpid" class="form-control" name="billing_dpid"
                                                type="text" value="{{ $billingAddress->dpid ?? '' }}">
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
                                                    value="1" name="billing_is_qas_valid" id="billing_is_qas_valid"
                                                    {{ isset($billingAddress->is_qas_valid) && $billingAddress->is_qas_valid == 1 ? 'checked' : '' }}>
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
                                                    name="billing_validate_address" id="billing_validate_address"
                                                    {{ isset($billingAddress->validate_address) && $billingAddress->validate_address == 1 ? 'checked' : '' }}>
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
                                data-initial="billing_address_edit"
                                data-for="billing_address_show">{{ __('buttons.cancel') }}</a>
                            <button type="submit" class="update_address_button"
                                class="btn btn-primary">{{ __('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="billing_address_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Billing Address</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="billing_address_history_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="billing_address_history"
                        data-for="billing_address_show">{{ __('buttons.close') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_billing_address_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Billing Address Update History</h2>
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
                                <tbody class="fw-bold text-gray-600" id="billing_address_main_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Billing Preferences</div>
                                        </td>
                                        <td class="fw-bolder text-end billing_preference_history_td">
                                        </td>
                                    </tr>
                                    <tr id="billing_connection_history_tr">
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Billing Address</div>
                                        </td>
                                        <td class="fw-bolder text-end billing_connection_history_td">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 px-5 email_welcome_pack_history">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Is Postal Address Available
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end email_welcome_pack_history_td">
                                            {{ isset($saleDetail->l_email_welcome_pack) && $saleDetail->l_email_welcome_pack == 1 ? 'Yes' : 'No' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" id="billing_address_history_table_body">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600" id="left_billing_address_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Address </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-address-history-td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Lot Number </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-lot-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Number </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-unit-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Type </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-unit-type-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Unit Type Code </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-unit-type-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Number </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-floor-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Level Type </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-floor-level-type-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Floor Type Code </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-floor-type-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Name </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-street-name-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Number </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-street-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Suffix </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-street-suffix-history">
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
                                <tbody class="fw-bold text-gray-600" id="right_billing_address_body">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Street Code </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-street-code-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">House Number </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-house-number-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">House Number Suffix </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-house-number-suffix-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Suburb </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-suburb-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Property Name </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-property-name-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">State </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-state-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Post Code </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-postcode-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Site Location Descriptor </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-site-location-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Property Ownership </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-property-ownership-history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">DPID </div>
                                        </td>
                                        <td class="fw-bolder text-end billing-dpid-history">
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
                                        <td class="fw-bolder text-end billing-address-validation-history">
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
