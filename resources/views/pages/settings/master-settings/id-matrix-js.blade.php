<script>
    var matrix = [];
    $(document).on('click', '#id-matrix-tab', function (e) {
        if (matrix.length === 0) {
            CardLoaderInstance.show('#id-matrix-section');
            axios.get('/settings/get-idmatrix')
                .then(function (response) {
                    if (response.status === 200) {
                        matrix = response.data.matrix_settings;
                        setValues(matrix);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    toastr.error('Whoops! something went wrong');
                })
                .then(function () {
                    CardLoaderInstance.hide();
                });
        } else {
            setValues(matrix);
        }
    });

    function setValues(matrix) {
        (matrix[0].value == 1) ? $("input[name=status][value='1']").prop("checked", true) : $("input[name=status][value='0']").prop("checked", true);
        $('input[name="drivers_license"]').prop('checked', matrix[1].value == 1);
        $('input[name="australian_passport"]').prop('checked', matrix[2].value == 1);
        $('input[name="medicare_card"]').prop('checked', matrix[3].value == 1);
        $('input[name=foreign_passport]').prop('checked', matrix[4].value == 1);
        CKEDITOR.instances.matrix_content.setData(matrix[5].value);
    }

    $(document).on('click', '#add_matrix', function (e) {
        e.preventDefault();
        var formData = new FormData($("#master_settings_idmatrix_form")[0]);
        var action = $('#master_settings_idmatrix_form').attr('action');
        formData.append('matrix_content', CKEDITOR.instances.matrix_content.getData());
        formSubmit(action, formData);
    });


    $(document).on('click', '#matrix_attributes', function () {
        var selected = jQuery('#matrix_attributes :selected').val();
        CKEDITOR.instances.matrix_content.insertText(selected);
    });

    function formSubmit(action, formData) {
        removeValidationErrors()
        let submitButton = document.querySelector('#add_matrix');
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        axios.post(action, formData)
            .then((response) => {
                if (response.data.status == true) {
                    matrix = response.data.matrix_settings;
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
    }

    const showValidationMessages = (errors) => {
        $.each(errors, function (key, value) {
            var textarea_id = $("#" + key);

            // if cke editor
            var error_field = $(textarea_id).nextAll('.form_error').addClass('field-error').text(value).fadeIn();
            $(error_field).parent().find("#cke_" + key).css('border-color', 'red');
        });
    }

    const removeValidationErrors = () => {
        $("span.form_error").text('').hide();
        $(".cke").css('border-color', '');
    }
</script>
