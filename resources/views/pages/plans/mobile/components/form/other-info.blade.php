<div class="tab-pane fade" id="other-info" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#other_info_section">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.other_info.sectionTitle')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <form id="plan_other_info_form" class="form">
            <div id="other_info_section" class="collapse show">
                <!--begin::Form-->
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Repeater-->
                    <div id="kt_docs_repeater_advanced">
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="dynamicForm">
                                @foreach($plan->planMobileOtherInfo as $planMobileOtherInfo)
                                <div class="row dynamicRow" id="row-{{$loop->iteration}}" data-row="{{$loop->iteration}}">
                                    <div class="col-md-3">
                                        <label class="form-label">{{ __ ('mobile.formPage.other_info.other_info_field.label')}}</label>
                                        <input type="text" autocomplete="off" name="other_info_field[]" id="other_info_field_{{$loop->iteration}}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.other_info.other_info_field.placeHolder')}}" value="{{$planMobileOtherInfo->title}}" />
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">{{ __ ('mobile.formPage.other_info.other_info_desc.label')}}</label>
                                        <textarea name="other_info_desc[]" id="other_info_desc_{{$loop->iteration}}" class="form-control form-control-lg form-control-solid common_other_info_desc ckeditor" placeholder="{{ __ ('mobile.formPage.other_info.other_info_desc.placeHolder')}}">{{$planMobileOtherInfo->description}}</textarea>
                                    </div>
                                    @if($loop->iteration > 1)
                                    <div class="col-md-2">
                                        <a href="javascript:;" class="btn btn-sm btn-light-danger mt-3 mt-md-8 delete-row" data-row="{{$loop->iteration}}">
                                            <i class="la la-trash-o"></i>{{ __ ('mobile.formPage.other_info.deleteButton')}}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                                @if(count($plan->planMobileOtherInfo) == 0)
                                <div class="row dynamicRow" id="row-1" data-row="1">
                                    <div class="col-md-3">
                                        <label class="form-label">{{ __ ('mobile.formPage.other_info.other_info_field.label')}}</label>
                                        <input type="text" autocomplete="off" name="other_info_field[]" id="other_info_field_1" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.other_info.other_info_field.placeHolder')}}" value="" />
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">{{ __ ('mobile.formPage.other_info.other_info_desc.label')}}</label>
                                        <textarea name="other_info_desc[]" id="other_info_desc_1" class="form-control form-control-lg form-control-solid common_other_info_desc ckeditor" placeholder="{{ __ ('mobile.formPage.other_info.other_info_desc.placeHolder')}}"></textarea>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-5 mb-5">
                                <a href="javascript:;" class="btn btn-light-primary" id="addButton">
                                    <i class="la la-plus"></i>{{ __ ('mobile.formPage.other_info.addButton')}}
                                </a>
                            </div>

                        </div>
                        <!--end::Form group-->
                    </div>
                    <!--end::Repeater-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-primary submit_btn mx-2" id="plan_other_info_form_submit_btn" data-form="plan_other_info_form" data-title="Other Information">{{ __ ('mobile.formPage.other_info.submitButton')}}</button>
                        <a href="{{url('/provider/plans/mobile/'.$providerId)}}" class="btn btn-light btn-active-light-primary me-2" id="plan_other_info_form_reset_btn">{{ __ ('mobile.formPage.other_info.cancelButton')}}</a>
                    </div>
                    <!--end::Actions-->
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>