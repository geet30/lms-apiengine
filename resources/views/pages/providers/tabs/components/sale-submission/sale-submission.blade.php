<div class="card mb-5 mb-xl-10">

    <div class="card-header  cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#amazing_extra_facilities_section1">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Sale Submission Through API Settings</h3>
        </div>
    </div>

    <div id="amazing_extra_facilities_section1" class="collapse show">
        <form role="form" id="provider_permission_form_sales" class="provider_permission_form_sales" name="provider_permission_form_sales">
            <input type="hidden" name="provider_id" value="{{$providerdetails[0]['id']}}">
            <input type="hidden" name="user_id" value="{{$providerdetails[0]['user_id']}}">
            <div class="card-body px-8">
                <div class="row mb-5">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Submit Sale Through API?</label>
                    <div class="col-lg-8 fv-row p-3" id="submit_sale_api">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input  id="submit_sale_api_yes" class="form-check-input submit_sale_api" name="submit_sale_api" type="radio" value="1" {{count($submit_sale_api) && $submit_sale_api[0] == 1  ? 'checked' : ''}}/>
                                <span class="fw-bold ps-2 fs-6">
                                {{ __('Yes') }}
                            </span>
                        </label>

                        <label class="form-check form-check-inline form-check-solid">
                            <input  id="submit_sale_api_no" class="form-check-input submit_sale_api" name="submit_sale_api" type="radio" value="0" {{count($submit_sale_api) && $submit_sale_api[0] == 0  ? 'checked' : ''}}/>
                                <span class="fw-bold ps-2 fs-6">
                                {{ __('No') }}
                            </span>
                        </label><br>
                        <span class="text-danger errors" id="status_error"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{route('provider.list')}}" id="" class="btn btn-light me-5">Cancel</a>
                <button type="submit" class="btn btn-primary submit_btn">
                    <span class="indicator-label">{{ __ ('mobile.formPage.amazing_extra_facilities.submitButton')}}</span>
                    <span class="indicator-progress">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mb-5 mb-xl-10">

    <div class="card-header  cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#amazing_extra_facilities_section1">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Password Protected Sale Submission</h3>
        </div>
    </div>

    <div id="amazing_extra_facilities_section1" class="collapse show">
        <form id="password_protected_sale_submission_form">
            <input type="hidden" name="provider_id" value="{{$providerId}}">
            <div class="card-body px-8">
                <div class="row mb-5">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Status</label>
                    <div class="col-lg-8 fv-row p-3">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input password-protected-sale" name="status" type="radio" value="1" @if($providerdetails[0]['protected_sale_submission'] == 1) checked @endif/>
                            <span class="fw-bold ps-2 fs-6">
                            {{ __('Enable') }}
                        </span>
                        </label>

                        <label class="form-check form-check-inline form-check-solid">
                            <input class="form-check-input password-protected-sale" name="status" type="radio" value="0" @if($providerdetails[0]['protected_sale_submission'] == 0) checked @endif/>
                            <span class="fw-bold ps-2 fs-6">
                            {{ __('Disable') }}
                        </span>
                        </label>
                        <span class="text-danger errors" id="status_error"></span>
                    </div>
                </div>
                <div class="row mb-5 sale-submission-password">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Password</label>
                    <div class="col-lg-8 fv-row">
                        <input type="password" class="form-control form-control-lg form-control-solid" placeholder="Password" name="password" tabindex="6" value="{{decryptGdprData($providerdetails[0]['protected_password'])}}">
                        <span class="text-danger errors" id="password_error"></span>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{route('provider.list')}}" id="" class="btn btn-light me-5">Cancel</a>
            <button type="button" class="btn btn-primary submit_btn" id="password_protected_sale_submit_btn" data-form="password_protected_sale_submission_form">
                <span class="indicator-label">{{ __ ('mobile.formPage.amazing_extra_facilities.submitButton')}}</span>
                <span class="indicator-progress">
                    Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
            </button>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10" id="sale-submission-card">
    <div class="card-header border-0">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Sale submission</h3>
        </div>
    </div>

    <div class="card-body px-8 pt-0">
        <form id="sale_submission_form">
            <input type="hidden" name="provider_id" value="{{$providerId}}">
            <div class="row mb-5">
                <label class="col-lg-2 col-form-label fw-bold fs-6 required">Submission Type</label>
                <div class="col-lg-4 fv-row">
                    <select class="form-control form-control-solid form-select userservice p-4" id="sale_submission_type" name="sale_submission_type" data-placeholder="Select type">
                        <option value="">Please select</option>
                        <option value="1">COR</option>
                        <option value="2">Move in</option>
                    </select>
                    <span class="text-danger errors" id="sale_submission_type_error"></span>
                </div>
            </div>
            <div class="row mb-5">
                <label class="col-lg-2 col-form-label fw-bold fs-6 required">From Email:</label>
                <div class="col-lg-4 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="e.g. user@cimet.com.au" name="from_email" tabindex="6" value="">
                    <span class="text-danger errors" id="from_email_error"></span>
                </div>
                <label class="col-lg-2 col-form-label fw-bold fs-6 required">From Name:</label>
                <div class="col-lg-4 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="e.g. cimet" name="from_name" tabindex="6" value="">
                    <span class="text-danger errors" id="from_name_error"></span>
                </div>
            </div>
            <div class="row mb-5">
                <label class="col-lg-2 col-form-label fw-bold fs-6 required">Subject:</label>
                <div class="col-lg-4 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="e.g. my subject" name="subject" tabindex="6" value="">
                    <span class="text-danger errors" id="subject_error"></span>
                </div>
                <label class="col-lg-2 col-form-label fw-bold fs-6 required">To:</label>
                <div class="col-lg-4 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="e.g. email1@gmail.com,email2@gmail.com" name="to_email_ids" tabindex="6" value="">
                    <span class="text-danger errors" id="to_email_ids_error"></span>
                </div>
            </div>
            <div class="row mb-5">
                <label class="col-lg-2 col-form-label fw-bold fs-6">CC Emails:</label>
                <div class="col-lg-4 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="e.g. email1@gmail.com,email2@gmail.com" name="cc_email_ids" tabindex="6" value="">
                    <span class="text-danger errors" id="cc_email_ids_error"></span>
                </div>
                <label class="col-lg-2 col-form-label fw-bold fs-6">BCC Emails:</label>
                <div class="col-lg-4 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="e.g. email1@gmail.com,email2@gmail.com" name="bcc_email_ids" tabindex="6" value="">
                    <span class="text-danger errors" id="bcc_email_ids_error"></span>
                </div>

            </div>

            <div id="time-slots">
                <div class="row mb-5">
                    <div class="col-md-6 type-2">
                        <div class="row">
                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Time:</label>
                            <div class="col-9 col-sm-10 col-md-7 col-lg-7 fv-row">
                                <input id="part-0" class="form-control form-control-lg timepicker timepicker_cor interval timepicker_cor_end cor_time_field_count form-control-solid" placeholder="e.g. 10:10" readonly="readonly" count="0" tabindex="6" name="cor_sale_time[]" type="text" value="">
                                <span class="text-danger errors cor_sale_time_error"></span>
                            </div>
                            <div class="col-1 fv-row p-0">
                                <button class="btn btn-success btn-icon-only green addRow" data-type="2"><i class="fa fa-plus p-0"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12 type-2">
                        <div class="row" id="newRow"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <a href="{{route('provider.list')}}" id="" class="btn btn-light me-5">Cancel</a>
        <button type="button" class="btn btn-primary" id="sale_submission_submit_btn" data-form="sale_submission_form">
            <span class="indicator-label">{{ __ ('mobile.formPage.amazing_extra_facilities.submitButton')}}</span>
            <span class="indicator-progress">
                Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
</div>
