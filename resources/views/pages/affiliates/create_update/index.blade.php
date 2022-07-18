<x-base-layout>
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="">
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                    @php $setnav = 'Add';
                        //dd($leadPopupData);
                        //dd($affiliateuser[0]['user']['id']);
                    @endphp
                    @php $diff_aff = '/affiliates/list' @endphp
                    @php $aff_head = 'Affiliates' @endphp
                    @if($type=="edit" || $opr=='edit')
                    @php $setnav = 'Edit' @endphp
                    @endif
                    @if($type == "sub-affiliates")
                    @php $aff_head = 'Sub Affiliates' @endphp
                    @php $diff_aff = '/affiliates/sub-affiliates/'.$userId @endphp
                    @endif
                    @if($type=="edit" || $opr=='edit')
                    @php
                    $records=$affiliateuser[0]['user'];
                    $records['status']=$affiliateuser[0]['status'];
                    $records['address']=$affiliateuser[0]['getuseradress']['address'];

                    $records['logo']=$affiliateuser[0]['logo'];
                    @endphp
                    <div class="card">
                        @include("pages.affiliates.components.affiliatedetails")

                    </div>
                    @endif
                    <div class="tab-content">
                        <div class="tab-pane fade show @if($type=='create' || $opr=='create' || $type=='edit' || $opr=='edit') active @endif" id="basic_details" role="tab-panel">
                            @include("pages.affiliates.create_update.basic_information")
                        </div>
                        <!--begin::Tab pane-->
                        @if($type=="edit" || $opr=='edit')
                        <div class="tab-pane card fade show" id="affiliate_verticals" role="tab-panel">
                            @include("pages.affiliates.create_update.affiliate_verticals")
                            @include("pages.affiliates.create_update.paramtermodal")
                            @include("pages.affiliates.create_update.plan_type_modal")
                        </div>
                        @endif
                        <div class="tab-pane fade show " id="additional_feature" role="tab-panel">
                            @include("pages.affiliates.create_update.additional_feature")
                        </div>
                        <div class="tab-pane fade show " id="social_links" role="tab-panel">
                            @include("pages.affiliates.create_update.social_links")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/custom/js/affiliates.js"></script>
    <script src="/common/plugins/custom/flatpickr/flatpickr.bundle.js"></script>
    <script src="/custom/js/loader.js"></script>
    <script>
        var type = '{{$setnav}}';
        var diff_aff = '{{$diff_aff}}';
        var aff_head = '{{$aff_head}}';
        var info = '{{request()->segment(2)}}';
        
        const breadArray = [{
            title: 'Dashboard',
            link: '/',
            active: false
            },
        ];

        if(info == 'sub-affiliates'){
            breadArray.push(
                {
                    title: 'Affiliates',
                    link: '/affiliates/list',
                    active: false
                },
            );
        }

        breadArray.push(
            {
                title: aff_head,
                link: diff_aff,
                active: false
            },
            {
                title: type,
                link: '#',
                active: true
            },
        );
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();
    </script>
    @include("pages.affiliates.create_update.verticals_js")
    @endsection
</x-base-layout>