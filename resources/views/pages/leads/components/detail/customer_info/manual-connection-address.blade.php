<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden" id="manual_connection_address_show">
            <div class="card-header">
                <div class="card-title">
                    <h2>Manual Connection Address</h2>
                </div>
                <div class="my-auto me-4 py-3">
                    <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history" id="manual_connection_history"
                    data-address_id="{{ $manualConnectionAddress->id ?? ''}}" data-vertical_id={{ $verticalId }} data-section = 'manual_connection_address'
                    data-for="manual_connection_address_history" data-initial="manual_connection_address_show">Show History</a>

                    <a href="" class="fw-bolder text-primary update_section float-end"
                        data-lead_id={{ $saleDetail->l_lead_id }} data-service_id={{ $verticalId }}
                        data-for="manual_connection_address_edit" data-initial="manual_connection_address_show"><i
                            class="bi bi-pencil-square text-primary"></i> Edit</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                        <tbody class="fw-bold text-gray-600">
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Manual Connection Address:</div>
                                </td>
                                <td class="fw-bolder text-center manual_connection_td">{{ $manualConnectionAddress->manual_connection_details ?? 'N/A' }}
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
        </div>
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50" id="manual_connection_address_edit"
            style="display:none;">
            <div class="card-header">
                <div class="card-title">
                    <h2>Manual Connection Address Edit</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <form role="form" name="manual_connection_form" id="manual_connection_form">
                    @csrf
                    <input type="hidden" name="manualAddressId" value="{{ $manualConnectionAddress->id ?? '' }}">
                    <input type="hidden" name="leadId" value={{ $saleDetail->l_lead_id }}>
                    <input type="hidden" name="visitorId" value={{ $saleDetail->l_visitor_id }}>
                    <input type="hidden" name="addressType"
                    value={{ isset($saleDetail->journey_property_type) && $saleDetail->journey_property_type == 0 ? 1 : 2 }}>
                    <div class="row mb-6 text-gray-600">
                        <label class="col-lg-3 fw-bolder">Manual Connection Address:</label>
                        <div class="col-lg-9 fv-row">
                            <input type="text" class="form-control" id="connection_address" name="manual_connection_address" autocomplete="off" value="{{ $manualConnectionAddress->manual_connection_details ?? '' }}">
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6 text-gray-600">
                        <label class="col-lg-3 fw-bolder">Comment :</label>
                        <div class="col-lg-9 fv-row">
                            <textarea class="form-control" rows="2" name="comment" placeholder="{{ __('sale_detail.view.customer.customer_info.comment.placeHolder') }}"></textarea>
                            <span class="help-block fw-bolder">Give your comment for this updation. </span>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a class="btn btn-light btn-active-light-primary me-2 close_section"
                            data-initial="manual_connection_address_edit" data-for="manual_connection_address_show">{{ __('buttons.cancel') }}</a>
                        <button type="submit" class="update_address_button" class="btn btn-primary">{{ __('buttons.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50" id="manual_connection_address_history"
            style="display:none;">
            <div class="card-header">
                <div class="card-title">
                    <h2>Manual Connection Address</h2>
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
                                <th class="text-muted text-capitalize text-nowrap">User Role</th>
                                <th class="text-muted text-capitalize text-nowrap">Comment</th>
                                <th class="text-muted text-capitalize text-nowrap">Updated at</th>
                                <th class="text-muted text-capitalize text-nowrap text-center">Show Update History</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bolder text-gray-600" id="manual_address_body">
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="javascript:void(0);" type="button"
                    class="btn btn-primary close_section"
                    data-initial="manual_connection_address_history" data-for="manual_connection_address_show">{{ __('buttons.close') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_manual_address_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Manual Connection Address Update History</h2>
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
                                    <div class="d-flex align-items-center">Manual Connection Address:</div>
                                </td>
                                <td class="fw-bolder text-center manual_address_td">
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
