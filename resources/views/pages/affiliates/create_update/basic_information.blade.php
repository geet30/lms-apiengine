@if(isset($affiliateuser))
@foreach ($affiliateuser[0]['getaffiliateservices'] as $value)
@php $selectedserviceid[] = $value['service_id'] @endphp
@endforeach
@foreach ($affiliateuser[0]['getunsubscribesources'] as $values)
@php $selectedsource[] = $values['unsubscribe_source'] @endphp
@endforeach
@endif
<div class="card mb-5 mb-xl-10">
    <form role="form" name="@if($type=='sub-affiliates')subaffiliate_basic_detail_form @else affiliate_basic_detail_form @endif" class="affiliate_basic_detail_form">
        @csrf
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Basic Details</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                @if($type=="sub-affiliates")
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Sub Affiliate Type</label>
                    <div class="col-lg-8 fv-row sub_affiliate_type">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input radio-w-h-18" name="sub_affiliate_type" type="radio" value="1" @if (@$affiliateuser[0]['sub_affiliate_type']==1) checked @endif />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('Referral') }}
                            </span>
                        </label>
                        <label class="form-check form-check-inline form-check-solid">
                            <input class="form-check-input radio-w-h-18" name="sub_affiliate_type" type="radio" value="2" @if (@$affiliateuser[0]['sub_affiliate_type']==2) checked @endif />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('Co-brand') }}
                            </span>
                        </label>
                        <br />
                        <span class="error text-danger"></span>
                    </div>
                </div>
                @endif

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">First Name</label>
                    <div class="col-lg-8 fv-row first_name">
                        <input type="text" name="first_name" class="form-control form-control-lg form-control-solid" placeholder="e.g. Steve" value="{{ucfirst(decryptGdprData(@$affiliateuser[0]['user']['first_name']))}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Last Name</label>
                    <div class="col-lg-8 fv-row last_name">
                        <input type="text" name="last_name" class="form-control form-control-lg form-control-solid" placeholder="e.g. Waugh" value="{{ucfirst(decryptGdprData(@$affiliateuser[0]['user']['last_name']))}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
                    <div class="col-lg-8 fv-row email">
                        <input type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="e.g. steve.waugh@gmail.com" value="{{decryptGdprData(@$affiliateuser[0]['user']['email'])}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Affiliate Phone</label>
                    <div class="col-lg-8 fv-row phone">
                        <input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="e.g. 9999999999" value="{{decryptGdprData(@$affiliateuser[0]['user']['phone'])}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>
                @if($type!="sub-affiliates")
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Legal Name</label>
                    <div class="col-lg-8 fv-row legal_name">
                        <input type="text" name="legal_name" class="form-control form-control-lg form-control-solid" placeholder="e.g. Steve" value="{{decryptGdprData(@$affiliateuser[0]['legal_name'])}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>
                @endif
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Company Name</label>
                    <div class="col-lg-8 fv-row company_name">
                        <input type="text" name="company_name" class="form-control form-control-lg form-control-solid" placeholder="e.g. demo pvt.ltd" value="{{@$affiliateuser[0]['company_name']}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>
                @if($type!="sub-affiliates")
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Set Message Sender Id</label>
                    <div class="col-lg-8 fv-row sender_id">
                        <input type="text" name="sender_id" class="form-control form-control-lg form-control-solid" placeholder="e.g. Elcgas" value="{{@$affiliateuser[0]['sender_id']}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Support Phone Number</label>
                    <div class="col-lg-8 fv-row support_phone_number">
                        <input type="tel" name="support_phone_number" class="form-control form-control-lg form-control-solid" placeholder="e.g. 9999999999" value="{{decryptGdprData(@$affiliateuser[0]['support_phone_number'])}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>
                @endif
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Company Address</label>
                    <div class="col-lg-8 fv-row company_address spinner spinner-danger mr-15">
                        <input type="text" name="company_address" class="form-control form-control-lg form-control-solid searchaddress" placeholder="e.g. 45 Ranworth Road Willagee Western Australia" value="{{@$affiliateuser[0]['getuseradress']['address']}}" autocomplete="off" />
                        <ul id="searchedaddress" class="form-control form-control-lg form-control-solid searchedaddress">
                        </ul>
                        <span class="error text-danger"></span>
                    </div>
                </div>

                @if($type=="sub-affiliates")
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Referral URL Title</label>
                    <div class="col-lg-8 fv-row referral_code_title">
                        <input type="text" name="referral_code_title" class="form-control form-control-lg form-control-solid" placeholder="e.g. Title" value="{{@$affiliateuser[0]['referral_code_title']}}" autocomplete="off" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Referral Code URL</label>
                    <div class="col-lg-8 fv-row referral_code_url">
                        <input type="text" name="referral_code_url" class="form-control form-control-lg form-control-solid" placeholder="e.g. http://demo.com" value="{{@$affiliateuser[0]['referral_code_url']}}" autocomplete="off" />
                        @if ($opr == 'edit')
                        <div class="referal_code">
                            <span style="font-size:11px; color:grey;">BASE URL : {{@$affiliateuser[0]['referral_code_url'].'?rc='.@$affiliateuser[0]['referal_code']}}</span>
                        </div>
                        @endif
                        <span class="error text-danger"></span>
                    </div>
                </div>
                @endif
                @if($type!="sub-affiliates")
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">Generate Plan Listing Token</label>
                    <div class="col-lg-8 fv-row">
                        <div class="form-check form-check-solid form-switch fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing" name="marketing" value="" {{ @$affiliateuser[0]['generate_token'] == 1 ? 'checked' : '' }} />
                            <label class="form-check-label" for="allowmarketing"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">Unsubscribe Source</label>
                    <div class="col-lg-8 fv-row">
                        <div class="d-flex align-items-center mt-3">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input" name="unsubscribe_source[]" type="checkbox" value="1" @if(isset($selectedsource)) @if(in_array(1, $selectedsource)) checked @endif @endif />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Email') }}
                                </span>
                            </label>
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input" name="unsubscribe_source[]" type="checkbox" value="2" @if(isset($selectedsource)) @if(in_array(2, $selectedsource)) checked @endif @endif />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('SMS') }}
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Show on Agent Portal</label>
                    <div class="col-lg-8 fv-row show_agent_portal">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input radio-w-h-18" name="show_agent_portal" type="radio" value="1" @if (@$affiliateuser[0]['show_agent_portal']==1) checked @endif />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('Yes') }}
                            </span>
                        </label>
                        <label class="form-check form-check-inline form-check-solid">
                            <input class="form-check-input radio-w-h-18" name="show_agent_portal" type="radio" value="2" @if (@$affiliateuser[0]['show_agent_portal']==2) checked @endif />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('No') }}
                            </span>
                        </label>
                        <br />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Allow Cross Selling</label>
                    <div class="col-lg-8 fv-row crossselling">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input radio-w-h-18" name="crossselling" type="radio" value="1" @if (@$affiliateuser[0]['cross_selling']==1) checked @endif/>
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('Yes') }}
                            </span>
                        </label>
                        <label class="form-check form-check-inline form-check-solid">
                            <input class="form-check-input radio-w-h-18" name="crossselling" type="radio" value="2"  @if (@$affiliateuser[0]['cross_selling']==2) checked @endif/>
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('No') }}
                            </span>
                        </label>
                        <br />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <input type="hidden" name="id" class="affiliate_user_id" value="{{@encryptGdprData($affiliateuser[0]['user_id'])}}">
                <input type="hidden" name="parent_id" value="{{@encryptGdprData($affiliateuser[0]['parent_id'])}}">
                @if($type=="sub-affiliates")
                <input type="hidden" name="user_id" value="{{ Request::segment(4) }}">
                @endif
                <div class="card-footer d-flex justify-content-end py-6 px-0 border-0">

                    <a href="{{ theme()->getPageUrl($diff_aff) }}" class="btn btn-white btn-active-light-primary me-2">{!! __('buttons.cancel') !!}</a>

                    <button type="submit" class="submit_button" class="btn btn-primary">
                        @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                    </button>
                </div>

            </div>
        </div>

    </form>
