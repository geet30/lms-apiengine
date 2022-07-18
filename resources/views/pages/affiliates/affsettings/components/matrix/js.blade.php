<script>
    var matrixArr = [];
    var services = [];

    $(document).on('click', '.idmatrix', function (e) {
        if (matrixArr.length === 0) {
            CardLoaderInstance.show('#matrix');
            let action = "/affiliates/idmatrix/" + $('#show_apikeypopup').data('user_id');
            var tag_id = $(this).val();
            axios.get(action)
                .then(function (response) {
                    services = response.data.services;
                    if (services) {
                        setServices(services);
                    }
                    matrixArr = response.data.id_matrix;
                    setValues(matrixArr);
                })
                .catch(function (error) {
                    console.log(error)
                })
                .then(function () {
                    CardLoaderInstance.hide();
                });
        } else {
            setServices(services);
            setValues(matrixArr);
        }
    });

    function setServices(services) {
        $('#services').html('');
        var html = '';
        $.each(services, function (index, service) {
            html += `<option value="${service.id}">${service.service_title}</option>`
        });
        $('#services').append(html);
    }

    function setValues(matrixArr) {
        if(matrixArr !== null) {
            $("#matrix_edit_id").val(matrixArr.id);
            $('input[name="medicare_card"]').prop('checked', matrixArr.medicare_card == 1);
            $('#foreign_passport').prop('checked', matrixArr.foreign_passport == 1);
            $('input[name="driver_license"]').prop('checked', matrixArr.driver_license == 1);
            $('input[name="australian_passport"]').prop('checked', matrixArr.australian_passport == 1);
            $("#id_matrix_enable").prop("checked", matrixArr.id_matrix_enable == 1);
            $("#matrix_content_key_enable").prop("checked", matrixArr.matrix_content_key_enable == 1);
            $("#secondary_identification_allow").prop("checked", matrixArr.secondary_identification_allow == 1);
            matrixArr.services !== null ? $('#services').val(matrixArr.services.split(',')).trigger('change') : '';
            CKEDITOR.instances.matrix_content.setData(matrixArr.matrix_content);
        }
    }

    $(document).on('click', '#add_matrix', function (e) {
        e.preventDefault();
        $("#matrix_user_id").val($('#show_apikeypopup').data('user_id'));
        var formData = new FormData($("#aff_idmatrix_form")[0]);
        var action = $('#aff_idmatrix_form').attr('action');
        formData.append('matrix_content', CKEDITOR.instances.matrix_content.getData());
        formSubmit(action, formData);
    });


    $(document).on('click', '#matrix_attributes', function () {
        var selected = jQuery('#matrix_attributes :selected').val();
        CKEDITOR.instances.matrix_content.insertText(selected);
    });
</script>
