<script>
    $(document).on('submit', '.submitsubmitAffiliate', function(e) {
        e.preventDefault();
        removeValidationErrors()
        CardLoaderInstance.show('.tab-content');
        let myForm = document.getElementById('affiliateFilter');
        let formData = new FormData(myForm);
        formData.append('providerservice', 1);
        formData.append('requesttype', 'affiliates');
        var url = "/provider/assign-providers-affiliates";
        axios.post(url, formData)
            .then(function(response) {
                $(".error").html("");
                if (response.data.status == 200) {
                    toastr.success(response.data.message);
                    $('.affiliateTabledata').empty();
                    if (response.data.result.length > 0) {
                        var users = ``;
                        $.each(response.data.result, function(key, val) {
                            checked = '';
                            if (val.status == 1) {
                                checked = 'checked'
                            }
                            users += `
                                <tr>
                                <td>${val.company_name}</td>
                                <td>${val.assignedby}</td>
                                <td>
                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                                        <input class="form-check-input sweetalert_demo change-provider-status" type="checkbox"  ${checked}  data-id="${val.id}">
                                    </div>
                                </td>
                                <td class="">
                                    <a class="deletemanageprovider" data-id="${val.id}" data-relation="${val.relationaluser}" data-service="${val.servive_id}" data-source="${val.source_user_id}" title="Delete">
                                        <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                                    </a>
                                </td>
                                </tr>
                                `;
                        });
                    }
                    $('.affiliateTabledata').append(users);

                    $('.multipleaffiliates').empty();
                    var html = ``;
                    if (response.data.users.length > 0) {
                        html += `<option value="all">Select All</option>`;
                        $.each(response.data.users, function(key, val) {
                            html += `<option value="${val.user_id}">${val.company_name}</option>`;
                        });
                    }
                    $('.multipleaffiliates').append(html);
                    $('.multipleaffiliates').select2({
                        placeholder: "Select Affiliates",
                        allowClear: true
                    });

                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function(error) {
                CardLoaderInstance.hide();
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    showValidationMessages(errors)
                } else if (error.response.status == 400) {
                    console.log(error.response);
                }
            })
            .then(function() {
                CardLoaderInstance.hide();
            });
    });

    //Change Status
    $(document).on('click', '.change-provider-status', function(e) {
        var check = $(this);
        var id = check.attr("data-id");
        var isChecked = check.is(':checked');
        if (check.is(':checked'))
            var status = 1;
        else
            var status = 0;

        var url = '/affiliates/change-provider-status';
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
                            toastr.error(response.data.message);
                            if (isChecked) {
                                check.prop('checked', false);
                            } else {
                                check.prop('checked', true);
                            }
                        } else {
                            toastr.success(response.data.message);
                        }

                    })
                    .catch(function(error) {
                        console.log(error);
                        if (isChecked) {
                            check.prop('checked', false);
                        } else {
                            check.prop('checked', true);
                        }
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

    $(document).on('click', '.deletemanageprovider', function(e) {
        e.preventDefault();
        var check = $(this);
        var id = check.attr("data-id");
        var service = check.attr("data-service");
        var relation = check.attr("data-relation");
        var source = check.attr("data-source");
        var providerId = '{{request()->segment(3)}}';
        var url = '/affiliates/deleteprovider';
        var formdata = new FormData();
        formdata.append("did", id);
        formdata.append("service", service);
        formdata.append("relation", relation);
        formdata.append("source", source);
        formdata.append('id', providerId);
        formdata.append('user', '');
        formdata.append('type', 2);
        formdata.append('providerservice', 1);
        formdata.append('providertype', 1);
        Swal.fire({
            title: "{{trans('affiliates.warning_msg_title')}}",
            text: "{{trans('affiliates.delete_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('affiliates.yes_text')}}",
        }).then(function(result) {
            if (result.isConfirmed) {
                CardLoaderInstance.show('.tab-content');
                axios.post(url, formdata)
                    .then(function(response) {
                        if (response.data.status == 400) {
                            toastr.error(response.data.message);
                        } else {
                            check.closest('tr').remove();
                            toastr.success(response.data.message);
                            $('.multipleaffiliates').empty();
                            var html = ``;
                            if (response.data.users.length > 0) {
                                html += `<option value="all">Select All</option>`;
                                $.each(response.data.users, function(key, val) {
                                    html += `<option value="${val.user_id}">${val.company_name}</option>`;
                                });
                            }
                            $('.multipleaffiliates').append(html);
                            $('.multipleaffiliates').select2({
                                placeholder: "Select Affiliates",
                                allowClear: true
                            });
                        }
                        CardLoaderInstance.hide();
                    })
                    .catch(function(error) {
                        console.log(error);
                        CardLoaderInstance.hide();
                    })
                    .then(function() {
                        CardLoaderInstance.hide();
                    });
            }
        });

    });

    $("#affiliates-tab-panel #providers").on('change', function () {
        if ($(this).children("option[value=select_all]:selected").length > 0) {
            $(this).children('option').prop('selected', true);
            $(this).children('option[value=select_all]').prop('selected', false);
        }
    });
</script>
