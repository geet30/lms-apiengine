<x-base-layout> 
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0">
                        <?php
                            $cancelButtonUrl = "/provider/plans/broadband/".encryptGdprData($providerUser[0]['user_id']);
                        ?>
                        {{ theme()->getView('pages/plans/common/header',['selectedProvider' => $selectedProvider]) }}
                        {{ theme()->getView('pages/providers/components/modal') }}
                        <!--begin::Navs-->
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                            <li class="nav-item  mt-2">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#basic_details">{{__('plans/broadband.plan_detail_tab')}}  </a>
                            </li>
                            
                            @if($type == 'edit')
                
                                <li class="nav-item mt-2">
                                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#special_offer">{{__('plans/broadband.special_offer_tab')}} </a>
                                </li> 
                                <li class="nav-item mt-2">
                                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#plan_fees">{{__('plans/broadband.fee_tab')}} </a>
                                </li> 
                                <li class="nav-item mt-2">
                                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#included_addons">
                                    {{__('plans/broadband.included_addon_tab')}} 
                                    </a>
                                </li>
                                <li class="nav-item mt-2">
                                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#addons">
                                    {{__('plans/broadband.addon_tab')}} 
                                    </a>
                                </li> 

                                <li class="nav-item mt-2">
                                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#terms">
                                    {{__('plans/broadband.t&c_tab')}} 
                                    </a>
                                </li>
                                <li class="nav-item mt-2">
                                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#acknowlegement">
                                    {{__('plans/broadband.ask_concent_tab')}} 
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <!--begin::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->
                <!--begin::Basic info-->
                <div class="tab-content">
                    {{ theme()->getView('pages/plans/broadband/create_update/basic_information',['type' => $type,'plan' => $plan,'connectionTypes' => $connectionTypes ,'technologyTypes' => $technologyTypes ,'assignedTechnolgy' => $assignedTechnolgy ,'contracts' => $contracts,'costTypes' => $costTypes, 'dataLimit' => $dataLimit ,'providerUser' =>$providerUser[0] ,'cancelButtonUrl' => $cancelButtonUrl,'dataUnit' => $dataUnit ]) }}

                    @if($type == 'edit')

                        {{ theme()->getView('pages/plans/broadband/create_update/offer',['plan' => $plan ,'costTypes' => $costTypes ,'cancelButtonUrl' => $cancelButtonUrl]) }}

                        {{ theme()->getView('pages/plans/broadband/create_update/fees',['plan' => $plan ,'costTypes' => $costTypes ,'feeTypes' => $feeTypes ,'cancelButtonUrl' => $cancelButtonUrl]) }}
                        
                        {{ theme()->getView('pages/plans/broadband/create_update/included_addon', ['costTypes' => $costTypes ,'phoneHomeConnection' => $phoneHomeConnection, 'additionalAddons' => $additionalAddons , 'broadbandModem' => $broadbandModem ,'plan' => $plan ,'defaultIncludedAddon' => $defaultIncludedAddon ,'cancelButtonUrl' => $cancelButtonUrl]) }}

                        {{ theme()->getView('pages/plans/broadband/create_update/addons' , ['costTypes' => $costTypes,'plan' => $plan ,'cancelButtonUrl' => $cancelButtonUrl ,'otherAddons' => $otherAddons]) }}

                        {{ theme()->getView('pages/plans/broadband/create_update/terms', ['plan' => $plan]) }}

                        {{ theme()->getView('pages/plans/broadband/create_update/acknowlegement' ,['plan' => $plan ,'cancelButtonUrl' => $cancelButtonUrl]) }}

                        {{ theme()->getView('pages/plans/broadband/create_update/modal',['plan' => $plan ]) }}
                    @endif
                </div> 
            </div>

        </div>
    </div>

    @section('scripts')
        <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
        <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script> 
        <script src="/custom/js/breadcrumbs.js"></script> 
        <script>
            var current_head = "{{ ucwords($selectedProvider->name) }}";
            let type = "{{ $type }}";
            const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: 'Providers',
                    link: '/provider/list',
                    active: false
                },
                {
                    title: current_head,
                    link: "/provider/plans/broadband/{{encryptGdprData($selectedProvider->user_id)}}",
                    active: false
                },
                {
                    title: 'Broadband Plans',
                    link: "/provider/plans/broadband/{{encryptGdprData($selectedProvider->user_id)}}",
                    active: false
               },
            ];
            let newArr = [];
            if(type == 'edit'){
                newArr = [
                        {
                            title: "{{ isset($plan) ? ucwords($plan->name) : '' }}",
                            link: '#',
                            active: false
                        },
                        {
                            title: "{{ucwords($type)}}",
                            link: '#',
                            active: true
                        },
                    ];
                    for(i=0; i < newArr.length ; i++){
                        breadArray.push(newArr[i]);
                    }
            }else{
                newArr = [
                    {
                        title: "{{ucwords($type)}}",
                        link: '#',
                        active: true
                    },
                ];
                breadArray.push(newArr[0]);
            }
            const breadInstance = new BreadCrumbs(breadArray,'Plans');
            breadInstance.init();

            let feeTypes = <?php echo json_encode($feeTypes->toArray()) ?>;
            let selectedFeeTypes = <?php echo json_encode(isset($plan->planFees)?array_column($plan->planFees->toArray(),'fee_id'): []) ?>;
            let costTypes = <?php echo json_encode($costTypes->toArray()) ?>; 
            let connectionChangeTitle = "{{__('plans/broadband.connection_change_title')}}";
            let connectionChangeText = "{{__('plans/broadband.connection_change_text')}}";
            let techTypeChangeTitle = "{{__('plans/broadband.tech_type_change_title')}}";
            let techTypeChangeText = "{{__('plans/broadband.tech_type_change_text')}}";
            let deleteCheckboxTitle = "{{__('plans/broadband.delete_checkbox_title')}}";
            let deleteCheckboxText = "{{__('plans/broadband.delete_checkbox_text')}}";
            
            let feesTypePlace = "{{__('plans/broadband.fees.placeholder')}}";
            let costTypePlace = "{{__('plans/broadband.fees_cost_type.placeholder')}}";
            let amountPlace = "{{__('plans/broadband.fees_amount.placeholder')}}";
            let removeFeePlace = "{{__('plans/broadband.fees_remove')}}"; 

            let addonCostTypePlace = "{{__('plans/broadband.addon_cost_type.placeholder')}}";
            let addonCostPlace= "{{__('plans/broadband.addon_cost.placeholder')}}";

            let noCheckboxPlace = "{{__('plans/broadband.no_checkbox_found')}}";
            let checkboxEditPlace = "{{__('plans/broadband.edit')}}";
            let checkboxDeletePlace = "{{__('plans/broadband.delete')}}";
            let checkboxActionPlace = "{{__('plans/broadband.action')}}";

            let feesAddHead = "{{__('plans/broadband.fees_add')}}";
            let feesEditHead = "{{__('plans/broadband.fees_edit')}}";
            let deleteFeesTitle = "{{__('plans/broadband.delete_fees_title')}}";
            let deleteFeesText = "{{__('plans/broadband.delete_fees_text')}}";
        </script>
        <script src="/custom/js/broadband-plans.js"></script>
        <script src="/custom/js/plans/common-fee.js"></script> 
        @endsection
</x-base-layout>