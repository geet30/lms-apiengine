<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>API Responses</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5" id="kt_ecommerce_sales_table">
                        <thead class="fw-bold text-gray-600">
                            <tr>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">S No.</th>
                                <th class="min-w-175px text-muted text-capitalize text-nowrap">API Name</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">API Reference Number</th>
                                <th class="min-w-70px text-muted text-capitalize text-nowrap">API Status</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Created at</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bolder text-gray-600">
                            <?php $inc = 1; ?>
                            @if(isset($apiResponses) && count($apiResponses) > 0)
                            @foreach ($apiResponses as $apiResponse)
                                <tr>
                                    <td>{{ $inc }}</td>
                                    <td>{{ $apiResponse->api_name }}</td>
                                    <td>{{ $apiResponse->dialler_api_reference_no }}</td>
                                    <td>N/A
                                    </td>
                                    <td>{{ dateTimeFormat($apiResponse->created_at) }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="font-weight-bold mr-2 view_api_response"
                                            name="view" title="View api response"
                                            data-header="{{ $apiResponse->header_data }}"
                                            data-request="{{ $apiResponse->api_request }}"
                                            data-response="{{ $apiResponse->api_response }}">View</a>
                                    </td>
                                </tr>
                                <?php $inc++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                            </tr>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@if($verticalId == 1)
<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Sale Submission API Responses</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5" id="kt_ecommerce_sales_table">
                        <thead class="fw-bold text-gray-600">
                            <tr>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">S No.</th>
                                <th class="min-w-175px text-muted text-capitalize text-nowrap">API Name</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">API Reference Number</th>
                                <th class="min-w-70px text-muted text-capitalize text-nowrap">API Status</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Created dt</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bolder text-gray-600">
                            <?php $inc = 1; ?>
                            @if(isset($saleSubmissionResponse) && count($saleSubmissionResponse) > 0)
                            @foreach ($saleSubmissionResponse as $apiResponse)
                                <tr>
                                    <td>{{ $inc }}</td>
                                    <td>{{ $apiResponse->api_name }}</td>
                                    <td>{{ $apiResponse->api_reference }}</td>
                                    <td>N/A
                                    </td>
                                    <td>{{ dateTimeFormat($apiResponse->created_at) }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="font-weight-bold mr-2 view_api_response"
                                            name="view" title="View api response"
                                            data-header="{{ $apiResponse->header_data }}"
                                            data-request="{{ $apiResponse->api_request }}"
                                            data-response="{{ $apiResponse->api_response }}">View</a>
                                    </td>
                                </tr>
                                <?php $inc++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                            </tr>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>SMS Logs</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5" id="kt_ecommerce_sales_table">
                        <thead class="fw-bold text-gray-600">
                            <tr>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">S No.</th>
                                <th class="min-w-175px text-muted text-capitalize text-nowrap">API Name</th>
                                <th class="min-w-70px text-muted text-capitalize text-nowrap">API Status</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Created dt</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bolder text-gray-600">
                            <?php $inc = 1; ?>
                            @if(isset($smsLogs) && count($smsLogs) > 0)
                            @foreach ($smsLogs as $smsLog)
                                <tr>
                                    <td>{{ $inc }}</td>
                                    <td>{{ $smsLog->api_name }}</td>
                                    <td>{{ $smsLog->api_status }}
                                    </td>
                                    <td>{{ dateTimeFormat($smsLog->created_at) }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="font-weight-bold mr-2 view_api_response"
                                            name="view" title="View api response"
                                            data-request="{{ decryptGdprData($smsLog->api_request) }}"
                                            data-response="{{ decryptGdprData($smsLog->api_response) }}">View</a>
                                    </td>
                                </tr>
                                <?php $inc++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                            </tr>
                                @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Send Email Logs</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5" id="kt_ecommerce_sales_table">
                        <thead class="fw-bold text-gray-600">
                            <tr>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">S No.</th>
                                <th class="min-w-175px text-muted text-capitalize text-nowrap">API Name</th>
                                <th class="min-w-70px text-muted text-capitalize text-nowrap">API Status</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Created dt</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bolder text-gray-600">
                            <?php $inc = 1; ?>
                            @if(isset($sendEmailLogs) && count($sendEmailLogs) > 0)
                            @foreach ($sendEmailLogs as $sendEmailLog)
                                <tr>
                                    <td>{{ $inc }}</td>
                                    <td>{{ $sendEmailLog->api_name }}</td>
                                    <td>{{ $sendEmailLog->api_status }}
                                    </td>
                                    <td>{{ dateTimeFormat($sendEmailLog->created_at) }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="font-weight-bold mr-2 view_api_response"
                                            name="view" title="View api response"
                                            data-request="{{ decryptGdprData($sendEmailLog->api_request) }}"
                                            data-response="{{ $sendEmailLog->api_response }}">View</a>
                                    </td>
                                </tr>
                                <?php $inc++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                            </tr>
                                @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>TokenEx Logs</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5" id="kt_ecommerce_sales_table">
                        <thead class="fw-bold text-gray-600">
                            <tr>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">S No.</th>
                                <th class="min-w-175px text-muted text-capitalize text-nowrap">API Name</th>
                                <th class="min-w-70px text-muted text-capitalize text-nowrap">API Status</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Created dt</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bolder text-gray-600">
                            <?php $inc = 1; ?>
                            @if(isset($tokenExLogs) && count($tokenExLogs) > 0)
                            @foreach ($tokenExLogs as $tokenExLog)
                                <tr>
                                    <td>{{ $inc }}</td>
                                    <td>{{ $tokenExLog->api_name }}</td>
                                    <td>{{ $tokenExLog->api_status }}
                                    </td>
                                    <td>{{ dateTimeFormat($tokenExLog->created_at) }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="font-weight-bold mr-2 view_api_response"
                                            name="view" title="View api response"
                                            data-request="{{ decryptGdprData($tokenExLog->api_request) }}"
                                            data-response="{{ decryptGdprData($tokenExLog->api_response) }}">View</a>
                                    </td>
                                </tr>
                                <?php $inc++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                            </tr>
                                @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
