<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script>

    $(document).on('change', '#dmoselection', function() {
        $('.form_error_name').html("");
        $('.tab-pane').removeClass('active');
        $('#'+$(this).val()).addClass('active');
    });

    $(document).on('change', '.dmo_parameters', function() {
        let selected = $(this).val();
        CKEDITOR.instances.dmo_content.insertText(selected);
    });

    $(document).on('change', '.dmo_parameters1', function() {
        let selected = $(this).val();
        CKEDITOR.instances.withpayontimediscount.insertText(selected);
    });

    $(document).on('change', '.dmo_parameters2', function() {
        let selected = $(this).val();
        CKEDITOR.instances.withdirectdebitdiscountcontent.insertText(selected);
    });

    $(document).on('change', '.dmo_parameters3', function() {
        let selected = $(this).val();
        CKEDITOR.instances.withbothpayontimeanddirectdebitdiscount.insertText(selected);
    });


    $(".submit_dmo_btn").click(function() {
        loaderInstance.show();
        var formData = new FormData($("#dmo_form")[0]);
        formData.append('dmo_content', CKEDITOR.instances.dmo_content.getData());
        url = '/settings/settings-dmo';
        axios.post(url, formData)
        .then(function (response) {
            loaderInstance.hide();
            if(response.status == 200){
                toastr.success(response.data.message);
                 $('.dmofirst').val(response.data.id);
            }else{
                toastr.error(response.data.message);
            }
        })
        .catch(function (error) {
            loaderInstance.hide();
            console.log(error);
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('.form_error_name').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }

        })
        .then(function () {
            loaderInstance.hide();
        });
    });


    $(".submit_dmo_btn1").click(function() {
        loaderInstance.show();
        var formData = new FormData($("#dmo_form1")[0]);
        formData.append('withpayontimediscount', CKEDITOR.instances.withpayontimediscount.getData());
        url = '/settings/settings-dmo';
        axios.post(url, formData)
        .then(function (response) {
            loaderInstance.hide();
            if(response.status == 200){
                toastr.success(response.data.message);
                 $('.dmosecond').val(response.data.id);
            }else{
                toastr.error(response.data.message);
            }

        })
        .catch(function (error) {
            loaderInstance.hide();
            console.log(error);
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('.form_error_name').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
        })
        .then(function () {
            loaderInstance.hide();
        });
    });


    $(".submit_dmo_btn2").click(function() {
        loaderInstance.show();
        var formData = new FormData($("#dmo_form2")[0]);
        formData.append('withdirectdebitdiscountcontent', CKEDITOR.instances.withdirectdebitdiscountcontent.getData());
        url = '/settings/settings-dmo';
        axios.post(url, formData)
        .then(function (response) {
            loaderInstance.hide();
            if(response.status == 200){
                toastr.success(response.data.message);
                 $('.dmothird').val(response.data.id);
            }else{
                toastr.error(response.data.message);
            }

        })
        .catch(function (error) {
            loaderInstance.hide();
            console.log(error);
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('.form_error_name').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
        })
        .then(function () {
            loaderInstance.hide();
        });
    });

    $(".submit_dmo_btn3").click(function() {
        loaderInstance.show();
        var formData = new FormData($("#dmo_form3")[0]);
        formData.append('withbothpayontimeanddirectdebitdiscount', CKEDITOR.instances.withbothpayontimeanddirectdebitdiscount.getData());
        url = '/settings/settings-dmo';
        axios.post(url, formData)
        .then(function (response) {
            loaderInstance.hide();
            if(response.status == 200){
                toastr.success(response.data.message);
                 $('.dmofourth').val(response.data.id);
            }else{
                toastr.error(response.data.message);
            }

        })
        .catch(function (error) {
            loaderInstance.hide();
            console.log(error);
            if(error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('.form_error_name').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
        })
        .then(function () {
            loaderInstance.hide();
        });
    });


</script>
