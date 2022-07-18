<div class="card mb-5 mb-xl-10">

    <div class="card-header cursor-pointer" data-bs-toggle="collapse" data-bs-target="#amazing_extra_facilities_section">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">SFTP</h3>
        </div>
    </div>
    <div id="amazing_extra_facilities_section" class="collapse show">
        <div class="card-body pt-0 table-responsive " id="ReloadListing">
            <div class="row p-5">
                <label class="col-md-2 col-form-label required fw-bold fs-6">Enable SFTP</label>
                @if($providerdetails[0]['sftp_enable'] == 1)
                    <button type="button" class="col-md-2 btn btn-success" id="sftp-status" data-sftp_status="{{$providerdetails[0]['sftp_enable']}}" data-id="{{$providerdetails[0]['id']}}">
                        Disable
                    </button>
                @else
                    <button type="button" class="col-md-2 btn btn-danger" id="sftp-status" data-sftp_status="{{$providerdetails[0]['sftp_enable']}}" data-id="{{$providerdetails[0]['id']}}">
                        Enable
                    </button>
                @endif

                <button type="button" class="btn btn-primary col-md-2 my-1 my-md-0 ms-0 ms-md-2" id="btn-log-emails" data-log_from_email="{{decryptGdprData($providerdetails[0]['log_from_email'])}}" data-log_from_name="{{decryptGdprData($providerdetails[0]['log_from_name'])}}" data-log_subject="{{$providerdetails[0]['log_subject']}}" data-log_to_emails="{{decryptGdprData($providerdetails[0]['log_to_emails'])}}" data-bs-toggle="modal" data-bs-target="#sftp-logs-modal" style="display:none">
                    Log Emails
                </button>

                <button type="button" class="btn btn-primary col-md-2 ms-0 ms-md-2" id="btn-add-sftp" data-bs-toggle="modal" data-bs-target="#add-sftp-modal" style="display:none">
                    Add SFTP
                </button>

                <div class="col-md-2 ms-auto mt-1 mt-md-0 px-0 me-3">
                    <button type="button" class="btn btn-light-primary filter_providers collapsible collapsed col-12 me-3" data-bs-toggle="collapse" data-bs-target="#sftp_filters">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black"/>
                            </svg>
                        </span>
                        Filter
                    </button>
                </div>
                <form role="form" name="sftp_filters" id="sftp_filters" class=" col-md-12 collapse sftp_filters">
                    <div class="row mt-3">
                        <div class="col-lg-3 my-1">
                            <div class="input-group">
                                <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="filter_destination" placeholder="Destination name" />
                            </div>
                        </div>
                        <div class="col-lg-3 my-1">
                            <div class="input-group">
                                <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="filter_remote_host" placeholder="Remote host" />
                            </div>
                        </div>
                        <div class="col-lg-3 my-1">
                            <div class="input-group">
                                <input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="filter_port" placeholder="Port" />
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
                        <div class="align-items-center pt-3 gap-2 gap-md-5">
                            <div class="input-group w-500px">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-light btn-active-light-primary me-2 resetbutton" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset" data-id="">Reset</button>
                                    <button type="submit" class="btn btn-primary" id="apply_sftp_filters">Apply Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @include('pages.providers.tabs.components.sftp.table')
        </div>
    </div>
</div>
@include('pages.providers.tabs.components.sftp.modals')
