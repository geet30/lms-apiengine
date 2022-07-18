<x-base-layout>
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            {{ theme()->getView('pages/plans/common/header',['selectedProvider' => $selectedProvider]) }}
        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::Basic info-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/providers/phones/components/toolbar',['brands' => $brands,'filterVars' => $filterVars]) }}
        {{ theme()->getView('pages/providers/phones/components/table',['brands' => $brands,'assignHandset' => $assignHandset,'providerId' => $providerId]) }}
        {{ theme()->getView('pages/providers/phones/components/modals',['brands' => $brands,'assignHandset' => $assignHandset,'providerId' =>$providerId ]) }}
    </div>
    {{ theme()->getView('pages/providers/components/modal') }}
    @section('scripts')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script> 
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
        var type = 'Assigned Phone';
        var diff_aff = '/provider/list';
        var aff_head = 'Providers';
        var selectedProvider = "{{ isset($selectedProvider) ? ucwords(decryptGdprData($selectedProvider->name)) : '' }}";

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
                    title: selectedProvider,
                    link: '#',
                    active: false
                },
                {
                    title: type,
                    link: '#',
                    active: true
                },
            ];
        const breadInstance = new BreadCrumbs(breadArray,'Plans');
        breadInstance.init();

        $(document).on('click','.remove_handset',function(event)
        { 
            var check = $(this);
            var id = check.attr("data-id");
            var url = '/provider/assigned-handsets/{{encryptGdprData($providerId)}}/remove-handset/'+id; 
            var title = 'Are you sure?';
            var text = "You want to Delete Handset assigned and all it's variant"; 
            var formdata = new FormData();
            formdata.append("id", id); 
            Swal.fire({
                title: title,
                text: text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then(function(result) {
                if (result.isConfirmed) {
                    axios.post(url,formdata )
                    .then(function (response) {
                        if(response.data.status == 400){
                            toastr.error(response.data.message);
                            return;
                        } 
                        toastr.success(response.data.message);
                        var row = check.closest('tr') 
                        var siblings = row.siblings();
                        row.remove();
                        siblings.each(function(index) {
                            check.children('td').first().text(index + 1);
                        });
                    })
                    .catch(function (error) { 
                        toastr.error(error.response.data.message); 
                    });
                } 
            }) 
        });
        
        /*
        * Change Status 
        */
        $(document).on('click','.change-status', function(e){ 
            var check = $(this);
            var id = check.attr("data-id");
            var url = '/provider/assigned-handsets/{{encryptGdprData($providerId)}}/change-status/'+id;
            var isChecked = check.is(':checked');
            var status = 0;
            var title = 'Are you sure?';
            var text = 'You want to change status!';
            if(isChecked)
            {
                var status = 1; 
                title = 'Are you sure?';
                text = 'You want to change status!';
            }
            var formdata = new FormData();
            formdata.append("id", id);
            formdata.append("status", status);
            Swal.fire({
                title: title,
                text: text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then(function(result) {
                if (result.isConfirmed) {
                    axios.post(url,formdata )
                    .then(function (response) {
                        if(response.data.status == 400){
                            toastr.error(response.data.message);
                        }else{
                            toastr.success(response.data.message);
                        }
                    })
                    .catch(function (error) { 
                        toastr.error(error.response.data.message);
                        if (isChecked) {
                            check.prop('checked', false);
                        } else {
                            check.prop('checked', true);
                        }
                    });
                }else{
                    if (isChecked) {
                        check.prop('checked', false);
                    } else {
                        check.prop('checked', true);
                    }
                }
            }) 
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