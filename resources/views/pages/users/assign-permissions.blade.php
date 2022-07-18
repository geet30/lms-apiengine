<x-base-layout>
    <!--begin::Basic info-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        <form name="permission_form">
        @include('pages/users/permissions/toolbar')
        <input type='hidden' name='user_id' value="{{$user->id}}"> 
        <div class="d-flex menu-md-row flex-row-fluid">
            <!--begin:::Tabs-->
            <div class="tab-content col-2 px-0 pt-5" style="border-right:1px solid #eff2f5;" >
                <div class="hide_section d-none">
                @include('pages/users/permissions/tab_heading')
                </div>
            </div>
            <!--end:::Tabs-->
            <!--begin::Tab content-->
            <div class="tab-content col-10 hide_section d-none">  
                    @include('pages/users/permissions/permissionsCheckbox') 
            </div>
            <!--end::Tab content-->
        </div> 
        <div class="card-footer d-flex justify-content-end py-6 px-9 hide_section">
                <a class="btn btn-light btn-active-light-primary me-2" href="/manage-user/list">{{__('plans/broadband.discard_button')}}</a>
                <button type="button" id="assign_permissions_btn" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
            </div>
    </div>
    
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/custom/js/users.js"></script>
    <script>
        var type = 'Manage User'; 

        const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                }, 
                {
                    title: type,
                    link: '/manage-user/list',
                    active: true
                },
                {
                    title: 'Assign Permission',
                    link: '#',
                    active: true
                },
            ];
        const breadInstance = new BreadCrumbs(breadArray,'Assign Permission');
        breadInstance.init(); 

        $('#assign_permissions_btn').click(function(e){
            $('span.form_error').hide();
            e.preventDefault();   
            var formData = $("form[name='permission_form']").serialize(); 
            var url = '/manage-user/assign-permissions/'+$('[name=user_id]').val();
            loaderInstance.show();
            axios.post(url,formData)
            .then(function (response) {  
                loaderInstance.hide();
                toastr.success(response.data.message);
                return true;
            })
            .catch(function (error) {
                loaderInstance.hide();
                $(".error").html("");
                if(error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        $('[name="'+key+'"]').parent().find('span.errors').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                }
                else if(error.response.status == 400) {
                    toastr.error('Something went wrong.');
                }
            }); 
        });

        var service = null; 
        $(".broadband_permission").hide();
        $(".mobile_permission").hide(); 
         
        setServiceTabs();
        function setServiceTabs()
        {
            $(".energy_tab,.mobile_tab,.broadband_tab,.mobile_broadband_tab").hide();   
            $(".mobile_service,.broadband_service,.energy_service,.mobile_broadband_service").parent().parent().hide(); 
            $(".mobile_service_sub_heading,.broadband_service_sub_heading,.energy_service_sub_heading,.mobile_broadband_service_sub_heading").hide();  
            if ($(".role_type").val() != '' && ($(".service_type").val() != null && $(".service_type").val() != '')) { 
                $(".hide_section").removeClass('d-none');
            } else {
                $(".hide_section").addClass('d-none');
            } 

            var service = $(".service_type").val();    
            if ($(".service_type").val() != null && $(".service_type").val() != '') {
                if (service.includes('1')) {
                    $(".energy_tab").show();
                    $(".energy_service").parent().parent().show(); 
                    $(".energy_service_sub_heading").show();  
                }
                else
                {    
                    $(".tab_energy_content,.energy_tab").removeClass('active'); 
                }
                if (service.includes('2')) {   
                    $(".mobile_broadband_tab,.mobile_tab").show(); 
                    $(".mobile_broadband_service,.mobile_service").parent().parent().show(); 
                    $(".mobile_broadband_service_sub_heading,.mobile_service_sub_heading").show();  
                }
                else
                { 
                    $(".tab_mobile_content,.mobile_tab").removeClass('active'); 
                }
                if (service.includes('3')) { 
                    $(".mobile_broadband_tab,.broadband_tab").show(); 
                    $(".mobile_broadband_service,.broadband_service").parent().parent().show(); 
                    $(".mobile_broadband_service_sub_heading,.broadband_service_sub_heading").show();   
                }
                else
                { 
                    $(".tab_broadband_content,.broadband_tab").removeClass('active'); 
                }
            } else {
                $(".hide_section").addClass('d-none');
            }
        }

        $(".service_type").change(function() {
            setServiceTabs();
        });

        $("#select_template").change(function() {
           var template_id = $('#select_template').val();
           var url = '/manage-user/get-template-permission';
           $('input[name="template_permission[]"]').attr('checked', false);
           loaderInstance.show();
           axios.post(url,{'template_id':template_id})
            .then(function (response) {   
                loaderInstance.hide();
                $.each(response.data.permissions, function(index, value) {
                    $('#' + value).prop('checked', true);
                    $('#' + value).attr('selected', true);
                });
                return true;
            })
            .catch(function (error) {
                loaderInstance.hide();
                $(".error").html("");
                if(error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        $('[name="'+key+'"]').parent().find('span.errors').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                }
                else if(error.response.status == 400) {
                    toastr.error('Something went wrong.');
                }
            }); 
        });

        $(".reset_all").click(function() {
            $('input[name="template_permission[]"]').prop('checked', false); 
            $('.users_select option').each(function() {  
                $(this).prop("selected", false);
            });
            $('#select_template').val('');
            $('.users_select,#select_template').select2();
        });
    </script> 
    @endsection
</x-base-layout>