var lastSel = $('.connection_type_event option:selected');

$(document).on('click','.connection_type_event', function(){
    lastSel = $('.connection_type_event option:selected'); 
});

/**
*   Show Technology Types according to selected connection type
*/
$(document).on('change','.connection_type_event', function(){
    var obj = this;
    if($('[name="action"]').val() == 'add')
    {
        getTechType(obj);
        return;
    }
    Swal.fire({
        title: connectionChangeTitle,
        text: connectionChangeText,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function(result) {
        if (result.isConfirmed) { 
            getTechType(obj);
            return;
        }  
        $('.connection_type_event').val(lastSel.val()).select2();
    }); 
});

var prev = $('.tech_type_event').val(); 
$(document).on('change','.tech_type_event', function(e){ 
    if($('[name="action"]').val() == 'add')
    {
        return;
    }
    var newArr = $(this).val();
    var elmts = prev.filter(
        function(i) {
            return this.indexOf(i) < 0;
        },
        newArr
    );  
    if(elmts.length>0)
    {
        Swal.fire({
            title: techTypeChangeTitle,
            text: techTypeChangeText,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function(result) {
            if (!result.isConfirmed) {  
                $(".tech_type_event").find("option[value="+elmts[0]+"]").prop("selected", "selected");
                $('.tech_type_event').select2();
            }  
            else
            {
                prev = newArr;
            }
        }); 
        return true;
    }  
    prev = newArr;
});

//getTechTypes
function getTechType(obj)
{
    var connectionId = $(obj).val();
    if(connectionId == 1)
    {
        loaderInstance.show();
        axios.get('/provider/plans/broadband/get-technology-type/'+connectionId)
        .then(function (response) { 
            loaderInstance.hide(); 
            var techTypeOptions = '<option value=""></option>';
            $.each( response.data.data, function( key, value ) {
                techTypeOptions += `<option value="${value.id}">${value.name}</option>`;    
            });
            $('.tech_type_event').html(techTypeOptions);
            $('.tech_type_event').select2();
        })
        .catch(function (error) {
            loaderInstance.hide();
        });
        return;
    }
    $('.tech_type_event').html('');
    return;
}
/**
*   send plan section form data to server to store in database
*/
$(document).on('submit','#basic_details_form,#plan_info_form,#plan_data_form,#critical_information_form,#remarketing_informatio_form,#special_offer_form',function(e)
{ 
    var formId = $(this).attr('id');
    e.preventDefault();
	let formData = new FormData(this); 
    if($(this).attr('id') == 'basic_details_form')
    {  
        if(formData.get('action') == 'add')
        {
            saveForm('store',formData,'add',formId);
            return;
        }
    }
	saveForm('/provider/plans/broadband/update',formData,'',formId);
});

/**
*   get term and condition content.
*/ 
$(document).on('click','.get_term_page', function(){ 
    let id=$(this).attr('data-id');
    let title=$(this).attr('data-title');
    let description=$(this).attr('data-description'); 
    $("#edit_terms_and_condition_form .error").html("");
    $("#edit_terms_and_condition_form")[0].reset();
    $('#term_id').val(id);
    $('#term_title').val(title); 
    editorsArr.term_title_content.setData(description);
});

/**
*   send term and condition form data to server 
*/ 
$(document).on('submit','#edit_terms_and_condition_form',function(e)
{
    e.preventDefault();
    $("#edit_terms_and_condition_form .error").html("");
    var formId = $(this).attr('id');
	let formData = new FormData(this);
	saveForm('/provider/plans/broadband/update-terms-condition',formData,'',formId);
});

/**
*   it send to axios request to server and get reponse from server also show errors  
*/ 
function saveForm(url,formData,action,formId)
{
    loaderInstance.show();
    axios.post(url,formData)
		.then(function (response) { 
            $(".error").html("");
            loaderInstance.hide();
            if(action == 'add')
            {
                location.href = '/provider/plans/broadband/'+$('#provider_id_field').val();
                return true;
            }
            if(formId == 'edit_terms_and_condition_form')
            { 
                $('#term_condition_id_'+formData.get('id')).attr('data-title',formData.get('title')); 
                $('#term_condition_id_'+formData.get('id')).attr('data-description',formData.get('term_title_content'))
                $('#term_condition_title_'+formData.get('id')).html(formData.get('title')); 
                $('#edit_terms_and_condition_modal').modal('hide'); 
                KTMenu.createInstances(); 
            }
            else if(formId == 'basic_details_form')
            {   
                if(response.data.addondata.connenction_change == 'yes')
                { 
                    selectedModemId =$('#included_modem_form [name=addon_id]').val(); 
                    setOtherAddonData(response.data.addondata.otherAddons); 
                    setIncludedAddonData(response.data.addondata.broadbandModem,'included_modem_id',selectedModemId);  
                    if(selectedModemId == $('#included_modem_id').val())
                    {
                        $("#included_modem_form input[name=status][value=1]").prop("checked",true);
                        $('.included_modems_fields').removeClass('d-none');
                    } 
                    else
                    {
                        $("#included_modem_form input[name=status][value=0]").prop("checked",true);
                        $('.included_modems_fields').addClass('d-none');
                    }
                }
                $('#basic_details_form [name=nbn_key_url]').val(response.data.plan_data.nbn_key_url);
                $('#basic_details_form [name=nbn_key_file]').val(null);
                $("#basic_details_form input[name=nbn_key][value=1]").prop("checked",true);
            }
            else if(formId == 'critical_information_form')
            {
                $('#critical_information_form [name=critical_info_url]').val(response.data.plan_data.critical_info_url);
                $('#critical_information_form [name=critical_info_file]').val(null);
                $("#critical_information_form input[name=critical_info_type][value=1]").prop("checked",true);
            }
            toastr.success(response.data.message);
            return true;
		})
		.catch(function (error) {
            loaderInstance.hide();
			$(".error").html("");
            var inc = 1;
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) { 
                    if(inc == 1)
                    {
                        $('[name="'+key+'"]').focus();
                        inc++;
                    }
                    $('[name="'+key+'"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    $('#'+formId+' .'+key+'-error').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
            else if(error.response.status == 400) { 
                toastr.error(error.response);
            }
            return false;
		});
}

function setIncludedAddonData(data,id,selectedModemId)
{  
    var html = '<option></option>';
    if(data.length >= 0)
    {  
        $.each(data,function(i,val){
            html += `<option value="${val.id}" ${selectedModemId==val.id?'selected':''}>${val.name}</option>`;    
        });
    }
    $('#'+id).html(html); 
}
/**
*   send acknowledgement form to server to store values in database.
*/ 
$(document).on('submit','#ack_info_form',function(e)
{ 
    var formId = $(this).attr('id');
    e.preventDefault();
    $("#kt_account_ack_info .error").html("");
	let formData = new FormData(this);
	var response = saveForm('/provider/plans/broadband/update-plan-eic-content',formData,'',formId); 
});

/**
*   it sets the value in form of particular selected content checkbox with action => edit.
*/ 
$(document).on('click','.edit_checkbox',function(e){  

	var required_option = $(this).data('required');
	var save_checkbox_status = $(this).data('status');
	var content_option = $(this).data('content'); 
	var id_option = $(this).data('id');
	var validation_message_option = $(this).data('validation-message');  

	$('#provider_ackn_checkbox_form input[name=required][value='+required_option+']').prop("checked", true);
	$('#provider_ackn_checkbox_form input[name=status][value='+save_checkbox_status+']').prop("checked", true);

    editorsArr.checkbox_content.setData(content_option);
    editorsArr.validation_message.setData(validation_message_option); 
    
	$('#provider_ackn_checkbox_form input[name=checkbox_id]').val(id_option);
	$('#provider_ackn_checkbox_form input[name=action]').val('edit'); 
});

/**
*   it sets the null values in form of particular selected content checkbox with action => add.
*/ 
$('.add-eic-content').on('click',function(e){
	e.preventDefault();
	$('#provider_ackn_checkbox_form input[name=action]').val('add'); 
	$('#provider_ackn_checkbox_form input[name=required][value=1]').prop("checked", true);
    $('#provider_ackn_checkbox_form input[name=status][value=1]').prop("checked", true);
});

/**
*   it sets the null values in form content checkbox.
*/
$(document).on('hide.bs.modal','#add_provider_ack_checkbox',function(e){  
    $('#provider_ackn_checkbox_form span.error').hide();
 
    $('#provider_ackn_checkbox_form input[name=required][value=1]').prop("checked", true);
    $('#provider_ackn_checkbox_form input[name=status][value=1]').prop("checked", true);

    editorsArr.checkbox_content.setData('');
    editorsArr.validation_message.setData(''); 

    $('#provider_ackn_checkbox_form textarea[name=validation_message]').val('');
    $('#provider_ackn_checkbox_form input[name=checkbox_id]').val('');
    $('#provider_ackn_checkbox_form input[name=action]').val(''); 
});

/**
*   send checkbox content id  to server to delete in database.
*/ 
$(document).on('click','.delete_checkbox',function(e){
	e.preventDefault();
    var id_option = $(this).data('id');
    Swal.fire({
        title: deleteCheckboxTitle,
        text: deleteCheckboxText,
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
            formData.append('checkbox_id',id_option);
            formData.append('action','delete');
            eicCheckbox('/provider/plans/broadband/delete-plan-eic-content-checkbox',formData);
        } 
    });
});

/**
*   send checkbox acknowledge form form to server to store/edit values in database.
*/ 
$(document).on('submit','#provider_ackn_checkbox_form',function(e)
{ 
    e.preventDefault();
    $("#kt_account_ack_info .error").html("");
	let formData = new FormData(this);
    var formId = $(this).attr('id');
	eicCheckbox('/provider/plans/broadband/update-plan-eic-content-checkbox',formData,formId); 
});

/**
*   it send to axios request to server and get reponse from server also show errors  
*/ 
function eicCheckbox(url,formData,formId)
{
    loaderInstance.show();
    axios.post(url,formData)
		.then(function (response) { 
            loaderInstance.hide();  
            $(".error").html("");
            toastr.success(response.data.message); 
            $('#add_provider_ack_checkbox').modal('hide');
            setContentCheckbox(response);
		}) 
		.catch(function (error) {
            loaderInstance.hide();
			$(".error").html("");
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('[name="'+key+'"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    $('#'+formId+' .'+key+'-error').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
            else if(error.response.status == 400) {
                toastr.error(error.response);
            }
		});
}

/**
*    get an array and make table.
*/ 
function setContentCheckbox(response)
{
    data = response.data; 
    $('#ack_contenct_checkbox_tbody').html('');
    if(data.checboxList.length == 0)
    {
        $('#ack_contenct_checkbox_tbody').append('<tr><td class="text-center" colspan="7">'+ noCheckboxPlace +'</td></tr>'); 
    }
    else
    {   
        var inc = 1;
        $.each(data.checboxList,function(i,val){
            required_text = 'False';
            if(val.required == 1)
                required_text = 'True'; 

            save_checkbox_status = 'False';
            if(val.status == 1)
                save_checkbox_status = 'True'; 

            $('#ack_contenct_checkbox_tbody').append(`
                <tr>
                    <td>
                        <p>
                        ${inc}
                        </p>
                    </td> 
                    <td>
                        <p>${required_text}</p>
                    </td>  
                    <td>
                        ${add3Dots(val.content.trim(),100)}
                    </td> 
                    <td>
                        ${val.validation_message}
                    </td>
                    <td>
                        <p>${save_checkbox_status}</p>
                    </td>
                    <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        ${checkboxActionPlace}
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <div class="menu-item">
                            <a class="menu-link px-3 edit_checkbox" data-bs-toggle="modal" data-bs-target="#add_provider_ack_checkbox" 
                            data-id="${val.id}"
                            data-content="${val.content}"
                            data-required="${val.required}" 
                            data-status="${val.status}" data-validation-message="${val.validation_message}"
                            >${checkboxEditPlace}</a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link px-3 delete_checkbox" data-id="${val.id}">${checkboxDeletePlace}</a>
                        </div>
                    </td>
                </tr> 
            `);
            inc++;
            KTMenu.createInstances(); 
        });
    }
}

/**
*   add dots at the end of text for big content
*/ 
function add3Dots(str, limit) 
{
    var dots = "...";
    if(str.length > limit) { 
        str = str.substring(0,limit) + dots;
    }
    return str;
}

/**
*   store other addons in database.
*/
$(document).on('submit','#other_addon_home_connection_form,#other_addon_modem_form,#other_addon_addons_form',function(e)
{ 
    e.preventDefault(); 
	let formData = new FormData(this);
    loaderInstance.show();
    url = '/provider/plans/broadband/save-other-addon';
    axios.post(url,formData)
		.then(function (response) { 
            loaderInstance.hide();
            toastr.success(response.data.message); 
            return true;
		})
		.catch(function (error) {
            loaderInstance.hide();
			if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    if(key.includes("amount"))
                    {
                        toastr.error(value); 
                        return false;
                    } 
                });
            }
            else if(error.response.status == 400) { 
                toastr.error(error.response.data.message);  
            }
            return false;
		});  
});


