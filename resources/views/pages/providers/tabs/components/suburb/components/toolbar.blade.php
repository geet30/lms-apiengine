<div class="suburb_toolbar row px-8 py-3">
    <div class="col-md-4 d-flex align-items-center">
        <h3 class="fw-bolder m-0">Suburb</h3>
    </div>
    <div class="col-md-8 d-flex justify-content-end py-1 py-md-0 h-45px">
        <button type="button" class="btn btn-light-primary collapsible collapsed text-nowrap me-3" data-bs-toggle="collapse" data-bs-target="#suburb_filters">
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black"/>
                </svg>
            </span>
            Filter
        </button>
        <div class="btn-group me-3">
            <div class="dropdown">
                <button class="btn btn-light-primary btn_status_change_bulk dropdown-toggle h-45px" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Change Status
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
                    <li><button class="dropdown-item dropdown_change_status" type="button" data-status="1">Enable</button></li>
                    <li><button class="dropdown-item dropdown_change_status" type="button" data-status="0">Disable</button></li>
                </ul>
            </div>
        </div>
        <a href="/provider/download-suburb-postcodes-sample-sheet" class="btn btn-light-primary me-3">Download Sample Sheet</a>
        <button type="button" class="btn btn-light-primary me-3 import-button" data-bs-toggle="modal" data-bs-target="#import_modal">
            Import Suburb
        </button>
        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" id="assign_suburb_btn" data-bs-target="#suburb-modal">+Assign</button>
        <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" id="add_suburb_btn" data-bs-target="#add-suburb-modal">+Add</button>
    </div>
</div>

