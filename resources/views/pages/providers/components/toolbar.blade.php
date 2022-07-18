<!--begin::Card header-->
<div class="card-header border-0 pt-0 px-0">
    <!--begin::Card toolbar-->
    <div class="card-toolbar">
        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
            <form role="form" name="provider_filters" id="provider_filters" class="provider_filters">
                @csrf
                <div class="row">
                    <div class="col-lg-2 fv-row service">
                        <select name="service" id="service" data-control="select2" data-placeholder="Select Service"
                            class="form-control form-control-lg form-control-solid" tabindex="-1" aria-hidden="true" aria-label="Verticals">
                            @foreach ($services as $row)
                                <option value="{{ $row->id }}" {{ $row->id == 2 ? 'selected':'' }}>
                                    {{ $row->service_title }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error text-danger"></span>
            
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group">
                            <input class="form-control form-control-solid rounded input" type="text" name="id"
                                placeholder="Provider Id" />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group">
                            <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="legal_name"
                                placeholder="Name" />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group ">
                            <select data-placeholder="Filter By Status" class="form-select form-select-solid status_filter"
                                name="status" data-control="select2" data-hide-search="true">
                                <option></option>
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 gap-2 gap-md-5">
                        <div class="input-group w-275px">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-light btn-active-light-primary me-2 resetbutton"
                                    data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset" data-id="">Reset</button>
                                <button type="submit" class="btn btn-primary" id="apply_provider_filters">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if(checkPermission('provider_action',$userPermissions,$appPermissions) && checkPermission('add_provider',$userPermissions,$appPermissions))
                <a href="{{ theme()->getPageUrl('provider/create') }}" id="provider" class="btn btn-light-primary me-3">+Add</a>
            @endif
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Card toolbar-->
</div>