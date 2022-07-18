    <div class="card">

        <div id="kt_affliate_form_details" class="">
            <form class="" method="POST" action='/affiliates/saveidmatrix' accept-charset="UTF-8" id="aff_idmatrix_form">
                @csrf
                <input type="hidden" value="" name="user_id" id="matrix_user_id">
                <input type="hidden" value="" name="edit_id" id="matrix_edit_id">

                <div class="card border-top p-9">

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('affiliates_label.id_matrix.enable_id_matrix') }} </label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="id_matrix_enable" type="radio" value="1" id="id_matrix_enable" />
                                    <span class=" fw-bold ps-2 fs-6">
                                        {{ __('affiliates_label.id_matrix.active') }}
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input radio-w-h-18" name="id_matrix_enable" type="radio" value="0" id="id_matrix_enable" checked />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('affiliates_label.id_matrix.inactive') }}
                                    </span>
                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('affiliates_label.id_matrix.verify_secondary_id') }} </label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="secondary_identification_allow" type="radio" value="1" id="secondary_identification_allow" />
                                    <span class=" fw-bold ps-2 fs-6">
                                        {{ __('affiliates_label.id_matrix.yes') }}
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input radio-w-h-18" name="secondary_identification_allow" type="radio" value="0" id="secondary_identification_allow" checked />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('affiliates_label.id_matrix.no') }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6"> {{ __('affiliates_label.id_matrix.service') }}</label>
                        <div class="col-lg-8 fv-row">
                            <select name="services[]" id="services" class="form-select form-select-solid form-select-lg" data-control="select2" data-placeholder="Please select" data-hide-search="true" multiple="multiple">

                            </select>
                            <span class="form_error" style="color: red;"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6"> {{ __('affiliates_label.id_matrix.parameters') }}</label>
                        <div class="col-lg-8 fv-row">
                            <select name="matrix_attributes" id="matrix_attributes" class=" form-select form-select-solid form-select-lg" multiple>
                                <option value=" @Affiliate-Name@">@Affiliate-Name@</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('affiliates_label.id_matrix.status') }}</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="matrix_content_key_enable" id="matrix_content_key_enable" type="radio" value="1" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('affiliates_label.id_matrix.active') }}
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input radio-w-h-18" name="matrix_content_key_enable" id="matrix_content_key_enable" type="radio" value="0" checked />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('affiliates_label.id_matrix.inactive') }}
                                    </span>
                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('affiliates_label.id_matrix.identification_types') }}</label>
                        <div class="col-lg-8 fv-row service_div">
                            <div class="form-check form-check-custom form-check-solid mb-5">
                                <input class="form-check-input me-3" name="medicare_card" type="checkbox" value="1" id="medicare_card">
                                <label class="form-check-label" for="medicare_card">
                                    <div class="fw-bolder text-gray-800">{{ __('affiliates_label.id_matrix.medicare_card') }}</div>
                                </label>
                            </div>
                            <div class="form-check form-check-custom form-check-solid mb-5">
                                <input class="form-check-input me-3" name="foreign_passport" id="foreign_passport" type="checkbox" value="1">
                                <label class="form-check-label" for="foreign_passport">
                                    <div class="fw-bolder text-gray-800">{{ __('affiliates_label.id_matrix.foreign_passport') }}</div>
                                </label>
                            </div>
                            <div class="form-check form-check-custom form-check-solid mb-5">
                                <input class="form-check-input me-3" name="driver_license" type="checkbox" value="1" id="driver_license">
                                <label class="form-check-label" for="driver_license">
                                    <div class="fw-bolder text-gray-800">{{ __('affiliates_label.id_matrix.driver_license') }}</div>
                                </label>
                            </div>
                            <div class="form-check form-check-custom form-check-solid mb-5">
                                <input class="form-check-input me-3" name="australian_passport" type="checkbox" value="1" id="australian_passport">
                                <label class="form-check-label" for="australian_passport">
                                    <div class="fw-bolder text-gray-800">{{ __('affiliates_label.id_matrix.australian_passport') }}</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('affiliates_label.id_matrix.content') }}</label>


                        <div class="col-lg-8 fv-row field-holder">
                            <textarea name="matrix_content" class="form-control form-control-lg form-control-solid ckeditor" id="matrix_content"></textarea>
                            <span class="form_error" style="color: red;"></span>
                        </div>
                    </div>

                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9 border-0">
                    <a href="{{ theme()->getPageUrl('affiliates/list') }}" class="btn btn-white btn-active-light-primary me-2">{{ __('buttons.cancel') }}</a>
                    <button type="submit" class="btn btn-primary" id="add_matrix">

                        <span class="indicator-label">{{ __('buttons.save') }}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
