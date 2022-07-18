var pageNumber = 2, processing = false;
let sales = [];
let selectedSales = [];
let allSelectedSales = [];
let qaListHtml = ''; 
$("#lead_date_id,#lead_movin_date_id").daterangepicker(
    {
        autoUpdateInput: false,
    }
);

var dateToday = new Date();
$(".movin_date").daterangepicker({
    autoApply: true,
    autoUpdateInput: false,
    singleDatePicker: true,
    minDate: dateToday,
    locale: {
        format: 'YYYY-MM-DD'
    },

});

$('.movin_date').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

$(".visit_created_date").daterangepicker({
    autoApply: true,
    autoUpdateInput: false,
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    },

});

$('.visit_created_date').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

$("#lead_date_id,#lead_movin_date_id").on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
});

$('.energy,.mobile,.broadband,.techTypeId,.propertyTypeId,.moveInDate').hide();

$(document).on('change', '#vertical_id_field', function () {
    $('.energy,.mobile,.broadband,.techTypeId,.propertyTypeId').hide();
    $('#productType').html('');
    var serviceId = $(this).val();
    $('.vertical_id_field').val(serviceId);
    showFieldsByVertical(serviceId);
    getAffiliateByService(serviceId);
});

function getAffiliateByService(serviceId) {
    $('#subAffiliateId').html('');
    loaderInstance.show();
    axios.post('get-affiliate-by-service', { 'serviceId': serviceId })
        .then(function (response) {
            loaderInstance.hide();
            html = '<option></option>';
            $.each(response.data.affiliates, function (key, value) {
                html += `<option value=${value.user_id}>${value.company_name}</option>`;
            });
            $('#affiliateId').html(html);

            html = '<option></option>';
            $.each(response.data.providers, function (key, value) {
                html += `<option value=${value.user_id}>${value.name}</option>`;
            });
            $('#providerId').html(html);
        })
        .catch(function (error) {
            loaderInstance.hide();
            console.log(error);
        });
}

$('.energy,.mobile,.broadband,.techTypeId,.propertyTypeId').hide();
$('#productType').html('');
var serviceId = $('#vertical_id_field').val();
showFieldsByVertical(serviceId)

function showFieldsByVertical(serviceId) {
    console.log("serviceId" + serviceId);
    $('.connectionType').hide();
    $('.mobileSale').hide();
    $('.energySale').hide();
    $('#connectionType').html('').select2();
    $('.move_in_div').show();
    if (serviceId == 1) {
        $('#productType').html('<option></option><option value="1">Electrity</option><option value="2">Gas</option><option value="3">LPG</option>');
        $('.energy').show();
        $('.energySale').show();
    }
    else if (serviceId == 2) {
        $('.move_in_div').hide();
        $('.mobileSale').show();
        $('.mobile,.connectionType').show();
        $('#connectionType').html(mobileConnectionTypes).select2();
    }
    else if (serviceId == 3) {
        $('.broadband,.connectionType').show();
        $('#connectionType').html(broadbandConnectionTypes).select2();
    }
}

$('#productType').change(function () {
    $('.techTypeId').hide();
    var productId = $(this).val();
    var serviceId = $('#vertical_id_field').val();
    if (productId == 1 && serviceId == 3) {
        $('.techTypeId').show();
    }
});

$('#affiliateId').change(function () {
    $('#subAffiliateId').html('');
    loaderInstance.show();
    axios.post('get-sub-affiliate-list', { 'affiliateId': $(this).val(), 'serviceId': $('#vertical_id_field').val() })
        .then(function (response) {
            loaderInstance.hide();
            html = '<option></option>';
            $.each(response.data.affiliates, function (key, value) {
                html += `<option value=${value.user_id}>${value.company_name}</option>`;
            });
            $('#subAffiliateId').html(html);
        })
        .catch(function (error) {
            loaderInstance.hide();
            console.log(error);
        });
});

$('#moveInId').change(function () {
    $('.moveInDate').hide();
    var productId = $(this).val();
    if (productId == 1) {
        $('.moveInDate').show();
    }
});

$('#apply_lead_filters').click(function (e) {
    e.preventDefault();
    pageNumber = 1;
    $('.master-checkbox').prop('checked', false);
    getFilterData();
});

$('#reset_lead_filters').click(function (e) {
    $('#filter_leads')[0].reset();
    $(".listing_filters").val('').trigger('change');
    $('#apply_lead_filters').trigger("click");
});

function getFilterData(type) {
    processing = true;
    let myForm = document.getElementById('filter_leads');
    let vertical_id = $('#vertical_id_field').val();
    let formData = new FormData(myForm);
    formData.append('verticalId', vertical_id);
    loaderInstance.show();
    axios.post('filter-data?page=' + pageNumber, formData)
        .then(function (response) {
            loaderInstance.hide();
            var html = '';
            sales = response.data.leads;
            var serviceId = response.data.serviceId;
            if (Object.keys(sales).length > 0) {
                $.each(sales, function (key, leadData) {
                    var val = leadData[0];
                    var count = leadData.length;
                    $('.mobile_heading,.energy_heading,.broadband_heading,.moving_date').addClass('d-none');
                    html += `<tr>`;
                    if (formData.get("saleType") == 'sales') {
                        html += `<td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input row-checkbox" type="checkbox" value="${val.LeadId}" data-id="${val.LeadId}" data-affiliate_id="${val.AffiliateId}" data-sale_created_dt="${val.SalesCreatedDate}" data-reference_no="${val.reference_no}" data-name="${val.VisitorFirstName}" data-affiliate_name="${val.AffiliateLegalName}"  data-assigned_qa="${val.AssignedUser}"/></div></td>`;
                    }
                    html += `<td>${val.LeadId}</td>`;
                    if (formData.get("saleType") == 'sales') {
                        html += `<td>${val.reference_no}<br> ${(count > 1 && leadData[0]['ProviderId'] != leadData[1]['ProviderId']) ? leadData[1]['reference_no'] : ''}</td>`;
                    }
                    else if (formData.get("saleType") == 'visits') {
                        html += `<td>${val.browser}</td>`;
                    }
                    if (formData.get("saleType") == 'sales' || formData.get("saleType") == 'leads') {
                        html += `<td>${val.VisitorFirstName}</td>`;
                        if (serviceId == 1) {
                            $('.energy_heading').removeClass('d-none');
                            html += `<td>${val.ProductTypeDescription}</td>`;
                        }
                        else if (serviceId == 2) {
                            $('.mobile_heading,.broadband_heading').removeClass('d-none');
                            html += `<td>${val.ConnectionName}</td><td>${val.PlanName}</td>`;
                        } else if (serviceId == 3) {
                            $('.mobile_heading').removeClass('d-none');
                            html += `<td>${val.ConnectionName}</td>`;
                        }
                    }
                    html += `<td>${val.AffiliateLegalName}</td><td>${val.SubAffiliateName != null ? val.SubAffiliateName : 'N/A'}</td>`;
                    if (formData.get("saleType") == 'sales') {
                        html += `<td>${val.ProiderName}</td><td>${val.AssignedUserName != null ? val.AssignedUserName : ''}</td><td>${val.CollabratorName != null ? val.CollabratorName : ''}</td><td id="status_${val.LeadId}"><div class="badge badge-light-success">${val.SaleStatus != null ? val.SaleStatus : '--'}</div><br>`;
                        if (count > 1) {
                            html += `<div class="badge badge-light-success">${leadData[1]['SaleStatus'] != null ? leadData[1]['SaleStatus'] : '--'} </div></td>`;
                        }
                        html += `</td>`;
                        if (serviceId == 1) {
                            $('.moving_date').removeClass('d-none');
                            html += `<td>${val.MovingDate}</td>`;
                        }
                        html += `<td>${val.SalesCreatedDate}</td>`;
                    }
                    else if (formData.get("saleType") == 'leads') {
                        if (serviceId == 1) {
                            $('.moving_date').removeClass('d-none');
                            html += `<td>${val.MovingDate}</td>`;
                        }
                        html += `<td>${val.JourneyCompleted != null ? val.JourneyCompleted : '0'}</td>
								<td>${val.IsDuplicate != null ? val.IsDuplicate : 'No'}</td>
								<td>${val.LeadCreatedDate}</td>`;
                    }
                    else if (formData.get("saleType") == 'visits') {
                        html += `<td>${val.LeadCreatedDate}</td>`;
                    }
                    html += `<td class="text-end"><a href="/${formData.get('saleType')}/detail/${vertical_id}/${val.LeadDataId}"  title="View"><i class="bi bi-eye fs-2 mx-1 text-primary"></i></a>`;
                    if (formData.get("saleType") == 'leads') {
                        html += `<a href="" title="Remove Lead"><i class="bi bi-trash fs-2 mx-1 text-danger"></i></a>`;
                    }
                    else if (formData.get("saleType") == 'sales') {
                        html += `<a role="button" onclick="openSchemaModal('${val.LeadId}')"><i class="bi bi-filetype-csv fs-2 mx-1 text-success"></i></a>`;
                    }
                    html += `</td></tr>`;
                });
                processing = false;
            }
            else {
                html = '<tr style="text-align:center"><td colspan="11">No Data Found</td></tr>'
            }
            if (type == 'scroll') {
                KTMenu.createInstances();
                $('.lead_table_data_body').append(html);
                pageNumber += 1;
                return;
            }
            KTMenu.createInstances();
            pageNumber = 2;
            $('.lead_table_data_body').html(html);
        })
        .catch(function (error) {
            loaderInstance.hide();
            console.log(error);
        });
}

$(document).scroll(function (e) {
    if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
        if (processing)
            return false;
        getFilterData('scroll');
    }
});

// Assigned User code
$('#assign-qa').click(async function () {
    let saleIds = [];
    $('.assigned_user_table_data_body').html('');
    if ($('.row-checkbox:checked').length) {
        $('#kt_assign_sale_modal').modal('show');
        $('.assigned_user_table_data_body').append(`<tr>
			<td colspan="8">
				<div class="overlay overlay-block card-rounded text-center">
					<div class="overlay-wrapper p-5">
						Please Wait...
					</div>
					<div class="overlay-layer card-rounded bg-dark bg-opacity-5">
						<div class="spinner-border text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</div>
				</div>
			</td>
		</tr>`)

        // if (qaListHtml == '') {
        // 	await getQaList();
        // }
        // await getAssignedQa();
        $('.assigned_user_table_data_body').html('');
        $.each($('.row-checkbox:checked'), function () {
            let saleStatusText = $('#status_'+$(this).data('id')).html(); 
            selectedSales.push({ 'id': $(this).data('id') })
            var html =`
                        <tr>
                            <td>${$(this).data('reference_no')}</td>
                            <td>${$(this).data('name')}</td>
                            <td>${$(this).data('affiliate_name')}</td>
                            <td>
                                ${saleStatusText}
                            </td>
                        `;
                       if(checkPermission('sale_assign_qa_section',appPermissions,userPermissions))
                        {
                            if(checkPermission('sale_assign_qa_to_sale',appPermissions,userPermissions))
                            {
                                html += `<td>
                                <input type="hidden" name="sales_id[]" value="${$(this).data('id')}">
                                <input type="hidden" name="ref_no[${$(this).data('id')}]" value="${$(this).data('reference_no')}">
                                <select class="form-select mb-2 qa-list qa-common" name="qas[${$(this).data('id')}][]" id="qa_${$(this).data('id')}" data-row="${$(this).data('id')}" data-control="select2" data-hide-search="true" data-placeholder="Select QA">
                                ${qaListHtml}
                                </select>

                                        </td>`;
                            }

                            if(checkPermission('sale_assign_collaborator_to_sale',appPermissions,userPermissions))
                            {
                                html += `
                                        <td>
                                        <select class="form-select mb-2 qa-list collaborator-common" name="collaborator[${$(this).data('id')}][]" id="collaborator_${$(this).data('id')}" data-row="${$(this).data('id')}" data-control="select2" data-hide-search="true" data-placeholder="Select Collaborator" multiple>
                                        ${qaListHtml}
                                        </select>
                                        </td>`;
                            }
                        }
                    html += `
                    </tr>
                    `;
            $('.assigned_user_table_data_body').append( html);
        })
        $('.assigned_qas_list').html(qaListHtml);
        await getAssignedQa();
        $('.assigned_qas_list,.qa-list').select2({
            allowClear: true
        });
        KTMenu.createInstances();
    } else {
        toastr.error('Please select atleast one sale.')
    }
});

const getAssignedQa = () => {
    return new Promise((resolve, reject) => {
        selectedLeadId = [];
        sales = {};
        qaListHtml = '';
        $.each($('.row-checkbox:checked'), function () {
            let affiliateId = $(this).data('affiliate_id');
            let saleCreatedDt = $(this).data('sale_created_dt');
            let id = $(this).data('id');
            selectedLeadId.push({ 'id': $(this).data('id') })
            sales[id]={affiliateId,saleCreatedDt};
        });
        var serviceId = $('#vertical_id_field').val();
        axios.post('/sales/get-assigned-qa-list', { 'lead_id': selectedLeadId, sales, 'serviceId': serviceId })
            .then(function (response) {
                allSelectedSales = response.data.assigned_qas;  
                let saleQas = response.data.saleQas;
                for (var key in saleQas) {
                    if (saleQas.hasOwnProperty(key)) {
                        items = [];
                        let qaList = '<option></option>';
                        saleQas[key].forEach(element => {
                            qaList += `<option value="${element.id}">${element.full_name}</option>`;
                        });
                        $('#qa_'+key+' ,#collaborator_'+key).html(qaList);
                    }
                }
                let saleAssinedQas = response.data.saleAssinedQas;
                for (var key in saleAssinedQas) {
                    if (saleAssinedQas.hasOwnProperty(key)) {
                        let collaborators = [];
                        saleAssinedQas[key].forEach(element => {
                            if(element.type == 1)
                                $('#qa_'+key).val(element.user_id).change();
                            if(element.type == 2)
                                collaborators.push(element.user_id)
                        });
                        $('#collaborator_'+key).val(collaborators).change();
                    }
                }
                resolve('resolved');
            }).catch(err => {
                if (err.response.status && err.response.data.message)
                    toastr.error(err.response.data.message);
                else
                    toastr.error('Whoops! something went wrong.');
                reject('resolved');
            });
    });
}


$('#master-qa').on('change', function (e) {
    $('#master-collaborators').find("option[disabled='disabled']").removeAttr('disabled');
    $('#master-collaborators').find("option[value='" + $(this).val() + "']").attr('disabled', true);
    $('#master-collaborators').trigger('change.select2');
});

$('#master-collaborators').on('change', function (e) {
    $('#master-qa').find("option[disabled='disabled']").removeAttr('disabled');
    $(this).val().forEach(element => {
        $('#master-qa').find("option[value='" + element + "']").attr('disabled', true);
    });
    $('#master-qa').trigger('change.select2');
});

$('#apply-master-dropdown').click(function () {
    $('.qa-common').val($('#master-qa').val()).trigger('change.select2').change();
    $('.collaborator-common').val($('#master-collaborators').val()).trigger('change.select2').change();
})
$(document).on('change', '.qa-common', function (e) {
    $('#collaborator_' + $(this).data('row')).find("option[disabled='disabled']").removeAttr('disabled');
    $('#collaborator_' + $(this).data('row')).find("option[value='" + $(this).val() + "']").attr('disabled', true);
    $('#collaborator_' + $(this).data('row')).trigger('change.select2');
});

$(document).on('change', '.collaborator-common', function (e) {
    $('#qa_' + $(this).data('row')).find("option[disabled='disabled']").removeAttr('disabled');
    $(this).val().forEach(element => {
        $('#qa_' + $(this).data('row')).find("option[value='" + element + "']").attr('disabled', true);
    });
    $('#qa_' + $(this).data('row')).trigger('change.select2');
});

const assignUsers = () => {
    var formData = $('#assigned_user_form').serialize();
    formData += '&verticalId=' + $('#vertical_id_field').val()
    axios.post('/sales/assign-qa', formData)
        .then(response => {
            toastr.success(response.data.message)
            $('.master-checkbox,.row-checkbox').prop('checked', false);
            pageNumber = 1;
            getFilterData();
            $('#kt_assign_sale_modal').modal('hide');
        }).catch(err => {
            if (err.response.status == 422) {
                showValidationMessages(err.response.data.errors);
            }
            if (err.response.status && err.response.data.message)
                toastr.error(err.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        });
}

$(document).on('click', '.edit_affiliate_section', function (e) {
    var value = $(this).data('type');
    var affiliate_id = $(this).data('affiliate_id');
    if (value == 'sub-affiliate') {
        $('.dynamic_affiliate_heading').text('Change Sub Affiliate');
        $('.select-affiliate-heading').text('Select Sub Affiliate');
        $('#affiliate_select_options').data('placeholder', 'Sub Affiliate Name');
    }
    else if (value == 'affiliate') {
        $('.dynamic_affiliate_heading').text('Change Affiliate');
        $('.select-affiliate-heading').text('Select Affiliate');
        $('#affiliate_select_options').data('placeholder', 'Affiliate Name');
    }
    var formData = new FormData();
    formData.append('type', value);
    formData.append('affiliate_id', affiliate_id);
    axios.post('/sales/get_affiliate_list', formData)
        .then(response => {
            var affiliateOptions = '<option value=""></option>';
            $.each(response.data.data, function (key, value) {
                affiliateOptions += `<option value="${value.user_id}">${value.company_name}</option>`;
            });
            $('#affiliate_select_type').val(value);
            $('#affiliate_select_options').html(affiliateOptions);
            $('#affiliate_select_options').select2({
                tags: true,
                dropdownParent: $("#kt_assign_change_affiliate")
            });

            $('#kt_assign_change_affiliate').modal('show');
        }).catch(err => {
        });
});


$(document).on('submit', '#assigned_user_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    if (formData.get('affiliate_id') == null || formData.get('affiliate_id') == '') {
        toastr.error('Please select affiliate');
        return;
    }
    console.log(formData.get('affiliate_id'));
    axios.post('/sales/change_affilitae', formData)
        .then(response => {
            $('#kt_assign_change_affiliate').modal('hide');
            var data = jQuery("#affiliate_select_options option:selected").text();
            toastr.success(response.data.message)
            if (formData.get('type') == 'affiliate') {
                $('#affiliate_display_name').html(data);
                $('#sub_affiliate_display_name').html('N/A');
                $('.edit_affiliate_section').data('affiliate_id', formData.get('affiliate_id'))
                return;
            }
            $('#sub_affiliate_display_name').html(data);

        }).catch(err => {
            toastr.error(err.response.data.message)
        });
});

