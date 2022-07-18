<script>
    var comparisonChart = null;

    function comparisonGraphData(visits,leads,sales,leadType,saleType,label,percentage) {
        var options = {
            series: [{
                name: 'Visits',
                data: visits
            }, {
                name: leadType,
                data: leads
            }, {
                name: saleType,
                data: sales
            }],
            chart: {
                type: 'bar',
                height: 350,
                width: percentage,
            },
            plotOptions: {
                bar: {
                    columnWidth: '55%',
                    endingShape: 'rounded',
                    dataLabels: {
                            position: 'top',
                        },
                },

            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                        return val;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
            },
            stroke: {
                show: true,
                width: 4,
                colors: ['transparent']
            },
            xaxis: {
                range: 7,
                categories: label,
                labels: {
                    style: {
                        fontSize: '18px',
                        fontweight: 'bold',
                    },
                },
            },
            fill: {
                    opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            },
        };
        comparisonChart = new ApexCharts(document.querySelector("#comparison_chart"), options);
        comparisonChart.render();
    }

    //affiliate event
    $(document).on('click', '.check_comparison_retailer_affiliate', function() {
        if ($(this).val() == 1) {
            $('.' + $(this).data('id') + '_affiliate_section').removeClass('d-none');
            $('.' + $(this).data('id') + '_provider_section').addClass('d-none');
            return;
        }
        $('.' + $(this).data('id') + '_affiliate_section').addClass('d-none');
        $('.' + $(this).data('id') + '_provider_section').removeClass('d-none');
    });

    //affiliate event
    $(document).on('change', '#comparison_service_id', function() {
        serviceId = $(this).val();
        getAffiliates(serviceId);
    });
    serviceId = $('#comparison_service_id').val();
    getAffiliates(serviceId);

    function getAffiliates(serviceId) {
        axios.post('/statistics/get-affiliates-by-service', {
                'serviceId': serviceId
            })
            .then(function(response) {
                loaderInstance.hide();
                html = '<option></option>';
                $.each(response.data.affiliates, function(key, value) {
                    html += `<option value=${value.user_id}>${value.company_name}</option>`;
                });
                $('#comparison_affiliate_id').html(html);

                html = '<option></option>';
                $.each(response.data.providers, function(key, value) {
                    html += `<option value=${value.user_id}>${value.name}</option>`;
                });
                $('#comparison_provider_id').html(html);
            })
            .catch(function(error) {
                loaderInstance.hide();
                console.log(error);
            });
    }

    //affiliate event
    $(document).on('change', '#comparison_affiliate_id', function() {
        var affiliate = $(this).val();
        axios.post('/statistics/get-subaffiliate', {
                'affiliate': affiliate,
                'serviceId': $('#comparison_service_id').val()
            })
            .then(function(response) {
                loaderInstance.hide();
                html = '<option></option>';
                $.each(response.data.masterAffiliateData, function(key, value) {
                    html += `<option value=${value.user_id}>${value.company_name} Only</option>`;
                });
                $.each(response.data.affiliates, function(key, value) {
                    html += `<option value=${value.user_id}>${value.company_name}</option>`;
                });
                $('#comparison_sub_affiliate_id').html(html);
            })
            .catch(function(error) {
                loaderInstance.hide();
                console.log(error);
            });
    });


    $(document).on('submit', '#comparison_graph_toolbar', function(e) {

        var form = this;
        e.preventDefault();
        getComparisonGraphData(form);
    });

    function getComparisonGraphData(form) {
        var start_date = $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').startDate.format(
            'DD-MM-YYYY');
        var end_date = $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').endDate.format('DD-MM-YYYY');
        $('.comparison_stat_title').html(start_date + ' To ' + end_date);
        let formData = new FormData(form);
        formData.set('start_date', start_date);
        formData.set('end_date', end_date);
        axios.post('/statistics/get-comparison-graph', formData)
            .then(function(response) {
                comparison_flag = true;
                if (comparisonChart != null) {
                    comparisonChart.destroy();
                }
                var percentage = 100;

                if(response.data.no_of_days > 8 && response.data.no_of_days <= 30)
                {
                    percentage += (response.data.no_of_days - 8)*12.5;
                }
                else if(response.data.no_of_days > 30)
                {
                    if(response.data.no_of_days/30 > 8)
                    {
                    percentage += (response.data.no_of_days/15 - 8)*12.5;
                    }
                }
                percentage = percentage+'%';
                $('.comparison_title').html(response.data.comparisonType + ' ' +'Comparison');
                comparisonGraphData(response.data.visits,response.data.leads,response.data.sales,response.data.leadType,response.data.saleType,response.data.label,percentage);
            })
            .catch(function(error) {
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value);
                    });
                }
                loaderInstance.hide();
            });
    }
 var comparison_flag = false;
    $("#comparison_graph_click").on("click", function(e) {
        if(comparison_flag == false){
    var comparisonForm = document.getElementById('comparison_graph_toolbar');
    getComparisonGraphData(comparisonForm);
    }
    });

</script>
