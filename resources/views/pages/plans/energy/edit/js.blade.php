@section('styles')
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/custom/js/breadcrumbs.js"></script>
<script>
    var baseUrl = '/provider/plans/energy';
    var formData = [];
    var remarketingData = '';
    var eicData = '';
    var tagData = '';
    var planTag = '';
    var type_id = '';

    var energyName = '';
    var energyType = "{{ $editPlan['energy_type'] }}";
    if(energyType == 1){
        energyName = 'electricity';
    }else if(energyType == 2){
        energyName = 'gas';
    }else if(energyType == 3){
        energyName = 'lpg';
    }
    var diff_aff = '/provider/list';
    var aff_head = 'Providers';
    let current_head = "{{ ucwords(decryptGdprData($selectedProvider->name)) }}";
    let current_head_url = "/provider/plans/energy/"+energyName+"/list/{{ encryptGdprData($selectedProvider->user_id) }}";
    let current_sub_head = "{{ ucwords($editPlan['name']) }}";

    const breadArray = [{
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
            title: current_head,
            link: current_head_url,
            active: false
        },
        {
            title: capitalizeFirstLetter(energyName) + " Plans",
            link: current_head_url,
            active: false
        },
        {
            title: current_sub_head,
            link: '#',
            active: false
        },
        {
            title: "Edit",
            link: '#',
            active: true
        },
    ];
    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();

    $(document).on('change', '#eic_parameter', function() {
        var selected = $('#eic_parameter :selected').val();
        var oldData = CKEDITOR.instances.eic_editor.getData();
        oldData += selected;
        CKEDITOR.instances.eic_editor.setData(oldData);
    });

    function capitalizeFirstLetter(str) {
        if(str)
           return str[0].toUpperCase() + str.slice(1);
        return false;
    }

    $(document).on('change', '#eic_parameter_checkbox', function() {
        var selected = jQuery('#eic_parameter_checkbox :selected').val();
        console.log(selected);
        var oldData = CKEDITOR.instances.checbox_content.getData();
        oldData += selected;
        CKEDITOR.instances.checbox_content.setData(oldData);
    });

    $(document).on('change', '#remarketing_pearm', function() {
        var selected = $('#remarketing_pearm :selected').val();
        var oldData = CKEDITOR.instances.remarketing_terms_conditions.getData();
        oldData += selected;
        CKEDITOR.instances.remarketing_terms_conditions.setData(oldData);
    });

    $(document).on('change', '#apply_now_parameters', function() {
        var selected = $('#apply_now_parameters :selected').val();
        var oldData = CKEDITOR.instances.apply_now_content.getData();
        oldData += selected;
        CKEDITOR.instances.apply_now_content.setData(oldData);
    });


    var ck_data = document.getElementsByClassName("ckeditor");
    var data = '';
    let plan_id = "{{$editPlan['id']}}";
    if (ck_data.length) {

        for (var i = 0; i < ck_data.length; i++) {
            //ClassicEditor .create(ck_data.item(i)) .catch( error=> {
            //console.error( error );

            //} );
            // console.log(ck_data.item(i).getData());

        }
    }
    $("#submit_plan_view").click(function() {

        formData = new FormData($("#plan_view_form")[0]);
        action = $('#plan_view_form').attr('action');
        formData.append('view_bonus', CKEDITOR.instances.view_bonus.getData());
        formData.append('view_contract', CKEDITOR.instances.view_contract.getData());
        formData.append('view_exit_fee', CKEDITOR.instances.view_exit_fee.getData());
        formData.append('view_benefit', CKEDITOR.instances.view_benefit.getData());
        formData.append('view_discount', CKEDITOR.instances.view_discount.getData());

        form_submit(action, formData);

    });
    $("#submit_plan_info").click(function() {

        //formDatas =$("#plan_info_form").serialize();

        var formData = new FormData($("#plan_info_form")[0]);
        action = $('#plan_info_form').attr('action');
        
        
        
        formData.append('plan_desc', CKEDITOR.instances.plan_desc.getData());
        formData.append('paper_bill_fee', CKEDITOR.instances.paper_bill_fee.getData());
        formData.append('counter_fee', CKEDITOR.instances.counter_fee.getData());
        formData.append('credit_card_service_fee', CKEDITOR.instances.credit_card_service_fee.getData());
        if(CKEDITOR.instances.cooling_off_period){
            formData.append('cooling_off_period', CKEDITOR.instances.cooling_off_period.getData());
        }
        
        formData.append('other_fee_section', CKEDITOR.instances.other_fee_section.getData());
        formData.append('plan_bonus_desc', CKEDITOR.instances.plan_bonus_desc.getData());
        formData.append('payment_options', CKEDITOR.instances.payment_options.getData());
        formData.append('plan_features', CKEDITOR.instances.plan_features.getData());
        formData.append('terms_condition', CKEDITOR.instances.terms_condition.getData());

        form_submit(action, formData);

    });

    $("#remarketing_info_btn").click(function() {
        var formData = new FormData($("#remarketing_info_form")[0]);

        action = $('#plan_info_form').attr('action');
        formData.append('remarketing_terms_conditions', CKEDITOR.instances.remarketing_terms_conditions.getData());
        form_submit(action, formData);
    });

    $("#eic_content_btn").click(function() {
        var formData = new FormData($("#eic_content_form")[0]);
        action = $('#eic_content_form').attr('action');
        formData.append('eic_editor', CKEDITOR.instances.eic_editor.getData());
        form_submit(action, formData);
        jQuery('.get_plan_eic').trigger('click');
    });


    $("#eic_content_checkbox_btn").click(function() {
        var formData = new FormData($("#eic_content_checkbox_form")[0]);
        action = $('#eic_content_checkbox_form').attr('action');
        formData.append('checbox_content', CKEDITOR.instances.checbox_content.getData());
        status = form_submit(action, formData);
        console.log(status);
        if (status == 200) {

        }


    });

    $("#apply_now_btn").click(function() {
        var formData = new FormData($("#apply_now_form")[0]);

        action = $('#apply_now_form').attr('action');
        formData.append('apply_now_content', CKEDITOR.instances.apply_now_content.getData());
        form_submit(action, formData);
    });
    $("#set_tag_btn").click(function() {
        var formData = new FormData($("#plan_tag_form")[0]);
        action = $('#plan_tag_form').attr('action');
        form_submit(action, formData);
    });


    //geting remarketing data
    $(".get_remarketing_info").click(function() {
        if (remarketingData == '') {

            let action = baseUrl + "/get-remarketing"
            remarketingData = getData(action, {
                params: {
                    plan_id: plan_id
                }
            });
        }
    });

    function form_submit(action, formData) {

        $(".input").css("border-color", "black");
        $(".form_error").text("");
        var checkAction = formData.get('action_form');

        let submitButton = document.querySelector('.submit_button');
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        axios.post(action, formData)

            .then(function(response) {
                if (response.data.status == 200) {
                    if (checkAction == 'eic_content_checkbox_form') {
                        $('#eic_model').modal('toggle');
                        $("#eic_model").modal('hide');
                        getEicCheckboxData(type_id);
                    }
                    toastr.success(response.data.message);
                } else {
                    toastr.error("{{trans('plans.errorMessage')}}");
                }


            })
            .catch(function(error) {
                if (error.response.status == 422) {


                    errors = error.response.data.errors;

                    $.each(errors, function(key, value) {
                        $('textarea[name=' + key + ']').parent('.field-holder').find('span.form_error').slideDown(400).html(value);
                        $('textarea[name=' + key + ']').css('border-color', 'red');
                        $('input[name=' + key + ']').parent('.field-holder').find('span.form_error').slideDown(400).html(value);
                        $('input[name=' + key + ']').css('border-color', 'red');
                        $('select[name=' + key + ']').parent('.field-holder').find('span.form_error').slideDown(400).html(value);
                        $('select[name=' + key + ']').css('border-color', 'red');
                    });

                }
            })
            .then(function() {
                submitButton.setAttribute('data-kt-indicator', 'off');
                submitButton.disabled = false;
                // always executed
            });

    }

    function getData(action, formData) {
        var responseData = '';
        axios.get(action, formData)
            .then(function(response) {
                if (response.data.remarketing_allow == 1) {
                    $("#allowmarketing").prop('checked', true);
                    
                    $("input[name='discount']").val(response.data.discount);
                    $("input[name='discount_title']").val(response.data.discount_title);
                    $("input[name='termination_fee']").val(response.data.termination_fee);
                    $("input[name='month_benfit_period']").val(response.data.contract_term);
                    CKEDITOR.instances.remarketing_terms_conditions.setData(response.data.remarketing_terms_conditions);
                } else {

                    $("#allowmarketing").prop('checked', false);
                }
            })
            .catch(function(error) {
                toastr.error(error.response.message);
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                }
            })

    }

    //get eic content data
    $(".get_plan_eic").click(function() {
        if (eicData == '') {
            let action = baseUrl + "/get-eic-content"
            if (eicData == '') {
                axios.get(action, {
                        params: {
                            plan_id: plan_id
                        }
                    })
                    .then(function(response) {
                        eicData = response.data;
                        $("#add_checkbox").prop('disabled', false);
                        if (response.data.status == 1) {
                            $("#eic_status").prop('checked', true);
                        } else {
                            $("#eic_status").prop('checked', false);
                        }
                        CKEDITOR.instances.eic_editor.setData(response.data.content);
                        $('input[name=type_id]').val(response.data.id);
                        type_id = response.data.id;
                        getEicCheckboxData(type_id);
                    })
                    .catch(function(error) {
                        $("#add_checkbox").prop('disabled', true);

                    })
            }

        }
    });

    function getEicCheckboxData(type_id) {
        let action = baseUrl + "/get-eic-checkbox-content";
        axios.get(action, {
                params: {
                    type_id: type_id
                }
            })
            .then(function(response) {
                var sr = 1;
                let requiredData = '';
                let bodyData = '';
                $('.eic_table_body').html();

                $.each(response.data, function(index, value) {

                    if (value.required == 1)
                        requiredData = 'true';
                    else
                        requiredData = 'false';

                    if (value.save_checkbox_status == 1)
                        save_checkbox_status = 'true';
                    else
                        save_checkbox_status = 'false';


                    bodyData += `<tr> <td>${sr++}</td>
                            <td>${requiredData}</td>

                            <td>${value.validation_message}</td>
                            <td>${value.module_type}</td>
                            <td>${value.save_checkbox_status}</td>
                            <td>
                                    <button type="button"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 edit_checkbox_btn"
                                        data-bs-toggle="modal" data-reqired= "${requiredData}", data-content= "${value.content}"data-savecheckbox= "${value.save_checkbox_status}" data-module="${value.module_type}" data-v_msg="${value.validation_message}"  data-id= "${value.id}" data-bs-target="#eic_model">

                                        <span class="svg-icon svg-icon-3"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3"
                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                    fill="black"></path>
                                                <path
                                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                    fill="black"></path>
                                            </svg></span>

                                    </button>

                                    <a href="#" data-bs-toggle=""
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm menu-link px-3">

                                        <span class="svg-icon svg-icon-3"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                    fill="black"></path>
                                                <path opacity="0.5"
                                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                    fill="black"></path>
                                                <path opacity="0.5"
                                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                    fill="black"></path>
                                            </svg></span>

                                    </a>
                                </td>
                            </tr>`;

                    // console.log(value.content);

                });
                $('.eic_table_body').html(bodyData);

                // const dataTable = $("#eic_checkbox_table").DataTable({
                //     responsive: false,
                //     searching: false,
                //     "sDom": "tipr"
                // });

            })
            .catch(function(error) {
                console.log(error);

            })
    }

    $(document).on('click', '.edit_checkbox_btn', function(e) {

        var id = $(this).attr('data-id');
        var reqiured = $(this).attr('data-reqired');
        var content = $(this).attr('data-content');
        var savecheckbox = $(this).attr('data-savecheckbox');
        var modules = $(this).attr('data-module');
        var validationMessage = $(this).attr('data-v_msg');

        if (savecheckbox == 1) {
            $("#save_checkbox_status").prop('checked', true);
        }
        if (reqiured) {
            $("#checkbox_required").prop('checked', true);
        }
        CKEDITOR.instances.checbox_content.setData(content);
        $('input[name=id]').val(id);
        $('input[name=validation_message]').val(validationMessage);
        //$('select[name=eic_type]').val(validationMessage);
        $('select[name=eic_type] option[value="' + modules + '"]').prop('selected', true);

    });
    $(document).on('click', '.get_plan_tag', function(e) {
        let action = baseUrl + "/get-plan-tags"
        if (planTag == '') {
            axios.get(action, {
                    params: {
                        plan_id: plan_id
                    }
                })
                .then(function(response) {
                    var planOptions = '';
                    planTag = response.data;
                    planTags = response.data.planTags;
                    var options = '';
                    $("#plan_tags").append('');
                    $.each(response.data.allTags, function(key, value) {

                        if (jQuery.inArray(value.id, planTags) !== -1) {
                            options += `<option value="${value.id}" selected>${value.name}</option>`
                        } else {
                            options += `<option value="${value.id}">${value.name}</option>`
                        }
                    })
                    $("#plan_tags").append(options);
                })
                .catch(function(error) {
                    console.log(error);
                    toastr.error(error.error.message);
                    if (error.response.status == 422) {
                        errors = error.response.data.errors;
                    }
                })
        }

    });
    $(document).on('click', '#add_checkbox', function(e) {
        $('#eic_content_checkbox_form')[0].reset();
        $('input[name=type_id]').val(type_id);
    });

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
</script>