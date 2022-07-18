<script>
    jQuery(document).ready(function() {
        // $("#recon_history_table").DataTable();

        let dataTableList = $(".recon_history_datatable")
        .on('draw.dt', function () {
            $('.form-check-input.main').prop('checked', false);
            KTMenu.createInstances();
        })
        .DataTable({
            columnDefs: [
                { "orderable": false, "targets": 0 }
            ],
            searching: true,
            ordering: true,
            "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        });

        $('#recon_ref_no').keyup(function () {
        if (dataTableList !== '')
            dataTableList.search($(this).val()).draw();
        });
        $(".recon_history_reset_btn").on('click', function () {
        $('#recon_ref_no').val('');
        if (dataTableList !== '')
            dataTableList.search($(this).val()).draw();
        });
    
        jQuery("#test_recon").click(function(){
            jQuery("#recon_file_type").val("test");
            jQuery("#generate_month_recon_popup").modal();
            jQuery("#add_adjustment_form")[0].reset();
        });
        jQuery("#live_recon").click(function(){
            jQuery("#recon_file_type").val("live");
            jQuery("#generate_month_recon_popup").modal();
            jQuery("#add_adjustment_form")[0].reset();
        });
        $(document).on('click', '#submit_recon_month_data', function(e) {
            e.preventDefault();
            $('#add_adjustment_form').find('input').css('border-color', '');
            CardLoaderInstance.show('.modal-content');
            var formData = new FormData($("#add_adjustment_form")[0]);
            formData.append('affiliate_id',$('#aff_sub_id').val());
            axios.post("{{ route('recon.generate-recon-file')}}", formData)
                .then(function(response) {
                    var tableRow = response.data.result;
                    $("#generate_month_recon_popup").modal('hide');
                    if (response.data.status == true) {
                        toastr.success(response.data.message);
                   
                        CardLoaderInstance.hide();
                        

                    } else {
                        toastr.error(response.data.message);
                    }
                })
                .catch(function(error) {
                    if (error.response.status == 422) {
                        errors = error.response.data.errors;
                        $("span.form_error").hide();
                        $('#add_adjustment_form').find('input').css('border-color', '');
                        $('.field-holder').find('input').css('border-color', '');
                    
                        $.each(errors, function(i, obj) {
                        
                            $('input[name=' + i + ']').parent('.field-holder').find('span.form_error').slideDown(400).html(obj);
                            $('input[name=' + i + ']').css('border-color', 'red');
                        });
                        CardLoaderInstance.hide();
                    }
                })
                .then(function() {
                    KTMenu.createInstances();
                });
            });
    
    });
</script>