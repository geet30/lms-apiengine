<div class="tab-pane fade show mb-5" role="tab-panel">
    <!--begin::Order details-->
    <div id="journey_show">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card col-md-4 card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>General Info</h2>
                    </div>
                    @if ($verticalId == 1)
                        <div class="my-auto me-4 py-3">
                            <a href="javascript:void(0);" class="fw-bolder me-6 text-primary show_history"
                                data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                                data-vertical_id="{{ $verticalId ?? '' }}" data-section='journey'
                                data-for="journey_history" data-initial="journey_show">Show
                                History</a>

                            <a href="" class="fw-bolder text-primary update_section float-end"
                                data-lead_id={{ $saleDetail->l_lead_id }} data-service_id={{ $verticalId }}
                                data-for="journey_edit" data-initial="journey_show"><i
                                    class="bi bi-pencil-square text-primary"></i> Edit</a>
                        </div>
                    @endif
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                            <tbody class="fw-bold text-gray-600">
                                <div class="row">
                                    @if ($verticalId == '1')
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Fuel Type</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span class="fw-bolder fuel_type">
                                                        @if (isset($saleDetail) && isset($gasSaleDetail))
                                                            Both
                                                        @elseif (isset($saleDetail->sale_product_product_type) &&
                                                            $saleDetail->sale_product_product_type == 1)
                                                            Electricity
                                                        @elseif ((isset($saleDetail->sale_product_product_type) &&
                                                            $saleDetail->sale_product_product_type == 2) ||
                                                            isset($gasSaleDetail->sale_product_product_type))
                                                            Gas
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Property Type</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder property_type">{{ isset($saleDetail->journey_property_type) && $saleDetail->journey_property_type == 0 ? 'Residential' : 'Business' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Life Support</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder life_support">{{ isset($saleDetail->journey_life_support) && $saleDetail->journey_life_support == 1 ? 'Yes' : 'No' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($saleDetail) && isset($gasSaleDetail))
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                                id="life_support_fuel_div"
                                                {{ isset($saleDetail->journey_life_support) && $saleDetail->journey_life_support == 1 ? '' : 'style=display:none' }}>
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Life Support Fuel</div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span class="fw-bolder life_support_fuel">
                                                            @if (isset($saleDetail->journey_life_support_energy_type))
                                                                @switch($saleDetail->journey_life_support_energy_type)
                                                                    @case(1)
                                                                        Electricity
                                                                    @break
                                                                    @case(2)
                                                                        Gas
                                                                    @break
                                                                    @default
                                                                        Both
                                                                @endswitch
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                            id="life_support_equipment_div"
                                            {{ isset($saleDetail->journey_life_support) && $saleDetail->journey_life_support == 1 ? '' : 'style=display:none' }}>
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Life Support Equipment
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder life_support_equipment">{{ $saleDetail->journey_life_support_value ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Moving Property</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder moving_property">{{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? 'Yes' : 'No' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="elec_movin_div"
                                                {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 0 ? 'style=display:none' : '' }}>
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Moving
                                                            Date</div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder elec_moving_date">
                                                            {{ isset($saleDetail->sale_product_moving_at) ? dateTimeFormat($saleDetail->sale_product_moving_at) : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="gas_movin_div"
                                                {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 0 ? 'style=display:none' : '' }}>
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Moving Date</div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder gas_moving_date">{{ isset($gasSaleDetail->sale_product_moving_at) ? dateTimeFormat($gasSaleDetail->sale_product_moving_at) : dateTimeFormat($saleDetail->sale_product_moving_at) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="movin_time_div"
                                            {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 0 ? 'style=display:none' : '' }}>
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Perferred Move-In Time
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder prefered_movin_time">{{ $saleDetail->journey_prefered_move_in_time }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                                id="elec_provider_div"
                                                {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? 'style=display:none' : '' }}>
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Current
                                                            Electricity Provider</div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span class="fw-bolder elec_provider">
                                                            @foreach ($providers as $provider)
                                                                @if (isset($saleDetail->sale_product_provider_id) && $saleDetail->sale_product_provider_id == $provider['id'])
                                                                    {{ $provider['legal_name'] }}
                                                                    @php
                                                                        $elecProviderId = $provider['id'];
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="gas_provider_div"
                                                {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? 'style=display:none' : '' }}>
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Current Gas Provider
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span class="fw-bolder gas_provider">
                                                            @foreach ($providers as $provider)
                                                                @if (isset($saleDetail) && isset($gasSaleDetail))
                                                                    @if (isset($gasSaleDetail->sale_product_provider_id) && $gasSaleDetail->sale_product_provider_id == $provider['id'])
                                                                        {{ $provider['legal_name'] }}
                                                                        @php
                                                                            $gasProviderId = $provider['id'];
                                                                        @endphp
                                                                    @endif
                                                                @elseif(isset($saleDetail))
                                                                    @if (isset($saleDetail->sale_product_provider_id) && $saleDetail->sale_product_provider_id == $provider['id'])
                                                                        {{ $provider['legal_name'] }}
                                                                        @php
                                                                            $gasProviderId = $provider['id'];
                                                                        @endphp
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="is_elec_work_div"
                                            {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 0 ? 'style=display:none' : '' }}>
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Is Electrical Work is
                                                        going on at site</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder is_elec_work">{{ isset($saleDetail->vie_is_elec_work) && $saleDetail->vie_is_elec_work == 1 ? 'Yes' : 'No' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="is_access_issue_div"
                                            {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 0 ? 'style=display:none' : '' }}>
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Is Any Access Issue on
                                                        Site</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder is_any_access_issue">{{ isset($saleDetail->vie_is_any_access_issue) && $saleDetail->vie_is_any_access_issue == 1 ? 'Yes' : 'No' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Credit Score</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder credit_score">{{ $saleDetail->ebd_credit_score ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($verticalId == '2')
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Connection Type</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder property_type">{{ isset($saleDetail->journey_connection_type) && $saleDetail->journey_connection_type == 1 ? 'Personal' : 'Business' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Plan Type</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder property_type">{{ isset($saleDetail->journey_plan_type) && $saleDetail->journey_plan_type == 1 ? 'Sim' : 'Sim +  Mobile' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Price Filteration</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder property_type">{{ isset($saleDetail->journey_plan_cost_min) ? '$' . $saleDetail->journey_plan_cost_min : '' }}
                                                        -
                                                        {{ isset($saleDetail->journey_plan_cost_max) ? '$' . $saleDetail->journey_plan_cost_max : '' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($saleDetail->journey_plan_type) && $saleDetail->journey_plan_type == 2)
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Selected Device</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder property_type">{{ isset($handsetData['name']) ? ucwords($handsetData['name']) : 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Current Provider</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder">{{ $currentProvider->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($verticalId == 3)
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Connection Type</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span class="fw-bolder property_type">N/A</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Plan Name</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span class="fw-bolder property_type">N/A</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Total Plan Cost</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span class="fw-bolder property_type">N/A</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Property Type</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder property_type">{{ isset($saleDetail->journey_property_type) && $saleDetail->journey_property_type == 0 ? 'Residential' : 'Business' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Moving Property</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder property_type">{{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? 'Yes' : 'No' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Move In Date</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span
                                                        class="fw-bolder property_type">
                                                        {{ isset($saleDetail->sale_product_moving_at) ? dateTimeFormat($saleDetail->sale_product_moving_at) : 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                            <div class="row">
                                                <div class="col-md-6 text-muted">
                                                    <div class="d-flex align-items-center">Provider</div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span class="fw-bolder property_type">
                                                        @foreach ($providers as $provider)
                                                            @if (isset($saleDetail->sale_product_provider_id) && $saleDetail->sale_product_provider_id == $provider['id'])
                                                                {{ $provider['name'] }}
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->

            </div>
        </div>
        @if ($verticalId == '1')
            @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                <div class="d-flex flex-column flex-xl-row gap-7 py-5 gap-lg-10">
                    <div class="card col-md-4 card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Electricity Usage</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <div class="row">
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Distributor
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span class="fw-bolder elec_distributor">
                                                            @foreach ($distributors as $distributor)
                                                                @if (isset($saleDetail->sale_product_distributor_id) && $saleDetail->sale_product_distributor_id == $distributor['id'])
                                                                    {{ $distributor['name'] }}
                                                                    @php
                                                                        $elecDistributorId = $distributor['id'];
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Concession On Electricity
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ isset($saleDetail->journey_elec_concession_rebate_amount) ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Solar Panel
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder solar_panel">{{ isset($saleDetail->journey_solar_panel) && $saleDetail->journey_solar_panel == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Solar Panel Option
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder solar_options">{{ $saleDetail->journey_solar_options ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Peak Usage
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_peak_usage ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Off Peak
                                                            Usage</div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_off_peak_usage ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Shoulder
                                                            Usage</div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_shoulder_usage ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Usage Level
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_usage_level ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Bill
                                                            Available</div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span class="fw-bolder">
                                                            {{ $saleDetail->journey_bill_available ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Bill Amount
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_bill_amount ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Bill Period
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span class="fw-bolder">
                                                            {{ isset($saleDetail->ebd_bill_start_date) ? dateTimeFormat($saleDetail->ebd_bill_start_date) : 'N/A' }}
                                                            <span> To
                                                            </span>
                                                            {{ isset($saleDetail->ebd_bill_end_date) ? dateTimeFormat($saleDetail->ebd_bill_end_date) : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                                {{ isset($saleDetail->sale_product_meter_type_code) ? '' : 'style=display:none' }}
                                                id="elec_meter_type_code">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Electricity Meter Type
                                                            Code
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder elec_meter_type_code">{{ $saleDetail->sale_product_meter_type_code ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (isset($saleDetail->ebd_control_load_one_usage))
                                                <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                    <div class="row">
                                                        <div class="col-md-6 text-muted">
                                                            <div class="d-flex align-items-center">Control Load One
                                                                Usage
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <span
                                                                class="fw-bolder">{{ $saleDetail->ebd_control_load_one_usage ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (isset($saleDetail->ebd_control_load_two_usage))
                                                <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                    <div class="row">
                                                        <div class="col-md-6 text-muted">
                                                            <div class="d-flex align-items-center">Control Load Two
                                                                Usage
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <span
                                                                class="fw-bolder">{{ $saleDetail->ebd_control_load_two_usage ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                                {{ isset($saleDetail->ebd_control_load_one_off_peak) ? '' : 'style=display:none' }}
                                                id="control_load_one_off_peak">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Control Load One Off
                                                            Peak
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder control_load_one_off_peak">{{ $saleDetail->ebd_control_load_one_off_peak ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                                {{ isset($saleDetail->ebd_control_load_one_shoulder) ? '' : 'style=display:none' }}
                                                id="control_load_one_shoulder">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Control Load One
                                                            Shoulder
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder control_load_one_shoulder">{{ $saleDetail->ebd_control_load_one_shoulder ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                                {{ isset($saleDetail->ebd_control_load_two_off_peak) ? '' : 'style=display:none' }}
                                                id="control_load_two_off_peak">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Control Load Two Off
                                                            Peak
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder control_load_two_off_peak">{{ $saleDetail->ebd_control_load_two_off_peak ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                                {{ isset($saleDetail->ebd_control_load_two_shoulder) ? '' : 'style=display:none' }}
                                                id="control_load_two_shoulder">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Control Load Two
                                                            Shoulder
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder control_load_two_shoulder">{{ $saleDetail->ebd_control_load_two_shoulder ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
            @endif
            @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                <div class="d-flex flex-column flex-xl-row gap-7 py-5 gap-lg-10">
                    <div class="card col-md-4 card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Gas</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <div class="row">
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Distributor
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span class="fw-bolder gas_distributor">
                                                            @foreach ($distributors as $distributor)
                                                                @if (isset($saleDetail) && isset($gasSaleDetail))
                                                                    @if (isset($gasSaleDetail->sale_product_distributor_id) && $gasSaleDetail->sale_product_distributor_id == $distributor['id'])
                                                                        {{ $distributor['name'] }}
                                                                        @php
                                                                            $gasDistributorId = $distributor['id'];
                                                                        @endphp
                                                                    @endif
                                                                @elseif(isset($saleDetail))
                                                                    @if (isset($saleDetail->sale_product_distributor_id) && $saleDetail->sale_product_distributor_id == $distributor['id'])
                                                                        {{ $distributor['name'] }}
                                                                        @php
                                                                            $gasDistributorId = $distributor['id'];
                                                                        @endphp
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Concession On Gas
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ isset($saleDetail->journey_elec_concession_rebate_amount) || isset($saleDetail->journey_elec_concession_rebate_amount) ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Bills Available
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->journey_bill_available ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Bills Amount
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_bill_amount ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Bill Period
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">
                                                            {{ isset($saleDetail->ebd_bill_start_date) ? dateTimeFormat($saleDetail->ebd_bill_start_date) : 'N/A' }}
                                                            <span> To
                                                            </span>
                                                            {{ isset($saleDetail->ebd_bill_end_date) ? dateTimeFormat($saleDetail->ebd_bill_end_date) : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600"
                                                {{ isset($gasSaleDetail->sale_product_meter_type_code) || $saleDetail->sale_product_meter_type_code ? '' : 'style=display:none' }}
                                                id="gas_meter_type_code">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Meter Type Code
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder gas_meter_type_code">{{ $gasSaleDetail->sale_product_meter_type_code ?? $saleDetail->sale_product_meter_type_code }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Peak Usage
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_peak_usage ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Off Peak Usage
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_off_peak_usage ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                                                <div class="row">
                                                    <div class="col-md-6 text-muted">
                                                        <div class="d-flex align-items-center">Gas Usage Level
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span
                                                            class="fw-bolder">{{ $saleDetail->ebd_usage_level ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card body-->
                </div>
            @endif
        @endif
    </div>
    <div id="journey_edit" style="display: none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2> Customer Journey Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form role="form" name="customer_journey_form" id="customer_journey_form">
                        @csrf
                        <input type="hidden" name="leadId" value="">
                        <input type="hidden" name="visitorId" value={{ $saleDetail->l_visitor_id }}>
                        <input type="hidden" name="verticalId" value={{ $verticalId }}>
                        @if ($verticalId == 1)
                            @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                                <input type="hidden" name="electricityProductType"
                                    value={{ $saleDetail->sale_product_product_type }}>
                            @endif
                            @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                                <input type="hidden" name="gasProductType"
                                    value={{ $gasSaleDetail->sale_product_product_type ?? $saleDetail->sale_product_product_type }}>
                            @endif
                            <div class="row mb-5">
                                <div class="col-md-6 mb-6 text-gray-600">
                                    <div class="row">
                                        <!--begin::Label-->
                                        <label class="col-md-4 fw-bolder">Life Support</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-md-8">
                                            <label class="form-check form-check-inline form-check-solid mb-5">
                                                <input class="form-check-input life_support" name="life_support"
                                                    type="radio" value="1"
                                                    {{ isset($saleDetail->journey_life_support) && $saleDetail->journey_life_support == 1 ? 'checked' : '' }} />
                                                <span class="fw-bolder ps-2 fs-6">
                                                    Yes
                                                </span>
                                            </label>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid  mb-5">
                                                <input class="form-check-input life_support" name="life_support"
                                                    type="radio" value="0"
                                                    {{ isset($saleDetail->journey_life_support) && $saleDetail->journey_life_support == 0 ? 'checked' : '' }} />
                                                <span class="fw-bolder ps-2 fs-6">
                                                    No
                                                </span>
                                            </label>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <div class="col-md-6 mb-6 text-gray-600" id="life_support_equipment"
                                    {{ isset($saleDetail->journey_life_support) && $saleDetail->journey_life_support == 1 ? '' : 'style=display:none' }}>
                                    <div class="row">
                                        <!--begin::Label-->
                                        <label class="col-md-4 fw-bolder">Life Support Equipment</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-md-8">
                                            <select data-control="select2" class="form-select-solid form-select"
                                                id="medical_equipment_value" name="medical_equipment_value">
                                                <option value="" selected="selected">Select life support equipment
                                                </option>
                                                @foreach ($lifeSupportEquipments as $lifeSupportEquipment)
                                                    <option value="{{ $lifeSupportEquipment->title }}"
                                                        {{ isset($saleDetail->journey_life_support_value) && $saleDetail->journey_life_support_value == $lifeSupportEquipment->title ? 'selected' : '' }}>
                                                        {{ $lifeSupportEquipment->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                @if (isset($saleDetail) && isset($gasSaleDetail))
                                    <div class="col-md-6 mb-6 text-gray-600" id="life_support_fuel"
                                        {{ isset($saleDetail->journey_life_support) && $saleDetail->journey_life_support == 1 ? '' : 'style=display:none' }}>
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Life Support Fuel</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <select data-control="select2" class="form-select-solid form-select"
                                                    id="medical_equipment_energytype"
                                                    name="medical_equipment_energytype">
                                                    <option value="" selected="selected">Please select life support fuel
                                                    </option>
                                                    <option value="1"
                                                        {{ isset($saleDetail->journey_life_support_energy_type) && $saleDetail->journey_life_support_energy_type == 1 ? 'selected' : '' }}>
                                                        Electricity</option>
                                                    <option value="2"
                                                        {{ isset($saleDetail->journey_life_support_energy_type) && $saleDetail->journey_life_support_energy_type == 2 ? 'selected' : '' }}>
                                                        Gas</option>
                                                    <option value="3"
                                                        {{ isset($saleDetail->journey_life_support_energy_type) && $saleDetail->journey_life_support_energy_type == 3 ? 'selected' : '' }}>
                                                        Both</option>
                                                </select>
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-6 text-gray-600">
                                    <div class="row">
                                        <!--begin::Label-->
                                        <label class="col-md-4 fw-bolder">Move In</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-md-8">
                                            <label class="form-check form-check-inline form-check-solid mb-5">
                                                <input class="form-check-input move_in" name="move_in" type="radio"
                                                    value="1"
                                                    {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? 'checked' : '' }} />
                                                <span class="fw-bolder ps-2 fs-6">
                                                    Yes
                                                </span>
                                            </label>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <label class="form-check form-check-inline form-check-solid  mb-5">
                                                <input class="form-check-input move_in" name="move_in" type="radio"
                                                    value="0"
                                                    {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 0 ? 'checked' : '' }} />
                                                <span class="fw-bolder ps-2 fs-6">
                                                    No
                                                </span>
                                            </label>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                                    <div class="col-md-6 mb-6 text-gray-600" id="electricity_move_in"
                                        {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? '' : 'style=display:none' }}>
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Electricity Move In Date</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input
                                                    class="form-control form-control-solid rounded rounded-end-0 movin_date"
                                                    placeholder="Date" id="elec_movin_date" name="elec_movin_date"
                                                    value="{{ $saleDetail->sale_product_moving_at ?? '' }}">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                @endif
                                @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                                    <div class="col-md-6 mb-6 text-gray-600" id="gas_move_in"
                                        {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? '' : 'style=display:none' }}>
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Gas Move In Date</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input
                                                    class="form-control form-control-solid rounded rounded-end-0 movin_date"
                                                    placeholder="Date" id="gas_movin_date" name="gas_movin_date"
                                                    value="{{ $gasSaleDetail->sale_product_moving_at ?? $saleDetail->sale_product_moving_at }}">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-6 text-gray-600" id="move_in_time"
                                    {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? '' : 'style=display:none' }}>
                                    <div class="row">
                                        <!--begin::Label-->
                                        <label class="col-md-4 fw-bolder">Perferred Move In Time</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-md-8">
                                            <select data-control="select2" class="form-select-solid form-select"
                                                name="prefered_move_in_time" id="prefered_move_in_time">

                                                <option value="">None</option>
                                                <option value="8am - 1pm"
                                                    {{ isset($saleDetail->journey_prefered_move_in_time) && $saleDetail->journey_prefered_move_in_time == '8am - 1pm' ? 'selected' : '' }}>
                                                    8am - 1pm</option>
                                                <option value="9am - 2pm"
                                                    {{ isset($saleDetail->journey_prefered_move_in_time) && $saleDetail->journey_prefered_move_in_time == '9am - 2pm' ? 'selected' : '' }}>
                                                    9am - 2pm</option>
                                                <option value="10am - 3pm"
                                                    {{ isset($saleDetail->journey_prefered_move_in_time) && $saleDetail->journey_prefered_move_in_time == '10am - 3pm' ? 'selected' : '' }}>
                                                    10am - 3pm</option>
                                                <option value="11am - 4pm"
                                                    {{ isset($saleDetail->journey_prefered_move_in_time) && $saleDetail->journey_prefered_move_in_time == '11am - 4pm' ? 'selected' : '' }}>
                                                    11am - 4pm</option>
                                                <option value="12pm - 5pm"
                                                    {{ isset($saleDetail->journey_prefered_move_in_time) && $saleDetail->journey_prefered_move_in_time == '12pm - 5pm' ? 'selected' : '' }}>
                                                    12pm - 5pm</option>
                                                <option value="1pm - 6pm"
                                                    {{ isset($saleDetail->journey_prefered_move_in_time) && $saleDetail->journey_prefered_move_in_time == '1pm - 6pm' ? 'selected' : '' }}>
                                                    1pm - 6pm</option>
                                                <option value="8am - 11:59am"
                                                    {{ isset($saleDetail->journey_prefered_move_in_time) && $saleDetail->journey_prefered_move_in_time == '8am - 11:59am' ? 'selected' : '' }}>
                                                    8am - 11:59am</option>
                                                <option value="12pm-6pm"
                                                    {{ isset($saleDetail->journey_prefered_move_in_time) && $saleDetail->journey_prefered_move_in_time == '12pm-6pm' ? 'selected' : '' }}>
                                                    12pm-6pm</option>
                                            </select>
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Solar</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <label class="form-check form-check-inline form-check-solid mb-5">
                                                    <input class="form-check-input solar" name="solar" type="radio"
                                                        value="1"
                                                        {{ isset($saleDetail->journey_solar_panel) && $saleDetail->journey_solar_panel == 1 ? 'checked' : '' }} />
                                                    <span class="fw-bolder ps-2 fs-6">
                                                        Yes
                                                    </span>
                                                </label>
                                                <!--end::Option-->

                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid  mb-5">
                                                    <input class="form-check-input solar" name="solar" type="radio"
                                                        value="0"
                                                        {{ isset($saleDetail->journey_solar_panel) && $saleDetail->journey_solar_panel == 0 ? 'checked' : '' }} />
                                                    <span class="fw-bolder ps-2 fs-6">
                                                        No
                                                    </span>
                                                </label>
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600" id="elec_provider"
                                        {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 0 ? '' : 'style=display:none' }}>
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Electricity Provider</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <select data-control="select2" class="form-select-solid form-select"
                                                    name="elec_provider" id="electricity_provider">
                                                    <option value="">Select Provider</option>
                                                    @foreach ($providers as $provider)
                                                        <option value='{{ $provider['id'] }}'
                                                            {{ isset($elecProviderId) && $elecProviderId == $provider['id'] ? 'selected' : '' }}>
                                                            {{ $provider['legal_name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Electricity Meter Type Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input class="form-control" id="meter_type_code"
                                                    name="elec_meter_type_code" type="text"
                                                    value="{{ $saleDetail->sale_product_meter_type_code ?? '' }}">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600" style="display:none">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Electricity Account Number</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input class="form-control" id="elec_account_number"
                                                    name="elec_account_number" type="text" value="">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Electricity Distributor</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <select data-control="select2" class="form-select-solid form-select"
                                                    name="elec_distributor" id="electricity_distributor_id">
                                                    <option value="">Select Distributor</option>
                                                    @foreach ($distributors as $distributor)
                                                        @if ($distributor['energy_type'] == 1 || $distributor['energy_type'] == 3)
                                                            <option value={{ $distributor['id'] }}
                                                                {{ isset($elecDistributorId) && $elecDistributorId == $distributor['id'] ? 'selected' : '' }}>
                                                                {{ $distributor['name'] }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600" id="solar_type"
                                        {{ isset($saleDetail->journey_solar_panel) && $saleDetail->journey_solar_panel == 0 ? 'style=display:none' : '' }}>
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Solar Tarrif Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <select data-control="select2" class="form-select-solid form-select"
                                                    id="solar_tarriff_type" name="solar_tarriff_type">
                                                    <option value="">Please select Solar tariff Type</option>
                                                    <option value="Normal"
                                                        {{ isset($saleDetail->journey_solar_options) && $saleDetail->journey_solar_options == 'Normal' ? 'selected' : '' }}>
                                                        Normal</option>
                                                    <option value="Premium"
                                                        {{ isset($saleDetail->journey_solar_options) && $saleDetail->journey_solar_options == 'Premium' ? 'selected' : '' }}>
                                                        Premium</option>
                                                </select>
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Control Load One Off Peak</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input class="form-control" id="control_load_one_off_peak"
                                                    name="control_load_one_off_peak" type="text"
                                                    value="{{ $saleDetail->ebd_control_load_one_off_peak ?? '' }}">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Control Load One Shoulder</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input class="form-control" id="control_load_one_shoulder"
                                                    name="control_load_one_shoulder" type="text"
                                                    value="{{ $saleDetail->ebd_control_load_one_shoulder ?? '' }}">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Control Load Two Off Peak</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input class="form-control" id="control_load_two_off_peak"
                                                    name="control_load_two_off_peak" type="text"
                                                    value="{{ $saleDetail->ebd_control_load_two_off_peak ?? '' }}">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Control Load Two Shoulder</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input class="form-control" id="control_load_two_shoulder"
                                                    name="control_load_two_shoulder" type="text"
                                                    value="{{ $saleDetail->ebd_control_load_two_shoulder ?? '' }}">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                @endif
                                @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                                    <div class="col-md-6 mb-6 text-gray-600" id="gas_provider_show"
                                        {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 0 ? '' : 'style=display:none' }}>
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Gas Provider</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <select data-control="select2" class="form-select-solid form-select"
                                                    name="gas_provider" id="gas_provider">
                                                    <option value="">Select Provider</option>
                                                    @foreach ($providers as $provider)
                                                        <option value={{ $provider['id'] }}
                                                            {{ isset($gasProviderId) && $gasProviderId == $provider['id'] ? 'selected' : '' }}>
                                                            {{ $provider['legal_name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Gas Meter Type Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input class="form-control" id="meter_type_code"
                                                    name="gas_meter_type_code" type="text"
                                                    value="{{ $saleDetail->sale_product_meter_type_code ?? '' }}">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600" style="display:none">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Gas Account Number</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <input class="form-control" id="gas_account_number"
                                                    name="gas_account_number" type="text" value="">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6 text-gray-600">
                                        <div class="row">
                                            <!--begin::Label-->
                                            <label class="col-md-4 fw-bolder">Gas Distributor</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="col-md-8">
                                                <select data-control="select2" class="form-select-solid form-select"
                                                    name="gas_distributor" id="gas_distributor_id">
                                                    <option value="">Select Distributor</option>
                                                    @foreach ($distributors as $distributor)
                                                        @if ($distributor['energy_type'] == 2 || $distributor['energy_type'] == 3)
                                                            <option value={{ $distributor['id'] }}
                                                                {{ isset($gasDistributorId) && $gasDistributorId == $distributor['id'] ? 'selected' : '' }}>
                                                                {{ $distributor['name'] }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="error text-danger"></span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-6 text-gray-600" id="is_access_issue"
                                    {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? '' : 'style=display:none' }}>
                                    <div class="row">
                                        <!--begin::Label-->
                                        <label class="col-md-4 fw-bolder">Is Any Access Issue on Site</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-8 fv-row">
                                            <div
                                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input sweetalert_demo" type="checkbox"
                                                    name="is_any_access_issue"
                                                    {{ isset($saleDetail->vie_is_any_access_issue) && $saleDetail->vie_is_any_access_issue == 1 ? 'checked' : '' }}>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-6 text-gray-600" id="is_electric_work"
                                    {{ isset($saleDetail->journey_moving_house) && $saleDetail->journey_moving_house == 1 ? '' : 'style=display:none' }}>
                                    <div class="row">
                                        <!--begin::Label-->
                                        <label class="col-md-4 fw-bolder">Is Electrical Work is going on at site</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-8 fv-row">
                                            <div
                                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input sweetalert_demo" type="checkbox"
                                                    name="is_elec_work"
                                                    {{ isset($saleDetail->vie_is_elec_work) && $saleDetail->vie_is_elec_work == 1 ? 'checked' : '' }}>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <span class="error text-danger"></span>
                                        <!--end::Option-->
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <div class="col-md-6 mb-6 text-gray-600">
                                    <div class="row">
                                        <!--begin::Label-->
                                        <label class="col-md-4 fw-bolder">Credit Score</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-md-8">
                                            <input class="form-control" id="credit_score" name="credit_score"
                                                type="text" value="{{ $saleDetail->ebd_credit_score ?? '' }}">
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row mb-6 text-gray-600">
                            <label class="col-lg-2 fw-bolder">Comment :</label>
                            <div class="col-lg-10 fv-row">
                                <textarea class="form-control" rows="2" name="comment"></textarea>
                                <span class="help-block fw-bolder">Give your comment for this updation. </span>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2 close_section"
                                data-initial="journey_edit" data-for="journey_show">Cancel</a>
                            <button type="submit" class="update_journey_button" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <div id="journey_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Journey</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="journey_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="journey_history" data-for="journey_show">{{ __('buttons.close') }}</a>
                </div>

                <!--end::Documents-->
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="show_journey_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Customer Journey Update History</h2>
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
                    <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                        <div class="row">
                            <div class="col-md-6 text-muted">
                                <div class="d-flex align-items-center">Life Support</div>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="fw-bolder life_support_history"></span>
                            </div>
                        </div>
                    </div>
                    @if (isset($saleDetail) && isset($gasSaleDetail))
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="life_support_fuel_div">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Life Support Fuel</div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder life_support_fuel_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="life_support_equipment_div">
                        <div class="row">
                            <div class="col-md-6 text-muted">
                                <div class="d-flex align-items-center">Life Support Equipment
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="fw-bolder life_support_equipment_history"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                        <div class="row">
                            <div class="col-md-6 text-muted">
                                <div class="d-flex align-items-center">Moving Property</div>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="fw-bolder moving_property_history"></span>
                            </div>
                        </div>
                    </div>
                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="elec_movin_div_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Electricity Moving
                                        Date</div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder elec_moving_date_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="gas_movin_div_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Gas Moving Date</div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder gas_moving_date_history"></span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="movin_time_div_history">
                        <div class="row">
                            <div class="col-md-6 text-muted">
                                <div class="d-flex align-items-center">Perferred Move-In Time
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="fw-bolder prefered_movin_time_history"></span>
                            </div>
                        </div>
                    </div>
                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="elec_provider_div_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Current
                                        Electricity Provider</div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder elec_provider_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="gas_provider_div_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Current Gas Provider
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder gas_provider_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="is_elec_work_div_history">
                        <div class="row">
                            <div class="col-md-6 text-muted">
                                <div class="d-flex align-items-center">Is Electrical Work is
                                    going on at site</div>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="fw-bolder is_elec_work_history">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="is_access_issue_div_history">
                        <div class="row">
                            <div class="col-md-6 text-muted">
                                <div class="d-flex align-items-center">Is Any Access Issue on
                                    Site</div>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="fw-bolder is_any_access_issue_history"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                        <div class="row">
                            <div class="col-md-6 text-muted">
                                <div class="d-flex align-items-center">Credit Score</div>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="fw-bolder credit_score_history"></span>
                            </div>
                        </div>
                    </div>
                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Electricity Distributor
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder elec_distributor_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="control_load_one_off_peak_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Control Load One Off
                                        Peak
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder control_load_one_off_peak_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="control_load_one_shoulder_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Control Load One
                                        Shoulder
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder control_load_one_shoulder_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="control_load_two_off_peak_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Control Load Two Off
                                        Peak
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder control_load_two_off_peak_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="control_load_two_shoulder_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Control Load Two
                                        Shoulder
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder control_load_two_shoulder_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="elec_meter_type_code_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Electricity Meter Type
                                        Code
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder elec_meter_type_code_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Gas Distributor
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder gas_distributor_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-10 px-5 fw-bold text-gray-600" id="gas_meter_type_code_history">
                            <div class="row">
                                <div class="col-md-6 text-muted">
                                    <div class="d-flex align-items-center">Gas Meter Type Code
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="fw-bolder gas_meter_type_code_history">
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
