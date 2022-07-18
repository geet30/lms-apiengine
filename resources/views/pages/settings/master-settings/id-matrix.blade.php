<div class="tab-pane fade show" id="id-matrix-section" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">ID Matrix</h3>
            </div>
        </div>
        <form class="" method="POST" action='/settings/saveidmatrix' accept-charset="UTF-8" id="master_settings_idmatrix_form">
            @csrf
            <div class="card border-top p-9">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6"> {{ __('affiliates_label.id_matrix.parameters') }}</label>
                    <div class="col-lg-8 fv-row">
                        <select id="matrix_attributes" class=" form-select form-select-solid form-select-lg" multiple>
                            <option value=" @Affiliate-Name@">@Affiliate-Name@</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">{{ __('affiliates_label.id_matrix.content') }}</label>
                    <div class="col-lg-8 fv-row field-holder">
                        <textarea name="matrix_content" class="form-control form-control-lg form-control-solid ckeditor" id="matrix_content"></textarea>
                        <span class="form_error" style="color: red;"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('affiliates_label.id_matrix.status') }}</label>
                    <div class="col-lg-8 fv-row">
                        <div class="d-flex align-items-center mt-3">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input radio-w-h-18 matrix-status" name="status" id="" type="radio" value="1" checked/>
                                <span class="fw-bold ps-2 fs-6">
                                        {{ __('affiliates_label.id_matrix.active') }}
                                    </span>
                            </label>

                            <label class="form-check form-check-inline form-check-solid">
                                <input class="form-check-input radio-w-h-18 matrix-status" name="status" id="" type="radio" value="0"/>
                                <span class="fw-bold ps-2 fs-6">
                                        {{ __('affiliates_label.id_matrix.inactive') }}
                                    </span>
                            </label>

                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Identification Types</label>
                    <div class="col-lg-8 fv-row service_div">
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input me-3" name="medicare_card" type="checkbox" value="1" id="medicare_card">
                            <label class="form-check-label" for="medicare_card">
                                <div class="fw-bolder text-gray-800">{{ __('affiliates_label.id_matrix.medicare_card') }}</div>
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input me-3 foreign-passport" name="foreign_passport" type="checkbox" value="1" id="foreign_passport">
                            <label class="form-check-label" for="foreign_passport">
                                <div class="fw-bolder text-gray-800">{{ __('affiliates_label.id_matrix.foreign_passport') }}</div>
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input me-3 drivers-license" name="drivers_license" type="checkbox" value="1" id="drivers_license">
                            <label class="form-check-label" for="drivers_license">
                                <div class="fw-bolder text-gray-800">{{ __('affiliates_label.id_matrix.driver_license') }}</div>
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input me-3 australian-passport" name="australian_passport" type="checkbox" value="1" id="australian_passport">
                            <label class="form-check-label" for="australian_passport">
                                <div class="fw-bolder text-gray-800">{{ __('affiliates_label.id_matrix.australian_passport') }}</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9 border-0">
                <a href="{{ theme()->getPageUrl('/') }}" class="btn btn-secondary me-2">{{ __('buttons.cancel') }}</a>
                <button type="submit" class="btn btn-primary" id="add_matrix">
                    <span class="indicator-label">{{ __('buttons.save') }}</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
