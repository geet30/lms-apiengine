<script>
        var conversionschart = null;
        function makeConversionGraphData(data,category,percentage)
        {
            console.log(data);
            console.log(category);
            var options = {
                series: [{
                name: 'Inflation',
                data: data
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                    width: percentage
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                        position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val + "%";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: category,
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 0.4,
                            opacityTo: 0.5,
                        }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function (val) {
                        return val + "%";
                        }
                    }
                },
                title: {
                    text: 'Conversion',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
                };

                conversionschart = new ApexCharts(document.querySelector("#conversions_graph_chart"), options);
                conversionschart.render();
        }
        //affiliate event
        $(document).on('click','.check_conversion_retailer_affiliate',function()
        {
            if($(this).val() == 1)
            {
                $('.'+$(this).data('id')+'_affiliate_section').removeClass('d-none');
                $('.'+$(this).data('id')+'_provider_section').addClass('d-none');
                return;
            }
            $('.'+$(this).data('id')+'_affiliate_section').addClass('d-none');
            $('.'+$(this).data('id')+'_provider_section').removeClass('d-none');
        });

        //affiliate event
        $(document).on('change','#converion_service_id',function()
        {
            var serviceId = $(this).val();
            getAffiliateProvidersList(serviceId);
        });

        var serviceId = $('#converion_service_id').val();
        getAffiliateProvidersList(serviceId);
        function getAffiliateProvidersList(serviceId)
        {
            axios.post('/statistics/get-affiliates-by-service', { 'serviceId': serviceId })
                .then(function (response) {
                    loaderInstance.hide();
                    html = '<option></option>';
                    $.each(response.data.affiliates, function (key, value) {
                        html += `<option value=${value.user_id}>${value.company_name}</option>`;
                    });
                    $('#converion_affiliate_id').html(html);

                    html = '<option></option>';
                    $.each(response.data.providers, function (key, value) {
                        html += `<option value=${value.user_id}>${value.name}</option>`;
                    });
                    $('#converion_provider_id').html(html);
                })
                .catch(function (error) {
                    loaderInstance.hide();
                    console.log(error);
                });
        }

        //affiliate event
        $(document).on('change','#converion_affiliate_id',function()
        {
            var affiliate = $(this).val();
            axios.post('/statistics/get-subaffiliate', { 'affiliate': affiliate,'serviceId' : $('#converion_service_id').val() })
                .then(function (response) {
                    loaderInstance.hide();
                    html = '<option></option>';
                    $.each(response.data.masterAffiliateData, function (key, value) {
                        html += `<option value=${value.user_id}>${value.company_name} Only</option>`;
                    });
                    $.each(response.data.affiliates, function (key, value) {
                        html += `<option value=${value.user_id}>${value.company_name}</option>`;
                    });
                    $('#conversion_sub_affiliate_id').html(html);
                })
                .catch(function (error) {
                    loaderInstance.hide();
                    console.log(error);
                });
        });


        //affiliate event
        $(document).on('submit','#conversion_graph_toolbar',function(e)
        {
            var form = this;
            e.preventDefault();
            getConversionGraphData(form);
        });

        function getConversionGraphData(form)
        {
            var start_date =  $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').startDate.format('DD-MM-YYYY');
            var end_date   =  $("#dashboard_brief_stats_card_time_slot").data('daterangepicker').endDate.format('DD-MM-YYYY');
            let formData = new FormData(form);
            formData.set('start_date',start_date);
            formData.set('end_date',end_date);
            axios.post('/statistics/get-conversion-graph', formData)
            .then(function (response) {
                if(conversionschart != null)
                {
                    conversionschart.destroy();
                } 
                var percentage = 100;
                 
                if(response.data.no_of_days > 15 && response.data.no_of_days <= 30)
                {
                    percentage += (response.data.no_of_days - 15)*6.5; 
                }
                else if(response.data.no_of_days > 30)
                {
                    if(response.data.no_of_days/30 > 15)
                    {
                        percentage += (response.data.no_of_days/30 - 15)*6.5; 
                    }
                }
                percentage = percentage+'%';
                makeConversionGraphData(response.data.data,response.data.category,percentage);
                $('#visit_to_leads_summary').html(response.data.visitToLeadConversion);
                $('#visit_to_net_sales_summary').html(response.data.visitToNetSaleConversion);
                $('#visit_to_gross_sale_summary').html(response.data.visitToGrossSaleConversion);
                $('#leads_to_net_sales_summary').html(response.data.leadToNetSaleConversion);
                $('#leads_to_gross_sales_summary').html(response.data.leadToGrossSaleConversion);
                $('#unique_leads_to_net_sales_summary').html(response.data.uniqueLeadToNetSaleConversion);
                $('#unique_leads_to_gross_sales_summary').html(response.data.uniqueLeadToGrossSaleConversion);
            })
            .catch(function (error) {
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        toastr.error(value);
                    });
                }
                loaderInstance.hide();
            });
        }
        var converseForm =document.getElementById('conversion_graph_toolbar');
        getConversionGraphData(converseForm);
</script>
