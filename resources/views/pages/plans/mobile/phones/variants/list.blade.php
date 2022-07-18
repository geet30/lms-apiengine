<x-base-layout>
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            {{ theme()->getView('pages/plans/common/header',['providerUser' => []]) }}
        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::Basic info-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
     {{ theme()->getView('pages/plans/mobile/phones/variants/components/modals',compact('providerId','planId','handsetId','colors','variants','capacities','interStorages','handsetName','providerName','planName','filterVars')) }}
        {{ theme()->getView('pages/plans/mobile/phones/variants/components/toolbar',compact('providerId','planId','handsetId','colors','variants','capacities','interStorages','handsetName','providerName','planName','filterVars')) }}
        {{ theme()->getView('pages/plans/mobile/phones/variants/components/table',compact('providerId','planId','handsetId','colors','variants','capacities','interStorages','handsetName','providerName','planName')) }} 
    </div>
    
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
        var type = 'Manage Variant';
        var diff_aff = '/provider/list';
        var aff_head = 'Providers';

        const breadArray = [
                {
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
                    title: 'Mobile Plans',
                    link: "{{ theme()->getPageUrl('provider/plans/mobile/'.encryptGdprData($providerId)) }}",
                    active: false
                },
                {
                    title: 'Manage Phone(s)',
                    link: "{{ theme()->getPageUrl('provider/plans/mobile/'.encryptGdprData($providerId).'/manage-phone/'.encryptGdprData($planId)) }}",
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
        
        /*
        * Change Status 
        */
        $(document).on('click','.change-status', function(e){ 
            var check = $(this);
            var id = check.attr("data-id");
            
            var url = '/provider/plans/mobile/{{$providerId}}/phones/variants/change-status/{id}';
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
            });
        });

        $(document).on('click','.view_handset_variant', function(e){   
            var url = '/provider/manage-phone/view-variant-images'; 
            var formdata = new FormData(); 
            formdata.append('variantId',$(this).data('variant'));
            axios.post(url,formdata )
            .then(function (response) { 
                $('.td_var_images').html(response.data.var_img); 
                $("#viewVariantImagesModel").modal('show');
            })
            .catch(function (error) {
                toastr.error(error.message); 
            }); 
        });

        $(document).on('click', '.img-pop', function(e) {
            e.preventDefault(); 
            var myModal = new bootstrap.Modal(document.getElementById("imagemodal"), {});
            myModal.show();
            $('.img_src').attr("src",$(this).attr('href'));        
        });
    </script> 
    @endsection
</x-base-layout>