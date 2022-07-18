<div class="tab-pane fade mb-5 show {{ isset($saleType) && $saleType == 'visits' ? 'active' : '' }}" id="stage"
    role="tab-panel">
    <!--begin::Order details-->
    <div id="stage_show">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Stage</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="" class="fw-bolder text-primary update_section float-end" data-for="stage_edit"
                            data-lead_id={{ $saleDetail->l_lead_id }} data-initial="stage_show"><i
                                class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @if ($saleType == 'leads' || $saleType == 'sales')
                        <div class="row">
                            <!-- left side -->
                            <div class="col-md-6 px-5">
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Source</div>
                                                </td>
                                                <td class="fw-bolder text-end source_td">
                                                    @if (isset($saleDetail->l_visitor_source))
                                                        @switch($saleDetail->l_visitor_source)
                                                            @case(1)
                                                                API
                                                            @break
                                                            @case(2)
                                                                Agent
                                                            @break
                                                            @case(3)
                                                                Manual
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($saleType == 'sales')
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">Completed By</div>
                                                    </td>
                                                    <td class="fw-bolder text-end sale_completed_by_td">
                                                        @if (isset($saleDetail->sale_product_sale_completed_by))
                                                            @switch($saleDetail->sale_product_sale_completed_by)
                                                                @case(1)
                                                                    Customer
                                                                @break
                                                                @case(2)
                                                                    Agent
                                                                @break
                                                                @case(3)
                                                                    Agent Assisted
                                                                @break
                                                            @endswitch
                                                            @else
                                                            Customer
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($verticalId == 1)
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">SMS</div>
                                                    </td>
                                                    <td class="fw-bolder text-end sms_td">
                                                        {{ isset($unsubscribesData) && $unsubscribesData->email_unsubscribe == 1 ? 'Opt-Out' : 'Opt-In' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">Email</div>
                                                    </td>
                                                    <td class="fw-bolder text-end email_td">
                                                        {{ isset($unsubscribesData) && $unsubscribesData->sms_unsubscribe == 1 ? 'Opt-Out' : 'Opt-In' }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($verticalId == 2 || $verticalId == 3)
                                                @if (isset($saleDetail->l_sub_affiliate_id))
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">RC</div>
                                                        </td>
                                                        <td class="fw-bolder text-end">
                                                            {{ $saleDetail->l_referal_code ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($saleType == 'leads')
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Lead Duplicate</div>
                                                        </td>
                                                        <td class="fw-bolder text-end">
                                                            {{ isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 1 ? 'Yes' : 'No' }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($saleType == 'sales')
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Sale Duplicate</div>
                                                        </td>
                                                        <td class="fw-bolder text-end sale_duplicate_td">
                                                            {{ isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 1 ? 'Yes' : 'No' }}
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
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Lead Id</div>
                                                </td>
                                                <td class="fw-bolder text-end sale_ip_td">
                                                    {{ $saleDetail->sale_product_lead_id ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            @if ($saleType == 'sales')
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">Sale Product Id</div>
                                                    </td>
                                                    <td class="fw-bolder text-end sale_ip_td">
                                                        {{ $saleDetail->sale_product_id ?? 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($saleType == 'sales')
                                                @if ($verticalId == 1)
                                                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">Electricity
                                                                    Reference
                                                                    Number</div>
                                                            </td>
                                                            <td
                                                                class="fw-bolder text-end electricity_reference_number_td">
                                                                {{ $saleDetail->sale_product_reference_no ?? 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                                                        <tr>
                                                            <td class="text-muted">
                                                                <div class="d-flex align-items-center">Gas Reference
                                                                    Number
                                                                </div>
                                                            </td>
                                                            <td class="fw-bolder text-end gas_reference_number_td">
                                                                {{ $gasSaleDetail->sale_product_reference_no ?? $saleDetail->sale_product_reference_no }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @else
                                                    <tr>
                                                        <td class="text-muted">
                                                            <div class="d-flex align-items-center">Reference Number
                                                            </div>
                                                        </td>
                                                        <td class="fw-bolder text-end gas_reference_number_td">
                                                            {{ $saleDetail->sale_product_reference_no ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if ($saleType == 'leads')
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">Lead Create Date</div>
                                                    </td>
                                                    <td class="fw-bolder text-end sale_create_date_td">
                                                        {{ isset($saleDetail->sale_created_at) ? dateTimeFormat($saleDetail->sale_created_at) : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @elseif ($saleType == 'sales')
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">Sale Create Date</div>
                                                    </td>
                                                    <td class="fw-bolder text-end sale_create_date_td">
                                                        {{ isset($saleDetail->sale_product_sale_created_at) ? dateTimeFormat($saleDetail->sale_product_sale_created_at) : 'N/A' }}
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
                    @elseif($saleType == 'visits')
                        <div class="row">
                            <!-- left side -->
                            <div class="col-md-6 px-5">
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">Source</div>
                                                </td>
                                                <td class="fw-bolder text-end source_td">
                                                    @if (isset($saleDetail->l_visitor_source))
                                                        @switch($saleDetail->l_visitor_source)
                                                            @case(1)
                                                                API
                                                            @break
                                                            @case(2)
                                                                Agent
                                                            @break
                                                            @case(3)
                                                                Manual
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </td>
                                            </tr>
                                            @if (isset($saleDetail->l_sub_affiliate_id))
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex text-nowrap align-items-center">RC</div>
                                                    </td>
                                                    <td class="fw-bolder text-end">
                                                        {{ $saleDetail->l_referal_code ?? 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Source</div>
                                                </td>
                                                <td class="fw-bolder text-end">
                                                    {{ $saleDetail->m_utm_source ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Medium</div>
                                                </td>
                                                <td class="fw-bolder text-end">
                                                    {{ $saleDetail->m_utm_medium ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Compaign</div>
                                                </td>
                                                <td class="fw-bolder text-end">
                                                    {{ $saleDetail->m_utm_campaign ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM RM Source</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_rm_source ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM RM</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_rm ?? 'N/A' }}
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
                                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5" style="/*overflow:scroll;*/word-break: break-all;">
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM RM Source</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_rm_source ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Term</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_term ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Content</div>
                                                </td>
                                                <td class="fw-bolder text-end">
                                                    {{ $saleDetail->m_utm_content ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">GClid</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_gclid ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">FBClid</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_fbclid ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">MCVID</div>
                                                </td>
                                                <td class="fw-bolder text-end"><span class="mcvid-td"></span>
                                                    <i class=" fa fa-eye-slash text-primary" class="toggleKey" data-id="{{ base64_encode(encryptGdprData($saleDetail->l_lead_id)) }}"  style='font-size:25px;cursor: pointer;' title="Show MCVID"></i>
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
                <!--end::Card body-->
            </div>
        </div>
        @if ($verticalId == 1)
            <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
                @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                    <div class="card col-md-4 card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Electricity</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Electricity Lead Duplicate
                                                </div>
                                            </td>
                                            <td class="fw-bolder text-end electricity_lead_duplicate_td">
                                                {{ isset($saleDetail->l_is_duplicate) && $saleDetail->l_is_duplicate == 1 ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Electricity sale Duplicate
                                                </div>
                                            </td>
                                            <td class="fw-bolder text-end electricity_sale_duplicate_td">
                                                {{ isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 1 ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex text-nowrap align-items-center">Electricity Resale Allow
                                                </div>
                                            </td>
                                            <td class="fw-bolder text-end  electricity_resale_allow_td">Retention
                                            </td>
                                        </tr>

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                @endif
                @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                    <div class="card col-md-4 card-flush py-4 flex-row-fluid overflow-hidden">
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
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Gas Lead Duplicate</div>
                                            </td>
                                            <td class="fw-bolder text-end gas_lead_duplicate_td">
                                                {{ isset($saleDetail->l_is_duplicate) && $saleDetail->l_is_duplicate == 1 ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Gas Sale Duplicate</div>
                                            </td>
                                            <td class="fw-bolder text-end sale_duplicate_td">
                                                {{ isset($saleDetail) && isset($gasSaleDetail) ? ($gasSaleDetail->sale_product_is_duplicate == 1 ? 'Yes' : 'No') : (isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 1 ? 'Yes' : 'No') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Gas Resale Allow</div>
                                            </td>
                                            <td class="fw-bolder text-end gas_resale_allow_td">Retention
                                            </td>
                                        </tr>

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                @endif

            </div>
        @endif
        @if ($saleType == 'leads' || $saleType == 'sales')
            <div class="d-flex flex-column flex-xl-row gap-7 py-5 gap-lg-10">
                <!--begin::Order details-->
                <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>UTM</h2>
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
                                    <table class="table table-row-bordered mb-0 fs-6 gy-5">
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Source</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_source ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Medium</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_medium ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Compaign</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_campaign ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Term</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_term ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM Content</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_content ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM RM</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_rm ?? 'N/A' }}
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
                                    <table class="table table-row-bordered mb-0 fs-6 gy-5" style="/*overflow:scroll;*/word-break: break-all;">
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM RM Source</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_utm_rm_source ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">UTM RM Date</div>
                                                </td>
                                                <td class="fw-bolder text-end">
                                                    {{ isset($saleDetail->m_utm_rm_date) ? dateTimeFormat($saleDetail->m_utm_rm_date) : 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">GClid</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_gclid ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">FBClid</div>
                                                </td>
                                                <td class="fw-bolder text-end">{{ $saleDetail->m_fbclid ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex text-nowrap align-items-center">MCVID</div>
                                                </td>
                                                <td class="fw-bolder text-end"><span class="mcvid-td"></span>
                                                    <i class=" fa fa-eye-slash text-primary" class="toggleKey" data-id="{{ base64_encode(encryptGdprData($saleDetail->l_lead_id)) }}" style='font-size:25px;cursor: pointer;' title="Show MCVID"></i>
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
        @endif
    </div>
    <div id="stage_edit" style="display: none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Stage Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form role="form" name="stage_form" id="stage_form">
                        @csrf
                        <input type="hidden" name="leadId" value="">
                        <input type="hidden" name="verticalId" value="{{ $verticalId }}">
                        <input type="hidden" name="saleType" value="{{ $saleType }}">
                        @if ($verticalId == 1)
                            @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                                <input type="hidden" name="electricityProductType"
                                    value={{ $saleDetail->sale_product_product_type }}>
                            @endif
                            @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                                <input type="hidden" name="gasProductType"
                                    value={{ $gasSaleDetail->sale_product_product_type ?? $saleDetail->sale_product_product_type }}>
                            @endif
                        @endif
                        <div class="row mb-6 text-gray-600">
                            <label class="col-lg-4 fw-bolder">Source :</label>
                            <div class="col-lg-8 fv-row">
                                <select data-control="select2" class="form-select-solid form-select" name="sale_source">
                                    <option value="">Select Source</option>
                                    <option value="1"
                                        {{ isset($saleDetail->l_visitor_source) && $saleDetail->l_visitor_source == 1 ? 'selected' : 'N/A' }}>
                                        API</option>
                                    <option value="2"
                                        {{ isset($saleDetail->l_visitor_source) && $saleDetail->l_visitor_source == 2 ? 'selected' : 'N/A' }}>
                                        Agent</option>
                                    <option value="3"
                                        {{ isset($saleDetail->l_visitor_source) && $saleDetail->l_visitor_source == 3 ? 'selected' : 'N/A' }}>
                                        Manual</option>
                                </select>
                                <span class="error text-danger"></span>
                            </div>
                        </div>
                        <div class="row mb-6 text-gray-600">
                            <label class="col-lg-4 fw-bolder">Completed By :</label>
                            <div class="col-lg-8 fv-row">
                                <select data-control="select2" class="form-select-solid form-select"
                                    name="sale_completed_by">
                                    <option value="">Select Completed By</option>
                                    <option value="1"
                                        {{ isset($saleDetail->sale_product_sale_completed_by) && $saleDetail->sale_product_sale_completed_by == 1 ? 'selected' : '' }}>
                                        Customer</option>
                                    <option value="2"
                                        {{ isset($saleDetail->sale_product_sale_completed_by) && $saleDetail->sale_product_sale_completed_by == 2 ? 'selected' : '' }}>
                                        Agent</option>
                                    <option value="3"
                                        {{ isset($saleDetail->sale_product_sale_completed_by) && $saleDetail->sale_product_sale_completed_by == 3 ? 'selected' : '' }}>
                                        Agent Assisted</option>
                                </select>
                                <span class="error text-danger"></span>
                            </div>
                        </div>
                        @if ($verticalId == 1)
                            <div class="row mb-6 text-gray-600">
                                <!--begin::Input-->
                                <label class="col-lg-4 fw-bolder">SMS Subscription:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-check form-check-inline form-check-solid mb-5">
                                                <input class="form-check-input sms_subscription_checkbox"
                                                    name="sms_subscription_checkbox" type="radio" value="0"
                                                    {{ isset($unsubscribesData) && $unsubscribesData->sms_unsubscribe == 0 ? 'checked' : '' }} />
                                                <span class="fw-bolder ps-2 fs-6">
                                                    Opt-In
                                                </span>
                                            </label>
                                        </div>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <div class="col-md-3">
                                            <label class="form-check form-check-inline form-check-solid mb-5">
                                                <input class="form-check-input sms_subscription_checkbox"
                                                    name="sms_subscription_checkbox" type="radio" value="1"
                                                    {{ isset($unsubscribesData) && $unsubscribesData->sms_unsubscribe == 1 ? 'checked' : '' }} />
                                                <span class="fw-bolder ps-2 fs-6">
                                                    Opt-Out
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="row mb-6 text-gray-600">
                                <!--begin::Input-->
                                <label class="col-lg-4 fw-bolder">Email Subscription:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-check form-check-inline form-check-solid mb-5">
                                                <input class="form-check-input email_subscription_checkbox"
                                                    name="email_subscription_checkbox" type="radio" value="0"
                                                    {{ isset($unsubscribesData) && $unsubscribesData->email_unsubscribe == 0 ? 'checked' : '' }} />
                                                <span class="fw-bolder ps-2 fs-6">
                                                    Opt-In
                                                </span>
                                            </label>
                                        </div>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <div class="col-md-3">
                                            <label class="form-check form-check-inline form-check-solid mb-5">
                                                <input class="form-check-input email_subscription_checkbox"
                                                    name="email_subscription_checkbox" type="radio" value="1"
                                                    {{ isset($unsubscribesData) && $unsubscribesData->email_unsubscribe == 1 ? 'checked' : '' }} />
                                                <span class="fw-bolder ps-2 fs-6">
                                                    Opt-Out
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input-->
                            </div>
                            @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                                <div class="row mb-6 text-gray-600">
                                    <!--begin::Input-->
                                    <label class="col-lg-4 fw-bolder">Electricity Sale Duplicate:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-check form-check-inline form-check-solid mb-5">
                                                    <input class="form-check-input electricity_sale_duplicate_checkbox"
                                                        name="electricity_sale_duplicate_checkbox" type="radio"
                                                        value="1"
                                                        {{ isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 1 ? 'checked' : '' }} />
                                                    <span class="fw-bolder ps-2 fs-6">
                                                        Yes
                                                    </span>
                                                </label>
                                            </div>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <div class="col-md-3">
                                                <label class="form-check form-check-inline form-check-solid mb-5">
                                                    <input class="form-check-input electricity_sale_duplicate_checkbox"
                                                        name="electricity_sale_duplicate_checkbox" type="radio"
                                                        value="0"
                                                        {{ isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 0 ? 'checked' : '' }} />
                                                    <span class="fw-bolder ps-2 fs-6">
                                                        No
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            @endif
                            @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail->sale_product_product_type))
                                <div class="row mb-6 text-gray-600">
                                    <!--begin::Input-->
                                    <label class="col-lg-4 fw-bolder">Gas Sale Duplicate:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-check form-check-inline form-check-solid mb-5">
                                                    <input class="form-check-input gas_sale_duplicate_checkbox"
                                                        name="gas_sale_duplicate_checkbox" type="radio" value="1"
                                                        {{ isset($saleDetail) && isset($gasSaleDetail) ? ($gasSaleDetail->sale_product_is_duplicate == 1 ? 'checked' : '') : (isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 1 ? 'checked' : '') }} />
                                                    <span class="fw-bolder ps-2 fs-6">
                                                        Yes
                                                    </span>
                                                </label>
                                            </div>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <div class="col-md-3">
                                                <label class="form-check form-check-inline form-check-solid mb-5">
                                                    <input class="form-check-input gas_sale_duplicate_checkbox"
                                                        name="gas_sale_duplicate_checkbox" type="radio" value="0"
                                                        {{ isset($saleDetail) && isset($gasSaleDetail) ? ($gasSaleDetail->sale_product_is_duplicate == 0 ? 'checked' : '') : (isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 0 ? 'checked' : '') }} />
                                                    <span class="fw-bolder ps-2 fs-6">
                                                        No
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            @endif
                        @else
                            @if ($saleType == 'sales')
                                <div class="row mb-6 text-gray-600">
                                    <!--begin::Input-->
                                    <label class="col-lg-4 fw-bolder">Sale Duplicate:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="form-check form-check-inline form-check-solid mb-5">
                                                    <input class="form-check-input gas_sale_duplicate_checkbox"
                                                        name="sale_duplicate_checkbox" type="radio" value="1"
                                                        {{ isset($saleDetail) && isset($gasSaleDetail) ? ($gasSaleDetail->sale_product_is_duplicate == 1 ? 'checked' : '') : (isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 1 ? 'checked' : '') }} />
                                                    <span class="fw-bolder ps-2 fs-6">
                                                        Yes
                                                    </span>
                                                </label>
                                            </div>
                                            <!--end::Option-->

                                            <!--begin::Option-->
                                            <div class="col-md-2">
                                                <label class="form-check form-check-inline form-check-solid mb-5">
                                                    <input class="form-check-input gas_sale_duplicate_checkbox"
                                                        name="sale_duplicate_checkbox" type="radio" value="0"
                                                        {{ isset($saleDetail) && isset($gasSaleDetail) ? ($gasSaleDetail->sale_product_is_duplicate == 0 ? 'checked' : '') : (isset($saleDetail->sale_product_is_duplicate) && $saleDetail->sale_product_is_duplicate == 0 ? 'checked' : '') }} />
                                                    <span class="fw-bolder ps-2 fs-6">
                                                        No
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            @endif
                        @endif
                        <div class="row mb-6 text-gray-600">
                            <label class="col-lg-4 fw-bolder">Comment :</label>
                            <div class="col-lg-8 fv-row">
                                <textarea class="form-control" rows="2" name="stage_comment"></textarea>
                                <span class="help-block fw-bolder">Give your comment for this updation. </span>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2 close_section"
                                data-initial="stage_edit" data-for="stage_show">Cancel</a>
                            <button type="submit" class="update_stage_button" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
</div>

