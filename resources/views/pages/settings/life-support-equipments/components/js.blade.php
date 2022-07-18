<script>
    var life_support_table = '', life_support_id = '', dataTable = '', master_life_support_content = '';

    loadFromServer();

    $(document).on('click', '.change-life-support-status', function () {
        var isChecked = $(this).is(':checked');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change life support equipment status",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                CardLoaderInstance.show('#kt_content_container');
                axios.get("/settings/change-life-support-status/" + $(this).attr('data-id'))
                    .then((response) => {
                        if (response.data.status == true) {
                            $(this).attr('title', isChecked ? 'Click to disable' : 'Click to enable');
                            toastr.success(response.data.message);
                        } else {
                            $(this).prop('checked', !isChecked);
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        $(this).prop('checked', !isChecked);
                        toastr.error('Whoops! something went wrong.');
                    })
                    .then(function () {
                        CardLoaderInstance.hide();
                    });
            } else {
                $(this).prop('checked', !isChecked);
            }
        });
    })

    $('#life_support_form_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('.modal-content');
        let formData = $('#life_support_form').serialize();
        var url = '/settings/post-life-support-equipments'
        if (life_support_id) {
            url += '/' + life_support_id
        }
        axios.post(url, formData)
            .then(response => {
                if (response.data.status == true) {
                    $('#life-support-modal').modal('hide');
                    loadFromServer();
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

    $('#search_target_table').keyup(function () {
        if (dataTable !== '')
            dataTable.search($(this).val()).draw();
    })

    $('#life-support-modal').on('hide.bs.modal', () => {
        life_support_id = '';
        CardLoaderInstance.hide();
    });

    $('#life-support-modal').on('hidden.bs.modal', () => {
        $('#life-support-modal').find('.title').text('Add Life Support Equipment');
        removeValidationErrors();
        $('#life_support_form').find('input#life_support_status').val(0);
        $('#life_support_form').trigger('reset');
    });

    function loadFromServer() {
        CardLoaderInstance.show('#target_table');
        axios.get('/settings/get-life-support-equipments')
            .then(response => {
                if (response.data.status == 200) {
                    master_life_support_content = response.data.master_life_support_content;
                    life_support_table = response.data.life_support;
                    loadTable(life_support_table);
                    setMasterLifeSupportContent(master_life_support_content);
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

    function loadTable(life_support_table) {
        if (dataTable !== '') {
            dataTable.destroy();
        }
        if (life_support_table.length) {
            var html = '';
            html += createTargetTable(life_support_table);
            $('.target_table_data_body').html(html);
        }

        dataTable = $("#target_table")
            .on('draw.dt', function () {
                KTMenu.createInstances();
            })
            .DataTable({
                searching: true,
                ordering: true,
                "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
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
                <td width="16.6%"><span>${tableRow.title}</td>
                <td width="16.6%"><span>${getEnergyType(tableRow.energy_type)}</span></td>
                <td width="16.6%"><span ><div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input change-life-support-status" data-id="${tableRow.id}" type="checkbox" data-status="${tableRow.status}" title="${tableRow.status ? 'Click to disable' : 'Click to enable'}" name="notifications" ${tableRow.status == 1 ? 'checked' : ''}></div></span></td>
                <td width="16.6%"><span>${tableRow.created_at}</span></td>
                <td width="16.6%" class="text-start"><a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                         <span class="svg-icon svg-icon-5 m-0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                             </svg>
                         </span>
                     </a>
                     <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                         <div class="menu-item">
                             <span class="menu-link edit-life-support" data-id="${tableRow.id}" data-status="${tableRow.status}" data-title="${tableRow.title}" data-energy_type="${tableRow.energy_type}">Edit</span>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link delete-life-support"  data-id="${tableRow.id}">Delete</span>
                         </div>
                     </div>
                 </td></tr>`;
        return trRow;
    }

    function getEnergyType(energy_type) {
        if (energy_type === 1) {
            return 'Electricity'
        } else if (energy_type === 2) {
            return 'Gas'
        } else {
            return 'Both'
        }
    }

    // edit sftp
    $(document).on('click', '.edit-life-support', function (e) {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('life-support-modal'), {});
        myModal.show();

        life_support_id = $(this).attr('data-id')
        $('#life-support-modal').find('.title').text('Edit Life Support Equipment');
        $('input[name=title]').val($(this).attr('data-title'));
        $('select[name=energy_type]').val($(this).attr('data-energy_type')).change();
        $('input[name=status]').val($(this).attr('data-status'));

        $(this).attr('data-protocol_type') == 0 ? $('input[name=protocol_type]#ftp').prop('checked', true) : $('input[name=protocol_type]#sftp').prop('checked', true)
        $(this).attr('data-authentication_type') == 0 ? $('input[name=auth_type]#key-auth').prop('checked', true) : $('input[name=auth_type]#password-auth').prop('checked', true)

    });

    //delete target
    $(document).on('click', '.delete-life-support', function (e) {
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
                axios.delete("/settings/delete-life-support-equipment/" + id)
                    .then(function (response) {
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                            targetArr = "";
                            loadFromServer();
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

    $(document).on('submit', '#affiliate_life_support_content_form', function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('#master-life-support-modal .modal-content');
        var formData = new FormData($(this)[0]);
        axios.post('post-master-life-support-content', formData)
            .then(function (response) {
                if (response.data.status == 1) {
                    toastr.success(response.data.message);
                    $('#master-life-support-modal').modal('hide');
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                console.log(error)
                if (error.response.status == 422) {
                    toastr.error(error.response.data.message);
                    var errors = error.response.data.errors;
                    showValidationMessages(errors);
                } else
                    toastr.error(error.response.data.message);
            })
            .then(function () {
                CardLoaderInstance.hide();
            });
    });

    function setMasterLifeSupportContent(content) {
        if (content !== null) {
            CKEDITOR.instances.content.setData(content.value);
        }
    }

    const showValidationMessages = (errors) => {
        $.each(errors, function (key, value) {
            var input = $("input[name='" + key + "']");
            var select = $("select[name='" + key + "']");
            var id = $("#" + key);

            if (key.indexOf(".") != -1) {
                var arr = key.split(".");
                input = $("input[name='" + arr[0] + "[]']:eq(" + arr[1] + ")");
                select = $("input[name='" + arr[0] + "[]']:eq(" + arr[1] + ")"); // simple select
                id = $("select[name='" + arr[0] + "[]']:eq(" + arr[1] + ")");
            }

            $(input).next('span.errors').addClass('field-error').text(value).fadeIn();
            $(input).css('border-color', 'red');

            $(select).next('span.errors').addClass('field-error').text(value).fadeIn();
            $(select).css('border-color', 'red');

            // if select2 , ck-editor
            var error_field = $(id).nextAll('span.errors').addClass('field-error').text(value).fadeIn();
            $(error_field).parent().find('.select2-selection').css('border-color', 'red');
            $(error_field).parent().find("#cke_" + key).css('border-color', 'red');
        });
    }

    const removeValidationErrors = () => {
        $("span.errors").text('').hide();
        $("input").css('border-color', '');
        $("select").css('border-color', '');
        $(".select2-selection").css('border-color', '');
        $(".cke").css('border-color', '');
    }
</script>