</div>
@if($type=="edit" || $opr=='edit')
@if($type!="sub-affiliates")
<div class="card mb-5 mb-xl-10">
    <form role="form" name="affiliate_logo_form" class="affiliate_logo_form">
        {{ csrf_field() }}
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Logo
                    </h2>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Company Logo</label>
                    <div class="col-lg-8 fv-row logo">
                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('/common/media/avatars/blank.png')">
                            @if(isset($affiliateuser[0]['logo']))
                            @php
                            $logo = $affiliateuser[0]['logo'];
                            @endphp
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{$logo }}')"></div>
                            @else
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url('/common/media/avatars/blank.png')"></div>
                            @endif
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Logo">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                            </label>
                        </div>
                        <div class="form-text">Allowed file types: png.</div>
                        <div class="form-text">Logo dimensions must be 300*130 pixels</div>
                        <span class="error text-danger"></span>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" class="affiliate_user_id" value="{{@encryptGdprData($affiliateuser[0]['user_id'])}}">
            <input type="hidden" name="parent_id" value="{{@encryptGdprData($affiliateuser[0]['parent_id'])}}">
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ theme()->getPageUrl($diff_aff) }}" class="btn btn-white btn-active-light-primary me-2">{!! __('buttons.cancel') !!}</a>

                <button type="submit" class="submit_button" class="btn btn-primary">
                    @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                </button>
            </div>

        </div>
    </form>
</div>
<div class="card mb-5 mb-xl-10">
    <form name="affiliate_spark_post_feature_form" role="form" class="affiliate_spark_post_feature_form">
        @csrf
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>SparkPost API Key
                    </h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">SparkPost API Key</label>

                    <div class="col-lg-8 fv-row affiliate_sparkpostkey position-relative mb-3 " data-kt-password-meter="true">
                        <input type="password" name="affiliate_sparkpostkey" id="affiliate_sparkpostkey" class="form-control form-control-lg form-control-solid" placeholder="e.g. 1cac124e55fbc2904f61afe" value="{{@$affiliateuser[0]['getthirdpartyapi']['api_key']}}" />
                        @if(isset($affiliateuser[0]['getthirdpartyapi']['api_key']))
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                data-kt-password-meter-control="visibility">
                                <i class="bi bi-eye-slash fs-2"></i>

                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        @endif
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <!--end::Input group-->
            </div>
            <input type="hidden" name="id" class="affiliate_user_id" value="{{@encryptGdprData($affiliateuser[0]['user_id'])}}">
            <input type="hidden" name="parent_id" value="{{@encryptGdprData($affiliateuser[0]['parent_id'])}}">
            <!--end::Card header-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ theme()->getPageUrl($diff_aff) }}" class="btn btn-white btn-active-light-primary me-2">{!! __('buttons.cancel') !!}</a>

                <button type="submit" class="submit_button" class="btn btn-primary">
                    @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                </button>
            </div>
        </div>
    </form>
</div>
@endif
@endif
