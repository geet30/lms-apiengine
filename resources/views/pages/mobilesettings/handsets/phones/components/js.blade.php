<script>
    jQuery(function () {
    let statusToggleButton = null;
    let toggleInitialStatus = 0;

    $(".reset-phone-filter").on('click', function () {
        $('#phones_filters')[0].reset();
        $(".filter_phone_status").val('').trigger('change');
        $('#search_brand').prop('selectedIndex',0).trigger('change');
        $('#filter_phone_status').prop('selectedIndex',0).trigger('change');
        $("#apply_phones_filters").trigger("click");
    });

    $('#apply_phones_filters').click(function(e) {
        e.preventDefault();
        pageNumber = 1;
        getPhonesFilterData();
    });

    $('.master-checkbox').click(function() {
        $('.row-checkbox').prop('checked', false);
        if ($(this).is(':checked')) {
            $('.row-checkbox').prop('checked', true);
        }
    });

    $('#assign_provider').click(function() {
        $('#selected_phone_to_assign_section').html('').hide();
        let html = '';
        if ($('.row-checkbox:checked').length) {
            $.each($('.row-checkbox:checked'),function(){
                html += `<div class="col-lg-3">
                            <input type="hidden" name="handsets_ids[]" value="${$(this).val()}">
                            <input type="radio" class="btn-check" checked="checked">
                            <label class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-10" for="kt_create_account_form_account_type_personal">
                                <span class="d-block fw-bold text-start">
                                    <span class="text-dark fw-bolder d-block fs-4 mb-2">${$(this).data('name')}</span>
                                </span>
                            </label>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>`;
            })
            $('#selected_phone_section').html(html).show();
            $('#assign_handset_modal').modal('show');
        }else{
            toastr.error('Please select atleast one Phone.');
        }
    })

    $('#assign_provider_drop_down').change(function(){
        if($(this).val() == '')
            return false
        let data = new FormData();
        data.append('provider_id',$('#assign_provider_drop_down').val());
        $.each($('[name^=handsets_ids]'), function(){
            data.append('handset_ids[]',$(this).val());
        })
        axios.post('/mobile/check-assign-provider', data)
            .then(response => {
                setAssignHandseHtml(response.data.assigned_handsets,response.data.not_assigned_Handsets);
                loaderInstance.hide();
            }).catch(err => {
                loaderInstance.hide();
            });
    })

    const setAssignHandseHtml = (assigned_handsets,not_assigned_Handsets) =>{
        let html  = '';
        assigned_handsets.forEach(element => {
            html += `<div class="col-lg-3">
                        <input type="radio" class="btn-check" checked="checked">
                        <label class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger p-7 d-flex align-items-center mb-10" for="kt_create_account_form_account_type_personal" style="border-color:'red'">
                            <span class="d-block fw-bold text-start">
                            <span class="text-dark fw-bolder d-block fs-4 mb-2">${element.name}</span>
                                <span class="text-dark fw-bolder d-block fs-7">Already Assigned</span>
                            </span>
                        </label>
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>`;
        })

        not_assigned_Handsets.forEach(element => {
            html += `<div class="col-lg-3">
                            <input type="hidden" name="handset_ids[]" value="${element.id}">
                            <input type="radio" class="btn-check" checked="checked">
                            <label class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-10" for="kt_create_account_form_account_type_personal">
                                <span class="d-block fw-bold text-start">
                                    <span class="text-dark fw-bolder d-block fs-4 mb-2">${element.name}</span>
                                </span>
                            </label>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>`;
        })
        $('#selected_phone_section').hide();
        $('#selected_phone_to_assign_section').html(html).show();
    }

    $('#assigned_handset_provider_submit').click(function(){
        if($('#assign_provider_drop_down').val() == '')
            return false
        let data = new FormData();
        data.append('provider_id',$('#assign_provider_drop_down').val());
        $.each($('[name^=handset_ids]'), function(){
            data.append('handset_ids[]',$(this).val());
        })
        if(!$('[name^=handset_ids]').length){
            toastr.error('Selected phone(s) is/are already assigned.');
            return false;
        }
        axios.post('/mobile/handset/assign-provider', data)
            .then(response => {
                $('#assign_handset_modal').modal('hide');
                $('.master-checkbox,.row-checkbox').prop('checked',false);
                toastr.success(response.data.message);
                loaderInstance.hide();
            }).catch(err => {
                loaderInstance.hide();
            });
    })

    $("#assign_handset_modal").on('hidden.bs.modal', function(){
        $('#assign_provider_drop_down').val('').change();
        $('#selected_phone_section').html('');
    });

    function getPhonesFilterData(){
        processing = true;
        let myForm = document.getElementById('phones_filters');
        let formData = new FormData(myForm);
        var url = '/mobile/handsets?page=' + pageNumber;
        loaderInstance.show();
        axios.post(url, formData)
            .then(function (response) {
                actionPer = response.data.action_per;
                setPhonesHtmlListing(response.data.phonesListing,actionPer);
                loaderInstance.hide();
            });
    }

    function setPhonesHtmlListing(data,actionPer){
        let html = '';
        dataTable.destroy(false);
        data.forEach((element,index) => {
            checked = '';
            if (element.status == 1) { checked = 'checked' }
            html += `<tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input row-checkbox" type="checkbox" value="${element.id}" data-name="${element.name}"  />
                            </div>
                        </td>
                        <td>${index+1}</td>
                        <td title="${element.name}">
                            ${element.name}
                        </td>
                        <td title="${element.model}">
                            ${element.model}
                        </td>
                        <td>${element.brand ? element.brand.title : '-'}</td>
                        <td>
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                                    <input class="form-check-input sweetalert_demo change-status" type="checkbox" data-id="${element.encrypted_id}" value="" ${checked}>
                            </div>
                        </td>`;
            if(actionPer){
                html += `<td><a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                </svg>
                            </span>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item">
                                <a href="/mobile/get-phone-form/${element.encrypted_id}"><span class="menu-link api_popup">{{ __('buttons.edit') }}</span></a>
                            </div>
                            <div class=" menu-item ">
                                <a href="javascript:void(0);" class="delete-phone" data-id="${element.encrypted_id}"><span class="menu-link">{{ __('buttons.delete') }}</span></a>
                            </div>
                            <div class=" menu-item ">
                                <a href="javascript:void(0);" class="manage-phone-variant" data-id="${element.encrypted_id}"><span class="menu-link">{{ __('buttons.variants') }}</span></a>
                            </div>
                        </div></td>
                    </tr>`;
            }else{
                html += `<td>-</td></tr>`;
            }   
           
            });
            $('#phones_list_tbody').html('');
            $('#phones_list_tbody').append(html);
            KTMenu.createInstances();
            dataTable = $("#phones_table").DataTable({
                searching: true,
                "sDom": "tipr",
                "pageLength": 10,
                columnDefs: [{
                    targets: [2,3],
                    render: $.fn.dataTable.render.ellipsis(20,true)
                }],
            });
        }

        $('.submit_btn').click(function() {
            let phoneId = $('#phone_id').val();
            let formId = $(this).data('form');
            if (!formId) {
                toastr.error('Whoops! something went wrong.');
                return false;
            }
            let data = new FormData($('#' + formId)[0]);
            let url = "{{url('/mobile/save')}}";
            data.append('form', formId);
            if (phoneId) {
                data.append('phoneId', phoneId);
                data.append('_method', 'put');
                url += '/' + phoneId;
            }
            switch (formId) {
                case 'phone_basic_details_form':
                    data.set('why_this', editorsArr.why_this.getData());
                    data.set('other_info', editorsArr.other_info.getData());
                    break;
                case 'mobile_features_form':
                    data.set('camera', editorsArr.camera.getData());
                    data.set('sensors', editorsArr.sensors.getData());
                    data.set('technical_specs', editorsArr.technical_specs.getData());
                    data.set('battery_info', editorsArr.battery_info.getData());
                    data.set('in_the_box', editorsArr.in_the_box.getData());
                    break;
                case 'add_more_info_form':
                    data.set('s_no', $('#add_more_info_form [name=s_no]').val());
                    break;
            }
            $('.errors').text('').removeClass('field-error').hide();
            submitForm(url, data, formId);
        });

    const submitForm = (url, data, form) => {
        loaderInstance.show();
        axios.post(url, data)
            .then(response => {
                if (response.data.status == 200) {
                    toastr.success('Details saved successfully.')
                    if(response.data.type == 'add'){

                            location.href = `{{ theme()->getPageUrl('/mobile/handsets') }}`;
                        }
                        if (form == 'add_more_info_form') {
                            $('#add_more_info_modal').modal('hide');
                            $('#add_more_info_modal').find('form').trigger('reset');
                            handsetMoreInfoList(response.data.handsetInfoList);
                            KTMenu.createInstances();
                        }
                    }
                    loaderInstance.hide();
                }).catch(err => {
                    if (err.response.status == 422) {
                        showValidationMessages(err.response.data.errors);
                    }
                    if (err.response.status && err.response.data.message)
                        toastr.error('Please Check Errors');
                    else
                        toastr.error('Whoops! something went wrong.');

                    loaderInstance.hide();
                });
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

        $('body').on('click', '.cancel_more_info_btn', function() {
            $('#add_more_info_modal').find('form').trigger('reset');
            $('#add_more_info_modal').modal('hide');
        });

        $('body').on('click', '.add_more_info', function() {
            srNoDropdown();
        });

        const srNoDropdown = () => {
            let infoCounter = $('#phones_more_info_tbody tr').length + 1;
            $('#add_more_info_form [name=s_no]').html('');
            for (let index = 1; index <= infoCounter; index++) {
                $('#add_more_info_form [name=s_no]').append(`
                <option value="${index}" ${index == infoCounter ? 'selected' : ''} >${index}</option>
            `);
            }
            $('#add_more_info_form [name=s_no]').change();
        }


        $(document).on('click', '.delete-phone', function(e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            Swal.fire({
                title: "{{trans('handset.indexPage.warning_msg_title')}}",
                text: "{{trans('handset.indexPage.delete_msg_text')}}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{trans('handset.indexPage.yes_text')}}",
            }).then(function(result) {
                if (result.isConfirmed) {

                    axios.delete("/mobile/delete/" + id)
                        .then(function(response) {
                            if (response.data.status == true) {
                                toastr.success(response.data.message);
                                setPhonesHtmlListing(response.data.phoneListing);
                            } else {
                                toastr.error(response.data.message);
                            }

                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            });

        });


        $('[name=linktype]').click(function() {
            $('.url_box, .file_box').hide();
            if ($(this).val() == 'file')
                $('.file_box').fadeIn();
            else
                $('.url_box').fadeIn();
        });


        function handsetMoreInfoList(data) {
            let html = '';
            data.forEach((element, index) => {
                html += `<tr>
                        <td>${element.s_no}</td>
                        <td>${element.title}</td>
                        <td>
                            <a href="${element.image}" target="_blank" rel="noopener noreferrer">
                                <span class="text-sky-800 text-hover-primary fs-5 fw-bolder">View</span>
                            </a></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{ __ ('mobile.formPage.planRef.actions')}}

                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>

                            </a>

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">

                                <div class="menu-item px-3">
                                    <a href="javascript:void(0)" class="menu-link px-3 edit-handset-info-modal" data-id="${element.id}" data-s_no="${element.s_no}" data-title="${element.title}" data-image="${element.image}" data-linktype="${element.linktype}">{{ __ ('buttons.edit')}}</a>
                                </div>

                                <div class="menu-item px-3">
                                    <a href="javascript:void(0)" class="menu-link px-3 delete-handset-info-modal" data-id="${element.id}" data-kt-ecommerce-order-filter="delete_row">{{ __ ('buttons.delete')}}</a>
                                </div>

                            </div>

                        </td>
                    </tr>`
        });
        $('#phones_more_info_tbody').html('');
        $('#phones_more_info_tbody').append(html);
        srNoDropdown();
    }

    $(document).on('click', '.edit-handset-info-modal', function() {
        srNoDropdown();
        $('.add_more_info_header').html('Edit Info');
        $('#current_s_no, #add_more_info_form [name=s_no]').val($(this).data('s_no'));
        $('#add_more_info_form [name=s_no]').trigger('change');
        $('#add_more_info_form [name=title]').val($(this).data('title'));
        let linktype = $(this).data('linktype');
        $('#add_more_info_form [name=url]').val($(this).data('image'));
        let handset_info_id = $(this).data('id');
        $('#add_more_info_form [name=handset_info_id]').val(handset_info_id);
        $('[name=s_no]').removeAttr('disabled');
        $('[name=s_no] option:last').attr('disabled', true);
        $('#add_more_info_modal').modal('show');
    });

    /*
    * Change Status
    */
    $(document).on('click', '.change-status', function(e) {
        var id = $(this).attr("data-id");
        statusToggleButton = $(this);
        var url = '/mobile/change-handset-status';
        if ($(this).is(':checked'))
            toggleInitialStatus = 1;

        var formdata = new FormData();
        formdata.append("handset_id", id);
        formdata.append("status", toggleInitialStatus);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change status!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function(result) {
            if (result.isConfirmed) {
                axios.post(url, formdata)
                    .then(function(response) {
                        toastr.success(response.data.message);
                    })
                    .catch(function(error) {
                        if (error.response.status == 422) {
                            toastr.error(error.response.data.message);
                            statusToggleButton.prop('checked', !toggleInitialStatus);
                        }
                        if (error.response.status == 400) {
                            handsetAssignedProvidersData(error.response.data.decryptedProviders);
                            $('#handset_status_change_modal_btn').attr('data-id', id);
                            $('#handset_status_change_modal_btn').attr('data-status', toggleInitialStatus);
                            $('#handsetAssignedProvidersModal').modal('show');
                        }
                    });
            } else {
                statusToggleButton.prop('checked', !toggleInitialStatus);
            }
        });
    });

    function handsetAssignedProvidersData(data) {
        let html = '';
        data.forEach((element, index) => {
            html += ` <div class="col-md-3">
                    <div class="form-body">
                        <div class="form-group name">
                            <div class="alert alert-info">
                                <strong>${element}</strong>
                            </div>
                        </div>
                    </div>
                </div>`
        });

        $('.assigned_providers_names').html('');
        $('.assigned_providers_names').append(html);
    }

    $('body').on('click', '.cancel_assign_providers_btn', function() {
        $('#handsetAssignedProvidersModal').modal('hide');
        statusToggleButton.prop('checked', !toggleInitialStatus);
    });

    $(document).on('click', '#handset_status_change_modal_btn', function() {
        var id = $(this).attr("data-id");
        var status = $(this).attr("data-status");
        var url = '/mobile/change-handset-status/accepted';

        var formdata = new FormData();
        formdata.append("handset_id", id);
        formdata.append("status", status);
        axios.post(url, formdata)
            .then(function(response) {
                toastr.success(response.data.message);
                $('#handsetAssignedProvidersModal').modal('hide');
            })
            .catch(function(error) {
                if (error.response.status == 422) {
                    toastr.error(error.response.data.message);
                }
            });
    });

    $("#add_more_info_modal").on('hidden.bs.modal', function () {

        $(this).find('form').trigger('reset');
        $('.add_more_info_header').html('Add Info');
        $('[name=s_no]').attr('disabled', true);
        $("[name='handset_info_id']").val("");
        $('.file_box').hide();
        $('.url_box').fadeIn();
    });

});

</script>
