jQuery(function () {
    localStorage.removeItem('brands');
    //Distributor click
    $(document).on('click', '.getBrands', function(e) {
        if(localStorage.getItem("brands")){
            
        }else{
            localStorage.setItem("brands", 1);
            // CardLoaderInstance.show('.tab-content');
           
            // let myForm = document.getElementById('distributorFilter');
            // let formData = new FormData(myForm);
            // formData.append('user',$('#checksegment').val());
            // formData.append('request_from',$('#distributorFilter').closest('form').attr('name'));
            var url = "get-mobile-brands";
            axios.get(url)
            .then(function (response) {
                console.log(response.data.brands);
               
                $('#brandsTabledata').empty();
                if(response.data.brands.length > 0){
                    var brands = ``;
                    $.each(response.data.brands, function (key, val) {
                        brands+= `
                        <tr>
                        <td>${key + 1}</td>
                        <td>${val.title}</td>
                        <td>${val.os_name}</td>
                        <td>`;
                        if (val.status && val.status == 1) {
                            brands += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status"><input id="aff_statusfeild" class ="form-check-input changeAffStatus" data-check ="${val.status}" data-id="${val.id}" type = "checkbox" data-status="0" title="Disable"  value= "1" name="status" checked="${val.status ? 'checked' : ''}" ></div>`;
                        } else {
                            brands += `<div class ="form-check form-switch form-switch-sm form-check-custom form-check-solid" title = "Change Status" ><input  id="aff_statusfeild" class ="form-check-input changeAffStatus" data-check="${val.status}" data-id="${val.id}" type ="checkbox" data-status="1" title="enable"
                            value = "0" name="status" >
                        </div>`;
                        }
                        brands += `</td>
                        <td>
                            <a href = "#" class = "btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement = "bottom-end">Actions<span class = "svg-icon svg-icon-5 m-0">
                            <svg xmlns = "http://www.w3.org/2000/svg" width = "24" height = "24" viewBox = "0 0 24 24" fill ="none">
                            <path d = "M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill = "black"/></svg> </span></a>
                            <div class = "menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu= "true" >
                            <div class = "menu-item" ><span class ="menu-link brand_edit_popup" data-id="${val.id}" data-title ="${val.title}" data-os_name="${val.os_name}">Edit</span></div>
                            <div class= "menu-item"><span class ="menu-link deleteBrand" data-id="${val.id}">Delete</span></div></div>
                        </td>
                        </tr>
                        `;
                    });
                
                }else{
                    
                    brands = `<tr class="no_record"><td colspan="4" align="center">{{trans('mobile_settings.brandPage.norecord')}}</td></tr>`;
                }
                $('#brandsTabledata').append(brands);
                KTMenu.createInstances();
            })
            .catch(function (error) {
                console.log(error);
                // CardLoaderInstance.hide();
            })
            .then(function () {
                console.log('tets');
                // CardLoaderInstance.hide();
            });



        } 
    });
    $(document).on('click', '.deleteBrand', function(e) {
        e.preventDefault();
        var check = $(this);
        var id = check.attr("data-id");
        var url = 'delete-mobile-brands';
        
        var formdata = new FormData();
        formdata.append("id", id);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.isConfirmed) {
                // CardLoaderInstance.show('.tab-content');
                axios.post(url,formdata )
                .then(function (response) {
                    console.log(response);
                    if(response.data.status == 400){
                        toastr.error(response.data.message);
                    }else{
                        toastr.success(response.data.message);
                        check.closest('tr').remove();
                    }
                    
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // CardLoaderInstance.hide();
                });
            }
        });

    });
    $(document).on('click', '.brand_edit_popup', function(e) {
       
        var myModal = new bootstrap.Modal(document.getElementById("mobile_brands_modal"), {});
        myModal.show();
        var id = $(this).data('id');
        $('.brand_heading').text('Edit Handset Brand');
        // $('#api_key_id').val(id);
        $('span.form_error').hide();
        $('.add_brands_submit_btn').text('Save');
        
        $('#mobile_brands_form').find('input').css('border-color', '');
        // $("#editApiKeyModel").modal('show');
        $('#mobile_brands_form').find('input[name=title]').val($(this).data('title'));
        
        $('#mobile_brands_form').find('select[name=os_name]').val($(this).data('os_name'));

    });
   

    $(document).on('click','.add_brands_submit_btn',function(){
       
        brands_ajax();
    });
    function brands_ajax(){   
        var formdata = $("#mobile_brands_form").serialize();    
        var url = "save-mobile-brands";
		
        axios.post(url, formdata).then((response) => {
            
            if (response.data.status == 200) {
                $('#mobile_brands_modal').modal('hide');
                toastr.success(response.data.message);
                // setTimeout(function(){ 
                //     window.location.reload(); 
                // }, 1000);
            } 
            else if(response.data.status == 422){
                toastr.error(response.data.message);
            }
           

        }).catch((error) => {
            console.log(error);
            if (error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('[name="' + key + '"]').parent().find('span.error').empty().addClass(
                        'text-danger').text(value).finish().fadeIn();
                });
            } 
            toastr.error('Please Check Errors');
            return false;
        })
       
	}


});
