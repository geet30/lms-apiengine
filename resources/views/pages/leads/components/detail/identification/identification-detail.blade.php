<div class="tab-pane fade show mb-5" role="tab-panel">
    <div id="identification_detail_view">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden" id="identification_detail_show">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Identification Details</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary show_history"
                            data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                            data-vertical_id="{{ $verticalId ?? '' }}" data-section='identification_detail'
                            data-for="identification_detail_history" data-initial="identification_detail_view">Show
                            History</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">

                            @php
                                $inc = 0;
                                $contents = ['Primary Identification', 'Secondary Identification'];
                            @endphp
                            @if (isset($identificationDetails) && count($identificationDetails) > 0)
                                @foreach ($identificationDetails as $key => $value)
                                    <tbody class="fw-bold text-gray-600" id="table_{{ $key }}">


                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center"><span
                                                        class="text-dark fw-bolder fs-6">{{ $contents[$inc] }}:</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="my-auto me-4 py-3">
                                                    <a href=""
                                                        class="fw-bolder text-primary update_section float-end button_{{ $key }}"
                                                        data-id="{{ $key }}"><i
                                                            class="bi bi-pencil-square text-primary"></i> Edit</a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Identification Type:</div>
                                            </td>
                                            <td class="fw-bolder text-end {{ $key }}_idenType">
                                                {{ $identificationDetails[$key]->identification_type ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        @if (!empty($identificationDetails[$key]))
                                            @switch($identificationDetails[$key]->identification_type)
                                                @case('Drivers Licence')
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div
                                                                class="d-flex align-items-center {{ $key }}_lic_state">
                                                                Licence State:</div>
                                                        </td>
                                                        <td class="fw-bolder text-end {{ $key }}_lic_state_code">
                                                            {{ $identificationDetails[$key]->licence_state_code ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Licence Number:</div>
                                                        </td>
                                                        <td class="fw-bolder text-end {{ $key }}_lic_number">
                                                            {{ $identificationDetails[$key]->licence_number ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Identification Expiry Date:
                                                            </div>
                                                        </td>
                                                        <td class="fw-bolder text-end {{ $key }}_lic_expiry">
                                                            {{ isset($identificationDetails[$key]->licence_expiry_date) ? $identificationDetails[$key]->licence_expiry_date : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    @if ($verticalId == 1)
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">ID Matrix Reference
                                                                    Number:
                                                                </div>
                                                            </td>
                                                            <td class="fw-bolder text-end">
                                                                N/A
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">ID Matrix Status:</div>
                                                            </td>
                                                            <td class="fw-bolder text-end">
                                                                Disabled
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @break

                                                @case('Foreign Passport')
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Passport Number:</div>
                                                        </td>
                                                        <td class="fw-bolder text-end {{ $key }}_foreign_pass_number">
                                                            {{ $identificationDetails[$key]->foreign_passport_number ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Country Name:</div>
                                                        </td>
                                                        <td
                                                            class="fw-bolder text-end {{ $key }}_foreign_country_name">
                                                            {{ $identificationDetails[$key]->foreign_country_name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Country Code:</div>
                                                        </td>
                                                        <td
                                                            class="fw-bolder text-end {{ $key }}_foreign_country_code">
                                                            {{ $identificationDetails[$key]->foreign_country_code ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center ">Identification Expiry Date:
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="fw-bolder text-end {{ $key }}_foreign_ident_expiry_date">
                                                            {{ isset($identificationDetails[$key]->foreign_passport_expiry_date) ? $identificationDetails[$key]->foreign_passport_expiry_date : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    @if ($verticalId == 1)
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">ID Matrix Reference
                                                                    Number:
                                                                </div>
                                                            </td>
                                                            <td class="fw-bolder text-end">
                                                                N/A
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">ID Matrix Status:</div>
                                                            </td>
                                                            <td class="fw-bolder text-end">
                                                                Disabled
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @break

                                                @case('Passport')
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Passport Number:</div>
                                                        </td>
                                                        <td class="fw-bolder text-end {{ $key }}_passport_number">
                                                            {{ $identificationDetails[$key]->passport_number ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Identification Expiry Date:
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="fw-bolder text-end {{ $key }}_passport_ident_expiry">
                                                            {{ isset($identificationDetails[$key]->passport_expiry_date) ? $identificationDetails[$key]->passport_expiry_date : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    @if ($verticalId == 1)
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">ID Matrix Reference
                                                                    Number:
                                                                </div>
                                                            </td>
                                                            <td class="fw-bolder text-end">
                                                                N/A
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">ID Matrix Status:</div>
                                                            </td>
                                                            <td class="fw-bolder text-end">
                                                                Disabled
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @break

                                                @case('Medicare Card')
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Medicare Card Number:</div>
                                                        </td>
                                                        <td class="fw-bolder text-end {{ $key }}_medi_card_num">
                                                            {{ $identificationDetails[$key]->medicare_number ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Reference Number:</div>
                                                        </td>
                                                        <td class="fw-bolder text-end {{ $key }}_medi_ref_num">
                                                            {{ $identificationDetails[$key]->reference_number ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Middle Name On Card:</div>
                                                        </td>
                                                        <td
                                                            class="fw-bolder text-end {{ $key }}_medi_card_middle_name">
                                                            {{ $identificationDetails[$key]->card_middle_name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Card Color:</div>
                                                        </td>
                                                        <td class="fw-bolder text-end {{ $key }}_medi_card_color">
                                                            {{ $identificationDetails[$key]->card_color ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Identification Expiry Date:
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="fw-bolder text-end {{ $key }}_medi_card_ident_expiry">
                                                            {{ isset($identificationDetails[$key]->medicare_card_expiry_date) ? $identificationDetails[$key]->medicare_card_expiry_date : 'N/A' }}
                                                            {{ $identificationDetails[$key]->medicare_card_expiry_date ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    @if ($verticalId == 1)
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">ID Matrix Reference
                                                                    Number:
                                                                </div>
                                                            </td>
                                                            <td class="fw-bolder text-end">
                                                                N/A
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">ID Matrix Status:</div>
                                                            </td>
                                                            <td class="fw-bolder text-end">
                                                                Disabled
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @break
                                            @endswitch
                                        @endif
                                        @php $inc++ @endphp




                                    </tbody>
                                    @if ($loop->iteration == 1)
                                        <div id="primary_data_edit_form" style="display:none">
                                            <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
                                                <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <h2>Primary Identification Edit</h2>
                                                        </div>
                                                    </div>
                                                    <div class="card-body pt-0">

                                                        <form role="form" name="table_primary_form"
                                                            id="table_primary_form" class="editForm">
                                                            @csrf
                                                            <input type="hidden" name="primaryId"
                                                                value="{{ $identificationDetails['primary_data']->id ?? '' }}">
                                                            <input type="hidden" name="primaryLeadId"
                                                                value="{{ $saleDetail->l_lead_id ?? '' }}">
                                                            <input type="hidden" name="verticalId"
                                                                value="{{ $verticalId }}">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-6 text-gray-600">
                                                                    <div class="row">
                                                                        <label class="col-md-4 fw-bolder">Identification
                                                                            Type:</label>
                                                                        <div class="col-md-8 fv-row">
                                                                            <select data-control="select2"
                                                                                class="form-select-solid form-select"
                                                                                name="primary_identification_type"
                                                                                id="primary_identification_type">
                                                                                @foreach ($identificationTypes as $key => $value)
                                                                                    <option value="{{ $key }}"
                                                                                        {{ isset($identificationDetails['primary_data']->identification_type) && $identificationDetails['primary_data']->identification_type == $key ? 'selected' : '' }}>
                                                                                        {{ $value }}</option>
                                                                                @endforeach

                                                                            </select>
                                                                            <!-- <input type="text" class="form-control"  name="primary_licence_state" value="{{ $identificationDetails['primary_data']->licence_state_code ?? ' ' }}"/> -->
                                                                            <span class="error text-danger"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="primary_driver_license"
                                                                    class="row primary_form" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Licence
                                                                                    State:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <select data-control="select2"
                                                                                        class="form-select-solid form-select"
                                                                                        name="primary_licence_state">
                                                                                        <option value=""> Select State
                                                                                        </option>
                                                                                        @foreach ($states as $state)
                                                                                            <option
                                                                                                value="{{ $state['state_code'] }}"
                                                                                                {{ isset($identificationDetails['primary_data']->licence_state_code) && $identificationDetails['primary_data']->licence_state_code == $state['state_code'] ? 'selected="selected"' : '' }}>
                                                                                                {{ $state['state'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <!-- <input type="text" class="form-control"  name="primary_licence_state" value="{{ $identificationDetails['primary_data']->licence_state_code ?? ' ' }}"/> -->
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Licence
                                                                                    Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="primary_licence_number"
                                                                                        value="{{ $identificationDetails['primary_data']->licence_number ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Identification
                                                                                    Expiry Date:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control identification_details_date"
                                                                                        name="primary_lice_id_exp_date"
                                                                                        value="{{ $identificationDetails['primary_data']->licence_expiry_date ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <div class="col-md-6 mb-6 text-gray-600">
                                                                                    <div class="row">
                                                                                        <label class="col-md-4 fw-bolder">Comment</label>
                                                                                        <div class="col-md-8 fv-row">
                                                                                            <input type="text" class="form-control " name="primary_licence_comment" id="primary_licence_comment" value=""/>
                                                                                            <span class="error text-danger"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->
                                                                    </div>
                                                                </div>
                                                                <div id="primary_foreign_passport"
                                                                    class=" row primary_form" style="display:none;">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Passport
                                                                                    Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="primary_foreign_passport_number"
                                                                                        value="{{ $identificationDetails['primary_data']->foreign_passport_number ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Country
                                                                                    Name:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <select
                                                                                        name="primary_foreign_country_name"
                                                                                        data-control="select2"
                                                                                        class="form-select-solid form-select">
                                                                                        <option value=""> Select Country
                                                                                        </option>
                                                                                        @foreach ($countriesData as $data)
                                                                                            <option
                                                                                                value="{{ $data['name'] }}"
                                                                                                {{ isset($identificationDetails['primary_data']->foreign_country_name) && $identificationDetails['primary_data']->foreign_country_name == $data['name'] ? 'selected' : '' }}>
                                                                                                {{ $data['name'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <!-- <input type="text" class="form-control"  name="primary_foreign_country_name" value="{{ $identificationDetails['primary_data']->foreign_country_name ?? ' ' }}"/> -->
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Country
                                                                                    Code:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="primary_foreign_country_code"
                                                                                        value="{{ $identificationDetails['primary_data']->foreign_country_code ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Identification
                                                                                    Expiry Date:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control identification_details_date"
                                                                                        name="primary_foreign_passport_expiry_date"
                                                                                        value="{{ $identificationDetails['primary_data']->foreign_passport_expiry_date ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <!-- <div class="col-md-6 mb-6 text-gray-600">
                                                                                    <div class="row">
                                                                                        <label class="col-md-4 fw-bolder">Comment</label>
                                                                                        <div class="col-md-8 fv-row">
                                                                                            <input type="text" class="form-control " name="primary_foreign_passport_comment" id="primary_foreign_passport_comment" value=""/>
                                                                                            <span class="error text-danger"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->
                                                                    </div>
                                                                </div>
                                                                <div id="primary_passport" class="row primary_form"
                                                                    style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Passport
                                                                                    Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="primary_passport_number"
                                                                                        value="{{ $identificationDetails['primary_data']->passport_number ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Identification
                                                                                    Expiry Date:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control
                                                                                            identification_details_date"
                                                                                        name="primary_passport_exp_date"
                                                                                        value="{{ $identificationDetails['primary_data']->passport_expiry_date ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- <div class="col-md-6 mb-6 text-gray-600">
                                                                                        <div class="row">
                                                                                            <label class="col-md-4 fw-bolder">Comment</label>
                                                                                            <div class="col-md-8 fv-row">
                                                                                                <input type="text" class="form-control " name="primary_passport_comment" id="primary_passport_comment" value=""/>
                                                                                                <span class="error text-danger"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                </div> -->
                                                                    </div>
                                                                </div>
                                                                <div id="primary_medicare_card"
                                                                    class="row primary_form" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Medicare
                                                                                    Card Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="primary_medicare_number"
                                                                                        value="{{ $identificationDetails['primary_data']->medicare_number ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Reference
                                                                                    Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <select data-control="select2"
                                                                                        class="form-select-solid form-select"
                                                                                        name="primary_medicare_ref_num">
                                                                                        <option value=""> Select
                                                                                            Reference Number</option>
                                                                                        @foreach ($referenceNumbers as $key => $value)
                                                                                            <option
                                                                                                value="{{ $key }}"
                                                                                                {{ isset($identificationDetails['primary_data']->reference_number) && $identificationDetails['primary_data']->reference_number == $key ? 'selected' : '' }}>
                                                                                                {{ $value }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <!-- <input type="text" class="form-control"  name="primary_medicare_ref_num" value="{{ $identificationDetails['primary_data']->reference_number ?? ' ' }}"/> -->
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Middle
                                                                                    Name On Card:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="primary_medicare_card_middle_name"
                                                                                        value="{{ $identificationDetails['primary_data']->card_middle_name ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label class="col-md-4 fw-bolder">Card
                                                                                    Color:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <select
                                                                                        name="primary_medicare_card_color"
                                                                                        data-control="select2"
                                                                                        class="form-select-solid form-select">
                                                                                        <option value=""> Select Card
                                                                                            Color</option>
                                                                                        @foreach ($cardColors as $key => $value)
                                                                                            <option
                                                                                                value="{{ $key }}"
                                                                                                {{ isset($identificationDetails['primary_data']->card_color) && $identificationDetails['primary_data']->card_color == $key ? 'selected' : '' }}>
                                                                                                {{ $value }}
                                                                                            </option>
                                                                                        @endforeach

                                                                                    </select>
                                                                                    <!-- <input type="text" class="form-control"  name="primary_medicare_card_color" value="{{ $identificationDetails['primary_data']->card_color ?? ' ' }}"/> -->
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Identification
                                                                                    Expiry Date:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control
                                                                                            identification_details_date"
                                                                                        name="primary_medicare_card_expiry_date"
                                                                                        value="{{ $identificationDetails['primary_data']->medicare_card_expiry_date ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <div class="col-md-6 mb-6 text-gray-600">
                                                                                        <div class="row">
                                                                                            <label class="col-md-4 fw-bolder">Comment</label>
                                                                                            <div class="col-md-8 fv-row">
                                                                                                <input type="text" class="form-control " name="primary_medicare_card_comment" id="primary_medicare_card_comment" value=""/>
                                                                                                <span class="error text-danger"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                </div> -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-6 text-gray-600">
                                                                    <div class="row">
                                                                        <label
                                                                            class="col-md-4 fw-bolder">Comment</label>
                                                                        <div class="col-md-8 fv-row">
                                                                            <input type="text" class="form-control "
                                                                                name="primary_comment"
                                                                                id="primary_comment" value="" />
                                                                            <span class="error text-danger"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="card-footer d-flex justify-content-end py-6 px-9">
                                                                    <a class="btn btn-light btn-active-light-primary me-2 close_section"
                                                                        id="primary_cancel_button">Cancel</a>
                                                                    <button type="submit"
                                                                        class="update_primary_submit_button"
                                                                        class="btn btn-primary">Save</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                    @if ($loop->iteration == 2)
                                        <div id="secondary_data_edit_form" style="display:none">
                                            <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
                                                <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <h2>Secondary Identification Edit</h2>
                                                        </div>
                                                    </div>
                                                    <div class="card-body pt-0" class="editForm">
                                                        <form role="form" name="table_secondary_form"
                                                            id="table_secondary_form">
                                                            @csrf
                                                            <input type="hidden" name="secondaryLeadId"
                                                                value="{{ $saleDetail->l_lead_id ?? '' }}">
                                                            <input type="hidden" name="secondaryId"
                                                                value="{{ $identificationDetails['secondary_data']->id ?? '' }}">
                                                            <input type="hidden" name="verticalId"
                                                                value="{{ $verticalId }}">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-6 text-gray-600">
                                                                    <div class="row">
                                                                        <label
                                                                            class="col-md-4 fw-bolder">Identification
                                                                            Type:</label>
                                                                        <div class="col-md-8 fv-row">
                                                                            <select name="secondary_identification_type"
                                                                                data-control="select2"
                                                                                class="form-select-solid form-select"
                                                                                id="secondary_identification_type">
                                                                                @foreach ($identificationTypes as $key => $value)
                                                                                    <option value="{{ $key }}"
                                                                                        {{ isset($identificationDetails['secondary_data']->identification_type) && $identificationDetails['secondary_data']->identification_type == $key ? 'selected' : '' }}>
                                                                                        {{ $value }}</option>
                                                                                @endforeach

                                                                            </select>
                                                                            <!-- <input type="text" class="form-control"  name="primary_licence_state" value="{{ $identificationDetails['primary_data']->licence_state_code ?? ' ' }}"/> -->
                                                                            <span class="error text-danger"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="secondary_driver_license" style="display:none"
                                                                    class="secondary_form">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Licence
                                                                                    State:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <select data-control="select2"
                                                                                        class="form-select-solid form-select"
                                                                                        name="secondary_licence_state">
                                                                                        <option value=""> Select State
                                                                                        </option>
                                                                                        @foreach ($states as $state)
                                                                                            <option
                                                                                                value="{{ $state['state_code'] }}"
                                                                                                {{ isset($identificationDetails['secondary_data']->licence_state_code) && $identificationDetails['secondary_data']->licence_state_code == $state['state_code'] ? 'selected="selected"' : '' }}>
                                                                                                {{ $state['state'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <!-- <input type="text" class="form-control"  name="secondary_licence_state" value="{{ $identificationDetails['secondary_data']->licence_state_code ?? ' ' }}"> -->
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Licence
                                                                                    Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="secondary_licence_number"
                                                                                        value="{{ $identificationDetails['secondary_data']->licence_number ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Identification
                                                                                    Expiry Date:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control
                                                                                            identification_details_date"
                                                                                        name="secondary_lice_id_exp_date"
                                                                                        value="{{ $identificationDetails['secondary_data']->licence_expiry_date ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <div class="col-md-6 mb-6 text-gray-600">
                                                                                    <div class="row">
                                                                                        <label class="col-md-4 fw-bolder">Comment</label>
                                                                                        <div class="col-md-8 fv-row">
                                                                                            <input type="text" class="form-control " name="secondary_licence_comment" id="secondary_licence_comment" />
                                                                                            <span class="error text-danger"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->
                                                                    </div>
                                                                </div>

                                                                <div id="secondary_foreign_passport"
                                                                    style="display:none" class="secondary_form">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Passport
                                                                                    Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="secondary_foreign_passport_number"
                                                                                        value="{{ $identificationDetails['secondary_data']->foreign_passport_number ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Country
                                                                                    Name:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <select
                                                                                        name="secondary_foreign_country_name"
                                                                                        data-control="select2"
                                                                                        class="form-select-solid form-select">
                                                                                        <option value=""> Select Country
                                                                                        </option>
                                                                                        @foreach ($countriesData as $data)
                                                                                            <option
                                                                                                value="{{ $data['name'] }}"
                                                                                                {{ isset($identificationDetails['secondary_data']->foreign_country_name) && $identificationDetails['secondary_data']->foreign_country_name == $data['name'] ? 'selected' : '' }}>
                                                                                                {{ $data['name'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <!-- <input type="text" class="form-control"  name="secondary_foreign_country_name" value="{{ $identificationDetails['secondary_data']->foreign_country_name ?? ' ' }}"/> -->
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Country
                                                                                    Code:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="secondary_foreign_country_code"
                                                                                        value="{{ $identificationDetails['secondary_data']->foreign_country_code ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Identification
                                                                                    Expiry Date:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control identification_details_date"
                                                                                        name="secondary_foreign_passport_expiry_date"
                                                                                        value="{{ $identificationDetails['secondary_data']->foreign_passport_expiry_date ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <div class="col-md-6 mb-6 text-gray-600">
                                                                                    <div class="row">
                                                                                        <label class="col-md-4 fw-bolder">Comment</label>
                                                                                        <div class="col-md-8 fv-row">
                                                                                            <input type="text" class="form-control " name="secondary_foreign_passport_comment" id="secondary_foreign_passport_comment" />
                                                                                            <span class="error text-danger"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->
                                                                    </div>
                                                                </div>

                                                                <div id="secondary_passport" style="display:none"
                                                                    class="secondary_form">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Passport
                                                                                    Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="secondary_passport_number"
                                                                                        value="{{ $identificationDetails['secondary_data']->passport_number ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Identification
                                                                                    Expiry Date:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control identification_details_date"
                                                                                        name="secondary_passport_exp_date"
                                                                                        value="{{ $identificationDetails['secondary_data']->passport_expiry_date ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- <div class="col-md-6 mb-6 text-gray-600">
                                                                                        <div class="row">
                                                                                            <label class="col-md-4 fw-bolder">Comment</label>
                                                                                            <div class="col-md-8 fv-row">
                                                                                                <input type="text" class="form-control " name="secondary_passport_comment" id="secondary_passport_comment" />
                                                                                                <span class="error text-danger"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                </div> -->
                                                                    </div>
                                                                </div>

                                                                <div id="secondary_medicare_card" style="display:none"
                                                                    class="secondary_form">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Medicare
                                                                                    Card Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="secondary_medicare_number"
                                                                                        value="{{ $identificationDetails['secondary_data']->medicare_number ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Reference
                                                                                    Number:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <select data-control="select2"
                                                                                        class="form-select-solid form-select"
                                                                                        name="secondary_medicare_ref_num">
                                                                                        <option value=""> Select
                                                                                            Reference Number</option>
                                                                                        @foreach ($referenceNumbers as $key => $value)
                                                                                            <option
                                                                                                value="{{ $key }}"
                                                                                                {{ isset($identificationDetails['secondary_data']->reference_number) && $identificationDetails['secondary_data']->reference_number == $key ? 'selected' : '' }}>
                                                                                                {{ $value }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <!-- <input type="text" class="form-control"  name="secondary_medicare_ref_num" value="{{ $identificationDetails['secondary_data']->reference_number ?? ' ' }}"/> -->
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Middle
                                                                                    Name On Card:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="secondary_medicare_card_middle_name"
                                                                                        value="{{ $identificationDetails['secondary_data']->card_middle_name ?? ' ' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label class="col-md-4 fw-bolder">Card
                                                                                    Color:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <select
                                                                                        name="secondary_medicare_card_color"
                                                                                        data-control="select2"
                                                                                        class="form-select-solid form-select">
                                                                                        <option value=""> Select Card
                                                                                            Color</option>
                                                                                        @foreach ($cardColors as $key => $value)
                                                                                            <option
                                                                                                value="{{ $key }}"
                                                                                                {{ isset($identificationDetails['secondary_data']->card_color) && $identificationDetails['secondary_data']->card_color == $key ? 'selected' : '' }}>
                                                                                                {{ $value }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <!-- <input type="text" class="form-control"  name="secondary_medicare_card_color" value="{{ $identificationDetails['secondary_data']->card_color ?? ' ' }}"/> -->
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-6 mb-6 text-gray-600">
                                                                            <div class="row">
                                                                                <label
                                                                                    class="col-md-4 fw-bolder">Identification
                                                                                    Expiry Date:</label>
                                                                                <div class="col-md-8 fv-row">
                                                                                    <input type="text"
                                                                                        class="form-control identification_details_date"
                                                                                        name="secondary_medicare_card_expiry_date"
                                                                                        value="{{ $identificationDetails['secondary_data']->medicare_card_expiry_date ?? '' }}" />
                                                                                    <span
                                                                                        class="error text-danger"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- <div class="col-md-6 mb-6 text-gray-600">
                                                                                        <div class="row">
                                                                                            <label class="col-md-4 fw-bolder">Comment</label>
                                                                                            <div class="col-md-8 fv-row">
                                                                                                <input type="text" class="form-control " name="secondary_medicare_card_comment" id="secondary_medicare_card_comment" />
                                                                                                <span class="error text-danger"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                </div> -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-6 text-gray-600">
                                                                    <div class="row">
                                                                        <label
                                                                            class="col-md-4 fw-bolder">Comment</label>
                                                                        <div class="col-md-8 fv-row">
                                                                            <input type="text" class="form-control "
                                                                                name="secondary_comment"
                                                                                id="secondary_comment" value="" />
                                                                            <span class="error text-danger"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div
                                                                class="card-footer d-flex justify-content-end py-6 px-9">
                                                                <a class="btn btn-light btn-active-light-primary me-2 close_section"
                                                                    id="secondary_cancel_button">Cancel</a>
                                                                <button type="submit"
                                                                    class="update_seconary_submit_button"
                                                                    class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td class="fw-bolder" colspan="7" align="center"> No Data Found</td>
                                    </tr>
                                </tbody>
                            @endif
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
    <div id="identification_detail_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Identification Details</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="identification_detail_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="identification_detail_history"
                        data-for="identification_detail_view">{{ __('buttons.close') }}</a>
                </div>

                <!--end::Documents-->
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="show_identification_detail_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Identification Detail Update History</h2>
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
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                        <tbody class="fw-bold text-gray-600">


                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center"><span
                                            class="text-dark fw-bolder fs-6 identification_type_history"></span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Identification Type:</div>
                                </td>
                                <td class="fw-bolder text-end identity_type_history">
                                </td>
                            </tr>
                                <tr class="licence_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            Licence State:</div>
                                    </td>
                                    <td class="fw-bolder text-end lic_state_code_history">
                                    </td>
                                </tr>
                                <tr class="licence_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Licence Number:</div>
                                    </td>
                                    <td class="fw-bolder text-end lic_number_history">
                                    </td>
                                </tr>
                                <tr class="licence_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Identification Expiry Date:
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end lic_expiry_history">
                                    </td>
                                </tr>
                                <tr class="foreign_passport_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Passport Number:</div>
                                    </td>
                                    <td class="fw-bolder text-end foreign_pass_number_history">
                                    </td>
                                </tr>
                                <tr class="foreign_passport_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Country Name:</div>
                                    </td>
                                    <td class="fw-bolder text-end foreign_country_name_history">
                                    </td>
                                </tr>
                                <tr class="foreign_passport_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Country Code:</div>
                                    </td>
                                    <td class="fw-bolder text-end foreign_country_code_history">
                                    </td>
                                </tr>
                                <tr class="foreign_passport_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center ">Identification Expiry Date:
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end foreign_ident_expiry_date_history">
                                    </td>
                                </tr>
                                <tr class="passport_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Passport Number:</div>
                                    </td>
                                    <td class="fw-bolder text-end passport_number_history">
                                    </td>
                                </tr>
                                <tr class="passport_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Identification Expiry Date:
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end passport_ident_expiry_history">
                                    </td>
                                </tr>
                                <tr class="medicare_card_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Medicare Card Number:</div>
                                    </td>
                                    <td class="fw-bolder text-end medi_card_num_history">
                                    </td>
                                </tr>
                                <tr class="medicare_card_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Reference Number:</div>
                                    </td>
                                    <td class="fw-bolder text-end medi_ref_num_history">
                                    </td>
                                </tr>
                                <tr class="medicare_card_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Middle Name On Card:</div>
                                    </td>
                                    <td class="fw-bolder text-end medi_card_middle_name_history">
                                    </td>
                                </tr>
                                <tr class="medicare_card_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Card Color:</div>
                                    </td>
                                    <td class="fw-bolder text-end medi_card_color_history">
                                    </td>
                                </tr>
                                <tr class="medicare_card_body">
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Identification Expiry Date:
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end medi_card_ident_expiry_history">
                                    </td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
            </div>
        </div>

    </div>
</div>
