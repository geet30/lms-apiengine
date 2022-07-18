<div class="tab-pane fade" id="acknowlegement" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{__('plans/broadband.acknowledgement_concent')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_ack_info" class="collapse show">
                <!--begin::Form-->
                <form id="ack_info_form" class="form">
                    <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}" id="plan_id">
                    <input type='hidden' name='eic_id' value="{{isset($plan->planEicContents) ? $plan->planEicContents->id :''}}">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.enable_plan_acknowledgement.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="status" type="radio" value="1" {{(isset($plan->planEicContents) && $plan->planEicContents->status == 1) ? 'checked' :''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.enable')}}</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid is-valid">
                                            <input class="form-check-input" name="status" type="radio" value="0" {{((isset($plan->planEicContents) && $plan->planEicContents->status != 1) || !isset($plan->planEicContents)) ? 'checked' :''}}>
                                            <span class="fw-bold ps-2 fs-6">{{__('plans/broadband.disable')}}</span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <span class="error text-danger status-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('plans/broadband.description.label')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <textarea type="text" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="content" style="display: none;">{{isset($plan->planEicContents)?$plan->planEicContents->content :''}}</textarea>
                                <span class="error text-danger"></span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                        <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
        </div>
    </div>

    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{__('plans/broadband.plan_acknowledgement_concent_checkboxes')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_plan_info" class="collapse show">
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="button" class="btn btn-primary add-eic-content" data-bs-toggle="modal" data-bs-target="#add_provider_ack_checkbox">+ {{__('plans/broadband.add_checkbox')}}</button>
            </div>
            <form class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="pt-0 table-responsive">
                        <!--begin::Table-->
                        <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="lead_data_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
                                    <th class="min-w-50px text-capitalize text-nowrap">{{__('plans/broadband.sr_no')}}</th>
                                    <th class="min-w-50 text-capitalize text-nowrap">{{__('plans/broadband.required')}}</th>
                                    <th class="min-w-30px text-capitalize text-nowrap">{{__('plans/broadband.content')}}</th>
                                    <th class="min-w-30px text-capitalize text-nowrap">{{__('plans/broadband.validation_message')}}</th>
                                    <th class="min-w-30px text-capitalize text-nowrap">{{__('plans/broadband.save_checkbox_status_in_database')}}</th>
                                    <th class="text-end min-w-70px text-capitalize text-nowrap">{{__('plans/broadband.action')}}</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600" id ="ack_contenct_checkbox_tbody">
                                 @if(isset($plan->planEicContentCheckbox) && count($plan->planEicContentCheckbox)>0)
                                    @foreach($plan->planEicContentCheckbox as $checkbox)
                                    <tr>
                                        <td>
                                            <p>
                                                {{$loop->iteration}}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                            {{$checkbox->required == 1? 'True': 'False'}}
                                            </p>
                                        </td>
                                        <td>
                                            {!! $checkbox->content !!}
                                        </td>
                                        <td>
                                            {!! $checkbox->validation_message !!}
                                        </td>
                                        <td>
                                            <p>
                                            {{$checkbox->status == 1? 'True': 'False'}}
                                        </p>
                                            </td>
                                        <td>
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{__('plans/broadband.action')}}
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                                            <div class="menu-item">
                                                <a class="menu-link px-3 edit_checkbox" data-bs-toggle="modal" data-bs-target="#add_provider_ack_checkbox"
                                                data-id="{{$checkbox->id}}"
                                                data-required="{{$checkbox->required}}"
                                                data-status="{{$checkbox->status}}"
                                                data-validation-message="{{$checkbox->validation_message}}"
                                                data-content="{{$checkbox->content}}"
                                                >{{__('plans/broadband.edit')}}</a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link px-3 delete_checkbox" data-id="{{$checkbox->id}}">{{__('plans/broadband.delete')}}</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            {{__('plans/broadband.no_checkbox_found')}}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
