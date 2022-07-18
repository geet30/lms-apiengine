    <!--begin::General options-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <form role="form" id="apply_now_popup_form" class="apply_now_popup_form" name="apply_now_popup_form">
            @csrf
            <div class="card card-flush py-4">
                <!--begin::Card body-->
                <div class="card-body px-8">
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-6">Show Plan on?</label>
                        <div class="col-lg-6 content_allow">
                            <div class="d-flex align-items-center mt-3">
                            @php 
                                $check1 = '';
                                $check2 = '';
                                    if(isset($pop_up_content["show_plan_on"])) 
                                    {
                                        $options = explode(',',$pop_up_content["show_plan_on"]);
                                        //dd($options);
                                        foreach($options as $value){
                                            $intValue = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);                                        
                                            if($intValue == 1){
                                                $check1 = 'checked';
                                            } else if($intValue == 2){
                                                $check2 = 'checked';
                                            }
                                        }
                                    }
                                @endphp
                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="show_plan_on[]" type="checkbox" {{$check1}} value="1" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Online') }}
                                    </span>
                                </label>
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="show_plan_on[]" type="checkbox" {{$check2}} value="2" />
                                    <span class="fw-bold ps-2 fs-6">
                                        {{ __('Telesales') }}
                                    </span>
                                </label>   
                                <p><span class="error text-danger"></span></p>                         
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label fw-bold fs-6">Apply Now Pop Up Parameter </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12">
                            <select data-control="" data-placeholder="Select Tag" data-hide-search="true" name="select_selectsplitter3" id="select_selectsplitter3" class="form-select form-select-solid apply_popup_select" size="5" data-id="apply_popup_select">
                                <option value="@Provider_Name@" class="pop_up_parameter">@Provider_Name@</option>
                                <option value="@Provider_Term_And_Conditions@" class="pop_up_parameter">@Provider_Term_And_Conditions@</option><!-- energy -->
                                <option value="@Provider_Logo@" class="pop_up_parameter">@Provider_Logo@</option>
                                <option value="@name@" class="pop_up_parameter">@name@</option><!-- broadband -->
                                <option value="@Provider_Phone_Number@" class="pop_up_parameter">@Provider_Phone_Number@</option>
                                <option value="@Provider_Email@" class="pop_up_parameter">@Provider_Email@</option>
                                <option value="@Affiliate_Name@" class="pop_up_parameter">@Affiliate_Name@</option>
                                <option value="@Affiliate_Logo@" class="pop_up_parameter">@Affiliate_Logo@</option>
                                <option value="@Customer_Full_Name@" class="pop_up_parameter">@Customer_Full_Name@</option>
                                <option value="@Customer_Mobile_Number@" class="pop_up_parameter">@Customer_Mobile_Number@</option>
                                <option value="@Customer_Email@" class="pop_up_parameter">@Customer_Email@</option>
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label required fw-bold fs-6">Apply Now Pop Up Content</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12 pop_up_content">
                            <textarea type="text" id="pop_up_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="pop_up_content">{{$pop_up_content["description"]??''}}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
                <div class="card-footer pt-0 px-8">
                    <div class="pull-right">
                        <!--begin::Button-->
                        <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="apply_now_popup_submit" class="btn btn-primary">
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
