<script>
    var dmo_vdo_table = '', dmo_vdo_id = '', data_table = '';

    loadFromServer();

    $('#dmo_vdo_form_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('.modal-content');
        let formData = $('#dmo_vdo_form').serialize();
        var url = '/settings/post-dmo-vdo'
        if (dmo_vdo_id) {
            url += '/' + dmo_vdo_id
        }
        axios.post(url, formData)
            .then(response => {
                if (response.data.status == true) {
                    $('#dmo_vdo_modal').modal('hide');
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
        if (data_table !== '')
            data_table.search($(this).val()).draw();
    })

    $('#dmo_vdo_modal').on('hide.bs.modal', () => {
        dmo_vdo_id = '';
        CardLoaderInstance.hide();
    });

    $('#import_modal').on('hidden.bs.modal', () => {
        removeValidationErrors();
    });

    $('#states_modal').on('hidden.bs.modal', () => {
        removeValidationErrors();
    });

    $('#dmo_vdo_modal').on('hidden.bs.modal', () => {
        $('#dmo_vdo_modal').find('.title').text('Add DMO VDO');
        removeValidationErrors();
        $('#dmo_vdo_form').trigger('reset');
        $('select[name=distributor]').val('').change();
        $('select[name=property_type]').val('').change();
        $('select[name=tariff_type]').val('').change();
        $('select[name=offer_type]').val('').change();
    });

    function loadFromServer() {
        CardLoaderInstance.show('#target_table');
        axios.post('/settings/get-dmo-vdo')
            .then(response => {
                if (response.data.status == 1) {
                    dmo_vdo_table = response.data.dmo_vdo;
                    loadTable(dmo_vdo_table);
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

    function loadTable(dmo_vdo_table) {
        if (data_table !== '') {
            data_table.destroy();
        }
        if (dmo_vdo_table.length) {
            var html = '';
            html += createTargetTable(dmo_vdo_table);
            $('.target_table_data_body').html(html);
        }

        data_table = $("#target_table")
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
        $.each(targetArr, function (key, val) {
            html += createTableRow(val, key+1);
        });
        return html;
    }

    function createTableRow(tableRow, count) {
        var trRow = `<tr id="sftp-tr">
                <td><span>${count}</span></td>
                <td><span>${tableRow.distributor_name}</td>
                <td>
                    <div class="marquee bluebox">
                      <span><span>${tableRow.tariff_types}</span></span>
                    </div>
                </td>
                <td><span>${getOfferType(tableRow.offer_type)}</span></td>
                <td><span>${getPropertyType(tableRow.property_type)}</span></td>
                <td><span>${tableRow.annual_price}</span></td>
                <td><span>${tableRow.annual_usage}</span></td>
                <td class="text-start"><a href="#" class="btn btn-sm btn-light btn-active-light-primary text-nowrap" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                         <span class="svg-icon svg-icon-5 m-0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                             </svg>
                         </span>
                     </a>
                     <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                         <div class="menu-item">
                             <span class="menu-link edit_dmo_vdo" data-id="${tableRow.id}" data-distributor_id="${tableRow.distributor_id}" data-property_type="${tableRow.property_type}" data-tariff_type="${tableRow.tariff_type}" data-tariff_name="${tableRow.tariff_name}" data-offer_type="${tableRow.offer_type}" data-annual_price="${tableRow.annual_price}" data-peak_only="${tableRow.peak_only}" data-peak_offpeak_peak="${tableRow.peak_offpeak_peak}" data-peak_offpeak_offpeak="${tableRow.peak_offpeak_offpeak}" data-peak_shoulder_peak="${tableRow.peak_shoulder_peak}" data-peak_shoulder_offpeak="${tableRow.peak_shoulder_offpeak}" data-peak_shoulder_shoulder="${tableRow.peak_shoulder_shoulder}" data-peak_shoulder_1_2_peak="${tableRow.peak_shoulder_1_2_peak}" data-peak_shoulder_1_2_offpeak="${tableRow.peak_shoulder_1_2_offpeak}" data-peak_shoulder_1_2_shoulder_1="${tableRow.peak_shoulder_1_2_shoulder_1}" data-peak_shoulder_1_2_shoulder_2="${tableRow.peak_shoulder_1_2_shoulder_2}" data-control_load_1="${tableRow.control_load_1}" data-control_load_2="${tableRow.control_load_2}" data-control_load_1_2_1="${tableRow.control_load_1_2_1}" data-control_load_1_2_2="${tableRow.control_load_1_2_2}" data-annual_usage="${tableRow.annual_usage}">Edit</span>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link delete_dmo_vdo"  data-id="${tableRow.id}">Delete</span>
                         </div>
                     </div>
                 </td></tr>`;
        return trRow;
    }

    function getOfferType(type){
        var t = '';
        (type === 1) ? t = 'DMO' : t = 'VDO';
        return t
    }

    function getPropertyType(type){
        var t = '';
        (type === 1) ? t = 'Residential' : t = 'Business';
        return t
    }

    // edit dmo vdo
    $(document).on('click', '.edit_dmo_vdo', function (e) {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('dmo_vdo_modal'), {});
        myModal.show();

        dmo_vdo_id = $(this).attr('data-id');
        $('#dmo_vdo_modal').find('.title').text('Edit DMO VDO');
        $('select[name=distributor]').val($(this).attr('data-distributor_id')).change();
        $('select[name=property_type]').val($(this).attr('data-property_type')).change();
        $('select[name=tariff_type]').val($(this).attr('data-tariff_type')).change();
        $('input[name=tariff_name]').val($(this).attr('data-tariff_name'));
        $('select[name=offer_type]').val($(this).attr('data-offer_type')).change();
        $('input[name=annual_price]').val($(this).attr('data-annual_price'));
        $('input[name=peak_only]').val($(this).attr('data-peak_only'));
        $('input[name=peak_offpeak_peak]').val($(this).attr('data-peak_offpeak_peak'));
        $('input[name=peak_offpeak_offpeak]').val($(this).attr('data-peak_offpeak_offpeak'));
        $('input[name=peak_shoulder_peak]').val($(this).attr('data-peak_shoulder_peak'));
        $('input[name=peak_shoulder_offpeak]').val($(this).attr('data-peak_shoulder_offpeak'));
        $('input[name=peak_shoulder_shoulder]').val($(this).attr('data-peak_shoulder_shoulder'));
        $('input[name=peak_shoulder_1_2_peak]').val($(this).attr('data-peak_shoulder_1_2_peak'));
        $('input[name=peak_shoulder_1_2_offpeak]').val($(this).attr('data-peak_shoulder_1_2_offpeak'));
        $('input[name=peak_shoulder_1_2_shoulder_1]').val($(this).attr('data-peak_shoulder_1_2_shoulder_1'));
        $('input[name=peak_shoulder_1_2_shoulder_2]').val($(this).attr('data-peak_shoulder_1_2_shoulder_2'));
        $('input[name=control_load_1]').val($(this).attr('data-control_load_1'));
        $('input[name=control_load_2]').val($(this).attr('data-control_load_2'));
        $('input[name=control_load_1_2_1]').val($(this).attr('data-control_load_1_2_1'));
        $('input[name=control_load_1_2_2]').val($(this).attr('data-control_load_1_2_2'));
        $('input[name=annual_usage]').val($(this).attr('data-annual_usage'));
    });

    //delete target
    $(document).on('click', '.delete_dmo_vdo', function (e) {
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
                axios.delete("/settings/delete-dmo-vdo/" + id)
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

    $('#states_form_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('#states_modal .modal-content');
        let formData = $('#states_form').serialize();
        var url = '/settings/post-dmo-vdo-states'
        axios.post(url, formData)
            .then(response => {
                if (response.data.status == true) {
                    $('#states_modal').modal('hide');
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

    $('#import_form_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('#import_modal .modal-content');
        var fileInput = document.querySelector('#file');
        let formData = new FormData();
        formData.append('file', fileInput.files[0]);
        var url = '/settings/import-dmo-vdo'
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
            KTMenu.createInstances();
        });
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
