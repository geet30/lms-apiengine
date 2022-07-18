<script>
    var connectionChart = null;

    function connectionGraphData(newconnection, portin, recontract, label,percentage) {
        var options = {
            series: [{
                name: 'New Connection',
                data: newconnection
            }, {
                name: 'Port In',
                data: portin
            }, {
                name: 'Re Contract',
                data: recontract
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
            yaxis: {
                title: {
                    text: 'Sales',
                    style: {
                        fontSize: '18px'
                    }
                },
            },
            fill: {
                    opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + ' Sales'
                    }
                }
            },
        };
        connectionChart = new ApexCharts(document.querySelector("#connection_type_charts"), options);
        connectionChart.render();
    }

    //affiliate event
    $(document).on('click', '.check_connection_retailer_affiliate', function() {
        if ($(this).val() == 1) {
            $('.' + $(this).data('id') + '_affiliate_section').removeClass('d-none');
            $('.' + $(this).data('id') + '_provider_section').addClass('d-none');
            return;
        }
        $('.' + $(this).data('id') + '_affiliate_section').addClass('d-none');
        $('.' + $(this).data('id') + '_provider_section').removeClass('d-none');
    });

    //affiliate event
    $(document).on('change', '#connection_service_id', function() {
        serviceId = [$(this).val()];
        getAffiliates(serviceId);
    });
    serviceId = [$('#connection_service_id').val()];
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
                $('#connection_affiliate_id').html(html);

                html = '<option></option>';
                $.each(response.data.providers, function(key, value) {
                    html += `<option value=${value.user_id}>${value.name}</option>`;
                });
                $('#connection_provider_id').html(html);
            })
            .catch(function(error) {
                loaderInstance.hide();
                console.log(error);
            });
    }

    //affiliate event
    $(document).on('change', '#connection_affiliate_id', function() {
        var affiliate = $(this).val();
        axios.post('/statistics/get-subaffiliate', {
                'affiliate': affiliate,
                'serviceId': $('#connection_service_id').val()
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
                $('#connection_sub_affiliate_id').html(html);
            })
            .catch(function(error) {
                loaderInstance.hide();
                console.log(error);
            });
    });


    $(document).on('submit', '#connection_graph_toolbar', function(e) {

        var form = this;
        e.preventDefault();
        getConnectionGraphData(form);
    });

    function getConnectionGraphData(form) {
        var start_date = $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').startDate.format(
            'DD-MM-YYYY');
        var end_date = $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').endDate.format('DD-MM-YYYY');
        $('.connection_stat_title').html(start_date + ' To ' + end_date);
        let formData = new FormData(form);
        formData.set('start_date', start_date);
        formData.set('end_date', end_date);
        axios.post('/statistics/get-connection-graph', formData)
            .then(function(response) {
                connection_flag = true;
                if (connectionChart != null) {
                    connectionChart.destroy();
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
                connectionGraphData(response.data.newconnection, response.data.portin, response.data
                    .recontract, response.data.label,percentage);
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
 var connection_flag = false;
    $("#connection_click").on("click", function(e) {
        if(connection_flag == false){
    var connectionForm = document.getElementById('connection_graph_toolbar');
    getConnectionGraphData(connectionForm);
    }
    });

</script>
