<x-base-layout>
    <!--begin::Row-->

    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0" role="button" style="background:#009ef7 !important;">
            <div class="card-title m-0">
                @if($source == "1" && $type=='1')
                @if(!isset($editData))
                <h3 class="fw-bolder m-0 text-white">Add Welcome Email Template: {{$affiliateData}}</h3>
                @else
                <h3 class="fw-bolder m-0 text-white">Edit Welcome Email Template: {{$affiliateData}}</h3>
                @endif
                @endif
                @if($source == "1" && $type=='2')
                @if(!isset($editData))
                <h3 class="fw-bolder m-0 text-white">Add Remarketing Template: {{$affiliateData}}</h3>
                @else
                <h3 class="fw-bolder m-0 text-white">Edit Remarketing Template: {{$affiliateData}}</h3>
                @endif
                @endif
                @if($source == "1" && $type=='4')
                @if(!isset($editData))
                <h3 class="fw-bolder m-0 text-white">Add Send Plan Email: {{$affiliateData}}</h3>
                @else
                <h3 class="fw-bolder m-0 text-white">Edit Send Plan Email: {{$affiliateData}}</h3>
                @endif
                @endif
                @if($source == "2")
                @if(!isset($editData))
                <h3 class="fw-bolder m-0 text-white">Add Message template: {{$affiliateData}}</h3>
                @else
                <h3 class="fw-bolder m-0 text-white">Edit Message template: {{$affiliateData}}</h3>
                @endif
                @endif
            </div>
        </div>
        <div id="kt_affliate_form_details" class="">
            <form class="form" id="affilate_email_sms_template" enctype="multipart/form-data">
                <div class="card-body border-top p-9">
                    <input type="hidden" name="user_id" id="user_id" value="{{$affiliate_id}}">
                    <input type="hidden" name="id" value="{{isset($editData)?encryptGdprData($editData->id):''}}">
                    <input type="hidden" name="type" value="{{$source}}">
                    <input type="hidden" name="email_type" value="{{$type}}">
                    <input type="hidden" name="action" value="{{isset($editData)?'edit':'add'}}">
                    <input type="hidden" name="service_id" @foreach ($services as $service) @if($email_type==$service->service_id)
                    value="{{$service->service_id}}"
                    @endif
                    @endforeach
                    >

                    <input type="hidden" name="template_type" value="{{$template_type}}">
                    @if($source == "2" && $type =='3')
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label fw-bold fs-6">{{trans('affiliates.target_type')}}</label>
                        <div class="col-sm-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input move_in_normal" name="target_type" value="lead" type="radio" @if(isset($editData->target_type)) {{$editData->target_type == "lead"?"checked":''}} @else checked @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        Lead
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input move_in" name="target_type" value="sale" type="radio" @if(isset($editData)) {{$editData->target_type	 == "sale"?"checked":''}} @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        Sales
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label fw-bold fs-6">{{trans('affiliates.restrict_time')}}:</label>
                        <div class="col-sm-8 fv-row">
                            <input class="form-check-input me-3" name="check_restricted_time" type="checkbox" value="1" {{isset($editData->check_restricted_time) && ($editData->check_restricted_time ==1)?'checked':''}}>
                        </div>
                    </div>
                    @endif
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6">{{trans('affiliates.template_name')}}:</label>
                        <div class="col-sm-8 fv-row template_name">
                            <input type="text" name="template_name" class="form-control form-control-sm form-control-solid" placeholder="e.g. New_Remarketing" value="{{isset($editData->template_name)?$editData->template_name:''}}">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    @if(($source == "2") && ($type =='1' || $type =='3'))
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label fw-bold fs-6">{{trans('affiliates.sender_id')}}</label>
                        <div class="col-sm-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input move_in_normal" name="sender_id_method" type="radio" value="1" @if(isset($editData)) {{$editData->sender_id_method	 == 1?"checked":''}} @else checked @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        Default(Affilate Sender Id)
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input move_in" value="2" name="sender_id_method" type="radio" @if(isset($editData)) {{$editData->sender_id_method	 == 2?"checked":''}} @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        Custom
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input move_in" value="3" name="sender_id_method" type="radio" @if(isset($editData)) {{$editData->sender_id_method	 == 3?"checked":''}} @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        2-Way
                                    </span>
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="row mb-6 sender_custom_id">

                        <label class="col-sm-4 col-form-label  fw-bold fs-6"></label>
                        <div class="col-sm-8 fv-row sender_id">
                            <input type="text" name="sender_id" class="form-control form-control-sm form-control-solid" placeholder="{{trans('affiliates.enter_sender_id')}}" value="@if(isset($editData)) {{$editData->sender_id_method	 == 2?$editData->sender_id:''}} @endif">
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6 sender_plivo">
                        <label class="col-sm-4 col-form-label  fw-bold fs-6"></label>
                        <div class="col-sm-8 fv-row plivo_number">

                            <select name="plivo_number" class="form-select form-select-solid form-select-sm">
                                <option value="" selected="selected">Please select</option>

                                @foreach ($plivoNumbers as $plivoNumber)
                                <option value="{{$plivoNumber->number}}">{{$plivoNumber->alias}}({{$plivoNumber->number}})</option>
                                @endforeach

                            </select>
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    @endif

                    @if(($type =='2' && $email_type=='3') || ($type =='2' && $email_type=='2'))
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label fw-bold fs-6">{{trans('affiliates.utm_rm')}}:</label>
                        <div class="col-sm-8 fv-row">
                            <input type="text" name="utm_rm" class="form-control form-control-sm form-control-solid" value="{{isset($editData)?$editData->utm_rm:''}}">
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label fw-bold fs-6">{{trans('affiliates.utm_rm_date')}}:</label>
                        <div class="col-sm-8 fv-row">
                        <input type="hidden" name="utm_rm_date_status" type="checkbox" value="0">
                        <input class="form-check-input me-3" name="utm_rm_date_status" type="checkbox" value="1" @if(isset($editData)) {{$editData->utm_rm_date_status == 1?"checked":''}} @endif>
                        </div>
                    </div>

                    @endif
                    @if($source=='1')
                    @if(isset($editData))
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label fw-bold fs-6">{{trans('affiliates.template_id')}}</label>
                        <div class="col-sm-8 fv-row">
                            <input type="text" readonly class="form-control form-control-sm form-control-solid" value="{{isset($editData)?$editData->template_id:''}}">
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    @endif
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6">{{trans('affiliates.from_name')}}:</label>
                        <div class="col-sm-8 fv-row from_name">
                            <input type="text" name="from_name" placeholder="e.g. Cimet Sales" class="form-control form-control-sm form-control-solid" value="{{isset($editData)?$editData->from_name:''}}">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <div class="row mb-6 from_email">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6">{{trans('affiliates.from_email')}}:</label>
                        <div class="col-sm-8 fv-row">
                            <input type="text" name="from_email" placeholder="e.g. sales@cimet.com.au" class="form-control form-control-sm form-control-solid" value="{{isset($editData)?$editData->from_email:''}}">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6">{{trans('affiliates.bounce')}}</label>
                        <div class="col-sm-8 fv-row sending_domain">
                            <select name="sending_domain" class="form-select form-select-solid form-select-sm">
                                <option value="">Default Bounce Domain</option>
                                @if(isset($domainOrPool->sendingDomains->results))
                                @foreach ($domainOrPool->sendingDomains->results as $domains)
                                <option value="{{$domains->domain}}" @if(isset($editData)) @if($editData->sending_domain == $domains->domain)
                                    selected="selected"
                                    @endif
                                    @endif>{{$domains->domain}}</option>
                                @endforeach
                                @endif

                            </select>
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6 ">{{trans('affiliates.ip_pool')}}</label>
                        <div class="col-sm-8 fv-row ip_pool">


                            <select name="ip_pool" class="form-select form-select-solid form-select-sm">
                                <option value="">Please select any IP Pool</option>
                                @if(isset($domainOrPool->ip_pools->results))
                                @foreach ($domainOrPool->ip_pools->results as $pool)
                                <option value="{{$pool->id}}" @if(isset($editData)) @if($editData->ip_pool == $pool->id)
                                    selected="selected"
                                    @endif
                                    @endif
                                    >
                                    {{$pool->name}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label  fw-bold fs-6">{{trans('affiliates.reply_to')}}:</label>
                        <div class="col-sm-8 fv-row reply_to">
                            <input type="text" name="reply_to" placeholder="e.g. sales@cimet.com.au" class="form-control form-control-sm form-control-solid" value="{{isset($editData)?$editData->reply_to:''}}">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6 ">{{trans('affiliates.subject')}}:</label>
                        <div class="col-sm-8 fv-row subject">
                            <input type="text" name="subject" placeholder="e.g. Compare your Energy for amazing offers" class="form-control form-control-sm form-control-solid" value="{{isset($editData)?$editData->subject:''}}">
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6 description">{{trans('affiliates.description')}}</label>
                        <div class="col-sm-8 fv-row description">
                            <textarea class="form-control form-control-sm form-control-solid" placeholder="e.g. To see latest offers for you - Click here" name="description" cols="50" rows="10">@if(isset($editData)){{$editData->description}}@endif</textarea>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    @endif
                    @if(($source == '1' && $type =='2') || ($source == '2' && $type =='2'))
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label fw-bold fs-6 ">
                            Select Remarketing
                            @if($source == "1")
                            Email
                            @else
                            SMS
                            @endif
                        </label>
                        <div class="col-sm-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input normal_radio normal_movin" name="select_remarketing_type" type="radio" value="1" @if(isset($editData)) {{$editData->select_remarketing_type == 1?"checked":''}} @else checked @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        Normal
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input move_in_radio normal_movin" name="select_remarketing_type" type="radio" value="2" @if(isset($editData)) {{$editData->select_remarketing_type == 2?'checked':''}} @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        MoveIn
                                    </span>
                                </label>

                            </div>
                        </div>
                    </div>


                    <div class="row mb-6 move_in_customers">
                        <label class="col-sm-4 col-form-label fw-bold fs-6">{{trans('affiliates.move_in_customers')}}</label>
                        <div class="col-sm-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" name="move_in_template" type="radio" value="1" @if(isset($editData)) {{$editData->move_in_template == 1?'checked':''}} @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        Yes
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input" name="move_in_template" type="radio" value="2" @if(isset($editData)) {{$editData->move_in_template == 2?"checked":''}} @else checked @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        No
                                    </span>
                                </label>

                            </div>
                        </div>
                    </div>
                    @endif
                    @if(($source == '1' && $type =='2') || ($source == '2' && $type =='2')||($source == '2' && $type =='3'))

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6 interval_text">{{trans('affiliates.days_interval')}}:</label>
                        <div class="col-sm-8 fv-row interval">
                            <input type="number" id="interval" name="interval" placeholder="e.g. 4" onkeypress="return event.charCode >= 48 && event.charCode <= 57" min="0" class="form-control form-control-sm form-control-solid" value="{{isset($editData)?$editData->interval:''}}">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <div class="row" class="instant_option">

                        <div class="col-md-4">
                            <div class="col-sm-12">
                                <label class=" col-form-label fw-bold fs-6">{{trans('affiliates.instant_option')}}:</label>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="col-sm-12">
                                <input class="form-check-input me-2 mt-3" id="instant" name="instant" type="checkbox" value="1" @if(isset($editData)) {{$editData->immediate_sms == 1?"checked":''}} @endif>
                                <label class=" form-check-label me-10 mt-3">Instant</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="col-sm-12">
                                <label class="col-form-label fw-bold fs-6">OR</label>
                            </div>

                        </div>
                        <div class="col">
                            <?php
                            $hours = "00:00";
                            if (isset($editData->delay_time) && $editData->delay_time != null) {
                                $hours = intdiv($editData->delay_time, 60) . ':' . ($editData->delay_time % 60);
                            }
                            ?>
                            <div class="col-sm-12 delay_time">
                                <input class="form-control mt-4 form-control-solid" id="delay_time" name="delay_time" placeholder="e.g. 30" readonly="ture" value="{{$hours}}">
                                <span class="error text-danger"></span>
                            </div>
                        </div>

                    </div>
                    @if(($source == '1' && $type =='2') || ($source == '2' && $type =='2'))
                    <div class="row instant_option">
                        <div class="col-md-4">
                            <div class="col-sm-12">
                                <label class="col-form-label fw-bold fs-6"> </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="col-sm-12">
                                <label class="col-form-label fw-bold fs-6 mt-4">{{trans('affiliates.allow_duplicate')}}:</label>
                                <input class="form-check-input me-2 mt-7" name="dupli_enable" value="1" type="checkbox" {{isset($editData->remarketing_duplicate_check) && ($editData->remarketing_duplicate_check ==1)?'checked':''}}>
                            </div>
                        </div>
                        <div class="col">
                            <div class="col-sm-12">
                                <label class="col-form-label fw-bold fs-6"> </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="col-sm-12">
                                <label class="col-form-label fw-bold fs-6"> </label>
                            </div>
                        </div>

                    </div>
                    @endif
                    <div class="row mb-6" id="interval_day_time">
                        <label class="col-sm-4 col-form-label fw-bold fs-6"> Time:</label>
                        <div class="col-sm-8 fv-row remarketing_time">
                            <input class="form-control form-control-sm form-control-solid" placeholder="" readonly="readonly" name="remarketing_time" type="text" value="{{isset($editData)?$editData->remarketing_time:''}}" id="remarketing_time">
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    @endif
                    @if($source == '2' && ($type == "2"||$type == "3"))
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6">{{trans('affiliates.shorter_url')}}:</label>
                        <div class="col-sm-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input url_short" name="source_type" type="radio" id="bitly" value="1" @if(isset($editData)) {{$editData->source_type == 1?'checked':''}} @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        Bitly
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input url_short" name="source_type" type="radio" id="rebrandly" value="2" @if(isset($editData)) {{$editData->source_type == 2?"checked":''}} @else checked @endif />
                                    <span class="fw-bold ps-2 fs-6">
                                        Rebrandly
                                    </span>
                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="row mb-6 branding_url">
                        <label class="col-sm-4 col-form-label  fw-bold fs-6">{{trans('affiliates.branding_url')}}</label>
                        <div class="col-sm-8 fv-row">
                            <select name="branding_url" class="form-select form-select-solid form-select-sm">
                                <option value="">Please select</option>
                                <option value="save.fyi">save.fyi</option>
                                <option value="rebrand.ly">rebrand.ly</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    @if($source == "1")
                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label fw-bold fs-6">{{trans('affiliates.tracking_option')}}</label>
                        <div class="col-sm-8 fv-row">
                            <input class="form-check-input me-2" name="opens_tracking" type="checkbox" value="1" @if(isset($editData)) {{$editData->opens_tracking==1?'checked':''}} @else checked @endif>
                            <label class="form-check-label me-2">
                                {{trans('affiliates.track_open')}}
                            </label>

                            <input class="form-check-input me-2" name="click_tracking" type="checkbox" value="1" @if(isset($editData)){{$editData->click_tracking==1?'checked':''}} @else checked @endif>
                            <label class="form-check-label me-2">
                                {{trans('affiliates.track_click')}}
                            </label>

                            <input class="form-check-input me-2" name="transactional" type="checkbox" value="1" @if(isset($editData)){{$editData->transactional==1?'checked':''}} @else checked @endif>
                            <label class="form-check-label me-2">
                                {{trans('affiliates.transactional')}}
                            </label>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label  fw-bold fs-6"> {{trans('affiliates.cc_email')}}</label>
                        <div class="col-sm-8 fv-row">
                            <textarea class="form-control form-control-sm form-control-solid" name="email_cc" cols="50" rows="2" placeholder="e.g. cimetInternal.com.au,cimetInternal.com.au">{{isset($editData)?$editData->email_cc:''}}</textarea>
                            <!-- {{trans('affiliates.demo_email')}}-->
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label  fw-bold fs-6">{{trans('affiliates.bcc_email')}}</label>
                        <div class="col-sm-8 fv-row">
                            <textarea class="form-control form-control-sm form-control-solid" name="email_bcc" cols="50" rows="2" placeholder="e.g. cimetInternal.com.au,cimetInternal.com.au">{{isset($editData)?$editData->email_bcc:''}}</textarea>
                            <!-- {{trans('affiliates.demo_email')}}-->
                        </div>
                    </div>
                    @endif

                    <div class=" row mb-6">
                        <label class="col-sm-4 col-form-label  fw-bold fs-6">
                            @if($source == '1')
                            {{trans('affiliates.html_param')}}
                            @else
                            {{trans('affiliates.attribute')}}
                            @endif
                        </label>
                        <div class="col-sm-8 fv-row">
                            <select name="subject_parameters" id="affiliate_subject_parameter" size="4" class="form-select form-select-solid form-select-sm">
                                @foreach ($parameters as $parameter)

                                <option value="{{$parameter->attribute}}">{{$parameter->attribute}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-4 col-form-label required fw-bold fs-6">
                            @if($source == '1')
                            {{trans('affiliates.html_editor')}}
                            @else
                            {{trans('affiliates.message')}}
                            @endif
                        </label>
                        <div class="col-sm-8 fv-row contents">
                            <textarea id="ckeditor_content" rows="12" class="form-control form-control-sm form-control-solid" name="contents" cols="50">{{isset($editData)?$editData->content:''}}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                    </div>


                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9 border-0">
                    <a href="{{url('/affiliates/templates')}}/{{$affiliate_id}}" class="btn btn-white btn-active-light-primary me-2">{{trans('affiliates.cancel')}}</a>
                    <button type="submit" class="btn btn-primary" id="add_edit_affiliate_button">
                        @include('partials.general._button-indicator', ['label' => __('affiliates.save_changes')])
                    </button>
                </div>
            </form>
        </div>
    </div>


    @section('styles')
    <link href="/common/plugins/custom/flatpickr/flatpickr.bundle.css" rel="stylesheet" type="text/css" />
    @endsection
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/common/plugins/custom/flatpickr/flatpickr.bundle.js"></script>
    <script>
        var titleVal = '{{$headArr["title"]}}';
        var link = '{{$headArr["link"]}}';
       
         var affiliate_name = '{{$affiliateData}}'; 
         console.log(affiliate_name);
 
    </script>
    <script src="/custom/js/affiliate-template.js"></script>
    @endsection
    <!--end::Row-->
</x-base-layout>