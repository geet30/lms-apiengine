<script>
    $(document).ready(function() {
        localStorage.removeItem('users');
        //user click
        $(document).on('click', '.getusers', function(e) {
            if (localStorage.getItem("users")) {

            } else {
                localStorage.setItem("users", 1);

                CardLoaderInstance.show('.tab-content');
                var id = $('#show_apikeypopup').data('user_id');
                let myForm = document.getElementById('userFilter');
                let formData = new FormData(myForm);
                formData.append('user', $('#checksegment').val());
                formData.append('request_from', $('#userFilter').closest('form').attr('name'));
                var url = "/affiliates/link-users/" + id;
                axios.post(url, formData)
                    .then(function(response) {
                        $('.userTabledata').empty();
                        if (response.data.getAssignedUsers.length > 0) {

                            var users = ``;
                            $.each(response.data.getAssignedUsers, function(key, val) {
                                users += `
                            <tr>
                            <td>${val.first_name}</td>
                            <td>${val.service}</td>
                            <td>${val.rolename}</td>
                            <td>${val.assignedby}</td>
                            <td class="text-end">
                                <a class="deletemanageuser" data-id="${val.id}" title="Delete">
                                    <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                                </a>
                            </td>
                            </tr>
                            `;
                            });


                        } else {
                            users = `<tr class="no_record"><td colspan="5" align="center">{{trans('affiliates.norecord')}}</td></tr>`;
                        }
                        $('.userTabledata').append(users);
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

        $(document).on('change', '#userservice', function(e) {
            CardLoaderInstance.show('.tab-content');
            var service = $(this).val();
            let myForm = document.getElementById('userFilter');
            let formData = new FormData(myForm);
            formData.append('id', $('#show_apikeypopup').data('user_id'));
            formData.append('user', $('#checksegment').val());
            formData.append('type', 3);
            var url = "/affiliates/get-users";
            axios.post(url, formData)
                .then(function(response) {
                    $('#users').empty();
                    var html = ``;
                    if (response.data.result.users.length > 0) {
                        html+= `<option value="select_all">{{trans('affiliates.select_all')}}</option>`;
                        $.each(response.data.result.users, function(key, val) {
                            html += `<option value="${val.id}">${val.first_name} (${val.rolename})</option>`;
                        });
                    }
                    $('#users').append(html);
                    $('#users').select2({
                        placeholder: "Select Users",
                    });

                    $('.userTabledata').empty();
                    if (response.data.result.getAssignedUsers.length > 0) {
                        var users = ``;
                        $.each(response.data.result.getAssignedUsers, function(key, val) {
                            users += `
                        <tr>
                        <td>${val.first_name}</td>
                        <td>${val.service}</td>
                        <td>${val.rolename}</td>
                        <td>${val.assignedby}</td>
                        <td class="text-end">
                            <a class="deletemanageuser" data-id="${val.id}" title="Delete">
                                <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                            </a>
                        </td>
                        </tr>
                        `;
                        });

                    } else {
                        users = `<tr class="no_record"><td colspan="5" align="center">{{trans('affiliates.norecord')}}</td></tr>`;
                    }
                    $('.userTabledata').append(users);
                    CardLoaderInstance.hide();
                })
                .catch(function(error) {
                    console.log(error);
                    CardLoaderInstance.hide();
                })
                .then(function() {
                    CardLoaderInstance.hide();
                });
        });

        $(document).on('submit', '.submitServices', function(e) {
            e.preventDefault();
            CardLoaderInstance.show('.tab-content');
            let myForm = document.getElementById('userFilter');
            let formData = new FormData(myForm);
            formData.append('id', $('#show_apikeypopup').data('user_id'));
            formData.append('user', $('#checksegment').val());
            formData.append('request_from', $('#userFilter').closest('form').attr('name'));
            formData.append('type', 3);
            var url = "/affiliates/assign-users";
            axios.post(url, formData)
                .then(function(response) {
                    $(".error").html("");
                    if (response.data.status == 200) {

                        toastr.success(response.data.message);
                        $('.userTabledata').empty();
                        if (response.data.result.length > 0) {
                            var users = ``;
                            $.each(response.data.result, function(key, val) {
                                users += `
                            <tr>
                            <td>${val.first_name}</td>
                            <td>${val.service}</td>
                            <td>${val.rolename}</td>
                            <td>${val.assignedby}</td>
                            <td class="text-end">
                                <a class="deletemanageuser" data-id="${val.id}" title="Delete">
                                    <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                                </a>
                            </td>
                            <tr>
                            `;
                            });

                        } else {
                            users = `<tr class="no_record"><td colspan="5" align="center">{{trans('affiliates.norecord')}}</td></tr>`;
                        }

                        $('.userTabledata').append(users);
                        $('#users').empty();
                        var html = `<option value="select_all">{{trans('affiliates.select_all')}}</option>`;
                        if (response.data.users.length > 0) {
                            html += ``;
                            $.each(response.data.users, function(key, val) {
                                html += `<option value="${val.id}">${val.first_name} (${val.rolename})</option>`;
                            });
                        }
                        $('#users').append(html);
                        $('#users').select2({
                            placeholder: "Select Users",
                        });

                    } else {
                        toastr.error(response.data.message);
                    }

                    CardLoaderInstance.hide();
                })
                .catch(function(error) {
                    CardLoaderInstance.hide();
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
                    CardLoaderInstance.hide();
                });
        });

        $('.multipleusers').select2({
            placeholder: 'Select Users',
        });

        $(document).on('click', '.deletemanageuser', function(e) {
            e.preventDefault();
            var check = $(this);
            var id = check.attr("data-id");
            var url = '/affiliates/deleteuser';

            let myForm = document.getElementById('userFilter');
            var formdata = new FormData();
            formdata.append("did", id);
            formdata.append('id', $('#show_apikeypopup').data('user_id'));
            formdata.append('user', $('#checksegment').val());
            formdata.append('type', 3);
            formdata.append('userservice', $('#userservice').val());
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
                                $('#users').empty();
                                var html = `<option value="select_all">{{trans('affiliates.select_all')}}</option>`;
                                if (response.data.users.length > 0) {
                                    html += ``;
                                    $.each(response.data.users, function(key, val) {
                                        html += `<option value="${val.id}">${val.first_name} (${val.rolename})</option>`;
                                    });
                                }
                                $('#users').append(html);
                                $('#users').select2({
                                    placeholder: "Select Users",
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


        //This code is done for add Select All Button on Multiselect
        $(".multipleusers").on('change', function() {
            //Check Select All Selected 
            if ($(this).children("option[value=select_all]:selected").length > 0) {
                $(this).children('option').prop('selected', true);
                $(this).children('option[value=select_all]').prop('selected', false);
                $(this).children("option[value=select_all]").hide();
                $('#users').select2({});
            } else {
                //if not select all selected option selected
                var total_option = $(this).children('option').length;
                var selected_option = $(this).children('option:selected').length;
                if (total_option === (selected_option + 1)) {
                    $(this).children("option[value=select_all]").hide();

                } else {

                    $(this).children("option[value=select_all]").show();
                    $('#users').select2({
                        placeholder: "Select Users",
                    });
                }
            }
        });

    });
</script>