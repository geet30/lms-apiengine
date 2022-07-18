<!--  -->
<!--begin::Main column-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="concession_details_form" class="concession_details_form" name="concession_details_form">
        @csrf
        <!-- <input type="hidden" class="" id="user_id" name="user_id" value="{{$account_detail['user_id']??''}}"> -->
        <input type="hidden" class="" id="provider_id" name="provider_id" value="{{$provider_details[0]['user_id'] ??''}}">
        <!--begin::General options-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body px-8">
                <div class="row mb-6>
                    <!--begin::Label-->
                    <label class=" col-lg-4 col-form-label required fw-bold fs-6">Allowed Concession</label>
                    <!--end::Label-->
                    <div class="align-items-center col-8 allowed_concession_state">
                        <select class="form-select fsorm-select-transsparent" name="allowed_concession_state[]" id="allowed_concession_state" data-control="select2" data-hide-search="true" data-placeholder="Select State" multiple>
                            <option value=""></option>
                            @foreach ($states as $id => $row)
                            <option value="{{$row->id}}" {{isset($concession_data) && in_array($row->id,$concession_data)  ? 'selected' :''}}>{{ $row->name }}</option>
                            <p><span class="error text-danger"></span></p>
                            @endforeach
                        </select>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Card body-->
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">{{ __('Cancel') }}</a>
                    <button type="submit" id="concession_details_form_submit" class="btn btn-primary">
                        <span class="indicator-label">{{ __('Save Changes') }}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->
    </form>
    <form role="form" id="concession_content_form" class="concession_content_form" name="concession_content_form">
        @csrf
        <input type="hidden" class="" id="provider_id" name="provider_id" value="{{$provider_details[0]['user_id'] ??''}}">
        <div class="card card-flush py-4 px-8">
            <!--begin::Card header-->
            <div class="card-header border-1 pt-0 px-8">
                <div class="card-title">
                    <h2>Concession Content</h2>
                </div>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Type</label>
                    <!--end::Label-->
                    <div class="align-items-center col-8 type">
                        <select data-control="select2" class="form-select form-select-solid select2-hidden-accessible" name="type" id="type" data-placeholder="Select Type" tabindex="-1" aria-hidden="true">
                            <option value="">Select Type</option>
                            <option value="1" selected>Online</option>
                            <option value="2">Telesale</option>
                        </select>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">State</label>
                    <!--end::Label-->
                    <div class="align-items-center col-8">
                        <select class="form-select fsorm-select-transsparent" name="state" id="state" data-control="select2" data-hide-search="true" data-placeholder="Select State">
                            <option value=""></option>
                            @foreach ($states as $row)
                            <option value="{{$row->id}}" {{isset($state_consent['state_id']) && $row->id == $state_consent['state_id'] ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        <span class="error text-danger" id="state_error"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label fw-bold fs-6">Parameters</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12">
                        <select data-control="select2" data-placeholder="Select Parameters" data-hide-search="true" name="statewise_select" id="select_selectsplitter1" class="form-select concession_provider_parameter" data-id="concession_provider_parameter" size="5">
                            @if (count($content_attribute) > 0)
                            @foreach ($content_attribute as $row)
                            <option value="{{ $row->attribute }}" {{ isset($content_attribute['id']) && $row->id == $content_attribute['id'] ? 'selected' : '' }}>
                                {{ $row->attribute }}
                            </option>
                            @endforeach
                            <p><span class="error text-danger"></span></p>
                            @endif
                        </select>
                    </div>
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <div class="mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label required fw-bold fs-6">Content:</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12 concession_content">
                        <textarea type="text" id="concession_content" name="concession_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5"></textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <!--begin::Button-->
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="concession_content_form_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
        </div>
    </form>
</div>
<!--end::Main column-->
<!--  -->