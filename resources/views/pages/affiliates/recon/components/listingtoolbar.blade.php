<!--begin::Card header-->
<div class="card-header align-items-center py-0 gap-2 gap-md-5 px-0 border-0">
    <!--begin::Card toolbar-->
    <div class="card-toolbar">
        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
            <form role="form" name="@if($info==' sub-affiliates')subaffiliate_filters @else affiliate_filters @endif" id="affiliate_filters" class="affiliate_filters">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="id" placeholder="User Id" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="company_name" placeholder="Name" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group ">
                            <input class="form-control form-control-solid rounded rounded-end-0 input" type="email" name="email" placeholder="Email" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group ">
                            <select data-placeholder="Filter By Status" class="form-select form-select-solid" name="status" data-control="select2" data-hide-search="true">
                                <option></option>
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 gap-2 gap-md-5">
                        <div class="input-group w-275px">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-light btn-active-light-primary me-2 resetbutton" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset" data-id="@if($info == 'sub-affiliates'){{request()->segment(3)}} @endif">Reset</button>
                                <button type="submit" class="btn btn-primary" id="apply_affiliate_filters">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--begin::Add product-->
            @if($info == 'sub-affiliates')
            <a href="{{ theme()->getPageUrl('affiliates/sub-affiliates/create/'.encryptGdprData($affId)) }}" class="btn btn-light-primary">+Add</a>
            @else 
            @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('add_affiliate',$userPermissions,$appPermissions))
            <a href="{{ theme()->getPageUrl('affiliates/create') }}" class="btn btn-light-primary me-3">+Add</a>
            @endif   
            @endif
            <!--end::Add product-->
        </div>
    </div>
</div>
<!--end::Card toolbar-->

<!--end::Card header-->
