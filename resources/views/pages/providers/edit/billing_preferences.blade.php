<!--begin::General options-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="billing_preference_form" class="billing_preference_form" name="billing_preference_form">
        @csrf
        <div class="card card-flush py-4">
            <!--begin::Card body-->
            <div class="card-body px-8">
                <!--begin::Input group-->
                <div class="row mb-5">
                    <!--begin::Label-->
                    <label class="col-lg-6 col-form-label required fw-bold fs-6">Content Allowed For</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-6 content_allow">
                        <div class="d-flex align-items-center mt-3">
                            @php 
                                $check1 = '';
                                $check2 = '';
                                if(isset($paper_bill_content["status"])){
                                    $options = explode(',',$paper_bill_content["e_billing_preference_option"]);
                                    foreach($options as $value){
                                        if($value == 1){
                                            $check1 = 'checked';
                                        } else if($value == 2){
                                            $check2 = 'checked';
                                        }
                                    }
                                }
                            @endphp
                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input radio-w-h-18" name="content_allow[]" type="checkbox" {{$check1}} value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Email') }}
                                </span>
                            </label>
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input radio-w-h-18" name="content_allow[]" type="checkbox" {{$check2}} value="2" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Post') }}
                                </span>
                            </label>                            
                        </div>
                        <p><span class="error text-danger"></span></p>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-5">
                    <!--begin::Label-->
                    <label class="col-lg-6 fw-bold fs-6">Does this section require billing preference to be enabled?</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-6 content_allow_status">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input radio-w-h-18 content_allow_status_btn" name="content_allow_status" type="radio" {{isset($paper_bill_content["status"]) && $paper_bill_content["status"] ? 'checked' : ''}} value="1" />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('Yes') }}
                            </span>
                        </label>
                        <!--end::Option-->

                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid">
                            <input class="form-check-input radio-w-h-18 content_allow_status_btn" name="content_allow_status" type="radio" {{isset($paper_bill_content["status"]) && $paper_bill_content["status"] ? '' : 'checked'}} value="0" />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('No') }}
                            </span>
                        </label>
                        <p><span class="error text-danger"></span></p>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <div class="row show_billing_parameters_div" style="display: none;">
                    <div class="row mb-5">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-xxl-12 col-form-label fw-bold fs-6">Paper Bill Content Parameter </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12">
                            <select data-control="select2" data-placeholder="Select Tag" data-hide-search="true" name="select_selectsplitter1" id="select_selectsplitter1" class="form-select form-select-solid billing_preference_select" size="5" data-id="billing_preference_select">
                                <option value="@Provider_Name@" class="billing_parameter">@Provider_Name@</option>
                                <option value="@Provider_Logo@" class="billing_parameter">@Provider_Logo@</option>
                                <option value="@Plan_Name@" class="billing_parameter">@Plan_Name@</option>
                                <option value="@Provider_Phone_Number@" class="billing_parameter">@Provider_Phone_Number@</option>
                                <option value="@Provider_Email@" class="billing_parameter">@Provider_Email@</option>
                                <option value="@Affiliate_Name@" class="billing_parameter">@Affiliate_Name@</option>
                                <option value="@Affiliate_Logo@" class="billing_parameter">@Affiliate_Logo@</option>
                                <option value="@Customer_Full_Name@" class="billing_parameter">@Customer_Full_Name@</option>
                                <option value="@Customer_Mobile_Number@" class="billing_parameter">@Customer_Mobile_Number@</option>
                                <option value="@Customer_Email@" class="billing_parameter">@Customer_Email@</option>
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--begin::Input group-->
                    <div class="row mb-5">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-xxl-12 col-form-label required fw-bold fs-6">Paper Bill Content</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12 paper_bill_content">
                            <textarea type="text" id="paper_bill_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="paper_bill_content">{{$paper_bill_content["description"]??''}}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>    
            </div>
            <!--end::Card body-->
            <div class="card-footer pt-0 px-8">
                <div class="pull-right">
                    <!--begin::Button-->
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="billing_preference_submit" class="btn btn-primary">
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
<!--end::General options-->
