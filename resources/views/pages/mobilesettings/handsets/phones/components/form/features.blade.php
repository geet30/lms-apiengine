<div class="tab-pane fade" id="features" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('handset.formPage.feature.sectionTitle')}}</h3>
            </div>
        </div>
        <div id="basic_details_section" class="collapse show">
            <!--begin::Form-->
            <form id = 'mobile_features_form' class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.feature.camera.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="camera" placeholder="{{ __ ('handset.formPage.feature.camera.placeHolder')}}" class="form-control form-control-lg form-control-solid ckeditor">{{isset($phone) ? $phone->camera : ''}}</textarea>
                            <span class="text-danger errors" id="camera_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.feature.sensor.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="sensors" placeholder="{{ __ ('handset.formPage.feature.sensor.placeHolder')}}" class="form-control form-control-lg form-control-solid ckeditor">{{isset($phone) ? $phone->sensors : ''}}</textarea>
                            <span class="text-danger errors" id="sensors_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.feature.technical_specs.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="technical_specs" placeholder="{{ __ ('handset.formPage.feature.technical_specs.placeHolder')}}" class="form-control form-control-lg form-control-solid ckeditor">{{isset($phone)?$phone->technical_specs:''}}</textarea>
                            <span class="text-danger errors" id="technical_specs_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.feature.battery_info.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="battery_info" placeholder="{{ __ ('handset.formPage.feature.battery_info.placeHolder')}}" class="form-control form-control-lg form-control-solid ckeditor">{{isset($phone)?$phone->battery_info:''}}</textarea>
                            <span class="text-danger errors" id="battery_info_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.feature.in_the_box.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="in_the_box" placeholder="{{ __ ('handset.formPage.feature.in_the_box.placeHolder')}}" class="form-control form-control-lg form-control-solid ckeditor">{{isset($phone)?$phone->in_the_box:''}}</textarea>
                            <span class="text-danger errors" id="in_the_box_error"></span>
                        </div>
                    </div>
                   

                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ theme()->getPageUrl('/mobile/handsets') }}" type="button" class="btn btn-light btn-active-light-primary me-2">{{ __ ('handset.formPage.feature.cancelButton')}}</a>
                    <button type="button" class="btn btn-primary submit_btn" id="mobile_features_form_submit_btn" data-form="mobile_features_form">{{ __ ('handset.formPage.feature.submitButton')}}</button>
                </div>
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!--end::Card body-->
</div>
<!--end::Content-->