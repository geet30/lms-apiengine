<div class="tab-pane fade show py-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Customer Consent & Acceptance</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5"
                        id="kt_ecommerce_sales_table">
                        <thead   class="fw-bold text-gray-600">
                            <tr>
                                <th class="min-w-50px text-muted text-capitalize text-nowrap">S No.</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Energy Type</th>
                                <th class="min-w-150px text-muted text-capitalize text-nowrap">Checkbox Source</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">EIC Type</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Checkbox Content</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Status</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Created dt</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Updated dt</th>
                                <th class="min-w-100px text-muted text-capitalize text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            <?php $inc = 1; ?>
                            @foreach ($checkboxStatuses as $checkboxStatus)
                            <tr>
                                <td class="fw-bolder">{{ $inc }}
                                </td>
                                <td class="fw-bolder">{{ $checkboxStatus->energy_type }}
                                </td>
                                <td class="fw-bolder">{{ $checkboxStatus->checkbox_source }}
                                </td>
                                <td class="fw-bolder">Credit Check Consent
                                </td>
                                <td class="fw-bolder"> <span class="fw-bolder long_to_short_text">{{ $checkboxStatus->checkbox_content }}</span>
                                </td>
                                <td>
                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid"
                                        title="Change Status">
                                        <input class="form-check-input sweetalert_demo change-status" type="checkbox" value=""
                                            name="notifications" {{ $checkboxStatus->status == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="fw-bolder">{{ $checkboxStatus->created_at }}
                                </td>
                                <td class="fw-bolder">{{ $checkboxStatus->updated_at }}
                                </td>
                                <td class="fw-bolder">
                                    <a href="javascript:void(0)" class="font-weight-bold mr-2" data-bs-toggle="modal"
                                        data-bs-target="#customer_consent_acceptance_pop_up">View</a>
                                </td>
                            </tr>
                            <?php $inc++; ?>
                            @endforeach

                        </tbody>
                    </table>
                </div>


                <!-- The Modal -->
                <div class="modal fade" id="customer_consent_acceptance_pop_up" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header bg-primary">
                                <h4 class="modal-title">Customer Consent & Acceptance</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="separator my-1"></div>
                                <div class="inner-section mx-4">
                                    <h5>Checkbox Content</h5>
                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Pariatur veniam
                                        possimus
                                        architecto ratione ea assumenda iure nulla qui aperiam rem velit aut fugit,
                                        earum
                                        quod. Numquam facilis quaerat sunt id.</p>
                                    <h5>Checkbox Status</h5>
                                    <input type="checkbox" class="form-check-input bg-primary" name="status"
                                        id="status">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="button-section pull-right">
                                    <button class="btn btn-primary" data-bs-dismiss="modal">Save Changes</button>
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
