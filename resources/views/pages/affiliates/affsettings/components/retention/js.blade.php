<script>
    var retentionArr = "";
    var retentionAllow = 0;
    var checked = "";
    var userServices = "";
    //gettag data
    $(".providers_div").hide();
    $(".provider_Retention").hide();
    $(".text-danger").hide();

    //get provides according to selected service
    $(document).on('change', '#userservices', function(e) {
        /* if (!$(this).val())
            return false; */
        $(".error_service_id").text("");

        $("#userservices option:first").attr('disabled', true);
        axios.get("/affiliates/getassignedproviders", {
                params: {
                    'service_id': $(this).val(),
                    'user_id': $('#show_apikeypopup').data('user_id'),
                    'user': $('#checksegment').val()

                }
            })
            .then(function(response) {
                var providerArray = response.data;
                var options = '<option value=""></option>';
                $("#rentetion_providers").empty('');
                if (providerArray.length > 0) {
                    $.each(providerArray, function(key, value) {
                        options += `<option value="${value.provider_primary_id}" provider_id="${value.relationaluser}">${value.name}</option>`
                    })
                    $("#rentetion_providers").append(options);
                    $(".providers_div").show();
                } else {
                    $("#rentetion_providers").append('<option value="No provider assigned" selected>No provider assigned for selected service</option>');

                    $(".providers_div").show();
                }
                $(".provider_Retention").hide();
                $(".provider_subaff").hide();

            })
            .catch(function(error) {

                toastr.error(error);
            })

    });

    //get providers status and its affilaite retention status and its assigned subaffiliates.
    $(document).on('change', '#rentetion_providers', function(e) {
        $(".error_provider_id").text("");
        var currentMod = window.location.href.split("?")[1];
        $("#rentetion_providers option:first").attr('disabled', true)
        var subaffiliate_html = '';
        var affiliate_html = '';
        var master_affiliate_html = '';
        var provider_primary_id = $(this).val();
        var provider_id = $(this).find(":selected").attr('provider_id');
        var provider_name = $("#rentetion_providers option:selected").text();
        $("#provider_name").text(provider_name);
        $(".provider_Retention").show();
        $(".provider_subaff").show();
        var parent_id = $("#aff_sub_id").val();
        //subaffiliate
        var subAffArr = {};
        var subAffHtml = '';

        axios.get("/affiliates/providerstatus/", {
                params: {
                    provider_id,
                    'service_id': $("#userservices").val(),
                    parent_id,
                    user_id: $('#show_apikeypopup').data('user_id'),
                    provider_primary_id,
                    currentMod
                }
            })
            .then(function(response) {
                $('input[name="retention_allow"]').prop('checked', false).change();
                $('input[name="master_retention_allow"]').prop('checked', false).change();
                $('input[name="override_provider_retention"]').prop('checked', false).change();

                var RetentionStatus = 0;


                $("#provider_retension").text('No');
                var retensionData = response.data.retention_data;
                var subAffiliates = response.data.sub_affilaites;

                if ($.isEmptyObject(subAffiliates)) {
                    $('#sub_affiliate_setting_h2').hide();
                }else{
                    $('#sub_affiliate_setting_h2').show();

                }
                //sub-affiliates html create sub-aff companyname a/c to provider and service
                $.each(subAffiliates, function(key, value) {
                    subAffHtml += `<div class="form-group">
                          <label class="col-lg-4 col-form-label fs-6 " for="sub_retention_allow">Retention Allow for ${value.company_name}</label>
                          <input type="hidden" name="subaffiliates[${value.user_id}]" value="0"/>
                          <div class="col-md-8 float-end form-check form-switch form-check-custom form-check-solid"><input class="form-check-input subinput disabled" type="checkbox" value="1" id="sub_retention_allow" name="subaffiliates[${value.user_id}]" /></div>
                      </div>`
                });

                $('.provider_subaff').html(subAffHtml);

                $.each(subAffiliates, function(key, value) {
                    if (value.sub_retension_allow !== null && value.sub_retension_allow.retention_allow == 1) {
                        $('input[name="subaffiliates[' + value.user_id + ']"]').prop('checked', true).change();
                    } else {
                        $('input[name="subaffiliates[' + value.user_id + ']"]').prop('checked', false).change();
                    }
                });

                // 13-05-2022 CheckBox Settings for Sub-Affliliates.
                $('#master_retention_allow').change(function() {
                    if (this.checked) {
                        $.each(subAffiliates, function(key, value) {
                            $('input[name="subaffiliates[' + value.user_id + ']"]').prop('checked', true).change();
                        });
                    } else {
                        $.each(subAffiliates, function(key, value) {
                            $('input[name="subaffiliates[' + value.user_id + ']"]').prop('checked', false).change();
                        });

                    }
                });
                // 13-05-2022 CheckBox Settings for Sub-Affliliates.

                $(".provider_retension_href").attr("href", response.data.edit_providerLink);
                //provider retension(resale)
                if (response.data.resale_status) {
                    RetentionStatus = response.data.resale_status.is_retention;
                }
                if (RetentionStatus == 1) {
                    $("#provider_retension").text('Yes');
                    $('#master_retention_allow').removeAttr("disabled");
                    $('#retention_allow').removeAttr("disabled");
                }
                // 12-05-2022 Enable/Disable retention checkbox
                if (RetentionStatus == 0) {
                    $('#master_retention_allow').attr('disabled', true);
                    $('#retention_allow').attr('disabled', true);
                    $.each(subAffiliates, function(key, value) {
                        $('input[name="subaffiliates[' + value.user_id + ']"]').attr('disabled', true);
                    });

                }
                // 12-05-2022 Enable/Disable Retention Checkbox
                $('#override_provider_retention').change(function() {
                    var provider_retension_text = $("#provider_retension").text();
                    if (this.checked) {
                        $('#master_retention_allow').removeAttr("disabled");
                        $('#retention_allow').removeAttr("disabled");
                        $.each(subAffiliates, function(key, value) {
                            $('input[name="subaffiliates[' + value.user_id + ']"]').removeAttr("disabled");
                        });
                    } else if (provider_retension_text == "No") {
                        $('#master_retention_allow').prop('checked', false);
                        $('#retention_allow').prop('checked', false);
                        $('#master_retention_allow').attr('disabled', true);
                        $('#retention_allow').attr('disabled', true);
                        $.each(subAffiliates, function(key, value) {
                            $('input[name="subaffiliates[' + value.user_id + ']"]').prop('checked', false);
                            $('input[name="subaffiliates[' + value.user_id + ']"]').attr('disabled', true);
                        });
                    } else if (provider_retension_text == "Yes") {
                        $('#master_retention_allow').removeAttr("disabled");
                        $('#retention_allow').removeAttr("disabled");
                        $.each(subAffiliates, function(key, value) {
                            $('input[name="subaffiliates[' + value.user_id + ']"]').removeAttr("disabled");
                        });
                    }
                });
                // 12-05-2022 
                if (retensionData.override_provider_retention == 1) {
                    $('input[name="override_provider_retention"]').prop('checked', true).change();
                }
                if (retensionData.master_retention_allow == 1) {
                    $('input[name="master_retention_allow"]').prop('checked', true).change();
                }
                if (retensionData && retensionData.retention_allow == 1) {
                    $('input[name="retention_allow"]').prop('checked', true).change();
                }
            })
            .catch(function(error) {

            })
            .then(function() {

            });
    });


    $(document).on('click', '#save_retention', function(e) {
        e.preventDefault();
        $("#retention_user_id").val($('#show_apikeypopup').data('user_id'));
        var formData = new FormData($("#aff_retention_form")[0]);
        var action = $('#aff_retention_form').attr('action');
        formData.append('provider_primary_id', $("#rentetion_providers option:selected").val());
        formSubmitRetention(action, formData);
    });

    function formSubmitRetention(action, formData) {

        $(".text-danger").text("");
        var checkAction = formData.get('action_form');
        let submitButton = document.querySelector('#save_retention');
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        axios.post(action, formData)
            .then(function(response) {

                if (response.data.status == true) {
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function(error) {
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        console.log(errors, "Dfdfd");
                        $('.feild-holder').find('span.error_' + key).empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                } else if (error.response.status == 400) {
                    console.log(error.response);
                }

            })
            .then(function() {
                submitButton.setAttribute('data-kt-indicator', 'off');
                submitButton.disabled = false;
            });

    }
    $(document).on('click', '.retentionsales', function(e) {
        $(".providers_div").hide();
        $("#userservices").val(1).change();
    });
</script>