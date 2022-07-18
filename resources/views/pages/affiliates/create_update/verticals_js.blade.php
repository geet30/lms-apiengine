<script>
    /*
     * start intialize flatpicker 
     */
    var signupPopupStatus=0;
    var leadPopupNameStatus=0;
    var leadPopupEmailStatus=0;
    var leadPopupPhoneStatus=0;
    
    if($('.signup_popup_class').is(':checked')){
        if($('.lead_popup_name_required').is(':checked')){
            $('.lead_popup_name').hide();
        }
        if($('.lead_popup_email_required').is(':checked')){
            $('.lead_popup_email').hide();
        }
        if($('.lead_popup_phone_required').is(':checked')){
            $('.lead_popup_phone').hide();
        }
     }else{
        $('.showOnSignupPopup').hide();
     }
     if($('.lead_popup_name_enabled').is(':checked')){
        $('.lead_popup_name_required_main').show();
     }else{
        $('.lead_popup_name_required_main').hide();
     }
     if($('.lead_popup_email_enabled').is(':checked')){
        $('.lead_popup_email_required_main').show();
     }else{
        $('.lead_popup_email_required_main').hide();
     }
     if($('.lead_popup_phone_enabled').is(':checked')){
        $('.lead_popup_phone_required_main').show();
     }else{
        $('.lead_popup_phone_required_main').hide();
     }

     $('.lead_popup_name_enabled , .lead_popup_email_enabled , .lead_popup_phone_enabled' ).on('change',function(){
        if($('.lead_popup_name_enabled').is(':checked')==false && $('.lead_popup_email_enabled').is(':checked')==false && $('.lead_popup_phone_enabled').is(':checked')==false ){
            $('.signup_popup_class').trigger('click');
        }
     });
   

    $("#restrict_start_time").flatpickr({
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        dateFormat: "H:i",
        defaultMinute: 5

    });
    $("#restrict_end_time").flatpickr({
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        dateFormat: "H:i",
        defaultMinute: 5


    });
    /*
     * end intialize flatpicker 
     */
    /*
     * Change Status 
     */
    $(document).on('click', '.verticalStatus', function(e) {
        var check = $(this);
        var id = check.attr("data-status");
        var url = '/affiliates/vertical-status';
        var isChecked = check.is(':checked');
        if (check.is(':checked'))
            var status = 1;
        else
            var status = 2;

        var formdata = new FormData();
        formdata.append("id", id);
        formdata.append("status", status);
        Swal.fire({
            title: "{{trans('affiliates.warning_msg_title')}}",
            text: "{{trans('affiliates.warning_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('affiliates.yes_text')}}",
        }).then(function(result) {
            if (result.isConfirmed) {
                axios.post(url, formdata)
                    .then(function(response) {
                        if (response.data.status == 400) {
                            if (isChecked) {
                                check.prop('checked', false);
                            } else {
                                check.prop('checked', true);
                            }
                            toastr.error(response.data.message);
                        } else {
                            toastr.success(response.data.message);
                        }

                    })
                    .catch(function(error) {
                        console.log(error);
                    })
                    .then(function() {

                    });
            } else {
                if (isChecked) {
                    check.prop('checked', false);
                } else {
                    check.prop('checked', true);
                }
            }
        });
    });

    $(document).on('click', '.submitVertical', function(e) {
        event.preventDefault();
        let submitButton = $(this);
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true)
        var url = '/affiliates/store-vertical-services';
        var formdata = new FormData();
        formdata.append("service", $('#service').val());
        formdata.append("id", $('.affiliate_user_id').val());
        formdata.append("type", $('.request_form').val());
        axios.post(url, formdata)
            .then(function(response) {
                $(".error").html("");
                if (response.data.status == 400) {
                    toastr.error(response.data.message);
                } else {
                    toastr.success(response.data.message);
                    $('#service').select2({
                        placeholder: "Select Service",
                        allowClear: true
                    });


                    $('#service').empty();
                    var services = ``;
                    if (response.data.result.services.length > 0) {
                        services += `<option value="select_all">{{ __('Select All') }}</option>`;
                    }

                    $.each(response.data.result.services, function(key, val) {
                        services += `<option value="${val.id}">${val.service_title}</option>`;
                    });

                    $('#service').append(services);


                    $('#verticalListing').empty();
                    var verticals = '';
                    $.each(response.data.result.data, function(key, val) {
                        const splitDate = val.created.split(" ");
                        var convertdateformat = dateFormat(splitDate[0], 'dd-MM-yyyy');
                        var newdate = convertdateformat+" "+splitDate[1];
                        
                        checked = '';
                        if (val.status == 1) {
                            checked = 'checked';
                        }
                        verticals += `
                    <tr>
                    <td>${val.title}</td>
                    <td>${val.name}</td>
                    <td>
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input verticalStatus" type="checkbox" ${checked}  name="notifications"  data-status="${val.id}">
                    </div>
                    </td>
                    <td>${newdate}</td>
                    <td>
                        <a class="deletevertical" data-id="${val.id}" data-service="${val.service_id}" title="Delete" style="cursor:pointer">
                            <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                        </a>
                        <a title="Setting" class="editparameter" data-service="${val.service_id}" style="cursor:pointer">
                        <i class="bi bi-gear fs-2 mx-1 text-primary"></i>
                    </a>
                    </td>
                    <tr>
                    `;
                    });
                    $('#verticalListing').append(verticals);
                }
            })
            .catch(function(error) {
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });

                } else if (error.response.status == 400) {
                    console.log(error.response);
                }
            })
            .then(function() {
                submitButton.attr('data-kt-indicator', 'off');
                submitButton.prop('disabled', false);
                // always executed
            });

    });


    $(document).on('click', '.deletevertical', function(e) {
        var url = '/affiliates/delete-vertical';
        var closet = $(this);
        var formdata = new FormData();
        formdata.append("rowid", closet.attr('data-id'));
        formdata.append("type", $('.request_form').val());
        formdata.append("id", $('.affiliate_user_id').val());
        formdata.append("service", closet.attr('data-service'));
        Swal.fire({
            title: "{{trans('affiliates.warning_msg_title')}}",
            text: "{{trans('affiliates.delete_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('affiliates.yes_text')}}",
        }).then(function(result) {
            if (result.isConfirmed) {
                axios.post(url, formdata)
                    .then(function(response) {

                        if (response.data.status == 400) {
                            toastr.error(response.data.message);
                        } else {
                            toastr.success(response.data.message);
                            closet.closest('tr').remove();

                            $('#service').empty();
                            var services = ``;
                            if (response.data.services.length > 0) {
                                services += `<option value="select_all">{{ __('Select All') }}</option>`;
                            }
                            $.each(response.data.services, function(key, val) {
                                services += `<option value="${val.id}">${val.service_title}</option>`;
                            });
                            $('#service').append(services);

                        }

                    })
                    .catch(function(error) {
                        console.log(error);
                    })
                    .then(function() {

                    });
            }
        });

    });

    /*
     * popup show
    */
    $(document).on('click', '.editparameter', function(e) {
        e.preventDefault();
        $('.popclass').val('');
        $('.paramservice').val($(this).data('service'));
        var url = '/affiliates/getserviceparameter';
        var formdata = new FormData();
        formdata.append("service", $(this).data('service'));
        formdata.append("userid", $('.affiliate_user_id').val());
        axios.post(url, formdata)
        .then(function (response) {
            if(response.data.length > 0) {
                $('.planlistingval').val(response.data[0].plan_listing);
                $('.plandetailval').val(response.data[0].plan_detail);
                $('.remarketingval').val(response.data[0].remarketing);
                $('.slugval').val(response.data[0].slug);
                $('.termsval').val(response.data[0].terms);
                $('.paramid').val(response.data[0].id);
                $('.journeyval').val(response.data[0].journey.journey_order);
            }
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
            // always executed
        });

        var myModal = new bootstrap.Modal(document.getElementById("paramterpopup"), {});
        myModal.show();
    });


    $(document).on('submit', '.submitparamter', function(e) {
        e.preventDefault();
        let submitButton = $(this).find('.parameter_button');
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true)
        var url = '/affiliates/updateparameters';
        var formData = new FormData($(this)[0]);
        formData.append('request_from', $(this).closest('form').attr('name'));
        axios.post(url, formData)
            .then(function (response) {
                $(".error").html("");
                if(response.data.status == 200){
                    toastr.success(response.data.message);
                    var myModalEl = document.getElementById('paramterpopup');
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                }else{
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                    
                }
            })
            .then(function () {
                submitButton.attr('data-kt-indicator', 'off');
                submitButton.prop('disabled', false);
                // always executed
            });
    });


    var number = document.getElementById('journeyinput');
    // Listen for input event on numInput.
    number.onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58) 
        || e.keyCode == 8)) {
            return false;
        }
    }

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
    $(document).on('click', '#affiliate_plan_type', function(e) {
      
       
        var myModal = new bootstrap.Modal(document.getElementById("planTypePopup"), {});
        myModal.show();
    });

    $(document).on('submit', '#submit_plan_type_form , #lead_signup_form , #submit_connection_type_form', function(e) {
        e.preventDefault();
        var url = '/affiliates/updateplantype';
        var formData = new FormData($(this)[0]);
        formData.append('request_from', $(this).closest('form').attr('name'));
        axios.post(url, formData)
            .then(function (response) {
                $(".error").html("");
                if(response.data.status == 200){
                    toastr.success(response.data.message);
                    var myModalEl = document.getElementById('planTypePopup');
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                }else{
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('.'+key+'_error').empty().addClass(
                            'text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                } else if (error.response.status == 400) {

                    toastr.error(error.response.message);
                }
            });
    });
    
    $('.signup_popup_class').on('change', function(){
        $('.error').empty().text('');
        if($(this).is(':checked')){
            signupPopupStatus=1;
            $('.showOnSignupPopup').show();
            if($('.lead_popup_name_enabled ').is(':checked') && $('.lead_popup_name_required').is(':checked')){
                $('.lead_popup_name').hide();
            }else{
                $('.lead_popup_name').show();
            }
            if($('.lead_popup_email_enabled').is(':checked')  && $('.lead_popup_email_required').is(':checked')){
                $('.lead_popup_email').hide();
            }
            else{
                $('.lead_popup_email').show();
            }
            if($('.lead_popup_phone_enabled ').is(':checked') && $('.lead_popup_phone_required').is(':checked')){
                $('.lead_popup_phone').hide();
            }
            else{
                $('.lead_popup_phone').show();
            }
           
        }else{
            if($('.lead_popup_name_enabled').is(':checked')){
                $('.lead_popup_name_enabled').trigger('click');
            } 
             if($('.lead_popup_email_enabled').is(':checked')){
                $('.lead_popup_email_enabled').trigger('click');
            }  
            if($('.lead_popup_phone_enabled').is(':checked')){
                $('.lead_popup_phone_enabled').trigger('click');
            }
            if($('.lead_popup_name_required').is(':checked')){
                $('.lead_popup_name_required').trigger('click');
            } 
            if($('.lead_popup_email_required').is(':checked')){
                $('.lead_popup_email_required').trigger('click');
            }
            if($('.lead_popup_phone_required').is(':checked')){
                $('.lead_popup_phone_required').trigger('click');
            }
           
            $('.showOnSignupPopup').hide();
            signupPopupStatus=!signupPopupStatus;
            
            $('.lead_popup_name').show();
            $('.lead_popup_email').show();
            $('.lead_popup_phone').show();
        }
    });
    $('.lead_popup_phone_required').on('change',function(){
        $('.error').empty().text('');
        if($(this).is(':checked')){
            leadPopupPhoneStatus=1;
            $('.lead_popup_phone').hide();
            $('.lead_popup_phone').val('');
        }else{
            $('.lead_popup_phone').show();
            leadPopupPhoneStatus=!leadPopupPhoneStatus;
        }
    });
    $('.lead_popup_email_required').on('change',function(){
        $('.error').empty().text('');
        if($(this).is(':checked')){
            leadPopupEmailStatus=1;
            $('.lead_popup_email').hide();
            $('.lead_popup_email').val('');
        }else{
            $('.lead_popup_email').show();
            leadPopupEmailStatus=!leadPopupEmailStatus;
        }
       
    });
    $('.lead_popup_name_required').on('change',function(){
        $('.error').empty().text('');
        if($(this).is(':checked')){
            leadPopupNameStatus=1;
            $('.lead_popup_name').hide();
            $('.lead_popup_name').val('');
        }else{
            $('.lead_popup_name').show();
            leadPopupNameStatus=!leadPopupNameStatus;
        }
    });
    $('.lead_popup_name_enabled').on('change',function(){
        $('.error').empty().text('');
        $('.lead_popup_name').show();
        if($(this).is(':checked')){
            $('.lead_popup_name_required_main').show();
            if($('.lead_popup_name_required').is(':checked')){
                $('.lead_popup_name').hide();
            }else{
                    $('.lead_popup_name').show();
            }
            
        }else{
            
            $('.lead_popup_name_required_main').hide();
           
        }
       
    });
    $('.lead_popup_email_enabled').on('change',function(){
        $('.error').empty().text('');
        $('.lead_popup_email').show();
        if($(this).is(':checked')){
            $('.lead_popup_email_required_main').show();
            if($('.lead_popup_email_required').is(':checked')){
                $('.lead_popup_email').hide();
            }else{
                    $('.lead_popup_email').show();
            }
        }else{
            $('.lead_popup_email_required_main').hide();
        }
        
    });
    $('.lead_popup_phone_enabled').on('change',function(){
        $('.error').empty().text('');
        $('.lead_popup_phone').show();
        if($(this).is(':checked')){
            $('.lead_popup_phone_required_main').show();
            if($('.lead_popup_phone_required').is(':checked')){
                $('.lead_popup_phone').hide();
        }else{
                $('.lead_popup_phone').show();
        }
        }else{
            $('.lead_popup_phone_required_main').hide();
        }
       
    });
    
    
   
</script>