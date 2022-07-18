<script>

    var newCount = 0;
    var ramArr = "";
    var ramActive = 0;
    var pageNumber = 2;
    let ramDataTable;
    var showRamDatatable = false;
    var ramCapacity = @json($capacityArr);
    var actionPer=false;

    $(document).ready(function () {
        $(document).on('click', '.getram', function (e) {

            CardLoaderInstance.show('.tab-content');
            ramActive = 1;
            filterRam(e, null, 1);
        });
    });

    //api call on scroll
    $(window).scroll(function (e) {
        if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
            if (ramActive == 1 && ($('#ram_table tr').length) - 1 > 20) {
                ramArr = "";
                filterRam(e, 'scroll');
            }
        }
    });

    //edit brand popup
    $(document).on('click', '.ram_popup', function (e) {
        $('.ram_heading').html('Edit Capacity');
        var myModal = new bootstrap.Modal(document.getElementById("mobile_ram_modal"), {});
        myModal.show();
        $('span.error').hide(); //hide error
        $('.field-holder').find('select').css('border-color', '');
        $('.field-holder').find('input').css('border-color', '');
        $("#hidden_edit_id").val($(this).attr('data-id'));
        $('#mobile_ram_form').find('input[name=value]').val($(this).data('value'));
        $('#mobile_ram_form').find('select[name=unit]').val($(this).data('unit'));
        $('#mobile_ram_form').find('#description').text($(this).data('description'));

    });

    $('#mobile_ram_modal').on('hide.bs.modal', () => {
        CardLoaderInstance.hide();
    });

    //filter apply
    function filterRam(parm = null, type = null, page = null, link = null) {

        if (page) {
            pageNumber = page;
        }
        if (parm != null) {
            parm.preventDefault();
        }
        pageNumber = pageNumber;

        var url = "/mobile/filter-ram";

        if (ramArr.length === 0 || ramArr === "" && type != "scroll" && link != "") {
            axios.post(url + '?page=' + pageNumber)
                .then(function (response) {
                    var html = '';
                    ramArr = response.data.ramRecords.data;
                    CardLoaderInstance.hide();
                    if(!response.data.add_per){
                        $("#add_ram").remove();
                    }
                    actionPer = response.data.action_per;
                    html += createRamTable(ramArr,actionPer);


                    if (type == 'scroll') {
                        createRamPagination(html, 'append');
                        pageNumber += 1;
                        return;
                    }
                    pageNumber = 2;
                    createRamPagination(html, 'html');
                    var rowCount = ($('#ram_table tr').length) - 1;
                    if (rowCount == 0) {
                        $(".ram_table_data_body").empty().html('<tr class="no_record"><td colspan="7" align="center">No data available in table</td></tr>');

                    }

                })
                .catch(function (error) {
                    console.log(error);
                }).then(function () {
            });
        } else {
            CardLoaderInstance.hide();
            html = createRamTable(ramArr,actionPer);
            pageNumber = 2;
            createRamPagination(html, 'html');
            var rowCount = ($('#ram_table tr').length) - 1;
            if (rowCount == 0) {
                $(".ram_table_data_body").empty().html('<tr><td colspan="7" align="center">No data available in table</td></tr>');
            }
        }
    }

    function createRamPagination(html, type) {
        if (showRamDatatable != false) {
            ramDataTable.destroy();
        }
        if (type == 'append') {
            $('.ram_table_data_body').append(html);
        } else {
            $('.ram_table_data_body').html(html);
        }
        showRamDatatable = true;
        ramDataTable = $("#ram_table")
            .on('draw.dt', function () {
                KTMenu.createInstances();
            })
            .DataTable({
                searching: true,
                ordering: true,
                "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            });
    }

    function createRamTable(ramArr,actionPer) {
        var html = "";
        var count = 1;
        $.each(ramArr, function (key, val) {
            html += createRamTableRow(val, count,actionPer);
            count++;
        });
        return html;
    }

    $(document).on('click', '#add_ram_submit_btn', function (e) {
        e.preventDefault();
        $('.field-holder').find('input').css('border-color', '');
        $('.field-holder').find('select').css('border-color', '');
        $('#mobile_ram_form').find('input').css('border-color', '');
        CardLoaderInstance.show('.modal-content');
        var formData = new FormData($("#mobile_ram_form")[0]);
        formData.append('hidden_edit_id', $('#hidden_edit_id').val());
        axios.post("{{ route('manageram.store')}}", formData)
            .then(function (response) {
                var tableRow = response.data.result;
                $("#mobile_ram_modal").modal('hide');
                if (response.data.status == true) {
                    toastr.success(response.data.message);
                    ramArr = "";
                    $(".getram").trigger("click");

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
                    $('#mobile_ram_form').find("span.error").hide();
                    $.each(errors, function (i, obj) {
                        $('[name="' + i + '"]').parent().find('span.error').empty().addClass(
                            'text-danger').text(obj).finish().fadeIn();
                        $('input[name=' + i + ']').css('border-color', 'red');
                        $('select[name=' + i + ']').css('border-color', 'red');
                    });
                    CardLoaderInstance.hide();
                }
            })
            .then(function () {
            });
    });

    $(document).on('click', '#add_ram', function (e) {
        $("#hidden_edit_id").val("");
        $('span.error').text("").hide();
        $('input').css('border-color', '');
        $('select').css('border-color', '');
        $('#mobile_ram_form').find('input[name=value]').val('');
        $('#mobile_ram_form').find('select[name=unit]').val('');
        $('#mobile_ram_form').find('textarea[name=description]').val('');
    });

    $('#apply_ram_filters').on('click', function (event) {
        event.preventDefault();
        filterRamDatatable()
    });

    function filterRamDatatable() {
        var formdata = $('#ram_filters').serializeArray();
        ramDataTable.column(1).search(formdata[0].value).column(2).search(formdata[1].value).column(3).search(formdata[2].value).draw();
    }

    $(".resetRamtbutton").on('click', function () {
        $('#ram_filters')[0].reset();
        $('#ram_filters select[name=filter_unit]').val('').change();
        $('#ram_filters select[name=filter_status]').val('').change();
        ramDataTable.columns().search('').draw();
    });

    function createRamTableRow(tableRow, count,actionPer) {
        var trRow = `<tr id="filtertr">
                <td><span>${count}</span></td>
                <td><span>${getCapacity(tableRow.unit)}</span></td>
                <td><span>${tableRow.value}</td>
                <td><span class="d-none row_status">${tableRow.status == 1 ? 'status_enabled' : 'status_disabled'}</span>`;
        if (tableRow.status && tableRow.status == 1) {
            trRow += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status"><input id="aff_statusfeild" class ="form-check-input changeRamStatus" data-check ="${tableRow.status}" data-id="${tableRow.id}" type = "checkbox" data-status="0" title="Disable"  value= "1" name="status" checked="${tableRow.status ? 'checked' : ''}" ></div>`;
        } else {
            trRow += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status" ><input  id="aff_statusfeild" class ="form-check-input changeRamStatus" data-check="${tableRow.status}" data-id="${tableRow.id}" type ="checkbox" data-status="1" title="Enable"
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
                                 <a class="menu-link ram_popup" data-id="${tableRow.id}" data-value ="${tableRow.value}" data-unit="${tableRow.unit}" data-description="${tableRow.description}">Edit</a>
                             </div>
                             <div class="menu-item ">
                                 <span class="menu-link deleteRam" data-id="${tableRow.id}">Delete</span>
                             </div>
                         </div>
                     </td></tr>`;
        }
        else{
            trRow += `</td>
                    <td>-</td></tr>`;
        }
       
        return trRow;
    }

    function getCapacity(tableCapacity) {
        var c = '';
        $.each(ramCapacity, function (key, capacity) {
            if (tableCapacity === key) {
                c = capacity;
            }
        });
        return c;
    }

    $(document).on('click', '.changeRamStatus', function (e) {
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
                axios.post("{{ route('ram.changestatus')}}", {
                    'status': status,
                    'id': $(this).data("id")
                })
                    .then((response) => {
                        $("#mobile_ram_modal").modal('hide');
                        if (response.data.status == true) {
                            $(this).attr('title', isChecked ? 'Disable' : 'Enable');
                            $(this).closest('td').find('.row_status').text(isChecked ? 'status_enabled' : 'status_disabled');
                            toastr.success(response.data.message);

                            ramDataTable.destroy();
                            ramDataTable = $("#ram_table")
                                .on('draw.dt', function () {
                                    KTMenu.createInstances();
                                })
                                .DataTable({
                                    searching: true,
                                    ordering: true,
                                    "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                                });
                            filterRamDatatable()
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

    $(document).on('click', '.deleteRam', function (e) {
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
                axios.delete("/mobile/manageram/" + id)
                    .then(function (response) {
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                            ramArr = "";
                            $(".getram").trigger("click");
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
</script>
