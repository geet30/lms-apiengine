<x-base-layout>
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<style>
    .checker
    {
        width: 200px;
    }
</style>
@include('pages.affiliates.affsettings.components.permissions.components.affiliate_header') 
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" class="affiliate-permissions-form">
        @csrf
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Affiliate Permissions
                    </h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="col-lg-3 fv-row providerservice">

                    <input type="hidden" name="id" class="affiliate_user_id" value="{{$userId}}">
                    <input type="hidden" name="parent_id" value="">
                    <select id="permission_service_id" class="form-control form-control-solid form-select" data-placeholder="Select Verticals" data-control="select2" name="service_id">
                        @if(isset($verticals))
                            @foreach($verticals as $vertical)
                                <option value=""></option>
                                <option value="{{$vertical->service_id }}">{{$vertical->serviceName->service_title }}</option>
                            @endforeach
                        @endif
                    
                    
                    
                    <!-- @if(count($verticals)>0)
                            <option value=""></option>
                            @foreach($verticals as $vertical)
                            <option value="{{$vertical->id}}">
                                {{$vertical->service_title}}
                            </option>
                            @endforeach
                        @endif -->
                    </select>
                    <span class="service_id_permission_error text-danger"></span>
                </div>
                <div id="permission_checkboxes">
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ theme()->getPageUrl('affiliates/list') }}" class="btn btn-white btn-active-light-primary me-2">{!! __('buttons.cancel') !!}</a>
               
                <button type="submit" class="submit_button" class="btn btn-primary">
                    @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                </button>
            </div>
        </div>
    </form>

</div>
@section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script> 
    <script> 

        const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                }, 
                {
                    title: 'Affiliates',
                    link: '/affiliates/list',
                    active: false
                }, 
            ];
        if('{{$records["role"]}}' == '3'){
            breadArray.push(
                {
                    title: 'Sub-Affiliates',
                    link: '#',
                    active: false
                },
            );
            breadArray.push(
                {
                    title: 'Settings',
                    link: '#',
                    active: false
                },
            );
        }
        else
        {
            breadArray.push(
                {
                    title: 'Settings',
                    link: '/affiliates/affiliate-settings/{{$mainAffId}}',
                    active: false
                },
            );
        }
         
        breadArray.push(
            {
                title: 'Permissions',
                link: '/affiliates/list',
                active: true
            },
        );
        const breadInstance = new BreadCrumbs(breadArray,'Plans');
        breadInstance.init(); 
     
    $(document).on('change', '#permission_service_id', function(e) {
        let service_id = $(this).val();
        let user_id = $('.affiliate_user_id').val();
        var formdata = new FormData();
        formdata.append('service_id',service_id);
        formdata.append('user_id',user_id);
        loaderInstance.show();
        axios.post('/affiliates/get-service-permissions', formdata)
            .then(function (response) {
                setPermissionCheckbox(response);
                setServiceTabs(id);
                loaderInstance.hide();
            })
            .catch(function (error) {
                loaderInstance.hide();
            });
    });

    function setPermissionCheckbox(response)
    {
        var html = '';
        var assignedPermissions = response.data.assignPermissions;
        $.each(response.data.permissions, function (key, mainPermissions)
        {
            html +=
            `<div class="card-body row mb-5 mt-5 border pt-5 pb-5">
                <div>
                    <div>
                        <div class="permission_main_section">
                            <div class="row mb-2 pb-3">
                                <div class="col-lg-12">
                                    <label class="checkbox-inline">
                                        <div class="checker">
                                            <input class="permission_main_checkbox" type="checkbox" name="permissions[]" value="${mainPermissions[1]}" ${assignedPermissions.includes(mainPermissions[1])?'checked':''}>
                                            <b>Enable ${mainPermissions[0]} Section</b>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-10" style="margin-left: 15%;">`;

                                    $.each(mainPermissions[3], function (key, subPermission)
                                    {
                                        html +=
                                            `<div class="${subPermission[2]}_service_sub_heading main">
                                                <div class="heading pb-2">
                                                    <label class="checkbox-inline">
                                                        <div class="checker">
                                                            <input class="parent" type="checkbox" name="permissions[]" value="${subPermission[1]}" ${assignedPermissions.includes(subPermission[1])?'checked':''}>
                                                            <b>
                                                                ${subPermission[0]}
                                                            </b>
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="checkbox-list pb-5 px-5">`;

                                                $.each(subPermission[3], function (key, value)
                                                {
                                                    html +=
                                                        `<label class="checkbox-inline" style="vertical-align: top">
                                                            <div class="checker">
                                                                <input type="checkbox" class="children ${value[1]}_service" name="permissions[]" value="${value[1]}" ${assignedPermissions.includes(value[1])?'checked':''}>
                                                                ${value[0]}
                                                            </div>
                                                        </label>`;
                                                });
                                        html += `</div>
                                            </div>
                                            `;
                                    });
                                    html += `
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> `;
                });
            $('#permission_checkboxes').html(html);
    }

    $(document).on('change', '.permission_main_checkbox',function (){
        var isChecked = $(this).is(':checked');
        $(this).closest('.permission_main_section').find('.parent').prop('checked', isChecked);
        $(this).closest('.permission_main_section').find('.children').prop('checked', isChecked);
    });

    $(document).on('change', '.parent',function (){
        var isChecked = $(this).is(':checked');
        $(this).closest('.main').find('.children').prop('checked', isChecked);
    });

    function setServiceTabs(serviceId)
    {
        $(".mobile_service,.broadband_service,.energy_service,.mobile_broadband_service").parent().parent().hide();
        $(".mobile_service_sub_heading,.broadband_service_sub_heading,.energy_service_sub_heading,.mobile_broadband_service_sub_heading").hide();
        if (serviceId != null) {
            if (serviceId == 1) {
                $(".energy_service").parent().parent().show();
                $(".energy_service_sub_heading").show();
            }
            if (serviceId == 2) {
                $(".mobile_broadband_service,.mobile_service").parent().parent().show();
                $(".mobile_broadband_service_sub_heading,.mobile_service_sub_heading").show();
            }
            if (serviceId == 3) {
                $(".mobile_broadband_service,.broadband_service").parent().parent().show();
                $(".mobile_broadband_service_sub_heading,.broadband_service_sub_heading").show();
            }
        }
    }

    $(document).on('submit', '.affiliate-permissions-form', function(e) {
        e.preventDefault();
        $('.service_id_permission_error').html('');
        loaderInstance.show();
        var formdata = new FormData(this);
        axios.post('/affiliates/save-permissions', formdata)
        .then(function (response) {
            loaderInstance.hide();
            toastr.success('Permission saved successfully');
        })
        .catch(function (error) {
            loaderInstance.hide();
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {

                    $('.'+key+'_permission_error').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
        });
    });

    $(document).on('click', '.reset_password', function(e) {
        e.preventDefault();
        let submitButton = $(this);
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true)

        var id = $(this).attr('data-id');
        var url = '/affiliates/send-reset-password';
        var formdata = new FormData();
        formdata.append("id", id);
        axios.post(url, formdata)
            .then(function (response) {
                if (response.data.status == 400) {
                    toastr.error(response.data.message);
                } else {
                    toastr.success(response.data.message);
                }

            })
            .catch(function (error) {
                console.log(error);

            })
            .then(function () {
                // always executed
                submitButton.attr('data-kt-indicator', 'off');
                submitButton.prop('disabled', false);
            });

    });

    </script>
@endsection
</x-base-layout>
 