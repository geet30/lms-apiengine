<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="site_access_info_show">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-3 gap-lg-10">
            <div class="card col-md-4 card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title d-inline">
                        <h2 class="mt-5">Site Access Information</h2>
                        <span class="fw-normal text-gray-600 fs-6">(Will Be Sent To Retailers)<span>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder me-6 text-primary show_history"
                        data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                        data-vertical_id="{{ $verticalId ?? '' }}" data-section='site_access'
                        data-for="site_access_history" data-initial="site_access_info_show">Show
                        History</a>

                        <a href="javascript:void(0);" class="fw-bolder text-primary float-end edit_sales_btn" data-for="site_access_info_edit" data-initial="site_access_info_show">
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-pencil-square text-primary" aria-hidden="true"></i></span>Edit
                        </a>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive site_access_info_table">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Meter Hazards</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_meter_hazard_td">{{ $saleDetail->vie_meter_hazard ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Site Access Electricity</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_site_access_electricity_td">
                                                {{ $saleDetail->vie_site_access_electricity ?? 'N/A' }}
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
                                                <div class="d-flex align-items-center">DOG CODE</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_dog_code_td">
                                                {{ $saleDetail->vie_dog_code ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Site Access Gas</div>
                                            </td>
                                            <td class="fw-bolder text-end vie_site_access_gas_td">{{ $saleDetail->vie_site_access_gas ?? 'N/A' }}
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
        </div>
    </div>
    <div id="site_access_info_edit" style="display: none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title d-inline">
                        <h2>Site Access Information Edit</h2>
                        <span class="fw-normal text-gray-600 fs-6">(Will Be Sent To Retailers)<span>
                    </div>
                </div>
                <div class="card-body pt-0">
                   <!--begin::Form-->
                   <form id = 'site_access_info_form' name = 'site_access_info_form' class="form">
                        <!--begin::Card body-->
                        <input type="hidden" name="visitor_info_energy_id" class="visitor_info_energy_id" id="visitor_info_energy_id" value="{{ isset($saleDetail) ? $saleDetail->vie_id : '' }}">

                        <input type="hidden" name="lead_id" value="{{ isset($saleDetail) ? $saleDetail->l_lead_id : '' }}">

                        <div class="card-body border-top p-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">Meter Hazards</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="meter_hazard" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. Asbestos box" value="{{isset($saleDetail) ? $saleDetail->vie_meter_hazard :''}}" autocomplete="off" />
                                            <span class="text-danger errors" id="meter_hazard_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">DOG CODE</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="dog_code" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. AB 2000" value="{{isset($saleDetail) ? $saleDetail->vie_dog_code :''}}" autocomplete="off" />
                                            <span class="text-danger errors" id="dog_code_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">Site Access Electricity</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="site_access_electricity" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. Electric Fence" value="{{isset($saleDetail) ? $saleDetail->vie_site_access_electricity :''}}" autocomplete="off" />
                                            <span class="text-danger errors" id="site_access_electricity_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">Site Access Gas</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="site_access_gas" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. Electric Fence" value="{{isset($saleDetail) ? $saleDetail->vie_site_access_gas :''}}" autocomplete="off" />
                                            <span class="text-danger errors" id="site_access_gas_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">{{ __ ('sale_detail.view.customer.customer_info.comment.label')}}</label>
                                        <div class="col-lg-6 fv-row">
                                            <textarea name="comment" id="comment" placeholder="{{ __ ('sale_detail.view.customer.customer_info.comment.placeHolder')}}" class="form-control form-control-lg form-control-solid comment"></textarea>
                                            <span class="text-danger errors" id="comment_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="javascript:void(0);" type="button" class="btn btn-light btn-active-light-primary me-2 close_sales_form_btn" data-initial="site_access_info_edit" data-for="site_access_info_show" data-form="site_access_info_form">{{ __ ('handset.formPage.basicDetails.cancelButton')}}</a>
                            <button type="button" class="btn btn-primary submit_btn" id="site_access_info_form_submit_btn" data-form="site_access_info_form">{{ __ ('handset.formPage.basicDetails.submitButton')}}</button>
                        </div>
                    </form>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
    <div id="site_access_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Site Access Information</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="site_access_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="site_access_history"
                        data-for="site_access_info_show">{{ __('buttons.close') }}</a>
                </div>

                <!--end::Documents-->
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="show_site_access_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Site Access Information Update History</h2>
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
                        <div class="table-responsive site_access_info_table">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Meter Hazards</div>
                                        </td>
                                        <td class="fw-bolder text-end vie_meter_hazard_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Site Access Electricity</div>
                                        </td>
                                        <td class="fw-bolder text-end vie_site_access_electricity_history_td">
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
                                            <div class="d-flex align-items-center">DOG CODE</div>
                                        </td>
                                        <td class="fw-bolder text-end vie_dog_code_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Site Access Gas</div>
                                        </td>
                                        <td class="fw-bolder text-end vie_site_access_gas_history_td">
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


