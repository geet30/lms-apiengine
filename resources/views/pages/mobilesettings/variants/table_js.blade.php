<script src="/custom/js/loader.js"></script>
<script>
    var handestid = '{{$handsetId }}';
    var handsetName = "{{ isset($handsetDetails) ? $handsetDetails->name : '' }}";
    $(document).ready(function(){

        const breadArray = [
            {
                title: 'Dashboard',
                link: '/',
                active: false
            },
            {
                title: 'Handsets',
                link: '/mobile/handsets',
                active: false
            },
            {
                title: handsetName,
                link: '#',
                active: false
            },
            {
                title: 'Manage Variants',
                link:  '#',
                active: false
            }
        ];

        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();

    });

    $(document).on('click', '.img-pop', function(e) {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById("imagemodal"), {});
        myModal.show();
        $('.img_src').attr("src",$(this).attr('src'));
    });

    /*
     * Change Status 
     */
    $(document).on('click', '.variantstatus', function(e) {
        var check = $(this);
        var id = check.attr("data-id");
        var url = '/mobile/update-variant-status'
        var isChecked = check.is(':checked');
        if (check.is(':checked'))
            var status = 1;
        else
            var status = 0;

        var formdata = new FormData();
        formdata.append("id", id);
        formdata.append("status", status);
        Swal.fire({
            title: "{{trans('variants.warning_msg_title')}}",
            text: "{{trans('variants.warning_msg_text')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('variants.yes_text')}}",
        }).then(function(result) {
            if (result.isConfirmed) {
                axios.post(url, formdata)
                    .then(function(response) {
                        if (response.data.status == 400) {
                            if (isChecked) {
                                check.prop('checked', false);
                            } else {
                                check.prop('checked', true);
                            }
                            toastr.error(response.data.message);
                        } else {
                            toastr.success(response.data.message);
                        }

                    })
                    .catch(function(error) {
                        console.log(error);
                    })
                    .then(function() {

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


    $('#apply_variant_filters').click(function (e) {
        e.preventDefault();
        getFilterData();
    });


    function getFilterData() {
        CardLoaderInstance.show('#dynamicContent');
        let myForm = document.getElementById('variant_filters');
        let formData = new FormData(myForm);
        var url = '/mobile/list-variant';
        axios.post(url, formData)
        .then(function(response) {
            CardLoaderInstance.hide();
            if (response.data.variants.length > 0) {
                var html = '';
                $.each(response.data.variants, function (key, val) {
                    color = "style=color:"+val.color+"";
                    checked = '';
                    if (val.status == 1) { checked = 'checked' }
                    editurl = '/mobile/edit-variant/'+handestid+'/'+val.encrypt;

                    html +=`
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input check-all row-checkbox" type="checkbox" value="${val.id}" data-name="${val.variant_name}"  />
                                </div>
                            </td>
                            <td>${val.sno}</td>
                            <td>${val.variant_name}</td>
                            <td>
                                <span class="fa fa-square" ${color} ></span>
                                ${val.colortitle}
                            </td>
                            <td>${val.capacity}</td>
                            <td>${val.internal}</td>
                            <td>
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                                    <input class="form-check-input variantstatus change-status" type="checkbox" name="notifications" ${checked} data-id="${val.id}">
                                </div> 
                            </td>
                            <td>
                                <img src="${val.image}" width="32px" height="31px" class="img-pop">
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{__('variants.actions')}}
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                        </svg>
                                    </span>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">

                                    <div class="menu-item">
                                        <a href="${editurl}" class="menu-link "><i class="bi bi-pencil-square"></i>{{__('variants.edit')}}</a>
                                    </div>

                                    <div class="menu-item">
                                        <a href="" class="menu-link "><i class="bi bi-trash"></i>{{__('variants.delete')}}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                
            }else{
                html = `<tr>
                            <td colspan="10" align="center">{{ __('variants.norecord') }}</td>
                        </tr>`;
            }
            
            $('#dynamicContent').html(html);
            KTMenu.createInstances();
        })
        .catch(function(error) {
            console.log(error);
            CardLoaderInstance.hide();
        })
        .then(function() {
            CardLoaderInstance.hide();
        });
       
    }

    $(".resetbutton").on('click', function () {
        $('#variant_filters')[0].reset();
        $(".form-select").select2().val('').trigger('change.select2');
        $("#apply_variant_filters").trigger("click");
    });

    $('#assign_provider').click(function() {
        let html = '';
        $('#selected_phone_to_assign_section').html('').hide();
        if ($('.row-checkbox:checked').length) {
            $.each($('.row-checkbox:checked'),function(){
                html += `<div class="col-lg-3">
                                <input type="hidden" name="variants_ids[]" value="${$(this).val()}">
                                <input type="radio" class="btn-check" checked="checked">
                                <label class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-10" for="kt_create_account_form_account_type_personal">
                                    <span class="d-block fw-bold text-start">
                                        <span class="text-dark fw-bolder d-block fs-4 mb-2">${$(this).data('name')}</span>
                                    </span>
                                </label>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>`;
            })
            $('#selected_phone_section').html(html).show();
            $('#assign_variant_modal').modal('show');
        }else{
            toastr.error('Please select atleast one Variant.');
        }
    })

    $('#assign_provider_drop_down').change(function(){
            if($(this).val() == '')
                return false
            let data = new FormData();
            data.append('provider_id',$('#assign_provider_drop_down').val());
            $.each($('[name^=variants_ids]'), function(){
                data.append('variant_ids[]',$(this).val());
            })
            loaderInstance.show();
            $('#custom_loader').css('z-index',9999);
            axios.post('/mobile/variants/check-assign-provider', data)
                .then(response => {
                    setAssignHandseHtml(response.data.assigned_handsets,response.data.not_assigned_Handsets);
                    console.log(response);
                    loaderInstance.hide();
                }).catch(err => {
                    loaderInstance.hide();
                });
        })

        const setAssignHandseHtml = (assigned_handsets,not_assigned_Handsets) =>{
            let html  = '';
            assigned_handsets.forEach(element => {
                html += `<div class="col-lg-3">
                            <input type="radio" class="btn-check" checked="checked">
                            <label class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger p-7 d-flex align-items-center mb-10" for="kt_create_account_form_account_type_personal" style="border-color:'red'">
                                <span class="d-block fw-bold text-start">
                                <span class="text-dark fw-bolder d-block fs-4 mb-2">${element.variant_name}</span>
                                    <span class="text-dark fw-bolder d-block fs-7">Already Assigned</span>
                                </span>
                            </label>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>`;
            })

            not_assigned_Handsets.forEach(element => {
                html += `<div class="col-lg-3">
                                <input type="hidden" name="variant_ids[]" value="${element.id}">
                                <input type="hidden" id="handset_id" value="${element.handset_id}">
                                <input type="radio" class="btn-check" checked="checked">
                                <label class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-10" for="kt_create_account_form_account_type_personal">
                                    <span class="d-block fw-bold text-start">
                                        <span class="text-dark fw-bolder d-block fs-4 mb-2">${element.variant_name}</span>
                                    </span>
                                </label>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>`;
            })
            $('#selected_phone_section').hide();
            $('#selected_phone_to_assign_section').html(html).show();
        }

        $('#assigned_handset_provider_submit').click(function(){
            if($('#assign_provider_drop_down').val() == '')
                return false
            if(!$('[name^=variant_ids]').length){
                toastr.error('Selected variant(s) is/are already assigned.');
                return false;
            }
            let data = new FormData();
            data.append('provider_id',$('#assign_provider_drop_down').val());
            data.append('handset_id',$('#handset_id').val());
            $.each($('[name^=variant_ids]'), function(){
                data.append('variant_ids[]',$(this).val());
            })
            loaderInstance.show();
            $('#custom_loader').css('z-index',9999);
            axios.post('/mobile/variants/assign-provider', data)
                .then(response => {
                    $('#assign_variant_modal').modal('hide');
                    $('.master-checkbox,.row-checkbox').prop('checked',false);
                    toastr.success(response.data.message);
                    loaderInstance.hide();
                }).catch(err => {
                    loaderInstance.hide();
                });
        })
        
        $("#assign_variant_modal").on('hidden.bs.modal', function(){
            $('#assign_provider_drop_down').val('').change();
            $('#selected_phone_section').html('');
        });
        
</script>