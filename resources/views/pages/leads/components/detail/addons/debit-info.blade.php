<div class="tab-pane fade show py-5" role="tab-panel">
    <!--begin::Order details-->
    <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Credit/Debit Information</h2>
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
                                            <div class="d-flex align-items-center">Timestamp Used:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ isset($visitorDebitInfo->timestamp_used) && $visitorDebitInfo->timestamp_used != '' ? $visitorDebitInfo->timestamp_used : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Name On Card:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($visitorDebitInfo->name_on_card) && $visitorDebitInfo->name_on_card !='' ? ucwords(setTokenexDecryptData($visitorDebitInfo->name_on_card)) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">First Six Digit:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($visitorDebitInfo->first_six) && $visitorDebitInfo->first_six !='' ? ucwords(setTokenexDecryptData($visitorDebitInfo->first_six)) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Last Four Digit:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($visitorDebitInfo->last_four) && $visitorDebitInfo->last_four !='' ? setTokenexDecryptData($visitorDebitInfo->last_four) : 'N/A' }}
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
                                            <div class="d-flex align-items-center">Exp Month(s):</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ isset($visitorDebitInfo->exp_month) && $visitorDebitInfo->exp_month !='' ? setTokenexDecryptData($visitorDebitInfo->exp_month) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Exp Year(s):</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ isset($visitorDebitInfo->exp_year) && $visitorDebitInfo->exp_year !='' ? setTokenexDecryptData($visitorDebitInfo->exp_year) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Card Type:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ isset($visitorDebitInfo->card_type) && $visitorDebitInfo->card_type !='' ? ucwords(setTokenexDecryptData($visitorDebitInfo->card_type)) : 'N/A' }}
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
                                    @endif
                                    @if($saleType == 'leads')
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Lead Id:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            {{ $saleDetail->l_lead_id ?? 'N/A' }}
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
