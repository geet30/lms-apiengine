let flag = false;
$(document).on('click','.top_worst_plans_header',function(){
    let url = "/statistics/get-top-worst-plans";
    let serviceType = $('.statistics_service_type :selected').val();
    let start_date = $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').startDate.format('DD-MM-YYYY');
    let end_date = $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').endDate.format('DD-MM-YYYY');
    if(flag == false){
        axios.get(url, {
            params: {
                'service_id': serviceType,
                'start_date': start_date,
                'end_date' : end_date
            }
        }).then(function (response) {
                getTopPlansListing(response.data.topplans);
                getWorstPlansListing(response.data.worstplans);
                getServiceRelatedAffiliates([serviceType]);
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
    
        });
    }
    flag = true; 
});

function getTopPlansListing(data){
    let html = '';
    if(data.length > 0){
        data.forEach((element,index) => {
            html += `<tr>
                        <td>
                            <span class="text-muted fw-bold d-block fs-7">
                            ${index+1}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted fw-bold d-block fs-7"> ${element.plan_name}</span>
                        </td>
                        <td> 
                            <span class="text-muted fw-bold d-block fs-7">${element.provider_name}</span>
                        </td>
                        <td> 
                            <span class="text-muted fw-bold d-block fs-7 mt-1">${element.plan_cost}</span>
                        </td>
                        <td>
                            <span class="text-muted fw-bold d-block fs-7">
                            ${element.counter}
                            </span>
                        </td>
                    </tr>`; 
           
            });
            $('.top_plans_tbody').html('');
            $('.top_plans_tbody').append(html);  
    }else{
        html += `<tr>
                    <td>
                        <span class="text-muted fw-bold d-block fs-7">
                        No Data Found
                        </span>
                    </td>
                </tr>`;
        $('.top_plans_tbody').html('');
        $('.top_plans_tbody').append(html); 
    }
}

function getWorstPlansListing(data){
    let html = '';
    if(data.length > 0){
        data.forEach((element,index) => {
            html += `<tr>
                        <td>
                            <span class="text-muted fw-bold d-block fs-7">
                            ${index+1}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted fw-bold d-block fs-7"> ${element.plan_name}</span>
                        </td>
                        <td> 
                            <span class="text-muted fw-bold d-block fs-7">${element.provider_name}</span>
                        </td>
                        <td> 
                            <span class="text-muted fw-bold d-block fs-7 mt-1">${element.plan_cost}</span>
                        </td>
                        <td>
                            <span class="text-muted fw-bold d-block fs-7">
                            ${element.counter}
                            </span>
                        </td>
                    </tr>`; 
           
            });
            $('.worst_plans_tbody').html('');
            $('.worst_plans_tbody').append(html);  
    }else{
        html += `<tr>
                    <td>
                        <span class="text-muted fw-bold d-block fs-7">
                        No Data Found
                        </span>
                    </td>
                </tr>`;
        $('.worst_plans_tbody').html('');
        $('.worst_plans_tbody').append(html); 
    }  
}

$(document).on('change','.statistics_service_type',function(){
    flag = false;
    var serviceId = [$(this).val()]; 
    getServiceRelatedAffiliates(serviceId);
});

function getServiceRelatedAffiliates(serviceId){

    axios.post('/statistics/get-affiliates-by-service', { 'serviceId': serviceId })
    .then(function (response) {
        loaderInstance.hide();
        html = '';
        $.each(response.data.affiliates, function (key, value) {
            html += `<option value="${value.user_id}">${value.company_name}</option>`;
        });
        $('#top_worst_plans_chart_affiliate_id').html(html);

        html = '';
        $.each(response.data.providers, function (key, value) {
            html += `<option value="${value.user_id}">${value.name}</option>`;
        });
        $('#top_worst_plans_chart_provider_id').html(html);
    })
    .catch(function (error) {
        loaderInstance.hide();
        console.log(error);
    });
}

$(document).on('change','#top_worst_plans_chart_affiliate_id',function()
{    
    var affiliate = $(this).val(); 
    var serviceId = $('.statistics_service_type :selected').val();
    axios.post('/statistics/get-subaffiliate', { 'affiliate': affiliate,'serviceId' : serviceId })
        .then(function (response) {
            loaderInstance.hide();
            html = '';
            $.each(response.data.masterAffiliateData, function(key, value) {
                html += `<option value=${value.user_id}>${value.company_name} Only</option>`;
            });
            $.each(response.data.affiliates, function(key, value) {
                html += `<option value=${value.user_id}>${value.company_name}</option>`;
            });
            $('#top_worst_plans_chart_sub_affiliate_id').html(html);
        })
        .catch(function (error) {
            loaderInstance.hide();
            console.log(error);
        });
});

$(document).on('click','.check_retailer_affiliate',function(){
    let selectedType = $("input[name='top_worst_plans_chart_retailer_affiliate']:checked").val();
    if(selectedType == 1){
        $('.top_worst_plans_chart_providers').val('').trigger('change');
    }else if(selectedType == 2){
        $('.top_worst_plans_chart_affiliates').val('').trigger('change');
        $('.top_worst_plans_chart_sub_affiliates').val('').trigger('change');
    }
});

$(document).on('click','.top_worst_plans_chart_affiliate_filters',function(){
    let url = "/statistics/get-top-worst-plans";
    let serviceType = $('.statistics_service_type :selected').val();
    if(serviceType == null || serviceType == ''){
        toastr.error("Whoops! Please select Service Type.");
        return 0;
    }
    console.log(serviceType);
    let start_date = $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').startDate.format('DD-MM-YYYY');
    let end_date = $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').endDate.format('DD-MM-YYYY');
    let selectedAffiliates = selectedSubAffiliates = selectedProviders = '';
    let selectedType = $("input[name='top_worst_plans_chart_retailer_affiliate']:checked").val();
    if(selectedType == 1){
        selectedAffiliates = $('.top_worst_plans_chart_affiliates').val();
        selectedSubAffiliates = $('.top_worst_plans_chart_sub_affiliates').val();
    }else if(selectedType == 2){
        selectedProviders = $('.top_worst_plans_chart_providers').val();
    }
    axios.get(url, {
        params: {
            'service_id': serviceType,
            'start_date': start_date,
            'end_date' : end_date,
            'affiliate_ids' : selectedAffiliates,
            'sub_affiliate_ids' : selectedSubAffiliates,
            'provider_ids' : selectedProviders
        }
    }).then(function (response) {
            getTopPlansListing(response.data.topplans);
            getWorstPlansListing(response.data.worstplans);
    })
    .catch(function (error) {
        console.log(error);
    })
    .then(function () {

    });
});
