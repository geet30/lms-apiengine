<x-base-layout>
    @php
    //dd($provider_details[0]['service_id']);
    $setnav = 'Add';
    if(isset($provider_details) && $provider_details != ''){
    $setnav = 'Edit';
    }
    @endphp
    @section('scripts')
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/custom/js/breadcrumbs.js"></script>
    <script type="text/javascript" src="{{ URL::asset('custom/js/provider.js') }}"></script>
    @include('pages.providers.edit.life_support_js')
    <script>
        let providerName = "{{ isset($provider_details) ? ucwords($provider_details[0]['name']) : '' }}";
        let type = "{{ $action }}";
        // console.log(type);
        const breadArray = [{
                title: 'Dashboard',
                link: '/',
                active: false
            },
            {
                title: 'Providers',
                link: `{{ theme()->getPageUrl('provider/list') }}`,
                active: false
            },
        ];
        let newArr = [];
            if(type == 'update'){
                newArr = [
                        {
                            title: providerName,
                            link: '#',
                            active: false
                        },
                        {
                            title: '{{$setnav}}',
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
                        title: '{{$setnav}}',
                        link: '#',
                        active: true
                    },
                ];
                breadArray.push(newArr[0]);
            }
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();
    </script>
    @endsection
    @php
    $setnav = 'Add';
    if(isset($provider_details) && $provider_details != ''){
    $setnav = 'Edit';
    }
    //dd($provider_details);
    $account_detail = isset($provider_details) ? $provider_details[0] : '';
    $selected_service = isset($provider_details[0]['get_provider_services'][0]) ? $provider_details[0]['get_provider_services'][0] : '';
    $content_detail = isset($provider_details) ? $provider_details[0]['get_provider_content'] : '';
    $paper_bill_content = "";
    $what_happen_next = "";
    $pop_up_content = "";
    $footer_content = "";
    $state_consent = "";
    $satellite_eic = "";
    $tele_sale_eic = "";
    $acknowledgement = "";
    $state_consent_checkboxs = "";
    $tele_sale_eic_checkboxs = "";
    $acknowledgement_checkboxs = "";
    $terms_data = "";

    $types = [1,2,3,4,5,6,7,8,9];
    if($content_detail != ""){
    foreach($content_detail as $key => $value){
    if(in_array($value["type"], $types)){
    $terms_data = $content_detail[$key];
    break;
    }
    }
    foreach($content_detail as $key => $value){
    switch($value["type"]){
    case 10:
    $paper_bill_content = $content_detail[$key];//Billing Preferences
    //dd($paper_bill_content);
    break;
    case 11:
    $what_happen_next = $content_detail[$key];
    $post_submission_checkboxs = isset($what_happen_next['provider_content_checkbox']) ? $what_happen_next['provider_content_checkbox']: '';;
    break;
    case 12:
    $pop_up_content = $content_detail[$key];
    break;
    case 13:
    $footer_content = $content_detail[$key];
    break;
    case 14:
    $state_consent = $content_detail[$key];
    $state_consent_checkboxs = isset($state_consent['provider_content_checkbox']) ? $state_consent['provider_content_checkbox'] : '';
    break;
    case 15:
    $satellite_eic = $content_detail[$key];
    break;
    case 16:
    $tele_sale_eic = $content_detail[$key];
    $tele_sale_eic_checkboxs = isset($tele_sale_eic['provider_content_checkbox']) ? $tele_sale_eic['provider_content_checkbox'] : '';
    break;
    case 17:
    $acknowledgement = $content_detail[$key];
    $acknowledgement_checkboxs = isset($acknowledgement['provider_content_checkbox']) ? $acknowledgement['provider_content_checkbox']: '';;
    break;
    }
    }
    }//dd($content_detail,$terms_data);
    $detokenization_settings = isset($provider_details[0]['get_detokenization_settings'][0]) ? $provider_details[0]['get_detokenization_settings'][0] : '';//dd($detokenization_settings);

    $section_details = isset($provider_details[0]['get_provider_section']) ? $provider_details[0]['get_provider_section'] : '';
    $custom_details = isset($provider_details[0]['get_custom_field']) ? $provider_details[0]['get_custom_field'] : '';
    $connection_custom_details = isset($provider_details[0]['get_connection_custom_field']) ? $provider_details[0]['get_connection_custom_field'] : '';
    if(!empty($section_details)){
    $section_detail_update = [];  $aa = [];
    //dd($section_details);
    foreach($section_details as $key => $row){
    if($row['service_id'] == $selected_service['service_id']){
    $aa = $section_details[$key]['section_id'];
    $section_detail_update[$aa] = $section_details[$key];
    //array_push($section_detail_update,$section_details[$key]);
    }
    }
    $personal_details_section = isset($section_detail_update[1]) ? $section_detail_update[1] : '';
    $connection_details_section =isset($section_detail_update[2]) ? $section_detail_update[2] : '';
    $identification_details_section = isset($section_detail_update[3]) ? $section_detail_update[3] : '';
    $employment_details_section = isset($section_detail_update[4]) ? $section_detail_update[4] : '';
    $connection_address_section = isset($section_detail_update[5]) ? $section_detail_update[5] : '';
    $billing_and_delivery_address_section = isset($section_detail_update[6]) ? $section_detail_update[6] : '';

    }
    //dd($personal_details_section,$connection_details_section,$identification_details_section,$employment_details_section,$billing_and_delivery_address_section,$connection_address_section);

    $direct_debit_detail = isset($provider_details[0]['get_direct_debit_settings'][0]) ? $provider_details[0]['get_direct_debit_settings'][0] : '';
    $direct_debit_checkboxs = isset($provider_details[0]['get_direct_debit_settings'][0]['get_content_checkbox'][0]) ? $provider_details[0]['get_direct_debit_settings'][0]['get_content_checkbox'] : '';
    $permission = isset($provider_details[0]['get_permissions'][0]) ? $provider_details[0]['get_permissions'][0] : '';
    $outbound_links = isset($provider_details) ? $provider_details[0]['get_outbound_links'] : '';
    $contacts = isset($provider_details) ? $provider_details[0]['get_provider_contacts'] : '';
    $provider_equipments = isset($provider_details) ? $provider_details[0]['get_provider_equipments'] : [];
    $all_equipments = isset($provider_details) ? $provider_details[0]['get_all_equipments'] : [];
    if(!empty($outbound_links)){
    $new_array = array();
    foreach ($outbound_links as $key => $row)
    {
    $new_array[$key] = $row['order'];
    }
    array_multisort($new_array, SORT_ASC, $outbound_links);
    }
    if(!empty($contacts)){
    $new_array = array();
    foreach ($contacts as $key => $row)
    {
    $new_array[$key] = $row['created_at'];
    }
    array_multisort($new_array, SORT_DESC, $contacts);
    }
    //dd($outbound_links);
    @endphp
    <!--begin::Content-->
    <div class="flex-column-fluid px-0" id="kt_content">
        <!--begin::Post-->
        <div class="post" id="kt_post">
            <!--begin::Container-->
            <div id="provider_content_container">

                <!--begin::Main column-->
                <div class="d-flex menu-md-row flex-row-fluid">
                    <!--begin:::Tabs-->
                    <div class="tab-content provider-listing-box col-2 px-0 ">
                        <ul class="d-md-block nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fw-bold mb-n2 me-7 pb-5">
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="ms-md-4 nav-link text-active-primary pb-2 text-gray-600 fs-7 active" data-bs-toggle="tab" href="#account_details">Account Details</a>
                            </li>
                            <!--end:::Tab item-->
                            <?php if (isset($provider_details) && $provider_details != '') { ?>
                                <!--begin:::Tab item-->
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary px-2 text-gray-600 fs-7" data-bs-toggle="tab" href="#provider_logo">Logo</a>
                                </li>
                                @if($provider_details[0]['service_id']!=3)
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary pb-2 text-gray-600 fs-7" data-bs-toggle="tab" href="#permission">Permissions/Plan settings</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#apply_now_pop_up">Apply Now Pop Up</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#manage_section">Manage Journey Options</a>
                                </li>
                                @if($provider_details[0]['service_id']!=3)
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#billing_preference">Billing Preferences</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#direct_debit">Direct Debit/Payment Settings</a>
                                </li>
                                @if($provider_details[0]['service_id']==1)
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#statewise_consent">Statewise Consent</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#provider_acknowledgement">Acknowledgement</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-2 text-gray-600 fs-7" data-bs-toggle="tab" href="#terms_and_condition">Terms and Conditions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#outbound_links">Outbound Links</a>
                                </li>  
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#post_submission">Post Submissions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#detokenization_info">Detokenization </a>
                                </li>
                                @if($provider_details[0]['service_id']==1)
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-2 text-gray-600 fs-7" data-bs-toggle="tab" href="#life_support_codes">{{__('providers.lifesupport.tabTitle')}}</a>
                                </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary pb-2 text-gray-600 fs-7" data-bs-toggle="tab" href="#concession">Concession</a>
                                    </li>
                                @endif
                                @if($provider_details[0]['service_id']!=3)
                                    
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#manage_contacts">Manage Contacts</a>
                                    </li>
                                @endif
                                @if($provider_details[0]['service_id'] == 1)
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#tele_sale_setting">Tele Sales Setting</a>
                                </li>
                                @endif
                                @if($provider_details[0]['service_id'] != 1)
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#satellite_eic">Satellite Eic</a>
                                </li>
                                @endif
                                @if($provider_details[0]['service_id'] != 1 && $provider_details[0]['service_id'] != 3)
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary pb-1 text-gray-600 fs-7" data-bs-toggle="tab" href="#footer_content">Footer Content</a>
                                    </li>
                                @endif
                                <!--end:::Tab item-->
                            <?php  } ?>
                        </ul>
                    </div>
                    <!--end:::Tabs-->
                    <!--begin::Tab content-->
                    <div class="tab-content col-10">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="account_details" role="tab-panel">
                            @include('pages.providers.edit.account_detail')
                        </div>
                        <?php if (isset($provider_details) && $provider_details != '') { ?>
                            <div class="tab-pane fade show row gy-5 gx-xl-8" id="life_support_codes" role="tab-panel">
                                @include('pages.providers.edit.life_support_codes')
                            </div>
                            <div class="tab-pane fade show row gy-5 gx-xl-8" id="concession" role="tab-panel">
                                @include('pages.providers.edit.concession')
                            </div>
                            <div class="tab-pane fade show " id="provider_logo" role="tab-panel">
                                @include('pages.providers.edit.logo')
                            </div>
                            <div class="tab-pane fade show row gy-5 gx-xl-8" id="terms_and_condition" role="tab-panel">
                                @include('pages.providers.edit.provider_terms_and_conditions')
                            </div>
                            <div class="tab-pane fade show " id="permission" role="tab-panel">
                                @include('pages.providers.edit.permissions')
                            </div>
                            <div class="tab-pane fade show " id="billing_preference" role="tab-panel">
                                @include('pages.providers.edit.billing_preferences')
                            </div>
                            <div class="tab-pane fade show " id="post_submission" role="tab-panel">
                                @include('pages.providers.edit.post_submissions')
                            </div>
                            <div class="tab-pane fade show " id="apply_now_pop_up" role="tab-panel">
                                @include('pages.providers.edit.apply_now_pop_up')
                            </div>
                            <div class="tab-pane fade show " id="manage_contacts" role="tab-panel">
                                @include('pages.providers.edit.manage_contacts')
                            </div>
                            <div class="tab-pane fade show " id="manage_section" role="tab-panel">
                                @include('pages.providers.edit.manage_section')
                            </div>
                            <div class="tab-pane fade show row gy-5 gx-xl-8" id="direct_debit" role="tab-panel">
                                @include('pages.providers.edit.direct_debit')
                            </div>
                            <div class="tab-pane fade show " id="footer_content" role="tab-panel">
                                @include('pages.providers.edit.footer_content')
                            </div>
                            <div class="tab-pane fade show row gy-5 gx-xl-8" id="statewise_consent" role="tab-panel">
                                @include('pages.providers.edit.statewise_consent')
                            </div>
                            <div class="tab-pane fade show " id="satellite_eic" role="tab-panel">
                                @include('pages.providers.edit.provider_satellite_eic')
                            </div>
                            <div class="tab-pane fade show row gy-5 gx-xl-8" id="tele_sale_setting" role="tab-panel">
                                @include('pages.providers.edit.tele_sale_eic')
                            </div>
                            <div class="tab-pane fade show " id="outbound_links" role="tab-panel">
                                @include('pages.providers.edit.outbound_links')
                            </div>
                            <div class="tab-pane fade show row gy-5 gx-xl-8" id="provider_acknowledgement" role="tab-panel">
                                @include('pages.providers.edit.provider_acknowledgement')
                            </div>
                            <div class="tab-pane fade show row gy-5 gx-xl-8" id="detokenization_info" role="tab-panel">
                                @include('pages.providers.edit.detokenization_information')
                            </div>
                        <?php } ?>

                        <!--end::Tab pane-->
                    </div>
                    <!--end::Tab content-->

                </div>
                <!--end::Main column-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
    @section('styles')
        <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    @endsection
</x-base-layout>