$(document).on('click', '.view_api_response', function () {
    $('#api_header_here').empty().text('');
    $('#api_request_here').empty().text('');
    $('#api_response_here').empty().text('');
    $("#api_header_here").css('display','none');
    $("#api_request_data").css('display','none');
    $("#api_response_data").css('display','none');
    var api_header = ($(this)).data('header');
    var api_response = ($(this)).data('response');
    var api_request = ($(this)).data('request');
    var api_response = JSON.stringify(api_response).split('{').join('');
    api_response = api_response.replace(/[^0-9,a-zA-Z-_ ]/g, " ");
    if (api_header != "") {
        $("#api_header_here").css('display','block');
        $('#api_header_here').empty().text(JSON.stringify(api_header));
        $('#api_header_here').prepend("<b>Header data</b>: <br/>");
        $('#api_header_here').css("margin-bottom", '20px');
    }
    if (api_request != "") {
        $("#api_request_data").css('display','block');
        $('#api_request_here').empty().text(JSON.stringify(api_request, undefined, '\t'));
        $('#api_request_here').prepend("<b>Request data</b>: <br/>");
        $('#api_request_here').css("margin-bottom", '20px');

    }
    if (api_response != "") {
        $("#api_response_data").css('display','block');
        $('#api_response_here').empty().text(JSON.stringify(api_response));
        $('#api_response_here').prepend("<b>Response data</b>: <br/>");
        $('#api_response_popup').modal('show');
    }

});

$(document).on('click', '.update_section', function (e) {
    e.preventDefault();
    $('#' + $(this).data('initial')).hide();
    let formType = $(this).data('for');
    var serviceId = $(this).data('service_id');
    $('#' + $(this).data('for')).show();
    var lead_id = $(this).data('lead_id');
    $('input[name=leadId]').val(lead_id);
    $('input[name=comment]').val('');
})

$(document).on('click', '.close_section', function (e) {
    e.preventDefault();
    $('#' + $(this).data('initial')).hide();
    $('#' + $(this).data('for')).show();
})

$(document).on('submit', '#stage_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('form_name', 'stage_form');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update stage data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/sale-detail/update-stage';
            loaderInstance.show();
            axios.post(url, formData)
                .then(function (response) {
                    if (response.data.status == true) {
                        loaderInstance.hide();
                        $(".error").html("");
                        $('#stage_show').show();
                        $('#stage_edit').hide();
                        toastr.success(response.data.message);
                        switch (response.data.leadUpdatedData.visitor_source) {
                            case (1):
                                $(".source_td").text('API');
                                break;
                            case (2):
                                $(".source_td").text('Agent');
                                break;
                            case (3):
                                $(".source_td").text('Manual');
                                break;
                        }
                        if (response.data.saleUpdatedData != null) {
                            switch (response.data.saleUpdatedData.sale_completed_by) {
                                case (1):
                                    $(".sale_completed_by_td").text('Customer');
                                    break;
                                case (2):
                                    $(".sale_completed_by_td").text('Agent');
                                    break;
                                case (3):
                                    $(".sale_completed_by_td").text('Agent Assisted');
                                    break;
                            }
                        }
                        if (response.data.saleType == 'sales') {
                            $(".sms_td").text(response.data.unsubscribeUpdatedData.sms_unsubscribe == 1 ? 'Opt-Out' : 'Opt-In');
                            $(".email_td").text(response.data.unsubscribeUpdatedData.email_unsubscribe == 1 ? 'Opt-Out' : 'Opt-In');
                        }
                        if (response.data.saleType == 'sales') {
                            if (response.data.elecUpdatedData != null) {
                                $(".electricity_sale_duplicate_td").text(response.data.elecUpdatedData.is_duplicate == 1 ? 'Yes' : 'No');
                            }
                            if (response.data.gasUpdatedData != null) {
                                $(".gas_sale_duplicate_td").text(response.data.gasUpdatedData.is_duplicate == 1 ? 'Yes' : 'No');
                            }
                        }
                        if (response.data.mobileUpdatedData != null) {
                            if (response.data.saleType == 'sales') {
                                $(".sale_duplicate_td").text(response.data.mobileUpdatedData.is_duplicate == 1 ? 'Yes' : 'No');
                            }
                            switch (response.data.mobileUpdatedData.sale_completed_by) {
                                case (1):
                                    $(".sale_completed_by_td").text('Customer');
                                    break;
                                case (2):
                                    $(".sale_completed_by_td").text('Agent');
                                    break;
                                case (3):
                                    $(".sale_completed_by_td").text('Agent Assisted');
                                    break;
                            }
                        } if (response.data.broadbandUpdatedData != null) {
                            if (response.data.saleType == 'sales') {
                                $(".sale_duplicate_td").text(response.data.broadbandUpdatedData.is_duplicate == 1 ? 'Yes' : 'No');
                            }
                            switch (response.data.broadbandUpdatedData.sale_completed_by) {
                                case (1):
                                    $(".sale_completed_by_td").text('Customer');
                                    break;
                                case (2):
                                    $(".sale_completed_by_td").text('Agent');
                                    break;
                                case (3):
                                    $(".sale_completed_by_td").text('Agent Assisted');
                                    break;
                            }
                        }
                    }
                }).catch(function (error) {
                    loaderInstance.hide();
                    $(".error").html("");
                    if (error.response.status == 422) {
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                        toastr.error('Please Check Errors');
                    }
                    else if (error.response.status == 400) {
                        toastr.error(error.response.message);
                    }
                    return false;
                });
        }
    });

});
$(document).on('submit', '#customer_note_edit_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('form_name', 'customer_note_edit_form');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update customer notes data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/customer/update-customer-note';
            axios.post(url, formData)
                .then(function (response) {
                    if (response.data.status == 200) {
                        if (response.data.verticalId == 1) {
                            if (response.data.data.length >= 2) {
                                $('.electricityNote').html(response.data.data[0]['note']);
                                $('.gasNote').html(response.data.data[1]['note']);

                            } else {
                                if (response.data.data[0].product_type == 1) {
                                    $('.electricityNote').html(response.data.data[0].note);
                                } else if (response.data.data[0].product_type == 2) {
                                    $('.gasNote').html(response.data.data[0].note);
                                }
                            }
                        }
                        else {
                            $('.customerNote').html(response.data.data[0].note);
                        }
                        $('.comment').val('');
                        $('#customer_note_edit').hide();
                        $('#customer_note_show').show();
                        toastr.success(response.data.message);
                    } else {

                        toastr.error(response.data.message);
                    }
                    // console.log(response);
                    // toastr.success("Comment added successfully");
                    console.log(response.data.data.length);
                }).catch(function (error) {
                    if (error.response.status == 422) {
                        $(".error").html("");
                        var inc = 1;
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            if (inc == 1) {
                                $('[name="' + key + '"]').focus();
                                inc++;
                            }
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            // $('#'+formId+' .'+key+'-error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                    }
                    toastr.error("Please check errors");
                    // toastr.error("Something went wrong");

                });
        }
    });

});
$('input[type=radio][name=life_support]').change(function () {
    $('span.error').html('');
    var lifeSupportVal = this.value;
    if (lifeSupportVal == 0) {
        $('#life_support_equipment').hide();
        $('#life_support_fuel').hide();
        $("#medical_equipment_value").val('').trigger('change');
        $("#medical_equipment_energytype").val('').trigger('change');
    }
    else if (lifeSupportVal == 1) {
        $('#life_support_equipment').show();
        $('#life_support_fuel').show();
    }
});

$('input[type=radio][name=move_in]').change(function () {
    $('span.error').html('');
    var moveInVal = this.value;
    if (moveInVal == 0) {
        $('#electricity_move_in').hide();
        $('#gas_move_in').hide();
        $('#move_in_time').hide();
        $('#is_access_issue').hide();
        $('#is_electric_work').hide();
        $('#elec_movin_date').val('');
        $('#gas_movin_date').val('');
        $('#elec_provider').show();
        $('#gas_provider_show').show();
        $("#prefered_move_in_time").val('').trigger('change');
    }
    else if (moveInVal == 1) {
        $('#electricity_move_in').show();
        $('#gas_move_in').show();
        $('#move_in_time').show();
        $('#is_electric_work').show();
        $('#is_access_issue').show();
        $('#elec_provider').hide();
        $('#gas_provider_show').hide();
        $("#electricity_provider").val('').trigger('change');
        $("#gas_provider").val('').trigger('change');
    }
});
$('input[type=radio][name=solar]').change(function () {
    $('span.error').html('');
    var solarVal = this.value;
    if (solarVal == 0) {
        $('#solar_type').hide();
        $("#solar_tarriff_type").val('').trigger('change');
    }
    else if (solarVal == 1) {
        $('#solar_type').show();
    }
});


$(document).on('submit', '#customer_journey_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    var formId = $(this).attr('id');
    formData.append('form_name', formId);
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update journey data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/sale-detail/update-journey';
            loaderInstance.show();
            axios.post(url, formData)
                .then(function (response) {
                    if (response.data.status == true) {
                        loaderInstance.hide();
                        $(".error").html("");
                        $('#journey_show').show();
                        $('#journey_edit').hide();
                        $('#life_support_equipment_div').hide();
                        $('#life_support_fuel_div').hide();
                        $(".life_support_fuel").html('');
                        $(".life_support_equipment").html('');
                        $('#control_load_one_off_peak').hide();
                        $('#control_load_two_off_peak').hide();
                        $('#control_load_two_shoulder').hide();
                        $('#control_load_one_shoulder').hide();
                        $('#elec_meter_type_code').hide();
                        $('#gas_meter_type_code').hide();
                        var gasSaleUpdatedData = response.data.gasSaleUpdatedData;
                        var elecSaleUpdatedData = response.data.elecSaleUpdatedData;
                        var controlUpdatedLoad = response.data.controlUpdatedLoad;
                        var journeyUpdatedData = response.data.journeyUpdatedData;
                        var visitorUpdatedData = response.data.visitorUpdatedData;
                        $(".life_support").html(journeyUpdatedData.life_support == 1 ? 'Yes' : 'No');
                        if (journeyUpdatedData.life_support == 1) {
                            $('#life_support_equipment_div').show();
                            $('#life_support_fuel_div').show();
                            switch (journeyUpdatedData.life_support_energy_type) {
                                case (1):
                                    $(".life_support_fuel").html('Electricity');
                                    break;
                                case (2):
                                    $(".life_support_fuel").html('Gas');
                                    break;
                                case (3):
                                    $(".life_support_fuel").html('Both');
                                    break;
                            }
                            $(".life_support_equipment").html(journeyUpdatedData.life_support_value);
                        }
                        $(".moving_property").html(journeyUpdatedData.moving_house == 1 ? 'Yes' : 'No');
                        if (journeyUpdatedData.moving_house == 1) {
                            $('#elec_movin_div').show();
                            $('#gas_movin_div').show();
                            $('#is_elec_work_div').show();
                            $('#is_access_issue_div').show();
                            $('#movin_time_div').show();
                            $('#elec_provider_div').hide();
                            $('#gas_provider_div').hide();
                            if (elecSaleUpdatedData != null) {
                                $(".elec_moving_date").html(elecSaleUpdatedData.moving_at);
                            }
                            if (gasSaleUpdatedData != null) {
                                $(".gas_moving_date").html(gasSaleUpdatedData.moving_at);
                            }
                            $(".prefered_movin_time").html(journeyUpdatedData.prefered_move_in_time);
                            $(".is_elec_work").html(visitorUpdatedData.is_elec_work == 1 ? 'Yes' : 'No');
                            $(".is_any_access_issue").html(visitorUpdatedData.is_any_access_issue == 1 ? 'Yes' : 'No');
                        }
                        else if (journeyUpdatedData.moving_house == 0) {
                            $('#elec_movin_div').hide();
                            $('#gas_movin_div').hide();
                            $('#is_elec_work_div').hide();
                            $('#is_access_issue_div').hide();
                            $('#movin_time_div').hide();
                            $('#elec_provider_div').show();
                            $('#gas_provider_div').show();
                            if (elecSaleUpdatedData != null) {
                                $(".elec_provider").html(response.data.elecProvider);
                            }
                            if (gasSaleUpdatedData != null) {
                                $(".gas_provider").html(response.data.gasProvider);
                            }
                        }
                        if (elecSaleUpdatedData != null) {
                            $(".elec_distributor").html(response.data.elecDistributor.name);
                            $(".solar_panel").html(journeyUpdatedData.solar_panel == 1 ? 'Yes' : 'No');
                            $(".solar_options").html(journeyUpdatedData.solar_options ? journeyUpdatedData.solar_options : 'N/A');
                            if (controlUpdatedLoad.control_load_one_off_peak != null) {
                                $('#control_load_one_off_peak').show();
                                $('.control_load_one_off_peak').html(controlUpdatedLoad.control_load_one_off_peak);
                            }
                            if (controlUpdatedLoad.control_load_two_off_peak != null) {
                                $('#control_load_two_off_peak').show();
                                $('.control_load_two_off_peak').html(controlUpdatedLoad.control_load_two_off_peak);
                            }
                            if (controlUpdatedLoad.control_load_one_shoulder != null) {
                                $('#control_load_one_shoulder').show();
                                $('.control_load_one_shoulder').html(controlUpdatedLoad.control_load_one_shoulder);
                            }
                            if (controlUpdatedLoad.control_load_two_shoulder != null) {
                                $('#control_load_two_shoulder').show();
                                $('.control_load_two_shoulder').html(controlUpdatedLoad.control_load_two_shoulder);
                            }
                            if (elecSaleUpdatedData.meter_type_code != null) {
                                $('#elec_meter_type_code').show();
                                $('.elec_meter_type_code').html(elecSaleUpdatedData.meter_type_code);
                            }

                        }
                        if (gasSaleUpdatedData != null) {
                            $(".gas_distributor").html(response.data.gasDistributor.name);
                            if (gasSaleUpdatedData.meter_type_code != null) {
                                $('#gas_meter_type_code').show();
                                $('.gas_meter_type_code').html(gasSaleUpdatedData.meter_type_code);
                            }
                        }
                        $(".credit_score").html(controlUpdatedLoad.credit_score);
                        toastr.success(response.data.message);
                    }
                }).catch(function (error) {
                    loaderInstance.hide();
                    $(".error").html("");
                    if (error.response.status == 422) {
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                        toastr.error('Please Check Errors');
                    }
                    else if (error.response.status == 400) {
                        toastr.error(error.response.message);
                    }
                    return false;
                });
        }
    });

});

//Sale export
$(document).on("click", ".sale_info_chk_all_boxes", function (e) {
    $(".sale_info_check").prop('checked', this.checked);
});

$(document).on("click", "#sale_export_submit", function (e) {
    var checkbox_length = $(".sale_info_check:checked").length;

    if (checkbox_length) {
        var url = "{{route('admin.genrate-lead-csv')}}";
        export_csv(url, checkbox_length, checkbox_length);
        $(".sale_info_check").prop('checked', false);
        $('.sale_info_chk_all_boxes').prop('checked', false);
        $('#kt_customers_export_modal').modal('toggle');
    } else {
        toastr.error("Please select at-least one field");
    }
});

function export_csv(url, sale_info_check_length, sale_credit_check_length) {
    var movinTypeValues = "&movinstartDate=" + selectedMovinStartdate + "&movinendDate=" + selectedMovinEnddate;
    var filter_data = $("form[name=filter_sales]").serialize() + "&startDate=" + selectedStartdate + "&endDate=" + selectedEnddate + "&type=" + undefined + movinTypeValues;
    $.ajax({
        type: 'post',
        url: url,
        data: filter_data,
        dataType: 'json',
        beforeSend: function () {
            startLoader('.portlet-body');
        },
        complete: function () {
            stopLoader('.portlet-body');
        },
        success: function (response) {
            stopLoader('.portlet-body');
            var files = [];
            if (sale_info_check_length > 0) {
                files.push(response.data.sale_info.file_url);
            }
            if (sale_credit_check_length > 0) {
                files.push(response.data.sale_credit_info.file_url);
            }
            for (var i = 0; i < files.length; i++) {
                downloadURL(files[i]);
            }
        },
        error: function (data) {
            stopLoader('.portlet-body');
            show_FlashMessage(data.responseJSON.message, 'error');
        }
    });
}

$(".customer_info_dob").daterangepicker({
    autoApply: true,
    autoUpdateInput: false,
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    },
});

$(".concession_details_date").daterangepicker({
    autoApply: true,
    autoUpdateInput: false,
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    },

});

$('.customer_info_dob').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

$(document).on('click', '.edit_sales_btn', function (e) {
    e.preventDefault();
    $('#' + $(this).data('initial')).hide();
    $('#' + $(this).data('for')).show();
    $('.comment').val('');
});

$(document).on('click', '.close_sales_form_btn', function (e) {
    e.preventDefault();
    $('#' + $(this).data('initial')).hide();
    $('#' + $(this).data('for')).show();
    $('.errors').text('').removeClass('field-error').hide();
    $('#comment').val('');

});

