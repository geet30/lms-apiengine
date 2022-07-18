<x-base-layout>
    @if ($saleType == 'leads')
    @php $setnav = 'Leads' @endphp
    @elseif ($saleType == 'sales')
    @php $setnav = 'Sales' @endphp
    @elseif ($saleType == 'visits')
    @php $setnav = 'Visits' @endphp
    @endif
    <link rel="stylesheet" href="{{ URL::asset('custom/css/sale.css') }}">
    {{ theme()->getView('pages/leads/components/modal',array('saleDetail'=>$saleDetail,'verticalId'=>$verticalId,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions,)) }}
    <!--begin::Row-->
    {{-- <div class="row gy-12 gx-xl-12 card mt-3">
        {{ theme()->getView('pages/leads/components/view/toolbar') }}
    </div> --}}
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="w-100">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0">
                        @if($saleType == 'leads' || $saleType == 'sales')
                        {{ theme()->getView('pages/leads/components/header',array('saleDetail'=>$saleDetail,'connectionAddress'=>$connectionAddress,'affiliateLogo'=>$affiliateLogo,'saleType'=>$saleType,'verticalId'=>$verticalId,'salesQaData' => $salesQaData)) }}
                        @endif
                        <!--begin::Navs-->
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder" id="sale_list_detailss">

                            @if($saleType == 'sales' && checkPermission('sale_status_information',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#salestatus">Status</a>
                            </li>
                            @endif

                            @if($saleType == 'sales' || $saleType == 'leads')
                            @if(($saleType == 'leads' && checkPermission('lead_customer_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_customer_information',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0 {{ isset($saleType) && $saleType == 'leads' ? 'active':'' }}" data-bs-toggle="tab" href="#customer">Customer</a>
                            </li>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_customer_journey',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_customer_journey',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#journey">Journey</a>
                            </li>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_stage',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_stage',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#stage">Stage</a>
                            </li>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_plan_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_plan_information',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#plan_info">Plan</a>
                            </li>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_api_response',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_api_response',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#api_response">API</a>
                            </li>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_affiliate_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_affiliate_information',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#affiliates">Affiliates</a>
                            </li>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_qa_section',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_qa_section',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#qa_section">QA</a>
                            </li>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_identification_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_identification_information',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#identification">Identification</a>
                            </li>
                            @endif

                            @if($verticalId == 1 && (($saleType == 'leads' && checkPermission('lead_additional_info',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_additional_info',$userPermissions,$appPermissions)))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#additional_info">Additional Info</a>
                            </li>
                            @endif

                            @if(($saleType == 'leads' && checkPermission('lead_direct_debit_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_direct_debit_information',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#direct_debit">Direct Debit</a>
                            </li>
                            @endif
                            @endif
                            @if($verticalId == 3 && (($saleType == 'leads' && checkPermission('lead_addons',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_addons',$userPermissions,$appPermissions)))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#addon">Addons</a>
                            </li>
                            @endif
                            @if($saleType == 'visits')
                            @if(checkPermission('visit_stage',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0  {{ isset($saleType) && $saleType == 'visits' ? 'active':'' }}" data-bs-toggle="tab" href="#stage">Stage</a>
                            </li>
                            @endif

                            @if(checkPermission('visit_affiliate_information',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#affiliates">Affiliate Information</a>
                            </li>
                            </li>
                            @endif
                            @if(checkPermission('visit_user_analytices',$userPermissions,$appPermissions))
                            <li class="nav-item mt-2 me-6 py-5">
                                <a class="nav-link text-active-primary ms-0" data-bs-toggle="tab" href="#customer">User Analytics</a>
                            </li>
                            @endif
                            @endif
                        </ul>
                        <!--begin::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->
                {{ theme()->getView('pages/leads/components/detail/modal',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
                <!--begin::Basic info-->
                <div class="tab-content" id="heading_lead_sale_setting">
                    @if($saleType == 'sales' && checkPermission('sale_status_information',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/status',array('statuses'=>$statuses,'saleProduct'=>$saleProduct,'verticalId'=>$verticalId,'gasSaleProduct'=>$gasSaleProduct,'gasStatuses'=>$gasStatuses ,'saleDetail' => $saleDetail,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions)) }}
                    @endif
                    @if($saleType == 'sales' || $saleType == 'leads')
                    @if(($saleType == 'leads' && checkPermission('lead_customer_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_customer_information',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/customer',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'connectionAddress'=>$connectionAddress,'billingAddress'=>$billingAddress,'poBoxAddress'=>$poBoxAddress,'saleType'=>$saleType,'gasSaleDetail' => $gasSaleDetail,'customerTitles' => $customerTitles,'states'=>$states,'gasConnectionAddress'=>$gasConnectionAddress,'unitTypes'=>$unitTypes,'unitTypeCodes'=>$unitTypeCodes,'floorTypeCodes'=>$floorTypeCodes,'streetTypeCodes'=>$streetTypeCodes,'manualConnectionAddress'=>$manualConnectionAddress,'deliveryAddress'=>$deliveryAddress)) }}
                    @endif

                    @if(($saleType == 'leads' && checkPermission('lead_customer_journey',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_customer_journey',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/customerjourney',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'gasSaleDetail'=>$gasSaleDetail,'masterTariffs' => $masterTariffs,'distributors'=>$distributors,'providers'=>$providers,'lifeSupportEquipments' => $lifeSupportEquipments,'currentProvider'=>$currentProvider,'handsetData'=>$handsetData)) }}
                    @endif

                    @if(($saleType == 'leads' && checkPermission('lead_stage',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_stage',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/stage',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'gasSaleDetail'=>$gasSaleDetail,'saleType'=>$saleType,'unsubscribesData'=>$unsubscribesData)) }}
                    @endif

                    @if(($saleType == 'leads' && checkPermission('lead_plan_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_plan_information',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/plan_info',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'gasSaleDetail' => $gasSaleDetail,'contractData' => $contractData,'employmentDetails'=>$employmentDetails,'providers'=>$providers,'masterEmploymentDetails'=>$masterEmploymentDetails,'handsetData'=>$handsetData,'costType'=>$costType,'connectionDetails'=>$connectionDetails)) }}
                    @endif

                    @if(($saleType == 'leads' && checkPermission('lead_api_response',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_api_response',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/api_responses',array('apiResponses'=>$apiResponses,'saleSubmissionResponse'=>$saleSubmissionResponse,'verticalId'=>$verticalId,'tokenExLogs'=>$tokenExLogs,'smsLogs'=>$smsLogs,'sendEmailLogs'=>$sendEmailLogs)) }}
                    @endif

                    @if(($saleType == 'leads' && checkPermission('lead_affiliate_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_affiliate_information',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/affiliate',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'saleType'=>$saleType,'subAffiliate'=> $subAffiliate,'affiliateData'=>$affiliateData,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions)) }}
                    @endif

                    @if(($saleType == 'leads' && checkPermission('lead_qa_section',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_qa_section',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/qa-section',array('qaSaleCompletedBy' => $qaSaleCompletedBy,'saleDetail'=>$saleDetail,'saleQaSection' => $saleQaSectionData,'verticalId'=>$verticalId)) }}
                    @endif

                    @if(($saleType == 'leads' && checkPermission('lead_identification_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_identification_information',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/identification',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'identificationDetails'=> $identificationDetails,'states' => $allStates,'identificationTypes'=> $identificationTypes ,'countriesData'=> $countriesData,'cardColors'=> $cardColors,'referenceNumbers' => $referenceNumbers,'checkboxStatuses'=>$checkboxStatuses,'visitorDocuments'=>$visitorDocuments)) }}
                    @endif

                    @if($verticalId == 1 && (($saleType == 'leads' && checkPermission('lead_additional_info',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_additional_info',$userPermissions,$appPermissions)))
                    {{ theme()->getView('pages/leads/components/additional_info',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail , 'concessionTypes' => $concessionTypes,'saleAgentTypes' => $saleAgentTypes, 'saleOtherInfo' => $saleOtherInfo)) }}
                    @endif

                        @if(($saleType == 'leads' && checkPermission('lead_direct_debit_information',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_direct_debit_information',$userPermissions,$appPermissions))
                            {{ theme()->getView('pages/leads/components/direct_debit',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail ,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions, 'saleType' =>  $saleType,'visitorBankInfo'=>$visitorBankInfo,'visitorDebitInfo'=>$visitorDebitInfo)) }}
                        @endif
                    @endif

                    @if($verticalId == 3 && (($saleType == 'leads' && checkPermission('lead_addons',$userPermissions,$appPermissions)) || $saleType == 'sales' && checkPermission('sale_addons',$userPermissions,$appPermissions)))
                    {{ theme()->getView('pages/leads/components/addon',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
                    @endif

                    @if($saleType == 'visits')
                    @if(checkPermission('visit_stage',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/stage',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'saleType'=>$saleType)) }}
                    @endif

                    @if(checkPermission('visit_affiliate_information',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/affiliate',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'saleType'=>$saleType,'subAffiliate'=>$subAffiliate,'affiliateData'=>$affiliateData,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions)) }}
                    @endif

                    @if(checkPermission('visit_user_analytices',$userPermissions,$appPermissions))
                    {{ theme()->getView('pages/leads/components/customer',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'connectionAddress'=>$connectionAddress,'billingAddress'=>$billingAddress,'poBoxAddress'=>$poBoxAddress,'saleType'=>$saleType)) }}
                    @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
    <!--end::Row-->
</x-base-layout>
<script src="/custom/js/breadcrumbs.js"></script>
<script src="/custom/js/sale.js"></script>
<script>
    var type = '{{ $setnav }}'
    if (type == 'Sales') {
        var link = "{{url('sales/list')}}"
    } else if (type == 'Leads') {
        var link = "{{url('leads/list')}}"
    } else if (type == 'Visits') {
        var link = "{{url('visits/list')}}"
    }
    const breadArray = [{
            title: 'Dashboard',
            link: '/',
            active: false
        },
        {
            title: type,
            link: link,
            active: false
        },
        {
            title: 'View',
            link: '#',
            active: true
        },
    ];
    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();

    let changedStatus = "";
    let verticalId = "{{$verticalId}}";

    $('.change-status').change(function() {
        let saleProductId = $(this).data('product_id');
        let productType = $(this).data('product_type');
        let status = $(this).val();
        if (!status)
            return false;

        Swal.fire({
            title: "Are you sure?",
            text: "You want to change status!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function(result) {
            if (result.isConfirmed) {
                getSubStatuses(saleProductId, status, productType);
            } else
                $('.change-status').val('').change();

        });
    })

    const getSubStatuses = (saleProductId, status, productType) => {
        changedStatus = status;
        axios.post('/sales/get-sub-statuses', {
                status
            })
            .then(response => {
                setSubStatusHtml(saleProductId, response.data, productType)
            }).catch(err => {
                if (err.response.status && err.response.data.message)
                    toastr.error(err.response.data.message);
                else
                    toastr.error('Whoops! something went wrong.');
            });
    }

    const setSubStatusHtml = (saleProductId, subStatusList, productType) => {
        $('#sub_status').html(`<option value=""></option>`);
        $('#change_sale_status_form_submit_btn').data('saleproductid', saleProductId);
        $('#change_sale_status_form_submit_btn').data('productType', productType)
        subStatusList.forEach(element => {
            $('#sub_status').append(`
            <option value="${element.id}">${element.get_status.title}</option
            `);
        });
        $('#sub_status').change();
        $('#change_sale_status_pop_up').modal('show');
    }

    $("#change_sale_status_pop_up").on('hidden.bs.modal', function() {
        $('.change-status').val('').change();
    });

    $('#change_sale_status_form_submit_btn').click(function() {
        let formData = $('#change_sale_status_form').serialize();
        let id = $('#change_sale_status_form_submit_btn').data('saleproductid');
        let productType = $('#change_sale_status_form_submit_btn').data('productType');
        let leadId = $('#change_sale_status_form_submit_btn').data('lead_id');
        formData += '&status=' + changedStatus + '&saleProductId=' + id + '&saleProductType=' + productType + '&service_id=' + verticalId + '&lead_id=' + leadId;
        axios.post('/sales/change-status', formData)
            .then(response => {
                if (verticalId == 1) {
                    if (typeof response.data.header != 'undefined') {
                        var api_header = response.data.header;
                        var api_response = response.data.data;
                        var api_request = response.data.request;
                        console.log(api_request);
                        $('#api_header_here').empty().text(JSON.stringify(api_header));
                        $('#api_header_here').prepend("<b>Header data</b>: <br/>");
                        $('#api_header_here').css("margin-bottom", '20px');
                        if (api_request != "") {
                            $('#api_request_here').empty().text(JSON.stringify(api_request));
                            $('#api_request_here').prepend("<b>Request data</b>: <br/>");
                            $('#api_request_here').css("margin-bottom", '20px');
                        }
                        $('#api_response_here').empty().text(JSON.stringify(api_response));
                        $('#api_response_here').prepend("<b>Response data</b>: <br/>");
                        $('#change_sale_status_pop_up').modal('hide');
                        $('#api_response_popup').modal('show');
                        return;
                    }
                }
                window.location.href = window.location.href;
            }).catch(err => {
                if (err.response.status == 400) {
                    var api_header = err.response.data.header;
                    var api_response = err.response.data.data;
                    var api_request = err.response.data.request;
                    console.log(api_request);
                    $('#api_header_here').empty().text(JSON.stringify(api_header));
                    $('#api_header_here').prepend("<b>Header data</b>: <br/>");
                    $('#api_header_here').css("margin-bottom", '20px');
                    if (api_request != "") {
                        $('#api_request_here').empty().text(JSON.stringify(api_request));
                        $('#api_request_here').prepend("<b>Request data</b>: <br/>");
                        $('#api_request_here').css("margin-bottom", '20px');
                    }
                    $('#api_response_here').empty().text(JSON.stringify(api_response));
                    $('#api_response_here').prepend("<b>Response data</b>: <br/>");
                    $('#change_sale_status_pop_up').modal('hide');
                    $('#api_response_popup').modal('show');
                }
            });
    });

    $("#sale_list_detailss").find('li a').first().addClass("active");
    $("#heading_lead_sale_setting").children("div").first().addClass("show active");

    $('#leads_email_submit_btn').click(function(event) {
        event.preventDefault();
        let emailFrom = $('#emailFrom').val();
        let emailFromName = $('#emailFromName').val();
        let emailSubject = $('#emailSubject').val();
        let emailContent = CKEDITOR.instances.emailContent.getData();

        if (emailFrom.length > 0) {
            $('#emailFrom_error').text("");
        }
        if (emailFromName.length > 0) {
            $('#emailFromName_error').text("");
        }
        if (emailSubject.length > 0) {
            $('#emailSubject_error').text("");
        }
        if (emailContent.length > 0) {
            $('#emailContent_error').text("");
        }

        let formData = new FormData($('#leads_email_form')[0]);
        formData.append('emailContent', emailContent);
        var url = '/leads/send-email-lead'
        axios.post(url, formData)
            .then(function(response) {
                $('#leads_email_modal').modal('hide');
                if (response.data.status == false) {
                    toastr.error('Email Not Sent');
                } else {
                    toastr.success('Email Sent Successfully');
                }
            })
            .catch(function(err) {
                if (err.response.status == 422) {
                    showValidationMessages(err.response.data.errors);
                }
                if (err.response.status && err.response.data.message)
                    toastr.error('Please Check Errors');
                else
                    toastr.error('Whoops! something went wrong.');
                loaderInstance.hide();
            });

    });
    $('.sender_id_method').change(function(eveent) {
        event.preventDefault();
        let methodId = $(".sender_id_method:checked").val();
        if ((methodId == 2)) {
            $('.sender_custom_id').show();
            $('.sender_plivo').hide();
        } else if (methodId == 3) {
            $('.sender_plivo').show();
            $('.sender_custom_id').hide();
            var affiliateId = $('#userId').val();
            let formData = new FormData($('#leads_sms_form')[0]);
            formData.append('userId1', affiliateId);
            $('#plivo_number')
                .empty()
                .append('<option selected="selected" value="0">Please Select One Option</option>');
            var url = '/leads/get-plivo-data'
            axios.post(url, formData)
                .then(function(response) {
                    $.each(response.data, function(i, val) {
                        $('#plivo_number')
                            .append($("<option></option>")
                                .attr("value", val.id)
                                .text(val.alias));
                    });
                    // console.log(response.data);
                })
                .catch(function(err) {
                    if (err.response.status == 422) {
                        showValidationMessages(err.response.data.errors);
                    }
                    if (err.response.status && err.response.data.message)
                        toastr.error('Please Check Errors');
                    else
                        toastr.error('Whoops! something went wrong.');
                    loaderInstance.hide();
                });

        } else if (methodId == 1) {
            $('.sender_custom_id').hide();
            $('.sender_plivo').hide();
        }
    });

    $('#leads_sms_submit_btn').click(function(event) {
        event.preventDefault();
        let sender_id_method = $(".sender_id_method:checked").val();
        let method_content = $('#method_content').val();
        if (typeof(sender_id_method) != "undefined" && sender_id_method !== null) {
            $('#sender_id_method_error').text("");
        }
        if (method_content.length > 0) {
            $('#method_content_error').text("");
        }
        let formData = new FormData($('#leads_sms_form')[0]);

        var url = '/leads/send-sms-lead'
        axios.post(url, formData)
            .then(function(response) {
                $('#leads_sms_modal').modal('hide');
                if (response.data.status == false || response.data.response.response.success == false) {
                    toastr.error('Message Not Sent.');
                } else {
                    toastr.success('Message Sent Successfully');
                }
            })
            .catch(function(err) {
                if (err.response.status == 422) {
                    showValidationMessages(err.response.data.errors);
                }
                if (err.response.status && err.response.data.message)
                    toastr.error('Please Check Errors');
                else
                    toastr.error('Whoops! something went wrong.');
                loaderInstance.hide();
            });

    });

    $(document).ready(function() {

        var qaTest = '{{isset($salesQaData->is_locked) ? $salesQaData->is_locked :1}}';
        // Open Start Sale QA Modal:-
        if (qaTest == 0) {
            $('#sales_qa_start').modal('show');
        }
        
        // Open Stop Sale QA Modal:-
        $(document).on('click', '#salesQaStopBtn', function(event) {
            $('#sales_qa_end').modal('show');
        });

        // Redirect Page:-
        $(document).on('click', '#salesQaEND', function(event) {
            window.location.href="{{ url('/sales/list') }}";
        });

        // AXIOS for updating in Sale QA Logs and Sale Assigned QA tables:-
        $(document).on('click', '.salesQaBtn', function(event) {
            let formData = new FormData($('#sales_qa_logs')[0]);
            formData.append("verticalId", '{{$verticalId}}');
            formData.append("leadId", '{{decryptGdprData($leadId)}}');
            formData.append("userId", '{{\Auth::user()->id}}');
            formData.append("isLocked", qaTest);
            $("#sales_qa_start").modal('hide');
            var url = '/sales/save-assigned-qa-logs'
            axios.post(url, formData)
                .then(function(response) {
                    loaderInstance.hide();
                    console.log(response);
                })
                .catch(function(error) {
                    if (error.response.status == 422) {
                        toastr.error("Please Try Again Later");
                    }
                    if (error.response.status && error.response.data.message)
                        toastr.error(error.response.data.message);
                    else
                        toastr.error('Whoops! something went wrong.');

                });
        });

    });
</script>