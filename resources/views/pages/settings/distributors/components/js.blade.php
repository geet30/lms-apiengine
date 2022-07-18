<script>
    var distributor_table = '', data_table = '';

    var input = document.querySelector('input[name="post_codes"]');
    var postcodes = new Tagify(input);

    loadFromServer();

    $(document).on('click', '.distributor-status', function () {
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
                axios.get("/settings/change-distributors-status/" + $(this).attr('data-id'))
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

    $('#distributor_form_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('#distributor_modal .modal-content');
        let formData = $('#distributor_form').serialize();
        var url = '/settings/post-distributors'
        axios.post(url, formData)
            .then(response => {
                if (response.data.status == true) {
                    $('#distributor_modal').modal('hide');
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

    $('#apply_distributor_filters').on('click', function (event) {
        event.preventDefault();
        filterDatatable();
    })

    function filterDatatable() {
        var formdata = $('#distributor_filters').serializeArray();
        data_table.column(1).search(formdata[0].value).column(2).search(formdata[1].value).column(3).search(formdata[2].value).draw();
    }

    $('#import_modal').on('hide.bs.modal', () => {
        CardLoaderInstance.hide();
    });

    $('#distributor_modal').on('hide.bs.modal', () => {
        CardLoaderInstance.hide();
    });

    $('#import_modal').on('hidden.bs.modal', () => {
        $('#import_modal input[name=distributor_id]').val('');
        $('#import_form').trigger('reset');
        removeValidationErrors();
    });

    $('#distributor_modal').on('hidden.bs.modal', () => {
        $('#distributor_modal').find('.title').text('Add Distributor');
        $('#distributor_modal input[name=distributor_id]').val('');
        $('#distributor_form').trigger('reset');
        removeValidationErrors();
    });

    function loadFromServer() {
        CardLoaderInstance.show('#target_table');
        axios.post('/settings/get-distributors')
            .then(response => {

                if (response.data.status == 1) {
                    distributor_table = response.data.distributors;
                    loadTable(distributor_table);
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

    function loadTable(distributor_table) {
        if (data_table !== '') {
            data_table.destroy();
        }
        if (distributor_table.length) {
            var html = '';
            html += createTargetTable(distributor_table);
            $('.target_table_data_body').html(html);
        }

        data_table = $("#target_table")
            .on('draw.dt', function () {
                $('.form-check-input.main').prop('checked', false);
                KTMenu.createInstances();
            })
            .DataTable({
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
        var trRow = `<tr id="distributor-tr">
                <td><span>${count}</span></td>
                <td><span>${tableRow.name}</td>
                <td><span>${getEnergyType(tableRow.energy_type)}</span></td>
                <td><span class="d-none row_status">${tableRow.status == 1 ? 'status_enabled' : 'status_disabled'}</span><span><span ><div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input distributor-status" data-id="${tableRow.id}" type="checkbox" data-status="${tableRow.status}" title="${tableRow.status == 1 ? 'Click to disable' : 'Click to enable'}" name="notifications" ${tableRow.status == 1 ? 'checked' : ''}></div></span></span></td>
                <td class="text-start"><a href="#" class="btn btn-sm btn-light btn-active-light-primary text-nowrap" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                         <span class="svg-icon svg-icon-5 m-0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                             </svg>
                         </span>
                     </a>
                     <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                         <div class="menu-item ">
                             <span class="menu-link import_post_codes"  data-id="${tableRow.id}" data-bs-toggle="modal" data-bs-target="#import_modal">Import Post Codes</span>
                         </div>
                         <div class="menu-item">
                             <span class="menu-link edit_distributor" data-id="${tableRow.id}" data-distributor_name="${tableRow.name}" data-energy_type="${tableRow.energy_type}" data-service_id="${tableRow.service_id}" data-status="${tableRow.status}" data-service_id="${tableRow.service_id}">Edit</span>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link delete_distributor"  data-id="${tableRow.id}">Delete</span>
                         </div>
                     </div>
                 </td></tr>`;
        return trRow;
    }

    function getEnergyType(type) {
        var t = '';
        if(type === 1)
            t = 'Electricity'
        else if(type === 2)
            t = 'Gas';
        else if(type === 3)
            t = 'LPG'
        else
            t = '-'
        return t
    }

    // edit distributor
    $(document).on('click', '.edit_distributor', function (e) {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('distributor_modal'), {});
        myModal.show();
        distributor_id = $(this).attr('data-id');
        getPostCodes(distributor_id);
        $('#distributor_modal').find('.title').text('Edit Distributor');
        $('#distributor_modal input[name=distributor_id]').val($(this).attr('data-id'));
        $('#distributor_modal input[name=distributor_name]').val($(this).attr('data-distributor_name'));
        if ($(this).attr('data-energy_type') == 1)
            $('#distributor_modal #energy_type_electricity').prop('checked', true);
        else if($(this).attr('data-energy_type') == 2)
            $('#distributor_modal #energy_type_gas').prop('checked', true);
        else if($(this).attr('data-energy_type') == 3)
            $('#distributor_modal #energy_type_lpg').prop('checked', true);
    });

    // import post codes
    $(document).on('click', '.import_post_codes', function (e) {
        $('#import_modal input[name=distributor_id]').val($(this).attr('data-id'));
    });

    function getPostCodes(id) {
        CardLoaderInstance.show('.modal-content');
        axios.get('/settings/get-distributor-post-codes/'+id)
            .then(response => {
                var postcodes = response.data.distributor_post_codes;
                $('#post_codes').val(postcodes)
            })
            .catch(error => {
                console.log(error);
                toastr.error('Whoops! something went wrong.');
            })
            .then(() => {
                CardLoaderInstance.hide();
            });
    }

    //delete target
    $(document).on('click', '.delete_distributor', function (e) {
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
                axios.delete("/settings/delete-distributors/" + id)
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
        formData.append('distributor_id', $('#import_form input[name=distributor_id]').val());

        var url = '/settings/import-distributor-post-codes';
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

    $(".resetbutton").on('click', function () {
        $('#distributor_filters')[0].reset();
        $('#distributor_filters select[name=filter_energy_type]').val('').change();
        $('#distributor_filters select[name=filter_status]').val('').change();
        data_table.columns().search('').draw();
    });

    $('#remove_all_postcodes').on('click', function (e){
        e.preventDefault();
        postcodes.removeAllTags();
    })

    const showValidationMessages = (errors) => {
        $.each(errors, function (key, value) {
            var input = $("input[name='" + key + "']");

            var clas = $("#"+key+"_electricity");

            if(key.indexOf(".") != -1){
                var arr = key.split(".");
                input = $("input[name="+arr[0]+"]");
            }
            $(input).next('span.errors').text(value).fadeIn();
            $(input).css('border-color', 'red');

            $(clas[0]).closest('.field-holder').find('span.errors').text(value).fadeIn();
        });
    }

    const removeValidationErrors = () => {
        $("span.errors").text('').hide();
        $("input").css('border-color', '');
        $(".select2-selection").css('border-color', '');
    }
</script>