$('.submit_btn').click(function () {
    let formId = $(this).data('form');
    if (!formId) {
        toastr.error('Whoops! something went wrong.');
        return false;
    }
    let data = new FormData($('#' + formId)[0]);
    let url = '';
    data.append('form', formId);
    switch (formId) {
        case 'customer_info_form':
            url = '/sales/sale-detail/update-customer-info';
            break;
        case 'demand_details_form':
            url = '/sales/sale-detail/update-demand-details-info';
            break;
        case 'nmi_number_form':
            url = '/sales/sale-detail/update-nmi-number-info';
            if ($('#nmi_skip').is(":checked")) {
                data.append('nmi_skip', 1);
            } else {
                data.append('nmi_skip', 0);
            }
            if ($('#mirn_skip').is(":checked")) {
                data.append('mirn_skip', 1);
            } else {
                data.append('mirn_skip', 0);
            }
            break;
        case 'site_access_info_form':
            url = '/sales/sale-detail/update-site-access-info';
            break;
        case 'qa_section_form':
            url = '/sales/sale-detail/update-qa-section-info';
            break;
        case 'other_info_form':
            url = '/sales/sale-detail/update-other-info';
            break;
    }
    $('.errors').text('').removeClass('field-error').hide();
    submitForm(url, data, formId);
});

const submitForm = (url, data, form) => {
    loaderInstance.show();
    axios.post(url, data)
        .then(response => {
            if (response.data.status == 200) {
                toastr.success('Details saved successfully.')
                if (form == 'customer_info_form') {
                    let info = response.data.customerInfoData;
                    showUpdatedCustomerInfoData(info);
                }
                if (form == 'demand_details_form') {
                    let info = response.data.demandDetailsData;
                    showUpdatedDemandDetailsData(info);
                }
                if (form == 'nmi_number_form') {
                    let info = response.data.nmiNumberData;
                    showUpdatedNmiNumberData(info);
                }
                if (form == 'site_access_info_form') {
                    let info = response.data.siteAccessData;
                    showUpdatedSiteAccessData(info);
                }
                if (form == 'qa_section_form') {
                    let info = response.data.qaSectionData;
                    showUpdatedQaSectionData(info);
                }
                if (form == 'other_info_form') {
                    let info = response.data.otherInfoData;
                    showUpdatedOtherInfoData(info);
                }
            }
            loaderInstance.hide();
        }).catch(err => {
            if (err.response.status == 422) {
                showValidationMessages(err.response.data.errors);
            }
            if (err.response.status && err.response.data.message)
                toastr.error('Please Check Errors');
            else
                toastr.error('Whoops! something went wrong.');

            loaderInstance.hide();
        });
}

const showValidationMessages = (errors) => {
    $.each(errors, function (key, value) {
        $('#' + key + '_error').addClass('field-error').text(value).fadeIn();
    });
    if ($(".field-error:first").length) {
        $("html, body").animate({
            scrollTop: $(".field-error:first").offset().top - 150
        }, 1500);
    }
}

function showUpdatedCustomerInfoData(info) {
    $('#customer_info_edit').hide();
    $('#customer_info_show').show();
    $('.errors').text('').removeClass('field-error').hide();
    $('#visitor_id').val(info.id ? info.id : '');
    $(".customer_info_title_td").text(info.title ? info.title : 'N/A');
    $(".customer_info_f_name_td").text(info.first_name ? info.first_name : 'N/A');
    $(".customer_info_m_name_td").text(info.middle_name ? info.middle_name : 'N/A');
    $(".customer_info_l_name_td").text(info.last_name ? info.last_name : 'N/A');
    $(".customer_info_email_td").text(info.email ? info.email : 'N/A');
    $(".customer_info_phone_td").text(info.phone ? info.phone : 'N/A');
    $(".customer_info_alt_phone_td").text(info.alternate_phone ? info.alternate_phone : 'N/A');
    $(".customer_info_dob_td").text(info.dob ? info.dob : 'N/A');
}

function showUpdatedDemandDetailsData(info) {
    $('#demand_details_edit').hide();
    $('#demand_details_show').show();
    $('#demand_details_enable_section').hide();
    $('#demand_details_disable_section').hide();
    $('.errors').text('').removeClass('field-error').hide();
    $('#energy_bill_details_id').val(info.id ? info.id : '');
    if (info.demand_tariff == 1) {
        $('#demand_details_enable_section').show();
        $(".ebd_demand_usage_type_td").text(info.demand_usage_type == 2 ? 'kWH' : 'KVA');
        $(".ebd_demand_tariff_code_td").text(info.demand_tariff_code ? info.demand_tariff_code : 'N/A');
        $(".ebd_demand_meter_type_td").text(info.demand_meter_type == 1 ? 'Single' : 'Time Of Use');
        $(".ebd_demand_rate1_peak_usage_td").text(info.demand_rate1_peak_usage ? info.demand_rate1_peak_usage : 'N/A');
        $(".ebd_demand_rate1_off_peak_usage_td").text(info.demand_rate1_off_peak_usage ? info.demand_rate1_off_peak_usage : 'N/A');
        $(".ebd_demand_rate1_shoulder_usage_td").text(info.demand_rate1_shoulder_usage ? info.demand_rate1_shoulder_usage : 'N/A');
        $(".ebd_demand_rate1_days_td").text(info.demand_rate1_days ? info.demand_rate1_days : 'N/A');
        $(".ebd_demand_rate2_peak_usage_td").text(info.demand_rate2_peak_usage ? info.demand_rate2_peak_usage : 'N/A');
        $(".ebd_demand_rate2_off_peak_usage_td").text(info.demand_rate2_off_peak_usage ? info.demand_rate2_off_peak_usage : 'N/A');
        $(".ebd_demand_rate2_shoulder_usage_td").text(info.demand_rate2_shoulder_usage ? info.demand_rate2_shoulder_usage : 'N/A');
        $(".ebd_demand_rate2_days_td").text(info.demand_rate2_days ? info.demand_rate2_days : 'N/A');
        $(".ebd_demand_rate3_peak_usage_td").text(info.demand_rate3_peak_usage ? info.demand_rate3_peak_usage : 'N/A');
        $(".ebd_demand_rate3_off_peak_usage_td").text(info.demand_rate3_off_peak_usage ? info.demand_rate3_off_peak_usage : 'N/A');
        $(".ebd_demand_rate3_shoulder_usage_td").text(info.demand_rate3_shoulder_usage ? info.demand_rate3_shoulder_usage : 'N/A');
        $(".ebd_demand_rate3_days_td").text(info.demand_rate3_days ? info.demand_rate3_days : 'N/A');
        $(".ebd_demand_rate4_peak_usage_td").text(info.demand_rate4_peak_usage ? info.demand_rate4_peak_usage : 'N/A');
        $(".ebd_demand_rate4_off_peak_usage_td").text(info.demand_rate4_off_peak_usage ? info.demand_rate4_off_peak_usage : 'N/A');
        $(".ebd_demand_rate4_shoulder_usage_td").text(info.demand_rate4_shoulder_usage ? info.demand_rate4_shoulder_usage : 'N/A');
        $(".ebd_demand_rate4_days_td").text(info.demand_rate4_days ? info.demand_rate4_days : 'N/A');
    }
    else {
        $('#demand_details_disable_section').show();
    }
}

function showUpdatedOtherInfoData(info) {
    $('#other_info_edit').hide();
    $('#other_info_show').show();
    $('.errors').text('').removeClass('field-error').hide();
    $(".token_td").text(info.token ? info.token : 'N/A');
    $(".qa_notes_td").text(info.qa_notes ? info.qa_notes : 'N/A');
    $(".life_support_notes_td").text(info.life_support_notes ? info.life_support_notes : 'N/A');
    $(".qa_notes_created_date_td").text(info.qa_notes_created_date ? info.qa_notes_created_date : 'N/A');
    $(".retailors_resubmission_comment_td").text(info.retailers_resubmission_comment ? info.retailers_resubmission_comment : 'N/A');
    $(".pin_number_td").text(info.pin_number ? info.pin_number : 'N/A');
    $(".sale_agent_td").text(info.sale_agent ? info.sale_agent : 'N/A');
    $(".simply_reward_id_td").text(info.simply_reward_id ? info.simply_reward_id : 'N/A');
}

$('input[type="radio"][name="billing_address_option"]').click(function () {
    if ($(this).is(':checked') && $(this).val() == '2') {
        $('.email_welcome_check').hide();
        var address_type = 'billing'
        setConnectionAddressValue(address_type)
    }
    //when other option is selected
    else if ($(this).is(':checked') && $(this).val() == '3') {
        $('#billing_info_form').show();
        $('.email_welcome_check').hide();
    }

    //when email option is selected
    else if ($(this).is(':checked') && $(this).val() == '1') {
        $('#billing_info_form').show();
        $('.email_welcome_check').show();

    } else {

    }
}); $('input[type="radio"][name="delivery_address_option"]').click(function () {
    if ($(this).is(':checked') && $(this).val() == '1') {
        var address_type = 'delivery'
        setConnectionAddressValue(address_type)
    }
    //when other option is selected
    else if ($(this).is(':checked') && $(this).val() == '2') {
        $('#delivery_info_form').show();
    }
});

function setConnectionAddressValue(address_type) {
    console.log(address_type)
    var connection_address = $('#connectioninfo_form').serialize();
    $.each($('#connectioninfo_form').serializeArray(), function (i, field) {

        if (field.name == 'connection_address') {
            $('#' + address_type + '_address').val(field.value);
        }

        //lot number
        if (field.name == 'lot_number') {
            $('#' + address_type + '_lot_number').val(field.value);
        }

        //unit number
        if (field.name == 'unit_no') {
            $('#' + address_type + '_unit_no').val(field.value);
        }

        //unit type
        if (field.name == 'unit_type') {
            $('#' + address_type + '_unit_type').val(field.value).trigger('change');;
        }

        //floor number
        if (field.name == 'floor_no') {
            $('#' + address_type + '_floor_no').val(field.value);
        }

        //floor level type
        if (field.name == 'floor_level_type') {
            $('#' + address_type + '_floor_level_type').val(field.value);
        }

        //floor type code
        if (field.name == 'floor_type_code') {
            $('#' + address_type + '_floor_type_code').val(field.value).trigger('change');;
        }

        //street number
        if (field.name == 'street_number') {
            $('#' + address_type + '_street_number').val(field.value);
        }

        //street name
        if (field.name == 'street_name') {
            $('#' + address_type + '_street_name').val(field.value);
        }

        if (field.name == 'street_number_suffix') {
            $('#' + address_type + '_street_number_suffix').val(field.value);
        }
        //street name
        if (field.name == 'street_suffix') {
            $('#' + address_type + '_street_suffix').val(field.value);
        }

        //site descriptor
        if (field.name == 'site_descriptor') {
            $('#' + address_type + '_site_descriptor').val(field.value);
        }

        //house_num
        if (field.name == 'house_num') {
            $('#' + address_type + '_house_num').val(field.value);
        }

        //house_number_suffix
        if (field.name == 'house_number_suffix') {
            $('#' + address_type + '_house_number_suffix').val(field.value);
        }

        //suburb
        if (field.name == 'suburb') {
            $('#' + address_type + '_suburb').val(field.value);
        }

        //state
        if (field.name == 'state') {
            $('#' + address_type + '_state').val(field.value).trigger('change');;
        }

        //property_name
        if (field.name == 'property_name') {
            $('#' + address_type + '_property_name').val(field.value);
        }

        //postcode
        if (field.name == 'postcode') {
            $('#' + address_type + '_postcode').val(field.value);
        }

        //property_ownership
        if (field.name == 'property_ownership') {
            $('#' + address_type + '_property_ownership').val(field.value).trigger('change');;
        }

        //street_code
        if (field.name == 'street_code') {
            $('#' + address_type + '_street_code').val(field.value).trigger('change');;
        }

        //post_code
        if (field.name == 'post_code') {
            $('#' + address_type + '_post_code').val(field.value);

        }//dpid
        if (field.name == 'connection_dpid') {
            $('#' + address_type + '_dpid').val(field.value);
        }


        //unit_type_code
        if (field.name == 'unit_type_code') {
            $('#' + address_type + '_unit_type_code').val(field.value).trigger('change');;
        }

        //unit_type_code
        if (field.name == 'floor_type_code') {
            $('#' + address_type + '_floor_type_code').val(field.value);
        }

        if (field.name == 'is_qas_valid') {
            $('#is_qas_valid').val(field.value);
        }

        if (field.name == 'validate_address') {
            $('#' + address_type + '_validate_address').val(field.value);
        }

        $('#' + address_type + '_info_form').hide();
    });
}


