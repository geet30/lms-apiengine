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

        {{ theme()->getView('pages/providers/phones/variants/components/modals',compact('providerId','handsetId','colors','variants','capacities','interStorages','handsetName')) }}

        {{ theme()->getView('pages/providers/phones/variants/components/toolbar',compact('providerId','handsetId','colors','variants','capacities','interStorages','handsetName','filterVars')) }}

        {{ theme()->getView('pages/providers/phones/variants/components/table',compact('providerId','handsetId','colors','variants','capacities','interStorages','handsetName')) }} 
    </div>
    {{ theme()->getView('pages/providers/components/modal') }}
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
        var type = 'Assigned Variants';
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
                    link: "{{ theme()->getPageUrl('provider/assigned-handsets/'.encryptGdprData($providerId)).'/list' }}",
                    active: false
                },
                {
                    title: 'Assigned Phone',
                    link: "{{ theme()->getPageUrl('provider/assigned-handsets/'.encryptGdprData($providerId)).'/list' }}",
                    active: false
                },
                {
                    title: "{{ $handsetName }}",
                    link: "{{ theme()->getPageUrl('provider/assigned-handsets/'.encryptGdprData($providerId).'/manage-phone-variant/'.encryptGdprData($handsetId).'/list') }}",
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
            var url = '/provider/assigned-handsets/{{$providerId}}/manage-phone-variant/{{$handsetId}}/change-status/'+id;
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
                        if(error.response.status == 402)
                        { 
                            $("#variantname").text(check.attr('data-variantname'));
                            $("#variantid").val(check.attr('data-variantid'));
                            $("#provider_variant_table_id").val(check.attr('data-providerVariantTableId'));
                            $('.submit-enable-vha-code').remove();
                            $('.VHA_code_warning').show();   
                            $("#vha_code").next('span').html("");
                            $('.vha_error').text('');
                            $('.submit-vha-code').before('<button type="submit" class="btn btn-success submit-enable-vha-code " style="margin-right:4px;">Submit & Enable</button>');
                            $("#vhaCodeModal").modal('toggle'); 
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

        /*
        * Change Status 
        */
        $(document).on('click','.delete_provider_variant', function(e){ 
            var check = $(this);
            var id = check.attr("data-id");
            
            var url = '/provider/assigned-handsets/{{$providerId}}/manage-phone-variant/{{$handsetId}}/remove-variant'; 
            var title = 'Are you sure?';
            var text = 'You want to delete this!'; 
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
            });
        });

        $(document).on('click','.add_vha_code', function(e){ 
            $('.VHA_code_warning').css("display", "none");
            $("#variantname").text($(this).attr('data-variantname'))
            $("#variantid").val($(this).attr('data-variantid'))
            $("#provider_variant_table_id").val($(this).attr('data-providerVariantTableId'))
            $("#vha_code").val('');  
            if($(this).data('vha') != ''){
                $("#vha_code").val($(this).data('vha'));
            }  
            $(".vha_error").html(""); 
            $("#vhaCodeModal").modal('show');
        });

        $(document).on('submit','#vha_code_form', function(e){ 
            e.preventDefault(); 
            submitVhaCode();
        });

        function submitVhaCode(action){ 
            $("#vha_code").next('span').html("");
            if($("#vha_code").val() == ""){
                $("#vha_code").next('span').html("SKU code is required.");
                return false;
            }
            let form = document.getElementById('vha_code_form');
            var formdata = new FormData(form); 
            var url = '/provider/assigned-handsets/{{$providerId}}/manage-phone-variant/{{$handsetId}}/store_vha_code'; 
            axios.post(url,formdata )
            .then(function (response) {
                if(response.data.status){
                    $('.vha_code_table_'+formdata.get('provider_variant_table_id')).html(formdata.get('vha_code'));
                    $('.add_vha_code_field_'+formdata.get('provider_variant_table_id')).data('vha',formdata.get('vha_code'));

                    if(action){
                        return true;
                    }
                    else{
                        toastr.success(response.data.message); 
                        $('#vhaCodeModal').modal('hide');
                    }
                }
                else{
                    $('.vha_error').text(result.data.message);
                } 
            })
            .catch(function (error) { 
                toastr.error(error.response.data.message); 
            });  
        }

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
                toastr.error(error.response.message); 
            }); 
        });

        $(document).on('click', '.img-pop', function(e) {
            e.preventDefault(); 
            var myModal = new bootstrap.Modal(document.getElementById("imagemodal"), {});
            myModal.show();
            $('.img_src').attr("src",$(this).attr('href'));        
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