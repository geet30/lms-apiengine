
<script src="/common/plugins/custom/flatpickr/flatpickr.bundle.js"></script>
@include('pages.affiliates.affsettings.components.target.components.js')
@include('pages.affiliates.affsettings.components.users.components.js')
@include('pages.affiliates.affsettings.components.providers.components.js')
@include('pages.affiliates.affsettings.components.distributors.components.js')
@include('pages.affiliates.affsettings.components.ipwhitelist.components.js')

<script>
    var abc = "{{ ($records) ? decryptGdprData($records['phone']) : "
    " }}";
    var checkAffiliateBdm = 0;



    jQuery(document).ready(function() {
        $(".dataTables_empty").text("There is no record to show.");
        
        var pageNumber = 2;
        $(document).on('click', '#affdetails', function(e) {
            phoneCall();
        });

        function phoneCall() {
            (function() {
                window.open(`tel:${abc}`);
            })()
        }

        //show popup on eye click
        $(document).on('click', '.toggleKey', function(e) {
            if ($(this).hasClass('fa-eye-slash')) {
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $("#apikeyshow").modal('show');
                $("#api-key-input").text($(this).data('id'));
                $(".copyapikey").attr('onClick', copyToClipboard("#api-key-input"));
                $(".copyapikey").text('Copy');
            } else {
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
                $(this).next('.span_apikey').hide();
                $("#apikeyshow").modal('show');
            }
        });
        jQuery('#apikeyshow').modal({
            backdrop: 'static',
            keyboard: false // to prevent closing with Esc button (if you want this too)
        });


    });

    //show values on Update
    var tagsArr = '';
    $(document).on('click', '.api_popup', function(e) {
        $('.popheading').text("{{trans('affiliates_label.api_key.edit_api_key')}}");
        var myModal = new bootstrap.Modal(document.getElementById("apicreatemodal"), {});
        myModal.show();
        var id = $(this).data('id');
        $('#api_key_id').val(id);
        $('span.form_error').hide();
        $('#add_update_apikeyform').find('input').css('border-color', '');
        $("#editApiKeyModel").modal('show');
        $('input[name=name]').val($(this).data('name'));
        $('input[name=page_url]').val($(this).data('page'));
        $('input[name=origin_url]').val($(this).data('origin'));

    });

    $(document).on('click', '.hideapkipopup', function(e) {
        //remove class if poup closed
        $(".toggleKey").removeClass('fa-eye');
        $(".toggleKey").addClass('fa-eye-slash');
    });

    //add-update API Key
    $(document).on('click', '#submit_apikeydata', function(e) {
        e.preventDefault();
        $('#add_update_apikeyform').find('input').css('border-color', '');
        var formData = new FormData($("#add_update_apikeyform")[0]);
        formData.append('user_id', $('#show_apikeypopup').data('user_id'));
        formData.append('id', $("#api_key_id").val());
        if($("#aff_statusfeild").val()) {
            var affStatus = $("#aff_statusfeild").val();
        }
        else {
            var affStatus = 1;
        }
        formData.append('status', affStatus);
        CardLoaderInstance.show('.modal-content');

        axios.post("{{ route('apikey.store')}}", formData)
            .then(function(response) {
                $("#apicreatemodal").modal('hide');
                if (response.data.status == true) {
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message);
                }
                setTimeout(function() {
                   location.reload();
                }, 1000); //add delay
                CardLoaderInstance.hide();


            })
            .catch(function(error) {
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $("span.form_error").hide();
                    $('#add_update_apikeyform').find('input').css('border-color', '');
                    $.each(errors, function(key, value) {
                        $('input[name=' + key + ']').next("span.form_error_" + key).html(value).show();;
                        $('input[name=' + key + ']').css('border-color', 'red');
                    });
                    CardLoaderInstance.hide();

                }
            })
            .then(function() {
                //CardLoaderInstance.hide();

            });
    });
    $(document).on('click', '#show_apikeypopup', function(e) {
        $('.popheading').text("{{trans('affiliates_label.api_key.add_api_key')}}");
        $('span.form_error').text("").hide();
        $('input').css('border-color', '');
        $('.form-control').val('');
    });
    //change status api-key
    $(document).on('click', '.changeAffStatus', function(e) {
        let check = $(this).data("check");
        let thisVal = $(this);
        Swal.fire({
            title: "{{trans('affiliates.warning_msg_title')}}",
            text: "{{trans('affiliates.warning_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('affiliates.yes_text')}}",
            cancelButtonClass: "cancel_aff",
        }).then((result) => {
            if (result.value) {
                var status = $(this).data("status");
                var user_id = $('#show_apikeypopup').data('user_id');
                axios.post("{{ route('apikey.changestatus')}}", {
                        'status': status,
                        'user_id': user_id,
                        'id': $(this).data("id")
                    })
                    .then(function(response) {
                        $("#apicreatemodal").modal('hide');
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                        } else {
                            toastr.error(response.data.message);
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000); //add delay
                    })
                    .catch(function(error) {})
                    .then(function() {

                    });
            }
        });
        $(".cancel_aff").click(function() {
            $(thisVal).prop('checked', check);
        });
    });
    KTMenu.createInstances();
    //datatablse
    const dataTable = $("#affiliatekeys_table").DataTable({
        searching: true,
        "sDom": "tipr",
        "pageLength": 20

    });

    if (($("#affiliatekeys_table >tbody >tr >td").hasClass("dataTables_empty"))) {
        $('.pagination').hide();
        $('#affiliatekeys_table_info').hide();
        $('#affiliatekeys_table_paginate').hide();

    } else {
        $('.pagination').hide();
        $('#affiliatekeys_table_info').hide();
        $('#affiliatekeys_table_paginate').hide();

    }
    $("#affiliatekeys_table_info").addClass('pagination');

    //breadcrumbs code
    var aff_head = '{{$headArr["title"]}}';
    var titleVal = '{{$headArr["settingTitle"]}}';
    var link = '{{$headArr["redirect_link"]}}';
    // var aff_name = '{{ucfirst(decryptGdprData($records["first_name"]))}}'; 
    var aff_name = '{{ucfirst($records->affiliate->company_name)}}'; 

   console.log(aff_name);
    $('#search_affiliate').keyup(function() {
        dataTable.search($(this).val()).draw();
    });
    var info = '{{request()->segment(2)}}';

    const breadArray = [{
        title: 'Dashboard',
        link: '/',
        active: false
    }, ];

    if (info == 'sub-affiliates') {
        breadArray.push({
            title: 'Affiliates',
            link: '/affiliates/list',
            active: false
        }, );
    }

    breadArray.push(
        {
            title: aff_head,
            link: link,
            active: false
        }, 
        {
            title: aff_name,
            link: "/affiliates/affiliate-settings/{{encryptGdprData($records->id)}}",
            active: false
        },
        {
            title: titleVal,
            link: '#',
            active: true
    
        }, 
        );

    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();
    //target js start here
    function formSubmit(action, formData) {
        $(".form_error").text("");
        $('.cke').css('border-color', '');
        $(".select2-selection").css('border-color', '');
        var checkAction = formData.get('action_form');
        let submitButton = document.querySelector('#add_matrix');
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        axios.post(action, formData)
            .then(function(response) {
                if (response.data.edit_id !== null && response.data.edit_id !== undefined)
                    $("#matrix_edit_id").val(response.data.edit_id);
                if (response.data.status == true) {
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function(error) {
                console.log(error);
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        var id = $("#"+key);
                        // if select2
                        var error_field = $(id).nextAll('.form_error').addClass('field-error').text(value).fadeIn();
                        $(error_field).parent().find('.select2-selection').css('border-color', 'red');

                        // if cke editor
                        var error_field1 = $(id).nextAll('.form_error').addClass('field-error').text(value).fadeIn();
                        $(error_field1).parent().find("#cke_"+key).css('border-color', 'red');

                    });
                    toastr.error(error.response.data.message);
                } else {
                    toastr.error('Whoops! something went wrong');
                }
            })
            .then(function() {
                submitButton.setAttribute('data-kt-indicator', 'off');
                submitButton.disabled = false;
            });
    }

    $(document).on('click', '.reset_password', function(e) {
        e.preventDefault();
        let submitButton = $(this);
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true)

        var id = $(this).attr('data-id');
        var url = '/affiliates/send-reset-password';
        var formdata = new FormData();
        formdata.append("id", id);
        axios.post(url, formdata)
            .then(function(response) {
                if (response.data.status == 400) {
                    toastr.error(response.data.message);
                } else {
                    toastr.success(response.data.message);
                }

            })
            .catch(function(error) {
                console.log(error);

            })
            .then(function() {
                // always executed
                submitButton.attr('data-kt-indicator', 'off');
                submitButton.prop('disabled', false);
            });

    });
    //filter
    $('#applyapkifilter').click(function(e) {
        e.preventDefault();
        pageNumber = 1;
        getFilterApiKey();
    });

    function getFilterApiKey(type) {
        var requestFrom = "{{Request::segment(2)}}";
        processing = true;
        var subaffRow = "";

        var sub = '';
        let myForm = document.getElementById('apikeyform');
        let formData = new FormData(myForm);
        formData.append('requestFrom', requestFrom);

        axios.post("/affiliates/affiliate-settings/" + $('#show_apikeypopup').data('user_id') + '?page =' + pageNumber, formData)
            .then(function(response) {
                var requestFrom = response.data.requestFrom;
                var i = 1;
                var html = '';
                var requestFrom = response.data.requestFrom;
                if (response.data.records.affiliate.referral_code_title)
                    subaffRow = response.data.records.affiliate.referral_code_title ? response.data.records.affiliate.referral_code_title : "N/A";

                var i = 1;
                if (requestFrom == "sub-affiliates") {
                    var i = 2;
                    html += ` <tr>
                        <td>1</td>
                        <td><span>${subaffRow}</span></td>

                        <td>
                            <span>${response.data.records.affiliate.referral_code_url ? response.data.records.affiliate.referral_code_url+'?rc='+response.data.records.affiliate.referal_code: "N/A"}</span>
                        </td>

                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                    </tr>`;
                }
                if (response.data.records.api_keys !== "undefined")
                    if (response.data.records.api_keys.length > 0) {
                        $.each(response.data.records.api_keys, function(key, val) {
                            const splitDate = val.created_at.split(" ");
                            var convertdateformat = dateFormat(splitDate[0], 'dd-MM-yyyy');
                            var newdate = convertdateformat+" "+splitDate[1];

                            var pageUrl = val.page_url;
                            if (requestFrom == "sub-affiliates") {
                                var pageUrl = val.page_url +
                                    '?rc=' + val.rc_code;
                            }
                            html += `
                             <tr>
                            <td>${i}
                            </td>
                            <td>
                            <span> ${
                                val.name
                            } </span></td>
                            <td><span>${pageUrl}</span></td>
                            <td>
                            <i class="fa fa-eye-slash"  class="toggleKey" data-id ='${val.api_key}' dats-bs-target= "#apikeyshow" style= 'font-size:25px;cursor:pointer;' aria-hidden ="true"></i></td>
                        <td><span>${newdate}</span></td>
                        <td>`;
                            if (val.status && val.status == 1) {
                                html += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status"><input id="aff_statusfeild" class ="form-check-input changeAffStatus" data-check ="${val.status}" data-id="${val.id}" type = "checkbox" data-status="0" title="Disable"  value= "1" name="status" checked="${val.status ? 'checked' : ''}" ></div>`;
                            } else {
                                html += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status" ><input  id="aff_statusfeild" class ="form-check-input changeAffStatus" data-check="${val.status}" data-id="${val.id}" type ="checkbox" data-status="1" title="enable"
                                value = "0" name="status" >
                            </div>`;
                            }
                            html += `</td>
                            <td>
                                    <a href = "#" class = "btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement = "bottom-end">Actions<span class = "svg-icon svg-icon-5 m-0">
                                    <svg xmlns = "http://www.w3.org/2000/svg" width = "24" height = "24" viewBox = "0 0 24 24" fill ="none">
                                    <path d = "M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill = "black"/></svg> </span></a>
                                    <div class = "menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu= "true" >
                                    <div class = "menu-item" ><span class ="menu-link api_popup" data-id="${val.id}" data-name ="${val.name}" data-page="${pageUrl}" data-origin = "${val.origin_url}">Edit</span></div>
                                    <div class= "menu-item"><span class ="menu-link">Delete</span></div></div>
                                    </td></tr>
                       `;
                            i++;
                        })
                        if (type == 'scroll') {
                            $('#affiliatekeys_table_body').append(html);
                            KTMenu.createInstances();
                            pageNumber += 1;
                            return;
                        }

                        pageNumber = 2;
                        $('#affiliatekeys_table_body').html(html);
                        KTMenu.createInstances();


                    } else {
                        $('#affiliatekeys_table_info').hide();
                        $('#affiliatekeys_table_paginate').hide();
                        $("#affiliatekeys_table_body").empty().html('<tr class="no_record"><td colspan="7" align="center">There is no record to show.</td></tr>');

                    }


            })
            .catch(function(error) {
                console.log(error);
            });

    }
    $(document).on("click", ".resetApiKey", function(e) {
        $('#search_affiliate').val("");
        $('#filter_status').val("1").change();
        pageNumber = 1;
        getFilterApiKey();
    });

     

    function dateFormat(inputDate, format) {
        //parse the input date
        const date = new Date(inputDate);

        //extract the parts of the date
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();

        //replace the month
        format = format.replace("MM", month.toString().padStart(2,"0"));

        //replace the year
        if (format.indexOf("yyyy") > -1) {
            format = format.replace("yyyy", year.toString());
        } else if (format.indexOf("yy") > -1) {
            format = format.replace("yy", year.toString().substr(2,2));
        }

        //replace the day
        format = format.replace("dd", day.toString().padStart(2,"0"));

        return format;
    }

    $(document).on("click", ".get_affiliate_bdm_users", function (e) {
        e.preventDefault();    
        if(checkAffiliateBdm)
        {
            return;
        } 
        let formData = new FormData(); 
        var user_id = $('#show_apikeypopup').data('user_id');
        formData.append('user', $('#checksegment').val());
        formData.append('user_id', user_id);
        checkAffiliateBdm = 1;
        loaderInstance.show();
        var url = '/affiliates/get-affiliate-bdm';
        axios.post(url,formData)
            .then(function (response) {  
                loaderInstance.hide();
                showUsersData(response.data.all_users,response.data.userId);
                updateServiceForAffiliateBdm(response.data.verticals);
                 
                return true;
            })
            .catch(function (error) {
                loaderInstance.hide(); 
            });
    });

    function updateServiceForAffiliateBdm(verticals)
    { 
        var html = '<option><option>';
        $.each(verticals, function (key, vertical) { 
            if(vertical.status == 1)
            {
                html = html + `<option value="${vertical.service_name.id}">${vertical.service_name.service_title}<option>`;
            }
        });   
        $('#serviceField').html(html).select2(); 
    }

    $(document).on("submit", "#add_affiliate_bdm_form", function (e) {
        e.preventDefault();    
        $('.errors').empty().addClass('text-danger').text('').finish().fadeIn();
        let formData = new FormData(this); 
        var url = '/affiliates/add-affiliate-bdm-form';
        if(formData.get('action') == 'edit')
        {
            formData.append('update', 'update');
            url = '/affiliates/update-affiliate-bdm-form/'+formData.get('id');
        }
        var user_id = $('#show_apikeypopup').data('user_id');
        formData.append('user', $('#checksegment').val());
        formData.append('user_id', user_id);
        checkAffiliateBdm = 1;
        loaderInstance.show();
        axios.post(url,formData)
            .then(function (response) {  
                loaderInstance.hide(); 
                $('#add_user_form_modal').modal('hide');
                showUsersData(response.data.all_users,response.data.userId);
                if(formData.get('action') == 'edit')
                {
                    toastr.success('User updated successfully.');
                    return;
                }
                toastr.success('User added successfully.');
                return true;
            })
            .catch(function (error) {
                loaderInstance.hide();
                $(".error").html("");
                if(error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        $('[name="'+key+'"]').parent().find('span.errors').empty().addClass('text-danger').text(value).finish().fadeIn();
                         
                        $('.'+key+'_errors').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                }
                else if(error.response.status == 400) {
                    toastr.error('Something went wrong.');
                }
            });
    });


/**
*   it sets the value in form of particular selected content checkbox with action => edit.
*/ 
$(document).on('click','.edit_user',function(e)
{   
    $("#add_affiliate_bdm_form .errors").html("");
	$('#add_user_form_modal').modal('show');
	var id = $(this).data('id');
	var first_name = $(this).data('first_name');
	var last_name = $(this).data('last_name');
	var email = $(this).data('email'); 
	var phone = $(this).data('phone'); 
	var services = $(this).data('service').toString();  
	$("#serviceField option:selected").prop("selected", false);
	$.each(services.split(","), function(i,e){  
		$("#serviceField option[value='" + e + "']").prop("selected", true);
	});
	$("#serviceField").select2();
	$('#add_affiliate_bdm_form input[name=action]').val('edit');
	$('#add_affiliate_bdm_form input[name=first_name]').val(first_name); 
    $('#add_affiliate_bdm_form input[name=last_name]').val(last_name);
    $('#add_affiliate_bdm_form input[name=email]').val(email);
	$('#add_affiliate_bdm_form input[name=phone]').val(phone); 
	$('#add_affiliate_bdm_form input[name=id]').val(id); 
    var label = 'Edit Affiliate BDM';
    if($('#affiliate_bdm_affiliate_role_info').val() == 'sub-affiliates')
    {
        label = 'Edit Sub Affiliate BDM';
    }
    $('.add_edit_affilite_bdm_title').html(label);
});

/**
*   it sets the null values in form of particular selected content checkbox with action => add.
*/ 
$('.add-user').on('click',function(e){ 
    $("#add_affiliate_bdm_form .errors").html("");
    $("#serviceField option").each(function(){
        this.selected=false;
    });
    $("#serviceField").select2();  
	$('#add_affiliate_bdm_form input[name=action]').val('add'); 
	$('#add_affiliate_bdm_form input[name=first_name]').val(''); 
    $('#add_affiliate_bdm_form input[name=last_name]').val(''); 
    $('#add_affiliate_bdm_form input[name=email]').val(''); 
	$('#add_affiliate_bdm_form input[name=phone]').val('');  
    var label = 'Add Affiliate BDM';
    if($('#affiliate_bdm_affiliate_role_info').val() == 'sub-affiliates')
    {
        label = 'Add Sub Affiliate BDM';
    }
    $('.add_edit_affilite_bdm_title').html(label);
});


/*
* Change Status 
*/
$(document).on('click','.change-status', function(e){ 
    var check = $(this);
    var id = check.attr("data-id"); 
    var isChecked = check.is(':checked');
    var status = 0;
    var title = 'Are you sure?';
    var text = 'You want to change status!';
    if(isChecked)
    {
        var status = 1;  
    }
    var formdata = new FormData();
	url = url = '/affiliates/update-affiliate-bdm-form/'+id;
    formdata.append("id", id); 
    formdata.append("status", status);
	formdata.append("update", 'status'); 
    Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function(result) {
        if (result.isConfirmed) {
            loaderInstance.show();
            axios.post(url,formdata )
            .then(function (response) {
                loaderInstance.hide();
                if(response.data.status == 400){
                    toastr.error(response.data.message);
                }else{
                    toastr.success('Status changed successfully.');
                }
            })
            .catch(function (error) {
                loaderInstance.hide();
                console.log(error);
            });
        }else{
            if (isChecked) {
                check.prop('checked', false);
            } else {
                check.prop('checked', true);
            }
        }
    });
});


function showUsersData(users,userId)
{
     
    $('#users_table_body_data').html('');
    var html = ''; 
    if (Object.keys(users).length > 0) 
    {
        $.each(users, function (key, user) 
        { 
            html += `
            <tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
                <td>1</td>
                <td> ${user.first_name} ${user.last_name}</td>
                <td>${user.email} </td> 
                <td>`;
            
            if(user.role == 2 || user.role == 3)
            {
                html += '--';
            }
            else
            {
                html += `
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input sweetalert_demo change-status" type="checkbox" value="" name="notifications" ${ user.status == 1?'checked':'' } data-id="${user.id}">
                    </div>`;
            }
            
            html += `
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon--></a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->`;
                if(user.role == 8 || user.role == 9)
                {   
                    html += `
                            <div class="menu-item px-3">
                                <a class="menu-link px-3 edit_user" data-id="${user.id}" data-first_name="${user.first_name}" data-last_name="${user.last_name}" data-phone="${user.phone}" data-email="${user.email}" data-role="${user.role}" data-service="${user.assigned_service}">Edit</a>
                            </div>`;
                }
                
                html+=`
                        <div class="menu-item px-3">`; 
                if($('#affiliate_role_info').val() == 'sub-affiliates')
                {
                    html +=  
                        `<a href="/affiliates/sub-affiliates/affiliate-bdm-permissions/${userId}/${user.id}" class="menu-link px-3" >Assign Permissions</a>`;
                }
                else
                {
                    html +=  
                        `<a href="/affiliates/affiliate-bdm-permissions/${userId}/${user.id}" class="menu-link px-3" >Permissions</a>`;
                }

                html+= `
                        </div> 
                    </div> 
                    <!--end::Menu-->
                </td>
            </tr>`; 
            });
        }
    else
    {
        html = `<tr>
            <td class="text-center" colspan="5">
                No user found.
            </td>
        </tr>`;
    }  
    $('.affiliateBdmUsers').html(html);
    KTMenu.createInstances();
}
</script>
@include('pages.affiliates.affsettings.components.tags.js');
@include('pages.affiliates.affsettings.components.matrix.js');
@include('pages.affiliates.affsettings.components.lifesupport.js');
@include('pages.affiliates.affsettings.components.retention.js');