$(document).on('submit', '#connectioninfo_form,#billinginfo_form,#pobox_form,#manual_connection_form,#gas_connection_form,#deliveryinfo_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    var formId = $(this).attr('id');
    formData.append('form_name', formId);
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update address data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/sale-detail/update-address';
            loaderInstance.show();
            axios.post(url, formData)
                .then(function (response) {
                    if (response.data.status == true) {
                        loaderInstance.hide();
                        $(".error").html("");
                        toastr.success(response.data.message);
                        if (response.data.addressId == 'connectioninfo_form') {
                            $('#connection_address_show').show();
                            $('#connection_address_edit').hide();
                            response.data.data.forEach(element => {
                                $('input[name=connectionAddressId]').val(element.id);
                                $('.connection-address-td').text(element.address ? element.address : 'N/A');
                                $('.connection-lot-number').text(element.lot_number ? element.lot_number : 'N/A');
                                $('.connection-unit-number').text(element.unit_number ? element.unit_number : 'N/A');
                                $('.connection-unit-type').text(element.unit_type ? element.unit_type : 'N/A');
                                $('.connection-unit-type-code').text(element.unit_type_code ? element.unit_type_code : 'N/A');
                                $('.connection-floor-number').text(element.floor_number ? element.floor_number : 'N/A');
                                $('.connection-floor-level-type').text(element.floor_level_type ? element.floor_level_type : 'N/A');
                                $('.connection-floor-type_code').text(element.floor_type_code ? element.floor_type_code : 'N/A');
                                $('.connection-street-name').text(element.street_name ? element.street_name : 'N/A');
                                $('.connection-street-number').text(element.street_number ? element.street_number : 'N/A');
                                $('.connection-street-suffix').text(element.street_suffix ? element.street_suffix : 'N/A');
                                $('.connection-street-code').text(element.street_code ? element.street_code : 'N/A');
                                $('.connection-house-number').text(element.house_number ? element.house_number : 'N/A');
                                $('.connection-house-number-suffix').text(element.house_number_suffix ? element.house_number_suffix : 'N/A');
                                $('.connection-suburb').text(element.suburb ? element.suburb : 'N/A');
                                $('.connection-property-name').text(element.property_name ? element.property_name : 'N/A');
                                $('.connection-state').text(element.state ? element.state : 'N/A');
                                $('.connection-postcode').text(element.postcode ? element.postcode : 'N/A');
                                $('.connection-site-location').text(element.site_descriptor ? element.site_descriptor : 'N/A');
                                $('.connection-property-ownership').text(element.property_ownership ? element.property_ownership : 'N/A');
                                $('.connection-dpid').text(element.dpid ? element.dpid : 'N/A');
                                $('.connection-qas').text(element.is_qas_valid == 1 ? 'Yes' : 'No');
                                $('.connection-address-validation').text(element.validate_address == 1 ? 'Yes' : 'No');
                            });
                        }
                        if (response.data.addressId == 'gas_connection_form') {
                            $('#gas_address_show').show();
                            $('#gas_address_edit').hide();
                            response.data.data.forEach(element => {
                                $('input[name=gasConnectionAddressId]').val(element.id);
                                $('.gas_connection_td').text(element.is_same_gas_connection == 1 ? 'Yes' : 'No')
                                $('.gas_connection-address-td').text(element.address ? element.address : 'N/A');
                                $('.gas_connection-lot-number').text(element.lot_number ? element.lot_number : 'N/A');
                                $('.gas_connection-unit-number').text(element.unit_number ? element.unit_number : 'N/A');
                                $('.gas_connection-unit-type').text(element.unit_type ? element.unit_type : 'N/A');
                                $('.gas_connection-unit-type-code').text(element.unit_type_code ? element.unit_type_code : 'N/A');
                                $('.gas_connection-floor-number').text(element.floor_number ? element.floor_number : 'N/A');
                                $('.gas_connection-floor-level-type').text(element.floor_level_type ? element.floor_level_type : 'N/A');
                                $('.gas_connection-floor-type_code').text(element.floor_type_code ? element.floor_type_code : 'N/A');
                                $('.gas_connection-street-name').text(element.street_name ? element.street_name : 'N/A');
                                $('.gas_connection-street-number').text(element.street_number ? element.street_number : 'N/A');
                                $('.gas_connection-street-suffix').text(element.street_suffix ? element.street_suffix : 'N/A');
                                $('.gas_connection-street-code').text(element.street_code ? element.street_code : 'N/A');
                                $('.gas_connection-house-number').text(element.house_number ? element.house_number : 'N/A');
                                $('.gas_connection-house-number-suffix').text(element.house_number_suffix ? element.house_number_suffix : 'N/A');
                                $('.gas_connection-suburb').text(element.suburb ? element.suburb : 'N/A');
                                $('.gas_connection-property-name').text(element.property_name ? element.property_name : 'N/A');
                                $('.gas_connection-state').text(element.state ? element.state : 'N/A');
                                $('.gas_connection-postcode').text(element.postcode ? element.postcode : 'N/A');
                                $('.gas_connection-site-location').text(element.site_descriptor ? element.site_descriptor : 'N/A');
                                $('.gas_connection-property-ownership').text(element.property_ownership ? element.property_ownership : 'N/A');
                                $('.gas_connection-dpid').text(element.dpid ? element.dpid : 'N/A'
                                );
                                $('.gas_connection-address-validation').text(element.validate_address == 1 ? 'Yes' : 'No');
                            });
                        }
                        if (response.data.addressId == 'pobox_form') {
                            $('#pobox_address_show').show();
                            $('#pobox_address_edit').hide();
                            response.data.data.forEach(element => {
                                $('input[name=poBoxAddressId]').val(element.id);
                                if (element.po_box == null) {
                                    $('#pobox_row').show();
                                    $('#po_box_row').hide();
                                    $('#pobox_row').html(`<div class="col-md-4 m-auto fw-bolder text-gray-600"> No PO Box Address Available
                </div>`);
                                    $('.po_box_status').html(`Disable`);
                                }
                                else {
                                    $('#pobox_row').hide();
                                    $('#po_box_row').show();
                                    $('.po_box_status').html(`Enable`);
                                }
                                $('.po-address-status').text(element.po_box == null ? 'Disable' : 'Enable');
                                $('.po-address-number').text(element.po_box ? element.po_box : 'N/A');
                                $('.po-address-suburb').text(element.suburb ? element.suburb : 'N/A');
                                $('.po-address-state-code').text(element.state_code ? element.state_code : 'N/A');
                                $('.po-address-postcode').text(element.postcode ? element.postcode : 'N/A');
                                $('.po-address-qas').text(element.is_qas_valid == 1 ? 'Yes' : 'No');
                                $('.po-address-validate-address').text(element.validate_address == 1 ? 'Yes' : 'No');
                                $('.po-address-dpid').text(element.dpid ? element.dpid : 'N/A');
                            });
                        }
                        if (response.data.addressId == 'manual_connection_form') {
                            $('#manual_connection_address_show').show();
                            $('#manual_connection_address_edit').hide();
                            response.data.data.forEach(element => {
                                $('input[name=manualAddressId]').val(element.id);
                                $('.manual_connection_td').text(element.manual_connection_details ? element.manual_connection_details : 'N/A');
                            });
                        }
                        if (response.data.addressId == 'billinginfo_form') {
                            $('#billing_address_show').show();
                            $('.email_welcome_pack').hide();
                            $('.billing_email_tr').hide()
                            $('#billing_address_edit').hide();
                            $('#billing_address_body').hide();
                            $('#billing_connection_tr').hide();
                            response.data.data.forEach(element => {
                                $('input[name=billingAddressId]').val(element.id);
                                switch (element.billing_preference) {
                                    case (1):
                                        $('.billing_preference_td').text('Email')
                                        $('.billing_email_tr').show()
                                        $('.email_welcome_pack').show();
                                        $('.email_welcome_pack_td').text(element.email_welcome_pack == 1 ? 'Yes' : 'No')
                                        break;
                                    case (2):
                                        $('.billing_preference_td').text('Connection')
                                        $('#billing_connection_tr').show();
                                        $('.billing_connection_tr').text(element.address ? element.address : 'N/A')
                                        break;
                                    default:
                                        $('.billing_preference_td').text('Other')
                                }
                                if ((element.billing_preference == 1 && element.email_welcome_pack == 1) || element.billing_preference == 3) {
                                    $('#billing_address_body').show();
                                    $('.billing-address-td').text(element.address ? element.address : 'N/A');
                                    $('.billing-lot-number').text(element.lot_number ? element.lot_number : 'N/A');
                                    $('.billing-unit-number').text(element.unit_number ? element.unit_number : 'N/A');
                                    $('.billing-unit-type').text(element.unit_type ? element.unit_type : 'N/A');
                                    $('.billing-unit-type-code').text(element.unit_type_code ? element.unit_type_code : 'N/A');
                                    $('.billing-floor-number').text(element.floor_number ? element.floor_number : 'N/A');
                                    $('.billing-floor-level-type').text(element.floor_level_type ? element.floor_level_type : 'N/A');
                                    $('.billing-floor-type-code').text(element.floor_type_code ? element.floor_type_code : 'N/A');
                                    $('.billing-street-name').text(element.street_name ? element.street_name : 'N/A');
                                    $('.billing-street-number').text(element.street_number ? element.street_number : 'N/A');
                                    $('.billing-street-suffix').text(element.street_suffix ? element.street_suffix : 'N/A');
                                    $('.billing-street-code').text(element.street_code ? element.street_code : 'N/A');
                                    $('.billing-house-number').text(element.house_number ? element.house_number : 'N/A');
                                    $('.billing-house-number-suffix').text(element.house_number_suffix ? element.house_number_suffix : 'N/A');
                                    $('.billing-suburb').text(element.suburb ? element.suburb : 'N/A');
                                    $('.billing-property-name').text(element.property_name ? element.property_name : 'N/A');
                                    $('.billing-state').text(element.state ? element.state : 'N/A');
                                    $('.billing-postcode').text(element.postcode ? element.postcode : 'N/A');
                                    $('.billing-site-location').text(element.site_descriptor ? element.site_descriptor : 'N/A');
                                    $('.billing-property-ownership').text(element.property_ownership ? element.property_ownership : 'N/A');
                                    $('.billing-dpid').text(element.dpid ? element.dpid : 'N/A');
                                    $('.billing-address-validation').text(element.validate_address == 1 ? 'Yes' : 'No');
                                }

                            });
                        }
                        if (response.data.addressId == 'deliveryinfo_form') {
                            $('#delivery_address_show').show();
                            $('#delivery_address_edit').hide();
                            $('#delivery_address_body').hide();
                            $('#delivery_connection_tr').hide();
                            response.data.data.forEach(element => {
                                $('input[name=deliveryAddressId]').val(element.id);
                                switch (element.delivery_preference) {
                                    case (1):
                                        $('.delivery_preference_td').text('Connection')
                                        $('#delivery_connection_tr').show();
                                        $('.delivery_connection_tr').text(element.address ? element.address : 'N/A')
                                        break;
                                    case (2):
                                        $('.delivery_preference_td').text('Other')
                                        break;
                                }
                                if (element.delivery_preference == 2) {
                                    $('#delivery_address_body').show();
                                    $('.delivery-address-td').text(element.address ? element.address : 'N/A');
                                    $('.delivery-lot-number').text(element.lot_number ? element.lot_number : 'N/A');
                                    $('.delivery-unit-number').text(element.unit_number ? element.unit_number : 'N/A');
                                    $('.delivery-unit-type').text(element.unit_type ? element.unit_type : 'N/A');
                                    $('.delivery-unit-type-code').text(element.unit_type_code ? element.unit_type_code : 'N/A');
                                    $('.delivery-floor-number').text(element.floor_number ? element.floor_number : 'N/A');
                                    $('.delivery-floor-level-type').text(element.floor_level_type ? element.floor_level_type : 'N/A');
                                    $('.delivery-floor-type-code').text(element.floor_type_code ? element.floor_type_code : 'N/A');
                                    $('.delivery-street-name').text(element.street_name ? element.street_name : 'N/A');
                                    $('.delivery-street-number').text(element.street_number ? element.street_number : 'N/A');
                                    $('.delivery-street-suffix').text(element.street_suffix ? element.street_suffix : 'N/A');
                                    $('.delivery-street-code').text(element.street_code ? element.street_code : 'N/A');
                                    $('.delivery-house-number').text(element.house_number ? element.house_number : 'N/A');
                                    $('.delivery-house-number-suffix').text(element.house_number_suffix ? element.house_number_suffix : 'N/A');
                                    $('.delivery-suburb').text(element.suburb ? element.suburb : 'N/A');
                                    $('.delivery-property-name').text(element.property_name ? element.property_name : 'N/A');
                                    $('.delivery-state').text(element.state ? element.state : 'N/A');
                                    $('.delivery-postcode').text(element.postcode ? element.postcode : 'N/A');
                                    $('.delivery-site-location').text(element.site_descriptor ? element.site_descriptor : 'N/A');
                                    $('.delivery-property-ownership').text(element.property_ownership ? element.property_ownership : 'N/A');
                                    $('.delivery-dpid').text(element.dpid ? element.dpid : 'N/A');
                                    $('.delivery-address-validation').text(element.validate_address == 1 ? 'Yes' : 'No');
                                }

                            });
                        }
                    }
                }).catch(function (error) {
                    loaderInstance.hide();
                    $(".error").html("");
                    if (error.response.status == 422) {
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('field-error').text(value).finish().fadeIn();
                        });
                        if ($(".field-error:first").length) {
                            $("html, body").animate({
                                scrollTop: $(".field-error:first").offset().top - 150
                            }, 1500);
                        }
                        toastr.error('Please Check Errors'); ``
                    }
                    else if (error.response.status == 400) {
                        toastr.error(error.response.message);
                    }
                    return false;
                });
        }
    });

});
$('.concession_details_date').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

$(document).on('submit', '#concession_details_edit_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('form_name', 'concession_details_edit_form');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update concession details data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/concession/update-concession-details';
            axios.post(url, formData)
                .then(function (response) {
                    if (response.data.status == 200) {
                        console.log(response.data.data);
                        $('input[name=vcd_id]').val(response.data.data.id);
                        $(".concession_type option[value=" + response.data.data.concession_type + "]").attr('selected', 'selected');
                        $(".vcd_concession_type").html(
                            response.data.data.concession_type_name
                        );
                        $('.vcd_concession_code').html(response.data.data.concession_code);
                        $('.vcd_concession_card_number').html(response.data.data.card_number);
                        $('.vcd_card_issue_date').html(response.data.data.card_start_date);
                        $('.vcd_card_expiry_date').html(response.data.data.card_expiry_date);
                        console.log(response.data.data);
                        toastr.success(response.data.message);


                    } else {
                        toastr.error(response.data.message);
                    }
                    $('.comment').val('');
                    $('#concession_detail_edit').hide();
                    $('#concession_detail_show').show();
                    // console.log(response);
                    // toastr.success("Comment added successfully");
                    // console.log(response.data.data.length);
                }).catch(function (error) {

                    if (error.response.status == 422) {
                        $(".error").html("");
                        var inc = 1;
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            if (inc == 1) {
                                $('[name="' + key + '"]').focus();
                                inc++;
                            }
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            // $('#'+formId+' .'+key+'-error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                    }
                    toastr.error("Please check errors");

                });
        }
    });

});

$(document).on('click', '.button_primary_data', function () {
    var id = $(this).attr('data-id');
    console.log(id);
    // $('#primary_data_edit_form').find('form').attr('name',id+'_form');
    $('#primary_data_edit_form').show();
    $('#table_primary_data').hide();

});

$(document).on('click', '.button_secondary_data', function () {
    var id = $(this).attr('data-id');
    // $('#secondary_data_edit_form').find('form').attr('name',id+'_form');
    $('#secondary_data_edit_form').show();
    $('#table_secondary_data').hide();

});

$('#primary_cancel_button').click(function () {
    $('#primary_data_edit_form').hide();
    $('#table_primary_data').show();
});
$('#secondary_cancel_button').click(function () {
    $('#secondary_data_edit_form').hide();
    $('#table_secondary_data').show();

});
$(".identification_details_date").daterangepicker({
    autoApply: true,
    autoUpdateInput: false,
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    },

});

$('.identification_details_date').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});


$('#primary_identification_type').on('change', function () {
    if (this.value == "Drivers Licence") {
        $('.primary_form').hide();
        $('#primary_driver_license').show();
    }
    else if (this.value == "Foreign Passport") {
        $('.primary_form').hide();
        $('#primary_foreign_passport').show();
    }
    else if (this.value == "Passport") {
        $('.primary_form').hide();
        $('#primary_passport').show();
    }
    else if (this.value == "Medicare Card") {
        $('.primary_form').hide();
        $('#primary_medicare_card').show();
    }
});

function showUpdatedNmiNumberData(info) {
    $('#nmi_number_edit').hide();
    $('#nmi_number_show').show();
    $('.errors').text('').removeClass('field-error').hide();
    $('.visitor_info_energy_id').val(info.id ? info.id : '');
    $(".vie_nmi_number_td").text(info.nmi_number ? info.nmi_number : 'N/A');
    $(".vie_nmi_skip_td").text(info.nmi_skip == 1 ? 'True' : 'False');
    $(".vie_dpi_mirn_number_td").text(info.dpi_mirn_number ? info.dpi_mirn_number : 'N/A');
    $(".vie_mirn_skip_td").text(info.mirn_skip == 1 ? 'True' : 'False');
    $(".vie_tariff_type_td").text(info.tariff_type ? info.tariff_type : 'N/A');
    $(".vie_tariff_list_td").text(info.tariff_list ? info.tariff_list : 'N/A');
    $(".vie_meter_number_e_td").text(info.meter_number_e ? info.meter_number_e : 'N/A');
    $(".vie_electricity_network_code_td").text(info.electricity_network_code ? info.electricity_network_code : 'N/A');
    $(".vie_electricity_code_td").text(info.electricity_code ? info.electricity_code : 'N/A');
    $(".vie_meter_number_g_td").text(info.meter_number_g ? info.meter_number_g : 'N/A');
    $(".vie_gas_network_code_td").text(info.gas_network_code ? info.gas_network_code : 'N/A');
    $(".vie_gas_code_td").text(info.gas_code ? info.gas_code : 'N/A');
}

//Sale export
$(document).on("click", ".sale_info_chk_all_boxes", function (e) {
    $(".sale_listing_export").prop('checked', this.checked);
});
$(document).on("click", ".lead_info_chk_all_boxes", function (e) {
    $(".lead_listing_export").prop('checked', this.checked);
});
//Sale export
$(document).on("click", ".sale_info_chk_all_boxes_2", function (e) {
    $(".sale_listing_export_2").prop('checked', this.checked);
});

$(document).on("click", ".lead_info_chk_all_boxes_2", function (e) {
    $(".lead_listing_export_2").prop('checked', this.checked);
});

function showUpdatedSiteAccessData(info) {
    $('#site_access_info_edit').hide();
    $('#site_access_info_show').show();
    $('.errors').text('').removeClass('field-error').hide();
    $('.visitor_info_energy_id').val(info.id ? info.id : '');
    $(".vie_meter_hazard_td").text(info.meter_hazard ? info.meter_hazard : 'N/A');
    $(".vie_site_access_electricity_td").text(info.site_access_electricity ? info.site_access_electricity : 'N/A');
    $(".vie_dog_code_td").text(info.dog_code ? info.dog_code : 'N/A');
    $(".vie_site_access_gas_td").text(info.site_access_gas ? info.site_access_gas : 'N/A');
}

function showUpdatedQaSectionData(info) {
    let saleCompletedId = info.sale_completed_by ? info.sale_completed_by : '';
    let saleCompletedName = '';
    if (saleCompletedId == 1)
        saleCompletedName = "Customer";
    else if (saleCompletedId == 2)
        saleCompletedName = "Agent";
    else if (saleCompletedId == 3)
        saleCompletedName = "Agent Assisted";
    else
        saleCompletedName = "N/A";

    $('#qa_section_edit').hide();
    $('#qa_section_show').show();
    $('.errors').text('').removeClass('field-error').hide();
    $(".qa_comment_td").text(info.qa_comment ? info.qa_comment : 'N/A');
    $(".qa_sale_comment_td").text(info.sale_comment ? info.sale_comment : 'N/A');
    $(".qa_rework_comment_td").text(info.rework_comment ? info.rework_comment : 'N/A');
    $(".qa_assigned_agent_td").text(info.assigned_agent ? info.assigned_agent : 'N/A');
    $(".qa_sale_completed_by_td").text(saleCompletedName);
}