/**
*   send included addon section form data to server to store in database
*/
$(document).on('submit','.included_addon_common',function(e)
{  
    e.preventDefault();
    var formId = $(this).attr('id');
	let formData = new FormData(this); 
	saveIncludedAddonForm('/provider/plans/broadband/update-included-addons',formData,formId);
});

/**
*   it send to axios request to server and get reponse from server also show errors  
*/ 
function saveIncludedAddonForm(url,formData,formId)
{
    loaderInstance.show();
    axios.post(url,formData)
		.then(function (response) { 
            loaderInstance.hide();   
            $(".error").html("");
            toastr.success(response.data.message); 
            setOtherAddonData(response.data.otherAddons);
		})
		.catch(function (error) {
            loaderInstance.hide();
			$(".error").html("");
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('#'+formId+' [name="'+key+'"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    $('#'+formId+' .'+key+'-error').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
            else if(error.response.status == 400) {
                console.log(error.response);
            }
            return false;
		});
}

/**
*   it update other addons  
*/ 
function setOtherAddonData(data)
{
    if(data)
    {
        var html = ''; 
        //home calling plan
        $.each(data.homeConnection, function(key, value) { 
            html += `
            <tr>
                <td>
                    <div class="row mb-2 mt-3"> 
                        <div class="col-lg-1 fv-row connection_allow">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input" name="addon_id[${value.id}]" type="checkbox" value="${value.id}" ${value.exist==1 ? 'checked':''}> 
                            </label> 
                        </div>
                        <label class="col-lg-6 fw-bold fs-6">${value.name}</label>
                    </div>
                </td>
            </tr>`; 
        });
        $('#other-addon-home-tbody').empty().append(html);
 
        setModemData(data);
        setAddonData(data);
        $('.form-select-dynamic').select2();

        let editorElements = document.getElementsByClassName('custom_ck_editor_dynamic'); 
        for (let index = 0; index < editorElements.length; index++) { 
            let nameOfElement = editorElements[index].getAttribute('name');
            const element = editorElements[index]; 
            ClassicEditor.create(element)
                .then(newEditor => {
                    editorsArr[nameOfElement] = newEditor;
                }).catch(error => {
                    console.error(error);
                }); 
        } 
    }
}

function setModemData(data)
{
        html = '';
        //modem plan
        $.each(data.modem, function(key, value) { 
            var costTypeOptions = '';
            $.each( costTypes, function( key, costValue ) {
                costTypeOptions += `<option value="${costValue.id}" ${costValue.id == value.cost_type_id ? 'selected' :''}>${costValue.cost_name}</option>`;    
            });

            html += `
            <div class="row mb-2 mt-3 border pt-2 pb-2">
                <div class="col-lg-4">
                    <div class="row mb-2 mt-3"> 
                        <div class="col-lg-1 fv-row connection_allow">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input other-modem-checkbox-display" name="addon_id[${value.id}]" type="checkbox" value="${value.id}" ${value.exist==1 ? 'checked':''}>
                            </label>
                        </div>
                        <label class="col-lg-6 fw-bold fs-6">${value.name}</label>
                    </div>
                </div>
                <div class="col-lg-4 other-modem-checkbox-hide ${value.exist == 0?'d-none':''}"> 
                    <select name="cost_type[${value.id}]" aria-label="${addonCostTypePlace}" data-control="select2" data-placeholder="${addonCostTypePlace}" class="form-select form-select-sm form-select-solid form-select-lg form-select-dynamic">
                        ${costTypeOptions}
                    </select>

                    <input type="text" name="amount[${value.id}]" class="form-control form-control-lg form-control-solid mt-2" placeholder="${addonCostPlace}" value="${value.price}" />
                </div>  
                <div class="col-lg-4 other-modem-checkbox-hide ${value.exist == 0?'d-none':''}"> 
                    <textarea type="text" class="form-control form-control-lg custom_ck_editor custom_ck_editor_dynamic" tabindex="8" placeholder="" rows="5" name="script[${value.id}]" style="display: none;">${value.script}</textarea>
                </div>   
            </div>`; 
        }); 
        $('#other-addon-modem-tbody').empty().append(html); 
}

function setAddonData(data)
{
    html = '';
    //addon plan
    $.each(data.addon, function(key, value) { 
        var costTypeOptions = '';
        $.each( costTypes, function( key, costValue ) {
            costTypeOptions += `<option value="${costValue.id}" ${costValue.id == value.cost_type_id ? 'selected' :''}>${costValue.cost_name}</option>`;    
        });
        html += `
        <div class="row mb-2 mt-3 border pt-2 pb-2">
            <div class="col-lg-4">
                <div class="row mb-2 mt-3">
                    <div class="col-lg-1 fv-row connection_allow">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <input class="form-check-input other-addon-checkbox-display" name="addon_id[${value.id}]" type="checkbox" value="${value.id}" ${value.exist==1 ? 'checked':''}>
                        </label>
                    </div>
                    <label class="col-lg-6 fw-bold fs-6">${value.name}</label>
                </div>
            </div>
            <div class="col-lg-4 other-addon-checkbox-hide ${value.exist == 0?'d-none':''}"> 
                <select name="cost_type[${value.id}]" aria-label="Select Cost Type" data-control="select2" data-placeholder="${addonCostTypePlace}" class="form-select form-select-sm form-select-solid form-select-lg form-select-dynamic">
                    ${costTypeOptions}
                </select>

                <input type="text" name="amount[${value.id}]" class="form-control form-control-lg form-control-solid mt-2" placeholder="${addonCostPlace}" value="${value.price}" />
            </div> 
            <div class="col-lg-4 other-addon-checkbox-hide ${value.exist == 0?'d-none':''}"> 
                <textarea type="text" class="form-control form-control-lg custom_ck_editor custom_ck_editor_dynamic" tabindex="8" placeholder="" rows="5" name="script[${value.id}]" style="display: none;">${value.script}</textarea>
            </div>   
        </div>`; 
    }); 

    $('#other-addon-addons-tbody').empty().append(html);
}

/*
* Change Status 
*/
$(document).on('click','.change-status', function(e){ 
    var check = $(this);
    var id = check.attr("data-status");
    var url = '/provider/plans/broadband/status';
    var isChecked = check.is(':checked');
    var status = 0;
    var title = disableStatusTitle;
    var text = disableStatusText;
    if(isChecked)
    {
        var status = 1; 
        title = changeStatusTitle;
        text = changeStatusText;
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
                console.log(error);
            })
            .then(function () {
               
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

/**
*   hide and show special offer fields.
*/
$(document).on('click','#special_offer_form [name="special_offer_status"]', function(e){ 
    if($(this).val() == 1) {
        $('.special_offer_field').removeClass('d-none');
        return;
    }
    $('.special_offer_field').addClass('d-none');
});

/**
*   hide and show included home connection fields.
*/
$(document).on('click','#kt_account_included_home_connection [name="status"]', function(e){  
    if($(this).val() == 1) {
        $('.included_home_connection_fields').removeClass('d-none');
        return;
    }
    $('.included_home_connection_fields').addClass('d-none');
});

/**
*   hide and show modem connection fields.
*/
$(document).on('click','#included_modem_form [name="status"]', function(e){  
    if($(this).val() == 1) {
        $('.included_modems_fields').removeClass('d-none');
        return;
    }
    $('.included_modems_fields').addClass('d-none');
});

/**
*   hide and show included adoon fields.
*/
$(document).on('click','#included_addon_form [name="status"]', function(e){  
    if($(this).val() == 1) {
        $('.included_addons_fields').removeClass('d-none');
        return;
    }
    $('.included_addons_fields').addClass('d-none');
});

/**
*   hide and show other addons fields.
*/
$(document).on('click','.other-addon-checkbox-display',function(e)
{   
    if($(this).is(":checked"))
    {
        $(this).parent().parent().parent().parent().parent().find('.other-addon-checkbox-hide').removeClass('d-none');
        return ;
    }
    $(this).parent().parent().parent().parent().parent().find('.other-addon-checkbox-hide').addClass('d-none');
});

/**
*   hide and show other modems fields.
*/
$(document).on('click','.other-modem-checkbox-display',function(e)
{   
    if($(this).is(":checked"))
    {
        $(this).parent().parent().parent().parent().parent().find('.other-modem-checkbox-hide').removeClass('d-none');
        return ;
    }
    $(this).parent().parent().parent().parent().parent().find('.other-modem-checkbox-hide').addClass('d-none');
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