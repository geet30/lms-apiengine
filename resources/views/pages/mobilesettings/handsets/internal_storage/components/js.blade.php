<script>

    var newCount = 0;
    var storageArr = "";
    var storageActive = 0;
    var pageNumber = 2;
    let storageDataTable;
    var showstorageDatatable = false;
    var storageUnit = @json($storageUnits);
    var actionPer=false;


    $(document).ready(function () {
        $(document).on('click', '.getstorage', function (e) {
            CardLoaderInstance.show('.tab-content');
            storageActive = 1;
            filterstorage(e, null, 1);
        });
    });

    //api call on scroll
    $(window).scroll(function (e) {
        if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
            if (storageActive == 1 && ($('#storage_table tr').length) - 1 > 20) {
                storageArr = "";
                filterstorage(e, 'scroll');
            }
        }
    });

    $(document).on('click', '.storage_popup', function (e) {
        $('.storage_heading').html('Edit Internal Storage');
        var myModal = new bootstrap.Modal(document.getElementById("mobile_storage_modal"), {});
        myModal.show();
        $('span.error').hide(); //hide error
        $('.field-holder').find('select').css('border-color', '');
        $('.field-holder').find('input').css('border-color', '');
        $("#hidden_edit_id").val($(this).attr('data-id'));
        $('#mobile_storage_form').find('input[name=value]').val($(this).data('value'));
        $('#mobile_storage_form').find('select[name=unit]').val($(this).data('unit'));
        $('#mobile_storage_form').find('#description').text($(this).data('description'));

    });

    $('#mobile_storage_modal').on('hide.bs.modal', () => {
        CardLoaderInstance.hide();
    });

    //filter apply
    function filterstorage(parm = null, type = null, page = null, link = null) {
        if (page) {
            pageNumber = page;
        }
        if (parm != null) {
            parm.preventDefault();
        }
        pageNumber = pageNumber;

        var url = "/mobile/filter-storage";

        if (storageArr.length === 0 || storageArr === "" && type != "scroll" && link != "") {
            axios.post(url + '?page=' + pageNumber)
                .then(function (response) {
                    var html = '';
                    storageArr = response.data.storageRecords.data;
                    CardLoaderInstance.hide();
                    if(!response.data.add_per){
                        $("#add_storage").remove();
                    }
                    actionPer = response.data.action_per;
                    html += createstorageTable(storageArr,actionPer);


                    if (type == 'scroll') {
                        createstoragePagination(html, 'append');
                        pageNumber += 1;
                        return;
                    }
                    pageNumber = 2;
                    createstoragePagination(html, 'html');
                    var rowCount = ($('#storage_table tr').length) - 1;
                    if (rowCount == 0) {
                        $(".storage_table_data_body").empty().html('<tr class="no_record"><td colspan="7" align="center">No data available in table</td></tr>');

                    }

                })
                .catch(function (error) {
                    console.log(error);
                }).then(function () {
            });
        } else {
            CardLoaderInstance.hide();
            html = createstorageTable(storageArr,actionPer);
            pageNumber = 2;
            createstoragePagination(html, 'html');
            var rowCount = ($('#storage_table tr').length) - 1;
            if (rowCount == 0) {
                $(".storage_table_data_body").empty().html('<tr><td colspan="7" align="center">No data available in table</td></tr>');
            }
        }
    }

    function createstoragePagination(html, type) {
        if (showstorageDatatable != false) {
            storageDataTable.destroy();
        }
        if (type == 'append') {
            $('.storage_table_data_body').append(html);
        } else {
            $('.storage_table_data_body').html(html);
        }
        showstorageDatatable = true;
        storageDataTable = $("#storage_table")
            .on('draw.dt', function () {
                KTMenu.createInstances();
            })
            .DataTable({
                searching: true,
                ordering: true,
                "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            });
    }

    function createstorageTable(storageArr,actionPer) {
        var html = "";
        var count = 1;
        $.each(storageArr, function (key, val) {
            html += createstorageTableRow(val, count,actionPer);
            count++;
        });
        return html;
    }

    $('#apply_storage_filters').on('click', function (event) {
        event.preventDefault();
        filterStorageDatatable()
    });

    function filterStorageDatatable(){
        var formdata = $('#storage_filters').serializeArray();
        storageDataTable.column(1).search(formdata[0].value).column(2).search(formdata[1].value).column(3).search(formdata[2].value).draw();
    }

    $(".resetStoragetbutton").on('click', function () {
        $('#storage_filters')[0].reset();
        $('#storage_filters select[name=filter_unit]').val('').change();
        $('#storage_filters select[name=filter_status]').val('').change();
        storageDataTable.columns().search('').draw();
    });

    $(document).on('click', '#add_storage_submit_btn', function (e) {

        e.preventDefault();

        $('.field-holder').find('input').css('border-color', '');
        $('.field-holder').find('select').css('border-color', '');
        $('#mobile_storage_form').find('input').css('border-color', '');
        CardLoaderInstance.show('.modal-content');
        var formData = new FormData($("#mobile_storage_form")[0]);
        formData.append('hidden_edit_id', $('#hidden_edit_id').val());
        axios.post("{{ route('managestorage.store')}}", formData)
            .then(function (response) {
                var tableRow = response.data.result;
                $("#mobile_storage_modal").modal('hide');
                if (response.data.status == true) {
                    toastr.success(response.data.message);
                    storageArr = "";
                    $(".getstorage").trigger("click");

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
                    $('#mobile_storage_form').find("span.error").hide();

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

    $(document).on('click', '#add_storage', function (e) {
        $("#hidden_edit_id").val("");
        $('span.error').text("").hide();
        $('input').css('border-color', '');
        $('select').css('border-color', '');
        $('#mobile_storage_form').find('input[name=value]').val('');
        $('#mobile_storage_form').find('select[name=unit]').val('');
        $('#mobile_storage_form').find('textarea[name=description]').val('');
    });

    function createstorageTableRow(tableRow, count,actionPer) {
        var trRow = `<tr id="filtertr">
                <td><span>${count}</span></td>
                <td><span>${getUnit(tableRow.unit)}</td>
                <td><span>${tableRow.value}</td>
                <td><span class="d-none row_status">${tableRow.status == 1 ? 'status_enabled' : 'status_disabled'}</span>`;
        if (tableRow.status && tableRow.status == 1) {
            trRow += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status"><input id="aff_statusfeild" class ="form-check-input changestorageStatus" data-check ="${tableRow.status}" data-id="${tableRow.id}" type = "checkbox" data-status="0" title="Disable"  value= "1" name="status" checked="${tableRow.status ? 'checked' : ''}" ></div>`;
        } else {
            trRow += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status" ><input  id="aff_statusfeild" class ="form-check-input changestorageStatus" data-check="${tableRow.status}" data-id="${tableRow.id}" type ="checkbox" data-status="1" title="Enable"
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
                             <a class="menu-link storage_popup" data-id="${tableRow.id}" data-value ="${tableRow.value}" data-unit="${tableRow.unit}" data-description="${tableRow.description}">Edit</a>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link deleteStorage" data-id="${tableRow.id}">Delete</span>
                         </div>
                     </div>
                 </td></tr>`;  
        }
        else{
            trRow += `</td>
                    <td>-</td>`; 
        }
        
        return trRow;
    }

    function getUnit(tableUnit) {
        var u = '';
        $.each(storageUnit, function (index, unit) {
            if (tableUnit === index) {
                u = unit;
            }
        });
        return u;
    }

    $(document).on('click', '.changestorageStatus', function (e) {
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
                axios.post("{{ route('storage.changestatus')}}", {
                    'status': status,
                    'id': $(this).data("id")
                })
                    .then((response) => {
                        $("#mobile_storage_modal").modal('hide');
                        if (response.data.status == true) {
                            $(this).attr('title', isChecked ? 'Disable' : 'Enable');
                            $(this).closest('td').find('.row_status').text(isChecked ? 'status_enabled' : 'status_disabled');
                            toastr.success(response.data.message);

                            storageDataTable.destroy();
                            storageDataTable = $("#storage_table")
                                .on('draw.dt', function () {
                                    KTMenu.createInstances();
                                })
                                .DataTable({
                                    searching: true,
                                    ordering: true,
                                    "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                                });
                            filterStorageDatatable()
                        } else {
                            toastr.error(response.data.message);
                            $(this).prop('checked', !isChecked);
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

    $(document).on('click', '.deleteStorage', function (e) {
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

                axios.delete("/mobile/managestorage/" + id)
                    .then(function (response) {
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                            storageArr = "";
                            $(".getstorage").trigger("click");
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
