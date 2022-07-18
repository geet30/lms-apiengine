<script src="/custom/js/loader.js"></script>
<script>
    var handestid = '{{$handsetId }}';
    var dynamictitle = '{{$title }}';
    var handsetName = "{{ isset($handsetDetails) ? $handsetDetails->name : '' }}";
    let variantId = "{{ isset($variant) ? $variant->id : '' }}";
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
                link: '/mobile/list-variant/'+handestid,
                active: false
            },
            {
                title: 'Manage Variants',
                link:  '/mobile/list-variant/'+handestid,
                active: false
            },
           
        ];

        let newArr = [];
        if(variantId){
        newArr = [
                {
                    title: "{{ isset($variant) ? ucwords($variant->variant_name) : '' }}",
                    link: '#',
                    active: false
                },
                {
                    title: variantId == '' ? 'Add' : 'Edit',
                    link: '#',
                    active: true
                },
            ];
            for(i=0; i < newArr.length ; i++){
                breadArray.push(newArr[i]);
            }
        }else{
            newArr = [
                {
                    title: variantId == '' ? 'Add' : 'Edit',
                    link: '#',
                    active: true
                },
            ];
            breadArray.push(newArr[0]);
        }

        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();




        //add more button
        var x = $('#add_more_images').children('div').length;
        // if(x == 5){ $('.add_button').hide(); }
        var y = x - 1;
        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper');

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                y++;
                $(wrapper).append('<div class="row mb-6"><div class="col s_no_'+y+'"><label class=" form-label mb-5 required">{{ __('variants.image_order') }}</label><input type="text" name="s_no[]" class="form-control form-control-lg form-control-solid" placeholder="" value="'+x+'"/> <input type="hidden" id="id_of_img" name="id_of_img[]" value="0"><span class="error text-danger"></span></div><div class="col img_type_'+y+'"><label class=" form-label mb-5 required">{{ __('variants.image_type') }}</label><select name="img_type[]" class="form-control form-control-solid form-select" data-control="select2"  data-placeholder="{{__('variants.storage')}}"><option value="">Select Image type</option>@foreach($img_type as $key => $value)<option value="{{ $key }}">{{ $value }}</option>@endforeach</select><span class="error text-danger"></span></div><div class="col sel_img_'+y+'"><label class="form-label mb-5 required">{{ __('variants.select_image') }}</label><input type="file" name="sel_img[]" class="form-control form-control-lg form-control-solid" /><span class="error text-danger"></span></div><a href="javascript:void(0);" class="remove_button"><i class="bi bi-trash fs-2 mx-1 text-primary"></i></a></div>'); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });



        $("form[name='add_handset_variant_form'],form[name='edit_handset_variant_form']").submit(function(e){
            e.preventDefault();
            url = '/mobile/store-variant';
            if($('#add_handset_variant_form').attr('name') == 'edit_handset_variant_form'){
                url = '/mobile/update-variant';
            } 

            var arr = [];
            $('input[name^="s_no"]').each(function () {
                arr.push($(this).val());
            });

            if (arr.length == $.unique(arr).length) {
               
            } else {    
                toastr.error("{{trans('variants.uniqueorder')}}");
                return false;
            }

            CardLoaderInstance.show('.card-body');
            var formData = new FormData($(this)[0]);
            axios.post(url, formData)
            .then(function (response) {
                if(response.data.status == 200){
                    $("#add_handset_variant_form")[0].reset();
                    $(".error").html("");
                    toastr.success(response.data.message);
                    setTimeout(function() { 
                        window.location = '/mobile/list-variant/'+handestid;
                    }, 1000);
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
                    $.each(errors, function(key, value) {
                        if(key.indexOf('.') != -1) {
                            let keys = key.split('.');
                            /*let keys_length = keys.length;*/
                            $('.'+keys[0]+'_'+keys[1]).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();

                        }
                        else {
                            $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        }
                    });
                }
            })
            .then(function () {
                CardLoaderInstance.hide();
            });
        });


        
        $(wrapper).on('click', '.delrow', function(e){
            e.preventDefault();
            var id = ($(this).data('id') - 1);
            var imgid = $(this).data('img-id');
            Swal.fire({
            title: "{{trans('variants.warning_msg_title')}}",
            text: "{{trans('variants.variant_warning')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{trans('variants.yes_text')}}",
            }).then(function(result) {
                if (result.isConfirmed) {
                    CardLoaderInstance.show('.card-body');
                    url = '/mobile/variant-images-delete/'+imgid;
                    axios.get(url)
                    .then(function (response) {
                        if(response.data.status == 200){
                            toastr.success(response.data.message);
                            // $('.mb-6_'+id).remove();
                            // x = $('#add_more_images').children('div').length;
                            // $('#add_more_images').val(x);
                            location.reload();
                        }else{
                            toastr.error(response.data.message);
                        }
                       
                       CardLoaderInstance.hide();
                        
                    })
                    .catch(function (error) {
                        CardLoaderInstance.hide();
                        console.log(error.response.data.errors);
                    })
                    .then(function () {
                        CardLoaderInstance.hide();
                    });
                } 
            });
        });

        $(document).on('click', '.img-pop', function(e) {
            e.preventDefault();
            var myModal = new bootstrap.Modal(document.getElementById("imagemodal"), {});
            myModal.show();
            $('.img_src').attr("src",$(this).attr('src'));
        });
        
    });


</script>