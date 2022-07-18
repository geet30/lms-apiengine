<x-base-layout>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            @include('pages.plans.common.header')
        </div>
    </div>
    <!--begin::Row-->
    {{ theme()->getView('pages/plans/energy/components/upload-plan-modal',['energy'=>$energy ,'providerId' =>$providerId]) }}
    {{ theme()->getView('pages/providers/components/modal') }}
    <div class="row gy-12 gx-xl-12 card mt-3">
        {{ theme()->getView('pages/plans/energy/components/toolbar',array('allStatus'=>$allStatus,'activeStatus'=>$activeStatus,'energy'=>$energy, 'userPermissions' => $userPermissions,'appPermissions' =>$appPermissions)) }}
        {{ theme()->getView('pages/plans/energy/components/table', array('allPlans'=>$allPlans,'providerId'=>$providerId,'energy'=>$energy, 'userPermissions' => $userPermissions,'appPermissions' =>$appPermissions)) }}
    </div>
    <!--end::Row-->
    @section('scripts')
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
        var type = "{{ $energy }} Plans";
        var diff_aff = '/provider/list';
        var aff_head = 'Providers';
        let current_head = "{{ isset($selectedProvider) ? ucwords($selectedProvider->name) : '' }}";
        let current_head_url = "/provider/plans/energy/{{ $energy }}/list/{{ encryptGdprData($providerId) }}";

        KTMenu.createInstances();
        const dataTable = $("#plan_data_table").DataTable({
            responsive: true,
            searching: true,
            "sDom": "tipr"
        });

        function capitalizeFirstLetter(str) {
      
           return str[0].toUpperCase() + str.slice(1);
        }
        
        $('#search_plans').keyup(function() {
            dataTable.search($(this).val()).draw();
        })
        const breadArray = [{
                title: 'Dashboard',
                link: '/',
                active: false
            },
            {
                title: aff_head,
                link: diff_aff,
                active: false
            },
            {
                title: current_head,
                link: current_head_url,
                active: false
            },
            {
                title: capitalizeFirstLetter(type),
                 link: '#',
                 active: true
             },
        ];
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();

        $(".plan_status").click(function(e) {
            let check = $(this).data("status");
            let thisVal = $(this);
            Swal.fire({
                title: "{{trans('plans.warning_msg_title')}}",
                text: "{{trans('plans.warning_msg_text')}}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{trans('plans.yes_text')}}",
                cancelButtonClass: "cancel_aff",
            }).then((result) => {
                if (result.value) {
                    var status = $(this).data("status");
                    if(status == 0 || status == ''){
                        status =1;
                    }else{
                        status = 0;
                    }

                    axios.post("{{ route('plan.changestatus')}}", {
                            'status': status,
                            'plan_id': $(this).data("id")
                        })
                        .then(function(response) {
                            $("#apicreatemodal").modal('hide');
                            if (response.data.status == 200) {
                                toastr.success(response.data.message);
                            } else {
                                toastr.error(response.data.message);
                            }

                        })
                        .catch(function(error) {})
                        .then(function() {
                        });
                }
            });
            $(".cancel_aff").click(function() {
                $(thisVal).prop('checked', check);
            });
        });

        $(document).on('submit','#add_plan_form',function(e) {
            e.preventDefault();
            $('.error').text('').fadeIn();
            let formData = new FormData(this);
            axios.post("{{ route('energy.upload.plans')}}",formData)
                .then(function (response) {  
                    $('#upload_plan_modal').modal('hide'); 
                    $('[name=upload_plan]').val('');
                    toastr.success('Plan sheet uploaded successfully');
                    $('#error-plan-modal').modal('show'); 
                    var saved = `<label style="color:red">Out of <b>${response.data.total}</b> plans <b>${response.data.inserted}</b> uploaded successfully.</label>`;
					$('.record_info').html(saved); 
                    var row = '';
                    $.each(response.data.errors, function(i, obj){ 
                        $.each(obj, function(i, data){ 
                        row +=`<tr>
                                <td style="width:20%">Row ${data['key']} </td>
                                <td style="width:20%"> ${data['column']} </td>
                                <td style="width:60%"> ${data['error']} </td>
                            </tr>`;
                        });
                    }); 
                    $("#error_body").html(row);
                }) 
                .catch(function (error) {  
                    $('[name=upload_plan]').val('');  
                    if(error.response.status = 400 || error.response.status == 500)
                    {
                        toastr.error(error.response.data.message);
                    } 
                    $.each(error.response.data.errors, function (key, value) {
                        $('.' + key + '_error').text(value).fadeIn();
                    });
                });
        });

        $(document).on('hide.bs.modal','#upload_plan_modal',function(e){  
            $('.error').text('').fadeIn();
        });

        $(document).on('click','.download_sample',function(e){  
            axios.post("{{ route('energy.download.plans')}}",{'type':$(this).data('type')})
            .then(function (response) {   
                location.href=response.data.url;
            }) 
            .catch(function (error) { 
                 
            });
        });

        $(document).on('hide.bs.modal','#error-plan-modal',function(e){  
            location.reload();
        });

        $(".agentportal").click(function(e) {
            let check = $(this).data("status");
            let thisVal = $(this);
            var isChecked = thisVal.is(':checked');
            if (thisVal.is(':checked'))
                var status = 1;
            else
                var status = 0;
            Swal.fire({
                title: "{{trans('plans.warning_msg_title')}}",
                text: "{{trans('plans.warning_msg_text')}}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{trans('plans.yes_text')}}",
                cancelButtonClass: "cancel_aff",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post("{{ route('plan.updateagentstatus')}}", {
                        'status': status,
                        'plan_id': $(this).data("id")
                    })
                    .then(function(response) {
                        if (response.data.status == 200) {
                            toastr.success(response.data.message);
                        } else {
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(function(error) {})
                    .then(function() {
                    });
                }else{
                    if (isChecked) {
                        thisVal.prop('checked', false);
                    } else {
                        thisVal.prop('checked', true);
                    }
                }
            });
        });

        $(document).on('click', '#view-provider', function (event) {
            var url = $(this).data('url');
            $('#provider-detail .modal-body').attr('data-kt-indicator', 'on');
            axios.get(url)
                .then(function (response) {
                    setTimeout(function () {
                        $('#provider-detail .modal-body').attr('data-kt-indicator', 'off');
                        $('#provider-detail .modal-body').append(response.data)
                    }, 1000)
                })
                .catch(function (error) {
                    $('#provider-detail .modal-body').attr('data-kt-indicator', 'off');
                    console.log(error);
                })
                .then(function () {

                });
        });

        $('#provider-detail').on('hidden.bs.modal', function (e) {
            $('#provider-detail .modal-body').html('<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>');
        });
    </script>

@endsection
</x-base-layout>
