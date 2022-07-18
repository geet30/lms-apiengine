<!--begin::Card header-->
<div class="card-header border-0 pt-6">
    <!--begin::Card title-->
    <div class="card-title">
        <!--begin::Search-->
        <div class="d-flex align-items-center position-relative my-1">
            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
            <input type="text" data-kt-customer-table-filter="search" id="search_leads" class="form-control form-control-solid w-250px ps-15" placeholder="Search Plans" />
        </div>
        <!--end::Search-->
    </div>
    <!--begin::Card title-->
    <!--begin::Card toolbar-->
    <div class="card-toolbar">
        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
            <!--Add plan-->
            <!-- <a href="3/create"  class="btn btn-light-primary me-3"> -->
                <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                <!-- <span class="svg-icon svg-icon-2">
                <i class="fa fa-plus" aria-hidden="true"></i></span> -->
                <!-- end::Svg Icon Add -->
            <!-- </a> -->
            <a  class="btn btn-light-primary me-3 download_sample" data-type="{{$energyType}}" download="electricity_info_sample.csv"> 
                Download {{ucwords($energyType)}} Info Sample 
            </a>

            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#upload_plan_modal">
                <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                <span class="svg-icon svg-icon-2">
                <i class="fa fa-plus" aria-hidden="true"></i></span>{{ __('plans/energyPlans.upload_plan_rate') }}
                <!-- end::Svg Icon Add -->
            </button>

        </div>

        <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
            <div class="fw-bolder me-5">
            <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
            <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
        </div>
        <!--end::Group actions-->
    </div>
    <!--end::Card toolbar-->
</div>
