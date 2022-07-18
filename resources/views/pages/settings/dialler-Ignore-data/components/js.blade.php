<script>
    $(document).ready(function() {

        // Initialize Values
        let type = 1,
            id;
        $('#data_id').val(0);
        var content_name = "Name";
        $("#content_type").text(content_name);
        $("#type").val('1');
        $('#content_name_label').text("Please Enter your " + 'Name');
        $('#content_name').attr('placeholder', 'Your Name');


        // Intialize Values
        $(document).on('click', '.dialler-tab', function() {
            type = $(this).data("id");
            content_name = $(this).data("name");
            $("#content_type").val(content_name);
            $("#type").val(type);
            $('#content_name_label').text("Please Enter your " + content_name);
            $('#content_name').attr("placeholder", 'Your ' + content_name);
            prevLink = $('.previous_btn').data('value');
            pageLink = $('.next_btn').data('value');
        });

        // Set Values for Add Button
        $(document).on('click', '.add_btn_popup', function(event) {
            $('#type_error').text("");
            $('#content_name_error').text("");
            $('#comment_error').text("");

            $("#dialler_ignore_data_form")[0].reset();
            $('#modal_title').text('Add Dialler Ignore Data');
            $("#content_type").text(content_name);
            $("#type").val(type);
            $('#content_name_label').text("Please Enter your " + content_name);
            $('#content_name').attr("placeholder", 'Your ' + content_name);
        });

        // Set Values for Edit Button 
        $(document).on('click', '.edit_btn_popup', function() {
            // event.preventDefault();
            $('#type_error').text("");
            $('#content_name_error').text("");
            $('#comment_error').text("");

            $('#modal_title').text('Edit Dialler Ignore Data');
            $('#content_type').text($(this).data("type"));
            $('#content_name_label').text("Please Enter your " + $(this).data("type"));
            $('#content_name').val($(this).data("value"));
            $('#comment').val($(this).data("comment"));
            $('#type').val($(this).data("type"));
            $('#data_id').val($(this).data("id"));

        });

        // Pagination :-
        // var prevLink;
        var hasPage, hasPrevPage = 1;
        var pageLink,prevLink;
        $(document).on('click', '.next_btn', function(event) {
            event.preventDefault();

            // Getting Values:-
            var error;
            if (typeof pageLink === 'undefined') {
                pageLink = $(this).data('value');
            }
            var hasPage = $(this).data('haspage');
            i = $(this).data('type');

            // Checking Errors:-
            if (hasPage == 0) {
                toastr.warning("No More Page");
                error = 1;
            }
            if (pageLink == 0) {
                error = 1;
            }

            // AJAX If there is no Error:-
            if (!error) {
                $.ajax({
                    url: pageLink,
                    type: "POST",
                    headers: {
                        'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "type": i
                    }
                }).done(function(response) {
                    // Set Variable Data with new Response:-
                    if (response.data.next_page_url != null) {
                        pageLink = response.data.next_page_url;
                        $('.next_btn').attr('data-value', response.data.next_page_url);
                        $('.next_btn').attr('data-haspage', response.data.hasMorePages);
                    } else {
                        hasPage = 0;
                        console.warn("Updating Error ->  Has No More Page");
                        $('.next_btn').attr('data-value', 0);
                        $('.next_btn').attr('data-haspage', 0);
                    }
                    if (response.data.prev_page_url != null) {
                        prevLink = response.data.prev_page_url;
                        $('.previous_btn').attr('data-value', response.data.prev_page_url);
                    } else {
                        console.warn("Updating Error ->  Has No Prev Page");
                        hasPrevPage = 0;
                        $('.previous_btn').attr('data-value', 0);
                    }
                    if (response.data.prev_page_url != null && hasPrevPage == 0) {
                        console.warn("Removing Error ->  Has No Prev Page");
                        hasPrevPage = 1;
                        prevLink = response.data.prev_page_url;
                    }
                    // console.log(response);
                    $('#tag_body_' + i + ' tr').remove();
                    setTableData1(response.data, i);
                    KTMenu.createInstances();
                });
            }
        });

        $(document).on('click', '.previous_btn', function(event) {
            event.preventDefault();

            // Getting Values:-
            var error;
            if (typeof prevLink === 'undefined') {
                prevLink = $(this).data('value');
            }
            i = $(this).data('type');

            // Checking Errors:-
            if (hasPrevPage == 0) {
                toastr.warning("You are Already on First Page");
                error = 1;
            }

            // AJAX If there is no Errors:-
            if (!error) {
                $.ajax({
                    url: prevLink,
                    type: "POST",
                    headers: {
                        'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "type": i
                    }
                }).done(function(response) {
                    // Set Variable Data with new Response:-
                    if (response.data.prev_page_url != null) {
                        prevLink = response.data.prev_page_url;
                        $('.previous_btn').attr('data-value', response.data.prev_page_url);
                    } else {
                        console.warn("Updating Error ->  Has No Prev Page");
                        hasPrevPage = 0;
                        $('.previous_btn').attr('data-value', 0);
                    }
                    if (response.data.next_page_url != null) {
                        pageLink = response.data.next_page_url;
                        $('.next_btn').attr('data-value', response.data.next_page_url);
                        $('.next_btn').attr('data-haspage', response.data.hasMorePages);
                    } else {
                        hasPage = 0;
                        console.warn("Updating Error ->  Has No More Page");
                        $('.next_btn').attr('data-value', 0);
                        $('.next_btn').attr('data-haspage', 0);
                    }
                    if (response.data.next_page_url != null && hasPage == 0) {
                        console.warn("Removing Error ->  Has No More Page");
                        hasPage = 1;
                    }

                    $('#tag_body_' + i + ' tr').remove();
                    setTableData1(response.data, i);
                    KTMenu.createInstances();
                });
            }
        });

        // AXIOS Post Request
        $('#dialler_ignore_data_form_submit_btn').click(function(event) {
            event.preventDefault();
            let typeId = $('#tabId').val();
            // let ID = $('#dId').val();
            let formData = new FormData($('#dialler_ignore_data_form')[0]);
            // formData.append('dId', ID);
            var url = '/settings/add/dialler-ignore'
            axios.post(url, formData)
                .then(function(response) {
                    $('#dialler_ignore_data_modal').modal('hide');
                    $('#tag_body_' + type + ' tr').remove();
                    toastr.success("Added Successfully");
                    setTableData(response.data, type);
                    loaderInstance.hide();
                    KTMenu.createInstances();
                })
                .catch(function(error) {
                    if (error.response.status == 422) {
                        showValidationMessages(error.response.data.errors);
                    }
                    if (error.response.status && error.response.data.message)
                        toastr.error(error.response.data.message);
                    else
                        toastr.error('Whoops! something went wrong.');

                });

        });

        // AXIOS Post Request For Delete
        $(document).on('click', '.delete_btn_dialler', function() {
            let type = $(this).data("type");

            let id = $(this).data("id");
            // alert(type + id);
            // console.log(type + "<- TYPE   ID ->" + id);
            let formData = new FormData();
            formData.append('id', id);
            formData.append('type', type);
            var url = '/settings/delete/dialler-ignore'
            axios.post(url, formData)
                .then(function(response) {
                    toastr.success("Delete Successfully");
                    var i = 1;
                    if (type == 'name') {
                        i = 1;
                    }
                    if (type == 'email') {
                        i = 2;
                    }
                    if (type == 'phone') {
                        i = 3;
                    }
                    if (type == 'domain') {
                        i = 4;
                    }
                    if (type == 'ip') {
                        i = 5;
                    }
                    if (type == 'ip_range') {
                        i = 6;
                    }
                    $('#tag_body_' + i + ' tr').remove();
                    setTableData(response.data, i);
                    loaderInstance.hide();
                })
                .catch(function(error) {
                    if (error.response.status == 422) {
                        toastr.error("Please Try Again Later");
                    }
                    if (error.response.status && error.response.data.message)
                        toastr.error(error.response.data.message);
                    else
                        toastr.error('Whoops! something went wrong.');

                });
        });

        const showValidationMessages = (errors) => {
            $.each(errors, function(key, value) {
                $('#' + key + '_error').addClass('field-error').text(value).fadeIn();
            });
            if ($(".field-error:first").length) {
                $("html, body").animate({
                    scrollTop: $(".field-error:first").offset().top - 150
                }, 1500);
            }
        }



        // *****************
        // Searching Button
        $(".resetbutton").on('click', function() {
            $('#tag_filters')[0].reset();
            $("#apply_search_filter").trigger("click");
        });

        $('#apply_search_filter').click(function(e) {
            e.preventDefault();
            var error;
            // pageNumber = 1;
            if ($('#search_tag').val().length <= 0) {
                error = 1;
                // alert("Please Type Some Value");
            }
            if (!error) {
                getFilterData();
            }
        });
        // $("#search_tag").on('change', function() {
        //     var error;
        //     if ($(this).val().length <= 0) {
        //         error = 1;
        //         alert("Please Type Some Value");
        //     }
        // });

        function getFilterData() {
            processing = true;
            var sub = '';
            let myForm = document.getElementById('tag_filters');
            let formData = new FormData(myForm);
            formData.append('type', type);

            var url = '/settings/search/dialler-data';
            axios.post(url, formData)
                .then(function(response) {
                    // console.log(response.data);
                    if (response.data.length > 0) {
                        $('#tag_body_' + type + ' tr').remove();
                        setTableData(response.data, type);
                        KTMenu.createInstances();
                    } else {
                        $('#tag_body_' + type + ' tr').remove();
                        $('#tag_body_' + type).append(`<tr>
                            <td colspan="5" class="text-center">No Data Found</td>`);
                        toastr.warning("No Data Found");
                    }

                })
                .catch(function(error) {
                    if (error.response.status == 422) {
                        toastr.error("Please Try Again Later");
                    }
                    if (error.response.status && error.response.data.message)
                        toastr.error(error.response.data.message);
                    else
                        toastr.error('Whoops! something went wrong.');

                });

        }
        // ******************
        function setTableData(response, i) {
            // alert(i);
            // console.log(data);
            $.each(response, function(index, val) {
                $('#tag_body_' + i).append(`<tr>
                    <td>${index+1}</td>
                    <td>${val.type_value}</td>
                    <td>${val.comment}</td>
                    <td>${val.created_at}</td>
                    <td>${val.updated_at}</td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                                <div class="menu-item">
                                    <span class="menu-link edit_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-action="edit" data-id="${val.id}" data-type="${val.type}" data-value="${val.type_value}" data-comment="${val.comment}" ><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                                </div>
                                <div class="menu-item ">
                                    <a type="button" data-id="${val.id}" data-type="${val.type}" data-value="${val.type_value}" data-comment="${val.comment}" class="menu-link px-3 delete_btn_dialler"><i class="bi bi-trash"></i> Delete</a>
                                </div>
                            </div>
                        </div>
                    </td>`);
            });
            KTMenu.createInstances();
        }

        function setTableData1(response, i) {
            console.log("Current page ->" + response.current_page + ",  HAS PREV PAGES -> " + response.prev_page_url + ",  HAS MORE PAGES -> " + response.next_page_url);
            var y = 0;
            $.each(response.data, function(index, val) {
                $('#tag_body_' + i).append(`<tr>
                    <td>${response.from+y}</td>
                    <td>${val.type_value}</td>
                    <td>${val.comment}</td>
                    <td>${val.created_at}</td>
                    <td>${val.updated_at}</td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                                <div class="menu-item">
                                    <span class="menu-link edit_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-action="edit" data-id="${val.id}" data-type="${val.type}" data-value="${val.type_value}" data-comment="${val.comment}" ><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                                </div>
                                <div class="menu-item ">
                                    <a type="button" data-id="${val.id}" data-type="${val.type}" data-value="${val.type_value}" data-comment="${val.comment}" class="menu-link px-3 delete_btn_dialler"><i class="bi bi-trash"></i> Delete</a>
                                </div>
                            </div>
                        </div>
                    </td>`);
                y++;
            });
            KTMenu.createInstances();
        }
    });
</script>