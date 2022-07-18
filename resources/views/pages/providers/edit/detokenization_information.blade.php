<!--begin::Main column-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="manage_provider_ips_form" class="manage_provider_ips_form" name="manage_provider_ips_form">
        @csrf 
        <!--begin::General options-->
        <div class="card card-flush py-4">            
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Manage Provider IPs</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body px-8 py-0">
                <div class="row">
                    <div class="col">
                <!--begin::Input group-->
                        <div class="fv-row mb-4 ips">
                            <!--begin::Label-->
                            <label class="fs-5 mb-5 col-5">White List IPs:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="ips" class="form-control form-control-solid d-md-inline-flex" value="" id="ips" placeholder="e.g. 121.11.11.11">{{$detokenization_settings["ips"] ?? ''}}</textarea>
                            <span class="error text-danger"></span>
                            <!--end::Input-->
                        </div>
                    </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col">
                    <div class="fv-row mb-4 ip_range">
                        <!--begin::Label-->
                        <label class="fs-5 mb-5 col-5">White List IPs Range:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control form-control-solid d-md-inline-flex" value="" id="ip_range" name="ip_range" placeholder="e.g. 121.11.11.11-20">{{$detokenization_settings["ip_range"] ?? ''}}</textarea>
                        <span class="error text-danger"></span>
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            </div>
            <!--begin::Actions-->
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="manage_provider_ips" class="btn btn-primary">
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
<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <form role="form" id="genrate_token_form" class="genrate_token_form" name="genrate_token_form">
            @csrf 
            <!--begin::Card header-->
            <div class="card-header border-0">
                <div class="card-title">
                    <h2>Manage Provider Detokenization</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body px-8 py-0">
                <!--begin::Input group-->
                <div class="row mb-4">
                    <!--begin::Label-->
                    <label class="fs-5 mb-5 col-lg-3">Provider token:</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-6">
                        <input type="text" class="form-control form-control-solid" id="token" placeholder="Click Generate Token" name="provider_token" readonly="" value="{{$detokenization_settings["token"]??''}}">
                    </div>
                    <!--end::Input-->
                    <div class="col-lg-3">
                        <button type="submit" class="pull-right btn btn-danger" id="genrate_token" name="genrate_token">Generate Token
                        </button>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
        </form>
    </div>
    <!--end::Pricing-->
</div>
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="allow_user_ip_form" class="allow_user_ip_form" name="allow_user_ip_form">
        @csrf 
        <!--begin::General options-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Direct Debit CSV Info</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body px-8 py-0">
                <!--begin::Input group-->
                <div class="row">
                    <div class="col">
                        <div class="fv-row mb-4 sale_export_password">
                            <!--begin::Label-->
                            <label class="fs-5 mb-5 col-5">Sale Export Password:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid d-md-inline-flex" type="password" id="sale_export_password" name="sale_export_password" placeholder="sale export password" >
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                <!--end::Input group-->
                
                <!--begin::Input group-->
                    <div class="col">
                        <div class="fv-row mb-4 export_leads">
                            <!--begin::Label-->
                            <label class="fs-5 mb-5 col-5">Allowed User IPs:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class=" form-control form-control-solid d-md-inline-flex" id="export_leads" name="export_leads" placeholder="e.g. 121.11.11.11">{{$detokenization_settings["debit_info_csv_ip"] ?? ''}}</textarea>
                            <span class="error text-danger"></span>
                            <!--end::Input-->
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                    <!--begin::Button-->
                    <button type="submit" id="allow_user_ip_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
        </div>
        <!--end::Pricing-->
    </form>
</div>
<!--end::Main column-->
                
