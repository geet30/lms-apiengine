jQuery(document).ready(function () {
    var pageNumber = 2, processing = false;

    $('.move_in').click(function () {
        $('.move_in_customers').hide();
    });

    $('.move_in_normal').click(function () {
        $('.move_in_customers').show();
    });

    //
    $('#filter_button').click(function (e) {
        e.preventDefault();
        let url;
        if ($("#select_source").val() == "email") {
            url = geturl;
        } else {
            url = smsurl;
        }

        change_url = url + "/" + $("#select_source").val() + "/" + $("#select_email_type").val() + "/" + $("#select_welcome_email_type").val();
        base_url = index_url + "/" + $("#select_source").val() + "/" + $("#select_email_type").val() + "/" + $("#select_welcome_email_type").val();
        $("#change_url").attr("href", change_url);
        location.replace(base_url);
    });

    $('#bitly').click(function () {
        $('.branding_url').hide();
    });

    $('#rebrandly').click(function () {
        $('.branding_url').show();
    });

    $('.move_in_radio').click(function () {
        $('.move_in_customers').hide();
    });

    $('.normal_radio').click(function () {
        $('.move_in_customers').show();
    });

    $('#interval_day_time').hide();

    $("input[name='interval']").keyup(function () {
        var days = $(this).val();
        if (days > 0) {
            $("#instant_option").hide();
            $("#interval_day_time").show();
        } else {
            $("#interval_day_time").hide();
            $("#instant_option").show();
        }
    });

    /*
     * Common function for add and update affiliate
    */
    $(document).on('submit', '.affiliate_basic_detail_form,.affiliate_logo_form,.affiliate_social_links_form,.affiliate_additional_feature_form,.affiliate_spark_post_feature_form,.affiliate_life_support_content_form', function (event) {
        event.preventDefault();
        let submitButton = $(this).find('.submit_button');
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true)

        var id = $('.affiliate_user_id').val();

        if (id.length === 0) {
            var url = '/affiliates/store';
        } else {
            var url = '/affiliates/update/' + id;
        }

        var formData = new FormData($(this)[0]);
        var that = $(this);
        formData.append('request_from', that.closest('form').attr('name'));
        axios.post(url, formData)
            .then(function (response) {
                $(".error").html("");
                if (response.data.status == 400) {
                    toastr.error(response.data.message);
                } else {
                    if (response.data.message == 'Sub-Affiliate Added successfully' || response.data.message == 'Sub-Affiliate Update successfully') {
                        toastr.success(response.data.message);
                        setTimeout(function () {
                            window.location = '/affiliates/sub-affiliates/edit/' + response.data.data.id;
                        }, 1000);
                    } else {
                        toastr.success(response.data.message);
                        if(that.closest('form').attr('name') == 'affiliate_social_links_form' || that.closest('form').attr('name') == 'affiliate_additional_feature_form'){

                        }else{
                            setTimeout(function () {
                                window.location = '/affiliates/edit/' + response.data.data.id;
                            }, 1000);
                        }
                    }
                }

            })
            .catch(function (error) {
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                }
                else if (error.response.status == 400) {
                    console.log(error.response);
                }
            })
            .then(function () {
                submitButton.attr('data-kt-indicator', 'off');
                submitButton.prop('disabled', false);
                // always executed
            });
    });



    /*
     * Change Status
    */
    $(document).on('click', '.change-status', function (e) {
        CardLoaderInstance.show('#affiliate_table');
        var check = $(this);
        var id = check.attr("data-status");
        var url = '/affiliates/status';
        var isChecked = check.is(':checked');
        if (check.is(':checked'))
            var status = 1;
        else
            var status = 0;

        var formdata = new FormData();
        formdata.append("id", id);
        formdata.append("status", status);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change status!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                axios.post(url, formdata)
                    .then(function (response) {
                        CardLoaderInstance.hide();
                        if (response.data.status == 400) {
                            check.prop('checked', !status);
                            toastr.error(response.data.message);
                        } else {
                            toastr.success(response.data.message);
                        }

                    })
                    .catch(function (error) {
                        console.log(error);
                        CardLoaderInstance.hide();
                    })
                    .then(function () {
                        CardLoaderInstance.hide();
                    });
            } else {
                CardLoaderInstance.hide();
                if (isChecked) {
                    check.prop('checked', false);
                } else {
                    check.prop('checked', true);
                }
            }
        });
    });

    $('#apply_affiliate_filters').click(function (e) {
        e.preventDefault();
        pageNumber = 1;
        getFilterData();
    });

    function getFilterData(type) {
        processing = true;
        var sub = '';
        let myForm = document.getElementById('affiliate_filters');
        let filterType = $('#affiliate_filters').attr('name');
        let formData = new FormData(myForm);
        formData.append('request_from', filterType);
        if(filterType == 'subaffiliate_filters'){
            formData.append('subaffiliates', $('.resetbutton').attr('data-id'));
            var sub = 'sub';
        }

        var url = '/affiliates/list?page=' + pageNumber;
        axios.post(url, formData)
            .then(function (response) {

                if (response.data.affiliates.length > 0) {
                    processing = false;
                    var html = '';
                    $.each(response.data.affiliates, function (key, val) {
                        checked = '';
                        if (val.twofa == null) {
                            twofa = '';
                            twostatus = 'danger';
                            badgetext = 'Disabled';
                        } else {
                            twofa = val.twofa;
                            twostatus = 'success';
                            badgetext = 'Enabled';
                        }
                        if (val.status == 1) { checked = 'checked' }
                        editurl = "/affiliates/edit/" + val.id;
                        apikeyurl = "affiliate-settings/" + val.id;
                        settingtitle = "Settings";
                        subaff = '/affiliates/sub-affiliates/' + val.id;
                        emailtemp = '/affiliates/templates/' + val.id + '/email/remarketing/broadband';

                        if (sub == 'sub') {
                            editurl = "/affiliates/sub-affiliates/edit/" + val.id;
                            apikeyurl = "sub-affiliates/affiliate-settting/" + val.id;
                            settingtitle = "Settings";
                            emailtemp = '/affiliates/templates/' + val.id + '/email/remarketing/broadband';
                        }


                        html += `
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input check-all" type="checkbox" value="${key}" />
                            </div>
                        </td>
                        <td>
                            <span>${val.userid}</span>
                        </td>
                        <td>
                            <span class="wraptext" data-toggle="tooltip" data-placement="top" title="${val.name}">${val.name}</span>
                        </td>
                        <td>
                            <span class="wraptext" data-toggle="tooltip" data-placement="top" title="${val.email}">${val.email}</span>
                        </td>`;
                        if (sub == '') {
                            html += `
                                <td>
                                    <span>
                                        <img src="${val.logo}" width="32px" height="31px" class="img-pop">

                                    </span>
                                </td>`;
                        }
                        html += `
                        <td>
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                                <input class="form-check-input sweetalert_demo change-status" type="checkbox" value="" name="notifications" ${checked}  data-status="${val.id}">
                            </div>
                        </td>
                        <td>
                            <div class="badge badge-light-${twostatus}">${badgetext}</div>
                        </td>
                        <td>
                            <a  class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">

                                <div class="menu-item">
                                    <a href="${editurl}" class="menu-link "><i class="bi bi-pencil-square"></i> Edit</a>
                                </div>
                                <div class="menu-item">
                                    <a href="${apikeyurl}" class="menu-link"><i class="bi bi-gear"></i> ${settingtitle}</a>
                                </div>`;
                        if (sub == '') {
                            html += `
                                    <div class="menu-item ">
                                        <a href="${subaff}" class="menu-link "><i class="bi bi-people"></i> Sub-Affiliates</a>
                                    </div>
                                `;
                        }

                        html += `
                                <div class="menu-item ">
                                    <a href="${emailtemp}" class="menu-link "><i class="bi bi-envelope-paper"></i> Templates</a>
                                </div>

                            </div>
                        </td>
                    </tr>
                    `;
                    });


                    // if (type == 'scroll') {
                    //     $('#affiliatebody').append(html);
                    //     KTMenu.createInstances();
                    //     pageNumber += 1;
                    //     return;
                    // }

                    pageNumber = 2;
                    dataTable.destroy();
                    $('#affiliatebody').html(html);
                    dataTable = $("#affiliate_table").DataTable({
                        responsive: false,
                        searching: true,
                        "sDom": "tipr",
                    });
                    KTMenu.createInstances();

                } else {
                    // if (type != 'scroll') {
                        dataTable.destroy();
                        dataTable = $("#affiliate_table").DataTable({
                            responsive: false,
                            searching: true,
                            "sDom": "tipr",
                        });
                        $('#affiliatebody').html('<td colspan="7" align="center">No matching records found</td>');
                    // }
                    // processing = true;
                }

            })
            .catch(function (error) {
                console.log(error);
            });

    }

    // $(document).scroll(function (e) {
    //     if ($(window).scrollTop() >= $(document).height() - $(window).height()) {

    //         if (processing)
    //             return false
    //         getFilterData('scroll');
    //     }
    // });


    //This code is done for add Select All Button on Multiselect
    $("select").on('change', function () {
        //Check Select All Selected
        if ($(this).children("option[value=select_all]:selected").length > 0) {
            $(this).children('option').prop('selected', true);
            $(this).children('option[value=select_all]').prop('selected', false);
            $(this).children("option[value=select_all]").hide();
        }
        else {
            //if not select all selected option selected
            var total_option = $(this).children('option').length;
            var selected_option = $(this).children('option:selected').length;
            if (total_option === (selected_option + 1)) {
                $(this).children("option[value=select_all]").hide();

            } else {

                $(this).children("option[value=select_all]").show();
            }
        }
    });


    $('.fav_clr').select2({
        placeholder: 'Select Service',
    });

    $(".resetbutton").on('click', function () {
        $('#affiliate_filters')[0].reset();
        $("#apply_affiliate_filters").trigger("click");
    });

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
            .then(function (response) {
                if (response.data.status == 400) {
                    toastr.error(response.data.message);
                } else {
                    toastr.success(response.data.message);
                }

            })
            .catch(function (error) {
                console.log(error);

            })
            .then(function () {
                // always executed
                submitButton.attr('data-kt-indicator', 'off');
                submitButton.prop('disabled', false);
            });

    });

    $(document).on('click', '.img-pop', function(e) {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById("imagemodal"), {});
        myModal.show();
        $('.img_src').attr("src",$(this).attr('src'));
    });

    $(document).on('keyup', '.searchaddress', function(e) {
        var that = $(this);
        if(that.val().length > 9){
            CardLoaderInstance.show('.company_address');
            var url = '/affiliates/search-address';
            var formdata = new FormData();
            formdata.append("address", that.val());
            axios.post(url, formdata)
            .then(function (response) {
                if(response.data.status == 200){
                    if (response.data.result.length > 0) {
                        $(".error").html("");
                        var searched = '';
                        $.each(response.data.result, function(key, val) {
                            searched += `<li style="cursor:pointer">${val.DisplayLine}</li>`;
                        });
                        $('#searchedaddress').empty();
                        $('#searchedaddress').show();
                        $('#searchedaddress').append(searched);
                    }

                }else{
                    $('#searchedaddress').hide();
                    $('.company_address').find('span.error').empty().addClass('text-danger').text(response.data.message).finish().fadeIn();
                }
                CardLoaderInstance.hide();
            })
            .catch(function (error) {
                console.log(error);
                CardLoaderInstance.hide();
            })
            .then(function () {
                CardLoaderInstance.hide();
                // always executed

            });
        }
    });

    $('#searchedaddress').hide();

    $(document).on('click', 'ul.searchedaddress li', function(e) {
       $('.searchaddress').val($(this).text());
       $('#searchedaddress').hide();
    });

});


