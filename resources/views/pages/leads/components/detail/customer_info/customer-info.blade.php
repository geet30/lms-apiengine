<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="customer_info_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Customer Info</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history"
                            data-visitor_id={{ $saleDetail->l_visitor_id ?? ''}} data-vertical_id={{ $verticalId }} data-section = 'customer_info'
                            data-for="customer_info_history" data-initial="customer_info_show">Show History</a>

                        <a href="javascript:void(0);" class="fw-bolder text-primary update_section float-end"
                            data-for="customer_info_edit" data-initial="customer_info_show">
                            <i class="bi bi-pencil-square text-primary" aria-hidden="true"></i>Edit
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive customer_info_table">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Title</div>
                                            </td>
                                            <td class="fw-bolder text-end customer_info_title_td">
                                                {{ $saleDetail->v_title ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">First Name</div>
                                            </td>
                                            <td class="fw-bolder text-end text-capitalize customer_info_f_name_td">
                                                {{ isset($saleDetail->v_first_name) ? ucfirst(strtolower(decryptGdprData($saleDetail->v_first_name))) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Middle Name</div>
                                            </td>
                                            <td class="fw-bolder text-end text-capitalize customer_info_m_name_td">
                                                {{ isset($saleDetail->v_middle_name) && $saleDetail->v_middle_name != '' ? ucfirst(strtolower(decryptGdprData($saleDetail->v_middle_name))) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Last Name</div>
                                            </td>
                                            <td class="fw-bolder text-end text-capitalize customer_info_l_name_td">
                                                {{ isset($saleDetail->v_last_name) ? ucfirst(strtolower(decryptGdprData($saleDetail->v_last_name))) : 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>

                        <!-- right side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Email</div>
                                            </td>
                                            <td class="fw-bolder text-end text-lowercase customer_info_email_td">
                                                {{ isset($saleDetail->v_email) ? decryptGdprData($saleDetail->v_email) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Phone Number</div>
                                            </td>
                                            <td class="fw-bolder text-end customer_info_phone_td">
                                                {{ isset($saleDetail->v_phone) ? decryptGdprData($saleDetail->v_phone) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Alternate Phone Number</div>
                                            </td>
                                            <td class="fw-bolder text-end customer_info_alt_phone_td">
                                                {{ isset($saleDetail->v_alternate_phone) && $saleDetail->v_alternate_phone != '' ? decryptGdprData($saleDetail->v_alternate_phone) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">DOB</div>
                                            </td>
                                            <td class="fw-bolder text-end customer_info_dob_td">
                                                {{ $saleDetail->v_dob ?? 'N/A' }}
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
                <!--end::Card body-->
            </div>

            <!--end::Documents-->
        </div>
    </div>
    <div id="customer_info_edit" style="display: none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Customer Info Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!--begin::Form-->
                    <form id='customer_info_form' name='customer_info_form' class="form">
                        <!--begin::Card body-->
                        <input type="hidden" name="visitor_id" id="visitor_id"
                            value="{{ isset($saleDetail) ? $saleDetail->l_visitor_id : '' }}">

                        <div class="card-body border-top p-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.title.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <select class="form-select form-select-solid" name="title"
                                                data-control="select2" data-hide-search="false"
                                                aria-label="{{ __('sale_detail.view.customer.customer_info.title.placeHolder') }}"
                                                data-placeholder="{{ __('sale_detail.view.customer.customer_info.title.placeHolder') }}"
                                                aria-hidden="true" tabindex="-1">
                                                <option value=""></option>
                                                @foreach ($titles as $id => $name)
                                                    <option value="{{ $id }}"
                                                        {{ isset($saleDetail) && $saleDetail->v_title == $id ? 'selected' : '' }}>
                                                        {{ $name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger errors" id="title_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label required fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.first_name.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="first_name"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ __('sale_detail.view.customer.customer_info.first_name.placeHolder') }}"
                                                value="{{ isset($saleDetail->v_first_name) ? ucfirst(strtolower(decryptGdprData($saleDetail->v_first_name))) : '' }}"
                                                autocomplete="off" />
                                            <span class="text-danger errors" id="first_name_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.middle_name.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="middle_name"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ __('sale_detail.view.customer.customer_info.middle_name.placeHolder') }}"
                                                value="{{ isset($saleDetail->v_middle_name) ? ucfirst(strtolower(decryptGdprData($saleDetail->v_middle_name))) : '' }}"
                                                autocomplete="off" />
                                            <span class="text-danger errors" id="middle_name_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label required fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.last_name.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="last_name"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ __('sale_detail.view.customer.customer_info.last_name.placeHolder') }}"
                                                value="{{ isset($saleDetail->v_last_name) ? ucfirst(strtolower(decryptGdprData($saleDetail->v_last_name))) : '' }}"
                                                autocomplete="off" />
                                            <span class="text-danger errors" id="last_name_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label required fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.email.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="email"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ __('sale_detail.view.customer.customer_info.email.placeHolder') }}"
                                                value="{{ isset($saleDetail) ? strtolower(decryptGdprData($saleDetail->v_email)) : '' }}"
                                                autocomplete="off" />
                                            <span class="text-danger errors" id="email_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label required fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.phone.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="phone"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ __('sale_detail.view.customer.customer_info.phone.placeHolder') }}"
                                                value="{{ isset($saleDetail) ? decryptGdprData($saleDetail->v_phone) : '' }}"
                                                autocomplete="off" />
                                            <span class="text-danger errors" id="phone_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.alternate_phone.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="alternate_phone"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ __('sale_detail.view.customer.customer_info.alternate_phone.placeHolder') }}"
                                                value="{{ isset($saleDetail) ? decryptGdprData($saleDetail->v_alternate_phone) : '' }}"
                                                autocomplete="off" />
                                            <span class="text-danger errors" id="alternate_phone_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.dob.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="dob"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 customer_info_dob"
                                                placeholder="{{ __('sale_detail.view.customer.customer_info.dob.placeHolder') }}"
                                                value="{{ isset($saleDetail) ? $saleDetail->v_dob : '' }}"
                                                autocomplete="off" id="dob" />
                                            <span class="text-danger errors" id="dob_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-6">
                                        <label
                                            class="col-lg-3 col-form-label fw-bold fs-6">{{ __('sale_detail.view.customer.customer_info.comment.label') }}</label>
                                        <div class="col-lg-6 fv-row">
                                            <textarea name="comment" id="comment"
                                                placeholder="{{ __('sale_detail.view.customer.customer_info.comment.placeHolder') }}"
                                                class="form-control form-control-lg form-control-solid comment"></textarea>
                                            <span class="text-danger errors" id="comment_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="javascript:void(0);" type="button"
                                class="btn btn-light btn-active-light-primary me-2 close_sales_form_btn"
                                data-initial="customer_info_edit" data-for="customer_info_show"
                                data-form="customer_info_form">{{ __('handset.formPage.basicDetails.cancelButton') }}</a>
                            <button type="button" class="btn btn-primary submit_btn" id="customer_info_form_submit_btn"
                                data-form="customer_info_form">{{ __('handset.formPage.basicDetails.submitButton') }}</button>
                        </div>
                    </form>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
    <div id="customer_info_history" style="display: none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Customer Info</h2>
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
                                    <th class="text-muted text-capitalize text-nowrap text-center">Show Update History</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bolder text-gray-600" id="customer_info_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button"
                        class="btn btn-primary close_section"
                        data-initial="customer_info_history" data-for="customer_info_show">{{ __('buttons.close') }}</a>
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>

<div class="modal fade" id="show_customer_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Customer Info Update History</h2>
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
                        <div class="table-responsive customer_info_table">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Title</div>
                                        </td>
                                        <td class="fw-bolder text-end customer_history_title_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">First Name</div>
                                        </td>
                                        <td class="fw-bolder text-end text-capitalize customer_history_f_name_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Middle Name</div>
                                        </td>
                                        <td class="fw-bolder text-end text-capitalize customer_history_m_name_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Last Name</div>
                                        </td>
                                        <td class="fw-bolder text-end text-capitalize customer_history_l_name_td">
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>

                    <!-- right side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Email</div>
                                        </td>
                                        <td class="fw-bolder text-end text-lowercase customer_history_email_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Phone Number</div>
                                        </td>
                                        <td class="fw-bolder text-end customer_history_phone_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Alternate Phone Number</div>
                                        </td>
                                        <td class="fw-bolder text-end customer_history_alt_phone_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">DOB</div>
                                        </td>
                                        <td class="fw-bolder text-end customer_history_dob_td">
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

