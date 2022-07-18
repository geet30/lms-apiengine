<!--begin::General options-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="post_submission_form" class="post_submission_form" name="post_submission_form">
        @csrf
        <div class="card card-flush py-4">
            <!--begin::Card body-->
            <div class="card-body px-8">
                <!--begin::Input group-->
                <div class="row mb-3">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label fw-bold fs-6">What Happen Next Parameter </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12">
                        <select data-control="select2" data-placeholder="" data-hide-search="true" name="post_submission_parameter" data-id="post_submission_parameter" id="select_selectsplitter1" class="form-select post_submission_parameter" size="5">
                            <option value="@Affiliate-Abn@" class="post_sub_parameter">@Affiliate-Abn@</option>
                            <option value="@Affiliate-Name@" class="post_sub_parameter">@Affiliate-Name@</option>
                            <option value="@Affiliate-Address@" class="post_sub_parameter">@Affiliate-Address@</option>
                            <option value="@Affiliate-Contact-Number@" class="post_sub_parameter">@Affiliate-Contact-Number@</option>
                            <option value="@Plan-Name@" class="post_sub_parameter">@Plan-Name@</option>
                            <option value="@Plan-Type@" class="post_sub_parameter">@Plan-Type@</option>
                            <option value="@Connection-Type@" class="post_sub_parameter">@Connection-Type@</option>
                            <option value="@Provider-Name@" class="post_sub_parameter">@Provider-Name@</option>
                            <option value="@Reference-ID@" class="post_sub_parameter">@Reference-ID@</option>
                            <option value="@Customer-Name@" class="post_sub_parameter">@Customer-Name@</option>
                            <option value="@Customer-Email@" class="post_sub_parameter">@Customer-Email@</option>
                            <option value="@Customer-Contact-Number@" class="post_sub_parameter">@Customer-Contact-Number@</option>
                            <option value="@Service-Type@" class="post_sub_parameter">@Service-Type@</option>
                            <option value="@Plan-Monthly-Cost@" class="post_sub_parameter">@Plan-Monthly-Cost@</option>
                            <option value="@Customer-Last-Name@" class="post_sub_parameter">@Customer-Last-Name@</option>
                            <option value="@Provider-Contact-Number@" class="post_sub_parameter">@Provider-Contact-Number@</option>
                        </select>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-3">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label required fw-bold fs-6">What Happen Next Content</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12 what_happen_next_content">
                        <textarea type="text" id="what_happen_next_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="what_happen_next_content">{{$what_happen_next["description"] ?? ''}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-3">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label required fw-bold fs-6">Why Us</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12 why_us_content">
                        <textarea type="text" id="why_us_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="why_us_content">{{$what_happen_next["why_us"] ?? ''}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <div class="card-footer pt-0 px-8">
                <div class="pull-right">
                    <!--begin::Button-->
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="post_submission_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </form>
    @if(isset($provider_details) && $provider_details[0]['service_id']!=2)
    <div class="card card-flush py-0 px-0">
     
        <div class="card-header border-0 pt-0 px-8">
            <div class="card-title">
                <h2>Post Submission Checkboxes</h2>
            </div>
            <div class="pull-right card-toolbar">
                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#add_post_submission_checkbox" id="post_submission_checkbox_button">+Add Checkbox</button>
            </div>
        </div>

        <div class="card-body px-8 pt-0 table-responsive">
            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="post_submissionn_checkbox_table">
                <thead>
                    <tr class="fw-bolder fs-6 text-gray-600 px-7">
                        <th class="text-capitalize text-nowrap">Sr. No.</th>
                        <th class="text-capitalize text-nowrap">Required</th>
                        <th class="text-capitalize text-nowrap">Content</th>
                        <th class="text-left text-capitalize text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600" id="post_submission_list">
                @if(!empty($post_submission_checkboxs) && count($post_submission_checkboxs) > 0)
                    @foreach($post_submission_checkboxs as $key => $value)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$value["checkbox_required"] ? 'Yes' : 'No'}}</td>
                        <td title="{{ strip_tags($value['content']) }}">
                            <span class="ellipses_table"> {{ strip_tags($value['content'])}}</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                       
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                </svg>
                            </span>
                          </a>
                            
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                               
                                <div class="menu-item px-3">
                                    <a class="menu-link px-3 edit_post_sub" id="post_submission_checkbox_edit" data-bs-toggle="modal" data-bs-target="#add_post_submission_checkbox" data-id="{{$value["id"]}}" data-eic="{{$value["type"]}}" 
                                    data-order="{{$value['order']}}" data-required_checkbox="{{$value["checkbox_required"]}}" data-save_checkbox="{{$value["status"]}}" data-validation_message="{{$value["validation_message"]}}" data-checkbox_content="{{$value["content"]}}" >Edit</a>
                                    <a type="button" id="ack_checkbox_delete" data-id="{{$value["id"]}}" class="menu-link px-3">Delete</a>
                                </div>
                            </div>
                          
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>


<!--begin::Modal - Adjust Balance-->
<div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false"  id="add_post_submission_checkbox" tabindex="-1" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">Post Submission Checkbox</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y">
                <!--begin::Form-->
                <form role="form" id="post_submission_checkbox_form" class="post_submission_checkbox_form" name="post_submission_checkbox_form">
                    @csrf
                    <!--begin::Input group-->
                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="col-lg-6 required fw-bold fs-6 mb-5">Checkbox Required</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 post_submission_checkbox_required">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input id="post_submission_checkbox_required_yes" class="form-check-input radio-w-h-18" name="post_submission_checkbox_required" type="radio" value="1" checked />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <input id="post_submission_checkbox_required_no" class="form-check-input radio-w-h-18" name="post_submission_checkbox_required" type="radio" value="0" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                            <p><span class="error text-danger"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-5 field-holder post_sub_validation_msg">
                        <!--begin::Label-->
                        <label class="col-lg-12 required col-form-label fw-bold fs-6">Validation Message</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="post_submission_validation_msg">
                            <textarea type="text" id="post_submission_validation_msg" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="3" name="post_submission_validation_msg"></textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="row mb-3">
                        <label class="col-lg-6 col-form-label required fs-5 fw-bold mb-1">Order </label>

                        <div class="col-lg-6 order">
                            <input type="number" class="form-control form-control-lg form-control-solid h-50px border" id="post_submission_checkbox_order" placeholder="e.g. 5" name="order">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <!--begin::Input group-->
                    <div class="fv-row mb-5 field-holder">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1 required">Checkbox Content</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="post_submission_checkbox_content">
                            <textarea type="text" id="post_submission_checkbox_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="3" name="post_submission_checkbox_content"></textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </form>
                <!--end::Form-->
                <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="post_submission_checkbox_submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
            <!--end::Modal body-->

        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
