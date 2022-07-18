@php 
//dd($exportSettingData); @endphp
<div class="d-flex flex-column gap-7 gap-lg-10">
        <form  method="POST" id="reset_sale_lead_password"  name="reset_sale_lead_password">
            @csrf 
            <!--begin::General options-->
            <div class="card card-flush py-4">            
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Set Password For Sale Export and Leads</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body px-8 py-0">
                    <div class="row">
                            <div class="col">
                                <div class="fv-row mb-4 reset_sale_export_password">
                                    <!--begin::Label-->
                                    <label class="fs-5 mb-5 col-5">Sale Export Password:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid d-md-inline-flex " type="password" id="reset_sale_export_password" name="reset_sale_export_password" placeholder="e.g. Password@123" value="{{ isset($exportSettingData['sale_export_password']) ? decryptGdprData($exportSettingData['sale_export_password']) : ''}}">
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                            <div class="col">
                                <div class="fv-row mb-4 reset_lead_export_password">
                                    <!--begin::Label-->
                                    <label class="fs-5 mb-5 col-5">Lead Export Password:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid d-md-inline-flex" type="password" id="reset_lead_export_password" name="reset_lead_export_password" placeholder="e.g. Password@123" value="{{ isset($exportSettingData['lead_export_password']) ? decryptGdprData($exportSettingData['lead_export_password']) :''}}">
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col">
                    <!--begin::Input group-->
                            <div class="fv-row mb-4 ips">
                                <!--begin::Label-->
                                <label class="fs-5 mb-5 col-5">Allowed IPs:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control" id="kt_tagify_lead_sale_ips" name="ips"  id="ips"  value="{{isset($exportSettingData['sale_export_ips'] ) ?$exportSettingData['sale_export_ips']: ''}} " placeholder="e.g. 223.223.22.22"/> 
                                <span class="error text-danger"></span>
                                <!--end::Input-->
                            </div>
                        </div>
                    <!--end::Input group-->
                
                </div>
                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-0 border-0">
                   
                        <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                        <button type="button" id="reset_sale_lead_password_submit_btn" class="btn btn-primary export_submit_btn" data-form="reset_sale_lead_password">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                   
                </div>
                <!--end::Actions-->

            </div>
            <!--end::Pricing-->
        </form>
        <form  method="POST" id="export_setting_direct_debit_form"  name="export_setting_direct_debit_form">
            @csrf 
            <!--begin::General options-->
            <div class="card card-flush py-4">            
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Manage Password And Log Email for Direct Debit</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body px-8 py-0">
                    <div class="row">
                            <div class="col">
                                <div class="fv-row mb-4 export_setting_direct_debit_password">
                                    <!--begin::Label-->
                                    <label class="fs-5 mb-5 col-5"> Direct Debit Password:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid d-md-inline-flex mb-5" type="password" id="export_setting_direct_debit_password" name="export_setting_direct_debit_password" placeholder="e.g. Password@123" value="{{ isset($exportSettingData['direct_debit_password']) ? decryptGdprData($exportSettingData['direct_debit_password']) : ''}}">
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                         
                                <label class="col-lg-2 fs-5 mb-5">Log Emails:</label>
                                <div class="col-lg-10 mb-4 export_setting_direct_debit_log_email">
                                    <!--begin::Label-->
                               
                                    <div class="col-lg-8">
                                    <label class="form-check form-check-inline form-check-solid me-5">
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="radio" class="form-check-input radio-w-h-18 mg-r5" name="export_setting_direct_debit_log_email"  value="1"
                                    id="enable_export_setting_direct_debit_log_email" {{ isset($exportSettingData['direct_debit_log_email']) && $exportSettingData['direct_debit_log_email'] ==1 ? 'checked' :''}} />Enable Log Emails 
                                
                                    </label>
                                    <label class="form-check form-check-inline form-check-solid me-5 ">
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="radio" class="form-check-input radio-w-h-18 mg-r5" name="export_setting_direct_debit_log_email"  value="0"
                                    id="disable_export_setting_direct_debit_log_email" {{ isset($exportSettingData['direct_debit_log_email']) &&  $exportSettingData['direct_debit_log_email'] ==0 ? 'checked' :''}}/>Disable Log Emails
                                    <br/>
                                    <span class="error text-danger"></span>
                                    </label>
                                 
                                    </div>
                                </div>
                                <input class="form-control" id="kt_tagify_direct_debit_emails" name="direct_debit_emails"  id="direct_debit_emails" class="mb-5"  placeholder="e.g. Email@cimet.com" value="{{$exportSettingData['direct_debit_emails'] ?? ''}}"/> 
                           
                    </div>
                    <div class="row">
                        <div class="col">
                    <!--begin::Input group-->
                            <div class="fv-row mb-4 ips">
                                <!--begin::Label-->
                                <label class="fs-5">Allowed IPs:</label>
                                <h3 class="card-title align-items-start flex-column mb-5">
									<span class="fs-6 text-gray-500">Only on allowed IPs admin user will be able to see the EXPORT button. This check work only for admin users</span>
				
								</h3>
                                    
                                    
                                <!--end::Label-->
                           
                                <!--begin::Input-->
                                <input class="form-control" id="kt_tagify_direct_debit_ips" name="direct_debit_ips"  id="direct_debit_ips"  value="{{$exportSettingData['direct_debit_ips'] ?? ''}}" placeholder="e.g. 223.223.22.22"/> 
                              
                                <span class="error text-danger"></span>
                                <!--end::Input-->
                            </div>
                        </div>
                    <!--end::Input group-->
                
                </div>
                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-0 border-0">
                   
                        <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                        <button type="button" id="export_setting_direct_debit_submit_btn" class="btn btn-primary export_submit_btn" data-form="export_setting_direct_debit_form">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                   
                </div>
                <!--end::Actions-->

            </div>
            <!--end::Pricing-->
        </form>
        <form  method="POST" id="export_setting_detokenization_form"  name="export_setting_detokenization_form">
            @csrf 
            <!--begin::General options-->
            <div class="card card-flush py-4">            
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Manage Password And Log Email for Detokenization</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body px-8 py-0">
                    <div class="row">
                            <div class="col">
                                <div class="fv-row mb-4 export_setting_detokenization_password">
                                    <!--begin::Label-->
                                    <label class="fs-5 mb-5 col-5"> Detokenization Password:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid d-md-inline-flex mb-5" type="password" id="export_setting_detokenization_password" name="export_setting_detokenization_password" placeholder="e.g. Passowrd@123" value="{{ isset($exportSettingData['detokenization_password']) ? decryptGdprData($exportSettingData['detokenization_password'] ): ''}}">
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-2 fs-5 mb-5">Log Emails:</label>
                        <div class="col-lg-10 mb-4 export_setting_detokenization_log_email">
                            <!--begin::Label-->
                            <label class="form-check form-check-inline form-check-solid me-5">
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="radio" class="form-check-input radio-w-h-18 mg-r5" name="export_setting_detokenization_log_email"  value="1"
                            id="export_setting_detokenization_log_email" {{ isset($exportSettingData['detokenization_log_email']) && $exportSettingData['detokenization_log_email'] ==1 ? 'checked' :''}} />Enable Log Emails 
                            <span class="error text-danger"></span>
                            </label>
                            <label class="form-check form-check-inline form-check-solid me-5">
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="radio" class="form-check-input radio-w-h-18 mg-r5" name="export_setting_detokenization_log_email"  value="0"
                            id="disable_export_setting_detokenization_log_email" {{ isset($exportSettingData['detokenization_log_email'] ) && $exportSettingData['detokenization_log_email'] ==0 ? 'checked' :''}}/>Disable Log Emails
                            <span class="error text-danger"></span>
                            </label>
                           
                        </div>
                        <input class="form-control" id="kt_tagify_detokenization_emails" name="detokenization_emails"  id="detokenization_emails" placeholder="e.g. Email@cimet.com" class="mb-5" value="{{$exportSettingData['detokenization_emails'] ?? ''}}"/> 
                           
                    </div>
                    <div class="row">
                        <div class="col">
                    <!--begin::Input group-->
                            <div class="fv-row mb-4 ips">
                                <!--begin::Label-->
                                <label class="fs-5 ">Allowed IPs:</label>
                                <h3 class="card-title align-items-start flex-column mb-5">
									<span class="fs-6 text-gray-500">Only on allowed IPs admin user will be able to see the EXPORT button. This check work only for admin users</span>
				
								</h3>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control" id="kt_tagify_detokenization_ips" name="detokenization_ips"  id="detokenization_ips"  value="{{$exportSettingData['detokenization_ips'] ?? ''}}" placeholder="e.g. 223.223.22.22"/> 
                              
                                <span class="error text-danger"></span>
                                <!--end::Input-->
                            </div>
                        </div>
                    <!--end::Input group-->
                
                </div>
                </div>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-0 border-0">
                   
                        <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                        <button type="button" id="export_setting_detokenization_log_email" class="btn btn-primary export_submit_btn" data-form="export_setting_detokenization_form">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                   
                </div>
                <!--end::Actions-->

            </div>
            <!--end::Pricing-->
        </form>
    </div>
    <style>
        .mg-r5{
            margin-right:5px;
        }
    </style>