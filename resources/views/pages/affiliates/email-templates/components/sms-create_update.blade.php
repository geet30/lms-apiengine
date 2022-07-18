<x-base-layout>
    <!--begin::Row-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0" role="button" style="background:#009ef7 !important;">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0 text-white">{{$action}} Message Template</h3>
            </div>
        </div>
        <div id="kt_affliate_form_details" class="">
            <form id="" class="form" method="POST" action="" enctype="multipart/form-data">
                <div class="card-body border-top p-9">
                    @if($type =='welcome')
                     <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6"> Welcome SMS Type:</label>
                        <div class="col-lg-8 fv-row">
                            <select name="welcome_email_type" class="form-select form-select-solid form-select-lg">
                                <option value="electricity_only">Electricity Only</option>
                                <option value="gas_only">Gas Only</option>
                                <option value="electricity_gas_different_only">Electricity and Gas from different retailer</option>
                                <option value="electricity_gas_same_only">Electricity and Gas from same retailer</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    @if($type =='confirmation')
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Set Target Type</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input move_in_normal" name="target_type" type="radio"  checked />
                                    <span class="fw-bold ps-2 fs-6">
                                        Lead
                                    </span>
                                </label>
                                
                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input move_in" name="target_type" type="radio" />
                                    <span class="fw-bold ps-2 fs-6">
                                        Sales
                                    </span>
                                </label>
                               
                            </div>
                        </div>
                    </div> 
                    @endif
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Template Name:</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid"  value="">
                        </div>
                    </div>
                    @if($type =='confirmation')
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Set Delay Day and Time</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input move_in_normal" name="immediate_sms" type="checkbox"   />
                                    <span class="fw-bold ps-2 fs-6">
                                        At the time when sale is created 
                                    </span>
                                </label>
                               <label class="col-lg-1 col-form-label fw-bold fs-6">OR</label> 
                               <input class="form-control form-control-lg form-control-solid w-25 me-1" placeholder="00" id="days_interval" name="days_interval" type="text" value="0">
                               <label class="col-lg-1 col-form-label fw-bold fs-6">Days</label> 
                               <input class="form-control form-control-lg form-control-solid w-25 me-1" placeholder="00" id="delay_hrs" name="delay_hrs" type="text" value="0">
                               <label class="col-lg-1 col-form-label fw-bold fs-6">Hours</label> 
                               <input class="form-control form-control-lg form-control-solid w-25" placeholder="00" id="delay_mins" name="delay_mins" type="text" value="30">
                               <label class="col-lg-1 col-form-label fw-bold fs-6">Minutes</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Check Restricited Time</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input move_in_normal" name="check_restricted" type="checkbox"   />
                                    <span class="fw-bold ps-2 fs-6">
                                        Check the box if you want to check restricted time
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($type =='welcome' || $type =='confirmation')
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Sender ID Method</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input move_in_normal" name="sender_id_method" type="radio"  checked />
                                    <span class="fw-bold ps-2 fs-6">
                                        Default(Affilate Sender Id)  
                                    </span>
                                </label>
                                
                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input move_in" name="sender_id_method" type="radio" />
                                    <span class="fw-bold ps-2 fs-6">
                                        Custom
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input move_in" name="sender_id_method" type="radio"  />
                                    <span class="fw-bold ps-2 fs-6">
                                        2-Way
                                    </span>
                                </label>
                               
                            </div>
                        </div>
                    </div> 
                    @endif
                    @if($type =='confirmation')
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Select source to make URL shorter:</label>
                            <div class="col-lg-8 fv-row">
                                <div class="d-flex align-items-center mt-3">
                                    <label class="form-check form-check-inline form-check-solid me-5">
                                        <input class="form-check-input" name="source_type" type="radio" id="bitly" value="1"  />
                                        <span class="fw-bold ps-2 fs-6">
                                            Bitly  
                                        </span>
                                    </label>
                                    
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input class="form-check-input" name="source_type" type="radio" id="rebrandly"  value="2" checked/>
                                        <span class="fw-bold ps-2 fs-6">
                                            Rebrandly
                                        </span>
                                    </label>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6 branding_url">
                            <label class="col-lg-4 col-form-label  fw-bold fs-6"> Enter branding URL:</label>
                            <div class="col-lg-8 fv-row">
                                <select name="branding_url" class="form-select form-select-solid form-select-lg">
                                    <option value="Please select">Please select</option>
                                    <option value="save.fyi">save.fyi</option>
                                    <option value="rebrand.ly">rebrand.ly</option>
                                </select>
                            </div>
                        </div>
                    @endif

                    @if($type =='remarketing')
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6"> Days Interval:</label>
                            <div class="col-lg-8 fv-row">
                                <input type="number" name="interval" onkeypress="return event.charCode >= 48 && event.charCode <= 57" min="0" class="form-control form-control-lg form-control-solid"  value="">
                            </div>
                        </div>
                    
                        @if($email_type =='broadband' || $email_type =='sim' || $email_type =='mobile_sim')
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6"> UTM RM:</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="utm_rm" class="form-control form-control-lg form-control-solid"  value="">
                            </div>
                        </div>
                        
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6"> UTM RM Date:</label>
                            <div class="col-lg-8 fv-row">
                                <input class="form-check-input me-3" name="utm_rm_date_status" type="checkbox" value="1" >
                            </div>
                        </div>
                        @endif
                    
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Select Remarketing Email</label>
                            <div class="col-lg-8 fv-row">
                                <div class="d-flex align-items-center mt-3">
                                    <label class="form-check form-check-inline form-check-solid me-5">
                                        <input class="form-check-input move_in_normal" name="select_remarketing_type" type="radio" value="1" checked />
                                        <span class="fw-bold ps-2 fs-6">
                                            Normal  
                                        </span>
                                    </label>
                                    
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input class="form-check-input move_in" name="select_remarketing_type" type="radio" value="2" />
                                        <span class="fw-bold ps-2 fs-6">
                                            MoveIn
                                        </span>
                                    </label>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6 move_in_customers">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">Do you want to send this template for Move-In customers</label>
                            <div class="col-lg-8 fv-row">
                                <div class="d-flex align-items-center mt-3">
                                    <label class="form-check form-check-inline form-check-solid me-5">
                                        <input class="form-check-input" name="move_in_template" type="radio" value="1" checked />
                                        <span class="fw-bold ps-2 fs-6">
                                            Yes  
                                        </span>
                                    </label>
                                    
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input class="form-check-input" name="move_in_template" type="radio" value="2" />
                                        <span class="fw-bold ps-2 fs-6">
                                            No
                                        </span>
                                    </label>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6"></label>
                            <div class="col-lg-8 fv-row">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">Set instant option Or delay time:</label>
                                <input class="form-check-input me-2 mt-3" name="instant_sms" type="checkbox" >
                                <label class="form-check-label me-10">Instant</label> 
                                <label class="col-lg-4 col-form-label fw-bold fs-6">OR</label>   
                                <input class="form-control mt-4" name="delay_time" type="text" placeholder="Exp: 30 minutes">
                                <label class="col-lg-4 col-form-label fw-bold fs-6 mt-4">Allow Duplicate Check:</label>
                                <input class="form-check-input me-2 mt-4" name="dupli_enable_sms" type="checkbox" >
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Select source to make URL shorter:</label>
                            <div class="col-lg-8 fv-row">
                                <div class="d-flex align-items-center mt-3">
                                    <label class="form-check form-check-inline form-check-solid me-5">
                                        <input class="form-check-input" name="source_type" type="radio" id="bitly" value="1"  />
                                        <span class="fw-bold ps-2 fs-6">
                                            Bitly  
                                        </span>
                                    </label>
                                    
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input class="form-check-input" name="source_type" type="radio" id="rebrandly"  value="2" checked/>
                                        <span class="fw-bold ps-2 fs-6">
                                            Rebrandly
                                        </span>
                                    </label>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="row mb-6 branding_url">
                            <label class="col-lg-4 col-form-label  fw-bold fs-6"> Enter branding URL:</label>
                            <div class="col-lg-8 fv-row">
                                <select name="branding_url" class="form-select form-select-solid form-select-lg">
                                    <option value="Please select">Please select</option>
                                    <option value="save.fyi">save.fyi</option>
                                    <option value="rebrand.ly">rebrand.ly</option>
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label  fw-bold fs-6"> Attributes:</label>
                        <div class="col-lg-8 fv-row">
                            <select name="message_attribute" size="4" class="form-select form-select-solid form-select-lg">
                                <option value="@Affiliate_Logo@">@Affiliate_Logo@</option>
                                <option value="@Address@">@Address@</option>
                                <option value="@Affiliate_Facebook_Link@">@Affiliate_Facebook_Link@</option>
                                <option value="@Affiliate_Twitter_Link@">@Affiliate_Twitter_Link@</option>
                                <option value="@Affiliate_Linkedin_Link@">@Affiliate_Linkedin_Link@</option>
                                <option value="@Affiliate_Youtube_Link@">@Affiliate_Youtube_Link@</option>
                                <option value="@Affiliate_Google_Plus_Link@">@Affiliate_Google_Plus_Link@</option>
                                <option value="@Affiliate_Name@">@Affiliate_Name@</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6"> Message:</label>
                        <div class="col-lg-8 fv-row">
                            <textarea id="ckeditor_content" rows="12" class="form-control form-control-lg form-control-solid"  name="message" cols="50"></textarea>
                        </div>
                    </div>
                
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{url('/affiliates/templates')}}/{{$affiliate_id}}/{{$source}}/{{$type}}/{{$email_type}}" class="btn btn-white btn-active-light-primary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="add_affiliate">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!--end::Row-->
    @section('scripts')
        <script src="/custom/js/affiliates.js"></script>
    @endsection
</x-base-layout>
