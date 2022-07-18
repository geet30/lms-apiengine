<!--begin::Basic info-->
<div class="card {{ $class }}">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Account Details') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!--begin::Card body-->

            <div class="card-body border-top p-9">
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Service') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select data-control="select2" data-placeholder="Select a Service" data-hide-search="true" name="format" class="form-select form-select-solid" multiple>
                            <option value="">Select Service</option>
                            <option value="energy">energy</option>
                            <option value="broadband">broadband</option>
                            <option value="mobile">Mobile</option>


                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Business Name') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Business Name" value=""/>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('ABN/ACN') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="ABN/ACN" value=""/>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('ABN/ACN') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="ABN/ACN" value=""/>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Phone') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Phone" value=""/>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Email') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Email" value=""/>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Legal Name') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Legal Name" value=""/>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Support Email') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Support Email" value=""/>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Description') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Description" value=""/>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Address') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Address" value=""/>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Provider Logo') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="file" name="company" class="form-control form-control-lg form-control-solid" placeholder="Provider Logo" value=""/>
                    </div>
                    <!--end::Col-->
                </div>


            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>

                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                    @include('partials.general._button-indicator', ['label' => __('Save Changes')])
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->
