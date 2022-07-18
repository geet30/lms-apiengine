<div class="tab-pane fade show py-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Handset Info</h2>
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
                                            <div class="d-flex align-items-center">Handset Selected:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($handsetData['name']) ? ucwords($handsetData['name']) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Variant Selected:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($handsetData['variant_name']) ? ucwords($handsetData['variant_name']) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Variant Color Name:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($handsetData['color']) ? ucwords($handsetData['color']) : 'N/A' }}
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
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Variant Capacity:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($handsetData['capacity']) ? $handsetData['capacity'].' GB' : '--' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Internal Storage:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($handsetData['internal_storage']) ? $handsetData['internal_storage'].' GB' : '--' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Contract Selected:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($contract->validity) ? $contract->validity.' Months' : '--' }}
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
