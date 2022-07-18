<!--begin::Card header-->
<div class="card-header border-0 pt-6">
    <!--begin::Card title-->
    <div class="card-title">

        <div class="d-flex align-items-center position-relative gap-5 my-1">
            <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                    </svg>
                </span> 
                <input type="text" data-kt-customer-table-filter="search" id="search_mobile_plans" class="form-control form-control-solid w-250px ps-15" placeholder="Search Mobile Plans" />
            </div>
                        <!--end::Svg Icon-->
           
            <form name="filter_mobile_plans" id="filter_mobile_plans" method="post" style="display:inherit">
                @csrf
                 <select class="form-select form-select-solid select2-hidden-accessible w-150px me-5" name="status_filter" data-control="select2" data-hide-search="true" aria-label="{{ __ ('mobile.listPage.status_filter.placeHolder')}}" data-placeholder="{{ __ ('mobile.listPage.status_filter.placeHolder')}}">
                    <option value=" ">All</option>
                    <option value="1" {{isset($filters['status_filter']) && $filters['status_filter'] == 1 ? 'selected' :'' }}>Active</option>
                    <option value="0" {{isset($filters['status_filter']) && $filters['status_filter'] == 0 ? 'selected' :'' }}>In-Active</option>
                </select>
                <button type="submit" class="btn btn-primary" >{{__('mobile.listPage.apply')}}</button>
            </form>
           
        </div>
    </div>
    <!--begin::Card title-->
    <!--begin::Card toolbar-->
    <div class="card-toolbar">
        <a  class="btn btn-light-primary me-3 download_sample" data-type="mobile"> 
                Download Mobile Info Sample 
        </a>
        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#upload_mobile_plan_modal">
            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
            <span class="svg-icon svg-icon-2">
            <i class="fa fa-plus" aria-hidden="true"></i></span>{{ __('mobile.listPage.uploadPlan') }}
            <!-- end::Svg Icon Add -->
        </button>
        @if(checkPermission('add_mobile_plan',$userPermissions,$appPermissions))
            <a href="{{ theme()->getPageUrl('provider/plans/mobile/'.$providerId.'/create') }}" class="btn btn-light-primary me-3">
                <span class="svg-icon svg-icon-2">
                    <i class="fa fa-plus" aria-hidden="true"></i></span>{{ __('mobile.listPage.addPlan') }}
            </a>
        @endif
    </div>
        
</div>
<!--end::Card toolbar-->


