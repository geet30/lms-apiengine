<div class="tab-pane fade show active" id="basic_details" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#basic_details_section">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('handset.formPage.basicDetails.sectionTitle')}}</h3>
            </div>
        </div>
        <div id="basic_details_section" class="collapse show">
            <!--begin::Form-->
            <form id = 'phone_basic_details_form' name = 'phone_basic_details_form' class="form" enctype="multipart/form-data">
                <!--begin::Card body-->
                @if (isset($phone))
                    <input type="hidden" name="phone_id" id="phone_id" value="{{ isset($phone) ? encryptGdprData($phone->id) : '' }}">
                @endif
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.basicDetails.phone_name.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('handset.formPage.basicDetails.phone_name.placeHolder')}}" value="{{isset($phone) ? $phone->name :''}}" autocomplete="off" />
                            <span class="text-danger errors" id="name_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.basicDetails.phone_brand.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <select class="form-select form-select-solid" name="brand_id" data-control="select2" data-hide-search="false" aria-label="{{ __ ('handset.formPage.basicDetails.phone_brand.placeHolder')}}" data-placeholder="{{ __ ('handset.formPage.basicDetails.phone_brand.placeHolder')}}" aria-hidden="true" tabindex="-1">
                                <option value=""></option>
                                @foreach($brandNames as $id => $name)
                                <option value="{{$id}}" {{isset($phone) && $phone->brand_id == $id ? 'selected' :''}}>{{$name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger errors" id="brand_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.basicDetails.phone_model.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="model" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('handset.formPage.basicDetails.phone_model.placeHolder')}}" value="{{isset($phone) ? $phone->model :''}}" autocomplete="off" />
                            <span class="text-danger errors" id="model_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.basicDetails.launch_details.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="launch_detail" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('handset.formPage.basicDetails.launch_details.placeHolder')}}" value="{{isset($phone) ? $phone->launch_detail :''}}" autocomplete="off" />
                            <span class="text-danger errors" id="launch_details_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __ ('handset.formPage.basicDetails.image.label')}}</label>
                        <div class="col-lg-8 fv-row logo">
                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('/common/media/avatars/blank.png')">
                                @if(isset($phone->image))
                                @php
                                $logo = $phone->image;
                                @endphp
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{$logo }}')"></div>
                                @else
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url('/common/media/avatars/blank.png')"></div>
                                @endif
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Logo">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                </label>
                            </div>
                            <div class="form-text">Allowed file types: png, jpg.</div>
                            <div class="form-text">Logo dimensions must be 300*130 pixels</div>
                            <span class="text-danger errors" id="image_error"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.basicDetails.pre_order_allowed.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" type="radio" name="is_pre_order" {{isset($phone) && $phone->is_pre_order == 1 ? 'checked':''}} value="1" />
                                    <span class="form-check-label">Yes</span>
                            </label>
                                <!--end::Option-->
                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" type="radio" name="is_pre_order" {{isset($phone) && $phone->is_pre_order == 0 ? 'checked':''}} value="0" checked />
                                    <span class="form-check-label">No</span>
                                </label>
                                <span class="text-danger errors" id="is_pre_order_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.basicDetails.why_this.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="why_this" id="why_this" placeholder="{{ __ ('handset.formPage.basicDetails.why_this.placeHolder')}}" class="form-control form-control-lg form-control-solid ckeditor">{{isset($phone) ? $phone->why_this : ''}}</textarea>
                            <span class="text-danger errors" id="why_this_error"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __ ('handset.formPage.basicDetails.other_info.label')}}</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="other_info" id="other_info" placeholder="{{ __ ('handset.formPage.basicDetails.other_info.placeHolder')}}" class="form-control form-control-lg form-control-solid ckeditor">{{isset($phone)?$phone->other_info:''}}</textarea>
                            <span class="text-danger errors" id="other_info_error"></span>
                        </div>
                    </div>
                   

                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ theme()->getPageUrl('/mobile/handsets') }}" type="button" class="btn btn-light btn-active-light-primary me-2">{{ __ ('handset.formPage.basicDetails.cancelButton')}}</a>
                    <button type="button" class="btn btn-primary submit_btn" id="phone_basic_details_form_submit_btn" data-form="phone_basic_details_form">{{ __ ('handset.formPage.basicDetails.submitButton')}}</button>
                </div>
            </form>
            <!--end::Input group-->
        </div>
    </div>
    <!--end::Card body-->
</div>
<!--end::Content-->