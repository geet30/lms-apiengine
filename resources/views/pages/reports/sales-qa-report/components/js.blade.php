<script>
    $(document).ready(function() {
        // Date Picker:-
        var start_date = moment().startOf('month');
        var end_date = moment();
        $('#datePickerQa').daterangepicker({
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

        // Sales Qa Filters:-
        $('#applySalesQaFilters').click(function(e) {
            e.preventDefault();
            pageNumber = 1;
            getSalesQaFilterData();
        });

        // Filter Function:-
        function getSalesQaFilterData() {
            processing = true;
            let myForm = document.getElementById('salesQaFilters');
            let formData = new FormData(myForm);
            var url = '/reports/sales-qa-logs/search';
            loaderInstance.show();
            axios.post(url, formData)
                .then(function(response) {
                    $('#tag_body_1 tr').remove();
                    saleQa = response.data.salesQaLogFilter;
                    $.each(saleQa, function(index, val) {
                        $('.sales_qa_table_body').append(`<tr>
                        <td>${index+1}</td>
                        <td>${val.lead_id}</td>
                        <td>${val.reference_no}</td>
                        <td>${val.ip}</td>
                        <td>${val.action}</td>
                        <td>${val.qa_name !=null ? val.qa_name : ""}</td>
                        <td>${val.collaborator_name !=null ? val.collaborator_name : "N/A"}</td>
                        <td>${val.Comment != null ? val.Comment : " "}</td>
                        <td>${val.created_at}</td>`);
                    });
                    loaderInstance.hide();
                });
        }

    });
</script>