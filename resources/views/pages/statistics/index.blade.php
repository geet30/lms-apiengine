<x-base-layout>
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/statistics/component/toolbar') }}
        <div>
            {{ theme()->getView('pages/statistics/tabs/conversion_graph/conversion-graph', compact('services')) }}'
        </div>
        <div>
            {{ theme()->getView('pages/statistics/tabs/lead-sale-comparison/lead-sale-comparison', compact('services')) }}
        </div>
        <div>
            {{ theme()->getView('pages/statistics/tabs/affiliate_stats', compact('services')) }}
        </div>
        <div>
            {{ theme()->getView('pages/statistics/tabs/sale_status_chart', compact('services')) }}
        </div>
        <div>
            {{ theme()->getView('pages/statistics/tabs/connection_type/connection_type_charts', compact('services')) }}
        </div>
        <div>
            {{ theme()->getView('pages/statistics/tabs/top_worst_plans_charts', ['services' => $services, 'affiliates' => $affiliates, 'subAffiliates' => $subAffiliates, 'providers' => $providers]) }}
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="/custom/js/statistics/top-worst-plans.js"></script>

        <script>
             var start_date = moment().startOf('month');
            var end_date = moment();
             /*Date and time picker*/
             $('#dashboard_brief_stats_card_time_slot').daterangepicker({
                startDate: start_date,
                endDate: end_date,
                showDropdowns: true,
                linkedCalendars: false,
                minDate: moment().subtract(2, 'years'), //datepicker min value
                maxDate: moment().endOf('isoWeek'),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'This Week': [moment().startOf('isoWeek'), moment()],
                    'Last Week': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks')
                        .endOf('isoWeek')
                    ],
                    'This Month': [moment().startOf('month'), moment()],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ],
                    'This Year': [moment().startOf('year'), moment()],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf(
                        'year')]
                }
            });
            var options = {
                series: [{
                    name: 'Inflation',
                    data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
                }],
                chart: {
                    height: 350,
                    type: 'bar',
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
                    formatter: function(val) {
                        return val + "%";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
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
                        formatter: function(val) {
                            return val + "%";
                        }
                    }
                },
                title: {
                    text: 'Affiliate Stats',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#kt_apexcharts_1"), options);
            chart.render();

            var options = {
                series: [44, 55, 13, 43, 22],
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: ['QA', 'Pending', 'Submit', 'Resubmit', 'Rejected'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#sale_status_chart"), options);
            chart.render();


            //conersion graphh
            var element = document.getElementById("conversions_graph_chart");

            var height = parseInt(KTUtil.css(element, 'height'));

            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var strokeColor = KTUtil.getCssVariableValue('--bs-gray-300');

            var color1 = KTUtil.getCssVariableValue('--bs-warning');
            var color1Light = KTUtil.getCssVariableValue('--bs-light-warning');

            var color2 = KTUtil.getCssVariableValue('--bs-success');
            var color2Light = KTUtil.getCssVariableValue('--bs-light-success');

            var color3 = KTUtil.getCssVariableValue('--bs-primary');
            var color3Light = KTUtil.getCssVariableValue('--bs-light-primary');

            //affiliate event
            $(document).on('click', '.check_retailer_affiliate', function() {
                if ($(this).val() == 1) {
                    $('#' + $(this).data('id') + '_affiliate_section').removeClass('d-none');
                    $('#' + $(this).data('id') + '_provider_section').addClass('d-none');
                    return;
                }
                $('#' + $(this).data('id') + '_affiliate_section').addClass('d-none');
                $('#' + $(this).data('id') + '_provider_section').removeClass('d-none');
            })
        </script>

        {{ theme()->getView('pages/statistics/tabs/conversion_graph/js') }}
        @include('pages.statistics.tabs.connection_type.js');
        @include('pages.statistics.tabs.lead-sale-comparison.js');
 @endsection
</x-base-layout>
