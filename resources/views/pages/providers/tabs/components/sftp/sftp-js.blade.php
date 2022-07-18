<script>
    var sftp_table = '', dataTable = '';

    $(window).on('load', function () {
        var sftp_enable = '{{$providerdetails[0]['sftp_enable']}}';
        if (sftp_enable == 1) {
            $('#btn-log-emails').fadeIn().css('display', 'inline-block');
            $('#btn-add-sftp').fadeIn().css('display', 'inline-block');
        }

        $('.sftp-tab').on('click', function (e) {
            loadSftp()
        });

        if ($('.sftp-tab').hasClass('active')) {
            loadSftp()
        }
    })

    function loadSftp() {
        if (sftp_table.length === 0 || sftp_table === '') {
            loadSftpFromServer();
        } else {
            loadSftpTable(sftp_table);
        }
    }

    $('#apply_sftp_filters').on('click', function (event) {
        event.preventDefault();
        var formdata = $('#sftp_filters').serializeArray();
        CardLoaderInstance.show('#target_table')
        $('#apply_sftp_filters').prop('disabled', true);
        setTimeout(function () {
            dataTable.column(1).search(formdata[0].value).column(2).search(formdata[1].value).column(3).search(formdata[2].value).column(4).search(formdata[3].value).draw();
            CardLoaderInstance.hide()
            $('#apply_sftp_filters').prop('disabled', false);
        }, 500);
    });

    $(".resetbutton").on('click', function () {
        $('#sftp_filters')[0].reset();
        $('#sftp_filters select[name=filter_status]').val('').change();
        dataTable.columns().search('').draw();
    });

    $(document).on('click', '#sftp-status', function () {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change SFTP status",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                CardLoaderInstance.show('#kt_content_container');
                axios.get("/provider/change-provider-sftp-status/" + $(this).attr('data-id'))
                    .then((response) => {
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                            if ($(this).attr('data-sftp_status') == 1) {
                                $('#btn-log-emails').fadeOut();
                                $('#btn-add-sftp').fadeOut();
                                $('#sftp-status').removeClass('btn-success').addClass('btn-danger').attr('data-sftp_status', 0).text('Enable');
                            } else {
                                $('#btn-log-emails').fadeIn().css('display', 'inline-block');
                                $('#btn-add-sftp').fadeIn().css('display', 'inline-block');
                                $('#sftp-status').removeClass('btn-danger').addClass('btn-success').attr('data-sftp_status', 1).text('Disable');
                            }
                        } else {
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toastr.error('Whoops! something went wrong.');
                    })
                    .then(function () {
                        CardLoaderInstance.hide();
                    });
            }
        });
    })

    $('#sftp_logs_form_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('.modal-content');
        let formData = $('#sftp_logs_form').serialize();

        axios.post('/provider/sftp-logs', formData)
            .then(response => {
                $('#sftp-logs-modal').modal('hide');

                if (response.data.status == true) {
                    toastr.success(response.data.message);
                    // update values
                    $('#btn-log-emails').attr('data-log_from_email', response.data.sftp.log_from_email);
                    $('#btn-log-emails').attr('data-log_from_name', response.data.sftp.log_from_name);
                    $('#btn-log-emails').attr('data-log_subject', response.data.sftp.log_subject);
                    $('#btn-log-emails').attr('data-log_to_emails', response.data.sftp.log_to_emails);
                } else {
                    toastr.error(response.data.message);
                }
            }).catch(error => {
            if (error.response.status == 422) {
                showValidationMessages(error.response.data.errors);
            }

            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        }).then(() => {
            CardLoaderInstance.hide();
            KTMenu.createInstances();
        });
    });

    $('#add_sftp_form_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('.modal-content');
        let formData = $('#add_sftp_form').serialize();

        axios.post('/provider/add-sftp', formData)
            .then(response => {

                if (response.data.status == true) {
                    $('#add-sftp-modal').modal('hide');
                    loadSftpFromServer();
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message);
                }

            }).catch(error => {
            if (error.response.status == 422) {
                errors = error.response.data.errors;
                showValidationMessages(errors)
            }
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        }).then(() => {
            CardLoaderInstance.hide();
            KTMenu.createInstances();
        });
    });

    $('#add-sftp-modal').on('hide.bs.modal', () => {
        CardLoaderInstance.hide();
    });

    $('#add-sftp-modal').on('hidden.bs.modal', () => {
        removeValidationErrors();
        $('#add-sftp-modal').find('.title').text('Add SFTP');
        $('#add_sftp_form').find('input#sftp_id').val('');
        $('#add_sftp_form').find('input#sftp_status').val(0);
        $('#add_sftp_form').trigger('reset');
    });

    $('#sftp-logs-modal').on('hide.bs.modal', () => {
        $("span.form_error").hide();
        $('#sftp_logs_form').find('input').css('border-color', '');
        $('#sftp_logs_form').find('textarea').css('border-color', '');
    });

    $('#btn-log-emails').on('click', function () {
        $('input[name=log_from_email]').val($(this).attr('data-log_from_email'));
        $('input[name=log_from_name]').val($(this).attr('data-log_from_name'));
        $('input[name=log_subject]').val($(this).attr('data-log_subject'));
        $('textarea[name=log_to_emails]').val($(this).attr('data-log_to_emails'));
    });

    function loadSftpFromServer() {
        CardLoaderInstance.show('.tab-pane#sftp');
        axios.get('/provider/get-sftps/{{$providerId}}')
            .then(response => {
                if (response.status == 200) {
                    sftp_table = response.data;
                    loadSftpTable(sftp_table);
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(error => {
                console.log(error);
                toastr.error('Whoops! something went wrong.');
            })
            .then(() => {
                CardLoaderInstance.hide();
            });
    }

    function loadSftpTable(sftp_table) {
        if (dataTable !== '') {
            dataTable.destroy();
        }

        var html = '';
        html += createTargetTable(sftp_table);
        $('.target_table_data_body').html(html);

        dataTable = $("#target_table")
            .on('draw.dt', function () {
                KTMenu.createInstances();
            })
            .DataTable({
                responsive: true,
                ordering: false,
                searching: true,
            });
    }

    function createTargetTable(targetArr) {
        var html = "";
        var count = 1;
        $.each(targetArr, function (key, val) {
            html += createTableRow(val, count);
            count++;
        });
        return html;
    }

    function createTableRow(tableRow, count) {
        var trRow = `<tr id="sftp-tr">
                <td width="16.6%"><span>${count}</span></td>
                <td width="16.6%"><span>${tableRow.destination_name}</td>
                <td width="16.6%"><span>${tableRow.remote_host}</span></td>
                <td width="16.6%"><span >${tableRow.port}</span></td>
                <td width="16.6%"><span class="d-none row_status">${tableRow.status == 1 ? 'status_enabled' : 'status_disabled'}</span><span ><div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input change-sftp-status" data-id="${tableRow.id}" type="checkbox" data-status="${tableRow.status}" title="${tableRow.status ? 'Click to disable' : 'Click to enable'}" name="notifications" ${tableRow.status == 1 ? 'checked' : ''}></div></span></td>
                <td width="16.6%" class="text-start"><a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                         <span class="svg-icon svg-icon-5 m-0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                             </svg>
                         </span>
                     </a>
                     <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                         <div class="menu-item">
                             <span class="menu-link edit-sftp" data-id="${tableRow.id}" data-destination_name="${tableRow.destination_name}" data-directory="${tableRow.directory}" data-password="${tableRow.password}" data-port="${tableRow.port}" data-authentication_type="${tableRow.auth_type}" data-protocol_type="${tableRow.protocol_type}" data-provider_id="${tableRow.provider_id}" data-remote_host="${tableRow.remote_host}" data-timeout="${tableRow.timeout}" data-username="${tableRow.username}" data-status="${tableRow.status}">Edit</span>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link delete-sftp"  data-id="${tableRow.id}">Delete</span>
                         </div>
                     </div>
                 </td></tr>`;
        return trRow;
    }

    //change status
    $(document).on('change', '.change-sftp-status', function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: 'You want to change SFTP status',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.get('/provider/change-sftp-status/' + $(this).attr('data-id'))
                    .then((response) => {
                        if (response.data.status == true) {
                            dataTable.destroy();

                            $(this).attr('title', $(this).is(':checked') ? 'Click to disable' : 'Click to enable');
                            $(this).closest('td').find('.row_status').text($(this).is(':checked') ? 'status_enabled' : 'status_disabled');

                            dataTable = $("#target_table")
                                .on('draw.dt', function () {
                                    KTMenu.createInstances();
                                })
                                .DataTable({
                                    responsive: true,
                                    ordering: false,
                                    searching: true,
                                });

                            toastr.success(response.data.message);
                        } else {
                            toastr.error(response.data.message);
                            $(this).is(':checked') ? $(this).prop('checked', false) : $(this).prop('checked', true)
                        }
                    })
                    .catch(function (error) {
                        toastr.error('Whoops! something went wrong.');
                        $(this).is(':checked') ? $(this).prop('checked', false) : $(this).prop('checked', true)
                    })
                    .then(function () {

                    });
            } else {
                $(this).is(':checked') ? $(this).prop('checked', false) : $(this).prop('checked', true)
            }
        });
    });


    // edit sftp
    $(document).on('click', '.edit-sftp', function (e) {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('add-sftp-modal'), {});
        myModal.show();

        $('#add-sftp-modal').find('.title').text('Edit SFTP');
        $('input[name=sftp_id]').val($(this).attr('data-id'));
        $('input[name=destination_name]').val($(this).attr('data-destination_name'));
        $('input[name=directory]').val($(this).attr('data-directory'));
        $('input[name=password]').val($(this).attr('data-password'));
        $('input[name=port]').val($(this).attr('data-port'));
        $('input[name=remote_host]').val($(this).attr('data-remote_host'));
        $('input[name=timeout]').val($(this).attr('data-timeout'));
        $('input[name=username]').val($(this).attr('data-username'));
        $('input[name=status]').val($(this).attr('data-status'));

        $(this).attr('data-protocol_type') == 0 ? $('input[name=protocol_type]#ftp').prop('checked', true) : $('input[name=protocol_type]#sftp').prop('checked', true)
        $(this).attr('data-authentication_type') == 0 ? $('input[name=auth_type]#key-auth').prop('checked', true) : $('input[name=auth_type]#password-auth').prop('checked', true)

    });

    //delete target
    $(document).on('click', '.delete-sftp', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then(function (result) {
            if (result.isConfirmed) {
                axios.delete("/provider/delete-sftp/" + id)
                    .then(function (response) {
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                            targetArr = "";
                            loadSftpFromServer();
                        } else {
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toastr.error('Whoops! something went wrong.');
                    });
            }
        });
    });
</script>
