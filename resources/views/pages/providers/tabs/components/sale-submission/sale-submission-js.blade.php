<script>
    var sale_submission_data = []
    $(".timepicker").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultMinute: 5,
        time_24hr: true
    });

    @if($providerdetails[0]['protected_sale_submission'] == 1)
    $('.sale-submission-password').fadeIn();
    @else
    $('.sale-submission-password').fadeOut();
    @endif

    $(document).on('click', '.addRow', function (event) {
        event.preventDefault();
        var html = `<div class="col-md-6 type-2 inputFormRow">
                        <div class="row">
                            <label class="col-lg-4 col-form-label fw-bold fs-6"></label>
                            <div class="col-9 col-sm-10 col-md-7 col-lg-7 fv-row mb-5">
                                <input class="form-control form-control-lg timepicker timepicker_cor timepicker_cor_end cor_time_field_count form-control-solid interval" placeholder="e.g. 10:10" readonly="readonly" count="0" tabindex="6" name="cor_sale_time[]" type="text" value="">
                                <span class="text-danger errors cor_sale_time_error" id=""></span>
                            </div>
                            <div class="col-1 fv-row p-0">
                                <button class="btn btn-danger btn-icon-only removeRow" data-type="2"><i class="fa fa-trash p-0"></i></button>
                            </div>
                          </div>
                       </div>`;

        if (checkEmptyIntervals($(this).closest('#sale_submission_form').find('.interval'))) {
            toastr.error('Please fill all the time fields.');
        } else {
            $('#newRow').append(html);
            $(".timepicker").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultMinute: 5,
                time_24hr: true
            });
        }
    });

    $(document).on('click', '.removeRow', function (event) {
        event.preventDefault();
        $(this).closest('.inputFormRow').fadeOut().remove();
    });

    function checkEmptyIntervals(intervals) {
        var status = false;
        $.each(intervals, (index, interval) => {
            if ($(interval).val() == '') {
                $(interval).closest('.row').find('.cor_sale_time_error').text('The time field is required.').show();
                status = true;
            }
        });
        return status;
    }

    $('#sale_submission_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        let submitButton = $(this);
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true);
        let formData = $('#sale_submission_form').serialize();

        axios.post('/provider/sale-submission', formData)
            .then(response => {
                sale_submission_data['sale_submission_' + response.data.sale_submission.sale_submission_type + '_' + response.data.sale_submission.provider_encrypted] = response.data;
                toastr.success(response.data.message)
            }).catch(error => {
            if (error.response.status == 422) {
                showValidationMessages(error.response.data.errors);

                // check for empty time interval field
                checkEmptyIntervals($('#sale_submission_form').find('.interval'));
            }
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        }).then(() => {
            submitButton.attr('data-kt-indicator', 'off');
            submitButton.prop('disabled', false);
        });
    });

    $('#password_protected_sale_submit_btn').click(function (event) {
        event.preventDefault();
        removeValidationErrors();
        let submitButton = $(this);
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true);
        let formData = $('#password_protected_sale_submission_form').serialize();

        axios.post('/provider/password-protected-sale-submission', formData)
            .then(response => {
                $("#password_protected_sale_submission_form span.errors").text('');
                toastr.success(response.data.message)
            }).catch(error => {
            if (error.response.status == 422) {
                showValidationMessages(error.response.data.errors);
            }
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        }).then(() => {
            submitButton.attr('data-kt-indicator', 'off');
            submitButton.prop('disabled', false);
        });
    });

    $('#sale_submission_type').on('change', function () {
        $("#sale_submission_form span.errors").text('');
        var type = $(this).val();
        var provider = $('input[name=provider_id]').val();
        var cache_data = 'sale_submission_' + type + '_' + provider;
        if (sale_submission_data.hasOwnProperty(cache_data)) {
            if (sale_submission_data[cache_data].status === 200)
                setSalesSubmissionResponse(sale_submission_data[cache_data]);
            else
                resetForm();
        } else {
            getFromServer(type, provider);
        }
    });

    function getFromServer(type, provider) {
        CardLoaderInstance.show('#sale-submission-card');
        axios.get('/provider/get-sale-submission/' + provider + '/' + type)
            .then(response => {
                sale_submission_data['sale_submission_' + type + '_' + provider] = response.data;
                if (response.data.status == 200) {
                    setSalesSubmissionResponse(response.data);
                } else {
                    resetForm()
                }
            }).catch(error => {
            console.log(error)
            toastr.error('Whoops! something went wrong');
        }).then(() => {
            CardLoaderInstance.hide();
        });
    }

    function setSalesSubmissionResponse(response) {
        var sale_submission = response.sale_submission;
        var intervals = response.intervals;
        // fill up the fields
        $('input[name=from_email]').val(sale_submission.from_email)
        $('input[name=from_name]').val(sale_submission.from_name)
        $('input[name=subject]').val(sale_submission.subject)
        $('input[name=to_email_ids]').val(sale_submission.to_email_ids)
        $('input[name=cc_email_ids]').val(sale_submission.cc_emails_ids)
        $('input[name=bcc_email_ids]').val(sale_submission.bcc_emails_ids)

        //save data in option tag
        $('#sale_submission_type option[value=1]').attr('data-from_email', sale_submission.from_email)
        $('#sale_submission_type option[value=1]').attr('data-from_name', sale_submission.from_name)

        var html_first_slot = '';
        var html_other_slots = '';
        $('#time-slots').html('');
        $.each(intervals, (index, interval) => {
            if (index == 0) {
                html_first_slot += `<div class="row mb-5">
                                    <div class="col-md-6 type-2">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6">Time:</label>
                                            <div class="col-9 col-sm-10 col-md-7 col-lg-7 fv-row">
                                                <input id="part-0" class="form-control form-control-lg timepicker timepicker_cor interval timepicker_cor_end cor_time_field_count form-control-solid" placeholder="e.g. 10:10" readonly="readonly" count="0" tabindex="6" name="cor_sale_time[]" type="text" value="${interval.time}">
                                                <span class="text-danger errors cor_sale_time_error" id=""></span>
                                            </div>
                                            <div class="col-1 fv-row p-0">
                                                <button class="btn btn-success btn-icon-only green addRow" data-type="2"><i class="fa fa-plus p-0"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-12 type-2">
                                        <div class="row" id="newRow"></div>
                                    </div>
                                </div>
                            </div>`
            } else {
                html_other_slots += `<div class="col-md-6 type-2 inputFormRow">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6"></label>
                                    <div class="col-9 col-sm-10 col-md-7 col-lg-7 fv-row mb-5">
                                        <input class="form-control form-control-lg timepicker timepicker_cor timepicker_cor_end cor_time_field_count form-control-solid interval" placeholder="e.g. 10:10" readonly="readonly" count="0" tabindex="6" name="cor_sale_time[]" type="text" value="${interval.time}">
                                        <span class="text-danger errors cor_sale_time_error" id=""></span>
                                    </div>
                                    <div class="col-1 fv-row p-0">
                                        <button class="btn btn-danger btn-icon-only removeRow" data-type="2"><i class="fa fa-trash p-0"></i></button>
                                    </div>
                                  </div>
                               </div>`
            }
        });

        $('#time-slots').append(html_first_slot)
        $('#newRow').append(html_other_slots)
        $(".timepicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            defaultMinute: 5,
            time_24hr: true
        });
    }

    function resetForm() {
        $('input[name=from_email]').val('')
        $('input[name=from_name]').val('')
        $('input[name=subject]').val('')
        $('input[name=to_email_ids]').val('')
        $('input[name=cc_email_ids]').val('')
        $('input[name=bcc_email_ids]').val('')
        $('#time-slots').html(`<div class="row mb-5">
                                    <div class="col-md-6 type-2">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6">Time:</label>
                                            <div class="col-9 col-sm-10 col-md-7 col-lg-7 fv-row">
                                                <input id="part-0" class="form-control form-control-lg timepicker timepicker_cor interval timepicker_cor_end cor_time_field_count form-control-solid" placeholder="e.g. 10:10" readonly="readonly" count="0" tabindex="6" name="cor_sale_time[]" type="text" value="">
                                                <span class="text-danger errors cor_sale_time_error" id=""></span>
                                            </div>
                                            <div class="col-1 fv-row p-0">
                                                <button class="btn btn-success btn-icon-only green addRow" data-type="2"><i class="fa fa-plus p-0"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-12 type-2">
                                        <div class="row" id="newRow"></div>
                                    </div>
                                </div>
                            </div>`);
        $(".timepicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            defaultMinute: 5,
            time_24hr: true
        });
    }

    $('.password-protected-sale').change(function () {
        if ($(this).val() == 1) {
            $('.sale-submission-password').fadeIn();
        } else {
            $('.sale-submission-password').fadeOut();
        }
    });

    $(document).on('submit', '.provider_permission_form_sales', function (event) {
        event.preventDefault();
        removeValidationErrors();

        var submitButton = $(this).closest('form').find('button[type=submit]');
        submitButton.attr('data-kt-indicator', 'on');
        submitButton.prop('disabled', true);

        var formData = new FormData($(this)[0]);
        var formName = $(this).closest('form').attr('name');
        var url = '/provider/update';

        formData.append('request_from', formName);

        axios.post(url, formData)
            .then(response => {
                console.log(response)
                if(response.data.status == 200)
                    toastr.success(response.data.message)
                else
                    toastr.error(response.data.message)
            }).catch(error => {
            if (error.response.status == 422) {
                showValidationMessages(error.response.data.errors);
            }
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        }).then(() => {
            submitButton.attr('data-kt-indicator', 'off');
            submitButton.prop('disabled', false);
        });
    });
</script>
