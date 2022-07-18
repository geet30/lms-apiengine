<script>

    var newCount = 0;
    var colorsArr = "";
    var colorsActive = 0;
    var pageNumber = 2;
    let colorsDataTable;
    var showColorsDatatable = false;
    var actionPer=false;


    $(document).ready(function () {
        $(document).on('click', '.getcolors', function (e) {
            CardLoaderInstance.show('.tab-content');
            colorsActive = 1;
            filtercolors(e, null, 1);
        });
    });
    //api call on scroll
    $(window).scroll(function (e) {
        if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
            if (colorsActive == 1 && ($('#colors_table tr').length) - 1 > 20) {
                colorsArr = "";
                filtercolors(e, 'scroll');
            }
        }
    });


    $(document).on('click', '.colors_popup', function (e) {
        e.preventDefault();
        $('.colors_heading').html('Edit Mobile Color');
        var myModal = new bootstrap.Modal(document.getElementById("mobile_colors_modal"), {});
        myModal.show();
        $('span.error').hide(); //hide error
        $('.field-holder').find('input').css('border-color', '');
        $("#hidden_edit_id").val($(this).attr('data-id'));
        $('#mobile_colors_form').find('input[name=title]').val($(this).data('title'));
        $('#mobile_colors_form').find('input[name=hexacode]').val($(this).data('hexacode'));
        $('#mobile_colors_form').find('#description').text($(this).data('description'));
        $('#mobile_colors_form').find('.minicolors-swatch-color').css('background-color', $(this).data('hexacode'));

    });

    $('#mobile_colors_modal').on('hide.bs.modal', () => {
        CardLoaderInstance.hide();
    });

    $(document).on("click", ".resetColorsFilter", function (e) {

        $('#searchColors').val("");
        $('#filter_status').val("1").change();
        pageNumber = 1;
        $('#colorsFilter').trigger("reset");
        $('.resetvalues').change();
        colorsArr = "";
        $(".getcolors").trigger("click");
    });

    //filter apply
    function filtercolors(parm = null, type = null, page = null, link = null) {

        if (page) {
            pageNumber = page;
        }
        if (parm != null) {
            parm.preventDefault();
        }

        var url = "/mobile/filter-colors";

        if (colorsArr.length === 0 || colorsArr === "" && type != "scroll" && link != "") {
            axios.post(url + '?page=' + pageNumber)
                .then(function (response) {
                    var html = '';
                    colorsArr = response.data.colorsRecords.data;
                    CardLoaderInstance.hide();
                    if(!response.data.add_per){
                        $("#add_colors").remove();
                    }
                    actionPer = response.data.action_per;
                    html += createcolorsTable(colorsArr,actionPer);


                    if (type == 'scroll') {
                        createcolorsPagination(html, 'append');
                        pageNumber += 1;
                        return;
                    }
                    pageNumber = 2;
                    createcolorsPagination(html, 'html');
                    setColor(colorsArr);
                    var rowCount = ($('#colors_table tr').length) - 1;
                    if (rowCount == 0) {
                        $(".colors_table_data_body").empty().html('<tr class="no_record"><td colspan="7" align="center">No data available in table</td></tr>');

                    }

                })
                .catch(function (error) {
                    console.log(error);
                }).then(function () {
            });
        } else {
            CardLoaderInstance.hide();
            html = createcolorsTable(colorsArr,actionPer);
            pageNumber = 2;
            createcolorsPagination(html, 'html');
            var rowCount = ($('#colors_table tr').length) - 1;
            if (rowCount == 0) {
                $(".colors_table_data_body").empty().html('<tr><td colspan="7" align="center">No data available in table</td></tr>');
            }
        }
    }

    function setColor() {
        $.each(colorsArr, function (index, row) {
            $('.color' + row.id).css('color', row.hexacode);
        });
    }

    function createcolorsPagination(html, type) {
        if (showColorsDatatable != false) {
            colorsDataTable.destroy();
        }
        if (type == 'append') {
            $('.colors_table_data_body').append(html);
        } else {
            $('.colors_table_data_body').html(html);
        }
        showColorsDatatable = true;
        colorsDataTable = $("#colors_table")
            .on('draw.dt', function () {
                KTMenu.createInstances();
                setColor()
            })
            .DataTable({
                searching: true,
                ordering: true,
                "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            });
    }

    function createcolorsTable(colorsArr,actionPer) {
        var html = "";
        var count = 1;
        $.each(colorsArr, function (key, val) {
            html += createcolorsTableRow(val, count,actionPer);
            count++;
        });
        return html;
    }

    //to hide all error on popup add click
    $(document).on('click', '#add_colors', function (e) {
        $("#hidden_edit_id").val("");
        $('span.error').text("").hide();
        $('input').css('border-color', '');
        $('#mobile_colors_form').find('input[name=title]').val('');
        $('#mobile_colors_form').find('input[name=hexacode]').val('#bf5050');
        $('#mobile_colors_form').find('textarea[name=description]').val('');
        $('#mobile_colors_form').find('.minicolors-swatch-color').css('background-color', '#bf5050');

    });

    $('#apply_colors_filters').on('click', function (event) {
        event.preventDefault();
        filterColorsDatatable();
    });

    function filterColorsDatatable() {
        var formdata = $('#colors_filters').serializeArray();
        colorsDataTable.column(1).search(formdata[0].value).column(2).search(formdata[1].value).column(3).search(formdata[2].value).draw();
    }

    $(".resetColorsbutton").on('click', function () {
        $('#colors_filters')[0].reset();
        $('#colors_filters select[name=filter_status]').val('').change();
        colorsDataTable.columns().search('').draw();
    });

    $(document).on('click', '#add_colors_submit_btn', function (e) {

        e.preventDefault();

        $('.field-holder').find('input').css('border-color', '');
        $('#mobile_colors_form').find('input').css('border-color', '');
        CardLoaderInstance.show('.modal-content');
        var formData = new FormData($("#mobile_colors_form")[0]);
        formData.append('hidden_edit_id', $('#hidden_edit_id').val());
        axios.post("{{ route('managecolors.store')}}", formData)
            .then(function (response) {
                var tableRow = response.data.result;
                $("#mobile_colors_modal").modal('hide');
                if (response.data.status == true) {
                    toastr.success(response.data.message);
                    colorsArr = "";
                    $(".getcolors").trigger("click");

                    CardLoaderInstance.hide();
                    if (response.data.edit_id !== null && response.data.edit_id !== undefined) {
                        $("#hidden_edit_id").val(response.data.edit_id);
                    }

                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $('#mobile_colors_form').find("span.error").hide();

                    $.each(errors, function (i, obj) {
                        $('[name="' + i + '"]').closest('.form-check').find('span.error').empty().addClass('text-danger').text(obj).finish().fadeIn();
                        $('input[name=' + i + ']').css('border-color', 'red');
                    });
                    CardLoaderInstance.hide();
                }
            })
            .then(function () {
            });
    });

    function createcolorsTableRow(tableRow, count,actionPer) {

        var trRow = `<tr id="filtertr">
                <td><span>${count}</span></td>
                <td><span>${tableRow.title}</span></td>
                <td class="d-flex"><i class="fa fa-square fa-2x color${tableRow.id}"></i> &nbsp; <span class="align-self-center">${tableRow.hexacode}</span></td>
                <td><span class="d-none row_status">${tableRow.status == 1 ? 'status_enabled' : 'status_disabled'}</span>`;
        if (tableRow.status && tableRow.status == 1) {
            trRow += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status"><input id="aff_statusfeild" class ="form-check-input changecolorsStatus" data-check ="${tableRow.status}" data-id="${tableRow.id}" type = "checkbox" data-status="0" title="Disable"  value= "1" name="status" checked="${tableRow.status ? 'checked' : ''}" ></div>`;
        } else {
            trRow += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status" ><input  id="aff_statusfeild" class ="form-check-input changecolorsStatus" data-check="${tableRow.status}" data-id="${tableRow.id}" type ="checkbox" data-status="1" title="Enable"
                    value = "0" name="status" >
                </div>`;
        }
        if(actionPer){
            trRow += `</td>
                <td><a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                         <span class="svg-icon svg-icon-5 m-0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                             </svg>
                         </span>
                     </a>
                     <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                         <div class="menu-item test">
                             <a class="menu-link colors_popup" data-id="${tableRow.id}" data-title ="${tableRow.title}" data-hexacode="${tableRow.hexacode}" data-status="${tableRow.status}" data-description="${tableRow.description}" data-color_unique_id="${tableRow.color_unique_id}">Edit</a>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link deleteColor" data-id="${tableRow.id}">Delete</span>
                         </div>
                     </div>
                 </td></tr>`;
        } else{
            trRow += `</td>
                <td>-</td></tr>`;
        }
       
        return trRow;
    }

    $(document).on('click', '.changecolorsStatus', function (e) {
        var isChecked = $(this).is(':checked');
        Swal.fire({
            title: "{{trans('mobile_settings.warning_msg_title')}}",
            text: "{{trans('mobile_settings.warning_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('mobile_settings.yes_text')}}",
        }).then((result) => {
            if (result.isConfirmed) {
                var status = $(this).data("status");
                axios.post("{{ route('colors.changestatus')}}", {
                    'status': status,
                    'id': $(this).data("id")
                })
                    .then((response) => {
                        $("#mobile_colors_modal").modal('hide');
                        if (response.data.status == true) {
                            $(this).attr('title', isChecked ? 'Disable' : 'Enable');
                            $(this).closest('td').find('.row_status').text(isChecked ? 'status_enabled' : 'status_disabled');
                            toastr.success(response.data.message);

                            colorsDataTable.destroy();
                            colorsDataTable = $("#colors_table")
                                .on('draw.dt', function () {
                                    KTMenu.createInstances();
                                    setColor();
                                })
                                .DataTable({
                                    searching: true,
                                    ordering: true,
                                    "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                                });
                            filterColorsDatatable()
                        } else {
                            $(this).prop('checked', !isChecked);
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        $(this).prop('checked', !isChecked);
                    })
                    .then(function () {

                    });
            } else {
                $(this).prop('checked', !isChecked);
            }
        });
    });

    $(document).on('click', '.deleteColor', function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        Swal.fire({
            title: "{{trans('mobile_settings.warning_msg_title')}}",
            text: "{{trans('mobile_settings.delete_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('mobile_settings.yes_text')}}",
        }).then(function (result) {
            if (result.isConfirmed) {

                axios.delete("/mobile/managecolors/" + id)
                    .then(function (response) {
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                            colorsArr = "";
                            $(".getcolors").trigger("click");
                        } else {
                            toastr.error(response.data.message);
                        }

                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {

                    });
            }
        });

    });


    $('.minicolors').minicolors({
        animationSpeed: 50,
        animationEasing: 'swing',
        change: null,
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        format: 'hex',
        hide: null,
        hideSpeed: 100,
        inline: false,
        keywords: '',
        letterCase: 'lowercase',
        opacity: false,
        position: 'bottom left',
        show: null,
        showSpeed: 100,
        theme: 'bootstrap',
        swatches: []
    });
</script>
