<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<script>
    var pageNumber = 2, processing = false;

    $('#search_tags').keyup(function() {
        dataTable.search($(this).val()).draw();
    })

    $(document).on('click', '.add-button', function() {
        $('.for-all-plans').show();
        $('form[name="add_update_tag_form"]')[0].reset();
        $('span.error').empty();
        $("select[name='rank']").empty();
        for (var i = 0; i <= $(this).data('count'); i++) {
            $("select[name='rank']").append('<option value="' + (i + 1) + '">' + (i + 1) +
                '</option>');
        }
        $("select[name='rank']").val($(this).data('count') + 1);
        $('.for-all-tr').show();
        $('.modal-title').text('Add Tag');
    });
    //add-update API Key
    $(document).on('submit', '#add_update_tag_form', function(e) {
        e.preventDefault();
        let submitButton = $(this).find('.submit_button');
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true)
        loaderInstance.show();
        $('#add_update_tag_form').find('input').css('border-color', '');
        let formData = new FormData($(this)[0]);
        var url = '/settings/tags/store';
        axios.post(url, formData)
            .then(function(response) {
                if (response.data.status == true) {
                    toastr.success(response.data.message);
                    if(response.data.added == true){
                        $('input[name=name]').val('');
                    }
                    $('#tag_body').html('');
                    var i = 0;
                    var tag_html = `
                                    <tr>
                                        <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                                    </tr>`;
                    response.data.tags.forEach(element => {
                        tag_html = `<tr>
                <td>${++i}</td>
                <td>${element.name }</td>
                <td class="text-center">`;
                        if (element.is_highlighted == 1) {
                            tag_html += `
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>`;
                        } else {
                            tag_html +=
                                `<a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }
                        tag_html += `</td>
                <td class="text-center">`;
                        if (element.is_top_of_list == 1)
                            tag_html += `
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>
                            <input size="1" readonly="readonly" name="animal" type="text" value=${ element.rank }>`;
                        else {
                            tag_html +=
                                ` <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }
                        tag_html += `</td>

                <td class="text-center">`;
                        if (element.is_one_in_state == 1) {
                            tag_html += `<a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>`;
                        } else {
                            tag_html +=
                                ` <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }

                        tag_html += `
                </td>
                <td>`;
                        tag_html +=
                        `${element.created_at}`;
                        tag_html += `</td>
                <td>
                    <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item">
                            <span class="menu-link api_popup" data-count=5 data-id="${element.id}" data-name="${element.name}" data-highlighted="${element.is_highlighted}" data-toplist="${element.is_top_of_list}" data-onestate="${element.is_one_in_state}"  data-rank="${element.rank}"><i class="bi bi-pencil-square"></i> Edit</span>
                        </div>
                        <div class="menu-item ">
                            <a type="button" data-id="${element.id }" class="menu-link px-3 delete_tag"><i class="bi bi-trash"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>`;
                        $('#tag_body').append(tag_html);
                        KTMenu.createInstances();
                    });
                }
            }).catch(function(error) {
                loaderInstance.hide();
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        $('[name="' + key + '"]').parent().find('span.error').empty().addClass(
                            'text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                } else if (error.response.status == 400) {
                    toastr.error(error.response.message);
                }
                return false;
            })
            .then(function() {
                submitButton.attr('data-kt-indicator', 'off');
                submitButton.prop('disabled', false);
                // always executed
            });
    });

    $(document).on("change", "input[name='isTopOfList']", function() {
        if ($(this).prop('checked') == false) {
            $("select[name='rank']").hide();
        } else {
            $("select[name='rank']").show();
        }

    });

    $(document).on('click', '.api_popup', function(e) {
        $('.popheading').text('Update');
        var myModal = new bootstrap.Modal(document.getElementById("addtagmodal"), {});
        myModal.show();
        var id = $(this).data('id');
        $('.for-all-tr').hide();
        $('span.form_error').hide();
        $('#add_update_tag_form').find('input').css('border-color', '');
        $("#editApiKeyModel").modal('show');
        $("select[name='rank']").empty();
        $('input[name=tagId]').val($(this).data('id'));
        $('input[name=name]').val($(this).data('name'));
        if ($(this).data('highlighted') == 1) {
            $("input[name='isHighlighted']").prop('checked', true).change();
        } else {
            $("input[name='isHighlighted']").prop('checked', false).change();
        }
        if ($(this).data('toplist') == 1) {
            $("input[name='isTopOfList']").prop('checked', true).change();
            for (var i = 0; i <= $(this).data('count'); i++) {
                $("select[name='rank']").append('<option value="' + (i + 1) + '">' + (i + 1) + '</option>');
            }
            $("select[name='rank']").show();
            $("select[name='rank']").val($(this).data('rank'));

        } else {
            $("input[name='isTopOfList']").prop('checked', false).change();
            for (var i = 0; i <= $(this).data('count'); i++) {
                $("select[name='rank']").append('<option value="' + (i + 1) + '">' + (i + 1) + '</option>');
            }
            $("select[name='rank']").val($(this).data('count') + 1);
        }
        if ($(this).data('onestate') == 1) {
            $("input[name='isOneInState']").prop('checked', true).change();
        } else {

            $("input[name='isOneInState']").prop('checked', false).change();
        }
        $("input[name='setForAll']").prop('checked', true).change();
        $('.for-all-plans').hide();
        $('.modal-title').text('Edit Tag');
        $('span.error').empty();
    });

    $(document).on('click', '.delete_tag', function(event) {
        var id = $(this).data('id');
        pageNumber = 1
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/settings/tags/delete/' + id + '?page=' + pageNumber,
                    type: 'GET',
                    dataType: 'JSON',
                    headers: {
                        'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id
                    },
                    success: (data) => {
                        loaderInstance.hide();
                        if (data.status == true) {
                            toastr.success(data.message);
                            $('#tag_body').html('');
                    var i = 0;
                    var tag_html = `
                                    <tr>
                                        <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                                    </tr>`;
                    data.tags.forEach(element => {
                        tag_html += `<tr>
                <td>${++i}</td>
                <td>${element.name }</td>
                <td class="text-center">`;
                        if (element.is_highlighted == 1) {
                            tag_html += `
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>`;
                        } else {
                            tag_html +=
                                `<a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }
                        tag_html += `</td>
                <td class="text-center">`;
                        if (element.is_top_of_list == 1)
                            tag_html += `
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>
                            <input size="1" readonly="readonly" name="animal" type="text" value=${ element.rank }>`;
                        else {
                            tag_html +=
                                ` <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }
                        tag_html += `</td>

                <td class="text-center">`;
                        if (element.is_one_in_state == 1) {
                            tag_html += `<a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>`;
                        } else {
                            tag_html +=
                                ` <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }

                        tag_html += `
                </td>
                <td>`;
                        tag_html +=
                        `${element.created_at}`;
                        tag_html += `</td>
                <td>
                    <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item">
                            <span class="menu-link api_popup" data-count=5 data-id="${element.id}" data-name="${element.name}" data-highlighted="${element.is_highlighted}" data-toplist="${element.is_top_of_list}" data-onestate="${element.is_one_in_state}"  data-rank="${element.rank}"><i class="bi bi-pencil-square"></i> Edit</span>
                        </div>
                        <div class="menu-item ">
                            <a type="button" data-id="${element.id }" class="menu-link px-3 delete_tag"><i class="bi bi-trash"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>`;
                    $('#tag_body').html(tag_html);
                            KTMenu.createInstances();
                    });

                        }
                    },
                    error: function(error) {
                        // if(error.status == 422) {
                        //     errors = error.responseJSON;
                        //     $.each(errors.errors, function(key, value) {
                        //         $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        //     });
                        // }
                        loaderInstance.hide();
                    }
                });
            }
        });
    });

    $(".resetbutton").on('click', function() {
        $('#tag_filters')[0].reset();
        $("#apply_tag_filters").trigger("click");
    });

    $('#apply_tag_filters').click(function(e) {
        e.preventDefault();
        pageNumber = 1;
        getFilterData();
    });

    function getFilterData(type) {
        processing = true;
        var sub = '';
        let myForm = document.getElementById('tag_filters');
        let formData = new FormData(myForm);

        var url = '/settings/tags?page=' + pageNumber;
        axios.post(url, formData)
            .then(function(response) {

                if (response.data.tags.length > 0) {
                    processing = false;
                    $('#tag_body').html('');
                    var html = '';
                    $.each(response.data.tags, function(key, val) {
                        checked = '';

                        html += `<tr>
                <td>${key + 1}</td>
                <td>${val.name }</td>
                <td class="text-center">`;
                        if (val.is_highlighted == 1) {
                            html += `
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>`;
                        } else {
                            html +=
                                `<a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }
                        html += `</td>
                <td class="text-center">`;
                        if (val.is_top_of_list == 1)
                            html += `
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>
                            <input size="1" readonly="readonly" name="animal" type="text" value=${ val.rank }>`;
                        else {
                            html +=
                                ` <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }
                        html += `</td>

                <td class="text-center">`;
                        if (val.is_one_in_state == 1) {
                            html += `<a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>`;
                        } else {
                            html +=
                                ` <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>`;
                        }

                        html += `
                </td>
                <td>`;
                        html +=
                            `${val.created_at}`;
                        html += `</td>
                <td>
                    <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item">
                            <span class="menu-link api_popup" data-count=5 data-id="${val.id}" data-name="${val.name}" data-highlighted="${val.is_highlighted}" data-toplist="${val.is_top_of_list}" data-onestate="${val.is_one_in_state}"  data-rank="${val.rank}"><i class="bi bi-pencil-square"></i> Edit</span>
                        </div>
                        <div class="menu-item ">
                            <a type="button" data-id="${val.id }" class="menu-link px-3 delete_tag"><i class="bi bi-trash"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>`;
                    });
                    pageNumber = 2;
                    dataTable.destroy();
                    $('#tag_body').html(html);
                    dataTable = $("#tags_table").DataTable({
                        responsive: false,
                        searching: true,
                        "sDom": "tipr",
                    });
                    KTMenu.createInstances();

                } else {
                    // if (type != 'scroll') {
                        dataTable.destroy();
                        dataTable = $("#tags_table").DataTable({
                            responsive: false,
                            searching: true,
                            "sDom": "tipr",
                        });
                        $('#tag_body').html('<td colspan="7" align="center">No matching records found</td>');
                    // }
                    // processing = true;
                }

            })
            .catch(function(error) {
                console.log(error);
            });

    }
</script>
