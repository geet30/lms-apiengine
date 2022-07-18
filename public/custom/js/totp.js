const container = document.getElementsByClassName("totp_container")[0];

document.querySelectorAll('.totp_container .form-control-solid').forEach(item => {
  item.addEventListener('paste', (e) => {
    e.preventDefault();
    const text = (e.originalEvent || e.clipboardData.getData('text/plain'));
    if (text.length == 6) {
        for (i=1 ; i<=text.length ; i++) {
            $('.totp_container input[name="totp[' + i + ']"]').val(text[i-1]);
        }    
    }
  })
})

container.onkeyup = function(e) {
    var target = e.srcElement || e.target;
    var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    var myLength = target.value.length;
    if (myLength >= maxLength) {
        var next = target;
        while (next = next.nextElementSibling) {
            if (next == null)
                break;
            if (next.tagName.toLowerCase() === "input") {
                next.focus();
                break;
            }
        }
    }
    // Move to previous field if empty (user pressed backspace)
    else if (myLength === 0) {
        var previous = target;
        while (previous = previous.previousElementSibling) {
            if (previous == null)
                break;
            if (previous.tagName.toLowerCase() === "input") {
                previous.focus();
                break;
            }
        }
    }
}

$(document).on('submit', 'form#twofaFormValidate', (e) => {
    let submitButton = document.querySelector('#submit_button');
    submitButton.setAttribute('data-kt-indicator', 'on');
    submitButton.disabled = true;

    let fields = [1,2,3,4,5,6];
    $('.invalid-feedback').hide();

    let totpArray = [];
    fields.forEach( async (field) => {
        const isValue = $('.totp_container input[name="totp[' + field + ']"]').val();
        if (isValue) {
            totpArray.push(isValue);
        }
    });

    if (totpArray.length != 6) {
        submitButton.setAttribute('data-kt-indicator', 'off');
        submitButton.disabled = false;
        $('.invalid-feedback').show();
        return false
    }
});

$(document).on('submit', 'form#twofaSecurityFormValidate', (e) => {
    let submitButton = document.querySelector('#backup_submit_button');
    submitButton.setAttribute('data-kt-indicator', 'on');
    submitButton.disabled = true;

    let fields = [1];
    $('.backup-invalid-feedback').hide();

    let totpArray = [];
    fields.forEach( async (field) => {
        const isValue = $('#twofaSecurityFormValidate input[name="totp[' + field + ']"]').val();
        if (isValue) {
            totpArray.push(isValue);
        }
    });

    if (totpArray.length != 1) {
        submitButton.setAttribute('data-kt-indicator', 'off');
        submitButton.disabled = false;
        $('.backup-invalid-feedback').show();
        return false
    }
});

