$(document).on('submit','#add_user_form',function(e)
{   
    e.preventDefault();
    $("#add_user_form .errors").html("");
	let formData = new FormData(this);
	formData.append('update', 'update');
    var url = '/manage-user/add';
	if(formData.get('action') == 'edit')
	{
		url = '/manage-user/update/'+formData.get('id');
	}
	loaderInstance.show();
	axios.post(url,formData)
		.then(function (response) {  
			loaderInstance.hide();
            $('#add_user_form_modal').modal('hide'); 
            dataTable.destroy();
            showUsersData(response.data.all_users,response); 
            dataTable = $("#lead_data_table").DataTable({
                responsive: false,
                searching: true,
                "sDom": "tipr",
            }); 
            if(formData.get('action') == 'edit')
            {
                toastr.success('User updated successfully.');
                return;
            }
            toastr.success('User added successfully.');
            return true;
		})
		.catch(function (error) {
			loaderInstance.hide();
			$(".error").html("");
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('[name="'+key+'"]').parent().find('span.errors').empty().addClass('text-danger').text(value).finish().fadeIn();
                    $('.'+key+'_errors').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
            else if(error.response.status == 400) {
                toastr.error('Something went wrong.');
            }
		});
});


/**
*   it sets the value in form of particular selected content checkbox with action => edit.
*/ 
$(document).on('click','.edit_user',function(e)
{   
    $("#add_user_form .errors").html("");
	$('#add_user_form_modal').modal('show');
	var id = $(this).data('id');
	var first_name = $(this).data('first_name');
	var last_name = $(this).data('last_name');
	var email = $(this).data('email'); 
	var phone = $(this).data('phone'); 
	var role = $(this).data('role');  
	var services = $(this).data('service').toString();  
	$("#serviceField option:selected").prop("selected", false);
	$.each(services.split(","), function(i,e){  
		$("#serviceField option[value='" + e + "']").prop("selected", true);
	});
	$("#serviceField").select2();
	$('#roleField').val(role).select2();
	$('#add_user_form input[name=action]').val('edit');
	$('#add_user_form input[name=first_name]').val(first_name); 
    $('#add_user_form input[name=last_name]').val(last_name);
    $('#add_user_form input[name=email]').val(email);
	$('#add_user_form input[name=phone]').val(phone); 
	$('#add_user_form input[name=id]').val(id); 
    $('.add_edit_user_title').html('Edit User');
});

/**
*   it sets the null values in form of particular selected content checkbox with action => add.
*/ 
$('.add-user').on('click',function(e){ 
    $("#add_user_form .errors").html("");
    $("#serviceField option").each(function(){
        this.selected=false;
    });
    $("#serviceField").select2(); 
	$("#roleField").val('').select2(); 
	$('#add_user_form input[name=action]').val('add'); 
	$('#add_user_form input[name=first_name]').val(''); 
    $('#add_user_form input[name=last_name]').val(''); 
    $('#add_user_form input[name=email]').val(''); 
	$('#add_user_form input[name=phone]').val('');  
    $('.add_edit_user_title').html('Add User');
});


