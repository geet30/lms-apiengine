<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="joint_access_show">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-3 gap-lg-10">
            <div class="card col-md-4 card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Joint Account Information</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder me-6 text-primary show_history"
                            data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                            data-vertical_id="{{ $verticalId ?? '' }}" data-section='joint_account'
                            data-for="joint_account_history" data-initial="joint_access_show">Show
                            History</a>

                        <a href="" class="fw-bolder text-primary update_section float-end" data-for="joint_access_edit"
                            data-initial="joint_access_show"><i class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                    Is this connection have joint account holder?</div>
                                            </td>
                                            <td class="fw-bolder text-end joint_acc_holder">
                                                {{ isset($saleDetail->vie_is_connection_joint_account_holder) && $saleDetail->vie_is_connection_joint_account_holder == 1 ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Name</div>
                                            </td>
                                            <td class="fw-bolder text-end joint_acc_info_name">
                                                {{ $saleDetail->vie_joint_acc_holder_title ?? '' }}
                                                {{ $saleDetail->vie_joint_acc_holder_first_name ?? '' }}
                                                {{ $saleDetail->vie_joint_acc_holder_last_name ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Email</div>
                                            </td>
                                            <td class="fw-bolder text-end joint_acc_info_email">
                                                {{ $saleDetail->vie_joint_acc_holder_email ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Phone</div>
                                            </td>
                                            <td class="fw-bolder text-end joint_acc_info_phone">
                                                {{ $saleDetail->vie_joint_acc_holder_phone_no ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Home Ph. No:</div>
                                            </td>
                                            <td class="fw-bolder text-end joint_acc_info_home_phone">
                                                <!--end::Svg Icon-->
                                                {{ $saleDetail->vie_joint_acc_holder_home_phone_no ?? 'N/A' }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Offices Ph. No:</div>
                                            </td>
                                            <td class="fw-bolder text-end joint_acc_info_ofc_phone">
                                                <!--end::Svg Icon-->
                                                {{ $saleDetail->vie_joint_acc_holder_office_phone_no ?? 'N/A' }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">D.O.B</div>
                                            </td>
                                            <td class="fw-bolder text-end joint_acc_info_doc">
                                                {{ $saleDetail->vie_joint_acc_holder_dob ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
    </div>
    <div id="joint_access_edit" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Joint Account Information Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form name="joint_access_edit_form" id="joint_access_edit_form">
                        @csrf
                        <input type="hidden" name="lead_id" id="lead_id"
                            value="{{ $saleDetail->l_lead_id ?? '' }}" />
                        <input type="hidden" name="jointAccountId" id="jointAccountId"
                            value="{{ $saleDetail->vie_id ?? '' }}" />
                        <div class="row">
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-8 fw-bolder">Is this connection have joint account
                                        holder?</label>
                                    <div class="col-md-4 ">
                                        <label class="form-check form-check-inline form-check-solid mb-5">
                                            <input class="form-check-input" name="is_connection_joint_account_holder"
                                                type="radio" value="1"
                                                {{ isset($saleDetail->vie_is_connection_joint_account_holder) && $saleDetail->vie_is_connection_joint_account_holder == '1' ? 'checked' : '' }} />
                                            <span class="fw-bolder ps-2 fs-6">
                                                Yes
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid  mb-5">
                                            <input class="form-check-input" name="is_connection_joint_account_holder"
                                                type="radio" value="0"
                                                {{ isset($saleDetail->vie_is_connection_joint_account_holder) && $saleDetail->vie_is_connection_joint_account_holder == '0' ? 'checked' : '' }} />
                                            <span class="fw-bolder ps-2 fs-6">
                                                No
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Title</label>
                                    <div class="col-md-8 ">
                                        <select data-control="select2" class="form-select-solid form-control"
                                            name="joint_account_title">
                                            @foreach ($titles as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ isset($saleDetail) && $saleDetail->vie_joint_acc_holder_title == $id ? 'selected' : '' }}>
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Email</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="joint_account_email"
                                            value="{{ $saleDetail->vie_joint_acc_holder_email ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">First Name</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control" name="joint_account_first_name"
                                            value="{{ $saleDetail->vie_joint_acc_holder_first_name ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Last Name</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control" name="joint_account_last_name"
                                            value="{{ $saleDetail->vie_joint_acc_holder_last_name ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Phone</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control" name="joint_account_phone"
                                            value="{{ $saleDetail->vie_joint_acc_holder_phone_no ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Home Ph. No:</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control" name="joint_account_home_phone"
                                            value="{{ $saleDetail->vie_joint_acc_holder_home_phone_no ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Office Ph. No:</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control" name="joint_account_office_phone"
                                            value="{{ $saleDetail->vie_joint_acc_holder_office_phone_no ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">DOB</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control joint_access_dob"
                                            name="joint_account_dob"
                                            value="{{ $saleDetail->vie_joint_acc_holder_dob ?? '' }}" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6 text-gray-600">
                                <div class="row">
                                    <label class="col-md-4 fw-bolder">Comment</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control" name="joint_account_comment" value="" />
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2 close_section"
                                data-initial="joint_access_edit" data-for="joint_access_show">Cancel</a>
                            <button type="submit" class="update_joint_access_info_button"
                                class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="joint_account_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Joint Account Information</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive customer_info_table">
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
                            <tbody class="fw-bolder text-gray-600" id="joint_account_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="joint_account_history"
                        data-for="joint_access_show">{{ __('buttons.close') }}</a>
                </div>

                <!--end::Documents-->
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="show_joint_account_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Joint Account Information Update History</h2>
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
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                Is this connection have joint account holder?</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_holder_history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                Title</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_title_history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                First Name</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_first_name_history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Last Name</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_info_last_name_history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Email</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_info_email_history">
                                        </td>
                                    </tr>

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-280px">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Phone</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_info_phone_history">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Home Ph. No:</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_info_home_phone_history">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Offices Ph. No:</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_info_ofc_phone_history">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">D.O.B</div>
                                        </td>
                                        <td class="fw-bolder text-end joint_acc_info_doc_history">
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

    </div>
</div>
