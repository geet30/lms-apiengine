<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" name="affiliate_additional_feature_form" class="affiliate_additional_feature_form">
        @csrf
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Additional Features
                    </h2>
                </div>
            </div>
            <div class="card-body pt-0">
                
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">For How Long Lead Data Would Be In Cookie In Days</label>
                    <div class="col-lg-8 fv-row lead_data_in_cookie">
                        <input type="text" name="lead_data_in_cookie" class="form-control form-control-lg form-control-solid" placeholder="e.g. 10" value="{{@$affiliateuser[0]['lead_data_in_cookie']}}"/>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Lead Ownership Days Interval In Days</label>
                    <div class="col-lg-8 fv-row lead_ownership_days_interval">
                        <input type="text" name="lead_ownership_days_interval" class="form-control form-control-lg form-control-solid" placeholder="e.g. 10" value="{{@$affiliateuser[0]['lead_ownership_days_interval']}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Lead Export Password</label>
                    <div class="col-lg-8 fv-row lead_export_password">
                    

                        <input type="password" name="lead_export_password" class="form-control form-control-lg form-control-solid" placeholder="e.g. *****" value="{{ isset($affiliateuser[0]['lead_export_password']) ? '******' : ''}}" autocomplete="new-password" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Sale Export Password</label>
                    <div class="col-lg-8 fv-row sale_export_password">
                        <input type="password" name="sale_export_password" class="form-control form-control-lg form-control-solid" placeholder="e.g. *****" value="{{ isset($affiliateuser[0]['sale_export_password']) ? '******' : ''}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <?php
                $start_time = "21:00";
                $end_time = "09:00";
                if (isset($affiliateuser[0]['restricted_start_time'])) {
                    $start_time = $affiliateuser[0]['restricted_start_time'] == null ? "21:00" : date('H:i:s', strtotime($affiliateuser[0]['restricted_start_time']));
                }
                if (isset($affiliateuser[0]['restricted_end_time'])) {
                    $end_time = $affiliateuser[0]['restricted_end_time'] == null ? "09:00" : date('H:i:s', strtotime($affiliateuser[0]['restricted_end_time']));
                }


                ?>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Restrict Start time</label>
                    <div class="col-lg-8 fv-row restrict_start_time">
                        <input class="form-control mt-4 form-control-solid" id="restrict_start_time" name="restrict_start_time" type="text" readonly value="{{$start_time}}">
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Restrict End Time</label>
                    <div class="col-lg-8 fv-row restrict_end_time">
                        <input class="form-control mt-4 form-control-solid" id="restrict_end_time" name="restrict_end_time" type="text" readonly value="{{$end_time}}">
                        <span class="error text-danger"></span>
                    </div>
                </div>

            </div>
            <input type="hidden" name="id" class="affiliate_user_id" value="{{@encryptGdprData($affiliateuser[0]['user_id'])}}">
            <input type="hidden" name="parent_id" value="{{@encryptGdprData($affiliateuser[0]['parent_id'])}}">
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ theme()->getPageUrl('affiliates/list') }}" class="btn btn-white btn-active-light-primary me-2">{!! __('buttons.cancel') !!}</a>
               
                <button type="submit" class="submit_button" class="btn btn-primary">
                    @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                </button>
            </div>
        </div>
    </form>

</div>