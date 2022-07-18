<link href="/custom/css/loader.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ URL::asset('custom/css/bootstrap-datepicker.min.css') }}">
<script src="/custom/js/loader.js"></script>

<script>
    var newCount = 0;
    var brandArr = "";
    var brandActionPer = false;
    var brandActive=0;
    var pageNumber = 2;
    let brandDataTable;
    var showDatatable = false;
    $(document).ready(function () {
        $(document).on('click', '.getBrands', function (e) {
            CardLoaderInstance.show('.tab-content');
            brandActive = 1;
            filterBrand(e, null, 1);
        });
    });

    //api call on scroll
    $(window).scroll(function (e) {
        if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
            if (brandActive == 1 && ($('#brands_table tr').length) - 1 > 20) {
                brandArr = "";
                filterBrand(e, 'scroll');
            }
        }
    });

    //edit brand popup
    $(document).on('click', '.brand_popup', function (e) {
        $('.brand_heading').html('Edit Handset Brand');
        var myModal = new bootstrap.Modal(document.getElementById("mobile_brands_modal"), {});
        myModal.show();
        $('span.error').hide(); //hide error
        $('.field-holder').find('input').css('border-color', '');
        $('.field-holder').find('select').css('border-color', '');
        $("#hidden_edit_id").val($(this).attr('data-id'));
        $('#mobile_brands_form').find('input[name=title]').val($(this).data('title'));
        $('#mobile_brands_form').find('select[name=os_name]').val($(this).data('os_name'));
    });

    $('#mobile_brands_modal').on('hide.bs.modal', () => {
        CardLoaderInstance.hide();
    });

    //filter apply
    function filterBrand(parm = null, type = null, page = null, link = null) {

        if (page) {
            pageNumber = page;
        }
        if (parm != null) {
            parm.preventDefault();
        }
        pageNumber = pageNumber;

        var url = "/mobile/filterbrand";

        if (brandArr.length === 0 || brandArr === "" && type != "scroll" && link != "") {
            axios.post(url + '?page=' + pageNumber)
                .then(function (response) {
                    var html = '';
                    brandArr = response.data.brandRecords.data;
                    if(!response.data.add_brand){
                        $("#add_brand").remove();
                    }
                    brandActionPer = response.data.brand_action;
                    CardLoaderInstance.hide();
                    html += createBrandTable(brandArr,response.data.brand_action);

                    if (type == 'scroll') {
                        createPagination(html, 'append');
                        pageNumber += 1;
                        return;
                    }
                    pageNumber = 2;
                    createPagination(html, 'html');
                    var rowCount = ($('#brands_table tr').length) - 1;
                    if (rowCount == 0) {
                        $(".brand_table_data_body").empty().html('<tr class="no_record"><td colspan="7" align="center">No data available in table</td></tr>');

                    }

                })
                .catch(function (error) {
                    console.log(error);
                }).then(function () {
            });
        } else {
            CardLoaderInstance.hide();
            html = createBrandTable(brandArr,brandActionPer);
            pageNumber = 2;
            createPagination(html, 'html');
            var rowCount = ($('#brands_table tr').length) - 1;
            if (rowCount == 0) {
                $(".brand_table_data_body").empty().html('<tr><td colspan="7" align="center">No data available in table</td></tr>');
            }
        }
    }

    function createPagination(html, type) {
        if (showDatatable != false) {
            brandDataTable.destroy();

        }
        if (type == 'append') {
            $('.brand_table_data_body').append(html);
        } else {
            $('.brand_table_data_body').html(html);
        }
        showDatatable = true;
        brandDataTable = $("#brands_table")
            .on('draw.dt', function () {
                KTMenu.createInstances();
            })
            .DataTable({
                searching: true,
                ordering: true,
                "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            });
    }

    function createBrandTable(brandArr,brandActionPer) {
        var html = "";
        var count = 1;
        $.each(brandArr, function (key, val) {
            html += createTableRow(val, count,brandActionPer);
            count++;
        });
        return html;
    }

    $(document).on('click', '#add_brands_submit_btn', function (e) {
        e.preventDefault();

        $('.field-holder').find('input').css('border-color', '');
        $('.field-holder').find('select').css('border-color', '');
        $('#mobile_brands_form').find('input').css('border-color', '');
        CardLoaderInstance.show('#mobile_brands_modal .modal-content');
        var formData = new FormData($("#mobile_brands_form")[0]);
        formData.append('hidden_edit_id', $('#hidden_edit_id').val());
        axios.post("{{ route('managebrand.store')}}", formData)
            .then(function (response) {
                var tableRow = response.data.result;
                $("#mobile_brands_modal").modal('hide');
                if (response.data.status == true) {
                    toastr.success(response.data.message);
                    brandArr = "";
                    $(".getBrands").trigger("click");

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
                    $('#mobile_brands_form').find("span.error").hide();

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

    $(document).on('click', '#add_brand', function (e) {
        $("#hidden_edit_id").val("");
        $('span.error').text("").hide();
        $('input').css('border-color', '');
        $('select').css('border-color', '');
        $('#mobile_brands_form').find('input[name=title]').val('');
        $('#mobile_brands_form').find('select[name=os_name]').val('');
    });

    $('#apply_brand_filters').on('click', function (event) {
        event.preventDefault();
        filterDatatable()
    });

    function filterDatatable(){
        var formdata = $('#brand_filters').serializeArray();
        brandDataTable.column(1).search(formdata[0].value).column(2).search(formdata[1].value).column(3).search(formdata[2].value).draw();
    }

    $(".resetBrandbutton").on('click', function () {
        $('#brand_filters')[0].reset();
        $('#brand_filters select[name=filter_status]').val('').change();
        $('#brand_filters select[name=filter_os]').val('').change();
        brandDataTable.columns().search('').draw();
    });

    function createTableRow(tableRow, count,brandActionPer) {

        var trRow = `<tr id="filtertr">
                <td><span>${count}</span></td> 
                <td><span>${tableRow.title}</td>
                <td><span>${tableRow.os_name}</td>
                <td><span class="d-none row_status">${tableRow.status == 1 ? 'status_enabled' : 'status_disabled'}</span>`;
        if (tableRow.status && tableRow.status == 1) {
            trRow += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status"><input id="aff_statusfeild" class ="form-check-input changeBrandStatus" data-check ="${tableRow.status}" data-id="${tableRow.id}" type = "checkbox" data-status="0" title="Disable"  value= "1" name="status" checked="${tableRow.status ? 'checked' : ''}" ></div>`;
        } else {
            trRow += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status" ><input  id="aff_statusfeild" class ="form-check-input changeBrandStatus" data-check="${tableRow.status}" data-id="${tableRow.id}" type ="checkbox" data-status="1" title="Enable"
                            value = "0" name="status" >
                        </div>`;
        }
        if(brandActionPer){
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
                             <a class="menu-link brand_popup" data-id="${tableRow.id}" data-title ="${tableRow.title}" data-os_name="${tableRow.os_name}">Edit</a>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link deleteBrand" data-id="${tableRow.id}">Delete</span>
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

    $(document).on('click', '.changeBrandStatus', function (e) {
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
                axios.post("{{ route('brand.changestatus')}}", {
                    'status': status,
                    'id': $(this).data("id")
                })
                    .then((response) => {
                        $("#mobile_brands_modal").modal('hide');
                        if (response.data.status == true) {
                            $(this).attr('title', isChecked ? 'Disable' : 'Enable');
                            $(this).closest('td').find('.row_status').text(isChecked ? 'status_enabled' : 'status_disabled');
                            toastr.success(response.data.message);

                            brandDataTable.destroy();
                            brandDataTable = $("#brands_table")
                                .on('draw.dt', function () {
                                    KTMenu.createInstances();
                                })
                                .DataTable({
                                    searching: true,
                                    ordering: true,
                                    "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                                });
                            filterDatatable()
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

    $(document).on('click', '.deleteBrand', function (e) {
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
                axios.delete("/mobile/managebrand/" + id)
                    .then(function (response) {
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                            brandArr = "";
                            $(".getBrands").trigger("click");
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
