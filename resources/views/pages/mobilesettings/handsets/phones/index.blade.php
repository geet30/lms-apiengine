
    <!--begin::Content-->
<div class="card-header align-items-center border-0">

    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
        <button type="button" class="btn btn-light-primary filter_providers collapsible collapsed me-3" data-bs-toggle="collapse" data-bs-target="#phones_filters">
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                </svg>
            </span>
            Filter
        </button>
            <button type="button" class="btn btn-light-primary filter_leads collapsible collapsed me-3" id="assign_provider">+Assign Provider</button>
            @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_handset_phones',$userPermissions,$appPermissions) &&  checkPermission('manage_handset_phones',$userPermissions,$appPermissions) && checkPermission('add_handset_phones',$userPermissions,$appPermissions))
            <a href="{{ theme()->getPageUrl('/mobile/get-phone-form') }}" class="btn btn-light-primary collapsible collapsed me-3 add_handsets"  id="add_handsets">+Add</a>
            @endif
    </div>
    <form name="phones_filters" id="phones_filters" class="collapse">
        <div class="row">
        <div class="col-lg-3 my-1">
            <div class="input-group">
                <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px" name="search_phone" placeholder="Search Phone Name" autocomplete="off" />
            </div>
        </div>
        <div class="col-lg-3 my-1">
            <div class="input-group">
                <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="search_model" placeholder="Search Model Number" autocomplete="off" />
            </div>
        </div>
        <div class="col-lg-2 my-1">
            <div class="input-group">
                <select data-control="select2" data-placeholder="Brands" data-hide-search="true" name="search_brand" id="search_brand" class="form-select form-select-solid select2-hidden-accessible w-150px" tabindex="-1" aria-hidden="true" aria-label="Brands">
                        <option value=""></option>
                    @foreach ($brandNames as $key=>$value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-2 my-1">
            <div class="input-group">
                <select data-control="select2" data-placeholder="Status" data-hide-search="true" name="filter_status" id="filter_phone_status" class="form-select form-select-solid select2-hidden-accessible w-150px" tabindex="-1" aria-hidden="true"  aria-label="Status">
                    <option value=""></option>
                    <option value="1">Active</option>
                    <option value="0">In-active</option>
                </select>
            </div>
        </div>
            <div class="align-items-center py-5 gap-2 gap-md-5">
                <div class="input-group w-300px">
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2 reset-phone-filter" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                        <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter" id="apply_phones_filters">Apply Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>



{{ theme()->getView('pages/mobilesettings/handsets/phones/components/modal',['phones'=>$phones, 'brandNames'=>$brandNames, 'providers'=>$providers]) }}
{{ theme()->getView('pages/mobilesettings/handsets/phones/components/toolbar') }}
{{ theme()->getView('pages/mobilesettings/handsets/phones/components/table',['phonesListing'=>$phonesListing, 'storageUnits'=>$storageArr, 'capacityArr'=>$capacityArr,'userPermissions'=>$userPermissions,'appPermissions'=>$appPermissions])}}
@include('pages.mobilesettings.handsets.phones.components.handset_assigned_providers_modal')
<!--end::Content-->

