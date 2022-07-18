let validationErrors = {};
$('.submit_btn').click(function () {
    let formId = $(this).data('form');
    let data = new FormData($('#' + formId)[0]);
    data.append('form', formId);
    $('.errors').text('').hide();
    if (validateForm(formId))
        submitForm(data);
});

const submitForm = (data) => {
    let url = window.location.href.replace('/create', '');
    axios.post(url, data)
        .then(response => {
            toastr.success('Details saved successfully.')
        }).catch(err => {
            if (err.response.status == 422) {
                setValidationMessages(err.response.data.errors);
            }
            if (err.response.status && err.response.data.message)
                toastr.error(err.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        });
}

const validateForm = (form) => {
    let errors = {};
    let isError = false;
    switch (form) {
        case 'plan_basic_details_form':
            let name = $('[name=name]').val();
            if (name == '') {
                errors['name'] = 'required';
                isError = true;
            }
            let connection_type = $('[name=connection_type]').val();
            if (connection_type == '') {
                errors['connection_type'] = 'required';
                isError = true;
            }
            let plan_type = $('[name=plan_type]').val();
            if (plan_type == '') {
                errors['plan_type'] = 'required';
                isError = true;
            }
            let cost = $('[name=cost]').val();
            if (cost == '') {
                errors['cost'] = 'required';
                isError = true; 
            }
            let plan_data = $('[name=plan_data]').val();
            if (plan_data == '') {
                errors['plan_data'] = 'required';
                isError = true;
            }
            let plan_data_unit = $('[name=plan_data_unit]').val();
            if (plan_data_unit == '') {
                errors['plan_data_unit'] = 'required';
                isError = true;
            }
            let contract_id = $('[name=contract_id]').val();
            if (contract_id == '') {
                errors['contract_id'] = 'required';
                isError = true;
            }
           
            let inclusion = $('[name=inclusion]').val();
            if (inclusion == '') {
                errors['inclusion'] = 'required';
                isError = true;
            }
            // let details = $('[name=details]').val();
            // if (details == '') {
            //     errors['details'] = 'required';
            //     isError = true;
            // }
            // let dummy = $('#dummy').val();
            // if(dummy == ''){
            //     errors.push({'dummy':'required'})  
            // }
            // errors
            break;
        case 'plan_permissions_authorizations_form':
            if (!$('[name=new_connection_allowed]:checked').val()) {
                errors['new_connection_allowed'] = 'required';
                isError = true;
            }
            if (!$('[name=port_allowed]:checked').val()) {
                errors['port_allowed'] = 'required';
                isError = true;
            }

            if (!$('[name=retention_allowed]:checked').val()) {
                errors['retention_allowed'] = 'required';
                isError = true;
            }
            break;
        case 'plan_term_condition_form':
            let term_title_content = $('[name=term_title_content]').val();
            if (term_title_content == '') {
                errors['term_title_content'] = 'required';
                isError = true;
            }
            break;
        case 'plan_reference_form':
            let s_no = $('[name=s_no]').val();
            if (s_no == '') {
                errors['s_no'] = 'required';
                isError = true;
            }

            let title = $('[name=title]').val();
            if (title == '') {
                errors['title'] = 'required';
                isError = true;
            }

            let linktype = $('[name=linktype]:checked').val();
            if (!linktype) {
                errors['new_connection_allowed'] = 'required';
                isError = true;
            } else {
                if (linktype == 1) {
                    let url = $('[name=url]').val();
                    if (url == '') {
                        errors['url'] = 'required';
                        isError = true;
                    }
                } else {
                    let file = $('[name=file]').val();
                    if (file == '') {
                        errors['file'] = 'required';
                        isError = true;
                    }
                }
            }






            break;
    }
    if (isError) {
        setValidationMessages(errors)
        toastr.error('The given data was invalid kya hai.');
        return false;
    }
    return true;
}

const isBlank = (field) => {
    if (field == '') {
        validationErrors[field] = 'required';
        isError = true;
    }
}

const setValidationMessages = (errors) => {
    $.each(errors, function (key, value) {
        $('#' + key + '_error').text(value).fadeIn();
    });
}