<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 mb-3 gap-lg-10">
        <!--begin::Order details-->
        <div class="card col-md-4 card-flush py-4 flex-row-fluid overflow-hidden">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Affiliate Information</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                        <tbody class="fw-bold text-gray-600">
                        @if(($saleType == 'leads' && checkPermission('lead_affiliate_name',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_affiliate_name',$userPermissions,$appPermissions) || $saleType == 'visits' && checkPermission('visit_affiliate_name',$userPermissions,$appPermissions))
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Affiliate Name</div>
                                </td>
                                <td class="fw-bolder text-end">
                                    <label id="affiliate_display_name">
                                    {{ isset($saleDetail->a_company_name)
                                ? $saleDetail->a_company_name : 'N/A' }}
                                    </label>
                                    <span class="text-primary text-hover-primary edit_affiliate_section" data-type="affiliate" data-affiliate_id="{{ $saleDetail->l_affiliate_id ?? ''}}">

                                    <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3"
                                            d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                            fill="black" />
                                        <path
                                            d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                    </span>
                                </td>
                            </tr>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_affiliate_sub_affiliate_name',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_affiliate_sub_affiliate_name',$userPermissions,$appPermissions) || $saleType == 'visits' && checkPermission('visit_affiliate_sub_affiliate_name',$userPermissions,$appPermissions))
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Sub Affiliate Name</div>
                                    </td>

                                    <td class="fw-bolder text-end">
                                        <label id="sub_affiliate_display_name">
                                            {{ $subAffiliate->company_name ?? 'N/A'}}
                                        </label>
                                        <span class="text-primary text-hover-primary edit_affiliate_section" data-type="sub-affiliate" data-affiliate_id="{{ $saleDetail->l_affiliate_id ?? ''}}">

                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                </svg>
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_referal_code_url',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_referal_code_url',$userPermissions,$appPermissions) || $saleType == 'visits' && checkPermission('visit_referal_code_url',$userPermissions,$appPermissions))
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Referral URL Title</div>
                                    </td>
                                    <td class="fw-bolder text-end">
                                        {{ isset($saleDetail->l_referal_title) ? decryptgdprData($saleDetail->l_referal_title) : 'N/A' }}
                                    </td>
                                </tr>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_affiliate_email',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_affiliate_email',$userPermissions,$appPermissions) || $saleType == 'visits' && checkPermission('visit_affiliate_email',$userPermissions,$appPermissions))
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Affiliate Email</div>
                                    </td>
                                    <td class="fw-bolder text-end" id="affiliate_show_email">{{ isset($affiliateData->email) ?strtolower(decryptGdprData($affiliateData->email)) : 'N/A' }}
                                    </td>
                                </tr>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_affiliate_phone',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_affiliate_phone',$userPermissions,$appPermissions) || $saleType == 'visits' && checkPermission('visit_affiliate_phone',$userPermissions,$appPermissions))
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Affiliate Phone</div>
                                    </td>
                                    <td class="fw-bolder text-end" id="affiliate_show_phone">
                                        {{ isset($affiliateData->phone) ?strtolower(decryptGdprData($affiliateData->phone)) : 'N/A' }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Card body-->
        </div>
        @if($saleType == 'sales' || $saleType == 'leads')
        <div class="card col-md-4 card-flush py-4 flex-row-fluid">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Remarketing Status</h2>
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
                                    <div class="d-flex align-items-center">Email(Total Email Sent)</div>
                                </td>
                                <td class="fw-bolder text-end">
                                    {{ $saleDetail->u_email_sent ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                        SMS(Total SMS Sent)</div>
                                </td>
                                <td class="fw-bolder text-end">
                                    N/A
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
        <!--end::Documents-->
    </div>
</div>
