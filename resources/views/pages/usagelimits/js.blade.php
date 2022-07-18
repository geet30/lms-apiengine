<script src="/custom/js/loader.js"></script>
<script src="/custom/js/tagify.min.js"></script>
<script>

    const breadArray = [{
        title: 'Dashboard',
        link: '/',
        active: false
        },
        {
        title: 'Usage Limits',
        link: '#',
        active: false
    }];

    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();



    /*
     * Common function for add and update usage
    */
    $(document).on('submit', '.addusageform', function (event) {
        event.preventDefault();

        if ($('.usageid').val().length === 0) {
            var url = '/usage/create';
        } else {
            var url = '/usage/update';
        }

        CardLoaderInstance.show('.modal-content');
        var formData = new FormData($(this)[0]);
        axios.post(url, formData)
        .then(function (response) {
            if (response.data.status == 200) {
                $('.addusageform')[0].reset();
                $('#usagepopup').modal('hide');
                toastr.success(response.data.message);
                location.reload();
                // setTimeout(function() {
                //     location.reload();
                // }, 500); 
            }else{
                toastr.error(response.data.message);
            } 
            CardLoaderInstance.hide();
        })
        .catch(function (error) {
            CardLoaderInstance.hide();
            $(".error").html("");
            if (error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function (key, value) {
                    $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
                toastr.error("{{trans('usagelimits.error')}}",);
            }else if(error.response.status == 400) {
                CardLoaderInstance.hide();
                toastr.error(error.response.message);
            }
        })
        .then(function () {
            CardLoaderInstance.hide();
        });
    });
    
    var input1 = document.querySelector("#kt_tagify_1");
    new Tagify(input1);


    $(document).on('click', '.editpopup', function(e) {
        $(".error").html("");
        var myModal = new bootstrap.Modal(document.getElementById("usagepopup"), {});
        myModal.show();
        $("#usage_type").select2().val($(this).data('usagetype')).trigger('change.select2');
        $("#state").select2().val($(this).data('state')).trigger('change.select2');
        $("#usage_type").prop('disabled', true);
        $("#state").prop('disabled', true);
        $('input[name=elec_low_range]').val($(this).data('elow'));
        $('input[name=elec_medium_range]').val($(this).data('emedium'));
        $('input[name=elec_high_range]').val($(this).data('ehigh'));
        $('input[name=gas_low_range]').val($(this).data('glow'));
        $('input[name=gas_medium_range]').val($(this).data('gmedium'));
        $('input[name=gas_high_range]').val($(this).data('ghigh'));
        $("textarea#kt_tagify_1").val($(this).data('postcodes'));
        $('.usageid').val($(this).data('id'));
        $('.usageset').val($(this).data('usagetype'));
    });

    $(document).on('click', '.usagepopup', function(e) {
        $("#usage_type").prop('disabled', false);
        $("#state").prop('disabled', false);
        $('.form-control').val('');
        $("#state").select2().val('').trigger('change.select2');
        $("#usage_type").select2().val('').trigger('change.select2');
        $('.usageid').val('');
    });
    
    const dataTable = $("#usage_table").DataTable({
        searching: false,
        "sDom": "tipr",
    });

    $(document).on('click', '.applyusagefilter', function(e) {
        e.preventDefault();
        CardLoaderInstance.show('.table-responsive');
        url = '/usage/getdatausagetype';
        usage = $('#usagefilter').val();
        var formData = new FormData();
        formData.append('usagetype', usage);
        axios.post(url, formData)
        .then(function (response) {
            // console.log(response.data);
            if (response.data.length > 0) {
                var html = ``;
                $.each(response.data, function (key, value) {
                    html+= `<tr>
                        <td>${value.state}</td>`;
                    var myVariable = [];
                    $.each(value.postcodes, function (key1, value1) {
                        myVariable.push(value1.post_code);
                        html+= `
                            ${value1.post_code}
                        `;
                    });
                    html+= `
                        <td>
                            ${myVariable.join(',')}
                        </td>
                        <td>
                            Low: ${value.elec_low_range} ,
                            Medium: ${value.elec_medium_range} ,
                            High: ${value.elec_high_range} 
                        </td>
                        <td>
                            Low: ${value.gas_low_range} ,
                            Medium: ${value.gas_medium_range} ,
                            High: ${value.gas_high_range} 
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                                <div class="menu-item">
                                    <a  class="menu-link editpopup" data-state="${value.state}" data-usagetype="${usage}" data-id="${value.id}" data-elow="${value.elec_low_range}"   data-emedium="${value.elec_medium_range}" data-ehigh="${value.elec_high_range}" data-glow="${value.gas_low_range}" data-gmedium="${value.gas_medium_range}" data-ghigh="${value.gas_high_range}" data-postcodes="${myVariable}">
                                    {{trans('usagelimits.edit')}}
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a href="" class="menu-link ">{{trans('usagelimits.delete')}}</a>
                                </div>
                            </div>
                        </td>
                    `;
                    html +=`
                        </tr>
                    `;
                    $('#usagebody').empty();
                    $('#usagebody').append(html);
                     $('#usage_table_info').show();
                     $('#usage_table_paginate').show();
                     KTMenu.createInstances();
                });
               
            }else{
                $('#usagebody').empty();
                $('#usage_table_info').hide();
                $('#usage_table_paginate').hide();
                $('#usagebody').append("<td colspan='5' align='center'>{{trans('usagelimits.nodata')}}</td>");
                
            }


            CardLoaderInstance.hide();
        })
        .catch(function (error) {
            CardLoaderInstance.hide();
        })
        .then(function () {
            CardLoaderInstance.hide();
        });  
    });
</script>
