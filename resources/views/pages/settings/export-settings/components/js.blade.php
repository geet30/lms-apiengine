<script src="{{'/custom/js/tagify.min.js'}}"></script>
<script>
jQuery(document).ready(function () {

    $(document).on('click', '.export_submit_btn', function (event) {
        event.preventDefault();
        $('.error').empty().text('');
        let formId = $(this).data('form');
            if (!formId) {
                toastr.error('Whoops! something went wrong.');
                return false;
            }
        var formData = new FormData($('#' + formId)[0]);
        var url = '/settings/change-password';
        formData.append('request_from', formId);

        axios.post(url, formData)
            .then(function (data) {
               if(data.data.status==200){
                   toastr.success(data.data.message);
                //    $('#reset_sale_export_password').val(data.data.salePasswordRes.value);
                //    $('#reset_lead_export_password').val(data.data.leadPasswordRes.value);
               }
            })
            .catch(function (error) {
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('[name="' + key + '"]').parent().find('span.error').empty().addClass(
                            'text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                } else if (error.response.status == 400) {

                    toastr.error(error.response.message);
                }
            });
    });
    var input3 = document.querySelector("#kt_tagify_lead_sale_ips"); 
        new Tagify(input3);  
    var input4 = document.querySelector("#kt_tagify_direct_debit_ips"); 
        new Tagify(input4);  
    var input5 = document.querySelector("#kt_tagify_detokenization_ips"); 
        new Tagify(input5);  
    var input6 = document.querySelector("#kt_tagify_detokenization_emails"); 
        new Tagify(input6); 
    var input7 = document.querySelector("#kt_tagify_direct_debit_emails"); 
        new Tagify(input7); 
   
});
</script>