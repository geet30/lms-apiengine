<link href="/custom/css/loader.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('custom/css/bootstrap-datepicker.min.css') }}">

<script src="/custom/js/loader.js"></script>
<script src="/custom/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script>
    var newCount = 0;
    var targetArr = "";
    var targetDates = "";
    var defaultYears = "";
    var targetActive = 0;
    var pageNumber = 2;
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];
    $(document).ready(function() {
        $(document).on('click', '.gettarget', function(e) {
            CardLoaderInstance.show('.tab-content');
            targetActive = 1;
            filterTaget(e, null, 1);
            dateSet();

        });
    });
    //api call on scroll 
    $(window).scroll(function(e) {
        if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
            if (targetActive == 1 && ($('#target_table tr').length) - 1 > 20) {
                targetArr = "";
                filterTaget(e, 'scroll');
            }
        }
    });
    //to hide all error on popup add click
    $(document).on('click', '#set_target_btn', function(e) {
        $("#hidden_edit_id").val("");
        $('span.form_error').text("").hide();
        $('input').css('border-color', '');
        $('.targetinput').val('');
        $("#date_picker").datepicker("setDate", "");

        dateSet();

    });
    //set targetactive to 0 on api key click
    $(document).on('click', '.apikey_link', function(e) {
        targetActive = 0;
    });
    //edit target popup
    $(document).on('click', '.target_popup', function(e) {
        $("#date_picker").datepicker("setDate", $(this).attr('data-date'));
        var myModal = new bootstrap.Modal(document.getElementById("settargetmodel"), {});
        myModal.show();
        $('span.form_error').hide(); //hide error
        $('.field-holder').find('input').css('border-color', '');
        $("#hidden_edit_id").val($(this).attr('data-id'));
        $("#target_value").val($(this).data('target')); //target value
        $("#comment").val($(this).attr('data-comment')); //comment
        $("#date_picker").val($(this).attr('data-date')); //target date

    });
    //filter apply
    function filterTaget(parm = null, type = null, page = null, link = null) {
        //$("#export_target").show();
        if (page) {
            pageNumber = page;
        }
        if (parm != null) {
            parm.preventDefault();
        }
        pageNumber = pageNumber;
        let myForm = document.getElementById('targetFilter');
        let formData = new FormData(myForm);
        var url = "/affiliates/filtertarget/" + $('#show_apikeypopup').data('user_id');
        console.log(targetArr, "staring");

        if (targetArr.length === 0 || targetArr === "" && type != "scroll" && link != "") {
            axios.post(url + '?page=' + pageNumber, formData)
                .then(function(response) {
                    var html = '';
                    targetArr = response.data.targetRecords.data;
                    console.log(targetArr, "success");
                    CardLoaderInstance.hide();
                    targetDates = response.data.targetDates;
                    defaultYears = response.data.defaultYears;
                    html += createTargetTable(targetArr);
                    if (type == 'scroll') {
                        $('.target_table_data_body').append(html);
                        pageNumber += 1;

                        return;
                    }
                    pageNumber = 2;
                    $('.target_table_data_body').html(html);
                    var rowCount = ($('#target_table tr').length) - 1;
                    if (rowCount == 0) {
                        $(".target_table_data_body").empty().html('<tr class="no_record"><td colspan="7" align="center">There is no record to show.</td></tr>');
                        $("#export_target").hide();
                    } else {
                        $("#export_target").show();
                        // dateSet();

                    }
                })
                .catch(function(error) {
                    console.log(error);
                }).
            then(function() {
                KTMenu.createInstances();

            });
        } else {
            CardLoaderInstance.hide();

            console.log(targetArr, "else");
            html = createTargetTable(targetArr);
            pageNumber = 2;
            $('.target_table_data_body').html(html);
            var rowCount = ($('#target_table tr').length) - 1;
            if (rowCount == 0) {
                $(".target_table_data_body").empty().html('<tr><td colspan="8" align="center">There is no record to show.</td></tr>');
                $("#export_target").css('display', 'none!important');
            }
            KTMenu.createInstances();

        }
    }

    function createTargetTable(targetArr) {
        var html = "";
        var count = 1;
        $.each(targetArr, function(key, val) {
            html += createTableRow(val, count);
            count++;
        });
        return html;
    }
    //filter target
    $(document).on('click', '.submitTarget', function(e) {
        targetArr = "";
        filterTaget(e, null, 1);
    });
    //create update target
    $(document).on('click', '#savetargetData', function(e) {
        e.preventDefault();
        $('#add_update_targetform').find('input').css('border-color', '');
        CardLoaderInstance.show('.modal-content');
        var formData = new FormData($("#add_update_targetform")[0]);
        formData.append('user_id', $('#show_apikeypopup').data('user_id'));
        formData.append('hidden_edit_id', $('#hidden_edit_id').val());
        axios.post("{{ route('managetarget.store')}}", formData)
            .then(function(response) {
                var tableRow = response.data.result;
                $("#settargetmodel").modal('hide');
                if (response.data.status == true) {
                    toastr.success(response.data.message);
                    targetArr = "";
                    $(".gettarget").trigger("click");

                    CardLoaderInstance.hide();
                    if (response.data.edit_id !== null && response.data.edit_id !== undefined) {
                        $("#hidden_edit_id").val(response.data.edit_id);
                    }

                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function(error) {
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $("span.form_error").hide();
                    $('#add_update_apikeyform').find('input').css('border-color', '');
                    $('.field-holder').find('input').css('border-color', '');
                
                    $.each(errors, function(i, obj) {
                      
                        $('input[name=' + i + ']').parent('.field-holder').find('span.form_error').slideDown(400).html(obj);
                        $('input[name=' + i + ']').css('border-color', 'red');
                    });
                    CardLoaderInstance.hide();
                }
            })
            .then(function() {
                KTMenu.createInstances();
            });
    });
    $(document).on('click', '.flatpickr-next-month', function() {
        alert("Ddfdfd");
    });

    //datepicker date set
    function dateSet() {
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth();
        $('#date_picker').datepicker({
            format: "mm-yyyy", //date format
            viewMode: "months",
            minViewMode: "months",
            autoclose: true,
            startDate: new Date(year, '0', '01'),
            endDate: new Date(year + 1, month, '31'),
            toggleActive: true
        }).on("show", function(event) {
            var year = $("th.datepicker-switch").eq(1).text();
            $(".month").each(function(index, element) {
                var el = $(element);
                /*  $.each(targetDates, function(key, val) {
                     if (val == year && months[key - 1] == el.text()) {
                         el.addClass('disabled'); //disable particular month

                     }
                 }); */
                var hideMonth = $.grep(targetDates, function(n, i) {
                    // console.log(n, "elemnet", i, "inex")
                    return n.substr(0, 4) == year && months[parseInt(n.substr(5, 2)) - 1] == el.text();
                });
                if (hideMonth.length)
                    el.addClass('disabled');
            });
        });

    }

    $(document).on("click", ".resetTarget", function(e) {
        $('#targetFilter').trigger("reset");
        $('.resetvalues').change();
        targetArr = "";
        $(".gettarget").trigger("click");
    });
    //export functionality
    $(document).on("click", "#export_target", function(e) {
        e.preventDefault();
        var url = "{{ route('affiliate.targetexport')}}";
        window.location.href = url + '?' + 'sort_month=' + $('#sort_month').val() + '&sort_year=' + $('#sort_year').val() + '&status_sort_type=' + $('#status_sort_type').val() + '&unique_aff_id=' + $('#show_apikeypopup').data('user_id');
    });

    function createTableRow(tableRow, count) {
        var status = 'Not Achieved';
        var month = tableRow.target_month;
        if (tableRow.status == 0) {
            status = 'Not Achieved';
        } else if (tableRow.status == 1) {
            status = 'Achieved';
        }
        var comment = "";
        if (tableRow.comment != null) {
            comment = tableRow.comment;
        }
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var monthArray = {
            'January': '01',
            'February': '02',
            'March': '03',
            'April': '04',
            'May': '05',
            'June': '06',
            'July': '07',
            'August': '08',
            'September': '09',
            'October': '10',
            'November': '11',
            'December': '12'
        };

        var month = months[month - 1];
        var numMonth = monthArray[month];

        var trRow = `<tr id="filtertr">
                <td><span>${count}</span></td>
                <td><span>${tableRow.target_value}</td>
                <td><span>${month}</span></td>
                <td><span>${tableRow.target_year}</span></td>
                <td><span >${status}</span></td>
                <td><span >${tableRow.sales}</span></td>
                <td><a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                         <span class="svg-icon svg-icon-5 m-0">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                             </svg>
                         </span>
                     </a>
                     <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                         <div class="menu-item test">
                             <a class="menu-link  target_popup" data-id="${tableRow.id}" data-month="${tableRow.target_month}" data-year="${tableRow.target_year}" data-date="${numMonth}-${tableRow.target_year}" data-modified="${month},${tableRow.target_year}" data-comment="${comment}" data-status="${status}" data-sales="${tableRow.sales}" data-target="${tableRow.target_value}">Edit</a>
                         </div>
                         <div class="menu-item ">
                             <span class="menu-link deletetarget"  data-id="${tableRow.id}">Delete</span>
                         </div>
                     </div>
                 </td></tr>`;
        return trRow;
    }
    //delete target
    $(document).on('click', '.deletetarget', function(e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var url = '/affiliates/deletetarget';
        Swal.fire({
            title: "{{trans('affiliates.warning_msg_title')}}",
            text: "{{trans('affiliates.delete_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('affiliates.yes_text')}}",
        }).then(function(result) {
            if (result.isConfirmed) {

                axios.delete("/affiliates/managetarget/" + id)
                    .then(function(response) {
                        if (response.data.status == true) {
                            toastr.success(response.data.message);
                            targetArr = "";
                            $(".gettarget").trigger("click");
                            console.log(targetArr, "delte");
                        } else {
                            toastr.error(response.data.message);
                        }

                    })
                    .catch(function(error) {
                        console.log(error);
                    })
                    .then(function() {

                    });
            }
        });

    });
</script>