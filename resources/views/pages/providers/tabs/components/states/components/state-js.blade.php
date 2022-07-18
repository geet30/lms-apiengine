<script>
    $(document).on('submit', '.submitStates', function(e) {
        e.preventDefault();
        removeValidationErrors()
        CardLoaderInstance.show('.tab-content');
        let myForm = document.getElementById('providerStates');
        let formData = new FormData(myForm);
        formData.append('user_type', 2);
        var url = "/provider/assign-providers-states";
        axios.post(url, formData)
            .then(function(response) {
                $(".error").html("");
                if (response.data.status == 200) {
                    toastr.success(response.data.message);
                    $('.statesTabledata').empty();
                    if (response.data.result.length > 0) {
                        var users = ``;
                        $.each(response.data.result, function(key, val) {
                            checked = '';
                            checkedRetention = '';
                            if (val.status == 1) {
                                checked = 'checked';
                            }
                            if(val.retention_alloweded == 1){
                                checkedRetention = 'checked';
                            }
                            users += `
									<tr>
									<td>${val.state_code}</td>
									<td>
										<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
											<input class="form-check-input sweetalert_demo changestatestatus" type="checkbox"  ${checked}  data-id="${val.user_state_id}">
										</div>
									</td>
									<td>
										<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Retention Allowed">
											<input class="form-check-input sweetalert_demo changeretentionalloweded" type="checkbox" data-id="${val.user_state_id}" ${checkedRetention}>
										</div>
									</td>
									<td class="">
										<a class="deletestate" title="Delete" data-id="${val.user_state_id}">
											<i class="bi bi-trash fs-2 mx-1 text-primary"></i>
										</a>
									</td>
									</tr>
									`;
                        });
                        $('.statesTabledata').append(users);

                        $('.multiplestates').empty();
                        var html = ``;
                        if (response.data.states.length > 0) {
                            html += `<option value="all">Select All</option>`;
                            $.each(response.data.states, function(key, val) {
                                html += `<option value="${val.state_id}">${val.state_code}</option>`;
                            });
                        }
                        $('.multiplestates').append(html);
                        $('.multiplestates').select2({
                            placeholder: "Select States",
                            allowClear: true
                        });
                    }
                } else {
                    toastr.error(response.data.message);
                }
                CardLoaderInstance.hide();
                window.location.href = window.location.href ;
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

    //Change Status state
    $(document).on('click', '.changestatestatus', function(e) {
        var check = $(this);
        var id = check.attr("data-id");
        var isChecked = check.is(':checked');
        if (check.is(':checked'))
            var status = 1;
        else
            var status = 2;

        var url = '/provider/change-state-status';
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

    //Change retention allowed state
    $(document).on('click', '.changeretentionalloweded', function(e) {
        var check = $(this);
        var id = check.attr("data-id");
        var isChecked = check.is(':checked');
        if (check.is(':checked'))
            var status = 1;
        else
            var status = 2;

        var url = '/provider/retention-allowed';
        var formdata = new FormData();
        formdata.append("id", id);
        formdata.append("retention_alloweded", status);
        Swal.fire({
            title: "{{trans('affiliates.warning_msg_title')}}",
            text: "{{trans('affiliates.warning_msg_text_retention')}}",
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

    //Delete state
    $(document).on('click', '.deletestate', function(e) {
        e.preventDefault();
        var check = $(this);
        var id = check.attr("data-id");
        var url = '/provider/deletestate';
        var providerId = '{{request()->segment(3)}}';
        var formdata = new FormData();
        formdata.append("id", id);
        formdata.append("providerid", providerId);
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
                            $('.multiplestates').empty();
                            var html = ``;
                            if (response.data.states.length > 0) {
                                html += `<option value="all">Select All</option>`;
                                $.each(response.data.states, function(key, val) {
                                    html += `<option value="${val.state_id}">${val.state_code}</option>`;
                                });
                            }
                            $('.multiplestates').append(html);
                            $('.multiplestates').select2({
                                placeholder: "Select States",
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

    $("#states-tab-panel #states").on('change', function () {
        if ($(this).children("option[value=select_all]:selected").length > 0) {
            $(this).children('option').prop('selected', true);
            $(this).children('option[value=select_all]').prop('selected', false);
        }
    });
</script>
