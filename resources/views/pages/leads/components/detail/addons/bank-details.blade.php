<div class="tab-pane fade show py-5" role="tab-panel">
    <!--begin::Order details-->
    <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Direct Debit Detail</h2>
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
                                            <div class="d-flex align-items-center">Payment Type:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            Bank Information
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Bank Name:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($visitorBankInfo->bank_name) ? ucwords(decryptBankDetail($visitorBankInfo->bank_name)) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Name On Account:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($visitorBankInfo->name_on_account) ? ucwords(decryptBankDetail($visitorBankInfo->name_on_account)) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">BSB Number:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($visitorBankInfo->bsb) ? decryptBankDetail($visitorBankInfo->bsb) : 'N/A' }}
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
                                            <div class="d-flex align-items-center">Branch Name:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ isset($visitorBankInfo->branch_name) ? ucwords(decryptBankDetail($visitorBankInfo->branch_name)) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Account Number:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ isset($visitorBankInfo->account_number) ? decryptBankDetail($visitorBankInfo->account_number) : 'N/A' }}
                                        </td>
                                    </tr>
                                    @if($saleType == 'sales')
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Sale Id:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ $saleDetail->sale_product_id ?? 'N/A' }}
                                        </td>
                                    </tr>

                                    <!-- <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Reference Number:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{-- $saleDetail->sale_product_reference_no ?? 'N/A' --}}
                                        </td>
                                    </tr>
                                    @endif
                                    @if($saleType == 'leads')
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Lead Id:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{-- $saleDetail->l_lead_id ?? 'N/A' --}}
                                        </td>
                                    </tr>
                                    @endif

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>

                    </div>

                </div>
                @if( $saleType == 'sales' && checkPermission('sale_detokenization_button',$userPermissions,$appPermissions) || $saleType == 'leads' && checkPermission('lead_detokenization_button',$userPermissions,$appPermissions))

                <div class="row mt-5">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter" id="apply_lead_filters">Detokenization</button>
                    </div>
                </div>
                @endif
            </div>
            <!--end::Card body-->
        </div>
    </div>

</div>
