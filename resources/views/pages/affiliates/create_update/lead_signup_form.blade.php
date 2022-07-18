<form role="form" name="lead_signup_form" id="submit_plan_type_form">
    @csrf
    <input type="hidden" name="userId" value="{{encryptGdprData($affiliateuser[0]['user']['id'])}}" />
    
        <div class="row mb-6">
            <label class="col-lg-2 col-form-label  fw-bold fs-6">Lead pop-up</label>
            <div class="col-lg-10 fv-row">
                <div class="row d-flex align-items-center mt-3">
                    <label class=" col-lg-2 form-check form-switch form-check-custom form-check-solid">
                     <input class="form-check-input signup_popup_class"  name="sign_up_pop_up" type="checkbox" {{ isset($leadPopupData[3][1]) && $leadPopupData[3][1] !=1 ? '' :'checked'}} />
                    <span class="form-check-label fw-bold ">
                        Enable
                    </span>
                    </label>
                </div>
                <span class="error text-danger sign_up_pop_up_error"></span>
            </div>
        </div>
        
         
       
        <div class="row mb-6">
            <label class="col-lg-2 col-form-label  fw-bold fs-6">Name</label>
            <div class="col-lg-4   col-form-label  fw-bold fs-6 showOnSignupPopup">
                <div class="row">
                <label class=" col-lg-6 form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input lead_popup_name_enabled" type="checkbox" name="lead_popup_name_enabled" {{ isset($leadPopupData[3][2]) && ($leadPopupData[3][2] ==1 || $leadPopupData[3][2] ==2  )? 'checked' :''}}  />
                    <span class="form-check-label fw-bold ">
                    Enable
                    </span>
                </label>
                <label class=" col-lg-6 form-check form-switch form-check-custom form-check-solid lead_popup_name_required_main" >
                    <input class="form-check-input lead_popup_name_required" type="checkbox"  name="lead_popup_name_required" {{ isset($leadPopupData[3][2]) && $leadPopupData[3][2] ==1 ? 'checked' :''}} />
                    <span class="form-check-label fw-bold ">
                    Required
                    </span>
                </label>
                </div>
            </div>

            <div class="col-lg-6 fv-row">
                    <div class="d-flex align-items-center ">
                        <input type="text" class="form-control form-control-lg form-control-solid mt-2 lead_popup_name inputFieldCommon" name="lead_popup_name" placeholder="e.g. Steve" value="{{ isset($leadPopupData[3][5]) && $leadPopupData[3][5] != '' ? $leadPopupData[3][5]  :''}}"/>
                    </div>
                    <span class="error text-danger lead_popup_name_error"></span>
            </div>
            
        </div>
        <div class="row mb-6">
            <label class="col-lg-2 col-form-label  fw-bold fs-6">Email:</label>
            <div class="col-lg-4   col-form-label  fw-bold fs-6 showOnSignupPopup">
                <div class="row">
                    <label class=" col-lg-6 form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input lead_popup_email_enabled" type="checkbox"  name="lead_popup_email_enabled" {{ isset($leadPopupData[3][3]) && ($leadPopupData[3][3] ==1 || $leadPopupData[3][3] ==2  )? 'checked' :''}}/>
                        <span class="form-check-label fw-bold ">
                        Enable
                        </span>
                    </label>
                    <label class=" col-lg-6 form-check form-switch form-check-custom form-check-solid lead_popup_email_required_main">
                        <input class="form-check-input lead_popup_email_required" type="checkbox" name="lead_popup_email_required" {{ isset($leadPopupData[3][3]) && $leadPopupData[3][3] ==1 ? 'checked' :''}}/>
                        <span class="form-check-label fw-bold ">
                        Required
                        </span>
                    </label>
                </div>
            </div>

            <div class="col-lg-6 fv-row">
                    <div class="d-flex align-items-center ">
                        <input type="text" class="form-control form-control-lg form-control-solid mt-2 lead_popup_email inputFieldCommon" name="lead_popup_email" placeholder="e.g. steve@cimet.com.au" value="{{ isset($leadPopupData[3][6]) && $leadPopupData[3][6] != '' ? $leadPopupData[3][6]  :''}}"/>
                    </div>
                    <span class="error text-danger lead_popup_email_error"></span>
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-2 col-form-label  fw-bold fs-6">Phone:</label>
            <div class="col-lg-4   col-form-label  fw-bold fs-6 showOnSignupPopup">
                <div class="row">
                    <label class=" col-lg-6 form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input lead_popup_phone_enabled" type="checkbox"  name="lead_popup_phone_enabled" {{ isset($leadPopupData[3][4]) && ($leadPopupData[3][4] ==1 || $leadPopupData[3][4] ==2  )? 'checked' :''}}/>
                        <span class="form-check-label fw-bold ">
                        Enable
                        </span>
                    </label>
                    <label class=" col-lg-6 form-check form-switch form-check-custom form-check-solid lead_popup_phone_required_main">
                        <input class="form-check-input lead_popup_phone_required" type="checkbox" name="lead_popup_phone_required"  {{ isset($leadPopupData[3][4]) && $leadPopupData[3][4] ==1 ? 'checked' :''}}/>
                        <span class="form-check-label fw-bold ">
                        Required
                        </span>
                    </label>
                </div>
            </div>   

            <div class="col-lg-6 fv-row">
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control form-control-lg form-control-solid mt-2 lead_popup_phone inputFieldCommon" name="lead_popup_phone" placeholder="e.g. 04-98567123" value="{{ isset($leadPopupData[3][7]) && $leadPopupData[3][7] != '' ? $leadPopupData[3][7]  :''}}"/>
                    </div>
                    <span class="error text-danger lead_popup_phone_error"></span>
            </div>
        </div>
   
                  
    <div class="text-end">
        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
        <button type="submit" class="btn btn-primary" id="plan_type_submit_btn">
            @include('partials.general._button-indicator', ['label' => __('buttons.save')])
        </button>
    </div>
</form>