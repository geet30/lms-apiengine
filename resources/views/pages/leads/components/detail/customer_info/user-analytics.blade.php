<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 mb-3 gap-lg-10">
        <!--begin::Order details-->
        <div class="card col-md-4 card-flush py-4 flex-row-fluid overflow-hidden">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>User Analytics</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Browser</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->si_browser ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Platform</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->si_platform ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Device Type</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ $saleDetail->si_device ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Screen Resolution</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ $saleDetail->si_screen_resolution ?? 'N/A' }}
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
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">IP</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->si_ip_address ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    @switch($saleType)
                                        @case('visits')
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Visit Date</div>
                                            </td>
                                            <td class="fw-bolder text-end">{{ isset($saleDetail->l_created_at) ? dateTimeFormat($saleDetail->l_created_at) :'N/A' }}
                                            </td>
                                        </tr>
                                            @break
                                        @case('leads')
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Lead Date</div>
                                            </td>
                                            <td class="fw-bolder text-end">{{ isset($saleDetail->sale_created_at) ? dateTimeFormat($saleDetail->sale_created_at) :'N/A' }}
                                            </td>
                                        </tr>
                                            @break
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Sale Date</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ isset($saleDetail->sale_product_sale_created_at) ? dateTimeFormat($saleDetail->sale_product_sale_created_at) :'N/A' }}
                                                </td>
                                            </tr>
                                        @default

                                    @endswitch
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Latitude</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ $saleDetail->si_latitude ?? 0 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Longitude</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ $saleDetail->si_longitude ?? 0 }}
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
            <!--end::Card body-->
        </div>
    </div>
</div>