var primaryIdeTypeSelected = $('#primary_identification_type').find(":selected").val();
if (primaryIdeTypeSelected != '' && primaryIdeTypeSelected != null) {
    if (primaryIdeTypeSelected == 'Drivers Licence') {
        $('.primary_form').hide();
        $('#primary_driver_license').show();
    } else if (primaryIdeTypeSelected == "Foreign Passport") {
        $('.primary_form').hide();
        $('#primary_foreign_passport').show();
    }
    else if (primaryIdeTypeSelected == "Passport") {
        $('.primary_form').hide();
        $('#primary_passport').show();
    }
    else if (primaryIdeTypeSelected == "Medicare Card") {
        $('.primary_form').hide();
        $('#primary_medicare_card').show();
    }
}
var secondaryIdeTypeSelected = $('#secondary_identification_type').find(":selected").val();
if (secondaryIdeTypeSelected != '' && secondaryIdeTypeSelected != null) {
    if (secondaryIdeTypeSelected == 'Drivers Licence') {
        $('.secondary_form').hide();
        $('#secondary_driver_license').show();
    } else if (secondaryIdeTypeSelected == "Foreign Passport") {
        $('.secondary_form').hide();
        $('#secondary_foreign_passport').show();
    }
    else if (secondaryIdeTypeSelected == "Passport") {
        $('.secondary_form').hide();
        $('#secondary_passport').show();
    }
    else if (secondaryIdeTypeSelected == "Medicare Card") {
        $('.secondary_form').hide();
        $('#secondary_medicare_card').show();
    }
}
$('#secondary_identification_type').on('change', function () {
    if (this.value == "Drivers Licence") {
        $('.secondary_form').hide();
        $('#secondary_driver_license').show();
    }
    else if (this.value == "Foreign Passport") {
        $('.secondary_form').hide();
        $('#secondary_foreign_passport').show();
    }
    else if (this.value == "Passport") {
        $('.secondary_form').hide();
        $('#secondary_passport').show();
    }
    else if (this.value == "Medicare Card") {
        $('.secondary_form').hide();
        $('#secondary_medicare_card').show();
    }
});
$(document).on('submit', '#table_primary_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('form_name', 'table_primary_edit_form');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update primary identification data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/identification-detail/update-primary-data';
            axios.post(url, formData)
                .then(function (response) {
                    if (response.status == 200) {
                        console.log(response.data.message);
                        $(".error").html("");
                        $('#table_primary_data').empty('');
                        loadIdentificationView(response.data.data.identification_type, 'primary_data', response.data.data.verticalId);
                        $('input[name=primaryId]').val(response.data.data.id);
                        $('.primary_data_idenType').html(response.data.data.identification_type ?? '');
                        $('.primary_data_lic_state_code').html(response.data.data.licence_state_code ?? '');
                        $('.primary_data_lic_number').html(response.data.data.licence_number ?? '');
                        $('.primary_data_lic_expiry').html(response.data.data.licence_expiry_date ?? '');
                        $('.primary_data_foreign_pass_number').html(response.data.data.foreign_passport_number ?? '');
                        $('.primary_data_foreign_country_name').html(response.data.data.foreign_country_name ?? '');
                        $('.primary_data_foreign_country_code').html(response.data.data.foreign_country_code);
                        $('.primary_data_foreign_ident_expiry_date').html(response.data.data.foreign_passport_expiry_date ?? '');
                        $('.primary_data_passport_number').html(response.data.data.passport_number) ?? '';
                        $('.primary_data_passport_ident_expiry').html(response.data.data.passport_expiry_date ?? '');
                        $('.primary_data_medi_card_num').html(response.data.data.medicare_number ?? '');
                        $('.primary_data_medi_card_ident_expiry').html(response.data.data.medicare_card_expiry_date ?? '');
                        $('.primary_data_medi_ref_num').html(response.data.data.reference_number ?? '');
                        $('.primary_data_medi_card_color').html(response.data.data.card_color ?? '');
                        $('.primary_data_medi_card_middle_name').html(response.data.data.card_middle_name ?? '');

                        $('#primary_data_edit_form').hide();
                        $('#table_primary_data').show();


                        console.log(response.data.data);
                        toastr.success(response.data.message);
                    } else {
                        toastr.error("Something went wrong");

                    }

                }).catch(function (error) {
                    if (error.response.status == 422) {
                        $(".error").html("");
                        var inc = 1;
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            if (inc == 1) {
                                $('[name="' + key + '"]').focus();
                                inc++;
                            }
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            // $('#'+formId+' .'+key+'-error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                    }
                    toastr.error("Please check errors");
                });
        }
    }); fupdatestage
});
$(document).on('submit', '#table_secondary_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('form_name', 'table_secondary_edit_form');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update secondary identification data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/identification-detail/update-secondary-data';
            axios.post(url, formData)
                .then(function (response) {
                    console.log(response);
                    if (response.status == 200) {
                        $('#table_secondary_data').empty('');
                        $(".error").html("");
                        loadIdentificationView(response.data.data.identification_type, 'secondary_data', response.data.data.verticalId);
                        $('input[name=secondaryId]').val(response.data.data.id);
                        $('.secondary_data_idenType').html(response.data.data.identification_type ?? '');
                        $('.secondary_data_lic_state_code').html(response.data.data.licence_state_code ?? '');
                        $('.secondary_data_lic_number').html(response.data.data.licence_number ?? '');
                        $('.secondary_data_lic_expiry').html(response.data.data.licence_expiry_date ?? '');
                        $('.secondary_data_foreign_pass_number').html(response.data.data.foreign_passport_number ?? '');
                        $('.secondary_data_foreign_country_name').html(response.data.data.foreign_country_name ?? '');
                        $('.secondary_data_foreign_country_code').html(response.data.data.foreign_country_code ?? '');
                        $('.secondary_data_foreign_ident_expiry_date').html(response.data.data.foreign_passport_expiry_date ?? '');
                        $('.secondary_data_passport_number').html(response.data.data.passport_number ?? '');
                        $('.secondary_data_passport_ident_expiry').html(response.data.data.passport_expiry_date ?? '');
                        $('.secondary_data_medi_card_num').html(response.data.data.medicare_number ?? '');
                        $('.secondary_data_medi_card_ident_expiry').html(response.data.data.medicare_card_expiry_date ?? '');
                        $('.secondary_data_medi_ref_num').html(response.data.data.reference_number ?? '');
                        $('.secondary_data_medi_card_color').html(response.data.data.card_color ?? '');
                        $('.secondary_data_medi_card_middle_name').html(response.data.data.card_middle_name ?? '');

                        $('#secondary_data_edit_form').hide();
                        $('#table_secondary_data').show();
                        toastr.success(response.data.message);
                    } else {
                        toastr.error("Something went wrong");
                    }
                }).catch(function (error) {
                    if (error.response.status == 422) {
                        $(".error").html("");
                        var inc = 1;
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            if (inc == 1) {
                                $('[name="' + key + '"]').focus();
                                inc++;
                            }
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            // $('#'+formId+' .'+key+'-error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                    }
                    toastr.error("Please check errors");
                });
        }
    });
});

function loadIdentificationView(identifictionType, key, verticalId) {

    let heading = '';
    if (key == 'primary_data') {
        heading = 'Primary Identification';
    } else if (key == 'secondary_data') {
        heading = 'Secondary Identificarion';
    }
    var html = ` <tr>
					<td class="text-muted">
						<div class="d-flex align-items-center"><span class="text-dark fw-bolder fs-6">`+ heading + `</span></div>
					</td>
					<td>
					<div class="my-auto me-4 py-3">
						<a href=""  class="fw-bolder text-primary update_section float-end button_`+ key + `" data-id="` + key + `" ><i class="bi bi-pencil-square text-primary"></i> Edit</a>
						</div>
					</td>
				</tr>
                <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Identification Type:</div>
                                        </td>
                                        <td class="fw-bolder text-end ` + key + `_idenType">
                                        </td>
                                    </tr>`;
    switch (identifictionType) {
        case 'Drivers Licence':
            html += `<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center `+ key + `_lic_state">Licence State:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_lic_state_code">

			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Licence Number:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_lic_number">

			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Identification Expiry Date:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_lic_expiry">

			</td>
		</tr>`;
            if (verticalId == 1) {
                html += `
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">ID Matrix Reference Number:</div>
			</td>
			<td class="fw-bolder text-end">
				N/A
			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">ID Matrix Status:</div>
			</td>
			<td class="fw-bolder text-end">
				Disabled
			</td>
		</tr>`;
            }
            break;
        case 'Foreign Passport':

            html += ` <tr>
		<td class="text-muted">
			<div class="d-flex align-items-center">Passport Number:</div>
		</td>
		<td class="fw-bolder text-end `+ key + `_foreign_pass_number">

		</td>
	</tr>
	<tr>
		<td class="text-muted">
			<div class="d-flex align-items-center">Country Name:</div>
		</td>
		<td class="fw-bolder text-end `+ key + `_foreign_country_name">

		</td>
	</tr>
	<tr>
		<td class="text-muted">
			<div class="d-flex align-items-center">Country Code:</div>
		</td>
		<td class="fw-bolder text-end `+ key + `_foreign_country_code">

		</td>
	</tr>
	<tr>
		<td class="text-muted">
			<div class="d-flex align-items-center ">Identification Expiry Date:</div>
		</td>
		<td class="fw-bolder text-end `+ key + `_foreign_ident_expiry_date">

		</td>
	</tr>`;
            if (verticalId == 1) {
                html += `
    <tr>
        <td class="text-muted">
            <div class="d-flex align-items-center">ID Matrix Reference Number:</div>
        </td>
        <td class="fw-bolder text-end">
            N/A
        </td>
    </tr>
    <tr>
        <td class="text-muted">
            <div class="d-flex align-items-center">ID Matrix Status:</div>
        </td>
        <td class="fw-bolder text-end">
            Disabled
        </td>
    </tr>`;
            }
            break;
        case 'Passport':
            html += `<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Passport Number:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_passport_number">

			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Identification Expiry Date:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_passport_ident_expiry">

			</td>
		</tr>`;
            if (verticalId == 1) {
                html += `
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">ID Matrix Reference Number:</div>
			</td>
			<td class="fw-bolder text-end">
				N/A
			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">ID Matrix Status:</div>
			</td>
			<td class="fw-bolder text-end">
				Disabled
			</td>
		</tr>`;
            }
            break;
        case 'Medicare Card':
            html += ` <tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Medicare Card Number:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_medi_card_num">

			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Reference Number:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_medi_ref_num">

			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Middle Name On Card:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_medi_card_middle_name">

			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Card Color:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_medi_card_color">

			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">Identification Expiry Date:</div>
			</td>
			<td class="fw-bolder text-end `+ key + `_medi_card_ident_expiry">

			</td>
		</tr>`;
            if (verticalId == 1) {
                html += `
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">ID Matrix Reference Number:</div>
			</td>
			<td class="fw-bolder text-end">
				N/A
			</td>
		</tr>
		<tr>
			<td class="text-muted">
				<div class="d-flex align-items-center">ID Matrix Status:</div>
			</td>
			<td class="fw-bolder text-end">
				Disabled
			</td>
		</tr>`;
            }
            break;



    }
    $('#table_' + key).append(html);
}
$(document).on("click", "#sale_csv_select_submit", function (e) {
    var checkbox_length = $(".sale_listing_export:checked").length;
    if (checkbox_length) {
        var checked = [];
        $(".sale_listing_export:checked").each(function () {
            checked[$(this).val()] = $(this).val();
        });
        export_csv(checked, 'Sale');
        $(".sale_listing_export").prop('checked', false);
        $('.chk_boxes').prop('checked', false);
        $('.sale_info_chk_all_boxes').prop('checked', false);
        $('#csv_select').modal('toggle');
        return false;
    } else {
        toastr.error("Please select at-least one field");
    }
});

$(document).on("click", "#lead_csv_select_submit", function (e) {
    var checkbox_length = $(".lead_listing_export:checked").length;
    if (checkbox_length) {
        var checked = [];
        $(".lead_listing_export:checked").each(function () {
            checked[$(this).val()] = $(this).val();
        });
        export_csv(checked, 'Lead');
        $(".lead_listing_export").prop('checked', false);
        $('.chk_boxes').prop('checked', false);
        $('.lead_info_chk_all_boxes').prop('checked', false);
        $('#csv_select').modal('toggle');
        return false;
    } else {
        toastr.error("Please select at-least one field");
    }
});

$(document).on("click", "#sale_csv_select_submit_2", function (e) {
    var checkbox_length = $(".sale_listing_export_2:checked").length;
    if (checkbox_length) {
        var checked = [];
        $(".sale_listing_export_2:checked").each(function () {
            checked[$(this).val()] = $(this).val();
        });
        export_csv(checked, 'Sale');
        $(".sale_listing_export_2").prop('checked', false);
        $('.chk_boxes').prop('checked', false);
        $('.sale_info_chk_all_boxes_2').prop('checked', false);
        $('#csv_select').modal('toggle');
        return false;
    } else {
        toastr.error("Please select at-least one field");
    }
});

$(document).on("click", "#lead_csv_select_submit_2", function (e) {
    var checkbox_length = $(".lead_listing_export_2:checked").length;
    if (checkbox_length) {
        var checked = [];
        $(".lead_listing_export_2:checked").each(function () {
            checked[$(this).val()] = $(this).val();
        });
        export_csv(checked, 'Lead');
        $(".lead_listing_export_2").prop('checked', false);
        $('.chk_boxes').prop('checked', false);
        $('.lead_info_chk_all_boxes_2').prop('checked', false);
        $('#csv_select').modal('toggle');
        return false;
    } else {
        toastr.error("Please select at-least one field");
    }
});

function export_csv(url, saleType) {
    if (saleType == 'Sale') {
        var filter_data = $("form[name=export_sales]").serialize();
    }
    else {
        var filter_data = $("form[name=export_leads]").serialize();
    }
    var filter_form_data = $("form[name=filter_leads]").serialize();
    var updated_filter_data = filter_data.concat(filter_form_data);
    axios.post('/sales/generate-lead-csv', updated_filter_data)
        .then(response => {
            $('.export_modal').modal('hide');
            toastr.success(response.data.message);
            location.href = response.data.url;

        }).catch(err => {
            toastr.error(err.response.data.message)
        });
}

$("#qa_notes_created_date").daterangepicker({
    autoApply: true,
    autoUpdateInput: false,
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    },

});
$(".joint_access_dob").daterangepicker({
    autoApply: true,
    autoUpdateInput: false,
    singleDatePicker: true,
    locale: {
        format: 'YYYY-MM-DD'
    },

});

$('#qa_notes_created_date').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

$('.joint_access_dob').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

