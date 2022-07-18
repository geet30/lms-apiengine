jQuery(document).ready(function () {
   

    /** Affiliate Email Template work start here **/
    $('#filter_emai_sms_button').click(function (e) {
        e.preventDefault();
        getEmailSmsData();
    });

    /***START***/
    $("#select_source,#select_email_type,#select_welcome_email_type").change(function (e) {
        e.preventDefault();
        if (this.id == 'select_source') {
            if ($(this).val() == "1" && $("#select_email_type").val() == "3") {
                $(`select[name^="select_source"] option[value="2"]`).prop("selected", true);
            }
            else if ($(this).val() == "2" && $("#select_email_type").val() == "4") {
                $(`select[name^="select_source"] option[value="1"]`).prop("selected", true);
            }
            else if ($(this).val() == "1") {
                $('#select_email_type option[value="3"]').prop('disabled', true);
                $('#select_email_type option[value="4"]').prop('disabled', false);
            }
            else if ($(this).val() == "2") {
                $('#select_email_type option[value="4"]').prop('disabled', true);
                $('#select_email_type option[value="3"]').prop('disabled', false);
            }
        }

        templateType = templatType();
        change_url = geturl + "/" + $("#select_source").val() + "/" + $("#select_email_type").val() + "/" + $("#select_welcome_email_type").val() + "/" + templateType;
        $("#change_url").attr("href", change_url);
    });
    $(document).on('change', '#template_type_energy', function (event) {
        change_url = geturl + "/" + $("#select_source").val() + "/" + $("#select_email_type").val() + "/" + $("#select_welcome_email_type").val() + "/" + $(this).val();
        $("#change_url").attr("href", change_url);
    });
    /**END**/
    /**start */
    function templatType() {
        var templateType = 0;
        if (($("#select_source").val() == "1") && (($("#select_email_type").val() == "1") || ($("#select_email_type").val() == "4"))) {
            let energy = `
                    <option value="1">Electricity Only</option>
                    <option value="2">Gas Only</option>
                    <option value="3">Electricity and Gas from different retailer</option>
                    <option value="4">Electricity and Gas from same retailer</option>
            `;
            let mobile = `
                    <option value="5">Sim</option>
                    <option value="6">Sim+Mobile</option>
            `;
            $("#template_type_energy").html('');
            if ($("#select_welcome_email_type").val() == "1") {
                $("#template_type_energy").append(energy);
                $("#template_type_energy").show();
                templateType = $("#template_type_energy").val();
            } else if ($("#select_welcome_email_type").val() == "2") {
                $("#template_type_energy").append(mobile);
                $("#template_type_energy").show();
                templateType = $("#template_type_energy").val();
            } else {
                $("#template_type_energy").html('');
                $("#template_type_energy").hide();
                templateType = 0;
            }
        } else {
            $("#template_type_energy").html('');
            $("#template_type_energy").hide();
            templateType = 0;
        }
        return templateType;
    }
    /**End */
    $("input[name='interval']").keyup(function () {
        var days = $(this).val();
        if (days > 0) {
            $(".instant_option").hide();
            $("#interval_day_time").show();
        }
        if (days == 0) {
            $(".instant_option").show();
            $("#interval_day_time").hide();
        }
        if (days == "") {
            $("#interval_day_time").hide();
            $(".instant_option").hide();
        }

    });

    /** Start**/
    const breadArray = [{
        title: 'Dashboard',
        link: '/',
        active: false
    },];
 



    check = document.getElementById('affiliate_template_filters');

    if (check !== null) {
        data = $("#select_welcome_email_type").val();
        if (data) {
            templateType = templatType();
            getEmailSmsData('initalize');
            add_url = geturl + "/" + $("#select_source").val() + "/" + $("#select_email_type").val() + "/" + $("#select_welcome_email_type").val() + "/" + templateType;
            $("#change_url").attr("href", add_url);
            let select_email_type = $("#select_email_type").val();
            if(!select_email_type){
                $("#filter_emai_sms_button").prop('disabled', true);
                $("#change_url").prop('disabled', true);
                $(".show_error").html("Please assign permission to this email type").css({ 'color': 'red' });  
            }

        } else {
            $("#filter_emai_sms_button").prop('disabled', true);
            $("#change_url").prop('disabled', true);
            toastr.error("Please add services for this affiliates");
            $(".show_error").html("Please assign service to this affiliate").css({ 'color': 'red' });
        }
        breadArray.push(
            {
                title: 'Affiliates',
                link: '/affiliates/list',
                active: false
            }, 
            {
                title: affiliate_name,
                link: '#',
                active: false
            },
            {
                title: "Templates",
                link: '#',
                active: true
            },
            {
                title: "Listing",
                link: '#',
                active: true
            }
        );


    } else {

        breadArray.push({
            title: 'Affiliates',
            link: '/affiliates/list',
            active: false
        },
        {
            title: affiliate_name,
            link: '#',
            active: false
        },
        {
            title: "Templates",
            link: '#',
            active: true
        },
         {
            title: "Listing",
            link: link,
            active: false
        }, {
            title: titleVal,
            link: '#',
            active: true
        });
        var currentdates = new Date();
        $("#remarketing_time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            defaultHour: currentdates.getHours(),
            defaultMinute: 5
        });
        $("#delay_time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minTime: "00:00",
            maxTime: "02:00",
        });
        if ($("#interval").val() != '0') {
            $(".instant_option").hide();
        } else {
            $("#interval_day_time").hide();

        }
        if ($("#interval").val() == '0') {
            $(".instant_option").show();
        }
        if ($("input[name='select_remarketing_type']:checked").val() == 1) {
            $(".move_in_customers").show();
        } else {
            $(".move_in_customers").hide();
        }
        senderIdMethod = $("input[name='sender_id_method']:checked").val();
        if (senderIdMethod == 1) {
            $(".sender_custom_id").hide();
            $(".sender_plivo").hide();
        } else if (senderIdMethod == 2) {
            $(".sender_custom_id").show();
            $(".sender_plivo").hide();
        } else if (senderIdMethod == 3) {
            $(".sender_custom_id").hide();
            $(".sender_plivo").show();
        }
        source_type = $("input[name='source_type']:checked").val();
        if (source_type == 1) {
            $(".branding_url").hide();
        } else {
            $(".branding_url").show();
        }
    }
    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();
    $(document).on("click", ".url_short", function (event) {
        source_type = $("input[name='source_type']:checked").val();
        if (source_type == 1) {
            $(".branding_url").hide();
        } else {
            $(".branding_url").show();
        }
    });

    $(document).on("click", "#instant", function (event) {
        if ($(this).prop("checked") == true) {
            $("#delay_time").prop('disabled', true);
        }
        else if ($(this).prop("checked") == false) {
            $("#delay_time").prop('disabled', false);
        }

    });

    $(document).on("click", ".normal_movin", function (event) {

        if ($("input[name='select_remarketing_type']:checked").val() == 1) {
            $(".move_in_customers").show();
            $(".interval_text").html("Days Interval");
        } else {
            $(".move_in_customers").hide();
            $(".interval_text").html("Days Interval(Before Move Date)");

        }
    });


    $(document).on('click', "#affiliate_subject_parameter", function (event) {
        $("span.error").fadeOut("slow");
        textarea = document.getElementById('ckeditor_content');
        insertAtCaret(textarea, $(this).val());
    });


    /**Start add or edit template**/
    $(document).on('submit', "#affilate_email_sms_template", function (event) {
        event.preventDefault();
        //loaderInstance.show();
        let submitButton = $(this).find('#add_edit_affiliate_button');
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true)
        var formData = new FormData($(this)[0]);
        var url = '/affiliates/saveUpdateEmailTemplate';
        axios.post(url, formData).then((response) => {
            loaderInstance.hide();
            if (response.data.status == 200) {
                setTimeout(() => {
                    window.location.href = response.data.url;
                }, 1000);
                toastr.success("Data has been saved successfully");
            } else {
                toastr.error("Something went wrong");
            }
        }).catch((error) => {
            loaderInstance.hide();
            if (error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function (key, value) {
                    $('.' + key).find('span.error').empty().text(value).finish().fadeIn();
                });
                $('html, body').animate({
                    scrollTop: ($('.error.text-danger').offset().top - 300)
                }, 1000);
            }
        }).then(function () {
            submitButton.attr('data-kt-indicator', 'off');
            submitButton.prop('disabled', false);
            // always executed
        });;
    });


    /**End add or edit template**/
    /**Start remove errors**/
    $(document).on("click", "input", function (event) {
        $("span.error").fadeOut("slow");
    });
    /**End remover error**/
    /** Start Remove template **/
    $(document).on("click", ".remove_template", function (event) {
        var id = $(this).attr("data-id");
        var this_data = this;
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this template!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                var formdata = new FormData();
                formdata.append("id", id);
                url = "/affiliates/delete_template";
                axios.post(url, formdata).then((response) => {
                    if (response.data.status == 200) {
                        dataTable.row($(this_data).parentsUntil('tr.first')).remove().draw();
                        toastr.success(response.data.message);

                    } else {
                        toastr.success(response.data.message);

                    }

                }).catch((error) => {

                    toastr.error("Something went wrong");
                })
            }

        });

    });
    /** End Remove template **/

    /** start change status */
    $(document).on("click", ".status_change", function (event) {
        var check = $(this);
        var url = '/affiliates/template-email-status';
        var isChecked = check.is(':checked');
        var status = [];
        if (check.is(':checked')) {
            status = 1;
        }
        else {
            status = 0;
        }
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change status!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                var formData = new FormData();
                type = check.attr("data-type");
                emailType = check.attr("data-email_type");
                interval = check.attr("data-interval");
                formData.append("id", check.attr("data-id"));
                formData.append("status", status);
                formData.append("type", type);
                formData.append("email_type", emailType);
                formData.append('user_id', $("#users_id").val());
                formData.append('service_id', check.attr("data-service_id"));
                formData.append('template_type', check.attr("data-template_type"));
                if (emailType == '2') {
                    formData.append('interval', interval);
                }
                axios.post(url, formData).then((response) => {
                    if (response.data.status == 200) {
                        if (type == 1 && (emailType == 1 || emailType == 4)) {
                            cell = $(check).parentsUntil('tr').parent().siblings('tr');
                            for (i = 0; i < cell.length; i++) {
                                $(cell[i]).find('.status_change').prop('checked', false);
                            }
                        }
                        if (emailType == 2 && status == 1) {
                            cell = $(check).parentsUntil('tr').parent().siblings('tr');
                            for (i = 0; i < cell.length; i++) {
                                if ($(cell[i]).find('.change_interval').text() == interval) {
                                    $(cell[i]).find('.status_change').prop('checked', false);
                                }

                            }

                        }
                        toastr.success(response.data.message);
                    } else {
                        toastr.success(response.data.message);
                    }

                }).catch((error) => {
                    console.log(error);
                    toastr.error("Something went wrong");
                })

            } else {
                if (isChecked) {

                    check.prop('checked', false);
                } else {

                    check.prop('checked', true);
                }
            }
        });
    });
    /** End change status*/



    function getEmailSmsData(check) {
        let myForm = document.getElementById('affiliate_template_filters');
        let formData = new FormData(myForm);
        var sourceType = $("#select_source").val();
        var emailType = $("#select_email_type").val();
        let templateType = $("#template_type_energy").val();
        let services = $("#select_welcome_email_type").val();
        url = '/affiliates/get_email_sms_template_data'
        axios.post(url, formData).then((response) => {
            if (check != "initalize") {
                dataTable.destroy(false);
                $("#affilate_email_template_table").empty();
                $("#affilate_email_template_table").append(`<thead id="email_sms_list_head">
                  </thead>
                    <tbody class="text-gray-700" id="email_sms_list_body">
                    </tbody>`
                );
                KTMenu.createInstances();
            }
            setHtmlHeadTable(sourceType, emailType, services);
            //console.log(response.data);
            //  a = JSON.parse(response.data, true);
            // console.log('ttt');
            console.log(response.data.data.length);
            for (var i = 0; i < response.data.data.length; i++) {
                setHtmlBodyTable(response.data.data[i]);
            }
            
            KTMenu.createInstances();
            
            if (check == "initalize") {
                dataTable = $("#affilate_email_template_table").DataTable({
                    searching: true,
                    "sDom": "tipr",
                    "pageLength": 10
                });
            } else {
                dataTable = $("#affilate_email_template_table").DataTable({
                    searching: true,
                    "sDom": "tipr",
                    "pageLength": 10
                });


            }
            if (response.data.data.length == 0) {
                $('.dataTables_info').hide();
            }

        }).catch((error) => {

        })
    }
    var dataTable;

    function setHtmlBodyTable(data) {
        var emailType = 'Welcome';
        if (data.email_type == 1) {
            emailType = "Welcome";
        }
        else if (data.email_type == 2) {
            emailType = "Remarketing";
        }
        else if (data.email_type == 3) {
            emailType = "2-way-Confirmation";
        }
        else if (data.email_type == 4) {
            emailType = "Send Plan";
        }
        common_head = `<tr>
               <td>
                 <span>${data.type == 1 ? 'Email' : 'Sms'}</span>
                </td>
                <td>
                <span>${emailType}</span>
                </td>
             `;
        common_footer = `<td>
                 <span>${data.template_name}</span>
                </td>
                    <td>
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input sweetalert_demo status_change" data-service_id="${data.service_id}" data-id="${data.id}" data-interval="${data.interval}" type="checkbox" value="${data.status}" name="notifications" data-type=${data.type} data-template_type="${data.template_type}" data-email_type=${data.email_type}
                        ${data.status == 1 ? "checked" : ""}>
                    </div>
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary px-4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item ">
                            <a href="{{ url('/affiliates/templates/preview/1'.$url_parameter) }}" class="menu-link  ">Preview</a>
                        </div>
                        <div class="menu-item ">
                            <a href="/affiliates/edit-template/${$('#users_id').val()}/${data.id}" class="menu-link  ">Edit</a>
                        </div>
                        <div class="menu-item " >
                            <span class="menu-link remove_template" data-id="${data.id}" >Delete</span>
                        </div>
                    </div>
                </td>
            </tr>`;
        body = null;
        if (data.type == 1 && (data.email_type == 1 || data.email_type == 4)) {
            if (data.template_type == 1) {
                body = `<td><span>Electricity Only</span></td>`;
            } else if (data.template_type == 2) {
                body = `<td><span>Gas Only</span></td>`;
            } else if (data.template_type == 3) {
                body = `<td><span>Electricity and Gas from different retailer</span></td>`;
            } else if (data.template_type == 4) {
                body = `<td><span>Electricity and Gas from same retailer</span></td>`;
            } else if (data.template_type == 5) {
                body = `<td><span>Mobile</span></td>`;
            } else if (data.template_type == 6) {
                body = `<td><span>Mobile+Sim</span></td>`;
            }

        }
        if (data.type == 1 && data.email_type == 2) {
            console.log('data');console.log(data);
            body = `<td><span>${data.from_name}</span></td>
                <td><span>${data.from_email}</span></td>
                <td><span>${data.ip_pool}</span></td>
                <td><span>${data.sending_domain != null ? data.sending_domain : 'Default Bounce Domain'}</span></td>
                <td><span>${data.subject}</span></td>
                <td><span>${data.subject}</span></td>
                <td><span>${data.select_remarketing_type == 1 ? 'Normal' : 'Move In'}</span></td>
                <td><span class="change_interval">${data.interval}</span></td>
                `;
        }
        if (data.type == 2 && data.email_type == 1) {
            body = ``;
        }
        if (data.type == 2 && data.email_type == 2) {
            body = `
            <td><span>${data.select_remarketing_type == 1 ? 'Normal' : 'Move In'}</span></td>
            <td><span>${data.source_type == 1 ? 'Bitly' : 'Rebrandly'}</span></td>
            <td><span class="change_interval">${data.interval}</span></td>`;
        }
        if (data.type == 2 && data.email_type == 3) {
            body = `<td><span>${data.target_type == 1 ? "Lead" : "Sale"}</span></td>
            <td><span>${data.source_type == 1 ? 'Bitly' : 'Rebrandly'}</span></td>
            <td><span>${data.sender_id}</span></td>`;
        }
        $("#email_sms_list_body").append(`
                ${common_head}
                ${body}
                ${common_footer}`);

    }

    function setHtmlHeadTable(sourceType, emailType, services) {
        var common_head = `<tr class="text-start text-gray-500 fw-bolder fs-7 text-uppercase gs-0">
                 <th style="text-transform: capitalize !important;">Source Type</th>
                 <th>${sourceType == 1 ? "Email" : "Sms"} Type</th>`;
        var common_foorter = `<th>Template Name</th>
                 <th>Status</th>
                 <th>Actions</th></tr>`;
        var body = ``;
        if (sourceType == 1 && (services == 1 || services == 2) && (emailType == 1 || emailType == 4)) {

            if (emailType == 1) {
                body = `<th>Welcome Email Type</th>`;
            } else if (emailType == 4) {
                body = `<th>Send Plan Email Type</th>`;
            }
        }
        if (sourceType == 1 && emailType == 2) {
            body = `
                <th>From Name</th>
                 <th>From Email</th>
                 <th>IP Pool</th>
                 <th>Bounce Domain</th>
                 <th>Subject</th>
                 <th>Time</th>
                 <th>Remarketing Type</th>
                 <th>Days interval</th>`;
        }
        if (sourceType == 2 && emailType == 1) {
            body = ``;
        }
        if (sourceType == 2 && emailType == 2) {
            body = `
            <th>Remarketing Type</th>
            <th>SMS Source Type</th>
            <th>Days interval</th>`;
        }
        if (sourceType == 2 && emailType == 3) {
            body = `<th>2-way Confirmation SMS Type</th>
            <th>SMS Source Type</th>
            <th>Sender ID</th>`;
        }
        $("#email_sms_list_head").append(`
                ${common_head}
                ${body};
                ${common_foorter}`);
    }



    /** Affiliate Email Template work end here **/


    $(document).on('click', 'input[name="sender_id_method"]', function (event) {
        var value = $("input[name='sender_id_method']:checked").val();
        if (value == 1) {
            $(".sender_custom_id").hide();
            $(".sender_plivo").hide();
        } if (value == 2) {
            $(".sender_custom_id").show();
            $(".sender_plivo").hide();
        } if (value == 3) {
            $(".sender_custom_id").hide();
            $(".sender_plivo").show();
        }
    });

    $(document).on('click', ".reset-button", function () {
        let energy = `
                    <option value="1">Electricity Only</option>
                    <option value="2">Gas Only</option>
                    <option value="3">Electricity and Gas from different retailer</option>
                    <option value="4">Electricity and Gas from same retailer</option>
            `;
        $("#template_type_energy").html(energy).show();
        let source = $("#select_source").find("option:first-child").val();
        $("#select_source").val(source).change();
        let email_type = $("#select_email_type").find("option:first-child").val();
        $("#select_email_type").val(email_type).change();
        let select_welcome_email_type = $("#select_welcome_email_type").find("option:first-child").val();
        $("#select_welcome_email_type").val(select_welcome_email_type).change();
        templateType = $("#template_type_energy").val();
        change_url = geturl + "/" + $("#select_source").val() + "/" + $("#select_email_type").val() + "/" + $("#select_welcome_email_type").val() + "/" + templateType;
        $("#change_url").attr("href", change_url);
        getEmailSmsData();
    });

});

function insertAtCaret(txtarea, text) {
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
        "ff" : (document.selection ? "ie" : false));
    if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart('character', -txtarea.value.length);
        strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;

    var front = (txtarea.value).substring(0, strPos);
    var back = (txtarea.value).substring(strPos, txtarea.value.length);
    txtarea.value = front + text + back;
    strPos = strPos + text.length;
    if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart('character', -txtarea.value.length);
        range.moveStart('character', strPos);
        range.moveEnd('character', 0);
        range.select();
    }
    else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}

