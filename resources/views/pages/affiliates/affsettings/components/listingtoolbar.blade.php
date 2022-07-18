<div class="card-header align-items-center border-0">
    <div class="card-title">
        <div class="d-flex align-items-center position-relative gap-5 my-1 me-5">
            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                </svg>
            </span>

            <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search" id="search_affiliate" />

        </div>

        <form id="apikeyform" name="" accept-charset="UTF-8" class="" method="POST">
            <div class="d-flex align-items-center position-relative gap-5 my-1">

                @csrf

                <select data-control="select2" data-placeholder="" data-hide-search="true" name="filter_status" id="filter_status" class="form-select form-select-solid select2-hidden-accessible w-150px" tabindex="-1" aria-hidden="true">
                    @foreach ($allStatus as $key => $value)
                    @if($activeStatus == $key)

                    <option value="{{$key}}" selected>{{$value}}</option>
                    @else
                    <option value="{{$key}}">{{$value}}</option>
                    @endif

                    @endforeach

                </select>
                <button type="submit" class="btn btn-primary" id="applyapkifilter">{{ __('affiliates_label.buttons.apply') }}</button>
                <button type="button" class="btn btn-primary resetApiKey">{{ __('affiliates_label.buttons.reset') }}</button>
            </div>

        </form>
        
    </div>



    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

        <button type="button" class="btn btn-light-primary filter_leads collapsible collapsed me-3" data-bs-toggle="modal" data-bs-target="#apicreatemodal" id="show_apikeypopup" data-user_id='{{encryptGdprData($records["id"])}}'>Create API key</button>
        <input type="hidden" value="" id="api_key_id">

    </div>
    <form name="filter_leads" id="filter_leads" class="collapse">
        <div class="card-header border-0">

            <div class="input-group w-250px">
                <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="search_name" placeholder="Name" />
            </div>
            <div class="input-group w-250px">
                <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="search_url" placeholder="Page Url" />
            </div>
            <div class="input-group w-250px">
                <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="search_api_key" placeholder="API Key" />
            </div>

            <div class="input-group w-250px mobile">
                <select data-placeholder="Filter By Status" class="form-select form-select-solid">
                    <option value="">Filter By Status</option>
                    <option value="1">Enabled</option>
                    <option value="2">Disables</option>
                </select>
            </div>
            <div class="align-items-center py-5 gap-2 gap-md-5 w-100">
                <div class="input-group w-500px">
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                        <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter" id="apply_lead_filters">Apply Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>