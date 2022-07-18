<div class="card mb-5 mb-xl-10">


    <div id="kt_affliate_form_details" class="">

        <div class=" card-body border-top p-9">

            <form class="" method="post" action='/affiliates/saveretention' id="aff_retention_form">
                @csrf
                <input type="hidden" value="" id="retention_user_id" name="user_id">
                <input type="hidden" value="" id="retention_edit_id" name="retention_edit_id">

                <div class="row mb-6 feild-holder">
                    <label class="col-lg-4 col-form-label fs-6">{{ __('Select Verticals') }}</label>
                    <div class="col-md-8 float-end">
                        <select data-control="select2" id="userservices" class="form-control form-control-solid form-select " name="service_id" data-placeholder="Select verticals">
                            @if(count($verticals)>0)
                            <option value=""></option>
                            @foreach($verticals as $vertical )
                            <option value="{{$vertical->service_id}}">{{$vertical->service_title}}</option>
                            @endforeach
                            @endif
                        </select>
                        <span class="error_service_id text-danger"></span>

                    </div>

                </div>
                <div class="row mb-6 providers_div feild-holder" style="display:none;">
                    <label class="col-lg-4 col-form-label fs-6">{{ __('affiliates_label.retension_sales.select_provider') }}</label>
                    <div class="col-md-8 float-end">
                        <select data-control="select2" id="rentetion_providers" class="form-control form-control-solid form-select rentetion_providers" name="provider_id" data-placeholder="Select provider">
                            <option value="">{{ __('affiliates_label.retension_sales.select_provider') }}</option>
                        </select>
                        <span class="error_provider_id text-danger"></span>

                    </div>

                </div>

                <div class="row mb-6 provider_Retention" style="display:none">
                    <div class="form-group">
                        <label class="col-lg-4 col-form-label fs-6 ">Retention Allow for <span id="provider_name"></span></label>
                        <div class="col-md-8 float-end px-4">
                            <span class="fw-bold" id="provider_retension"></span>
                            <a class=" btn p-0 btn-circle pull-right provider_retension_href" href="" target="_blank"><i class="bi bi-pencil fs-2x text-warning"></i></a>
                        </div>
                    </div>
                </div>

                <!-- 10/05/2022 -->
                <div class="row mb-6 py-3 provider_Retention" style="display:none">
                    <div class="form-group">
                        <label class="col-lg-4 col-form-label fs-6" for="">Over-ride Provider Retention Settings</label>
                        <div class="col-md-8 float-end form-check form-switch form-check-custom form-check-solid px-2"><input class="form-check-input" type="checkbox" value="1" id="override_provider_retention" name="override_provider_retention" /></div>
                    </div>
                </div>

                <div class="row mb-6 py-3 provider_Retention" style="display:none">
                    <div class="form-group">
                        <label class="col-lg-4 col-form-label fs-6" for="retention_allow">Retention Allow for {{$records['affiliate']['company_name']}} (only)</label>
                        <div class="col-md-8 float-end form-check form-switch form-check-custom form-check-solid px-2"><input class="form-check-input" type="checkbox" value="1" id="retention_allow" name="retention_allow" /></div>

                    </div>
                </div>

                <div class="row mb-6 py-3 provider_Retention" style="display:none">
                    <div class="form-group">
                        <label class="col-lg-4 col-form-label fs-6" for="">Master Retention Settings for {{$records['affiliate']['company_name']}}'s Sub-affiliates</label>
                        <div class="col-md-8 float-end form-check form-switch form-check-custom form-check-solid px-2"><input class="form-check-input" type="checkbox" value="1" id="master_retention_allow" name="master_retention_allow" /></div>
                    </div>
                </div>

                <h2 class="pt-4 pb-2 provider_Retention" id="sub_affiliate_setting_h2">Sub-Affiliate Specific Retention Settings
                </h2>
                <div class="row mb-6 py-3 provider_subaff mt-4">

                </div>

                <div class="d-flex justify-content-end py-6 border-0">
                    <a href="{{ theme()->getPageUrl('affiliates/list') }}" class="btn btn-white btn-active-light-primary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="save_retention">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

</div>