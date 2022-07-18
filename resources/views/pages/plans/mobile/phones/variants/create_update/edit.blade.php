<x-base-layout> 
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0"> 
                        {{ theme()->getView('pages/plans/common/header') }} 
                    </div>
                </div>
                <!--end::Navbar-->
                <!--begin::Basic info-->
                <div class="tab-content">
                <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{__('plans/mobile.add_variant_detail_heading')}} </h3>
                    </div>
                    <!--end::Card title-->
                    </div>
                        <!--begin::Content-->
                        <div id="kt_account_plan_info" class="collapse show">
                            <!--begin::Form-->
                            <form id="edit_variant_form" class="form">
                                <!--begin::Card body-->
                                <input type='hidden' name='plan_id' value="{{$planId}}"> 
                                <input type='hidden' name='plan_variant_id' value="{{$variantId}}"> 
                                <div class="card-body border-top p-9">
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/mobile.own_lease_handset_checkbox_label')}}</label>
                                        <!--end::Label-->
                                        <!--begin::Col--> 
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                                <!--begin::Options-->
                                                <div class="d-flex align-items-center mt-3"> 
                                                    <div class="col-lg-4"> 
                                                        <div class="row mb-2 mt-3"> 
                                                            <div class="col-lg-1 fv-row">
                                                                <label class="form-check form-check-inline form-check-solid me-5">
                                                                    <input class="form-check-input other-modem-checkbox-display own_main_checkbox" name="own" type="checkbox" value="1" {{isset($variantData) && $variantData->own == 1 ?'checked' :''}}>
                                                                    {{__('plans/mobile.own_label')}}</label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <!--begin::Option-->
                                                    <div class="col-lg-4"> 
                                                        <div class="row mb-2 mt-3"> 
                                                            <div class="col-lg-1 fv-row connection_allow">
                                                                <label class="form-check form-check-inline form-check-solid me-5">
                                                                    <input class="form-check-input other-modem-checkbox-display lease_main_checkbox" name="lease" type="checkbox" value="1" {{isset($variantData) && $variantData->lease == 1 ?'checked' :''}}>
                                                                    {{__('plans/mobile.lease_label')}}</label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                        </div>
                                    </div>

                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/mobile.own_handset_cost.label')}}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="own_cost" placeholder="{{__('plans/mobile.own_handset_cost.placeholder')}}" class="form-control form-control-lg form-control-solid own_fields" value="{{isset($variantData) ?$variantData->own_cost :''}}" autocomplete="off" />
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                     
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('plans/mobile.lease_handset_cost.label')}}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" placeholder="{{__('plans/mobile.lease_handset_cost.placeholder')}}" name="lease_cost" class="form-control form-control-lg form-control-solid lease_fields" value="{{isset($variantData) ?$variantData->lease_cost :''}}" autocomplete="off" />
                                            <span class="error text-danger"></span>
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row mb-6 border-bottom"> 
                                        <label class="col-lg-4 col-form-label fw-bold fs-6"><b>
                                        {{__('plans/mobile.own_handset_contract_terms')}}
                                        </b></label> 
                                    </div>

                                    @foreach($contracts as $contract)
                                    <?php
                                        $own_contract_cost = '';
                                        $own_contract_check = '';
                                        $own_contract_desc = '';
                                        foreach ($variant_own_contracts as $key => $value) {
                                            if($value['contract_id']==$contract->id){
                                                $own_contract_cost = $value['contract_cost'];
                                                $own_contract_check = 'checked';
                                                $own_contract_desc = $value['description'];
                                            }
                                        }
                                    ?>
                                    <div class="row mb-2 mt-3 pt-2 pb-2 border"> 
                                        <div class="col-lg-4"> 
                                            <div class="row mb-2 mt-3"> 
                                                <div class="col-lg-1 fv-row connection_allow">
                                                    <label class="form-check form-check-inline form-check-solid me-5">
                                                        <input class="form-check-input other-modem-checkbox-display own_fields" name="checkbox_own_contract[{{$contract->id}}]" type="checkbox" value="{{$contract->id}}" {{$own_contract_check}}>
                                                    </label>
                                                </div>
                                                <label class="col-lg-6 fw-bold fs-6"> {{ $contract->validity . " Month(s)" }}</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"> 
                                            <input type="text" class="form-control own_fields"  name="contract_own_cost[{{$contract->id}}]" placeholder="Enter Own a Phone Contract Cost" value="{{$own_contract_cost}}" autocomplete="off" >
                                            <span class="error text-danger own_contract_error{{$contract->id}}"></span>
                                        </div>  
                                        <div class="col-lg-4"> 
                                            <textarea class="form-control own_fields" cols="3" name="contract_own_desc[{{$contract->id}}]" placeholder="Enter Contract Description" >{{$own_contract_desc}}</textarea>
                                        </div>   
                                    </div>
                                    @endforeach 

                                    <div class="row mb-6 border-bottom"> 
                                        <label class="col-lg-4 col-form-label fw-bold fs-6"><b>
                                        {{__('plans/mobile.lease_handset_contract_terms')}}
                                        </b></label> 
                                    </div>
                                        @foreach($contracts as $contract)
                                            <?php
                                                $lease_contract_cost = '';
                                                $lease_contract_check = '';
                                                $lease_contract_desc = '';
                                                foreach ($variant_lease_contracts as $key => $value) {
                                                    if($value['contract_id']==$contract->id){
                                                        $lease_contract_cost = $value['contract_cost'];
                                                        $lease_contract_check = 'checked';
                                                        $lease_contract_desc = $value['description'];
                                                    }
                                                }
                                            ?>
                                        <div class="row mb-2 mt-3  border pt-2 pb-2"> 
                                            <div class="col-lg-4"> 
                                                <div class="row mb-2 mt-3"> 
                                                    <div class="col-lg-1 fv-row connection_allow">
                                                        <label class="form-check form-check-inline form-check-solid me-5">
                                                            <input class="form-check-input other-modem-checkbox-display lease_fields" name="checkbox_lease_contract[{{$contract->id}}]" type="checkbox" value="{{$contract->id}}"  {{$lease_contract_check}}>
                                                        </label>
                                                    </div>
                                                    <label class="col-lg-6 fw-bold fs-6">{{ $contract->validity . " Month(s)" }}</label>
                                                </div>
                                            </div> 

                                            <div class="col-lg-4"> 
                                                <input type="text" class="form-control lease_fields"  name="contract_lease_cost[{{$contract->id}}]" placeholder="Enter Own a Phone Contract Cost" value="{{$lease_contract_cost}}" autocomplete="off">
                                                <span class="error text-danger lease_contract_error{{$contract->id}}"></span>
                                            </div>  
                                            
                                            <div class="col-lg-4"> 
                                                <textarea class="form-control lease_fields" cols="3" name="contract_lease_desc[{{$contract->id}}]" placeholder="Enter Contract Description">{{$lease_contract_desc}}</textarea>
                                            </div>   
                                        </div>
                                        @endforeach 
                                </div>
                                <!--end::Card body-->
                                <!--begin::Actions-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ theme()->getPageUrl('provider/plans/mobile/'.encryptGdprData($providerId).'/manage-phone/'.encryptGdprData($planId).'/manage-phone-variant/'.encryptGdprData($handsetId)) }}" class="btn btn-light btn-active-light-primary me-2" >{{__('plans/broadband.discard_button')}}</a>
                                    <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                </div> 
            </div>

        </div>
    </div>

    @section('scripts')
        <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
        <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script> 
        <script src="/custom/js/breadcrumbs.js"></script> 
        <script>
             var type = 'Edit Variant';
            var diff_aff = '/provider/list';
            var aff_head = 'Providers';
            const breadArray = [
                {
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: aff_head,
                    link: diff_aff,
                    active: false
                },
                {
                    title: 'Mobile Plans',
                    link: "{{ theme()->getPageUrl('provider/plans/mobile/'.encryptGdprData($providerId)) }}",
                    active: false
                },
                {
                    title: 'Manage Phones',
                    link: "{{ theme()->getPageUrl('provider/plans/mobile/'.encryptGdprData($providerId).'/manage-phone/'.encryptGdprData($planId)) }}",
                    active: false
                },
                {
                    title: 'Manage Variants',
                    link: "{{ theme()->getPageUrl('provider/plans/mobile/'.encryptGdprData($providerId).'/manage-phone/'.encryptGdprData($planId).'/manage-phone-variant/'.encryptGdprData($handsetId)) }}",
                    active: false
                },
                {
                    title: type,
                    link: '#',
                    active: true
                },  
            ];
            const breadInstance = new BreadCrumbs(breadArray,'Plans');
            breadInstance.init();

            $(document).on('submit','#edit_variant_form',function(event)
            {
                loaderInstance.show();
                $('.error').html('');
                let formData = new FormData(this);
                var url = '/provider/plans/mobile/plan-handset-variant/details';
                event.preventDefault();
                axios.post(url,formData)
                .then(function (response) {  
                    loaderInstance.hide();
                    toastr.success(response.data.message);
                })
                .catch(function (error) { 
                    loaderInstance.hide(); 
                    if(error.response.status == 422) {
                        errors = error.response.data.errors;
                        $.each(errors, function(key, value) {  
                            $('[name="'+key+'"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();  
                            var contractId = key.substr(key.indexOf(".")+1);
                            var type = key.substr(0,key.indexOf(".")); 
                            if(type == 'contract_own_cost')
                            {
                                $('.own_contract_error'+contractId).empty().addClass('text-danger').text(value).finish().fadeIn();  
                            }
                            else if(type == 'contract_lease_cost')
                            {
                                $('.lease_contract_error'+contractId).empty().addClass('text-danger').text(value).finish().fadeIn();  
                            } 
                        });
                        $('html, body').animate({
                            scrollTop: ($('.error.text-danger').offset().top - 300)
                        }, 1000);
                    }
                    else if(error.response.status == 400) { 
                        toastr.error(error.response);
                    }
                });
            });
            $(".own_fields").prop('disabled', false);
            if (!$('.own_main_checkbox').is(":checked")) { 
                $(".own_fields").prop('disabled', true);
            } 

            $(".lease_fields").prop('disabled', false);
            if (!$('.lease_main_checkbox').is(":checked")) { 
                $(".lease_fields").prop('disabled', true);
            } 

            $(document).on('change','.own_main_checkbox',function(event)
            {
                $(".own_fields").prop('disabled', false);
                if (!$(this).is(":checked")) { 
                    $(".own_fields").prop('disabled', true);
                } 
            });

            $(document).on('change','.lease_main_checkbox',function(event)
            {
                $(".lease_fields").prop('disabled', false);
                if (!$(this).is(":checked")) { 
                    $(".lease_fields").prop('disabled', true);
                } 
            });
             
        </script>
        @endsection
</x-base-layout>