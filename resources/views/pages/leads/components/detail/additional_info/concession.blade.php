
<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="concession_detail_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Concession Details</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history"
                            data-vertical_id={{ $verticalId }} data-visitor_id="{{ $saleDetail->l_visitor_id ?? '' }}" data-section='concession_detail'
                            data-for="concession_detail_history" data-initial="concession_detail_show">Show History</a>

                        <a href="" class="fw-bolder text-primary update_section float-end"
                            data-for="concession_detail_edit" data-initial="concession_detail_show"><i
                                class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                            <tbody class="fw-bold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Concession Type:</div>
                                    </td>
                                    <td class="fw-bolder text-end vcd_concession_type">
                                        @foreach ($concessionTypes as $type)
                                            @if (isset($saleDetail->vcd_concession_type) && $saleDetail->vcd_concession_type == $type['local_id'])
                                                {{ $type['name'] }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Concession Code:</div>
                                    </td>
                                    <td class="fw-bolder text-end vcd_concession_code">
                                        {{ $saleDetail->vcd_concession_code ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Card Number:</div>
                                    </td>
                                    <td class="fw-bolder text-end vcd_concession_card_number">
                                        {{ $saleDetail->vcd_card_number ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Card Issue Date:</div>
                                    </td>
                                    <td class="fw-bolder text-end vcd_card_issue_date">
                                        {{ $saleDetail->vcd_card_start_date ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            Card Expiry Date:</div>
                                    </td>
                                    <td class="fw-bolder text-end vcd_card_expiry_date">
                                        {{ $saleDetail->vcd_card_expiry_date ?? 'N/A' }}
                                    </td>
                                </tr>


                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>

            <!--end::Documents-->
        </div>
    </div>
    <div id="concession_detail_edit" style="display:none">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Concession Details Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form name="concession_details_edit_form" id="concession_details_edit_form">
                        <input type="hidden" name="vcd_id" id="vcd_id" value="{{ $saleDetail->vcd_id }}" />
                        <input type="hidden" name="new_lead" id="new_lead" value="{{ $saleDetail->l_lead_id }}" />
                        <input type="hidden" name="new_visitor_id" id="new_visitor_id"
                            value="{{ $saleDetail->l_visitor_id }}">
                        <div class="row">
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Concession Type</label>
                                    <div class="col-md-8 ">
                                        <select name="concession_type" data-control="select2"
                                            class="form-select-solid form-select concession_type">
                                            <option value="">Select Type </option>
                                            @foreach ($concessionTypes as $type)
                                                <option value="{{ $type['local_id'] }}"
                                                    {{ $saleDetail->vcd_concession_type == $type['local_id'] ? 'selected' : '' }}>
                                                    {{ $type['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Concession Code</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control vcd_concession_code"
                                            name="concession_code"
                                            value="{{ $saleDetail->vcd_concession_code ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Card Number</label>
                                    <div class="col-md-8 fv-row">
                                        <input type="text" class="form-control" name="card_number"
                                            value="{{ $saleDetail->vcd_card_number ?? ' ' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Card Issue Date</label>
                                    <div class="col-md-8 fv-row">
                                        <input type="text" class="form-control concession_details_date"
                                            id="card_issue_date" name="card_issue_date" id="card_issue_date"
                                            value="{{ $saleDetail->vcd_card_start_date ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Card Expiry Date</label>
                                    <div class="col-md-8 fv-row">
                                        <input type="text" class="form-control concession_details_date"
                                            id="card_expiry_date" name="card_expiry_date" id="card_expiry_date"
                                            value="{{ $saleDetail->vcd_card_expiry_date ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Comment</label>
                                    <div class="col-md-8 fv-row">
                                        <input type="text" class="form-control " name="concession_details_comment"
                                            id="concession_details_comment" value="" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2 close_section"
                                data-initial="concession_detail_edit" data-for="concession_detail_show">Cancel</a>
                            <button type="submit" class="update_concession_detail_button"
                                class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="concession_detail_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Concession Detail</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                            <thead class="fw-bold text-gray-600">
                                <tr>
                                    <th class="text-muted text-capitalize text-nowrap">S No.</th>
                                    <th class="text-muted text-capitalize text-nowrap">User Name</th>
                                    <th class="text-muted text-capitalize text-nowrap">User role</th>
                                    <th class="text-muted text-capitalize text-nowrap">Comment</th>
                                    <th class="text-muted text-capitalize text-nowrap">Updated at</th>
                                    <th class="text-muted text-capitalize text-nowrap text-center">Show Update History
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="fw-bolder text-gray-600" id="concession_detail_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="concession_detail_history"
                        data-for="concession_detail_show">{{ __('buttons.close') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_concession_detail_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Concession Detail Update History</h2>
                <div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                        <tbody class="fw-bold text-gray-600">
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Concession Type:</div>
                                </td>
                                <td class="fw-bolder text-end vcd_concession_type_history">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Concession Code:</div>
                                </td>
                                <td class="fw-bolder text-end vcd_concession_code_history">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Card Number:</div>
                                </td>
                                <td class="fw-bolder text-end vcd_concession_card_number_history">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Card Issue Date:</div>
                                </td>
                                <td class="fw-bolder text-end vcd_card_issue_date_history">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                        Card Expiry Date:</div>
                                </td>
                                <td class="fw-bolder text-end vcd_card_expiry_date_history">
                                </td>
                            </tr>


                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
        </div>

    </div>
</div>
