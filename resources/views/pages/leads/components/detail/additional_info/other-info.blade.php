<div class="tab-pane fade show mb-5" role="tab-panel">
    <div id="other_info_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Others Information</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder me-6 text-primary show_history"
                        data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                        data-vertical_id="{{ $verticalId ?? '' }}" data-section='other_info'
                        data-for="other_info_history" data-initial="other_info_show">Show
                        History</a>

                        <a href="javascript:void(0);" class="fw-bolder text-primary float-end edit_sales_btn" data-for="other_info_edit" data-initial="other_info_show">
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-pencil-square text-primary" aria-hidden="true"></i></span>Edit
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <!-- left side -->
                        <div class="col-md-6 px-5">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Token:</div>
                                            </td>
                                            <td class="fw-bolder text-end token_td">{{ isset($saleOtherInfo) ? $saleOtherInfo->token : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Note From CIMET (Will be sent to retailers):</div>
                                            </td>
                                            <td class="fw-bolder text-end qa_notes_td">{{ isset($saleOtherInfo) ? $saleOtherInfo->qa_notes : 'N/A'  }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Life support Notes (In case of other option):</div>
                                            </td>
                                            <td class="fw-bolder text-end life_support_notes_td">
                                                {{ isset($saleOtherInfo) ? $saleOtherInfo->life_support_notes : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Other Created Date:</div>
                                            </td>
                                            <td class="fw-bolder text-end qa_notes_created_date_td">
                                                {{ isset($saleOtherInfo) ? $saleOtherInfo->qa_notes_created_date : 'N/A' }}
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
                                                <div class="d-flex align-items-center">Resubmission Comment for retailers:</div>
                                            </td>
                                            <td class="fw-bolder text-end retailors_resubmission_comment_td">{{  isset($saleOtherInfo) ? $saleOtherInfo->retailers_resubmission_comment : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">Pin Number:</div>
                                            </td>
                                            <td class="fw-bolder text-end pin_number_td">{{ isset($saleOtherInfo) ? $saleOtherInfo->pin_number : 'N/A' }}
                                            </td>
                                        </tr>
                                        @if (config('env.SIMPLYENERGY_ID'))
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Sale Agent:</div>
                                                </td>
                                                <td class="fw-bolder text-end sale_agent_td">{{ isset($saleOtherInfo) ? $saleOtherInfo->sale_agent : 'N/A' }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if(config('env.SIMPLYENERGY_ID') == $saleDetail->sale_product_provider_id)
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">Simply Reward ID:</div>
                                                </td>
                                                <td class="fw-bolder text-end simply_reward_id_td">
                                                    {{ isset($saleOtherInfo->simply_reward_id) ? $saleOtherInfo->simply_reward_id : 'N/A' }}
                                                </td>
                                            </tr>
                                        @endif
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

    <div id="other_info_edit" style="display: none;">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Other Information Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                   <!--begin::Form-->
                    <form id = 'other_info_form' name = 'other_info_form' class="form">
                        <!--begin::Card body-->
                            <input type="hidden" name="lead_id" class="lead_id" id="lead_id" value="{{ isset($saleDetail) ? $saleDetail->l_lead_id : '' }}">

                            <div class="card-body border-top p-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Token</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="token" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. ENE111111" value="{{isset($saleOtherInfo) ? $saleOtherInfo->token :''}}" autocomplete="off" />
                                                <span class="text-danger errors" id="token_error"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Note From CIMET (Will be sent to retailers) </label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="qa_notes" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. Sale is Ready" value="{{isset($saleOtherInfo) ? $saleOtherInfo->qa_notes :''}}" autocomplete="off" />
                                                <span class="text-danger errors" id="qa_notes_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Life support Notes (In case of other option)</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="life_support_notes" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. Not applicable" value="{{isset($saleOtherInfo) ? $saleOtherInfo->life_support_notes :''}}" autocomplete="off" />
                                                <span class="text-danger errors" id="life_support_notes_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Other Created Date</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="qa_notes_created_date" id="qa_notes_created_date" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 01/01/2023" value="{{isset($saleOtherInfo) ? $saleOtherInfo->qa_notes_created_date :''}}" autocomplete="off" readonly/>
                                                <span class="text-danger errors" id="qa_notes_created_date_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Resubmission comment for retailers</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="retailers_resubmission_comment" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. Ready for submission" value="{{isset($saleOtherInfo) ? $saleOtherInfo->retailers_resubmission_comment :''}}" autocomplete="off" />
                                                <span class="text-danger errors" id="retailers_resubmission_comment_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-6">
                                            <label class="col-lg-3 col-form-label fw-bold fs-6">Pin Number</label>
                                            <div class="col-lg-6 fv-row">
                                                <input type="text" name="pin_number" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. 0101" value="{{isset($saleOtherInfo) ? $saleOtherInfo->pin_number :''}}" autocomplete="off" />
                                                <span class="text-danger errors" id="pin_number_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(config('env.SIMPLYENERGY_ID') == $saleDetail->sale_product_provider_id)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">Simply Reward Plan Membership Id</label>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="simply_reward_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="e.g. SIM01111" value="{{isset($saleOtherInfo) ? $saleOtherInfo->simply_reward_id :''}}" autocomplete="off" />
                                                    <span class="text-danger errors" id="simply_reward_id_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (config('env.SIMPLYENERGY_ID'))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">Sale Agent</label>
                                                <div class="col-lg-6 fv-row">
                                                    <select class="form-select form-select-solid" name="sale_agent" data-control="select2" data-hide-search="false" aria-label="Select" data-placeholder="Select" aria-hidden="true" tabindex="-1">
                                                        <option value=""></option>
                                                        @foreach($saleAgentTypes as $key => $name)
                                                        <option value="{{$key}}" {{isset($saleOtherInfo) && $saleOtherInfo->sale_agent == $key ? 'selected' :''}}>{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger errors" id="sale_agent_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-6">
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
                            <a href="javascript:void(0);" type="button" class="btn btn-light btn-active-light-primary me-2 close_sales_form_btn" data-initial="other_info_edit" data-for="other_info_show" data-form="other_info_form">{{ __ ('handset.formPage.basicDetails.cancelButton')}}</a>
                            <button type="button" class="btn btn-primary submit_btn" id="other_info_form_submit_btn" data-form="other_info_form">{{ __ ('handset.formPage.basicDetails.submitButton')}}</button>
                        </div>
                    </form>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>

    <div id="other_info_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Other Information</h2>
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
                            <tbody class="fw-bolder text-gray-600" id="other_info_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="other_info_history"
                        data-for="other_info_show">{{ __('buttons.close') }}</a>
                </div>

                <!--end::Documents-->
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="show_other_info_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Other Information Update History</h2>
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
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Token:</div>
                                        </td>
                                        <td class="fw-bolder text-end token_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Note From CIMET (Will be sent to retailers):</div>
                                        </td>
                                        <td class="fw-bolder text-end qa_notes_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Life support Notes (In case of other option):</div>
                                        </td>
                                        <td class="fw-bolder text-end life_support_notes_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Other Created Date:</div>
                                        </td>
                                        <td class="fw-bolder text-end qa_notes_created_date_history_td">
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
                                            <div class="d-flex align-items-center">Resubmission Comment for retailers:</div>
                                        </td>
                                        <td class="fw-bolder text-end retailors_resubmission_comment_history_td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Pin Number:</div>
                                        </td>
                                        <td class="fw-bolder text-end pin_number_history_td">
                                        </td>
                                    </tr>
                                    @if (config('env.SIMPLYENERGY_ID'))
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Sale Agent:</div>
                                        </td>
                                        <td class="fw-bolder text-end sale_agent_history_td">
                                        </td>
                                    </tr>
                                @endif
                                @if(config('env.SIMPLYENERGY_ID') == $saleDetail->sale_product_provider_id)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Simply Reward ID:</div>
                                        </td>
                                        <td class="fw-bolder text-end simply_reward_id_history_td">
                                        </td>
                                    </tr>
                                @endif
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
