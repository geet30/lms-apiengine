@php
$required_class = '';
$uc_upper = '';
$type = 'add';
$disabled = '';
if($account_detail){
$type = 'edit';
$disabled = 'disabled';
$uc_upper = 'text-capitalize';
if($account_detail['service_id'] == 1 ){
$required_class = 'required';
}
}
@endphp
<!--begin::Main column-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" class="provider_basic_detail_form" name="provider_basic_detail_form">
        @csrf
        <input type="hidden" class="" id="action" name="action" value="{{$type}}">
        <input type="hidden" class="" id="service_id" name="service_id" value="{{!empty($selected_service)? $selected_service['service_id'] : ''}}">
        <input type="hidden" class="" id="provider_id" name="provider_id" value="{{$account_detail['id']??''}}">
        <input type="hidden" class="" id="user_id" name="user_id" value="{{$account_detail['user_id']??''}}">
        <!--begin::General options-->
        <div class="card card-flush py-4 px-8">
            <!--begin::Card body-->
            <div class="card-body px-0 pt-0">
                <!--begin::Input group-->
                <div class="row mb-6 service_type">
                    <!--begin::Label-->
                  @if(isset($account_detail['service_id']))  
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Service Type</label>
                    <!--end::Label-->
                    <span class="col-lg-7 m-4">
                        @if($account_detail['service_id'] == 1)
                        Energy
                        @elseif($account_detail['service_id'] == 2)
                        Mobile
                        @elseif($account_detail['service_id'] == 3)
                        Broadband
                        @else
                        N/A
                        @endif
                    </span>
                    @else
                     <div class="align-items-center mt-3 col-8">
                        <select data-control="select2" class="form-select form-select-solid select2-hidden-accessible {{$type}}" name="service_type" id="service_type" data-placeholder="Select service" tabindex="-1" aria-hidden="true">
                            <option></option>
                            @foreach($services as $row)
                                <option value="{{$row->id}}" {{!empty($selected_service) && $row->id == $selected_service['service_id'] ? 'selected' : ''}}>{{$row->service_title}}</option>
                            @endforeach
                        </select>
                        <span class="error text-danger"></span>
                    </div> 
                    <!--end::Input-->
                    @endif
                </div>

                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Business Name</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 business_name">
                        <input type="text" class="form-control form-control-lg form-control-solid {{$uc_upper}}" placeholder="e.g. Cimet Energy" name="business_name" tabindex="1" maxlength="100" value="{{$account_detail['name'] ?? ''}}" />
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Legal Name</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 legal_name">
                        <input type="text" class="form-control form-control-lg form-control-solid {{$uc_upper}}" placeholder="e.g. Cimet Energy" name="legal_name" tabindex="2" value="{{$account_detail['legal_name'] ?? ''}}" />
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">ABN/ ACN</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 abn">
                        <input type="text" class="form-control form-control-solid" placeholder="11 digits ABN or 9 digits ACN e.g. 9999999999" name="abn" tabindex="3" value="{{$account_detail['abn_acn_no']??''}}" />
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 email">
                        <input type="text" class="form-control form-control-solid" placeholder="e.g. cimetofficial@cimet.com.au" name="email" tabindex="4" value="{{decryptGdprData($account_detail['user']['email']??'')}}" />
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label {{$required_class}} fw-bold fs-6 required_star">Support Email</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 support_email">
                        <input type="text" class="form-control form-control-solid" placeholder="e.g. support@cimet.com.au" name="support_email" tabindex="5" value="{{$account_detail['support_email']??''}}" />
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label {{$required_class}} fw-bold fs-6 required_star">Escalation Email</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 complaint_email">
                        <input type="text" class="form-control form-control-solid" placeholder="e.g. escalation@cimet.com.au" name="complaint_email" tabindex="6" value="{{$account_detail['complaint_email']??''}}" />
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Contact Number</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 contact_no">
                        <input type="text" class="form-control form-control-solid" placeholder="10 digits e.g. 0499999999" name="contact_no" tabindex="7" value="{{decryptGdprData($account_detail['user']['phone']??'')}}" maxlength="10" />
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Address</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 address">
                        <textarea class="form-control form-control-solid" tabindex="8" placeholder="e.g. Opera House Sydney, New South Wales, Australia" rows="2" name="address">{{$account_detail['get_user_address']['address']??''}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label {{$required_class}} fw-bold fs-6 required_star">Description</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 description">
                        <textarea class="form-control form-control-solid" tabindex="9" placeholder="e.g.write description here..." rows="4" name="description" id="description">{{$account_detail['description']??''}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <!--begin::Actions-->
            <div class="card-footer pt-0 px-0">
                <div class="pull-right">
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="add_provider_account_details" class="btn btn-primary add_provider_account_details">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Pricing-->
    </form>
</div>
<!--end::Main column-->