<div class="tab-pane fade show py-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Connection Details</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Connection Request Type :</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            @if(isset($connectionDetails))
                                            @switch($connectionDetails->connection_request_type)
                                                @case(1)
                                                    New Connection
                                                    @break
                                                @case(2)
                                                   Port In
                                                    @break
                                                @case(3)
                                                   Re Contract
                                                    @break
                                                @default
                                                New Connection
                                            @endswitch
                                            @endif
                                        </td>
                                    </tr>
                                    @if($connectionDetails->connection_request_type == 2 || $connectionDetails->connection_request_type == 3)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Current Provider :</div>
                                        </td>
                                        <td class="fw-bolder text-end">@if(isset($connectionDetails))
                                            @switch($connectionDetails->connection_request_type)
                                                @case(2)
                                                    {{ $connectionDetails->current_provider ?? 'N/A' }}
                                                    @break
                                                @case(3)
                                                {{ isset($connectionDetails->current_provider) ? ucfirst(decryptGdprData($connectionDetails->current_provider)):'N/A' }}
                                                    @break
                                            @endswitch
                                            @endif
                                        </td>
                                    </tr>
                                    @if($connectionDetails->connection_request_type == 2)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Transfer to Provider :</div>
                                        </td>
                                        <td class="fw-bolder text-end"> {{ isset($connectionDetails->transfer_to_provider) ? ucfirst(decryptGdprData($connectionDetails->transfer_to_provider)):'N/A' }}
                                        </td>
                                    </tr>
                                    @endif
                                    @if($connectionDetails->connection_request_type == 3)
                                     <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Existing Connection A/C :</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($connectionDetails->connection_account_no) ? $connectionDetails->connection_account_no : 'N/A' }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endif
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
                                    @if($connectionDetails->connection_request_type == 2 || $connectionDetails->connection_request_type == 3)
                                    @if($connectionDetails->connection_request_type == 2)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Port Verify Method :</div>
                                        </td>
                                        <td class="fw-bolder text-end">Mobile OTP
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Existing Connection A/c or DOB :</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $connectionDetails->connection_account_no ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    @endif
                                    @if($connectionDetails->connection_request_type == 3)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Existing Lease Plan or Not :</div>
                                        <td class="fw-bolder text-end">{{ isset($connectionDetails->conn_is_lease) && $connectionDetails->conn_is_lease == 1 ? 'Yes':'No' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Lease Start Date :</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $connectionDetails->conn_renew_lease_start_date ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endif
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
