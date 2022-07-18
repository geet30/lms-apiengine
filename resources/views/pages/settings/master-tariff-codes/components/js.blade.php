<script>
    var master_tariff_codes_table = '', master_tariff_codes_id = '', data_table = '';

    loadFromServer();

    $(document).on('click', '.change-master-tariff-code-status', function () {
        var isChecked = $(this).is(':checked');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change status",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                CardLoaderInstance.show('#kt_content_container');
                axios.get("/settings/change-master-tariff-codes-status/" + $(this).attr('data-id'))
                    .then((response) => {
                        if (response.data.status == true) {
                            $(this).closest('td').find('.row_status').text(isChecked ? 'status_enabled' : 'status_disabled');
                            $(this).attr('title', isChecked ? 'Click to disable' : 'Click to enable');
                            toastr.success(response.data.message);

                            data_table.destroy();
                            data_table = $("#target_table")
                                .on('draw.dt', function () {
                                    $('.form-check-input.main').prop('checked', false);
                                    KTMenu.createInstances();
                                })
                                .DataTable({
                                    columnDefs :[
                                        { "orderable": false, "targets": 0 }
                                    ],
                                    searching: true,
                                    ordering: true,
                                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                    "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6 d-flex'li><'col-sm-6'p>>",
                                });
                            filterDatatable()
                        } else {
                            toastr.error(response.data.message);
                            $(this).prop('checked', !isChecked);
                        }
                    })
                    .catch((error) => {
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

    $('#master_tariff_codes_form_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('#master_tariff_codes_modal .modal-content');
        let formData = $('#master_tariff_codes_form').serialize();
        var url = '/settings/post-master-tariff-codes'
        if (master_tariff_codes_id) {
            url += '/' + master_tariff_codes_id
        }
        axios.post(url, formData)
            .then(response => {
                if (response.data.status == true) {
                    $('#master_tariff_codes_modal').modal('hide');
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

    $('#apply_master_tariff_codes_filters').on('click', function (event) {
        event.preventDefault();
        filterDatatable();
    })

    function filterDatatable() {
        var formdata = $('#master_tariff_codes_filters').serializeArray();
        data_table.column(2).search(formdata[0].value).column(3).search(formdata[1].value).column(7).search(formdata[2].value).draw();
    }

    $('#master_tariff_codes_modal').on('hide.bs.modal', () => {
        master_tariff_codes_id = '';
        CardLoaderInstance.hide();
    });

    $('#import_modal').on('hidden.bs.modal', () => {
        removeValidationErrors();
    });

    $('#master_tariff_codes_modal').on('hidden.bs.modal', () => {
        $('#master_tariff_codes_modal').find('.title').text('Add Master Tariff Code');
        removeValidationErrors();
        $('#master_tariff_codes_form').trigger('reset');
        $('select[name=distributor]').val('').change();
        $('select[name=property_type]').val('').change();
        $('select[name=tariff_type]').val('').change();
        $('select[name=offer_type]').val('').change();
        $('select[name=units_type]').val('').change();
    });

    function loadFromServer() {
        CardLoaderInstance.show('#target_table');
        axios.post('/settings/get-master-tariff-codes')
            .then(response => {
                if (response.data.status == 1) {
                    master_tariff_codes_table = response.data.master_tariffs;
                    loadTable(master_tariff_codes_table);
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

    function loadTable(master_tariff_codes_table) {
        if (data_table !== '') {
            data_table.destroy();
        }
        if (master_tariff_codes_table.length) {
            var html = '';
            html += createTargetTable(master_tariff_codes_table);
            $('.target_table_data_body').html(html);
        }

        data_table = $("#target_table")
            .on('draw.dt', function () {
                $('.form-check-input.main').prop('checked', false);
                KTMenu.createInstances();
            })
            .DataTable({
                columnDefs :[
                    { "orderable": false, "targets": 0 }
                ],
                searching: true,
                ordering: true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6 d-flex'li><'col-sm-6'p>>",
            });
        filterDatatable();
    }

    function createTargetTable(targetArr) {
        var html = "";
        $.each(targetArr, function (key, val) {
            html += createTableRow(val, key + 1);
        });
        return html;
    }

    function createTableRow(tableRow, count) {
        var trRow = `<tr id="master-tariff-tr">
                <td>
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input check-all check-row" type="checkbox" value="${tableRow.id}" />
                    </div>
                </td>
                <td><span>${count}</span></td>
                <td><span>${(tableRow.tariff_code == 'NULL') ? '-' : tableRow.tariff_code}</td>
                <td><span>${(tableRow.tariff_type == 'NULL') ? '-' : tableRow.tariff_type}</span></td>
                <td><span>${getPropertyType(tableRow.property_type)}</span></td>
                <td><span>${tableRow.distributor_name}</span></td>
                <td><span>${getUnitsType(tableRow.units_type)}</span></td>
                <td><span class="d-none row_status">${tableRow.status == 1 ? 'status_enabled' : 'status_disabled'}</span><span><span ><div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input change-master-tariff-code-status" data-id="${tableRow.id}" type="checkbox" data-status="${tableRow.status}" title="${tableRow.status == 1 ? 'Click to disable' : 'Click to enable'}" name="notifications" ${tableRow.status == 1 ? 'checked' : ''}></div></span></span></td>
                <td><span>${formatDateTime(tableRow.created_at)}</span></td>
                <td><span>${formatDateTime(tableRow.updated_at)}</span></td>
                <td class="text-start"><a href="#" class="btn btn-sm btn-light btn-active-light-primary text-nowrap" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                         <span class="svg-icon svg-icon-5 m-0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                             </svg>
                         </span>
                     </a>
                     <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                         <div class="menu-item">
                             <span class="menu-link edit_master_tariff_codes" data-id="${tableRow.id}" data-distributor_id="${tableRow.distributor_id}" data-property_type="${tableRow.property_type}" data-tariff_type="${tableRow.tariff_type}" data-tariff_code="${tableRow.tariff_code}" data-status="${tableRow.status}" data-units_type="${tableRow.units_type}">Edit</span>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link delete_master_tariff_codes"  data-id="${tableRow.id}">Delete</span>
                         </div>
                     </div>
                 </td></tr>`;
        return trRow;
    }

    function getUnitsType(type) {
        var t = '';
        (type === 1) ? t = 'kVA' : t = 'kWh';
        return t
    }

    function getPropertyType(type) {
        var t = '';
        (type === 1) ? t = 'Residential' : t = 'Business';
        return t
    }

    function formatDateTime(dateTime) {
        return moment(dateTime).format('YYYY-MM-DD, H:mm:ss');
    }

    // edit dmo vdo
    $(document).on('click', '.edit_master_tariff_codes', function (e) {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('master_tariff_codes_modal'), {});
        myModal.show();
        master_tariff_codes_id = $(this).attr('data-id');
        $('#master_tariff_codes_modal').find('.title').text('Edit Master Tariff Code');
        $('select[name=distributor]').val($(this).attr('data-distributor_id')).change();
        $('select[name=property_type]').val($(this).attr('data-property_type')).change();
        $('select[name=tariff_type]').val($(this).attr('data-tariff_type')).change();
        $('select[name=units_type]').val($(this).attr('data-units_type')).change();
        $('input[name=tariff_code]').val($(this).attr('data-tariff_code'));
        if ($(this).attr('data-status') == 1)
            $('#master_tariff_status_enabled').prop('checked', true);
        else
            $('#master_tariff_status_disabled').prop('checked', true);
    });

    //delete target
    $(document).on('click', '.delete_master_tariff_codes', function (e) {
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
                axios.delete("/settings/delete-master-tariff-codes/" + id)
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

    $('#import_form_submit_btn').click(function (event) {
        event.preventDefault();

        removeValidationErrors();
        CardLoaderInstance.show('#import_modal .modal-content');

        let formData = new FormData();
        var fileInput = document.querySelector('#file');
        formData.append('file', (fileInput.files[0] == undefined) ? '' : fileInput.files[0]);

        var method = $(this).closest('#import_form').find('input[name=method]:checked').val();
        formData.append('method', (method == undefined) ? '' : method);

        var url = '/settings/import-master-tariff-codes'
        axios.post(url, formData)
            .then(response => {
                if (response.data.status == true) {
                    $('#import_modal').modal('hide');
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
        });
    });

    $(document).on('click', '.dropdown_change_status', function () {
        var status = $(this).data('status');
        var ids = []
        $.each($('.check-row:checked'), function (index, item) {
            ids.push($(item).val());
        });
        if (ids.length === 0) {
            toastr.error('Please select at least one row');
            return false;
        }
        var formData = new FormData()
        formData.append('ids', ids);
        formData.append('status', status);
        CardLoaderInstance.show('#target_table');
        axios.post('/settings/change-master-tariff-codes-status-bulk', formData)
            .then(response => {
                if (response.data.status == true) {
                    $('.check-all').prop('checked', false);
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
        });
    });

    $(".resetbutton").on('click', function () {
        $('#master_tariff_codes_filters')[0].reset();
        $('#master_tariff_codes_filters select[name=filter_tariff_type]').val('').change();
        $('#master_tariff_codes_filters select[name=filter_status]').val('').change();
        data_table.columns().search('').draw();
    });

    const showValidationMessages = (errors) => {
        $.each(errors, function (key, value) {
            var input = $("input[name='" + key + "']");
            var select2_id = $("#" + key);

            $(input).next('span.errors').text(value).fadeIn();
            $(input).css('border-color', 'red');

            // if select2
            var error_field = $(select2_id).nextAll('.errors').text(value).fadeIn();
            $(error_field).parent().find('.select2-selection').css('border-color', 'red');
        });
    }

    const removeValidationErrors = () => {
        $("span.errors").text('').hide();
        $("input").css('border-color', '');
        $(".select2-selection").css('border-color', '');
    }
</script>
