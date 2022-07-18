 // datatablse
 let dataTable = $("#plan_fees_table").DataTable({
    searching: true,
    "sDom": "tipr",
    "pageLength": 20

});
$('#search_plan_fees_type').keyup(function() {
    dataTable.search($(this).val()).draw();
});

/**
*   it sets the value in form of particular selected content checkbox with action => edit.
*/ 
$(document).on('click','.edit_plan_fees_class',function(e){   
	var fees = $(this).data('fees');
	var fee_id = $(this).data('fee_id');
	var cost_id = $(this).data('cost_id'); 
    var additionInfo = $(this).data('additional_info');
	var id = $(this).data('id');  

    var feesTypeOptions = '<option value=""></option>'; 
    $.each( feeTypes, function( key, value ) {
        if(!selectedFeeTypes.includes(value.id) || fee_id == value.id)
        {
            feesTypeOptions += `<option value="${value.id}">${value.fee_name}</option>`;
        }     
    });
    $('.fee_id_select_class').html(feesTypeOptions);
    $('#add_fees_form [name=fee_id]').val(fee_id).select2();
    $('#add_fees_form [name=cost_type]').val(cost_id).select2(); 
	$('#add_fees_form input[name=amount]').val(fees);
    CKEDITOR.instances.additional_info.setData(additionInfo ? additionInfo : '');
    $('#add_fees_form input[name=id]').val(id); 
	$('#add_fees_form input[name=action]').val('edit'); 
    $('#add_fees_modal_heading').html(feesEditHead);
});

/**
*   it sets the null values in form of particular selected content checkbox with action => add.
*/ 
$('.add_plan_fees_class').on('click',function(e){  
    var feesTypeOptions = '<option value=""></option>'; 
    $.each( feeTypes, function( key, value ) {
        if(!selectedFeeTypes.includes(value.id))
        {
            feesTypeOptions += `<option value="${value.id}">${value.fee_name}</option>`;
        }    
    });
    $('.fee_id_select_class').html(feesTypeOptions);
    $('#add_fees_form [name=fee_id]').val(null).select2();
    $('#add_fees_form [name=cost_type]').val(null).select2(); 
	$('#add_fees_form input[name=amount]').val('');
    $('#add_fees_form input[name=id]').val(''); 
    CKEDITOR.instances.additional_info.setData('');
	$('#add_fees_form input[name=action]').val('add'); 
    $('#add_fees_modal_heading').html(feesAddHead);
});

/**
*   it sets the null values in form content checkbox.
*/
$(document).on('hide.bs.modal','#add_fees_modal',function(){  
    $('#add_fees_form [name=fee_id]').val(null).select2();
    $('#add_fees_form [name=cost_type]').val(null).select2(); 
    $('#add_fees_form input[name=amount]').val('');
    $('#add_fees_form input[name=id]').val(''); 
	$('#add_fees_form input[name=action]').val(''); 
    CKEDITOR.instances.additional_info.setData(''); 
    $("#add_fees_form .error").html("");
});

/**
*   send checkbox content id  to server to delete in database.
*/ 
$(document).on('click','.delete_plan_fees',function(e){
	e.preventDefault(); 
    var id = $(this).data('id');
    Swal.fire({
        title: deleteFeesTitle,
        text: deleteFeesText,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: 'RED',
        iconColor: 'RED',
    }).then(function(result) {
        if (result.isConfirmed) {
            var plan_id = $('#plan_id').val();
            let formData = new FormData();
            formData.append('plan_id',plan_id);
            formData.append('formTitle',$('.fees_submit_btn').data('title'));
            formData.append('id',id);
            formData.append('action','delete');
            formData.append('service_id',$('#plan_fees_service_id').val());
            serviceType = 'broadband';
            if($('#plan_fees_service_id').val() == 2)
            {
                serviceType = 'mobile';
            }
            savePlanFees('/provider/plans/'+serviceType+'/delete-plan-fees',formData);
        } 
    });
});


/**
*   send checkbox acknowledge form form to server to store/edit values in database.
*/ 
$(document).on('submit','#add_fees_form',function(e)
{ 
    e.preventDefault();
    $("#add_fees_form .error").html("");
	let formData = new FormData(this);
    var formId = $(this).attr('id');
    let formTitle = $('.fees_submit_btn').data('title');
    formData.append('formTitle', formTitle);
    serviceType = 'broadband';
    if($('#plan_fees_service_id').val() == 2)
    {
        serviceType = 'mobile';
    }
	savePlanFees('/provider/plans/'+serviceType+'/save-plan-fees',formData,formId); 
});

/**
*   it send to axios request to server and get reponse from server also show errors  
*/ 
function savePlanFees(url,formData,formId)
{
    loaderInstance.show();
    axios.post(url,formData)
		.then(function (response) { 
            loaderInstance.hide();  
            $(".error").html("");
            toastr.success(response.data.message); 
            $('#add_fees_modal').modal('hide');
            // $('#additional_info').val('');
            setPlanFeesContent(response);
		}) 
		.catch(function (error) {
            loaderInstance.hide();
			$(".error").html("");
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('[name="'+key+'"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
            else if(error.response.status == 400) { 
                toastr.error(error.response.data.message);
            }
		});
}

/**
*    get an array and make table.
*/ 
function setPlanFeesContent(response)
{ 
    $('#plan_fees_table').DataTable().destroy();
    data = response.data; 
    $('.plan_fees_table_body').html('');
    selectedFeeTypes = [];  
    if(data.planFeesList.length > 0)
    {
        var inc = 1; 
        $.each(data.planFeesList,function(i,val){ 
            selectedFeeTypes.push(val.fee_id);  
            $('.plan_fees_table_body').append(`
                <tr>    
                    <td>
                        ${inc}
                    </td>
                    <td>
                        ${val.fee_type.fee_name}
                    </td>
                    <td>
                        ${val.cost_type.cost_name}
                    </td>  
                    <td>
                        ${val.fees}
                    </td> 
                    <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                        </svg>
                                    </span>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                    <div class="menu-item">
                                        <a class="menu-link px-3 cursor-pointer edit_plan_fees_class" data-bs-toggle="modal"  data-bs-target="#add_fees_modal" data-id='${val.id}' data-fee_id='${val.fee_id}' data-cost_id='${val.cost_type_id}' data-fees='${val.fees}' data-additional_info='${val.additional_info}'>${checkboxEditPlace}</a>
                                    </div>
                                    <div class="menu-item">
                                    <a class="menu-link px-3 cursor-pointer delete_plan_fees" data-id='${val.id}'>${checkboxDeletePlace}</a>
                                    </div>
                                </div>
                    </td>
                </tr>
                `);
            inc++;
            KTMenu.createInstances(); 
        });  
    }
    datatable = $("#plan_fees_table").DataTable({
        searching: true,
        "sDom": "tipr",
        "pageLength": 20
    });  
}

let idValue='';
CKEDITOR.on('instanceReady', function(ev) {						
 
    $(document).on('click','.cke_button_off',function(){
        idValue= $(this).closest('.modal').attr('id');
         $('#'+idValue).css('display','none');
});
$(document).on('click', '.cke_dialog_ui_button_ok , .cke_dialog_ui_button_cancel, .cke_dialog_close_button', function () { 
    let focusId=$('.cke_focus').attr('id');
   let modifyId=focusId.replace('cke_','cke_editor_');
   let finalId =modifyId.concat('_dialog');
    if($('.'+finalId).css('display')=='none'){
        $('#'+idValue).css('display','block');
    }

});
});