<!--begin::Navbar-->
@php

$tmp=gettype($verticals);
if($tmp=='array'){
   $verticalList=$verticals; 
}else{
    $verticalList=$verticals->toArray();
}
$serviceIds=[];
if(!empty($verticalList))
{
    $serviceIds = array_column($verticalList, 'service_id');
    //$res=in_array(1,$serviceIds);
    //dd($res);
}
$address="";
$logo="";
$address=$records['address'];
$logo=$records['logo'];
@endphp
@if(isset($records))

<div class="card-body pt-9 pb-0">
    <!--begin::Details-->
    <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
        <input type="hidden" value="{{($records['affiliate']['user_id'])}}" id="aff_sub_id">
        <input type="hidden" value="{{($records['affiliate']['parent_id'])}}" id="parent_id">
        <div class="me-7 mb-4">
            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                @if($logo)
                    <a data-fancybox="gallery" href="{{$logo}}" data-toggle="tooltip" title="Logo"><img src="{{$logo}}" width="160px" height="160px"></a>
                @else
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }}" alt="image">
                @endif

                @if($records['status']==1)
                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
                @else
                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-danger rounded-circle border border-4 border-white h-20px w-20px"></div>
                @endif
            </div>
        </div>

        <!--begin::Info-->
        <div class="flex-grow-1">
            <!--begin::Title-->
            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                <!--begin::User-->
                <div class="d-flex flex-column">
                    <!--begin::Name-->
                    <div class="d-flex align-items-center mb-2">
                        <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ ($records) ? $records['affiliate']['company_name'] : "" }}</a>
                        <a href="#">
                            {!! theme()->getSvgIcon("icons/duotune/general/gen026.svg", "svg-icon-1 svg-icon-primary") !!}
                        </a>


                        <a href="mailto:{{decryptGdprData($records['email'])}}" target="_blank" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3">{{decryptGdprData($records['email'])}}</a>
                    </div>
                    <!--end::Name-->

                    <!--begin::Info-->
                    <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                        <a class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            {!! theme()->getSvgIcon("icons/duotune/communication/com006.svg", "svg-icon-4 me-1") !!}
                            {{ ($records) ? ucfirst(decryptGdprData($records['first_name'])).' '.ucfirst(decryptGdprData($records['last_name'])) : "" }}
                        </a>

                        <a href="" id="affdetails" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            {!! theme()->getSvgIcon("icons/duotune/communication/com006.svg", "svg-icon-4 me-1") !!}
                            {{ ($records) ? decryptGdprData($records['phone']) : "" }}
                        </a>

                        <a href="http://maps.google.com/?q={{$address}}" target="_blank" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            {!! theme()->getSvgIcon("icons/duotune/general/gen018.svg", "svg-icon-4 me-1") !!}
                            {{$address}}
                        </a>


                    </div>
                    <!--end::Info-->
                </div>
                <!--end::User-->

                <!--begin::Actions-->
                <div class="d-flex my-4">
                    <button type="submit" class="submit_button btn btn-sm btn-primary me-3 reset_password" data-id="{{encryptGdprData($records['id'])}}">
                        @include('partials.general._button-indicator', ['label' => __('Reset Password')])
                    </button>
                    <!--begin::Menu-->
                    <div class="me-0">
                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="bi bi-three-dots fs-3"></i>
                        </button>
                        {{ theme()->getView('pages/affiliates/components/menu',['affiliate_id'=> encryptGdprData($records['id']),'user_id' => encryptGdprData($records['affiliate']['user_id'])]) }}
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Title-->

            <!--begin::Stats-->
            <div class="d-flex flex-wrap flex-stack">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-grow-1 pe-8">
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap">
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-2 fw-bolder">0</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-bold fs-6 text-gray-400">{{ __('Unique Leads') }}</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-2 fw-bolder">0</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-bold fs-6 text-gray-400">{{ __('Gross Leads') }}</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-2 fw-bolder">0</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-bold fs-6 text-gray-400">{{ __('Gross Sales') }}</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Stats-->
        </div>
        <!--end::Info-->
    </div>
    <!--end::Details-->

    <!--begin::Navs-->
    
    <div class="d-flex overflow-auto h-55px">
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
            <li class="nav-item ">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#reconciliation">Generate Reconciliation </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#reconciliation_history">Reconciliation History</a>
            </li>
            
        </ul>
    </div>
 
    <!--begin::Navs-->
</div>
<!--end::Navbar-->
@endif
<!-- $affiliateuser[0]['id'] -->
