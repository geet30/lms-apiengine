<script>
    let feesAddHead = "{{__('plans/broadband.fees_add')}}";
    let feesEditHead = "{{__('plans/broadband.fees_edit')}}";
    let deleteFeesTitle = "{{__('plans/broadband.delete_fees_title')}}";
    let deleteFeesText = "{{__('plans/broadband.delete_fees_text')}}";

    let planId = "{{isset($plan) ? encryptGdprData($plan->id) : ''}}";
    let planRefId = null;
    let planTermId = null;
    let otherInfoCounter = 1;

    let eleEditors = document.getElementsByClassName('common_other_info_desc');

    let feeTypes = <?php echo json_encode($feeTypes->toArray()) ?>;
    let selectedFeeTypes = <?php echo json_encode(isset($plan->planFees) ? array_column($plan->planFees->toArray(), 'fee_id') : []) ?>;
    let costTypes = <?php echo json_encode($costTypes) ?>;
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
    let addonCostPlace = "{{__('plans/broadband.addon_cost.placeholder')}}";

    let noCheckboxPlace = "{{__('plans/broadband.no_checkbox_found')}}";
    let checkboxEditPlace = "{{__('plans/broadband.edit')}}";
    let checkboxDeletePlace = "{{__('plans/broadband.delete')}}";
    let checkboxActionPlace = "{{__('plans/broadband.action')}}";

    let saveUrl = "{{url('provider/plans/mobile/'.$providerId.'/save/')}}";
    var current_head = "{{ isset($selectedProvider) ? ucwords($selectedProvider->name) : '' }}";

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
            link: "/provider/plans/mobile/{{$providerId}}",
            active: false
        },
        {
            title: 'Mobile Plans',
            link: '/provider/plans/mobile/{{$providerId}}',
            active: false
        },
    ];

    let newArr = [];
    if (planId) {
        newArr = [{
                title: "{{ isset($plan) ? ucwords($plan->name) : '' }}",
                link: '#',
                active: false
            },
            {
                title: planId == '' ? 'Add' : 'Edit',
                link: '#',
                active: true
            },
        ];
        for(i = 0; i < newArr.length; i++) {
            breadArray.push(newArr[i]);
        }
    }else{
        newArr = [{
            title: planId == '' ? 'Add' : 'Edit',
            link: '#',
            active: true
        }, 
    ];
        breadArray.push(newArr[0]);
    }

    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();

    for (let index = 0; index < eleEditors.length; index++) {
        let nameOfElement = eleEditors[index].getAttribute('id');
        const element = eleEditors[index];
        otherInfoCounter++;

        CKEDITOR.replace(element, {
            height: 260,
            width: 700,
            removeButtons: 'PasteFromWord'
            });
        // ClassicEditor.create(element)
        //     .then(newEditor => {
        //         editorsArr[nameOfElement] = newEditor;
        //     }).catch(error => {
        //         console.error(error);
        //     });


    }

    if(planId){
        CKEDITOR.replace('term_content', {
        height: 260,
        width: 700,
        removeButtons: 'PasteFromWord'
    });
    
    }
    $(document).on('click', '.delete-row', function() {
        let row = $(this).data('row');
        CKEDITOR.instances['other_info_desc_' + row].destroy();
        $('#row-' + row).remove();

    });
    $('#addButton').click(function() {
        otherInfoCounter++;
        $('.dynamicForm').append(`
            <div class="row dynamicRow" id="row-${otherInfoCounter}" data-row="${otherInfoCounter}">
                <div class="col-md-3">
                    <label class="form-label">{{ __ ('mobile.formPage.other_info.other_info_field.label')}}</label>
                    <input type="text" name="other_info_field[]" id="other_info_field_${otherInfoCounter}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __ ('mobile.formPage.other_info.other_info_field.placeHolder')}}" value="" />
                </div>
                <div class="col-md-7">
                    <label class="form-label">{{ __ ('mobile.formPage.other_info.other_info_desc.label')}}</label>
                    <textarea name="other_info_desc[]" id="other_info_desc_${otherInfoCounter}" class="form-control form-control-lg form-control-solid common_other_info_desc ckeditors" placeholder="{{ __ ('mobile.formPage.other_info.other_info_desc.placeHolder')}}"></textarea>
                </div>
                <div class="col-md-2">
                    <a href="javascript:;" class="btn btn-sm btn-light-danger mt-3 mt-md-8 delete-row" data-row="${otherInfoCounter}">
                        <i class="la la-trash-o"></i>{{ __ ('mobile.formPage.other_info.deleteButton')}}
                    </a>
                </div>
            </div>
        `);
        // ClassicEditor
        //     .create($('#other_info_desc_' + otherInfoCounter)[0])
        //     .then(editorED => {

        //         editorsArr['other_info_desc_' + otherInfoCounter] = editorED;
        //     })
        //     .catch(error => {
        //         console.log(error);
        //     });

        CKEDITOR.replace('other_info_desc_' + otherInfoCounter, {
            height: 260,
            width: 700,
            removeButtons: 'PasteFromWord'
            });
        

    })
    $("#activation_date_time, #deactivation_date_time").daterangepicker({
        autoApply: true,
        autoUpdateInput: false,
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: true,
        minDate: "{{isset($plan) ? '0' : now()}}",
        locale: {
            format: 'YYYY-MM-DD hh:mm:ss'
        },

    });

    $('#activation_date_time,#deactivation_date_time').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('[name=connection_type],[name=business_size],[name=bdm_available]').change(function() {
        let connectionType = $('[name=connection_type]').val();
        let businessSize = $('[name=business_size]').val();
        let bdmAvailable = $('[name=bdm_available]:checked').val();
        $('.business,#business_size_box,#bdm_available_box,#bdm_contact_number_box,#bdm_details_box').hide()
        $('.personal').fadeIn()
        if (connectionType.length && connectionType != 1) {
            $('.business,#business_size_box').fadeIn()
            if (businessSize == 2) {
                $('#bdm_available_box').fadeIn();
                if (bdmAvailable == 1) {
                    $('#bdm_contact_number_box,#bdm_details_box').fadeIn();
                    $('.personal').hide()
                }
            }
        }
    });
    $('[name=connection_type]').change();


    $('[name=linktype]').click(function() {
        $('#url_box,#file_box').hide();
        if ($(this).val() == 2)
            $('#file_box').fadeIn();
        else
            $('#url_box').fadeIn();
    });


    $(document).on('click', '.edit-plan-term', function() {
        $('#plan_term_condition_form [name=term_title_content]').val($(this).data('title'));
        CKEDITOR.instances.term_content.setData($(this).data('desc'));
        planTermId = $(this).data('id');
        $('[name=s_no]').removeAttr('disabled');
        $('#cke_term_content').css('width','100%');
        $('#terms-conditions-modal').modal('show');
    });

    $('#terms-conditions-modal').on('hidden.bs.modal', function() {
        $('#plan_term_condition_form')[0].reset();
        $('#plan_term_condition_form .field-error').text('');
        planTermId = null;

    })


    $(document).on('click', '.edit-plan-ref', function() {
        $('#current_s_no, #plan_reference_form [name=s_no]').val($(this).data('sno'));
        $('#plan_reference_form [name=s_no]').trigger('change');
        $('#plan_reference_form [name=title]').val($(this).data('title'));
        $('#plan_reference_form [name=url]').val($(this).data('url'));
        planRefId = $(this).data('id');
        $('[name=s_no]').removeAttr('disabled');
        $('[name=s_no] option:last').attr('disabled', true);

        $('#plan-reference-modal').modal('show');
    });

    $(document).on('click', '.delete-plan-ref', function() {
        let refId = $(this).data('id');
        let url = "{{url('provider/plans/mobile/'.$providerId)}}/" + planId + '/reference/' + refId;
        // let url = "{{url('provider/plans/mobile/'.$providerId.'/'.$providerId.'/reference')}}";

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function(result) {
            if (result.isConfirmed) {
                axios.delete(url)
                    .then(response => {
                        toastr.success('Delete successfully.')
                        planRefList(response.data.planRefList)
                        KTMenu.createInstances();
                    }).catch(err => {
                        if (err.response.status && err.response.data.message)
                            toastr.error(err.response.data.message);
                        else
                            toastr.error('Whoops! something went wrong.');
                    });
            }
        });

    });

    $('#plan-reference-modal').on('hidden.bs.modal', function() {
        $('#plan_reference_form')[0].reset();
        $('#current_s_no').val('');
        $('[name=linktype]:checked').click();
        $('#plan_reference_form .field-error').text('');
        planRefId = null;
        $('[name=s_no]').attr('disabled', true);
        $('[name=s_no] option:last').removeAttr('disabled');
        $('#plan_reference_form [name=s_no]').trigger('change');
    })

    $('.submit_btn').click(function() {
        let formId = $(this).data('form');
        let formTitle = $(this).data('title');
        if(formId=='' || formId==null) {
            toastr.error('Whoops! something went wrong.');
            return false;
        }
        var is_checkbox_valid = 0;
        if(($('#plan_data_1').is(':checked'))){
            let planData = $("#plan_data").val('99999');
            $('[name=plan_data_unit] :selected').text('TB');
            is_checkbox_valid = 1;
        }
        let data = new FormData($('#' + formId)[0]);
        let url = "{{url('provider/plans/mobile/'.$providerId.'/save')}}";
        data.append('form', formId);
        data.append('formTitle', formTitle);
        if (planId) {
            
            data.append('planId', planId);
            data.append('_method', 'put');
            if(is_checkbox_valid == 1){
            data.append('plan_data','99999');
            data.append('plan_data_unit','3');
            }
            url += '/' + planId;
        }
        if(($('#plan_data_1').is(':checked'))){
            let planData = $("#plan_data").val('99999');
            $('[name=plan_data_unit] :selected').text('TB');
            is_checkbox_valid = 1;
        }
        
        switch (formId) {
            case 'plan_basic_details_form':
                data.set('inclusion', CKEDITOR.instances.inclusion.getData());
                data.set('network_host_information', CKEDITOR.instances.network_host_information.getData());
                data.set('bdm_details', CKEDITOR.instances.bdm_details.getData());
                break;
            case 'plan_special_offer_form':
                data.set('special_offer_description', CKEDITOR.instances.special_offer_description.getData());
                break;
            case 'plan_national_inclusion_form':
                data.set('national_special_features', CKEDITOR.instances.national_special_features.getData());
                data.set('national_additonal_info', CKEDITOR.instances.national_additonal_info.getData());
                break;
            case 'plan_information_form':
                data.set('details', CKEDITOR.instances.details.getData());
                data.set('amazing_extra_facilities', CKEDITOR.instances.amazing_extra_facilities.getData());
                break;
            case 'plan_international_inclusion_form':
                data.set('international_roaming', CKEDITOR.instances.international_roaming.getData());
                data.set('international_additonal_info', CKEDITOR.instances.international_additonal_info.getData());
                break;
            case 'plan_roaming_inclusion_form':
                data.set('roaming_internet_data', CKEDITOR.instances.roaming_internet_data.getData());
                data.set('roaming_additonal_info', CKEDITOR.instances.roaming_additonal_info.getData());
                break;
            case 'plan_fees_form':
                data.set('other_fee_charges', CKEDITOR.instances.other_fee_charges.getData());
                break;
            case 'plan_term_condition_form':
                data.set('term_content', CKEDITOR.instances.term_content.getData());
                data.set('planTermId', planTermId);
                break;
            case 'plan_other_info_form':
                data.delete('other_info_desc[]');
                $('.dynamicRow').each(function() {
                    let row = $(this).data('row');
                    let title = $('#other_info_field_' + row).val();
                    // let desc = editorsArr['other_info_desc_' + row].getData();
                    let desc = CKEDITOR.instances['other_info_desc_' + row].getData();
                    
                    data.append('other_info_desc[]', desc);
                })
                break;
            case 'plan_reference_form':
                if (planRefId)
                    data.set('planRefId', planRefId);
                data.set('s_no', $('#plan_reference_form [name=s_no]').val());
                break;
        }
        $('.errors').text('').removeClass('field-error').hide();
        if (validateForm(formId))
            submitForm(url, data, formId);
    });

    // 20-05-2022 Override Billing Preferences CheckBox
    $('[name=billing_preference_checkbox]').change(function() {
        var billing_preference;
        var new_array = new Array();
        $('[name=billing_preference_checkbox]:checked').each(function() {
            new_array.push($(this).val());
        });
        if (new_array.length == 2) {
            billing_preference = 3;
        }
        if (new_array == 1) {
            billing_preference = 1;
        }
        if (new_array == 2) {
            billing_preference = 2;
        }
        if (new_array == 0) {
            billing_preference = 0;
        }
        $('#billing_preference_value').val(billing_preference);
    });
    // 20-05-2022


    // Data Per Month Limited OR Unlimited 30-05-2022
    if(($('#plan_data_1').is(':checked'))){    
            $("#plan_data").attr('disabled', true);
            $("[name=plan_data_unit]").attr('disabled', true);
            $("#plan_data").val('Unlimited');
            $('#plan_data,#plan_data_unit').css('cursor','not-allowed');
        }
    $("#plan_data_1").change(function() {
        if(($(this).is(':checked'))){    
            $("#plan_data").attr('disabled', true);
            $("[name=plan_data_unit]").attr('disabled', true);
            $("#plan_data").val('Unlimited');
            $('#plan_data,#plan_data_unit').css('cursor','not-allowed');
            // $('#plan_data_unit').append('<option value="4" selected="selected">Unlimited</option>');
        }
        else{
            $("#plan_data").attr("placeholder", "e.g. 100");
            $("#plan_data").val('');
            $("#plan_data").removeAttr('disabled');
            $("[name=plan_data_unit]").removeAttr('disabled');
            $('#plan_data,#plan_data_unit').css('cursor','');

        }
    });
    // Data Per Month Limited OR Unlimited 30-05-2022
    
    const submitForm = (url, data, form) => {
        loaderInstance.show();
        axios.post(url, data)
            .then(response => {
                toastr.success('Details saved successfully.')
                if (form == 'plan_term_condition_form') {
                    planTermConditionList(response.data.plansTermList)
                    KTMenu.createInstances();
                }
                if (form == 'plan_reference_form') {
                    planRefList(response.data.planRefList);
                    KTMenu.createInstances();
                }
                if (response.data.listingUrl) {
                    location.href = response.data.listingUrl;
                }
                $('#plan-reference-modal,#terms-conditions-modal').modal('hide');
                loaderInstance.hide();
            }).catch(err => {
                console.log(err);
                if (err.response.status == 422) {
                    showValidationMessages(err.response.data.errors);
                }
                if (err.response.status && err.response.data.message)
                    toastr.error(err.response.data.message);
                else
                    toastr.error('Whoops! something went wrong.');

                loaderInstance.hide();
            });
    }

    const validateForm = (form) => {
        let errors = {};
        let isError = false;
        switch (form) {
            case 'plan_basic_details_form':
                let name = $('[name=name]').val();
                if (name == '') {
                    errors['name'] = "{{ __ ('mobile.formPage.basicDetails.name.errors.required')}}";
                    isError = true;
                }
                let connection_type = $('[name=connection_type]').val();
                if (connection_type == '') {
                    errors['connection_type'] = "{{ __ ('mobile.formPage.basicDetails.connection_type.errors.required')}}";
                    isError = true;
                }
                let plan_type = $('[name=plan_type]').val();
                if (plan_type == '') {
                    errors['plan_type'] = "{{ __ ('mobile.formPage.basicDetails.plan_type.errors.required')}}";
                    isError = true;
                }
                let costType = $('[name=cost_type_id]').val();
                if (cost_type_id == '') {
                    errors['cost_type_id'] = "{{ __ ('mobile.formPage.basicDetails.cost_type_id.errors.required')}}";
                    isError = true;
                }
                let cost = $('[name=cost]').val();
                if (cost == '') {
                    errors['cost'] = "{{ __ ('mobile.formPage.basicDetails.cost.errors.required')}}";
                    isError = true;
                } else if (isNaN(cost)) {
                    errors['cost'] = "{{ __ ('mobile.formPage.basicDetails.cost.errors.numeric')}}";
                    isError = true;
                } else if (cost < 0) {
                    errors['cost'] = "{{ __ ('mobile.formPage.basicDetails.cost.errors.gt')}}";
                    isError = true;
                } else if (cost < 1) {
                    errors['cost'] = "{{ __ ('mobile.formPage.basicDetails.cost.errors.min')}}";
                    isError = true;
                } else if (cost > 99999.99) {
                    errors['cost'] = "{{ __ ('mobile.formPage.basicDetails.cost.errors.max')}}";
                    isError = true;
                }

                let plan_data = $('[name=plan_data]').val();
                if (plan_data == '') {
                    errors['plan_data'] = "{{ __ ('mobile.formPage.basicDetails.plan_data.errors.required')}}";
                    isError = true;
                } else if (isNaN(plan_data)) {
                    errors['plan_data'] = "{{ __ ('mobile.formPage.basicDetails.plan_data.errors.numeric')}}";
                    isError = true;
                } else if (plan_data < 0) {
                    errors['plan_data'] = "{{ __ ('mobile.formPage.basicDetails.plan_data.errors.gt')}}";
                    isError = true;
                } else if (plan_data > 1023) {
                    errors['plan_data'] = "{{ __ ('mobile.formPage.basicDetails.plan_data.errors.max')}}";
                    isError = true;
                }

                let plan_data_unit = $('[name=plan_data_unit]').val();
                if (plan_data_unit == '') {
                    errors['plan_data_unit'] = "{{ __ ('mobile.formPage.basicDetails.plan_data_unit.errors.required')}}";
                    isError = true;
                }

                let network_type = $('[name^=network_type]').val();
                if (network_type.length == 0) {
                    errors['network_type'] = "{{ __ ('mobile.formPage.basicDetails.network_type.errors.required')}}";
                    isError = true;
                }

                let contract_id = $('[name=contract_id]').val();
                if (contract_id == '') {
                    errors['contract_id'] = "{{ __ ('mobile.formPage.basicDetails.name.errors.required')}}";
                    isError = true;
                }

                // let activation_date_time = $('[name=activation_date_time]').val();
                // if (activation_date_time == '') {
                //     errors['activation_date_time'] = "{{ __ ('mobile.formPage.basicDetails.activation_date_time.errors.required')}}";
                //     isError = true;
                // }

                let network_host_information = CKEDITOR.instances.network_host_information.getData();
                if (network_host_information == '') {
                    errors['network_host_information'] = "{{ __ ('mobile.formPage.basicDetails.network_host_information.errors.required')}}";
                    isError = true;
                }

                let inclusion = CKEDITOR.instances.inclusion.getData();
                if (inclusion == '') {
                    errors['inclusion'] = "{{ __ ('mobile.formPage.basicDetails.inclusion.errors.required')}}";
                    isError = true;
                }
                // if (!$('[name=billing_preference]:checked').val()) {
                //     errors['billing_preference'] = "{{ __ ('mobile.formPage.basicDetails.billing_preference.errors.required')}}";
                //     isError = true;
                // }

                // let deactivation_date_time = $('[name=deactivation_date_time]').val();
                // if (deactivation_date_time == '') {
                //     errors['deactivation_date_time'] = "{{ __ ('mobile.formPage.basicDetails.deactivation_date_time.errors.required')}}";
                //     isError = true;
                // }

                break;
            case 'plan_permissions_authorizations_form':
                if (!$('[name=override_provider_permission]:checked').val()) {
                    errors['override_provider_permission'] = "{{ __ ('mobile.formPage.permissions_authorizations.override_permission.errors.required')}}";
                    isError = true;
                }if (!$('[name=new_connection_allowed]:checked').val()) {
                    errors['new_connection_allowed'] = "{{ __ ('mobile.formPage.permissions_authorizations.new_connection_allowed.errors.required')}}";
                    isError = true;
                }
                if (!$('[name=port_allowed]:checked').val()) {
                    errors['port_allowed'] = "{{ __ ('mobile.formPage.permissions_authorizations.port_allowed.errors.required')}}";
                    isError = true;
                }

                if (!$('[name=retention_allowed]:checked').val()) {
                    errors['retention_allowed'] = "{{ __ ('mobile.formPage.permissions_authorizations.retention_allowed.errors.required')}}";
                    isError = true;
                }
                break;
            case 'plan_term_condition_form':
                let term_title_content = $('[name=term_title_content]').val();
                if (term_title_content == '') {
                    errors['term_title_content'] = "{{ __ ('mobile.formPage.tnc.term_title_content.errors.required')}}";
                    isError = true;
                }
                break;
            case 'plan_information_form':
                let details = CKEDITOR.instances.details.getData();
                if (details == '') {
                    errors['details'] = "{{ __ ('mobile.formPage.nationalInclusion.details.errors.required')}}";
                    isError = true;
                }
                let amazingExtraFacility = CKEDITOR.instances.amazing_extra_facilities.getData();
                if (amazingExtraFacility == '') {
                    errors['amazing_extra_facilities'] = "{{ __ ('mobile.formPage.planInformation.validations.plan_extra_facilities_required')}}";
                    isError = true;
                }
                break;
            case 'plan_national_inclusion_form':
                
                break;
            case 'plan_reference_form':
                let s_no = $('[name=s_no]').val();
                if (s_no == '') {
                    errors['s_no'] = "{{ __ ('mobile.formPage.planRef.modal.s_no.errors.required')}}";
                    isError = true;
                }

                let title = $('[name=title]').val();
                if (title == '') {
                    errors['title'] = "{{ __ ('mobile.formPage.planRef.modal.title.errors.required')}}";
                    isError = true;
                }

                let linktype = $('[name=linktype]:checked').val();
                if (!linktype) {
                    errors['new_connection_allowed'] = "{{ __ ('mobile.formPage.planRef.modal.linktype.errors.required')}}";
                    isError = true;
                } else {
                    if (linktype == 1) {
                        let url = $('[name=url]').val();
                        if (url == '') {
                            errors['url'] = "{{ __ ('mobile.formPage.planRef.modal.url.errors.required')}}";
                            isError = true;
                        }
                    } else {
                        let file = $('[name=file]').val();
                        if (file == '') {
                            errors['file'] = "{{ __ ('mobile.formPage.planRef.modal.file.errors.required')}}";
                            isError = true;
                        }
                    }
                }

                break;
        }
        if (isError) {
            showValidationMessages(errors)
            toastr.error('Please Check Errors.');
            return false;
        }
        return true;
    }

    const srNoDropdown = () => {
        let planRefCounter = $('#dynamic_plan_reference_data tr').length + 1;
        $('#plan_reference_form [name=s_no]').html('');
        for (let index = 1; index <= planRefCounter; index++) {
            $('#plan_reference_form [name=s_no]').append(`
                <option value="${index}" ${index == planRefCounter ? 'selected' : ''} >${index}</option>
            `);
        }
        $('#plan_reference_form [name=s_no]').trigger('change');
    }

    const showValidationMessages = (errors) => {
        $.each(errors, function(key, value) {
            $('#' + key + '_error').addClass('field-error').text(value).fadeIn();
        });
        if ($(".field-error:first").length) {
            $("html, body").animate({
                scrollTop: $(".field-error:first").offset().top - 150
            }, 1500);
        }
    }

    const planTermConditionList = (data) => {
        $('#dynamic_terms_condition_data').html('');
        data.forEach(term => {
            $('#dynamic_terms_condition_data').append(`
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-gray-800">${term.title}</label>
                    <div class="col-lg-8">
                        <span class="fw-bolder fs-6 text-gray-800" class="edit-plan-term" data-id="${term.id}" data-title="${term.title}" data-desc="${term.description}">{{ __ ('mobile.formPage.tnc.edit')}}</span>
                    </div>
                </div>
            `);
        });
    }

    const planRefList = (data) => {
        $('#dynamic_plan_reference_data').html('');
        console.log(data.length);
        if(data.length >=1){
            $('.addPlanRefButton').addClass('hideRefBtn');
            $('.addPlanRefButton').removeClass('showRefBtn');
        }else{
            $('.addPlanRefButton').addClass('showRefBtn');
            $('.addPlanRefButton').removeClass('hideRefBtn');
        }
        console.log(data.length);
        data.forEach((planRef, i) => {
            $('#dynamic_plan_reference_data').append(`
                <tr id="row-${i}">
                    <td class="text-center">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <td data-kt-ecommerce-order-filter="order_id" class="text-center">
                        <a href="javascript:void(0)" class="text-gray-800 text-hover-primary fw-bolder">${i+1}</a>
                    </td>
                    <td data-kt-ecommerce-order-filter="order_id" class="text-center">
                        <a href="javascript:void(0)" class="text-gray-800 text-hover-primary fw-bolder">${planRef.s_no}</a>
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" class="text-gray-800 text-hover-primary fw-bolder">${planRef.title}</a>
                    </td>
                    <td class="text-center">
                        <a href="${planRef.url}" target="_blank" rel="noopener noreferrer">
                            <span class="text-sky-800 text-hover-primary fs-5 fw-bolder">View</span>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{ __ ('mobile.formPage.planRef.actions')}}   
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                </svg>
                            </span>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="javascript:void(0)" class="menu-link px-3 edit-plan-ref" data-id="${planRef.id}" data-sno="${planRef.s_no}" data-title="${planRef.title}" data-url="${planRef.url}">{{ __ ('mobile.formPage.planRef.edit')}}</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="javascript:void(0)" class="menu-link px-3 delete-plan-ref" data-id="${planRef.id}" data-kt-ecommerce-order-filter="delete_row">{{ __ ('mobile.formPage.planRef.delete')}}</a>
                            </div>
                        </div>
                    </td>
                </tr>
            `);
            var menu = KTMenu.getInstance($('#row-' + i + ' .menu'));

        });
        srNoDropdown();
    }

    $(document).on('click', '#view-provider', function (event) {
        var url = $(this).data('url');
        $('#provider-detail .modal-body').attr('data-kt-indicator', 'on');
        axios.get(url)
            .then(function (response) {
                setTimeout(function () {
                    $('#provider-detail .modal-body').attr('data-kt-indicator', 'off');
                    $('#provider-detail .modal-body').append(response.data)
                }, 1000)
            })
            .catch(function (error) {
                $('#provider-detail .modal-body').attr('data-kt-indicator', 'off');
                console.log(error);
            })
            .then(function () {

            });
    });

    $('#provider-detail').on('hidden.bs.modal', function (e) {
        $('#provider-detail .modal-body').html('<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>');
    });

    $(document).on('click','.override_provider_permission', function(){
        hidePlanPermissionFields();
    });

   function hidePlanPermissionFields(){
       let selectedOption = $('input[type=radio][name=override_provider_permission]:checked').val();
        if(selectedOption == 1){
            $('.hide_permission_disable_fields').css('display','block');
        }else if(selectedOption == 0){
            $('.hide_permission_disable_fields').css('display','none');
        }
    }

    $(window).on("load", function() {
        hidePlanPermissionFields();
    });
</script>