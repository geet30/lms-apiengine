jQuery(document).ready(function () {

    $(document).on('submit', '#add_home_connection_form', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        var formId = 'add_home_connection_form';
        saveForm('/addons/store/3', formData, formId);
    });
    $(document).on('submit', '#add_modem_form', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        var formId = 'add_modem_form';
        saveForm('/addons/store/4', formData, formId);
    });
    $(document).on('submit', '#add_addon_form', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        var formId = 'add_addon_form';
        saveForm('/addons/store/5', formData, formId);
    });

    /**
    *   it send to axios request to server and get reponse from server also show errors  
    */
    function saveForm(url, formData, formId) {
        loaderInstance.show();
        axios.post(url, formData)
            .then(function (response) {
                if (formId == 'add_home_connection_form') {

                    window.location.href = '/addons/home-line-connection/list';
                }
                else if (formId == 'add_modem_form') {

                    window.location.href = '/addons/modem/list';
                }
                else if (formId == 'add_addon_form') {

                    window.location.href = '/addons/additional-addons/list';
                }
                loaderInstance.hide();
                $(".error").html("");
                toastr.success(response.data.message);
                setContentCheckbox(response);
            }).catch(function (error) {
                loaderInstance.hide();
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('[name="' + key + '"]').parent().find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                    $('html, body').animate({
                        scrollTop: ($('.error.text-danger').offset().top - 300)
                    }, 1000);
                }
                else if (error.response.status == 400) {
                    toastr.error(error.response.message);
                }
                return false;
            });
    }

    $(document).on('click', '.change-status', function (e) {
        var id = $(this).attr("data-status");
        var that = $(this);
        var url = '/addons/update-status';
        var status = 0;
        if ($(this).is(':checked'))
            status = 1;


        console.log(status);
        var formdata = new FormData();
        formdata.append("addon_id", id);
        formdata.append("status", status);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change status!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                axios.post(url, formdata)
                    .then(function (response) {
                        if (response.data.status == 400) {
                            toastr.error(response.data.message);
                            
                        } else {
                            toastr.success(response.data.message);
                            setTimeout(function() {
                                location.reload();
                            }, 1000); 
                        }

                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {

                    });
            } else {
                that.prop('checked', !status);
            }
        });
    });
    $(document).on('change', '.connection_type_event', function () {
        var obj = this;
            getTechType(obj);
    });
    function getTechType(obj) {
        var connectionId = $(obj).val();
        if (connectionId) {
            loaderInstance.show();
            axios.get('/addons/get-technology-type/' + connectionId)
                .then(function (response) {
                    loaderInstance.hide();
                    var techTypeOptions = '<option value=""></option>';
                    $.each(response.data.data, function (key, value) {
                        techTypeOptions += `<option value="${value.id}">${value.name}</option>`;
                    });
                    $('.tech_type_event').html(techTypeOptions);
                    $('.tech_type_event').select2();
                })
                .catch(function (error) {
                    loaderInstance.hide();
                });
            return;
        }
        $('.tech_type_event').html('');
        return;
    }
    $(document).on('click', '.delete_addon', function(event) {
        var id = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/addons/delete/' + id,
                    type: 'GET',
                    dataType: 'JSON',
                    headers: {
                        'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id
                    },
                    success: (data) => {
                        loaderInstance.hide();
                        if (data.status == true) {
                            toastr.success(data.message);
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000); //add delay
                    },
                    error: function(error) {
                        // if(error.status == 422) {
                        //     errors = error.responseJSON;
                        //     $.each(errors.errors, function(key, value) {
                        //         $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        //     });
                        // }
                        loaderInstance.hide();
                    }
                });
            }
        });

    });
});