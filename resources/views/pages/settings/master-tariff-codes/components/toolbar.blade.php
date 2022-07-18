<div class="card-header border-0 pt-0 px-0">
    <div class="card-toolbar flex-row-fluid">
        <h5>Master Tariff Codes</h5>
        <div class="ms-auto">
            <button type="button" class="btn btn-light-primary filter_providers collapsible collapsed me-3" data-bs-toggle="collapse" data-bs-target="#master_tariff_codes_filters">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                    </svg>
                </span>
                Filter
            </button>
            <div class="btn-group">
                <div class="dropdown">
                    <button class="btn btn-light-primary me-3 btn_status_change_bulk dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Change Status
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><button class="dropdown-item dropdown_change_status" type="button" data-status="1">Enable</button></li>
                        <li><button class="dropdown-item dropdown_change_status" type="button" data-status="0">Disable</button></li>
                    </ul>
                </div>
            </div>
            <a href="/settings/download-master-tariff-codes-sample-sheet" class="btn btn-light-primary me-3 add-button">Download Sample Sheet</a>
            <button type="button" class="btn btn-light-primary me-3 import-button" data-bs-toggle="modal" data-bs-target="#import_modal" data-count=2>
                Import Tariff Codes
            </button>
            <button type="button" class="btn btn-light-primary me-3 add-button" data-bs-toggle="modal" data-bs-target="#master_tariff_codes_modal" data-count=2>
                +Add
            </button>
        </div>
    </div>
</div>

<form role="form" name="master_tariff_codes_filters" id="master_tariff_codes_filters" class="collapse master_tariff_codes_filters">
    <div class="row">
        <div class="col-lg-2 my-1">
            <div class="input-group">
                <input class="form-control form-control-solid rounded rounded-end-0 input filter_tariff_code" type="text" name="filter_tariff_code" placeholder="Tariff code" />
            </div>
        </div>
        <div class="col-lg-2 my-1">
            <div class="input-group ">
                <select data-placeholder="Tariff type" class="form-select form-select-solid filter_tariff_type" name="filter_tariff_type" data-control="select2" data-hide-search="true">
                    <option></option>
                    <option value="Demand">Demand</option>
                </select>
            </div>
        </div>
        <div class="col-lg-3 my-1">
            <div class="input-group ">
                <select data-placeholder="Status" class="form-select form-select-solid filter_status" name="filter_status" data-control="select2" data-hide-search="true">
                    <option></option>
                    <option value="status_enabled">Enabled</option>
                    <option value="status_disabled">Disabled</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 justify-content-end gap-2 gap-md-5">
            <div class="input-group w-500px">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-light btn-active-light-primary me-2 resetbutton" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset" data-id="">Reset</button>
                    <button type="submit" class="btn btn-primary" id="apply_master_tariff_codes_filters">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
</form>