$(document).on('submit', '#joint_access_edit_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('form_name', 'joint_access_edit_form');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update Joint account information!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/customer/joint-account-update';
            axios.post(url, formData)
                .then(function (response) {
                    if (response.data.status == 200) {
                        $('.error').html('');
                        $(".joint_acc_info_name").html(
                            response.data.data[0].joint_acc_holder_title + " " + response.data.data[0].joint_acc_holder_first_name + " " + response.data.data[0].joint_acc_holder_last_name
                        );
                        $('.joint_acc_info_email').html(response.data.data[0].joint_acc_holder_email);
                        $('.joint_acc_holder').html(response.data.data[0].is_connection_joint_account_holder == 1 ? 'Yes' : 'No');
                        $('.joint_acc_info_phone').html(response.data.data[0].joint_acc_holder_phone_no);
                        $('.joint_acc_info_home_phone').html(response.data.data[0].joint_acc_holder_home_phone_no);
                        $('.joint_acc_info_ofc_phone').html(response.data.data[0].joint_acc_holder_office_phone_no);
                        $('.joint_acc_info_doc').html(response.data.data[0].joint_acc_holder_dob);

                        toastr.success(response.data.message);


                    } else {
                        toastr.error(response.data.message);
                    }
                    $('.comment').val('');
                    $('#joint_access_edit').hide();
                    $('#joint_access_show').show();
                    // console.log(response);
                    // toastr.success("Comment added successfully");
                    // console.log(response.data.data.length);
                }).catch(function (error) {

                    if (error.response.status == 422) {
                        $(".error").html("");
                        var inc = 1;
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            if (inc == 1) {
                                $('[name="' + key + '"]').focus();
                                inc++;
                            }
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            // $('#'+formId+' .'+key+'-error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                    }
                    toastr.error("Please check errors");

                });
        }
    });
});
$(document).on('submit', '#id_document_form', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('form_name', 'id_document_form');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to save uploaded documents!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(function (result) {
        if (result.isConfirmed) {
            var url = '/sales/sale-detail/update-id-document';
            loaderInstance.show();
            axios.post(url, formData)
                .then(function (response) {
                    if (response.data.status == true) {
                        loaderInstance.hide();
                        $(".error").html("");
                        toastr.success(response.data.message);
                        $('#id_document_edit').hide();
                        $('#id_document_show').show();
                        response.data.data.forEach(element => {
                            $('input[name=visitorDocumentId]').val(element.id);
                            $('.id_document_td').html(`<a href="${element.path}" target="_blank" >${element.file_name}</a>`);
                        });
                    }
                }).catch(function (error) {
                    loaderInstance.hide();
                    $(".error").html("");
                    if (error.response.status == 422) {
                        errors = error.response.data.errors;
                        $.each(errors, function (key, value) {
                            $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                        toastr.error('Please Check Errors');
                    }
                    else if (error.response.status == 400) {
                        toastr.error(error.response.message);
                    }
                    return false;
                });
        }
    });

});

function set_unit_code_val(unit_type, unit_type_id) {
    if (unit_type == '72')
        $('#' + unit_type_id).val('ANT').trigger('change');

    else if (unit_type == '73')
        $('#' + unit_type_id).val('APT').trigger('change');

    else if (unit_type == '74')
        $('#' + unit_type_id).val('ATM').trigger('change');

    else if (unit_type == '75')
        $('#' + unit_type_id).val('BBQ').trigger('change');

    else if (unit_type == '76')
        $('#' + unit_type_id).val('BLCK').trigger('change');

    else if (unit_type == '79')
        $('#' + unit_type_id).val('BTSD').trigger('change');

    else if (unit_type == '77')
        $('#' + unit_type_id).val('BLDG').trigger('change');

    else if (unit_type == '78')
        $('#' + unit_type_id).val('BNGW').trigger('change');

    else if (unit_type == '80')
        $('#' + unit_type_id).val('CAGE').trigger('change');

    else if (unit_type == '81')
        $('#' + unit_type_id).val('CARP').trigger('change');

    else if (unit_type == '82')
        $('#' + unit_type_id).val('CARS').trigger('change');

    else if (unit_type == '84')
        $('#' + unit_type_id).val('CLUB').trigger('change');

    else if (unit_type == '85')
        $('#' + unit_type_id).val('COOL').trigger('change');

    else if (unit_type == '86')
        $('#' + unit_type_id).val('CTGE').trigger('change');

    else if (unit_type == '87')
        $('#' + unit_type_id).val('DUP').trigger('change');

    else if (unit_type == '89')
        $('#' + unit_type_id).val('FY').trigger('change');

    else if (unit_type == '88')
        $('#' + unit_type_id).val('F').trigger('change');

    else if (unit_type == '90')
        $('#' + unit_type_id).val('GRGE').trigger('change');

    else if (unit_type == '91')
        $('#' + unit_type_id).val('HALL').trigger('change');

    else if (unit_type == '92')
        $('#' + unit_type_id).val('HSE').trigger('change');

    else if (unit_type == '83')
        $('#' + unit_type_id).val('KSK').trigger('change');

    else if (unit_type == '96')
        $('#' + unit_type_id).val('LSE').trigger('change');

    else if (unit_type == '93')
        $('#' + unit_type_id).val('LBBY').trigger('change');

    else if (unit_type == '94')
        $('#' + unit_type_id).val('LOFT').trigger('change');

    else if (unit_type == '95')
        $('#' + unit_type_id).val('LOT').trigger('change');

    else if (unit_type == '98')
        $('#' + unit_type_id).val('MSNT').trigger('change');

    else if (unit_type == '97')
        $('#' + unit_type_id).val('MB').trigger('change');

    else if (unit_type == '99')
        $('#' + unit_type_id).val('OFF').trigger('change');

    else if (unit_type == '100')
        $('#' + unit_type_id).val('PTHS').trigger('change');

    else if (unit_type == '101')
        $('#' + unit_type_id).val('REAR').trigger('change');

    else if (unit_type == '102')
        $('#' + unit_type_id).val('RES').trigger('change');

    else if (unit_type == '103')
        $('#' + unit_type_id).val('RESV').trigger('change');

    else if (unit_type == '104')
        $('#' + unit_type_id).val('RM').trigger('change');

    else if (unit_type == '105')
        $('#' + unit_type_id).val('SE').trigger('change');

    else if (unit_type == '106')
        $('#' + unit_type_id).val('SHED').trigger('change');

    else if (unit_type == '107')
        $('#' + unit_type_id).val('SHOP').trigger('change');

    else if (unit_type == '108')
        $('#' + unit_type_id).val('SHRM').trigger('change');

    else if (unit_type == '109')
        $('#' + unit_type_id).val('SIGN').trigger('change');

    else if (unit_type == '110')
        $('#' + unit_type_id).val('SITE').trigger('change');

    else if (unit_type == '111')
        $('#' + unit_type_id).val('SL').trigger('change');

    else if (unit_type == '112')
        $('#' + unit_type_id).val('STOR').trigger('change');

    else if (unit_type == '113')
        $('#' + unit_type_id).val('STR').trigger('change');

    else if (unit_type == '114')
        $('#' + unit_type_id).val('STU').trigger('change');

    else if (unit_type == '115')
        $('#' + unit_type_id).val('SUBS').trigger('change');

    else if (unit_type == 'SUITE')
        $('#' + unit_type_id).val('SUITE').trigger('change');

    else if (unit_type == '116')
        $('#' + unit_type_id).val('TNCY').trigger('change');

    else if (unit_type == '119')
        $('#' + unit_type_id).val('TWR').trigger('change');

    else if (unit_type == '118')
        $('#' + unit_type_id).val('TNHS').trigger('change');

    else if (unit_type == '120')
        $('#' + unit_type_id).val('U').trigger('change');

    else if (unit_type == '122')
        $('#' + unit_type_id).val('VLT').trigger('change');

    else if (unit_type == '121')
        $('#' + unit_type_id).val('VLLA').trigger('change');

    else if (unit_type == '123')
        $('#' + unit_type_id).val('WARD').trigger('change');

    else if (unit_type == '124')
        $('#' + unit_type_id).val('WE').trigger('change');

    else if (unit_type == '117')
        $('#' + unit_type_id).val('WKSH').trigger('change');

}


$(document).on('change', '#unit_type', function () {
    set_unit_code_val($(this).val(), 'unit_type_code');

});


$(document).on('change', '#gas_unit_type', function () {
    set_unit_code_val($(this).val(), "gas_unit_type_code");
});


$(document).on('change', '#billing_unit_type', function () {
    set_unit_code_val($(this).val(), "billing_unit_type_code");
});

$(document).on('click', '.show_history', function (e) {
    e.preventDefault();
    $('#' + $(this).data('initial')).hide();
    $('#' + $(this).data('for')).show();
    var history_section = ($(this)).data('section')
    if (history_section == 'customer_info') {
        var visitor_id = ($(this)).data('visitor_id')
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + visitor_id)
            .then(function (response) {
                $('#customer_info_body').html('');
                var i = 0;
                var customer_info_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.customer_info.length > 0) {
                    response.data.customer_info.forEach(element => {
                        customer_info_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="customer_info_history" data-updated_data='{"title":"${element.title}","first_name":"${element.first_name}","middle_name":"${element.middle_name}","last_name":"${element.last_name}","email":"${element.email}","phone":"${element.phone}","alternate_phone":"${element.alternate_phone}","dob":"${element.dob}"}' data-bs-toggle="modal"
                 data-bs-target="#show_customer_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#customer_info_body').append(customer_info_html);
                    });
                }
                else {
                    $('#customer_info_body').append(customer_info_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'manual_connection_address') {
        var address_id = $('input[name=manualAddressId]').val() ? $('input[name=manualAddressId]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + address_id)
            .then(function (response) {
                $('#manual_address_body').html('');
                var i = 0;
                var manual_address_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.manual_address.length > 0) {
                    response.data.manual_address.forEach(element => {
                        manual_address_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comments ? element.comments : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="manual_address_history" data-updated_data='{"address":"${element.manual_connection_details}"}' data-bs-toggle="modal"
                 data-bs-target="#show_manual_address_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#manual_address_body').append(manual_address_html);
                    });
                }
                else {
                    $('#manual_address_body').append(manual_address_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'connection_address') {
        var address_id = $('input[name=connectionAddressId]').val() ? $('input[name=connectionAddressId]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + address_id)
            .then(function (response) {
                $('#connection_address_body').html('');
                var i = 0;
                var connection_address_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.connection_address.length > 0) {
                    response.data.connection_address.forEach(element => {
                        connection_address_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comments ? element.comments : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="connection_address_history" data-updated_data='{"address":"${element.address}","lot_number":"${element.lot_number}","unit_number":"${element.unit_number}","unit_type":"${element.unit_type}","unit_type_code":"${element.unit_type_code}","floor_number":"${element.floor_number}","floor_level_type":"${element.floor_level_type}","floor_type_code":"${element.floor_type_code}","street_name":"${element.street_name}","street_code":"${element.street_code}","street_number":"${element.street_number}","street_suffix":"${element.street_suffix}","house_number":"${element.house_number}","house_number_suffix":"${element.house_number_suffix}","suburb":"${element.suburb}","state":"${element.state}","postcode":"${element.postcode}","property_name":"${element.property_name}","property_ownership":"${element.property_ownership}","site_descriptor":"${element.site_descriptor}","is_qas_valid":"${element.is_qas_valid}","validate_address":"${element.validate_address}","dpid":"${element.dpid}"}' data-bs-toggle="modal"
                 data-bs-target="#show_connection_address_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#connection_address_body').append(connection_address_html);
                    });
                }
                else {
                    $('#connection_address_body').append(connection_address_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'billing_address') {
        var address_id = $('input[name=billingAddressId]').val() ? $('input[name=billingAddressId]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + address_id)
            .then(function (response) {
                $('#billing_address_history_body').html('');
                var i = 0;
                var billing_address_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.billing_address.length > 0) {
                    response.data.billing_address.forEach(element => {
                        billing_address_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comments ? element.comments : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="billing_address_history" data-updated_data='{"address":"${element.address}","lot_number":"${element.lot_number}","unit_number":"${element.unit_number}","unit_type":"${element.unit_type}","unit_type_code":"${element.unit_type_code}","floor_number":"${element.floor_number}","floor_level_type":"${element.floor_level_type}","floor_type_code":"${element.floor_type_code}","street_name":"${element.street_name}","street_code":"${element.street_code}","street_number":"${element.street_number}","street_suffix":"${element.street_suffix}","house_number":"${element.house_number}","house_number_suffix":"${element.house_number_suffix}","suburb":"${element.suburb}","state":"${element.state}","postcode":"${element.postcode}","property_name":"${element.property_name}","property_ownership":"${element.property_ownership}","site_descriptor":"${element.site_descriptor}","is_qas_valid":"${element.is_qas_valid}","validate_address":"${element.validate_address}","dpid":"${element.dpid}","billing_preference":"${element.billing_preference}","email_welcome_pack":"${element.email_welcome_pack}"}' data-bs-toggle="modal"
                 data-bs-target="#show_billing_address_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#billing_address_history_body').append(billing_address_html);
                    });
                }
                else {
                    $('#billing_address_history_body').append(billing_address_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'delivery_address') {
        var address_id = $('input[name=deliveryAddressId]').val() ? $('input[name=deliveryAddressId]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + address_id)
            .then(function (response) {
                $('#delivery_address_history_body').html('');
                var i = 0;
                var delivery_address_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.delivery_address.length > 0) {
                    response.data.delivery_address.forEach(element => {
                        delivery_address_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comments ? element.comments : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="delivery_address_history" data-updated_data='{"address":"${element.address}","lot_number":"${element.lot_number}","unit_number":"${element.unit_number}","unit_type":"${element.unit_type}","unit_type_code":"${element.unit_type_code}","floor_number":"${element.floor_number}","floor_level_type":"${element.floor_level_type}","floor_type_code":"${element.floor_type_code}","street_name":"${element.street_name}","street_code":"${element.street_code}","street_number":"${element.street_number}","street_suffix":"${element.street_suffix}","house_number":"${element.house_number}","house_number_suffix":"${element.house_number_suffix}","suburb":"${element.suburb}","state":"${element.state}","postcode":"${element.postcode}","property_name":"${element.property_name}","property_ownership":"${element.property_ownership}","site_descriptor":"${element.site_descriptor}","is_qas_valid":"${element.is_qas_valid}","validate_address":"${element.validate_address}","dpid":"${element.dpid}","delivery_preference":"${element.billing_preference}"}' data-bs-toggle="modal"
                 data-bs-target="#show_delivery_address_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#delivery_address_history_body').append(delivery_address_html);
                    });
                }
                else {
                    $('#delivery_address_history_body').append(delivery_address_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'gas_address') {
        var address_id = $('input[name=gasConnectionAddressId]').val() ? $('input[name=gasConnectionAddressId]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + address_id)
            .then(function (response) {
                $('#gas_address_body').html('');
                var i = 0;
                var gas_address_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.gas_address.length > 0) {
                    response.data.gas_address.forEach(element => {
                        gas_address_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comments ? element.comments : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="gas_address_history" data-updated_data='{"address":"${element.address}","lot_number":"${element.lot_number}","unit_number":"${element.unit_number}","unit_type":"${element.unit_type}","unit_type_code":"${element.unit_type_code}","floor_number":"${element.floor_number}","floor_level_type":"${element.floor_level_type}","floor_type_code":"${element.floor_type_code}","street_name":"${element.street_name}","street_code":"${element.street_code}","street_number":"${element.street_number}","street_suffix":"${element.street_suffix}","house_number":"${element.house_number}","house_number_suffix":"${element.house_number_suffix}","suburb":"${element.suburb}","state":"${element.state}","postcode":"${element.postcode}","property_name":"${element.property_name}","property_ownership":"${element.property_ownership}","site_descriptor":"${element.site_descriptor}","is_qas_valid":"${element.is_qas_valid}","validate_address":"${element.validate_address}","dpid":"${element.dpid}","is_same_gas_connection":"${element.is_same_gas_connection}"}' data-bs-toggle="modal"
                 data-bs-target="#show_gas_connection_address_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#gas_address_body').append(gas_address_html);
                    });
                }
                else {
                    $('#gas_address_body').append(gas_address_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'pobox_address') {
        var address_id = $('input[name=poBoxAddressId]').val() ? $('input[name=poBoxAddressId]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + address_id)
            .then(function (response) {
                $('#pobox_address_body').html('');
                var i = 0;
                var pobox_address_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.pobox_address.length > 0) {
                    response.data.pobox_address.forEach(element => {
                        pobox_address_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comments ? element.comments : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="pobox_address_history" data-updated_data='{"po_box":"${element.po_box}","state":"${element.state}","postcode":"${element.postcode}","suburb":"${element.suburb}","is_qas_valid":"${element.is_qas_valid}","validate_address":"${element.validate_address}","dpid":"${element.dpid}"}' data-bs-toggle="modal"
                 data-bs-target="#show_pobox_address_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#pobox_address_body').append(pobox_address_html);
                    });
                }
                else {
                    $('#pobox_address_body').append(pobox_address_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'qa_section') {
        var verticalId = ($(this)).data('vertical_id')
        var leadId = ($(this)).data('lead_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + leadId)
            .then(function (response) {
                $('#qa_section_body').html('');
                var i = 0;
                var qa_section_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.qa_section.length > 0) {
                    response.data.qa_section.forEach(element => {
                        qa_section_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="qa_section_history" data-updated_data='{"qa_comment":"${element.qa_comment}","sale_comment":"${element.sale_comment}","rework_comment":"${element.rework_comment}","assigned_agent":"${element.assigned_agent}","sale_completed_by":"${element.sale_completed_by}"}' data-bs-toggle="modal"
                 data-bs-target="#show_qa_section_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#qa_section_body').append(qa_section_html);
                    });
                }
                else {
                    $('#qa_section_body').append(qa_section_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'concession_detail') {
        var verticalId = ($(this)).data('vertical_id')
        var visitorId = ($(this)).data('visitor_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + visitorId)
            .then(function (response) {
                $('#concession_detail_body').html('');
                var i = 0;
                var concession_detail_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.concession_detail.length > 0) {
                    response.data.concession_detail.forEach(element => {
                        concession_detail_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="concession_detail_history" data-updated_data='{"concession_type":"${element.concession_type}","concession_code":"${element.concession_code}","card_number":"${element.card_number}","card_start_date":"${element.card_start_date}","card_expiry_date":"${element.card_expiry_date}"}' data-bs-toggle="modal"
                 data-bs-target="#show_concession_detail_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#concession_detail_body').append(concession_detail_html);
                    });
                }
                else {
                    $('#concession_detail_body').append(concession_detail_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'identification_detail') {
        var verticalId = ($(this)).data('vertical_id')
        var leadId = ($(this)).data('lead_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + leadId)
            .then(function (response) {
                $('#identification_detail_body').html('');
                var i = 0;
                var identification_detail_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.identification_detail.length > 0) {
                    response.data.identification_detail.forEach(element => {
                        identification_detail_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="identification_detail_history" data-updated_data='{"identification_type":"${element.identification_type}","licence_state_code":"${element.licence_state_code}","licence_number":"${element.licence_number}","licence_expiry_date":"${element.licence_expiry_date}","passport_number":"${element.passport_number}","passport_expiry_date":"${element.passport_expiry_date}","foreign_passport_number":"${element.foreign_passport_number}","foreign_passport_expiry_date":"${element.foreign_passport_expiry_date}","medicare_number":"${element.medicare_number}","reference_number":"${element.reference_number}","card_color":"${element.card_color}","medicare_card_expiry_date":"${element.medicare_card_expiry_date}","foreign_country_name":"${element.foreign_country_name}","foreign_country_code":"${element.foreign_country_code}","card_middle_name":"${element.card_middle_name}","identification_option":"${element.identification_option}","identification_content":"${element.identification_content}"}' data-bs-toggle="modal"
                 data-bs-target="#show_identification_detail_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#identification_detail_body').append(identification_detail_html);
                    });
                }
                else {
                    $('#identification_detail_body').append(identification_detail_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'other_info') {
        var verticalId = ($(this)).data('vertical_id')
        var leadId = ($(this)).data('lead_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + leadId)
            .then(function (response) {
                $('#other_info_body').html('');
                var i = 0;
                var other_info_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.other_info.length > 0) {
                    response.data.other_info.forEach(element => {
                        other_info_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="other_info_history" data-updated_data='{"token":"${element.token}","qa_notes":"${element.qa_notes}","qa_notes_created_date":"${element.qa_notes_created_date}","life_support_notes":"${element.life_support_notes}","pin_number":"${element.pin_number}","retailers_resubmission_comment":"${element.retailers_resubmission_comment}","sale_agent":"${element.sale_agent}","simply_reward_id":"${element.simply_reward_id}"}' data-bs-toggle="modal"
                 data-bs-target="#show_other_info_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#other_info_body').append(other_info_html);
                    });
                }
                else {
                    $('#other_info_body').append(other_info_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'site_access') {
        var visitor_id = $('input[name=visitor_info_energy_id]').val() ? $('input[name=visitor_info_energy_id]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + visitor_id)
            .then(function (response) {
                $('#site_access_body').html('');
                var i = 0;
                var site_access_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.site_access.length > 0) {
                    response.data.site_access.forEach(element => {
                        site_access_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="site_access_history" data-updated_data='{"meter_hazard":"${element.meter_hazard}","dog_code":"${element.dog_code}","site_access_electricity":"${element.site_access_electricity}","site_access_gas":"${element.site_access_gas}"}' data-bs-toggle="modal"
                 data-bs-target="#show_site_access_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#site_access_body').append(site_access_html);
                    });
                }
                else {
                    $('#site_access_body').append(site_access_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'joint_account') {
        var visitor_id = $('input[name=jointAccountId]').val() ? $('input[name=jointAccountId]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + visitor_id)
            .then(function (response) {
                $('#joint_account_body').html('');
                var i = 0;
                var joint_account_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.joint_account.length > 0) {
                    response.data.joint_account.forEach(element => {
                        joint_account_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="joint_account_history" data-updated_data='{"joint_acc_holder_title":"${element.joint_acc_holder_title}","joint_acc_holder_first_name":"${element.joint_acc_holder_first_name}","joint_acc_holder_last_name":"${element.joint_acc_holder_last_name}","joint_acc_holder_email":"${element.joint_acc_holder_email}","joint_acc_holder_phone_no":"${element.joint_acc_holder_phone_no}","joint_acc_holder_home_phone_no":"${element.joint_acc_holder_home_phone_no}","joint_acc_holder_office_phone_no":"${element.joint_acc_holder_office_phone_no}","joint_acc_holder_dob":"${element.joint_acc_holder_dob}","is_connection_joint_account_holder":"${element.is_connection_joint_account_holder}"}' data-bs-toggle="modal"
                 data-bs-target="#show_joint_account_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#joint_account_body').append(joint_account_html);
                    });
                }
                else {
                    $('#joint_account_body').append(joint_account_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'nmi_number') {
        var visitor_id = $('input[name=visitor_info_energy_id]').val() ? $('input[name=visitor_info_energy_id]').val() : null;
        var verticalId = ($(this)).data('vertical_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + visitor_id)
            .then(function (response) {
                $('#nmi_number_body').html('');
                var i = 0;
                var nmi_number_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.nmi_number.length > 0) {
                    response.data.nmi_number.forEach(element => {
                        nmi_number_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="nmi_number_history" data-updated_data='{"nmi_number":"${element.nmi_number}","nmi_skip":"${element.nmi_skip}","dpi_mirn_number":"${element.dpi_mirn_number}","mirn_skip":"${element.mirn_skip}","tariff_type":"${element.tariff_type}","tariff_list":"${element.tariff_list}","meter_number_e":"${element.meter_number_e}","electricity_network_code":"${element.electricity_network_code}","electricity_code":"${element.electricity_code}","meter_number_g":"${element.meter_number_g}","meter_number_g":"${element.meter_number_g}","gas_network_code":"${element.gas_network_code}","gas_code":"${element.gas_code}"}' data-bs-toggle="modal"
                 data-bs-target="#show_nmi_number_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#nmi_number_body').append(nmi_number_html);
                    });
                }
                else {
                    $('#nmi_number_body').append(nmi_number_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'demand_details') {
        var verticalId = ($(this)).data('vertical_id')
        var leadId = ($(this)).data('lead_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + leadId)
            .then(function (response) {
                $('#demand_details_body').html('');
                var i = 0;
                var demand_details_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.demand_details.length > 0) {
                    response.data.demand_details.forEach(element => {
                        demand_details_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="demand_details_history" data-updated_data='{"demand_usage_type":"${element.demand_usage_type}","demand_tariff_code":"${element.demand_tariff_code}","demand_tariff":"${element.demand_tariff}","demand_meter_type":"${element.demand_meter_type}","demand_rate1_peak_usage":"${element.demand_rate1_peak_usage}","demand_rate1_off_peak_usage":"${element.demand_rate1_off_peak_usage}","demand_rate1_shoulder_usage":"${element.demand_rate1_shoulder_usage}","demand_rate1_days":"${element.demand_rate1_days}","demand_rate2_peak_usage":"${element.demand_rate2_peak_usage}","demand_rate2_off_peak_usage":"${element.demand_rate2_off_peak_usage}","demand_rate2_shoulder_usage":"${element.demand_rate2_shoulder_usage}","demand_rate2_days":"${element.demand_rate2_days}","demand_rate3_peak_usage":"${element.demand_rate3_peak_usage}","demand_rate3_off_peak_usage":"${element.demand_rate3_off_peak_usage}","demand_rate3_shoulder_usage":"${element.demand_rate3_shoulder_usage}","demand_rate3_days":"${element.demand_rate3_days}","demand_rate4_peak_usage":"${element.demand_rate4_peak_usage}","demand_rate4_off_peak_usage":"${element.demand_rate4_off_peak_usage}","demand_rate4_shoulder_usage":"${element.demand_rate4_shoulder_usage}","demand_rate4_days":"${element.demand_rate4_days}"}' data-bs-toggle="modal"
                 data-bs-target="#show_demand_details_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#demand_details_body').append(demand_details_html);
                    });
                }
                else {
                    $('#demand_details_body').append(demand_details_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'customer_note') {
        var verticalId = ($(this)).data('vertical_id')
        var leadId = ($(this)).data('lead_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + leadId)
            .then(function (response) {
                $('#customer_note_body').html('');
                var i = 0;
                var customer_note_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.customer_note.length > 0) {
                    response.data.customer_note.forEach(element => {
                        customer_note_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comment ? element.comment : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="customer_note_history" data-updated_data='{"elec_note":"${element.electricity_note}","gas_note":"${element.gas_note}","note":"${element.note}"}' data-bs-toggle="modal"
                 data-bs-target="#show_customer_note_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#customer_note_body').append(customer_note_html);
                    });
                }
                else {
                    $('#customer_note_body').append(customer_note_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
    if (history_section == 'journey') {
        var verticalId = ($(this)).data('vertical_id')
        var leadId = ($(this)).data('lead_id')
        axios.get('/sales/get-sale-update-history/' + verticalId + '/' + history_section + '/' + leadId)
            .then(function (response) {
                $('#journey_body').html('');
                var i = 0;
                var journey_html = `
					<tr>
						<td valign="top" colspan="6" class="text-center">There are no records to show</td>
					</tr>`;
                if (response.data.journey.length > 0) {
                    response.data.journey.forEach(element => {
                        journey_html = `
                 <tr>
                 <td class="fw-bolder">${++i}</td>
                 <td class="fw-bolder text-capitalize">${element.user_name}</td>
                 <td class="fw-bolder text-capitalize">${element.user_role}</td>
                 <td class="fw-bolder">${element.comments ? element.comments : 'N/A'}</td>
                 <td class="fw-bolder">${element.created_at}</td>
                 <td class="fw-bolder text-center"><a href="javascript:void(0);" class ="show_history" data-section ="journey_history" data-updated_data='{"control_load_one_off_peak":"${element.control_load_one_off_peak}","control_load_one_shoulder":"${element.control_load_one_shoulder}","control_load_two_off_peak":"${element.control_load_two_off_peak}","control_load_two_shoulder":"${element.control_load_two_shoulder}","credit_score":"${element.credit_score}","electricity_distributor_name":"${element.electricity_distributor_name}","electricity_meter_type_code":"${element.electricity_meter_type_code}","gas_meter_type_code":"${element.gas_meter_type_code}","electricity_moving_date":"${element.electricity_moving_date}","electricity_provider_name":"${element.electricity_provider_name}","gas_distributor_name":"${element.gas_distributor_name}","gas_moving_date":"${element.gas_moving_date}","gas_provider_name":"${element.gas_provider_name}","is_any_access_issue":"${element.is_any_access_issue}","is_dual":"${element.is_dual}","is_elec_work":"${element.is_elec_work}","life_support":"${element.life_support}","life_support_energy_type":"${element.life_support_energy_type}","life_support_value":"${element.life_support_value}","moving_house":"${element.moving_house}","prefered_move_in_time":"${element.prefered_move_in_time}","solar_options":"${element.solar_options}","solar_panel":"${element.solar_panel}"}' data-bs-toggle="modal"
                 data-bs-target="#show_journey_history_modal">
                 <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
             </a></td>
                 </tr>
                `;
                        $('#journey_body').append(journey_html);
                    });
                }
                else {
                    $('#journey_body').append(journey_html);
                }
            }).catch(err => {
                console.log(err);
                toastr.error('Whoops! something went wrong.');
            });
    }
})

$(document).on('click', '.show_history', function (e) {
    var section_name = $(this).data('section');
    var data = $(this).data('updated_data');
    if (section_name == 'customer_info_history') {
        $(".customer_history_title_td").text(data.title != 'null' ? data.title : 'N/A');
        $(".customer_history_f_name_td").text(data.first_name != 'null' ? data.first_name : 'N/A');
        $(".customer_history_m_name_td").text(data.middle_name != 'null' ? data.middle_name : 'N/A');
        $(".customer_history_l_name_td").text(data.last_name != 'null' ? data.last_name : 'N/A');
        $(".customer_history_email_td").text(data.email != 'null' ? data.email : 'N/A');
        $(".customer_history_phone_td").text(data.phone != 'null' ? data.phone : 'N/A');
        $(".customer_history_alt_phone_td").text(data.alternate_phone != 'null' ? data.alternate_phone : 'N/A');
        $(".customer_history_dob_td").text(data.dob != 'null' ? data.dob : 'N/A');
    }
    else if (section_name == 'manual_address_history') {
        $(".manual_address_td").text(data.address ? data.address : 'N/A');
    }
    else if (section_name == 'connection_address_history') {
        $('.connection-address-history-td').text(data.address != 'null' ? data.address : 'N/A');
        $('.connection-lot-number-history').text(data.lot_number != 'null' ? data.lot_number : 'N/A');
        $('.connection-unit-number-history').text(data.unit_number != 'null' ? data.unit_number : 'N/A');
        $('.connection-unit-type-history').text(data.unit_type != 'null' ? data.unit_type : 'N/A');
        $('.connection-unit-type-code-history').text(data.unit_type_code != 'null' ? data.unit_type_code : 'N/A');
        $('.connection-floor-number-history').text(data.floor_number != 'null' ? data.floor_number : 'N/A');
        $('.connection-floor-level-type-history').text(data.floor_level_type != 'null' ? data.floor_level_type : 'N/A');
        $('.connection-floor-type-code-history').text(data.floor_type_code != 'null' ? data.floor_type_code : 'N/A');
        $('.connection-street-name-history').text(data.street_name != 'null' ? data.street_name : 'N/A');
        $('.connection-street-number-history').text(data.street_number != 'null' ? data.street_number : 'N/A');
        $('.connection-street-suffix-history').text(data.street_suffix != 'null' ? data.street_suffix : 'N/A');
        $('.connection-street-code-history').text(data.street_code != 'null' ? data.street_code : 'N/A');
        $('.connection-house-number-history').text(data.house_number != 'null' ? data.house_number : 'N/A');
        $('.connection-house-number-suffix-history').text(data.house_number_suffix != 'null' ? data.house_number_suffix : 'N/A');
        $('.connection-suburb-history').text(data.suburb != 'null' ? data.suburb : 'N/A');
        $('.connection-property-name-history').text(data.property_name != 'null' ? data.property_name : 'N/A');
        $('.connection-state-history').text(data.state != 'null' ? data.state : 'N/A');
        $('.connection-postcode-history').text(data.postcode != 'null' ? data.postcode : 'N/A');
        $('.connection-site-location-history').text(data.site_descriptor != 'null' ? data.site_descriptor : 'N/A');
        $('.connection-property-ownership-history').text(data.property_ownership != 'null' ? data.property_ownership : 'N/A');
        $('.connection-dpid-history').text(data.dpid != 'null' ? data.dpid : 'N/A');
        $('.connection-qas-history').text(data.is_qas_valid == 1 ? 'Yes' : 'No');
        $('.connection-address-validation-history').text(data.validate_address == 1 ? 'Yes' : 'No');
    }
    else if (section_name == 'billing_address_history') {
        console.log(data)
        $('.email_welcome_pack_history').hide();
        $('#billing_address_history_table_body').hide();
        $('#billing_address_history_tr').hide();
        switch (data.billing_preference) {
            case ('1'):
                $('.billing_preference_history_td').text('Email')
                $('.email_welcome_pack_history').show();
                $('.email_welcome_pack_history_td').text(data.email_welcome_pack == 1 ? 'Yes' : 'No')
                break;
            case ('2'):
                $('.billing_preference_history_td').text('Connection')
                $('#billing_address_history_tr').show();
                $('.billing_connection_history_td').text(data.address != 'null' ? data.address : 'N/A');
                break;
            default:
                $('.billing_preference_history_td').text('Other')
        }
        if ((data.billing_preference == '1' && data.email_welcome_pack == '1') || data.billing_preference == '3') {
            $('#billing_address_history_table_body').show();
            $('.billing-address-history-td').text(data.address != 'null' ? data.address : 'N/A');
            $('.billing-lot-number-history').text(data.lot_number != 'null' ? data.lot_number : 'N/A');
            $('.billing-unit-number-history').text(data.unit_number != 'null' ? data.unit_number : 'N/A');
            $('.billing-unit-type-history').text(data.unit_type != 'null' ? data.unit_type : 'N/A');
            $('.billing-unit-type-code-history').text(data.unit_type_code != 'null' ? data.unit_type_code : 'N/A');
            $('.billing-floor-number-history').text(data.floor_number != 'null' ? data.floor_number : 'N/A');
            $('.billing-floor-level-type-history').text(data.floor_level_type != 'null' ? data.floor_level_type : 'N/A');
            $('.billing-floor-type-code-history').text(data.floor_type_code != 'null' ? data.floor_type_code : 'N/A');
            $('.billing-street-name-history').text(data.street_name != 'null' ? data.street_name : 'N/A');
            $('.billing-street-number-history').text(data.street_number != 'null' ? data.street_number : 'N/A');
            $('.billing-street-suffix-history').text(data.street_suffix != 'null' ? data.street_suffix : 'N/A');
            $('.billing-street-code-history').text(data.street_code != 'null' ? data.street_code : 'N/A');
            $('.billing-house-number-history').text(data.house_number != 'null' ? data.house_number : 'N/A');
            $('.billing-house-number-suffix-history').text(data.house_number_suffix != 'null' ? data.house_number_suffix : 'N/A');
            $('.billing-suburb-history').text(data.suburb != 'null' ? data.suburb : 'N/A');
            $('.billing-property-name-history').text(data.property_name != 'null' ? data.property_name : 'N/A');
            $('.billing-state-history').text(data.state != 'null' ? data.state : 'N/A');
            $('.billing-postcode-history').text(data.postcode != 'null' ? data.postcode : 'N/A');
            $('.billing-site-location-history').text(data.site_descriptor != 'null' ? data.site_descriptor : 'N/A');
            $('.billing-property-ownership-history').text(data.property_ownership != 'null' ? data.property_ownership : 'N/A');
            $('.billing-dpid-history').text(data.dpid != 'null' ? data.dpid : 'N/A');
            $('.billing-address-validation-history').text(data.validate_address == 1 ? 'Yes' : 'No');
        }
    }
    else if (section_name == 'delivery_address_history') {
        $('#delivery_address_history_table_body').hide();
        $('#delivery_address_history_tr').hide();
        switch (data.delivery_preference) {
            case ('1'):
                $('.delivery_preference_history_td').text('Connection')
                $('#delivery_address_history_tr').show();
                $('.delivery_connection_history_td').text(data.address != 'null' ? data.address : 'N/A');
                break;
            case ('2'):
                $('.delivery_preference_history_td').text('Other')
                break;
        }
        if (data.delivery_preference == '2') {
            $('#delivery_address_history_table_body').show();
            $('.delivery-address-history-td').text(data.address != 'null' ? data.address : 'N/A');
            $('.delivery-lot-number-history').text(data.lot_number != 'null' ? data.lot_number : 'N/A');
            $('.delivery-unit-number-history').text(data.unit_number != 'null' ? data.unit_number : 'N/A');
            $('.delivery-unit-type-history').text(data.unit_type != 'null' ? data.unit_type : 'N/A');
            $('.delivery-unit-type-code-history').text(data.unit_type_code != 'null' ? data.unit_type_code : 'N/A');
            $('.delivery-floor-number-history').text(data.floor_number != 'null' ? data.floor_number : 'N/A');
            $('.delivery-floor-level-type-history').text(data.floor_level_type != 'null' ? data.floor_level_type : 'N/A');
            $('.delivery-floor-type-code-history').text(data.floor_type_code != 'null' ? data.floor_type_code : 'N/A');
            $('.delivery-street-name-history').text(data.street_name != 'null' ? data.street_name : 'N/A');
            $('.delivery-street-number-history').text(data.street_number != 'null' ? data.street_number : 'N/A');
            $('.delivery-street-suffix-history').text(data.street_suffix != 'null' ? data.street_suffix : 'N/A');
            $('.delivery-street-code-history').text(data.street_code != 'null' ? data.street_code : 'N/A');
            $('.delivery-house-number-history').text(data.house_number != 'null' ? data.house_number : 'N/A');
            $('.delivery-house-number-suffix-history').text(data.house_number_suffix != 'null' ? data.house_number_suffix : 'N/A');
            $('.delivery-suburb-history').text(data.suburb != 'null' ? data.suburb : 'N/A');
            $('.delivery-property-name-history').text(data.property_name != 'null' ? data.property_name : 'N/A');
            $('.delivery-state-history').text(data.state != 'null' ? data.state : 'N/A');
            $('.delivery-postcode-history').text(data.postcode != 'null' ? data.postcode : 'N/A');
            $('.delivery-site-location-history').text(data.site_descriptor != 'null' ? data.site_descriptor : 'N/A');
            $('.delivery-property-ownership-history').text(data.property_ownership != 'null' ? data.property_ownership : 'N/A');
            $('.delivery-dpid-history').text(data.dpid != 'null' ? data.dpid : 'N/A');
            $('.delivery-address-validation-history').text(data.validate_address == 1 ? 'Yes' : 'No');
        }
    }
    else if (section_name == 'gas_address_history') {
        $('.gas_connection_history_td').text(data.is_same_gas_connection == 1 ? 'Yes' : 'No')
        $('.gas_connection-address-history-td').text(data.address != 'null' ? data.address : 'N/A');
        $('.gas_connection-lot-number-history').text(data.lot_number != 'null' ? data.lot_number : 'N/A');
        $('.gas_connection-unit-number-history').text(data.unit_number != 'null' ? data.unit_number : 'N/A');
        $('.gas_connection-unit-type-history').text(data.unit_type != 'null' ? data.unit_type : 'N/A');
        $('.gas_connection-unit-type-code-history').text(data.unit_type_code != 'null' ? data.unit_type_code : 'N/A');
        $('.gas_connection-floor-number-history').text(data.floor_number != 'null' ? data.floor_number : 'N/A');
        $('.gas_connection-floor-level-type-history').text(data.floor_level_type != 'null' ? data.floor_level_type : 'N/A');
        $('.gas_connection-floor-type-code-history').text(data.floor_type_code != 'null' ? data.floor_type_code : 'N/A');
        $('.gas_connection-street-name-history').text(data.street_name != 'null' ? data.street_name : 'N/A');
        $('.gas_connection-street-number-history').text(data.street_number != 'null' ? data.street_number : 'N/A');
        $('.gas_connection-street-suffix-history').text(data.street_suffix != 'null' ? data.street_suffix : 'N/A');
        $('.gas_connection-street-code-history').text(data.street_code != 'null' ? data.street_code : 'N/A');
        $('.gas_connection-house-number-history').text(data.house_number != 'null' ? data.house_number : 'N/A');
        $('.gas_connection-house-number-suffix-history').text(data.house_number_suffix != 'null' ? data.house_number_suffix : 'N/A');
        $('.gas_connection-suburb-history').text(data.suburb != 'null' ? data.suburb : 'N/A');
        $('.gas_connection-property-name-history').text(data.property_name != 'null' ? data.property_name : 'N/A');
        $('.gas_connection-state-history').text(data.state != 'null' ? data.state : 'N/A');
        $('.gas_connection-postcode-history').text(data.postcode != 'null' ? data.postcode : 'N/A');
        $('.gas_connection-site-location-history').text(data.site_descriptor != 'null' ? data.site_descriptor : 'N/A');
        $('.gas_connection-property-ownership-history').text(data.property_ownership != 'null' ? data.property_ownership : 'N/A');
        $('.gas_connection-dpid-history').text(data.dpid != 'null' ? data.dpid : 'N/A');
        $('.gas_connection-address-validation-history').text(data.validate_address == 1 ? 'Yes' : 'No');
    }
    else if (section_name == 'pobox_address_history') {
        if (data.po_box == 'null') {
            $('#pobox_row_history').show();
            $('#po_box_row_history').hide();
            $('#pobox_row_history').html(`<div class="col-md-4 m-auto fw-bolder text-gray-600">PO Box Address Disabled
</div>`);
        }
        else {
            $('#pobox_row_history').hide();
            $('#po_box_row_history').show();
        }
        $('.po-address-status-history').text(data.po_box == 'null' ? 'Disable' : 'Enable');
        $('.po-address-number-history').text(data.po_box != 'null' ? data.po_box : 'N/A');
        $('.po-address-suburb-history').text(data.suburb != 'null' ? data.suburb : 'N/A');
        $('.po-address-state-code-history').text(data.state != 'null' ? data.state : 'N/A');
        $('.po-address-postcode-history').text(data.postcode != 'null' ? data.postcode : 'N/A');
        $('.po-address-qas-history').text(data.is_qas_valid == 1 ? 'Yes' : 'No');
        $('.po-address-validate-address-history').text(data.validate_address == 1 ? 'Yes' : 'No');
        $('.po-address-dpid-history').text(data.dpid != 'null' ? data.dpid : 'N/A');
    }
    else if (section_name == 'qa_section_history') {
        let saleCompletedBy = data.sale_completed_by ? data.sale_completed_by : '';
        let saleCompletedName = '';
        if (saleCompletedBy == 1)
            saleCompletedName = "Customer";
        else if (saleCompletedBy == 2)
            saleCompletedName = "Agent";
        else if (saleCompletedBy == 3)
            saleCompletedName = "Agent Assisted";
        else
            saleCompletedName = "N/A";
        $(".qa_comment_history_td").text(data.qa_comment != 'null' ? data.qa_comment : 'N/A');
        $(".qa_sale_comment_history_td").text(data.sale_comment != 'null' ? data.sale_comment : 'N/A');
        $(".qa_rework_comment_history_td").text(data.rework_comment != 'null' ? data.rework_comment : 'N/A');
        $(".qa_assigned_agent_history_td").text(data.assigned_agent != 'null' ? data.assigned_agent : 'N/A');
        $(".qa_sale_completed_by_history_td").text(saleCompletedName);
    }
    else if (section_name == 'concession_detail_history') {
        $(".vcd_concession_type_history").text(
            data.concession_type ? data.concession_type : 'N/A'
        );
        $('.vcd_concession_code_history').text(data.concession_code != 'null' ? data.concession_code : 'N/A');
        $('.vcd_concession_card_number_history').text(data.card_number != 'null' ? data.card_number : 'N/A');
        $('.vcd_card_issue_date_history').text(data.card_start_date != 'null' ? data.card_start_date : 'N/A');
        $('.vcd_card_expiry_date_history').text(data.card_expiry_date != 'null' ? data.card_expiry_date : 'N/A');
    }
    else if (section_name == 'identification_detail_history') {
        $('.licence_body,.passport_body,.foreign_passport_body,.medicare_card_body').addClass('d-none');
        $('.identification_type_history').text(data.identification_option == 1 ? 'Primary Identification :' : 'Secondary Identification :');
        $('.identity_type_history').text(data.identification_type != 'null' ? data.identification_type : 'N/A');
        switch (data.identification_type) {
            case ('Drivers Licence'):
                $('.licence_body').removeClass('d-none');
                $('.lic_state_code_history').text(data.licence_state_code != 'null' ? data.licence_state_code : 'N/A')
                $('.lic_number_history').text(data.licence_number != 'null' ? data.licence_number : 'N/A')
                $('.lic_expiry_history').text(data.licence_expiry_date != 'null' ? data.licence_expiry_date : 'N/A')
                break;
            case ('Foreign Passport'):
                $('.foreign_passport_body').removeClass('d-none');
                $('.foreign_pass_number_history').text(data.foreign_passport_number != 'null' ? data.foreign_passport_number : 'N/A')
                $('.foreign_country_name_history').text(data.foreign_country_name != 'null' ? data.foreign_country_name : 'N/A')
                $('.foreign_country_code_history').text(data.foreign_country_code != 'null' ? data.foreign_country_code : 'N/A')
                $('.foreign_ident_expiry_date_history').text(data.foreign_passport_expiry_date != 'null' ? data.foreign_passport_expiry_date : 'N/A')
                break;
            case ('Passport'):
                $('.passport_body').removeClass('d-none');
                $('.passport_number_history').text(data.passport_number != 'null' ? data.passport_number : 'N/A')
                $('.passport_ident_expiry_history').text(data.passport_expiry_date != 'null' ? data.passport_expiry_date : 'N/A')
                break;
            case ('Medicare Card'):
                $('.medicare_card_body').removeClass('d-none');
                $('.medi_card_num_history').text(data.medicare_number != 'null' ? data.medicare_number : 'N/A')
                $('.medi_ref_num_history').text(data.reference_number != 'null' ? data.reference_number : 'N/A')
                $('.medi_card_middle_name_history').text(data.card_middle_name != 'null' ? data.card_middle_name : 'N/A')
                $('.medi_card_color_history').text(data.card_color != 'null' ? data.card_color : 'N/A')
                $('.medi_card_ident_expiry_history').text(data.medicare_card_expiry_date != 'null' ? data.medicare_card_expiry_date : 'N/A')
                break;
        }
    }
    else if (section_name == 'other_info_history') {
        $(".token_history_td").text(data.token != 'null' ? data.token : 'N/A');
        $(".qa_notes_history_td").text(data.qa_notes != 'null' ? data.qa_notes : 'N/A');
        $(".life_support_notes_history_td").text(data.life_support_notes != 'null' ? data.life_support_notes : 'N/A');
        $(".qa_notes_created_date_history_td").text(data.qa_notes_created_date != 'null' ? data.qa_notes_created_date : 'N/A');
        $(".retailors_resubmission_comment_history_td").text(data.retailers_resubmission_comment != 'null' ? data.retailers_resubmission_comment : 'N/A');
        $(".pin_number_history_td").text(data.pin_number != 'null' ? data.pin_number : 'N/A');
        $(".sale_agent_history_td").text(data.sale_agent != 'null' ? data.sale_agent : 'N/A');
        $(".simply_reward_id_history_td").text(data.simply_reward_id != 'null' ? data.simply_reward_id : 'N/A');
    }
    else if (section_name == 'site_access_history') {
        $('.vie_dog_code_history_td').text(data.dog_code != 'null' ? data.dog_code : 'N/A');
        $('.vie_site_access_gas_history_td').text(data.site_access_gas != 'null' ? data.site_access_gas : 'N/A');
        $('.vie_meter_hazard_history_td').text(data.meter_hazard != 'null' ? data.meter_hazard : 'N/A');
        $('.vie_site_access_electricity_history_td').text(data.site_access_electricity != 'null' ? data.site_access_electricity : 'N/A');
    }
    else if (section_name == 'joint_account_history') {
        $(".joint_acc_title_history").html(data.joint_acc_holder_title);
        $(".joint_acc_first_name_history").html(data.joint_acc_holder_first_name);
        $(".joint_acc_info_last_name_history").html(data.joint_acc_holder_last_name);
        $('.joint_acc_info_email_history').html(data.joint_acc_holder_email);
        $('.joint_acc_holder_history').html(data.is_connection_joint_account_holder == 1 ? 'Yes' : 'No');
        $('.joint_acc_info_phone_history').html(data.joint_acc_holder_phone_no);
        $('.joint_acc_info_home_phone_history').html(data.joint_acc_holder_home_phone_no);
        $('.joint_acc_info_ofc_phone_history').html(data.joint_acc_holder_office_phone_no);
        $('.joint_acc_info_doc_history').html(data.joint_acc_holder_dob);
    }
    else if (section_name == 'nmi_number_history') {
        $(".vie_nmi_number_history_td").text(data.nmi_number != 'null' ? data.nmi_number : 'N/A');
        $(".vie_nmi_skip_history_td").text(data.nmi_skip == 1 ? 'True' : 'False');
        $(".vie_dpi_mirn_number_history_td").text(data.dpi_mirn_number != 'null' ? data.dpi_mirn_number : 'N/A');
        $(".vie_mirn_skip_history_td").text(data.mirn_skip == 1 ? 'True' : 'False');
        $(".vie_tariff_type_history_td").text(data.tariff_type != 'null' ? data.tariff_type : 'N/A');
        $(".vie_tariff_list_history_td").text(data.tariff_list != 'null' ? data.tariff_list : 'N/A');
        $(".vie_meter_number_e_history_td").text(data.meter_number_e != 'null' ? data.meter_number_e : 'N/A');
        $(".vie_electricity_network_code_history_td").text(data.electricity_network_code != 'null' ? data.electricity_network_code : 'N/A');
        $(".vie_electricity_code_history_td").text(data.electricity_code != 'null' ? data.electricity_code : 'N/A');
        $(".vie_meter_number_g_history_td").text(data.meter_number_g != 'null' ? data.meter_number_g : 'N/A');
        $(".vie_gas_network_code_history_td").text(data.gas_network_code != 'null' ? data.gas_network_code : 'N/A');
        $(".vie_gas_code_history_td").text(data.gas_code ? data.gas_code != 'null' : 'N/A');
    }
    else if (section_name == 'demand_details_history') {
        $('#demand_details_enable_history').hide();
        $('#demand_details_disable_history').hide();
        if (data.demand_tariff == '1') {
            $('#demand_details_enable_history').show();
            $(".ebd_demand_usage_type_history_td").text(data.demand_usage_type == 2 ? 'kWH' : 'KVA');
            $(".ebd_demand_tariff_code_history_td").text(data.demand_tariff_code != 'null' ? data.demand_tariff_code : 'N/A');
            $(".ebd_demand_meter_type_history_td").text(data.demand_meter_type == 1 ? 'Single' : 'Time Of Use');
            $(".ebd_demand_rate1_peak_usage_history_td").text(data.demand_rate1_peak_usage != 'null' ? data.demand_rate1_peak_usage : 'N/A');
            $(".ebd_demand_rate1_off_peak_usage_history_td").text(data.demand_rate1_off_peak_usage != 'null' ? data.demand_rate1_off_peak_usage : 'N/A');
            $(".ebd_demand_rate1_shoulder_usage_history_td").text(data.demand_rate1_shoulder_usage != 'null' ? data.demand_rate1_shoulder_usage : 'N/A');
            $(".ebd_demand_rate1_days_history_td").text(data.demand_rate1_days != 'null' ? data.demand_rate1_days : 'N/A');
            $(".ebd_demand_rate2_peak_usage_history_td").text(data.demand_rate2_peak_usage != 'null' ? data.demand_rate2_peak_usage : 'N/A');
            $(".ebd_demand_rate2_off_peak_usage_history_td").text(data.demand_rate2_off_peak_usage != 'null' ? data.demand_rate2_off_peak_usage : 'N/A');
            $(".ebd_demand_rate2_shoulder_usage_history_td").text(data.demand_rate2_shoulder_usage != 'null' ? data.demand_rate2_shoulder_usage : 'N/A');
            $(".ebd_demand_rate2_days_history_td").text(data.demand_rate2_days != 'null' ? data.demand_rate2_days : 'N/A');
            $(".ebd_demand_rate3_peak_usage_history_td").text(data.demand_rate3_peak_usage != 'null' ? data.demand_rate3_peak_usage : 'N/A');
            $(".ebd_demand_rate3_off_peak_usage_history_td").text(data.demand_rate3_off_peak_usage != 'null' ? data.demand_rate3_off_peak_usage : 'N/A');
            $(".ebd_demand_rate3_shoulder_usage_history_td").text(data.demand_rate3_shoulder_usage != 'null' ? data.demand_rate3_shoulder_usage : 'N/A');
            $(".ebd_demand_rate3_days_history_td").text(data.demand_rate3_days != 'null' ? data.demand_rate3_days : 'N/A');
            $(".ebd_demand_rate4_peak_usage_history_td").text(data.demand_rate4_peak_usage != 'null' ? data.demand_rate4_peak_usage : 'N/A');
            $(".ebd_demand_rate4_off_peak_usage_history_td").text(data.demand_rate4_off_peak_usage != 'null' ? data.demand_rate4_off_peak_usage : 'N/A');
            $(".ebd_demand_rate4_shoulder_usage_history_td").text(data.demand_rate4_shoulder_usage != 'null' ? data.demand_rate4_shoulder_usage : 'N/A');
            $(".ebd_demand_rate4_days_history_td").text(data.demand_rate4_days != 'null' ? data.demand_rate4_days : 'N/A');
        }
        else {
            $('#demand_details_disable_history').show();
            $('#demand_details_disable_history').html(`<div class="col-md-4 m-auto fw-bolder text-gray-600">Demand Details Disabled
</div>`);
        }
    }
    else if (section_name == 'customer_note_history') {
        $('.electricityNote_history').text(data.elec_note != 'null' ? data.elec_note : 'N/A')
        $('.gasNote_history').text(data.gas_note != 'null' ? data.gas_note : 'N/A')
        $('.note_history').text(data.note != 'null' ? data.note : 'N/A')
    }
    else if (section_name == 'journey_history') {
        $('#life_support_equipment_div_history').hide();
        $('#life_support_fuel_div_history').hide();
        $('#control_load_one_off_peak_history').hide();
        $('#control_load_two_off_peak_history').hide();
        $('#control_load_two_shoulder_history').hide();
        $('#control_load_one_shoulder_history').hide();
        $('#elec_meter_type_code_history').hide();
        $('#gas_meter_type_code_history').hide();
        $('#elec_movin_div_history').hide();
        $('#gas_movin_div_history').hide();
        $(".life_support_history").text(data.life_support == 1 ? 'Yes' : 'No');
        if (data.life_support == 1) {
            $('#life_support_equipment_div_history').show();
            $('#life_support_fuel_div_history').show();
            switch (data.life_support_energy_type) {
                case ('1'):
                    $(".life_support_fuel_history").text('Electricity');
                    break;
                case ('2'):
                    $(".life_support_fuel_history").text('Gas');
                    break;
                case ('3'):
                    $(".life_support_fuel_history").text('Both');
                    break;
            }
            $(".life_support_equipment_history").text(data.life_support_value);
        }
        $(".moving_property_history").text(data.moving_house == 1 ? 'Yes' : 'No');
        if (data.moving_house == 1) {
            $('#elec_movin_div_history').show();
            $('#gas_movin_div_history').show();
            $('#is_elec_work_div_history').show();
            $('#is_access_issue_div_history').show();
            $('#movin_time_div_history').show();
            $('#elec_provider_div_history').hide();
            $('#gas_provider_div_history').hide();
            $(".elec_moving_date_history").text(data.electricity_moving_date);
            $(".gas_moving_date_history").text(data.gas_moving_date);
            $(".prefered_movin_time_history").text(data.prefered_move_in_time);
            $(".is_elec_work_history").text(data.is_elec_work == 1 ? 'Yes' : 'No');
            $(".is_any_access_issue_history").text(data.is_any_access_issue == 1 ? 'Yes' : 'No');
        }
        else if (data.moving_house == 0) {
            $('#elec_movin_div_history').hide();
            $('#gas_movin_div_history').hide();
            $('#is_elec_work_div_history').hide();
            $('#is_access_issue_div_history').hide();
            $('#movin_time_div_history').hide();
            $('#elec_provider_div_history').show();
            $('#gas_provider_div_history').show();
            $(".elec_provider_history").text(data.electricity_provider_name);
            $(".gas_provider_history").text(data.gas_provider_name);
        }
        $(".elec_distributor_history").text(data.electricity_distributor_name);
        $(".solar_panel_history").text(data.solar_panel == 1 ? 'Yes' : 'No');
        $(".solar_options_history").text(data.solar_options != 'null' ? data.solar_options : 'N/A');
        if (data.control_load_one_off_peak != 'null') {
            $('#control_load_one_off_peak_history').show();
            $('.control_load_one_off_peak_history').text(data.control_load_one_off_peak);
        }
        if (data.control_load_two_off_peak != 'null') {
            $('#control_load_two_off_peak_history').show();
            $('.control_load_two_off_peak_history').text(data.control_load_two_off_peak);
        }
        if (data.control_load_one_shoulder != 'null') {
            $('#control_load_one_shoulder_history').show();
            $('.control_load_one_shoulder_history').text(data.control_load_one_shoulder);
        }
        if (data.control_load_two_shoulder != 'null') {
            $('#control_load_two_shoulder_history').show();
            $('.control_load_two_shoulder_history').text(data.control_load_two_shoulder);
        }
        if (data.electricity_meter_type_code != 'null') {
            $('#elec_meter_type_code_history').show();
            $('.elec_meter_type_code_history').text(data.electricity_meter_type_code);
        }
        $(".gas_distributor_history").text(data.gas_distributor_name);
        if (data.gas_meter_type_code != 'null') {
            $('#gas_meter_type_code_history').show();
            $('.gas_meter_type_code_history').text(data.gas_meter_type_code);
        }
        $(".credit_score_history").text(data.credit_score != 'null' ? data.credit_score : 'N/A');

    }
});


$(document).on('click', '#send_resend_email', function (e) {
    var lead_id = $('#lead_id').val();
    var service_id = $('#service_id').val();
    axios.post('/sales/resend-welcome-email', { 'lead_id': lead_id, 'service_id': service_id })

        .then(response => {
            toastr.success('Email sent Successfully')

            $('#kt_modal_resend_mail').modal('hide');
        }).catch(err => {
            if (err.response.status == 422) {
                showValidationMessages(err.response.data.errors);
            }
            if (err.response.status && err.response.data.message)
                toastr.error(err.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        });
});

//show popup on eye click
$(document).on('click', '.toggleKey', function(e) {
    if ($(this).hasClass('fa-eye-slash')) {
        $(this).removeClass('fa-eye-slash');
        $(this).addClass('fa-eye');
        $('.mcvid-td').show();
        $(".mcvid-td").text($(this).data('id'));
    } else {
        $(this).removeClass('fa-eye');
        $(this).addClass('fa-eye-slash');
        $('.mcvid-td').hide();
    }
});

$(document).on('click', '.hideapkipopup', function(e) {
    //remove class if poup closed
    $(".toggleKey").removeClass('fa-eye');
    $(".toggleKey").addClass('fa-eye-slash');
});
