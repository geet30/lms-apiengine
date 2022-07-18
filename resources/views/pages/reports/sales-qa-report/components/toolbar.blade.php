<!--begin::Card toolbar-->
<div class="card-header align-items-center border-0">
    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
        <button type="button" class="btn btn-light-primary filter_providers collapsible collapsed me-3" data-bs-toggle="collapse" data-bs-target="#salesQaFilters">
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                </svg>
            </span>
            Filter
        </button>
        <form name="salesQaFilters" id="salesQaFilters" class="collapse">
            @csrf
            <input type="hidden" name="filterSearch" value="1">
            <div class="row">
                <div class="col-lg-3 my-2">
                    <label id="dateRange" name="dateRange" class="col-lg-12 col-form-label fs-6 px-3">Date Range</label>
                    <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="datePickerQa" id="datePickerQa" />
                </div>
                <div class="col-lg-3 my-2">
                    <div class="input-group">
                        <label class="col-lg-12 col-form-label px-3 fs-6">Assigned QA</label>
                        <select data-control="select2" data-placeholder="Assigned QA" data-hide-search="true" name="assignedQa[]" id="assignedQa" class="form-select form-select-solid select2-hidden-accessible" tabindex="-1" aria-hidden="true" aria-label="Assigned QA" multiple>
                            <option value=""></option>
                            @foreach ($QaList as $key=>$value)
                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 my-2">
                    <label class="col-lg-12 col-form-label fs-6 px-3">Action performed by</label>

                    <select data-control="select2" data-placeholder="Assigned QA" data-hide-search="true" name="actionPerformedBy[]" id="actionPerformedBy" class="form-select form-select-solid select2-hidden-accessible" tabindex="-1" aria-hidden="true" aria-label="Action performed by" multiple>
                        <option value=""></option>
                        @foreach ($QaList as $key=>$value)
                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-lg-3 my-2">
                    <label class="col-lg-12 col-form-label fs-6 px-3">Action</label>
                    <select data-control="select2" data-placeholder="Action" data-hide-search="true" name="qaAction[]" id="qaAction" class="form-select form-select-solid select2-hidden-accessible" tabindex="-1" aria-hidden="true" aria-label="Action" multiple>
                        <option value=""></option>
                        <option value="1">Assigned QA</option>
                        <option value="2">Assigned Collaborators</option>
                        <option value="3">Un-assigned QA</option>
                        <option value="4">Un-assigned Collaborators</option>
                        <option value="5">Start QA</option>
                        <option value="6">End QA</option>
                        <option value="7">Pause/Hold QA</option>

                    </select>
                </div>
                <div class="col-lg-3 my-2">
                    <label class="col-lg-12 col-form-label fs-6 px-3">Sale ID</label>
                    <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="saleId" id="saleId" placeholder="Sale ID" autocomplete="off" />
                </div>
                <div class="col-lg-3 my-2">
                    <label class="col-lg-12 col-form-label fs-6 px-3">Reference Number</label>
                    <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="referenceNumber" id="referenceNumber" placeholder="Reference Number" autocomplete="off" />
                </div>
                <div class="align-items-center py-5 gap-2 gap-md-5">
                    <div class="input-group w-300px">
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2 reset-qa-filter" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter" id="applySalesQaFilters">Apply Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end::Card toolbar-->