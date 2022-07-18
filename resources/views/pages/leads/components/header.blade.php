<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
    <!--begin: Pic-->
    <div class="me-7 mb-4">
        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
            @if(isset($affiliateLogo->logo))
            <img src="{{$affiliateLogo->logo}}">
            @else
            <img src="{{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }}">
            @endif
            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px">
            </div>
        </div>
    </div>
    <div class="flex-grow-1">
        <!--begin::Title-->
        <div class="d-flex row justify-content-between align-items-start flex-wrap mb-2">
            <!--begin::User-->
            <div class="d-flex flex-column">
                <!--begin::Name-->
                <div class="d-flex align-items-center mb-2">
                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{ $saleDetail->v_title ?? '' }} {{ isset($saleDetail->v_first_name)? ucfirst(strtolower(decryptGdprData($saleDetail->v_first_name))) : '' }} {{ isset($saleDetail->v_middle_name)? ucfirst(strtolower(decryptGdprData($saleDetail->v_middle_name))) : '' }} {{ isset($saleDetail->v_last_name)? ucfirst(strtolower(decryptGdprData($saleDetail->v_last_name))) : '' }}</a>
                    <a href="#">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF" />
                                <path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <a href="mailto:{{ isset($saleDetail->v_email)? strtolower(decryptGdprData($saleDetail->v_email)) : '' }}" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3" target="blank">{{ isset($saleDetail->v_email)? strtolower(decryptGdprData($saleDetail->v_email)) : '' }}</a>
                </div>
                <!--end::Name-->
                <!--begin::Info-->
                <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                    <a href="" onClick="(function(){
                        window.open('tel:0420580919');

                    })();" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                        <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                        <span class="svg-icon svg-icon-4 me-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black" />
                                <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        {{ isset($saleDetail->v_phone)? decryptGdprData($saleDetail->v_phone) : '' }}
                    </a>
                    @if(isset($connectionAddress->address))
                    <a href="http://maps.google.com/maps?q=<?= 'EnergyAustralia Level 33, 385 Bourke Street Melbourne VIC 3000' ?>" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2" target="blank">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                        <span class="svg-icon svg-icon-4 me-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="black" />
                                <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        {{ $connectionAddress->address ?? '' }}
                    </a>
                    @endif
                </div>
                <!--end::Info-->
            </div>
            <!--end::User-->
            <!--begin::Actions-->
            <div class="card-toolbar row">
                <!--begin::Toolbar-->
                <div class="d-flex" data-kt-customer-table-toolbar="base">
                    <!--begin::Trigger-->
                    <button type="button" class="btn btn-sm btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                        Send Email/SMS
                        <!-- <span class="svg-icon svg-icon-5 rotate-180 ms-3 me-0">...</span> -->
                    </button>
                    <!--end::Trigger-->

                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#leads_email_modal">Send Email</a>
                            <!-- <a href="mailto:{{ isset($saleDetail->v_email)? strtolower(decryptGdprData($saleDetail->v_email)) : '' }}" class="menu-link px-3"> -->
                            <!-- Send Email -->
                            <!-- </a> -->
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#leads_sms_modal">Send SMS</a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">
                                Check Histroy
                            </a>
                        </div>
                        <!--end::Menu item-->
                        @if($saleType == 'sales')
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="mailto:{{ isset($saleDetail->v_email)? strtolower(decryptGdprData($saleDetail->v_email)) : '' }}" class="menu-link px-3" data-bs-toggle="modal"    data-bs-target="#kt_modal_resend_mail">Resend Welcome Email</a>
                        </div>
                        <!--end::Menu item-->
                        @endif
                    </div>
                    <!--end::Menu-->


                    <!--begin::Export-->
                    <button type="button" class="btn btn-sm btn-light-danger me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">Delete Sale</button>
                    <!--end::Export-->

                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <!-- if($salesQaData->is_locked == 1) -->
                        <button type="button" class="btn btn-sm btn-light-danger me-3" id="salesQaStopBtn" data-value="{{$salesQaData->is_locked ?? '0'}}">Stop QA</button>
                    <!-- endif -->

                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                        <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
                    </div>
                    <!--end::Group actions-->
                </div>
            </div>
            <!--end::Menu-->
            <!--end::Title-->
            <!--end::Progress-->
        </div>
        <!--end::Stats-->
    </div>
    <!--end::Info-->
</div>