<script>
    let suburbs = [];
    let postcodeSuburbs = [];
    let userSubrubs = [];

    let suburbTable = $('#suburb-table')
        .on('draw.dt', function () {
            $('.form-check-input.main').prop('checked', false);
        })
        .DataTable({
            columnDefs: [
                {"orderable": false, "targets": 0}
            ],
            searching: true,
            ordering: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6 d-flex'li><'col-sm-6'p>>",
        });

    $('#apply_suburb_filters').on('click', function (event) {
        event.preventDefault();
        filterSuburbDatatable();
    })

    function filterSuburbDatatable() {
        var formdata = $('#suburb_filters').serializeArray();
        CardLoaderInstance.show('#suburb-table')
        $('#apply_suburb_filters').prop('disabled', true);
        setTimeout(function () {
            suburbTable.column(2).search(formdata[0].value).column(3).search(formdata[1].value).column(4).search(formdata[2].value).column(5).search(formdata[3].value).draw();
            CardLoaderInstance.hide()
            $('#apply_suburb_filters').prop('disabled', false);
        }, 500);
    }

    $(".reset_suburb_filter").on('click', function () {
        $('#suburb_filters')[0].reset();
        $('#suburb_filters select[name=filter_state]').val('').change();
        $('#suburb_filters select[name=filter_status]').val('').change();
        suburbTable.columns().search('').draw();
    });

    $('#suburb-modal').on('hidden.bs.modal', function () {
        $('#assign_suburb_form')[0].reset();
        $('#assign_suburb_form [name=state_id]').val('').change();
        $('#assign_suburb_form #suburbs').val('').change();
        removeValidationErrors();
    })

    $('.assign_suburb_submit_btn').click(function () {
        removeValidationErrors()
        CardLoaderInstance.show('#suburb-modal .modal-content');
        let formData = $('#assign_suburb_form').serialize();
        formData += "&provider_id={{encryptGdprData($providerdetails[0]['user_id'])}}";
        axios.post("/provider/assign-suburbs", formData)
            .then(function (response) {
                loaderInstance.hide();
                $('#suburb-modal').modal('hide');
                toastr.success(response.data.message)
                window.location.reload();
            }).catch(function (error) {
            loaderInstance.hide();
            if (error.response.status == 422) {
                showValidationMessages(error.response.data.errors)
            }
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        })
            .then(()=>{
                CardLoaderInstance.hide()
            });
    });


    $('#add-suburb-modal').on('hidden.bs.modal', function () {
        $('#add_suburb_form')[0].reset();
        $('#add_suburb_form [name=state]').val('').change();
        $('#add_suburb_form #suburb').val('').change();
        removeValidationErrors();
    })

    $('.add_suburb_submit_btn').click(function () {
        removeValidationErrors()
        CardLoaderInstance.show('#add-suburb-modal .modal-content');
        let formData = $('#add_suburb_form').serialize();
        axios.post("/provider/add-suburbs/"+'{{encryptGdprData($providerdetails[0]['user_id'])}}', formData)
            .then(function (response) {
                if(response.data.status == 200){
                    $('#add-suburb-modal').modal('hide');
                    toastr.success(response.data.message)
                    window.location.reload();
                } else {
                    toastr.error(response.data.message);
                }
            }).catch(function (error) {
                if (error.response.status == 422) {
                    showValidationMessages(error.response.data.errors)
                }
                if (error.response.status && error.response.data.message)
                    toastr.error(error.response.data.message);
                else
                    toastr.error('Whoops! something went wrong.');
            })
            .then(()=>{
               CardLoaderInstance.hide()
            });
    });

    $(document).ready(function () {
        $('a[data-bs-toggle="tab"]').on('click', function (e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('.linkprovider-tab a[href="' + activeTab + '"]').tab('show');
        }
    });

    $('#assign_suburb_form [name=state_id]').change(function () {
        let state_id = $('#assign_suburb_form [name=state_id]').val();
        if (!state_id) {
            return false;
        }
        loaderInstance.show();
        $('#custom_loader').css('z-index', 9999);
        if (suburbs[state_id] && suburbs[state_id].length) {
            setStateSuburbs()
        } else {
            getStateSuburbs();
        }
    })

    const getStateSuburbs = () => {
        let state_id = $('#assign_suburb_form [name=state_id]').val();
        let formData = {
            state_id,
            'provider_id': "{{encryptGdprData($providerdetails[0]['user_id'])}}"
        }
        axios.post("/provider/get-suburbs", formData)
            .then(function (response) {
                suburbs[state_id] = response.data.suburbs.suburbs;
                userSubrubs = response.data.assignedSubrubs;
                setStateSuburbs();
            }).catch(function (error) {
            loaderInstance.hide();
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        })
    }

    const setStateSuburbs = () => {
        let state_id = $('#assign_suburb_form [name=state_id]').val();
        $('#assign_suburb_form #suburbs').html('');
        var uniqueSub = "";
        var html = ``;
        if (suburbs[state_id].length > 0) {
            html = `<option value="select_all">Select All</option>`;
            suburbs[state_id].forEach(element => {
                var sub = element.suburb;
                if (uniqueSub != sub) {
                    html += `<option value="${element.id}" ${userSubrubs.includes(element.id) ? 'selected' : ''}>${element.suburb}</option>`;
                }
                uniqueSub = sub;
            });
            $('#assign_suburb_form #suburbs').append(html);
        }
        $('#assign_suburb_form #suburbs').select2({
            placeholder: "Select Suburb",
            allowClear: true
        });
        $('#assign_suburb_form #suburbs').change();
        loaderInstance.hide();
    }

    $(document).on('change', '#suburb', function () {
        let selected = $(this).val();
        console.log(selected);
        if (selected != '') {
            if (selected == 'all') {
                $(".postcodesSuburb option").prop("selected", true);
                $(".postcodesSuburbb option[value='all']").prop("selected", false);
                $('.postcodesSuburb #suburb').select2({
                    placeholder: "Select Suburb",
                    allowClear: true
                });
            }
        }
    });

    $('[name=assign_postcode_state_id]').change(function () {
        let state_id = $(this).val();
        if (!state_id) {
            return false;
        }
        loaderInstance.show();
        $('#custom_loader').css('z-index', 9999);
        if (postcodeSuburbs[state_id] && postcodeSuburbs[state_id].length) {
            setPostcodeStateSuburbs()
        } else {
            getPostcodeStateSuburbs();
        }
    })

    const getPostcodeStateSuburbs = () => {
        let state_id = $('[name=assign_postcode_state_id]').val();
        if (!state_id) {
            return false;
        }

        let formData = {
            state_id,
            'provider_id': "{{encryptGdprData($providerdetails[0]['user_id'])}}"
        }
        axios.post("/provider/get-postcode-suburbs", formData)
            .then(function (response) {
                postcodeSuburbs[state_id] = response.data.assignedSubrubs;
                setPostcodeStateSuburbs();
            }).catch(function (error) {
            loaderInstance.hide();
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        })
    }

    const setPostcodeStateSuburbs = () => {
        let state_id = $('[name=assign_postcode_state_id]').val();
        if (!state_id) {
            return false;
        }
        $('[name=assign_postcode_suburb_id]').html('');
        postcodeSuburbs[state_id].forEach(element => {
            $('[name=assign_postcode_suburb_id]').append(`
                <option value="${element.subrubs.suburb}" ${userSubrubs.includes(element.subrubs.suburb) ? 'selected' : ''}>${element.subrubs.suburb}</option>
            `);
        });
        $('[name=assign_postcode_suburb_id]').change();
        loaderInstance.hide();
    }

    $('[name=assign_postcode_suburb_id]').change(function () {
        let postcodes = [];
        let state_id = $('[name=assign_postcode_state_id]').val();
        let suburb_id = $(this).val();
        if (!state_id) {
            return false;
        }
        let formData = {
            'suburb': suburb_id
        }
        loaderInstance.show();
        axios.post("/provider/get-postcode-postcodes", formData)
            .then(function (response) {
                postcodePostcodes[suburb_id] = response.data.postcodes;
                $('#assign_postcode_postcode_id').html('');
                postcodePostcodes[suburb_id].forEach(element => {
                    $('#assign_postcode_postcode_id').append(`
                        <option value="${element.id}">${element.postcode}</option>
                        `);
                });
                loaderInstance.hide();


            }).catch(function (error) {
            loaderInstance.hide();
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        })

    })

    //Change Status suburb
    $(document).on('click', '.changeSuburbStatus', function (e) {
        var check = $(this);
        var status = 0;
        var id = check.data("id");
        var isChecked = check.is(':checked');
        if (check.is(':checked'))
            status = 1;

        var url = '/provider/change-suburb-status';
        var formdata = {
            id,
            status
        };
        Swal.fire({
            title: "{{trans('affiliates.warning_msg_title')}}",
            text: "{{trans('affiliates.warning_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('affiliates.yes_text')}}",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(url, formdata)
                    .then((response) => {

                        if (response.data.status == 400) {
                            toastr.error(response.data.message);
                            if (isChecked) {
                                check.prop('checked', false);
                            } else {
                                check.prop('checked', true);
                            }
                        } else {
                            suburbTable.destroy();
                            $(this).closest('td').find('.row_status').text($(this).is(':checked') ? 'status_enabled' : 'status_disabled');
                            suburbTable = $('#suburb-table')
                                .on('draw.dt', function () {
                                    $('.form-check-input.main').prop('checked', false);
                                })
                                .DataTable({
                                    columnDefs: [
                                        {"orderable": false, "targets": 0}
                                    ],
                                    searching: true,
                                    ordering: true,
                                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                    "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6 d-flex'li><'col-sm-6'p>>",
                                });
                            toastr.success(response.data.message);
                        }

                    })
                    .catch(function (error) {
                        if (isChecked)
                            check.prop('checked', false);
                        else
                            check.prop('checked', true);

                        if (error.response.status && error.response.data.message)
                            toastr.error(error.response.data.message);
                        else
                            toastr.error('Whoops! something went wrong.');
                    })
                    .then(function () {

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

    //Delete suburb
    $(document).on('click', '.deleteSuburb', function (e) {
        e.preventDefault();
        var check = $(this);
        var id = check.data("id");
        var url = '/provider/delete-suburb';
        var providerId = '{{request()->segment(3)}}';
        var formdata = {
            id,
            providerId
        };
        Swal.fire({
            title: "{{trans('affiliates.warning_msg_title')}}",
            text: "{{trans('affiliates.delete_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('affiliates.yes_text')}}",
        }).then(function (result) {
            if (result.isConfirmed) {
                CardLoaderInstance.show('.tab-content');
                axios.post(url, formdata)
                    .then(function (response) {
                        if (response.data.status == 400) {
                            toastr.error(response.data.message);
                        } else {
                            check.closest('tr').remove();
                            toastr.success(response.data.message);
                        }
                        CardLoaderInstance.hide();
                    })
                    .catch(function (error) {
                        CardLoaderInstance.hide();
                        if (error.response.status && error.response.data.message)
                            toastr.error(error.response.data.message);
                        else
                            toastr.error('Whoops! something went wrong.');
                    })
                    .then(function () {
                        CardLoaderInstance.hide();
                    });
            }
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
        axios.post('/provider/change-suburb-status-bulk', formData)
            .then(response => {
                if (response.data.status == true) {
                    $('.check-all').prop('checked', false);
                    toastr.success(response.data.message);
                    window.location.reload();
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

    $("#assign_suburb_form #suburbs").on('change', function () {
        if ($(this).children("option[value=select_all]:selected").length > 0) {
            $(this).children('option').prop('selected', true);
            $(this).children('option[value=select_all]').prop('selected', false);
        }
    });

    $('#suburb-tab-panel #import_modal').on('hidden.bs.modal', () => {
        $('#suburb-tab-panel #import_modal #file').val('');
        removeValidationErrors();
    });


    $('#suburb-tab-panel #import_form_submit_btn').click(function (event) {
        event.preventDefault();

        removeValidationErrors();
        CardLoaderInstance.show('#suburb-tab-panel #import_modal .modal-content');

        let formData = new FormData();
        var fileInput = document.querySelector('#suburb-tab-panel #import_modal #file');
        formData.append('file', (fileInput.files[0] == undefined) ? '' : fileInput.files[0]);

        var user_id = '{{encryptGdprData($providerdetails[0]['user_id'])}}'
        formData.append('user_id', user_id);

        var url = '/provider/import-suburb-postcodes'
        axios.post(url, formData)
            .then(response => {
                if (response.data.status == true) {
                    $('#import_modal').modal('hide');
                    toastr.success(response.data.message);
                    window.location.reload();
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
</script>
