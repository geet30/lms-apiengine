<div class="tab-pane fade show mb-5" id="qa_section" role="tab-panel">
    <div id="qa_section_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>QA Section</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder text-primary me-6 show_history"
                        data-lead_id={{ $saleDetail->l_lead_id }} data-vertical_id={{ $verticalId }} data-section = 'qa_section'
                        data-for="qa_section_history" data-initial="qa_section_show">Show History</a>

                        <a href="javascript:void(0);" class="fw-bolder text-primary float-end edit_sales_btn" data-for="qa_section_edit" data-initial="qa_section_show">
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-pencil-square text-primary" aria-hidden="true"></i></span>Edit
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                            <tbody class="fw-bold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">QA Comment:</div>
                                    </td>
                                    <td class="fw-bolder text-end qa_comment_td">{{ isset($saleQaSection) ? $saleQaSection->qa_comment : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Sale Comment:</div>
                                    </td>
                                    <td class="fw-bolder text-end qa_sale_comment_td">{{ isset($saleQaSection) ? $saleQaSection->sale_comment : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Rework Comment:</div>
                                    </td>
                                    <td class="fw-bolder text-end qa_rework_comment_td">{{ isset($saleQaSection) ? $saleQaSection->rework_comment : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Assigned Agent:</div>
                                    </td>
                                    <td class="fw-bolder text-end qa_assigned_agent_td">{{ isset($saleQaSection) ? $saleQaSection->assigned_agent : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">Completed By:</div>
                                    </td>
                                    <td class="fw-bolder text-end qa_sale_completed_by_td">
                                        @if (isset($saleQaSection) && $saleQaSection->sale_completed_by == 1)
                                            <span>Customer</span>
                                        @elseif (isset($saleQaSection) && $saleQaSection->sale_completed_by == 2)
                                            <span>Agent</span>
                                        @elseif (isset($saleQaSection) && $saleQaSection->sale_completed_by == 3)
                                            <span>Agent Assisted</span>
                                        @else
                                            <span>N/A</span>
                                        @endif
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
    <div id="qa_section_edit" style="display: none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>QA Section Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                   <!--begin::Form-->
                    <form id = 'qa_section_form' name = 'qa_section_form' class="form">
                        <!--begin::Card body-->
                            <input type="hidden" name="lead_id" id="lead_id" value="{{ isset($saleDetail) ? $saleDetail->l_lead_id : '' }}">
                            <input type="hidden" name="vertical_id" id="vertical_id" value="{{ isset($verticalId) ? $verticalId : '' }}">
                    
                        <div class="card-body border-top p-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-6">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">QA Comment</label>
                                        <div class="col-lg-6 fv-row">
                                            <textarea name="qa_comment" placeholder="e.g. QA is passed" class="form-control form-control-lg form-control-solid" autocomplete="off">{{ isset($saleQaSection) ? $saleQaSection->qa_comment : '' }}</textarea>
                                            <span class="text-danger errors" id="qa_comment_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-6">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">Sale Comment</label>
                                        <div class="col-lg-6 fv-row">
                                            <textarea name="sale_comment" placeholder="e.g. Duplicate sale" class="form-control form-control-lg form-control-solid" autocomplete="off">{{ isset($saleQaSection) ? $saleQaSection->sale_comment : '' }}</textarea>
                                            <span class="text-danger errors" id="sale_comment_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-6">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">Rework Comment</label>
                                        <div class="col-lg-6 fv-row">
                                            <textarea name="rework_comment" placeholder="e.g. Rework required" class="form-control form-control-lg form-control-solid" autocomplete="off">{{ isset($saleQaSection) ? $saleQaSection->rework_comment : '' }}</textarea>
                                            <span class="text-danger errors" id="rework_comment_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-6">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">Assigned Agent</label>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="assigned_agent" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. Assigned to Adam" value="{{ isset($saleQaSection) ? $saleQaSection->assigned_agent : '' }}" autocomplete="off" />
                                            <span class="text-danger errors" id="assigned_agent_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-6">
                                        <label class="col-lg-3 col-form-label required fw-bold fs-6">Completed By</label>
                                        <div class="col-lg-6 fv-row">
                                            <select class="form-select form-select-solid" name="sale_completed_by" data-control="select2" data-hide-search="false" aria-label="{{ __ ('handset.formPage.basicDetails.phone_brand.placeHolder')}}" data-placeholder="{{ __ ('handset.formPage.basicDetails.phone_brand.placeHolder')}}" aria-hidden="true" tabindex="-1">
                                                <option value=""></option>
                                                @foreach($qaSaleCompletedBy as $id => $name)
                                                <option value="{{$id}}" {{isset($saleQaSection) && $saleQaSection->sale_completed_by == $id ? 'selected' :''}}>{{$name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger errors" id="sale_completed_by_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-6">
                                        <label class="col-lg-3 col-form-label fw-bold fs-6">{{ __ ('sale_detail.view.customer.customer_info.comment.label')}}</label>
                                        <div class="col-lg-6 fv-row">
                                            <textarea name="comment" id="comment" placeholder="e.g. Required Details missing" class="form-control form-control-lg form-control-solid comment"></textarea>
                                            <span class="text-danger errors" id="comment_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="javascript:void(0);" type="button" class="btn btn-light btn-active-light-primary me-2 close_sales_form_btn" data-initial="qa_section_edit" data-for="qa_section_show" data-form="qa_section_form">{{ __ ('handset.formPage.basicDetails.cancelButton')}}</a>
                            <button type="button" class="btn btn-primary submit_btn" id="qa_section_form_submit_btn" data-form="qa_section_form">{{ __ ('handset.formPage.basicDetails.submitButton')}}</button>
                        </div>
                    </form>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
    <div id="qa_section_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>QA Section</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="qa_section_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="qa_section_history"
                        data-for="qa_section_show">{{ __('buttons.close') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_qa_section_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">QA Section Update History</h2>
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
                                    <div class="d-flex align-items-center">QA Comment:</div>
                                </td>
                                <td class="fw-bolder text-end qa_comment_history_td">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Sale Comment:</div>
                                </td>
                                <td class="fw-bolder text-end qa_sale_comment_history_td">
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Rework Comment:</div>
                                </td>
                                <td class="fw-bolder text-end qa_rework_comment_history_td">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Assigned Agent:</div>
                                </td>
                                <td class="fw-bolder text-end qa_assigned_agent_history_td">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">Completed By:</div>
                                </td>
                                <td class="fw-bolder text-end qa_sale_completed_by_history_td">
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
