<div >
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Assign Affiliate</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_special_offer_price" class="collapse show">
                <!--begin::Form-->
                <form id="link_user_form" class="form">
                    <!--begin::Card body-->
                    <input type='hidden' name='user_id' value="{{$user->id}}"> 
                    <div class="card-body border-top p-9">
                        <!--begin::Input group--> 
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Assign Affiliate</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="col-lg-8 fv-row">
                                    <select name="affiliates[]" data-control="select2" data-placeholder="e.g. Energy" class="form-select form-select-solid form-select-lg" id="pro_user_id" multiple="multiple">  
                                            @foreach($affiliates as $affiliate)
                                                <option value="{{ $affiliate->user_id }}" <?php if(in_array($affiliate->user_id,$selectedAffiliates)){echo 'selected';}  if($affiliate->status==0){echo ' class="alert-danger"';} ?> >{{$affiliate->company_name}}</option>
                                            @endforeach
                                    </select> 
                                    <span class="errors text-danger"></span> 
                                    </div>
                                    <span class="error text-danger special_offer_status-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Select Affiliate For Sub Affiliate</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="col-lg-8 fv-row">
                                    <select name="masteraffiliates[]" data-control="select2" data-placeholder="e.g. Energy" class="form-select form-select-solid form-select-lg" multiple="multiple" id="master_affiliates">  
                                        @foreach($affiliates as $affiliate)
                                            <option value="{{ $affiliate->user_id }}"  <?php if(in_array($affiliate->user_id,$selectedMasterAff)){echo 'selected';} if($affiliate->status==0){echo ' class="alert-danger"';} ?>>{{$affiliate->company_name}}</option>
                                        @endforeach
                                    </select> 
                                    <span class="errors text-danger"></span> 
                                    </div>
                                    <span class="error text-danger special_offer_status-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Assign Sub Affiliate</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="col-lg-8 fv-row">
                                    <select name="sub_affiliates[]" data-control="select2" data-placeholder="e.g. Energy" class="form-select form-select-solid form-select-lg sub_affiliates_select" multiple="multiple">  
                                        @foreach($allSubAffiliatesData as $affiliate)
                                            <option value="{{ $affiliate->user->id }}" <?php if(in_array($affiliate->user->id,$selectedSubAff)){echo 'selected';}   if($affiliate->status==0){echo ' class="alert-danger"';} ?> >{{$affiliate->getParentAffiliate->company_name}} : {{$affiliate->company_name}}</option>
                                        @endforeach
                                    </select> 
                                    <span class="errors text-danger"></span> 
                                    </div>
                                    <span class="error text-danger special_offer_status-error"></span>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">IP Whitelist</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="col-lg-8 fv-row">
                                        <input class="form-control" id="kt_tagify_1" name="ip" value="{{$whitelist_ip}}"/> 
                                        <span class="error text-danger special_offer_status-error"></span>
                                    </div>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        @if($user->getRoleNames()[0]== 'bdm')
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Date Range</label>
                            <!--end::Label-->
                            <!--begin::Col--> 
                            <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Options-->
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <input type="text" name="date_range_from" class="form-control" placeholder="Select Start Date" id="date_range_from" readonly value="{{isset($bdmDateRange->date_range_from)?$bdmDateRange->date_range_from:''}}">
                                            <span class="error text-danger special_offer_status-error"></span>
                                        </div>
                                        <div class="col-lg-4">
                                            @if((isset($bdmDateRange->date_range_checkbox) && $bdmDateRange->date_range_checkbox==1) || (!isset($bdmDateRange->date_range_checkbox)))
                                                <input type="text" class="form-control" placeholder="Select End Date" id="date_range_to" name="date_range_to" readonly disabled>
                                                <span class="error" style="color:red;display: block;"></span>
                                                <input type="checkbox" name="date_range_checkbox" id="date_range_checkbox" checked="checked"> Current Date
                                            @else
                                                <input type="text" class="form-control" name="date_range_to" id='date_range_to' value="{{isset($bdmDateRange->date_range_to)?$bdmDateRange->date_range_to:''}}" readonly> 
                                                <span class="error" style="color:red;display: block;"></span>
                                                <input type="checkbox" name="date_range_checkbox" id="date_range_checkbox" > Current Date
                                            @endif 
                                        </div>
                                    </div>
                                    <!--end::Options-->
                                <div class="fv-plugins-message-container invalid-feedback"></div> 
                            </div>
                            @endif
                            <!--end::Col-->
                        </div>
                    </div>
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a class="btn btn-light btn-active-light-primary me-2" href="/manage-user/list">{{__('plans/broadband.discard_button')}}</a>
                        <button type="submit" class="btn btn-primary">
                            {{__('plans/broadband.save_changes_button')}}
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
        </div>
    </div>
</div>