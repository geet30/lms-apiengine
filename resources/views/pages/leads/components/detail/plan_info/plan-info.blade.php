<div class="tab-pane fade show py-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Plan Information</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                @if ($verticalId == 1)
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="col-md-3">
                                <span class="text-dark fw-bolder fs-6">{{ __('sale_detail.electricity') }}:</span>
                            </div>
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Provider Name:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                @foreach ($providers as $provider)
                                                @if(isset($saleDetail->sale_product_provider_id) && $saleDetail->sale_product_provider_id == $provider['user_id'])
                                               {{ $provider['legal_name'] }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Name:</div>
                                            </td>
                                            <td class="fw-bolder text-end">{{ $saleDetail->name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Desc:</div>
                                            </td>
                                            <td class="fw-bolder text-end">

                                                {{ $saleDetail->plan_plan_desc ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Compaign Code:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ $saleDetail->plan_compaign_code ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Distributor:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                Ausgrid
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Bundle Code:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ $saleDetail->plan_bundle_code ?? 'N/A' }}
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
                            <div class="col-md-3">
                                <span class="text-dark fw-bolder fs-6">{{ __('sale_detail.gas') }}:</span>
                            </div>
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Provider Name:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                @foreach ($providers as $provider)
                                                @if(isset($saleDetail->sale_product_provider_id) && $saleDetail->sale_product_provider_id == $provider['user_id'])
                                               {{ $provider['legal_name'] }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Name:</div>
                                            </td>
                                            <td class="fw-bolder text-end">{{ $saleDetail->name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Desc:</div>
                                            </td>
                                            <td class="fw-bolder text-end">

                                                {{ $saleDetail->plan_plan_desc ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Compaign Code:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ $saleDetail->plan_compaign_code ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Distributor:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                Ausgrid
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Bundle Code:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ $saleDetail->plan_bundle_code ?? 'N/A' }}
                                            </td>
                                        </tr>

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>

                    </div>
                @elseif($verticalId == 2)
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Name:</div>
                                            </td>
                                            <td class="fw-bolder text-end">{{ $saleDetail->plan_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Provider:</div>
                                            </td>
                                            <td class="fw-bolder text-end text-wrap">
                                                @foreach ($providers as $provider)
                                                @if(isset($saleDetail->sale_product_provider_id) && $saleDetail->sale_product_provider_id == $provider['user_id'])
                                               {{ $provider['legal_name'] }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Connection Type:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ isset($saleDetail->journey_connection_type) && $saleDetail->journey_connection_type == 1 ? 'Personal':'Business' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Type:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ isset($saleDetail->journey_plan_type) && $saleDetail->journey_plan_type == 1 ? 'Sim':'Sim +  Mobile' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Sim Type:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                @if(isset($saleDetail->sale_product_sim_type))
                                                @switch($saleDetail->sale_product_sim_type)
                                                    @case(1)
                                                        Physical Sim
                                                        @break
                                                    @case(2)
                                                        E Sim
                                                        @break
                                                    @case(3)
                                                        Both
                                                        @break
                                                    @default
                                                       N/A
                                                @endswitch
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Network Type:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ $saleDetail->sale_product_plan_network_type ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Cost:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ isset($saleDetail->sale_product_cost) ? '$'.$saleDetail->sale_product_cost : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Data Per Month:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                @if(isset($saleDetail->sale_product_plan_data_unit))
                                                @switch($saleDetail->sale_product_plan_data_unit)
                                                    @case(1)
                                                        @php
                                                            $dataUnit = 'MB'
                                                        @endphp
                                                        @break
                                                    @case(2)
                                                        @php
                                                            $dataUnit = 'GB'
                                                        @endphp
                                                        @break
                                                    @case(3)
                                                        @php
                                                            $dataUnit = 'TB'
                                                        @endphp
                                                        @break
                                                    @default
                                                    @php
                                                    $dataUnit = ''
                                                @endphp
                                                @endswitch
                                                @endif
                                                {{ isset($saleDetail->sale_product_plan_data_per_month) ? $saleDetail->sale_product_plan_data_per_month.' '.$dataUnit : '--' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Duration:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ $saleDetail->sale_product_plan_duration ?? '0' }} Months
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Activation
                                                    Date:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ isset($saleDetail->sale_product_plan_activation_date) ? dateTimeFormat($saleDetail->sale_product_plan_activation_date) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Plan Deactivation
                                                    Date:</div>
                                            </td>
                                            <td class="fw-bolder text-end">
                                                {{ isset($saleDetail->sale_product_plan_deactivation_date) ? dateTimeFormat($saleDetail->sale_product_plan_deactivation_date) : 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Amazing Extra Facilities:</div>
                                            </td>
                                            <td class="fw-bolder justify-content-end text-justify">
                                                {!! $saleDetail->plan_amazing_extra_facilities ?? 'N/A' !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Inclusion:</div>
                                            </td>
                                            <td class="fw-bolder justify-content-end text-justify">
                                                {!! $saleDetail->plan_inclusion ?? 'N/A' !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
