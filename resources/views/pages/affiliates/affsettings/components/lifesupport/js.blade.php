<script>
    $(document).on('submit', '#affiliate_life_support_content_form', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('request_from', $(this).closest('form').attr('name'));

        var url = '/affiliates/update/' + $('#affiliate_user_id').val();

        removeValidationErrors()
        let submitButton = document.querySelector('#add_life_support');
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        axios.post(url, formData)
            .then((response) => {
                if (response.data.status == 200) {
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                if (error.response.status == 422) {
                    showValidationMessages(error.response.data.errors);
                    toastr.error(error.response.data.message);
                } else
                    toastr.error('Whoops! something went wrong');
            })
            .then(function () {
                submitButton.setAttribute('data-kt-indicator', 'off');
                submitButton.disabled = false;
            });
    });

    const showValidationMessages = (errors) => {
        $.each(errors, function (key, value) {
            var textarea_id = $("#affiliate_life_support_content_form textarea[name='"+key+"']");
            var error_field1 = $(textarea_id).nextAll('.form_error').addClass('field-error').text(value).fadeIn();
            $(error_field1).parent().find("#cke_"+key).css('border-color', 'red');
        });
    }

    const removeValidationErrors = () => {
        $("span.form_error").text('').hide();
        $("#cke_content").css('border-color', '');
    }
</script>
