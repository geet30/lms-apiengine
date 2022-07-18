$(document).ready(function () {
    var service = $('#affiliate-services option').val(), affiliate_id = $('#affiliate-id').val();

    handleModalContent($('#affiliate-services option:selected').text());

    getFilterData();

    $('#apply_commission_filters').click(function (e) {
        e.preventDefault();
        getFilterData();
    });

    $('#affiliate-services').change(function (e) {
        e.preventDefault();
        handleModalContent($(this).find('option:selected').text());
        service = $(this).val();
        getFilterData();
    });

    function getFilterData() {
        $('#apply_commission_filters').attr('disabled', true);
        CardLoaderInstance.show('#commission-table');
        service = $('#affiliate-services').val();
        var formData = $('#commission_filters').serialize();
        var url = '/affiliates/ajax-commission/' + affiliate_id + '/' + service;
        axios.post(url, formData)
            .then(function (response) {
                $('#commission-table').html(response.data);
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                $('#apply_commission_filters').attr('disabled', false);
                CardLoaderInstance.hide();
            });
    }

    function resetFilterForm() {
        $('#commission_filters select[name=year]').val(new Date().getFullYear()).change();
        $('#commission_filters select[name=month]').val(new Date().getMonth()).change();
        $('#commission_filters select[name=state]').val('').change();
        $('#commission_filters #providers-multiselect').val([]).change();
        $('#commission_filters select[name=property]').val('both').change();
        $('#commission_filters select[name=sale]').val('both').change();
    }

    $(".resetbutton").on('click', function () {
        // reset the filter form
        resetFilterForm();
        $('#apply_commission_filters').trigger('click');
    });

    $(document).on('click', '.here', function () {
        var form = `<div class="row justify-centent-center">
                        <div class="col-md-12">
                            <form class="mx-auto" method="POST" style="border: 1px solid #e4e6ef; border-radius: 0.475rem; max-width: 300px">
                                <input type="hidden" name="commission_struc_type" value="Elec-Res-Ret-ACT">
                                <input type="hidden" name="provider_id" value="7">
                                <input type="hidden" name="commission_struc_id" value="">
                                <input type="hidden" name="commission_year" value="2022" id="commission_year">
                                <input type="hidden" name="commission_month" value="Apr" id="commission_month">
                                <div class="form-actions" style="padding:5px">
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <input class="form-control form-control-sm" placeholder="Enter amount" name="amount" type="text" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-primary add_update_commission_structure">Submit</button>
                                            <button class="btn btn-sm btn-secondary click_cancel_commission_structure">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>`;
        $(this).closest('p').replaceWith(form);
    });

    $(document).on('click', '.add_update_commission_structure', function (e) {
        e.preventDefault();
        console.log('submit');
    });

    $(document).on('click', '.click_cancel_commission_structure', function (e) {
        e.preventDefault();
        console.log('cancel');
        $(this).closest('td').html(`<p><span class="here">Click Here</span> <br>to add commission</p>`);
    });

    function handleModalContent(service_type) {
        if (service_type == 'Energy') {
            $('#energy-box').show();
            $('#mobile-box').hide();
            $('#broadband-box').hide();
        } else if (service_type == 'Mobile') {
            $('#energy-box').hide();
            $('#mobile-box').show();
            $('#broadband-box').hide();
        } else {
            $('#energy-box').hide();
            $('#mobile-box').hide();
            $('#broadband-box').show();
        }
    }

    $('#save-commission-button').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        CardLoaderInstance.show('#add-commission-modal .modal-content');
        let formData = $('#add-commission-form').serialize();

        axios.post('/affiliates/add-commission/' + affiliate_id + '/' + service, formData)
            .then(response => {

                if (response.data.status == true) {
                    $('#add-commission-modal').modal('hide');
                    getFilterData();
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message);
                }

            }).catch(error => {
            if (error.response.status == 422) {
                showValidationMessages(error.response.data.errors);
            }
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        }).then(() => {
            CardLoaderInstance.hide();
            KTMenu.createInstances();
        });
    });

    $('#add-commission-modal').on('hide.bs.modal', () => {
        CardLoaderInstance.hide();
    });

    function resetAddCommissionForm() {
        $('#add-commission-form').trigger('reset');
        $('#add-commission-form select[name=year]').val(new Date().getFullYear()).change();
        $('#add-commission-form select[name=month]').val(new Date().getMonth()).change();
        $('#add-commission-form #providers').val([]).change();
    }

    $('#add-commission-modal').on('hidden.bs.modal', () => {
        removeValidationErrors();
        resetAddCommissionForm();
    });

    const showValidationMessages = (errors) => {
        $.each(errors, function(key, value) {
            var input = $("input[name='"+key+"']");
            var textarea = $("textarea[name='"+key+"']");
            var select = $("textarea[name='"+key+"']");
            var select2_id = $("#"+key);

            if(key.indexOf(".") != -1){
                var arr = key.split(".");
                input = $("input[name='"+arr[0]+"[]']:eq("+arr[1]+")");
                textarea = $("textarea[name='"+arr[0]+"[]']:eq("+arr[1]+")");
                select2_id = $("select[name='"+arr[0]+"[]']:eq("+arr[1]+")");
            }

            $(input).next('span.form_error').text(value).fadeIn();
            $(input).css('border-color', 'red');

            $(textarea).next('span.form_error').text(value).fadeIn();
            $(textarea).css('border-color', 'red');

            $(select).next('span.errors').text(value).fadeIn();
            $(select).css('border-color', 'red');

            // if select2
            var error_field = $(select2_id).nextAll('.form_error').text(value).fadeIn();
            $(error_field).parent().find('.select2-selection').css('border-color', 'red');
        });
    }

    const removeValidationErrors = () => {
        $("span.form_error").text('').hide();
        $("input").css('border-color', '');
        $("select").css('border-color', '');
        $("textarea").css('border-color', '');
        $(".select2-selection").css('border-color', '');
    }
});