/*
* Change Status 
*/
$(document).on('click','.change-status', function(e){ 
    var check = $(this);
    var id = check.attr("data-id");
    var url = '/provider/plans/broadband/status';
    var isChecked = check.is(':checked');
    var status = 0;
    var title = 'Are you sure?';
    var text = 'You want to change status!';
    if(isChecked)
    {
        var status = 1;  
    }
    var formdata = new FormData();
	url = '/manage-user/update/'+id;
    formdata.append("id", id); 
    formdata.append("status", status);
	formdata.append("update", 'status'); 
    Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function(result) {
        if (result.isConfirmed) {
            loaderInstance.show();
            axios.post(url,formdata )
            .then(function (response) {
                loaderInstance.hide();
                if(response.data.status == 400){
                    toastr.error(response.data.message);
                }else{
                    toastr.success('Status changed successfully.');
                }
            })
            .catch(function (error) {
                loaderInstance.hide();
                console.log(error);
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

$("#master_affiliates").on('change',function(){ 
    var valueSelected = $('#master_affiliates').val();
    if(valueSelected!='' && valueSelected !=null){
        fetchSubAffiliates(valueSelected);
    }else{
        $('.sub_affiliates_select').html('');
        $('.sub_affiliates_select').select2();
    }
});

let  fetchSubAffiliates= function(selected_value){
    var url = '/manage-user/get-sub-affiliate';
    axios.post(url,{
        'master_affiliate':selected_value,
        'user_id':$('[name=user_id]').val() 
    })
    .then(function (response) {  
        loaderInstance.hide();
        console.log(response.data);
        if(response.data.data.length>0)
            {
                var assigned_users= response.data.assigned_users;
                var html='';
                var subAffiliatesDisable = [];
                html+="<option ></option>";
                $.each(response.data.data, function(i,v){
                    var styleCss ='';
                    if(v.status==0)
                    {
                        subAffiliatesDisable.push(v.get_parent_affiliate.company_name+" : "+v.company_name);  
                        var styleCss= 'class="alert-danger"';
                    }
                    if(assigned_users.length>0 && Object.keys(assigned_users).map((k) => assigned_users[k]).indexOf(v.user_id) >-1){
                        html+="<option value="+v.user_id+" selected "+styleCss+">"+v.get_parent_affiliate.company_name+" : "+v.company_name+"</option>";
                    }else{
                        html+="<option value="+v.user_id+" "+styleCss+">"+v.get_parent_affiliate.company_name+" : "+v.company_name+"</option>";
                    }
                });
                $('.sub_affiliates_select').html(html); 
                 
            }else{ 
                $('.sub_affiliates_select').html('');
                 
            }
            $('.sub_affiliates_select').select2();
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
}

$(document).on('submit','#link_user_form',function(e)
{  
    e.preventDefault();
    $("#add_user_form .error").html("");
	let formData = new FormData(this);
	formData.append('update', 'update');
    var url = '/manage-user/assign-affiliate/'+$('[name=user_id]').val();
	loaderInstance.show();
	axios.post(url,formData)
    .then(function (response) {  
        loaderInstance.hide();
        toastr.success(response.data.message);
        window.location.href = "/manage-user/list";
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

$(document).on('submit','#filter_users',function(e)
{    
    e.preventDefault();
	let formData = new FormData(this); 
    var url = ''; 
	loaderInstance.show();
	axios.post(url,formData)
		.then(function (response) {  
			loaderInstance.hide();
            dataTable.destroy();
            showUsersData(response.data.all_users,response);
             console.log(response.data.all_users);
            dataTable = $("#lead_data_table").DataTable({
                responsive: false,
                searching: true,
                "sDom": "tipr",
            });
            return true;
		})
		.catch(function (error) {
			loaderInstance.hide();
 
		});
});
function showUsersData(users,response)
{
    var appPermissions = response.data.appPermissions;
    var userPermissions = response.data.userPermissions;
    $('#users_table_body_data').html('');
    var html = ''; 
    var i = 1;
    if (Object.keys(users).length > 0) 
    {
        $.each(users, function (key, user) 
        {
            html += `
            <tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
                <td>${i++}</td>
                <td> ${user.first_name} ${user.last_name}</td>
                <td>${user.email} </td>
                <td>${user.role_name} </td>
                <td>
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input sweetalert_demo change-status" type="checkbox" value="" name="notifications" ${ user.status == 1?'checked':'' } data-id="${user.id}">
                    </div>	
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon--></a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                         `;
                    if(checkPermission('users_action',appPermissions,userPermissions))
                    {   
                        if(checkPermission('edit_user',appPermissions,userPermissions))
                        {
                            html += `
                            <div class="menu-item px-3">
                                <a class="menu-link px-3 edit_user" data-id="${user.id}" data-first_name="${user.first_name}" data-last_name="${user.last_name}" data-phone="${user.phone}" data-email="${user.email}" data-role="${user.role}" data-service="${user.assigned_service}">Edit</a>
                            </div>`;
                        }
                        
                        if(checkPermission('assign_affliate',appPermissions,userPermissions))
                        {
                            html += `
                                <div class="menu-item px-3">
                                    <a href="/manage-user/assign-affiliate/${user.id}" class="menu-link px-3" >Assign Affiliate</a>
                                </div>`;
                        }

                        if(checkPermission('assign_permissions',appPermissions,userPermissions))
                        {
                            html += `
                                <div class="menu-item px-3">
                                    <a href="/manage-user/assign-permissions/${user.id}" class="menu-link px-3" > Permissions</a>
                                </div> `;
                        }

                        if(checkPermission('delete_user',appPermissions,userPermissions))
                        {
                            html += `
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" >Delete</a>
                                    </div>  `;
                        }

                        if(checkPermission('manage_user_2fa',appPermissions,userPermissions))
                        {
                            html += `
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" >Manage 2FA</a>
                                    </div> `;
                        }
                    }

                    html += `
                    </div>

            
                    <!--end::Menu-->
                </td>
            </tr>`; 
            });
        } 
    $('#users_table_body_data').html(html);
    KTMenu.createInstances();
}
