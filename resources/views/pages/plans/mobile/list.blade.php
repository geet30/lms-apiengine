<x-base-layout>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            @include('pages.plans.common.header',['selectedProvider' => $selectedProvider])
        </div>
    </div>
    <!--begin::Row-->
    {{ theme()->getView('pages/plans/mobile/components/upload-plan-modal',['providerId' =>$providerId]) }}
    <div class="row gy-12 gx-xl-12 card mt-3">
        {{ theme()->getView('pages/plans/mobile/components/toolbar', array('providerId' => $providerId,'connectionTypes' =>$connectionTypes,'planTypes'=>$planTypes,'filters'=>$filters, 'userPermissions' => $userPermissions,'appPermissions' =>$appPermissions)) }}
        {{ theme()->getView('pages/plans/mobile/components/table', array('providerId' => $providerId,'plans'=>$plans,'planTypes'=>$planTypes , 'userPermissions' => $userPermissions,'appPermissions' =>$appPermissions)) }}
    </div>
    <!--end::Row-->
    {{ theme()->getView('pages/providers/components/modal') }}
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script>
        var type = 'Mobile Plans';
        var diff_aff = '/provider/list';
        var aff_head = 'Providers';
        var current_head = "{{ isset($selectedProvider) ? ucwords(decryptGdprData($selectedProvider->name)) : '' }}";
        var current_head_url = "/provider/plans/mobile/{{ $providerId }}";
    
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
                title: type,
                link: '#',
                active: true
            },
        ];
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();

        KTMenu.createInstances();
        const dataTable = $("#mobile_plans_data_table").DataTable({
            responsive: true,
            searching: true,
            "sDom": "tipr"
        });

        $('#search_mobile_plans').keyup(function() {
            dataTable.search($(this).val()).draw();
        })

        // if ($('#no-data').length == 0) {
        //     const dataTable = $("#mobile_plans_data_table").DataTable({
        //         responsive: true,
        //         searching: true,
        //         "sDom": "tipr"
        //     });
        // }

        $(document).on('click', '#reset-filter', function() {
            $('[name="plan_type_filter"],[name="connection_type_filter"],[name="status_filter"]').val('').trigger('chosen:updated');
            $('[name="name_filter"]').val('');
            $('#filter_mobile_plans').submit();
        })

        $(document).on('click', '.delete-plan', function() {
            let planId = $(this).data('id');
            let url = window.location.href + "/" + planId;
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete plan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then(function(result) {
                if (result.isConfirmed) {
                    axios.delete(url)
                        .then(response => {
                            toastr.success('Delete successfully.')
                            location.href = location.href;
                        }).catch(err => {
                            if (err.response.status && err.response.data.message)
                                toastr.error(err.response.data.message);
                            else
                                toastr.error('Whoops! something went wrong.');
                        });
                }
            });
        })

        $(document).on('click', '.status', function() {
            let planId = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            let that = $(this);
            let url = window.location.href + "/change-status/" + planId;
            Swal.fire({
                title: "Are you sure?",
                text: "You want to change status!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then(function(result) {
                if (result.isConfirmed) {
                    axios.post(url, {
                            status
                        })
                        .then(response => {
                            toastr.success('Status changed successfully.')
                            location.href = location.href;
                        }).catch(err => {
                            if (err.response.status && err.response.data.message){
                                toastr.error(err.response.data.message);
                                that.prop('checked', !status);
                            }
                            else
                                toastr.error('Whoops! something went wrong.');
                        });
                } else {
                    that.prop('checked', !status);
                }
            });

        });
        $(document).on('hide.bs.modal','#error-plan-modal',function(e){  
            location.reload();
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
        $(document).on('click','.download_sample',function(e){  
           
            axios.post("{{ route('mobile.download.plans')}}",{'type':$(this).data('type')})
            .then(function (response) {   
                location.href=response.data.url;
            }) 
            .catch(function (error) { 
                 
            });
        });
        $('#provider-detail').on('hidden.bs.modal', function (e) {
            $('#provider-detail .modal-body').html('<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>');
        });
        $(document).on('submit','#add_mobile_plan_form',function(e) {
            e.preventDefault();
            $('.error').text('').fadeIn();
            let formData = new FormData(this);
            axios.post("{{ route('mobile.upload.plans')}}",formData)
                .then(function (response) {  
                    $('#upload_mobile_plan_modal').modal('hide'); 
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

        $(document).on('hide.bs.modal','#upload_mobile_plan_modal',function(e){  
            $('.error').text('').fadeIn();
        });
    </script>
    @endsection
</x-base-layout>