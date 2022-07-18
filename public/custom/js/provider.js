jQuery(document).ready(function () {

    $('#search_providers').keyup(function () {
        dataTable.search($(this).val()).draw();
    })
    $('#add_provider_close, #discard_btn').click(function () {
        $("#add_provider_modal").modal('hide');
    });
    $('#add_tele_sale_button').click(function () {
        let teleSaleState = $('#select_tele_sale_state').val();
        if (teleSaleState == '' || teleSaleState == null) {
            toastr.error("Please select state");

        } else {
            $('#add_provider_tele_sale_setting_checkbox').modal('show');
        }
    })

    $(".resetbutton").on('click', function () {
        $('#provider_filters')[0].reset();
        $('#service').prop('selectedIndex',1).trigger('change');
        $(".status_filter").val('').trigger('change');
        $("#apply_provider_filters").trigger("click");
    });
    $('.edit_post_sub').click(function () {
        let editVal = $(this).attr('data-required_checkbox');
        checkPostSubmissionCheckboxStatus(editVal);

    });
    function checkPostSubmissionCheckboxStatus(value) {
        if (value == 1) {
            $('.post_sub_validation_msg').show();
        } else {
            $('.post_sub_validation_msg').hide();
        }
    }
    $('input[type="radio"][name="post_submission_checkbox_required"]').click(function () {
        let postCheckValue = $(this).val();
        checkPostSubmissionCheckboxStatus(postCheckValue);
    });

    $('#apply_provider_filters').click(function (e) {
        e.preventDefault();
        pageNumber = 1;
        getFilterData();
    });
    let directDebitStatus = $('input[type=radio][name=direct_debit_status]:checked').val();
    function checkDirectDebitStatus(val) {
        if (val == 1) {
            $('.payment_method_hideable').show();
        } else {
            $('.payment_method_hideable').hide();
        }
    }
    let identification_detailss = $("input:radio.secondary_identification_details:checked").val();
    if(identification_detailss == 0){
        $(".optional_second_ids").addClass('hideSecOption');
    }  
    let billingAddress = $("input:radio.billing_address:checked").val();
    if(billingAddress == 0){
        $(".billing_address_dropdown").addClass('billing_address_hidden');
    }
    let deliveryAddress = $("input:radio.delivery_address:checked").val();
    if(deliveryAddress == 0){
        $(".delivery_address_dropdown").addClass('delivery_address_hidden');
    }
    checkDirectDebitStatus(directDebitStatus);
    let creditStatus = $('#creditCardCheckbox').is(':checked');
    if (creditStatus == false) {
        $('#creditDebitStatus').hide();
    } else {
        $('#creditDebitStatus').show();
    }
    let bankStatus = $('#bankCheckBox').is(':checked');
    if (bankStatus == false) {
        $('#bankAccountStatus').hide();
    } else {
        $('#bankAccountStatus').show();
    }

    $('input[type="checkbox"][name="payment_method[]"]').click(function () {
        if ($(this).is(':checked')) {
            if ($(this).attr('value') == 1) {

                $('#creditDebitStatus').removeClass('d-none d-block');
                $('#creditDebitStatus .d-none').removeClass('d-none');
                $('#creditDebitStatus').show();
            } else if ($(this).attr('value') == 2) {

                $('#bankAccountStatus').removeClass('d-none d-block');
                $('#bankAccountStatus .d-none').removeClass('d-none');
                $('#bankAccountStatus').show();
            }
        } else {
            if ($(this).attr('value') == 1) {

                $('#creditDebitStatus').removeClass('d-none d-block');
                $('#creditDebitStatus .d-none').removeClass('d-none');
                $('#creditDebitStatus').hide();

            } else if ($(this).attr('value') == 2) {

                $('#bankAccountStatus').removeClass('d-none d-block');
                $('#bankAccountStatus .d-none').removeClass('d-none');
                $('#bankAccountStatus').hide();
            }
        }

    });
    // $( ".payCheckbox").click(function(){
    //     if ($('.payCheckbox:checked').length==1) {
    //         if($(this).attr('val')==1){
    //             $('#creditDebitStatus').show();
    //         }else if($(this).attr('val')==2){
    //             $('#bankAccountStatus').show();
    //         }else if($(this).attr('val')==3){
    //             $('#creditDebitStatus').show();
    //             $('#bankAccountStatus').show();
    //         }
    //     }
    // });


    $('.alert_checkbox_button').click(function () {
        checkDesc();
    })
    function checkDesc() {
        let descValue = $('#acknowledgment_content').val();
        if (descValue != '' && descValue != null) {
            $('#add_provider_ack_checkbox').modal('show');
        } else {
            toastr.error('Acknowledgement Content is required');
        }
    }
    $('#termTypeId').val($('#terms_and_condition_title option:selected').text());
    $('#termTypeId').attr('termId', $('#terms_and_condition_title').val() ?? 0);
    $('.add_checkbox_button').click(function () {
        checkTermCondDesc();
    });
    function checkTermCondDesc() {
        let descValue = $('#term_description').val();
        if (descValue != '' && descValue != null) {
            // let val=$('#terms_and_condition_title').val();
            $('#termTypeId').val($('#terms_and_condition_title option:selected').text());
            $('#termTypeId').attr('termId', $('#terms_and_condition_title').val() ?? 0);
            $('#add_terms_condition_checkbox').modal('show');
        } else {
            toastr.error(' Please fill rest fields');
        }
    }

    let dataTableList = $(".provider_datatable")
        .on('draw.dt', function () {
            $('.form-check-input.main').prop('checked', false);
            KTMenu.createInstances();
        })
        .DataTable({
            columnDefs: [
                { "orderable": false, "targets": 0 }
            ],
            searching: true,
            ordering: true,
            "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        });

    $('#search_contacts').keyup(function () {
        if (dataTableList !== '')
            dataTableList.search($(this).val()).draw();
    });
    $('#add_statewise_checkbox_button').click(function () {
        let stateValue = $('input[type=radio][name=eic_type_checkbox]:checked').val();
        console.log(stateValue);
        let stateType = $('#select_consent_state').val();
        let stateContent = $('#statewise_consent_content').text();
        if (stateValue == 'state') {
            if (stateType == null || stateType == '') {
                toastr.error("Please add state");
            } else if (stateContent == null || stateContent == '') {
                toastr.error("Please add content");
            } else {
                $("#add_provider_state_eic_content_checkbox").modal('show');
            }
        } else if (stateValue == 'master') {
            if (stateContent == null || stateContent == '') {
                toastr.error("Please add content");
            } else {
                $("#add_provider_state_eic_content_checkbox").modal('show');
            }
        }
    });


    $(document).on('click', '.add-contact-button', function () {
        $('#add_contact_form').trigger('reset');
        CKEDITOR.instances.contact_description.setData('');
        $('span.error').empty();
        $('.modal-title').text('Add Contact');
    });

    $(document).on('click', '.edit-contact-button', function () {
        $('.popheading').text('Update');
        var myModal = new bootstrap.Modal(document.getElementById("add_contact"), {});
        myModal.show();
        var id = $(this).data('id');
        $('span.form_error').hide();
        $('input[name=contactId]').val($(this).data('id'));
        $('input[name=contact_name]').val($(this).data('name'));
        $('input[name=contact_email]').val($(this).data('email'));
        $('input[name=contact_designation]').val($(this).data('designation'));
        CKEDITOR.instances.contact_description.setData($(this).data('desc'));
        $('.modal-title').text('Edit Contact');
        $('span.error').empty();
    });

    function getFilterData(type) {
        processing = true;
        let myForm = document.getElementById('provider_filters');
        let formData = new FormData(myForm);
        formData.append('request_from', $('#provider_filters').attr('name'));
        var url = '/provider/list?page=' + pageNumber;
        axios.post(url, formData)
            .then(function (response) {
                var html = '';  
                dataTable.destroy(false);
                $('#providerbody').html('');
                if (response.data.providers.length > 0) {
                    processing = false;
                    $.each(response.data.providers, function (key, val) {
                        checked = '';

                        if (val.status == 1) { checked = 'checked' }
                        editurl = `/provider/edit/${val.id}/${val.service_id_encrypt}`;
                        viewurl = `/provider/view_ajax/${val.id}`;
                        deletewurl = `/provider/delete/${val.id}`;
                        settinggurl = `/provider/link-provider/${val.id}`;
                        assignedhandsets = `/provider/assigned-handsets/${val.id}/list`;
                        moveinurl = `/provider/movin-details/${val.id}`;
                        salesubmissionurl = `/provider/sale-submission-details/${val.id}`;
                        assignuserurl = `/provider/link-provider/${val.id}`;

                        electricity_logo = `/provider/plans/energy/electricity/list/${val.id}`;
                        gas_logo = `/provider/plans/energy/gas/list/${val.id}`;
                        mobile_logo = `/provider/plans/mobile/${val.id}`;
                        broadband_logo = `/provider/plans/broadband/${val.id}`;
                        lpg_logo = `/provider/plans/energy/lpg/list/${val.id}`; 
                        var appPermissions = response.data.appPermissions;
                        var userPermissions = response.data.userPermissions;

                        html += `
                                <tr>
                                    <td>${key + 1}</td>
                                    <td><span>${val.userid}</span></td>
                                    <td class="text-capitalize"><span><a href="#" data-bs-target="" id="view-provider" data-url=''>${val.name}</a></span></td>
                                    <td>
                                        <span><a data-fancybox="gallery" href="${val.logo}" data-toggle="tooltip" title="Logo"><img src="${val.logo}" width="32px" height="31px"></a></span>
                                    </td>
                                    <td>`;
                        if(checkPermission('provider_change_status',appPermissions,userPermissions))
                        {
                            html += `
                                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input sweetalert_demo change-status" type="checkbox" value="" name="notifications" ${checked} data-id="${val.id}"></div>`;
                        }
                        else
                        {
                            html += `--`;
                        }

                        html +=    `</td>
                                    <td>`;
                        if (val.service_id == 1  && checkPermission('show_energy_plans',userPermissions,appPermissions)) {
                            html += `
                                        <a class="btn-circle btn-icon-only btn-default" id="plans" title="View Electricity Plans" href="${electricity_logo}">
                                        <span style="color:orange;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" viewBox="0 0 512 512"><defs>
                                        <style>
                                          .cls-1 {
                                            fill: none;
                                            stroke: #599df4;
                                            stroke-width: 13px;
                                          }
                                        </style>
                                      </defs>
                                        <image id="lightbulb" x="42" width="428" height="512" xlink:href="data:img/png;base64,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"/>
                                        <rect class="cls-1" x="6" y="6" width="501" height="499" />
                                        </svg>
                                        </span>
                                    </a>
                                    <a class="btn-circle btn-icon-only btn-default" title="View Gas Plans" href="${gas_logo}">
                                        <span style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" viewBox="0 0 512 512">
                                        <defs>
                                        <style>
                                          .cls-1 {
                                            fill: none;
                                            stroke: #039ef7;
                                            stroke-width: 13px;
                                          }
                                        </style>
                                      </defs>
                                        <image id="gas" y="27" width="512" height="458" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAHKCAYAAAB14/O1AAAgAElEQVR4nO3dB5QlRfXH8d/CwpJzXHIOIlEyKpJzEpCsKAaCEgRBEBEElSCgqKiISPiLZJYgSAbJSXLOWXJawsLu/k/JHZ1dJryZd2+/qu7v55w5guxWV1e/eX27uureIVuf+K4AoAOGSFpT0paSVpI0j6Rhkl6SdLekSySdJul1Lg7gjwAAQNWmkPRVSd+VtFA/x35H0mGSjpI0misF+JmAsQRQkfkkHS3pOUm/aeHmn0wp6ReS/mH/DMAJAQCAaEtLOl/SI5L2lDT1II63uqSLJU3M1QJ8EAAAiPIZSedIul3Sxg7fN5+XdChXC/BBAADA2wK2eO8eSZvZYj8ve0ianysGtI8AAICXmSSdIOkBSdsGfb9MJGkXrhjQPgIAAO1K3yM72I1/J0lDg0d0Y64Y0D4CAADtSPv375B0sqTpKxrJeSs8FlBbBAAABiNN958k6XpJS3ZgBIdz1YD2RE/VAaiftLDv95Jm7OCZjeVzBbSHGQAArZpK0h9sa18nb/7JCx0+PlA8ZgAAtOJLkv4iac4MRutF6gMA7WMGAEBfhln63isyufknt2XQB6B4zAAA6M3sks6StEJmI3RrBn0AiscMAICepNz7d2Z485elFgbQJgIAAN2ltL27S7o0g4V+vbknz24BZeEVAIAuqdzuKZI2yXhE3rJFgADaRAAAIJlV0kVWujdnD3C1AB8EAAAWk/R3SXMUMBKPZtAHoBZYAwA0W9rf/89Cbv7J0xn0AagFAgCgubawJ/9pChqBZzPoA1ALBABAM6WV/mdImqSws38ugz4AtUAAADTP3pKOtS1/pXmFzyvggwAAaJZ9JR1Z8BlTAwBwQgAANEe6+f+i8LN9I4M+ALVAAAA0w2E1uPkn72bQB6AWCACA+ktP/vt34Cxfc25vjKSPnNsEGosAAKi3HST9vANneEVAIaEPndsDGo0AAKivlNP/zxWv9h9luwzWCtizz9M/4IhUwEA9rSrpdEkTVnh2T0naRtJN9u+jndvngQVwxC8UUD9LSBpRcZKfUyUt3u3mr4AAYCLn9oBGIwAA6mUGSedKmqqisxor6WBba/BOD/9trOOxmLEEHPELBdRHeuK/QNK8FZ3RB5J2lPS3Pv7MaMfvmfQ6YzJJ7zm1BzQaMwBAPaSFfidIWrGis3lR0ir93PwVsHBvBuf2gMYiAADq4YeStqvoTO61LX53tPBnvTP3EQAATggAgPJtKOmnFZ3FVZJWlvRMi3/eu3jPjM7tAY1FAACUbQ5JJ1X0u3yZpA16WOzXl1ed+0AAADghAADKNZG9g5++gjO41BILvT/Av+c9A8ArAMAJAQBQrsMlrVRB7y8a5M1fzAAA+SIAAMqUpuL3qKDnF0vavI08/N4zAHM7twc0FnkAgPLMKemUCnL8p2n/Tdvcyvdvx/4kizi3BzQWMwBAWdJN/4+Spg3uddrit4XDPv7HnfrTZSG+twAf/CIBZdlV0trBPX7SXjG869DWow5tdJcyAc7u3CbQSAQAQDnmraC2f1q0t66kl5zae9ZSBnviNQDggAAAKMMEtt9/isDeplX+G0t62LHNMZKecGwvWdi5PaCRCACAMuwp6QuBPR1rqYRvDGj7Eef2FnVuD2gkdgGgJDNb2dn1JX1W0nSSPra0tOmp9XZJt9mP1xR2DuaSdEhwPw63MsIRHnNuc/mgfgKNQgCAEkws6UeSvm+LwLobau/G57V3113us21s/5D0zzb2sefgVz2ct6fLbXyjPODc7mKSppb0Vu4XDsgZrwCQu5Tm9hpJBw7wJphuEnvbze01SSMkbStpysKu+Ab2Xj7K05K2sbr9UW5zbndCq0YIoA0EAMjZZPYE326N+8klbSTpNEtMc7qk1SpIpNOuSSX9OrD9tDr/ywHpesf3oKSRzm2u7Nwe0DgEAMjZUZKWce5fuqluJelKW5y2j6RpMh2DAyTNE9j+7i3W9G9Xml2407lNAgCgTQQAyNXikr4T3Lf5JR1hiwiPDb7ZDtTc9gojyoWWUbAq3q8BlmcNE9AeAgDk6nsVTtFPaU/DaUbgxEwKzhwqaVhQ26lAzzeD2u6NdwCQXut8zrlNoFEIAJCjIcEL33qTnii/blsKfydpeIfGJr322Dqw/W8FFOnpj3cAINsOCmCQCACQo7TvfYYO9ittO9zZAoH9Ap/Ee3NE4O9myiZ4flDbfUlFgZ53bnMD5/aARiEAQI5myaRPU1ju/fttF0EV1rMdChGekrRHx0ZTusq5vSUkzeHcJtAYBADIUW7b8+azPAJnSZop8DjpvH8W2P5ukt4ObL8/Vzi3N4TXAMDgEQAgRy9k2q/NbTYg6v38RvZUG+E8SRcHtd2qKwPa5DUAMEgEAMhRyk73cqZ9S2sT/irpHEnTOrd9gHN7XUZ2eOq/y/OWFMjTasFpkoHaIgBArs7L/MpsZsltvArTrC1pWae2xneI5TrIgfcswKS2bgLAABEAIFenFXBlUr6A66xUb7vrFqKK8aRXFscEtT0Ylwe0uW18t4H6IQBArm4IKCMbIW0ZPFrSGfY0Ohipzv8qQf1LU/8fdWx0Pu2KgLoA61lpaAADQACAXI2VdHZBV2cLq1o4mC2Mewb0R/a07b3yvl3vWYEnTxPb+AMYAAIA5GxEYVdnOUm3S1pyAH9nTkkbBvQlBVA/DGjXQ8T6Dl4DAANEAICc3ZrxlsDezGYzAau2+Od3sfr23s6qqNLfYFwkaZRzm6tkVswJyB4BAHI2RtIFBV6hqW3P/Zr9/Lm0ZmCngON/FLio0MObkq52bjMtwtymM6cDlIkAALnrRN56D5NZ8NJXprp0w5o+4Ngp3/+jcafmIuI1wDf4TgNaxy8LcnetpA8KvUqTSDpX0qa9/PdvBBxztBUTyt25AbsT0iuAdQs4dyALBADIXbr531jwVZrYtgiuM97/v4CkFQKOd5ZV3svdK5IuDejjzgWcO5AFAgCUwPt9cdUmstTBK3Y77vZBRY+OzHMIenRqQJvrshgQaA0BAEpQegAgWxMwwp78041/u4BjXGrpiUuR1ki84dzX9J327YLGAOgYAgCU4I6AbWMfd+C8Z7Sb9BZBT6mHB7QZ6UN7PeLt65KGFTYWQOUIAFCCtA7gLud+Xibpex2ojz+vVRP09oDlHyjNKQH9TYHWlgWOBVApAgCU4mbnfi4k6ThJn+nAVsOIxD8nBLRZhXRdHwk4zt5BayyA2iAAQCluce7n3LZN7znbppf25L9T6Kfhg6An6SqklMV/CDjO4lZiGUAvCABQirud+5mewhfs9u+n203DO9CoQiqa9HqB/e7yZysS5G2fjp8ZkDECAJTikYCFgIuM9+9PSfqipN8W9qn4UwZ9aMebQYsBV5O0bHWnAZSFAAClSFnjHnbu6/gBgGxl+m62kjynOvq9eVbSdXl2bUCOC2qXWQCgFwQAKMm9zn3tKQDocpLl8c99XcBZ9h69dP+y6o/eNrPcCwDGQwCAktzv3Nf+bgyXS1pd0r8zHqOzM+iDl+MD2pyQWQCgZwQAKMkTzn2dtYU/c5vVmn8+w3F6LmB7ZCf9LSjY+prt+gDQDQEASvKkc19nkjS0hT/3mNX2fyWzsTqnJtP/XT4IWoCZajEcENAuUDQCAJTkaee+TmBBQCselLRGZtvtIqrpdVoKAN4N6MNXLQsjAEMAgJL8O2C/eCuvAbrcYwsDI25QA5V2KFyfQT+8pQDrLwHtplmA/Tt7akBeCABQkrEBswDDB/jnb7Y882M6PG63ZhKIRDhG0uiAdndgFgD4HwIAlOZF5/4OZAagyyWSftzhcbuqw8ePlBZ7nhvQfpoF+FE+pwl0FgEASvOac38HEwAkP+tAEaHuru3gsatwZNAxtpe0cF6nCnQGAQBK4x0AzDLIvzfWFpY95NyfVnmXR87NbUGLHIda8AY0HgEASuMdAEzVxt992zLNVZ0t8PmAccjRIUF92kTSCmUPDdA+AgCUxvvGN0Wbfz9tD/yBU19aVfen/y43SboioN0hko4IaBcoCgEASuO9D39KhzZSPftrHNpp1X0VHqvTomYBPm9bOoHGIgBAad537u/kDm2MteqBIx3aasUzFR0nB/8MDK5+zncgmowPP0ozyrm/kzq1k9IUH+TUVn9yS0kcLWoW4LOStsvnNIFqEQCgNB8793dCx7ZSApsbHdvrzUsVHCMnVwfmPfiZwzoQoEgEACjNR879baUYUKtSdsBdK8gS+Gpw+zmKKuYzm6R9yx4aYHAIAFAa7wDAcwZAtkL/ZOc2xzckuP0cpRTMFwT1a2/KBaOJCABQmtwDAFm62cgFgRMHtp2zHwXNrkwi6fD6DBPQGgIAlMb76dd7TUHygqRfB7TbpakBwL2STg9qewvbGgg0BgEASjOZc3+9dxV0+WVghsDBpi+ug58EzALJAstj+U5Ek/BhR2m8A4APg84/ZSw8Lqjtzwa1W4LHJJ0Q1M+lJe1Yr+ECekcAgNJ4JO7pLmoGQLYt8L2AdpscACQHB86uHNZmfQigGAQAKE0pMwCy7XqnBLTb9ADg5cBFezMHbjkEskIAgNJ4BwBvBZ//sQEr1xds8ELALsdYVcQIu0uav+NnCAQjAEBpvF8BvBl8/g9LusS5zaEBgVBp0quVA4P6PEzSUfUdOuATBAAozYzO/Y2eAZBVC/QW+eqiFOn1yj1Bfd1Y0ur1GzLgfwgAUJrZnPsbPQMgmwHwnK5+OqAqYolGWxa/KMc6p4oGskIAgNJ4BwBvVHD+KdnQnx3bu8GxrdJdHpgieDFJOzdnKNE0BAAozXDn/r5Q0fn/wXHa/iSndupir8BXIofYzgCgdggAUJL0eZ3Vub9RK8l7Oo7Hjfs2SVc6tFMnj9uugAjTSDqi6QOMeiIAQElmkjSRc3+rmgFI9pf0ZBt//0PLVDfWsU91ker6vxh0LttTJwB1RACAkni//x9b4QyAbL3BZoOs55/y328l6f6AftVBygy4X9B5pDoBv2FBIOqGAAAlWci5rylf/wcVn/9dklaR9OAA/s5LkjaSdH5gv+rgVEk3B53H4pJ2a9Zwou4IAFCSxZz7+liHzj0lB1rSnlj7moF4295tp5vPpRX2r1RjLYufd+bFLgcHrEEBOoYpLZTEOwf+ox0891GWz/4oe7+8tKWfHWWvCG6XdL2kdzvYxxLdagmCvhbQ91Qk6EhJ29V/GNEEBAAoyeLOfe1kANAlJbO5xn7gI82sbCpp6oDx3FbSiZKu5lqhdLwCQCnSl/kczn3NIQCAv3/broAovwnYjQJUjgAApVjMVmN7IgCor2MDr++ittYAKBoBAErh/f4/ped9gKtfW2ktxfcDT+7HAdtSgUoRAKAUSzv382EK6tTehZIuCjrJKSX9sukDjLIRAKAUqzj3806ufCPsHhjofYWSwSgZAQBKMIOkhZ37SQDQDE/Ydssov5M0rOmDjDIRAKAEKwUsALyLK98Yh1vBoAgLSvpe0wcYZSIAQAlWc+7jaGYAGuWD4Js0CwJRJAIAlGAt5z7eY2l20Rx/D6ylMIVldASKQgCA3KUnq0Wc+/hPrnojpVmAkUEnvlXATBUQigAAuVs7oH/Xc9Ub6dngDIHHkSEQJSEAQO42DugfAUBzpan6h4LOflEWBKIkBADI2eSS1nTuX0oP+yJXvbFGBd+kD5I0vOmDjDIQACBn60ia1Ll/1NXH5ZLOChqFKa1kMJA9AgDkbNOAvl3CFYekvSS9GzQQW0talUFG7ggAkKs0/b+Jc9/ep+4+zHOSDgkajCG2IHAog42cEQAgV5taEODpKgoAoZtfSXowaEBS+ervMtjIGQEAcrVtQL+Y/kd3o4Jv0gezIBA5IwBAjtKX5hrO/Rpr5WGB7q4MXhB4BKONXBEAIEc7Bbw/vUnSM1xt9CByQeA2LAhErggAkJsJJX09oE9ncKXRi7Qg8LCgwUkLAn9DhkDkiAAAudlA0lzOfRoj6WyuNPpwdGCGwM9I2oXBR24IAJCbiC/K6yS9wJVGH9KCwN0DBygtCJyFC4CcEAAgJ4sHpP4V0/9o0WWSzgkarKltlgHIBgEAcrK3vTP19IGkM7nKaNGegSWDtw4qbgUMCgEAcpHq/n8loC9pi9frXGW0KJUM/nngYP1O0jRcDOSAAAC5OEDSxAF9OYErjAE6yqpGRhgeuOMAGJAhW58Ytf0VaNlSkm6zLYCeHrQa7U03v6RFJE1ii90ek/SAJUdCz9YJzByZdqV8QdINjD06iWIV6LSuwineN381/Ok/TTPvakmV5u7hv78k6VRJx0h6sQP9y10qG31+QEEq2cxr+swvK2l0vYYNJeEVADpte0krB/QhLf47paFXd2Pb035oLzd/2Za0fezPfafi/pUiLQh8L6ivSwUlvAJaRgCATppK0uFBxz9Z0msNvLrfk3SepJlb/PPpGhwv6W+Wux7/85SkXwSOx6EsCEQnEQCgkw4KSo4ypqF7rr8s6dhBbqVMOzBut1wM+J8jbc1EhJkk/ZixRqcQAKBTUrrf3YKOfYGkRxp2ZaeX9Mc28ygsKOlmpqbH8UFwhsDdbJEmUDkCAHTKgUHb/mRPbU2T3udP53DOk0o6UdJfJE3WwHHsyd8ljQhqeyJmAdApBADohAUkfTXouDfaT5NMGDCeqb1bJM3TsLHsTXpSfyuo7W1smyZQKQIAdMJBgVtQIxdt5WqxoLUUi9krgRXrMUxtSSWD9w1qe0IrFgRUigAAVUulUbcKOuZVki5s4BX9TGDbM9m4Rl2zkqQ1FtcG9XdzSUvWc9iQKwIAVO0nQUl/PrItcE3k8e6/LymD4F9t3YZ3saaSpMyJ35T0fkCfh1g6bKAyBACo0kKSNgs63q8l3d/Qqzl1BcdIN6hDLL/CsAqOl6tHA3NXbCppvvKHCKUgAECVdg/6zL3Q8Heos1V4rJS58fKGJ7A5QtLTAe1OaNkHgUoQAKAq00raIehYaQvcOw2+kktUfLzP27qAGSs+bi7SK4AfBPVlR0kzlDckKBEBAKqSitJMHnCs6yWd3uCrmFL+Lt+B4y5lC+KGd+DYOThT0nUB/Ui5F3YpbzhQIgIAVCFNbe4cdJwDG17W9stBiypbsYiVtG1qJru9gz57O1uCICAUAQCqsGlQQpkrJF3T8CsY9VqlVXPbNVi4w/3ohNskXRxw3JTTYf38Tx+lIwBAFaLKzR7Y8Ku3SYem/8c3m70OaOI+9h8HzQJ8M6BNYBwEAIg2p6QvBRzjYstS11Rp2v+wjM59JpuR+WwGfanSvySdE3C8tSXNke9pow4IABBtu6DP2UENv3J7SVo0g350lyoSXma1HpokIv10CvC+0bBxRMUIABAt4h11eud8R4Ov3NKSDs2gHz2ZxWYC5syva2HSZ/HqgMa/2vDMiwhGAIBIK1j2P2/HNviqpW1i/xdYStnDnBYERBQoytVRAf1KCyyXq8fwIEcEAIgU8fT/WEML/sh+X08pZMX9AvY6ILpOQS4ukXRfQF+2LHM4UAICAESZwLb/eUs5/8c09Kodafv+S5EWBF4qacqC+jxYaSfA8QHtbsFrAEQhAECU5QOmgEdK+ktDr9hutvCvNMtKOkPS0AL7PlCpYuJ7zm2mnQArxXcdTUQAgCgbB7R7TkNz/qdXKb/KoB+DtW5D1m28KemsgHY3D2gTIABAmE0CGm7i03/68j+xBr+ru0r6Xgb9iPangPbXzesUURcEAIiwcMDq/6cs21yTbG6FjiKnzz+Q9HFFY3q0pA0qOlanpOJUjzsfO/0uzVvOEKAUBACIEPElf0rDFv9tY++Uo9+d/9QWmn0YfBxZcpvTG5Ay+MyANtcJaBMNRwCACBGpfyPereYqlYM9tYKKcA/Y/vXzJW0UsICtJ1PYNs46lxE+I6BNAgC4IwCAt/TEuopzm48G7bHO0QGSflvB7+ZYKzs7yv79Mss//1YFYzK7pLNrXPL2bkkPO7f5pcyTP6FABADwtpSkqZzbPL8BV2mIPY1XleI3vY+/brz/L72/XkPSaxUcf0XLa1BXZzufV5o5WabG44UOIACAt1UD2qx7ADChrR7/fkXHu1PS/r38t9slrVZRELC7rT+oo0sCzol8AHBFAABv3gHAyzUv+zvM3hl/vaLjvWsLDEf18Wfusa1nb1fQn7TFccEKjlO1WywvgKeVazhO6CACAHgaEvCUcnWNV/9PbgviqkrvO9aSCrXyfvo2280RvTBwSpsunyz4OFX72AoieWIGAK4IAOAp7VWexrnNiDKrOZjebhBrVtiXn0g6bwB//p+SNqtgi2CqGfD74GN0wqXOx5xZ0vxlnDpKQAAAT0sFjOY1NbxCs9sCvBUqPOYZtud/oP4haesKkgVtL+lrwceo2viLLD1QHhhuCADgaWnn9l4M2E7VaSlL4g2SFq2wH9fYzXXsIP/+ebZlMFqqdzBXBcepStq++pLzsRbL93RRGgIAePKeAYh4guqkZW1afc4K+3CX1WX4oM12/mTbFCOl7aMn1ex7yXsB62ed20ODEQDAk3cAcEeNrk5613+VpBkqPObDtprfK7nPvlaRMdKXalY06Ebn9ggA4IYAAF5mtEVKnu6sydVJRX0usmQuVXnIbqaeU9Bj7F199LbMn0laJPgYVbnN+Thp9mjqfE8XJSEAgBfvamXpffW/anB1trICOFWmcX3Abv4vBrT9vqSNrTpjlEmt+FMdUgXf69zekIrXj6DGCADgZT7nkXxa0uuFX51tJZ1WQUW/7u63TH7ei8+6e9lyF7S7rqAvn7O6CKVLGRVfcD4H7981NBQBALx4fyndU/iVSQl3TrY0v1W5127+/67geHda1cJIP7RdE6XzngWYuwZjggwQAMCL9yuAxwu+Ml+31exV3vzvspv/yxUeM53jHwPbT69NfmfT3iXzrmRJAAAXBADw4p2h7LFCr8xOkk6o+HfrFqvi92qFx+yym+U1iPIle5VSsied+16nXAnoIAIAeJndeSSfKPDKfNueiKv8vbrQbpJVVO/ryUdWXChyvUbKPzBtYPvRvAOAefI7RZSIAABeZnQeydICgG07MF19iuXqf7/CY/bkGQt+osxsWwNL5b1jYnjBY4GMEADAw2RW2c7TMwVdmQ06kMHuaEvvG52jv1Vn2xhE+Zak5TM514F6uo00zD2ZtIbVE9EBBADw4J3d7u3gLWaevijpzAr3rI+11fHfd76peNg9cPFm+q76baHfWSMdszF2md65PTQQAQA8zOQ8iq8UclVStrrz7YmsCqMlfUfSLzp72r16xxIffRTU/jLWfom812gQAKBtBADw4D0D0InV7AOVgp6LJU1T0fE+sJTCkdvuPNwu6eeB7R8qaVh1p+OGAADZIQCAB+/c5LnPAKQn/hEVrsZO08dr22xDCQ6zdMQR5qmoNLE37wBgus6fEkpHAAAP3k9kb2Z8VdIq/79IWqGi471k6wxKKo08yvIhjAlq/4ACC+J4b5Os6rUTaowAAB68C918mPFVSYvvtqzoWGlB3cqS7q7oeJ5usm2REWaw0sQl8d6qWWVxKdQUAQA8TOI8irkGAKsGv9/u7mF78i8xIVKX/SU9G9T2HpLmCGo7wijnNgkA0DYCAHjw/jLy/rL0MJukv1VU2e8+u/k/X8GxIr1jqYIjpCnw/QoaC++gtsSFkMgMAQA81P0VQCrqc4ZlpIt2l6X2raKiXxUukPSPoOPsWNE18cAMALJDAAAP3lXvohaPDda+9i4+WtpCt3oh2yAHYs+g3ACTWtsl8P5M892NtvEhggfvL/cqptlbtZSkgyo4zu221S+yqE6nPBi4IHDnCnMxtKMp62RQEAIAePCe3szl/WZ6wjytgunWW+3Jv443/y4HB81sTCVp14B2vXkHADmuk0FhCADgoa7vN38qadHgY9wraV2rf1Bnb0j6SdD57V5AcRxmAJAdAgB48H4FkMMMwBJ2Y4n0qKS1av7k390JAbXxZaWodwpo15P3Z5oZALSNAAAevJOcTNvhq5J+L44PXovwsqR1LNNfU6Sb1iFB5/q9zL/PvDP3MQOAthEAwMMbzqPY6Tzn6WlyxcD2U8C0SeFJfgbrVFsU6G0+SWtkfN4zOreXc7psFIIAAB68p7A7GQDMEJztL20H29ZS5TbRaFsQGOE7GY+nd8nsprw2QiACAHjwngHoZKnTHwYHIOnmd15g+yU4S9I9Af3cUNLwTM/fO2FR3XJFoAMIAODB+2kkPS1N1IErMzy41OwFVs++6dIsyJEBYzA008WAkwRULyQAQNsIAODhdedMZxN26EnuJ4FlVh+RtEOGWQ47JaVWfibg2DsFZKZsl/f0/0dWZwFoCwEAPHws6UXnkZyr4iuzoOWWj5BWv28j6a2Kzyln6SZ2bED/UoXA9TM77zmd23tF0ljnNtFABADw4l321ftLsz8HBG77S6mE7whqu2R/Clg/kmyf2Zgs5Nze087toaEIAODFOwCYv8IrM6ukrYLavlbSEUFtly5NY/8h4BzWkzRFRmPjHQBEJFNCAxEAwIt3ABCdgre73YLSD6dkLd/mvX+fjretgZ4msx0BuSAAQJYIAODlKeeR/ExFVyYt+vtWUNuplsDDQW3XRVoIeFnAuWyZ0fgs6Nye9+8aGooAAF68s7stUNFWwO0t+Y+3B4K2utVRxGuAdaxSYKelGgDzOveBGQC4IACAF+8AYKKKXgNEPf3vTsGWll0s6TnnNtPe+40C+9yqJQNeLzGrBBcEAPDyQkBJ2+WDr87CkpYJaPcK+0Fr0jbSPweMVQ6vAZZ1bu/1gGAJDUUAAC9pX/JDzqO5XPDV2TagzTQOPwpot+5ODTi/NQITO7XKO4iNSKGMhiIAgCfvL6fIGYAhlpzH27mSbgnsd109Julfzuc2aXBVx1Z4zwDcG9NNNBEBADzd7tzeIpKmDbpCKwYszhJ7/ttyekCba1bY//FNF7ADgAAAbiKIwyoAABvDSURBVAgA4Mk7AEg53VcNukJfDmjzekm3BrTbFGcGpLhdo4Njt7rNNHm6q4Png5ohAICn9ArgA+c2o77A1wpo85iANpskpbi92fl8l+5geWnvz9h7BADwRAAAT6nAy93Oba4ecIWGByQaSiuzRzi32UQXOZ9z+o5brUPj6B0A3GK/Y4ALAgB4u9G5vZRGdW7nNtcKmJo9PSClbRP9PeCcO/EaYOGAglY3OLeHhiMAgLerA9rcxLm9iOn/vwa02URpBul55/OOzifRk7UD2iQAgCsCAHi7LuBJ2DMAGBLwRHg/72bdjA2YBVjUMgNWyXuRafqduqnic0DNEQDA21uS7nRucxXHfP1zSZrRqa0u5zq313T/cD7/lFZ68QrHdDZJKzu3eZv9bgFuCAAQwfs1QNoOuKlTW0s5tdNdRDW7JouY6l66wvHcPOC79VLn9gACAIS4JKDR7Z3a8b4RvEPmP3cvWWZAT1UGAFsFtBnxO4WGIwBAhJQQ5w3ndldxyty3pEMb3V3N1qwQ3rMAEUWfejJXwKLDVwOSbAEEAAjxccATS1q8t51DO96vAK51bg+f8A4AFrO1ANF2CthimtZEjKmg72gYAgBEuTCg3R1tPcBgTW8LtDx5F7DBJ7yfeFNN/jmCxzYFGN8IaJcEUwhBAIAoaQbgQ+e2U0Kgddv4+3M59kW2ZY3tfzEeDNhO6n39x7ehpFmd23xX0sXObQL/QQCAKG8FLVzapY2/6/0E+HTAWgd84oOAhYDemfnG952ANi+0GgCAOwIARIrIjpcyrM0/yL/rHQDc49wexnWf83h4p5TubsGguhVnBrQJ/AcBACKlwi5vO7efPrN7DfLvzu7cl6ed28O47ncej8hXAD8I+D59m/3/iEQAgEjvB2XJS4sBZxnE3/OeAXjOuT2M61nn8YgKAGZ3zFPR3VkB5bWB/yIAQLSTA9pPed33GMTf854B8L5BYVzeAZb3DpAue9kuA29/Cuov8B8EAIiW9sk/FHCMnSVNN8C/M4VzH5gBiOVdFXDKgN6mraXfDGg3rX+4OaBd4L8IABAtbZU7IeAYU9l714GY1LkPLzu3h3F5BwCTB4zvPgGBpYJ+Z4BxEACgCicHvcv83gCn9SdzPj7bs2K9aQGkF+8AIL1S+G7ACKTfldMC2gXGQQCAKrxmC5q8pSf6/QfQpvcMAAu0Yo1xHuOhkoY5tndYQFCZ/E3S6wHtAuMgAEBVjgk6Tsq9vmiLf9Y7AHjfuT18mvcsi9cNe4mglf9pxuOXAe0Cn0IAgKqknPlXBhwr5V8/tsU/SwBQHu8AwOs1wBFB35+XBiRAAnpEAIAqHRV0rDUlbdrCn2unkBDqYajDWWwpaa2g0Yj6HQE+hQAAVUplTe8NOt7RLUzvehcninj/i3F5r7Bv9zMwdeDrrDslXRXUNvApBACoUnq/+bOg46U874f082cIAMrjvXe/3UWFaeHfcKe+9NQ2UBkCAFTtzMB3nCk74HJ9/HfvVfsR+8rxP5M6Tdl3185nYDlLQBUhPf2fF9Q20CMCAFQtbe36SdAx0zv+E/tIy+q9tWpm5/Ywrmmcx+P9NhZupmDkpMDvzIOccx4A/SIAQCekAkF3BR13MUkH9/LfvDP3zePcHsY1n/N4tHP9Dx/AdtOBul3SxUFtA70iAEAnpCedAwKPm1IEf6mH/58AoCwLOvf2tUH+vbUl7ebcl+725+kfnUAAgE75u6TLgo6dPten9FAs6EXn48zr3B7G5R0ADKZ40ww29T/EuS9dLpF0eVDbQJ8IANBJe0saHXT8VCPgz+N9cT/ufIylnNvDuLwDgIFe//T9+BdJswZdl4+slDDQEQQA6KR7g2uebyxpv27//phz+4sHVYLDJ/ra0TEYTwzw7/xY0vqB1+I3QaWygZYQAKDT0pfsG4F9+KllCkwedW477TpYxrlNfGJBq7bnaSDXfwNJBwZei1ftswl0DAEAOu3l8Z7SvaWb9F9twd6TAbnlV+YTFGLVgEbvbvHPzS/p1ODvx/2DA1+gXwQAyEF6DXBjYD9msG1WUwRsP9zAuT18wjsAeMl++jOtpBEBOQi6uy741RfQEgIA5CAlB/qOLYqKsoikswfwFNiq5QMXiTXVxLb1zlMrgd8kks4P3O8vy0T4Lbb9IQcEAMhFWhB4ZHBfVpe0mXOb6XdoI+c2m27dHrZwtuuGFq5j2jr6heCxP1TSw8HHAFpCAICcpAx+9wT3JyJ979YBbTbZtgHnfl0//z1Vk9wieMxTkHtE8DGAlhEAICejJO1g/1uSL9grBrRvqoB1FWna/dY+/nuqTbF78LX70D7bka+5gAEhAEBu7u4jl3+uUrKhb/NJcvE1K7zj6bo+qgAeaIV4ou0fWP8CGBQCAOQoFV65vrArswNJgdo2kaTvB7R7YS//f6pHcUjg+XRJqX6PqeA4wIAQACBHo+29+qsFXZ20fey7GfSjZNtImjOg/xf18P8dYAvyor1qsxqs+kd2CACQq1S45auFfXGm2gZTZ9CPEqXvon0D+n2npKe6/fsEtuCvipv/GLv5v1DBsYABIwBAzv5ewdZAT2nr2h58ogbl60ELKf+v2z+n/AKnSdoz8Dy6O5Q6/8jZkK1PfJcLhJwNtbLBPdX3z9FISyTzDJ+qlk1re+NndG43vUqaw8pATynpXElrBJ5Hdyl43dBmAYAsMQOA3H0saUvL41+CySUdx6dqQA4OuPnLAscXrQ7EPyu8+aeqg9tx80fuCABQglettG8p01UbWX/Rv6Ul7Rw0Tsdb9sfbJC1R0bV4x7JNUugH2SMAQClSFrXtC3qqSjefmTLoR84mt0qNQwP6+LSkhSRdKmn6isYgzVZtFVBvAghBAICSnG8r7Uswq+WW53esd8fZTTrCDLaANCK46M137d0/UAS+nFCalFDll4X0OVW02yeDfuQoPSnvGNivySs+5xRs/L7iYwJtIQBAiX4g6fRC+p22gq2fQT9ysmzN6uH/TdJ+GfQDGBACAJSoK8HKZQX0fajdIJbOoC85mNdS81b9hB7lQksDzYp/FIcAAKVKFQM3lXRNAf2fwtLRzpNBXzppentHHlGSuROutC2qVPhDkQgAULL3bHq9v1rvOZjVgpX5G/qJm86y4kUt+qvazZI26aPKIJA9AgCU7j3LuHZLAecxpwUBdbkJtmp2q+64fBnd7Ve6+a9bUF4KoEcEAKiDtyWtVchMwGySrq3RzbA/81sWvog8/51wtaQ1Jb1Zk/NBgxEAoC66goARBZzPzBYEfC2DvkRK9RtukDR3Tc7n7/bKiSd/1AIBAOrkQ1uUdXYB5zRM0km2f3yiDPrjaYikAyVdUaNsiGfZO//3M+gL4IIAAHUzypLM/LaQ80qZDW+q0RT5cNvxcEiNvl9+JWlrVvujbggAUEepDOxudnMtYX/2MpLukLS7pAkz6M9gpKf+b0m6X9J65XW/R6Ptmuxh/wzUCgEA6uyX9kqghGnbSSUda4HAqhn0ZyAWtd0Nf5A0TTnd7tNISV+W9OuM+wi0hQAAdXeO3VCfK+Q8l7CV5mcV8FpgPit4dI+kL2TQHy/P2memhAWlwKARAKAJbpX0uUK2CXbZXNJ9ks613Pk5WdCe9h+0Es2lvrboydX2Sub2/LoG+CIAQFP8W9IahU3pTmDpjm+1vfRflzRlh/oyzBbCXSXpIXvfX6fdC2MlHWVbSV/JoD9AuCFbn8iWVjTOVla6deoCT/w9mxW4wLbZvRF4rCks6c16tgVuhsBjdVLKIbGTvXYBGoMAAE2VCvP8VdIKBZ//aEuBnKatH5P0pP08P8hV6yll75L280V7rz9xQL9zcqOk7WzcgEYhAECTTWT71X9Qs9dhKRfCM7bw8Q37ebPbT9rPPqP9pKyEs9hK/ro+4ffkY0mHSTrU/hloHAIAQFpF0p8lLcBYNMITtnjxxqYPBJqNRYDAJ5Xq0va7w0n4UmspKdQf7Vpz80fjEQAAn0jJgvaz994PMCa1c5dVYPw2xXyATxAAAOO60RbB/YAbRS2MtMBuWfb2A+MiAAA+7SOr0reQpFMZnyKNtW19n7FXOyz0A8ZDAAD07gVJO1hd+1sZp2Kka7WS1YF4uumDAfSGAADo3zWWL+Arkh5nvLL1mO3pT9fq5qYPBtAfAgCgNWlK+UzbL7+rFYxBHp6yTH6peNL/2bUC0A8CAGBgUpKd30ma31aUP8X4dUwKwnaxtRon8p4fGBgCAGBwRtme8gWtSM99jGNl7rJEPqkc8fF2LQAMEAEA0J60Y+AkSZ+V9HlbeU4yoRg3SNpI0tKSTrOxBzBIQxk4wM319pNSCu9sC9JmZHjb8rKkUyT9SdLDBZ8HkB1mAAB/j0ray6rrbSHpEmYFBiSl7L3MtvHNIWkfbv6AP2YAgDjp3fTZ9tMVDGxh29SGMO7jSCv3b7KdFmdZDgYAgagGCFRvTkmbS9rMgoEJG3oNRlvSnnPtxv9MBn0CGoMAAOis6SStLmkNSRtIGl7z6/GKJVa6QtIFkl7KoE9AI/EKAOis123K+yxbk/MZq0i4iv1v6QHBc7Yw8gb737tJ1APkgQAAyEda/Hav/fzWejWvpM9JWsq2vy2V8c6CF63vd9te/euZ1gfyRQAA5O0J+zmzWy9ns7S3C9r/LmSLDGeVNE3w2bwp6UnLgPik/TxoN/1X+SwB5SAAAMrzvP1c0UPPJ5E0s706mFbS1PYzTbefySUN6/Z3RtqOhTQD8ZZN0b9mP692++d/WwAAoAYIAIB6+cBK4FIGF0CfSAQEAEADEQAAANBABAAAADQQAQAAAA1EAAAAQAMRAAAA0EAEAAAANBB5AFqTMq2tKmlJy742lxVxmULSRCWcQMFGWj75OyWdbz+jmj4oyNLEkjaVtLGlbZ7dki4hzkeS3rWaGin3xcOWlfJqSY8w7n2jGmDvFpf0VUlb2i8y8vC4pB9YCVkgF1+WdITVbkAenrUU2qdIuodr8mm8AhjXEEnrW+WyFEXuxc0/O/NJOkfSkXx+kYEJJR0l6Wxu/tmZQ9L37bs8FaZaz77jYfgC/Z9lJN0s6SJJK+XSKfRqb0m/YHjQYYfbTQZ5W1nSxZJutNczjScCgP9IxVOOlXSLpOUy6A9at4+kTRgvdMiXufkXZwVJt0o6ZryCWI3U9ABgfosId7epPJTnSFt8BVRpYnvnj/Kk7/o97Lt/viZfvyYHACvaU/9SGfQFgze/rboGqrQp7/yLt7TdA5Zv6gA0NQBYS9LltpUP5SMAQNX4zNXD9JKulLRmE0++iQHAcraFjP259fG5pg8AKsdnrj4mt/wijVv83bQAIE0XX8LNv3aGN30AULlZGPJamUzSiKa91mlSAJBWfJ7BtH8tjW36AKBy7CevnxnsHtGY3QFNCgAOZ/9nbb3Y9AFA5V5gyGspvdo5rCkn25QAICX52S2DfiDGbYwrKnYHA15bezRld1gTAoA0Vfc79vnX2oimDwAqdz5DXlvpXnFcE060CQHAemT4q7XHCABaNoHVuviTpAckvSnpPRvD8yTtaBUu0b/zrTAV6imlDl677te2CQHA/hn0AXH2tpKg6NuqNm2dal18Q9IikqaWNKllQ0splf9swcC3WOTWr1FWlRL1dUDdr23dA4AlKOxTa0fw9N+SPSVdIWnJFv7wzJL+IOk0q5OB3p1rlQBRT5+XtFidr23dA4AdMugDYqSb/w8Z237tKunoQayB2UbSycwE9Gtfq0eBeqr1PaTuAcCWGfQBvh6z6er0xTuGse3TclbpcrC2tBXR6N0YexWwqX02US+1vocM2frEdzPoRoiFJD1Uw/NqmvQBfc7eX59vU/6882/NdTaN2Y43LYPma5mfaw4msuB0Y9t6PDuLKmthgboGd0Mz6EOULwW1+6G9I/2rpPskjez8qQKfspzDzT+ZxhYNUvq2fykwPct+UI3J7T39drZ4NaI0+Gp1DQDq/Apg8YA2n7fSkbtbGUlu/siVZ7U6Kt8hVyPtu/i79t38fEA/I+4lWahzALCQc3sf2h7qu53bBSIs49jmMiwGRAHukrShbdH05H0vyUadAwDvqk5/4OaPgnhWSBxmddOB3P1L0gnOfaxthcA6BwBTOrf3f87tAZG8F595/z4BUU5zbnequl4pAoDWPRDZWQCAi/uch7G2wW+dAwDv1aC13S8JADXi/V09rK4fjqaUAwYAAN0QAAAA0EAEAAAANBABAAAADUQAAABAAxEAAADQQAQAAAA0EAEAAAANRAAAAEADEQAAANBABAAAADQQAQAAAA1EAAAAQAMRAAAA0EAEAAAANBABAAAADUQAAABAAxEAAADQQAQAAAA0EAEAAAANRAAAAEADEQAAANBABAAAADQQAQAAAA1EAAAAQAMRAAAA0EAEAAAANBABAAAADUQAAABAAxEAAADQQAQAAAA0EAEAAAANRAAAAEADEQAAANBABAAAADQQAQAAAA1EAAAAQAMRAAAA0EAEAAAANBABAAAADUQAAABAAxEAAADQQAQAAAA00NAKT3l+SStIWljSQpIWkDSlpGklTS5p4syHf2wGfQA65QlGHg3m/f0/StJISW9IekfSI/bzoKSbJT1exVBHBgDDJG0gaUNJq0maI/BYAACUYmL7mdb6u8R4/X5G0tWSLpB0saQPI85ryNYnvuvd5lKSvilpq24nBwAABu51SWdI+qOkuzzHz3MNwMqSLpR0h6SdufkDANC26eye+i9Jl0ta0WtIPQKA+WyK4nqb8h/i0CYAABjXGpJutIftedodm3YCgPT+4seS7pW0HhcJAIBKpIft+yX9qJ0F9IMNAOaUdI2kgyVNyvUGAKBS6d77U0k3SJp3MAceTACwqaS7Pd9DAACAQfmcpNslbTzQvzzQAGBXSWdLmobrBABAFtKi+/Mk7TWQzgwkANhX0m/IHggAQHbSAvxfSvpFqx1r9WZ+6EAaBQAAHZEe1g9p5cCtBAC7SDqA6wgAQBEOlLRHfx3tLwBIC/6O43oDAFCU9Dpgo7463FcAkLb6/Yl3/gAAFCfdu0/uK2FQbzf3iST9zVIQAgCA8kxjdQR6TBbUWwDwQ/b5AwBQvGUl7dPTSfQUAMxnAQAAACjfAT1lC+wpAPi1pEm44AAA1EJKG3zs+CcyfgCwAoV9AAConQ2tbP9/jR8A/JhrDgBALe3X/aSGdvvnpSStU9EZ3ylphKTrJL0k6VlJI/m8AQAaYHJJc0iaRdIXrJDP0hWc9vqSlpR0l8abAfiW5RKOMtYKCS0saRlLVZhKCj/EzR8A0CAj7d53jd0Ll7F74zl2r4yS7vHf7Gq7KwAYJmnLwIM+KWklSVtIephPOQAA40j3xs0lrSLpqcCh+UpXXoCuAGCDwKQ/aZp/OUk3B7UPAEBd3Gj3zOuCzmd6exXw3wBgw6ADpRNYU9KrQe0DAFA3r9i9MyoISA/9/w0AVg04wFM2nTEqoG0AAOos3Ts3k/R4wDmuLgsA5pc0l3PjaRHD1hbFAACAgXtN0g4BCwPTPX/eCSz5j7dzeOcPAEDb0pqA8wKGcYUJbOuBpxSp/IhrDgCAi4h76sIpAFjIudE72eoHAICbB7uS9zhasGsNgKcLuOYAALga4dzeAikAmMa50ahtCwAANJX3vXXaFABM5dzo887tAQDQdN731ilTADCFc6MvOrcHAEDThQQA3iILCgEA0ETu9+vU4LvObc7q3B4AAE033Pn830kBwNvOjc7m3B4AAE0XEgC86dzo553bAwCg6b7gfP5vpADgMedGN3ZuDwCAptvE+fwfTQHAQ86NLhWQXRAAgKZaRNISzuf+8AQBaXvTLoDDnNsEAKCpIu6p/wkAbgpoONUwXimgXQAAmmRlSZsGnO9NKQB4XNLTzg2nWYC/SprJuV0AAJpiekmnBJxruuc/2ZVY4OqAA8wl6SxJEwe0DQBAnaV753mS5g04xyvVLbPQhUGDmLYtXC5pxqD2AQCom3TPvCJwW/1/7vldAcDFkl4POlAKAm5hTQAAAP1K7/xvC7z5vybp7+oWAHwo6YzA6zKPpOslnWPbGQAAwP+ke+O5dq+cK3Bc0r1+VPqHIVuf+N9SAEtKurOiYj53SRph9Y1fkPRcQE0CAH2b0B4CPmKcgEqlKryzW3rfL1gCvSUr6MBYy9Vzd/qXod3+w102LbB+BZ1YsqKTBar0npXsTL9LF9iM1/sZXYFhkra2L5sVbJdOCgBe7haUnxZQH6Qd6TtqQ8uCtpzVGpkyo/4BJbmo6+av8WYAkhUl3cjlBFw8K2l/u6l22lckHSFpzn768aqkgyQdb08LnbSupKMlLczHEXCxgq3J+4/x6wvfZBECgPbNIelUSb+XNFGHxjP9jh8l6W8t3PyTGST91vo9SQX968kQC0Iu5uYPuBnR/eavHgKAZFdJIxlzwM23Jf2xQ8OZUoh+fxB/b1tLQFLFmqDx/UjSTzp0bKCO0qvIPcc/r54CgGck/YKPAODqa/ZTpQ0k7dvG8baQ9J2K+7yG3fwB+Dk0Zf4bv7Xx1wB0SdOV19qaAAA+XpS0QEUzbGmF/z2SFm2znbQmYL6KFgamB5LbbZUyAB+3Wk6BUT39wvUkbQvaRtIbXADAzaz2e1WFdRxu/rI1AdtW1Oc1ufkDrlKCvy17uvmrjwAgeUrSjpLGcD0ANxtXNJSex9nIsa2+VDU2QBOMlvTVvor99RUAyFYN7spHBXDzuYqGculM2+pLVWMDNMFe/e3q6y8AkG1h+ikfF8DFjBVtCZzVsa0ZKurz8AqOATTBwZJ+3d95thIAJD+WtB8fG8BFFQl2Rju2NbaiV4GdTjwE1MHhre6kaTUAkDW6G2sCgLaktLsfVzCELzi29bJzQNEbzz4DTZN+R3cZyMP6QAIAWYawTdkdAAzaHRUNnWdK7xsc2+pLVWMD1M3rVi/j+IGc2EADAFmRk6XHTykIoCXnVzRMIxzbusCxrb5UNTZAndxs9+QBp/EfTAAg2yL4eUvZmVO1MyBnaYr79Ir6d63TLED6XT/ToZ1WXNG9UhmAPqXqowdYOeFet/r1ZbABgCxZUMoz/hlJF3KdgH7tX3GdjX0c1hvsLelDp/70Z4zVLWCdEdC3EXbv/ZndiwelnQCgy5OWKCRNQZzFSl6gRydJOrniobnR9gIP1pGSzqm4z1fariMAn3aFpejfxGbn2uIRAHT5l6UcTIHA72xRAoBPFuZ8u0PjcJwdeyBPCWNt10+ntv7+zIIAHiYA6TVbgL+kpcu+2WtMeisG5GFiSevZ7MCXJM3NhUTDPGM30are+/dlJUm/lLRCP3/ufnt1cElnu/sfa0s62qmmAVCS9HR/lS3AvaS3XP7tigwAxjevffksLGkhSfNLmsZ+prCAAShZWpTzrC1kSyvaz5P0QWbn80XLuZ9+F+ewWcDnbQte+rK5rKI9/62a0MoapynP5SXNJmmqjPoHDEa6oaeb75u2rf5xSQ9LetCe8D9VutedpP8HIprzPpq9HNgAAAAASUVORK5CYII="/>
                                        <rect class="cls-1" x="6" y="6" width="501" height="499" />
                                        </svg>
                                        </span>
                                    </a>`;

                        } else if (val.service_id == 2 && checkPermission('show_mobile_plans',userPermissions,appPermissions)) {
                            html += `
                                        <a class="btn-circle btn-icon-only btn-default" title="View mobile plans" href="${mobile_logo}">
                                        <span style="color:rgb(55, 20, 100);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" viewBox="0 0 512 512">
                                        <defs>
                                        <style>
                                          .cls-1 {
                                            fill: none;
                                            stroke: #039ef7;
                                            stroke-width: 13px;
                                          }
                                        </style>
                                        </defs>
                                            <image id="sim-card" width="512" height="512" xlink:href="data:img/png;base64,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"/>
                                            <rect class="cls-1" x="6" y="6" width="501" height="499" />
                                        </svg>
                                        </span>
                                    </a>
                                        `;
                        } else if (val.service_id == 3 && checkPermission('show_broadband_plans',userPermissions,appPermissions)) {
                            html += `
                                        <a class="btn-circle btn-icon-only btn-default" title="View broadband plans" href="${broadband_logo}">
                                        <span style="color:rgb(55, 20, 100);"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" viewBox="0 0 512 512">
                                        <defs>
                                        <style>
                                          .cls-1 {
                                            fill: none;
                                            stroke: #039ef7;
                                            stroke-width: 13px;
                                          }
                                        </style>
                                        </defs>
                                            <image id="wifi" y="45" width="512" height="422" xlink:href="data:img/png;base64,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"/>
                                            <rect class="cls-1" x="6" y="6" width="501" height="499" />
                                        </svg>
                                        </span>
                                    </a>
                                        `;
                        } else if (val.service_id == 4) {
                            html += `
                                        <a class="btn-circle btn-icon-only btn-default" title="View LPG Gas Plans" href="${lpg_logo}">
                                        <span style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" viewBox="0 0 512 512">
                                        <defs>
                                        <style>
                                          .cls-1 {
                                            fill: none;
                                            stroke: #039ef7;
                                            stroke-width: 13px;
                                          }
                                        </style>
                                        </defs>
                                            <image id="gas-bottle" x="102" width="308" height="512" xlink:href="data:img/png;base64,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"/>
                                            <rect class="cls-1" x="6" y="6" width="501" height="499" />
                                        </svg>
                                        </span>
                                    </a>
                                        `;
                        }
                        html += `
                                    </td>
                                    <td>
                                        <a href="#" class="btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon--></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item">`;
                                            if(checkPermission('edit_provider',appPermissions,userPermissions))
                                            {
                                                html += `<a href="${editurl}" class="menu-link px-3"><i class="bi bi-pencil-square"></i> Edit</a>`;
                                            }
                                            if(checkPermission('provider_settings',appPermissions,userPermissions))
                                            {
                                                html += `<a href="${settinggurl}" class="menu-link px-3"><i class="bi bi-gear"></i> Settings</a>`;
                                            }
                                            if(checkPermission('view_provider',appPermissions,userPermissions))
                                            {
                                                html += `<a  data-bs-toggle="modal" data-bs-target="#provider-detail" id="view-provider" data-url="${viewurl}" class="menu-link px-3"><i class="bi bi-eye"></i> View</a>`;
                                            }
                                            if(checkPermission('delete_provider',appPermissions,userPermissions))
                                            {
                                                html += `<a  data-bs-toggle="modal" data-bs-target="#provider-detail" id="view-provider" data-url="${viewurl}" class="menu-link px-3"><i class="bi bi-eye"></i> View</a>`;
                                            }
                                            html +=`   
                                                <a href="#" class="menu-link px-3"><i class="bi bi-calendar-check"></i> GSSSBDR</a>`;
                                            if (val.service_id == 2 && checkPermission('provider_action',userPermissions,appPermissions) && checkPermission('provider_assigned_phones',userPermissions,appPermissions)) {
                                                html += `<a href="${assignedhandsets}" class="menu-link px-3"><i class="bi bi-gear"></i>Assigned Phone(s)</a>`;
                                            }
                        html += `          </div>
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>`;
                    });
                    pageNumber = 2;
                    $('#providerbody').html(html);
                    KTMenu.createInstances();
                }
                dataTable = $("#provider_table")
                        .on('draw.dt', function () {
                            $('.form-check-input.main').prop('checked', false);
                            KTMenu.createInstances();
                        })
                        .DataTable({
                            columnDefs: [
                                { "orderable": false, "targets": 0 }
                            ],
                            searching: true,
                            ordering: true,
                            "sDom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        });

            })
            .catch(function (error) {
                console.log(error);
            });

    }

    /*
     * Provider move-in page js start
    */
    $("#elec_distributor_div").show();
    $("#gas_distributor_div").hide();
    $('#move_in_energy_type').change(function () {
        var select_energy_type = $(this).val();
        if (select_energy_type == 1) {
            $("#gas_distributor_div").hide();
        } else {
            $("#gas_distributor_div").show();
            $("#elec_distributor_div").hide();
        }
    });
    $('.is_credit_allow').change(function () {
        var selected_option = $(this).val();
        $(".credit_score_div").hide();
        if (selected_option == 1) {
            $(".credit_score_div").show();
        }
    });
    $('.is_life_support_allow').change(function () {
        var selected_option = $(this).val();
        $(".life_support_type_div").hide();
        if (selected_option == 1) {
            $(".life_support_type_div").show();
        }
    });
    /** Provider move-in page js start */

    /*
     * Common function for add and update provider start
    */
    $(document).on('submit', '#terms_and_condition_form,.concession_details_form,.concession_content_form,.provider_basic_detail_form, .provider_logo_form, .billing_preference_form, .post_submission_form, .apply_now_popup_form, .footer_content_form, .statewise_consent_form, .satellite_eic_form, .tele_sale_setting_form, .acknowledgement_content_form, .personal_details_form, .connection_details_form, .identification_details_form, .employment_details_form, .connection_address_form, .billing_and_delivery_address_form,.other_settings_form', function (event) {
        event.preventDefault();
        $('.error').empty().text('');


        var formData = new FormData($(this)[0]);
        var formName = $(this).closest('form').attr('name');
        if (formName == 'acknowledgement_content_form') {
            let checkBoxCount = $('#checkboxes_list_count').val();
            if (checkBoxCount > 0) {
                let ackFormContent = $('textarea#acknowledgment_content').val();
                if (ackFormContent == '' || ackFormContent == null) {
                    return toastr.error("Acknowledgement Content can't be empty");
                }
            }

        }
        if (formName == 'provider_basic_detail_form') {
            var url = '/provider/store';
        } else {
            var url = '/provider/update';
        }
        // formData.append('provider_id', $("#provider_id").val());
        formData.append('user_id', $("#user_id").val());
        if ($('select[name="service_type"]').val()) {
            formData.append('service_type_id', $('select[name="service_type"]').val());
        }
        else {
            formData.append('service_type_id', $("#service_id").val());
        }
        formData.append('request_from', formName);
        if (formName == 'personal_details_form' || formName == 'connection_details_form' || formName == 'identification_details_form' || formName == 'employment_details_form' || formName == 'connection_address_form' || formName == 'billing_and_delivery_address_form' || formName == 'other_settings_form') {
            formData.append('request_from', $('input[name="form_type"]').val());
            formData.append('request_sub_from', formName);
        }
        console.log('+++++++++',formData);

        loaderInstance.show();
        axios.post(url, formData)
            .then(function (response) {
                loaderInstance.hide();
                if (response.data.status != 400 && response.data.status != 422) {
                    if (response.data.desc != '' && response.data.desc != null) {
                        $('#acknowledgment_content').html(response.data.desc);
                    } else {
                        $('#acknowledgment_content').html('');
                    }
                    if (formName == 'terms_and_condition_form') {
                        console.log('______', response.data.data);
                        let setTypeArray = response.data.data.setTypesArray;
                        let unsetTypeArray = response.data.data.unsetTypesArray;
                        console.log(setTypeArray);
                        console.log(unsetTypeArray);
                        $('#terms_and_condition_title optgroup').remove();
                        setTypeArrayLength = Object.keys(setTypeArray).length;
                        unsetTypeArrayLength = Object.keys(unsetTypeArray).length;

                        console.log('----------', setTypeArrayLength);
                        console.log('----------', unsetTypeArrayLength);
                        if (setTypeArrayLength > 0) {

                            let optGrp1 = $('<optgroup />', {
                                label: 'Content already set'
                            }).appendTo('#terms_and_condition_title');
                            Object.entries(setTypeArray).forEach(entry => {
                                const [key, value] = entry;

                                $('<option />', {
                                    text: value,
                                    value: key
                                }).appendTo(optGrp1);
                            });


                        }
                        if (unsetTypeArrayLength > 0) {

                            let optGrp2 = $('<optgroup />', {
                                label: 'Content yet to be set'
                            }).appendTo('#terms_and_condition_title');

                            Object.entries(unsetTypeArray).forEach(entry => {
                                const [key, value] = entry;

                                $('<option />', {
                                    text: value,
                                    value: key
                                }).appendTo(optGrp2);
                            });

                        }
                    }
                    toastr.success(response.data.message);
                    if (jQuery('#action').val() == 'add') {
                        // window.location.href = "list";
                    }
                }
                if (response.data.message == "Success") {
                    if (formName == "terms_and_condition_form") {

                        $("#add_button_show_hide").show();
                    }
                }
                if (response.data.status == 400) {
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                $(".error").html("");
                loaderInstance.hide();
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                    $('html, body').animate({
                        scrollTop: ($('.error.text-danger').offset().top - 300)
                    }, 1000);
                }
                else if (error.response.status == 400) {
                    console.log(error.response);
                }
            });
    });

    $(document).on('submit', '#add_contact_form', function (e) {
        e.preventDefault();
        // $('#contact_form_submit').prop('disabled', true);
        $('#add_contact_form').find('input').css('border-color', '');
        var formData = new FormData($(this)[0]);
        formData.append('user_id', $("#user_id").val());
        var url = '/provider/contact/store';
        axios.post(url, formData)
            .then(function (response) {
                if (response.data.status == true) {
                    if (response.data.contactdata == '' || response.data.contactdata == null) {
                        toastr.error(response.data.message);
                        $("#add_contact").modal('show');
                        return;
                    }
                    toastr.success(response.data.message);
                    $("#add_contact").modal('hide');
                    $('#provider_contact_body').html('');
                    var i = 0;
                    var provider_contact_html = `
                        <tr>
                            <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                        </tr>`;
                    response.data.contactdata.forEach(element => {
                        provider_contact_html = `
                            <tr>
                                <td>${++i}</td>
                                <td>${element.name}</td>
                                <td>${element.email}</td>
                                <td>${element.designation}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon--></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                        <a type="button" class="menu-link px-3 edit-contact-button" data-action="edit" data-id="${element.id}" data-name="${element.name}" data-email="${element.email}" data-designation="${element.designation}" data-desc="${element.description}">Edit</a>
                                            <a type="button" class="menu-link px-3 delete_contact" data-user_id="${element.provider_id}" data-id="${element.id}">Delete</a>
                                        </div>
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>`;
                        $('#provider_contact_body').append(provider_contact_html);
                        KTMenu.createInstances();
                    });
                } else {
                    toastr.error(response.data.message);
                }//add delay
            })
            .catch(function (error) {
                loaderInstance.hide();
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('[name="' + key + '"]').parent().find('span.error').empty().addClass(
                            'text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                } else if (error.response.status == 400) {
                    toastr.error(error.response.message);
                }
                return false;
            })
    });
    $('.conn_detail_status').change(function () {
        if (this.value == '0') {
            $('.connection_details_hideable').fadeOut();
        }
        else if (this.value == '1') {
            $('.connection_details_hideable').fadeIn();
        }
    });
    ($("#state, #type")).change(function () {
        var providerId = $("#provider_id").val();
        var stateId = $('#state').val();
        var typeId = $('#type').val();
        var formData = new FormData();
        formData.append('provider_id',providerId);
        formData.append('state_id',stateId);
        formData.append('type_id',typeId);
        url = '/provider/concession_data';
        axios.post(url,formData)
            .then(function (response) {
                // console.log(response);
                if(response.data){
                    CKEDITOR.instances.concession_content.setData(response.data.content);
                }else{
                    CKEDITOR.instances.concession_content.setData('');
                }
            })
            .catch(error => {
                element.parentElement.innerHTML = `Error: ${error.message}`;
                console.log('There was an error!', error);
            });

    });
    $('.primary_identification_details').change(function () {
        if (this.value == '0') {
            $("#secondary_identification_details0").prop("checked", true);
            $('.identification_details_hideable').fadeOut();
            $('.optional_ids').addClass('hideOption');
        }
        else if (this.value == '1') {
            $('.identification_details_hideable').fadeIn();
            $('.optional_ids').removeClass('hideOption');
        }
    });
    $('.billing_address').change(function () {
        if (this.value == '0') {
            $('.billing_address_dropdown').addClass('billing_address_hidden');
        }
        else if (this.value == '1') {
            $('.billing_address_dropdown').removeClass('billing_address_hidden');
        }
    });
    $('.delivery_address').change(function () {
        if (this.value == '0') {
            $('.delivery_address_dropdown').addClass('delivery_address_hidden');
        }
        else if (this.value == '1') {
            $('.delivery_address_dropdown').removeClass('delivery_address_hidden');
        }
    });
    $('.direct_debit_status_input').change(function () {
        if (this.value == '0') {
            $('.payment_method_hideable').hide();
        }
        else if (this.value == '1') {
            $('.payment_method_hideable').show();
        }
    });
    $('.card_info_status_input').change(function () {
        if (this.value == '0') {
            $('.card_info_content_hideable').fadeOut();
        }
        else if (this.value == '1') {
            $('.card_info_content_hideable').fadeIn();
        }
    });
    $('.bank_info_status_input').change(function () {
        if (this.value == '0') {
            $('.bank_info_content_hideable').fadeOut();
        }
        else if (this.value == '1') {
            $('.bank_info_content_hideable').fadeIn();
        }
    });
    $('.employment_detail_status').change(function () {
        if (this.value == '0') {
            $('.employment_details_hideable').fadeOut();
        }
        else if (this.value == '1') {
            $('.employment_details_hideable').fadeIn();
        }
    });
    $('.conn_address_detail_status').change(function () {
        if (this.value == '0') {
            $('.connection_address_hideable').fadeOut();
        }
        else if (this.value == '1') {
            $('.connection_address_hideable').fadeIn();
        }
    });
    $('.billing_delivery_detail_status').change(function () {
        if (this.value == '0') {
            $('.billing_delivery_details_hideable').fadeOut();
        }
        else if (this.value == '1') {
            $('.billing_delivery_details_hideable').fadeIn();
        }
    });
    $('.billing_delivery_detail_status').change(function () {
        if (this.value == '0') {

            $("#billing_address0").prop("checked", true);
            $("#delivery_address0").prop("checked", true);
            $('.identification_details_hideable').fadeOut();
        }
        else if (this.value == '1') {
            $('.billing_delivery_details_hideable').fadeIn();
        }
    });

    /*$('.primary_identification_details').change(function () {
        if (this.value == '0') {
           $('.optional_ids').addClass('hideOption');
        }
        else if (this.value == '1') {
            $('.optional_ids').removeClass('hideOption');
        }
    });*/
    $('.secondary_identification_details').change(function () {
        if (this.value == '0') {
            $('.optional_second_ids').addClass('hideSecOption');
        }
        else if (this.value == '1') {
            $('.optional_second_ids').removeClass('hideSecOption');
        }
    });

    $('#employment_details').on('select2:select', function (e) {
        if (e.params.data.id == 4) // 4 id for Minimum residential status.
        {
            $('.employment_details_sub_option').fadeIn();
        }
    });
    $('#employment_details').on('select2:unselect', function (e) {
        if (e.params.data.id == 4) // 4 id for Minimum time of Employement.
        {
            $('.employment_details_sub_option').fadeOut();
        }
    });
    $('#connection_address').on('select2:select', function (e) {
        if (e.params.data.id == 1) // 4 id for Minimum time of Employement.
        {
            $('.connection_address_sub_option').fadeIn();
        }
    });
    $('#connection_address').on('select2:unselect', function (e) {
        if (e.params.data.id == 1) // 1 id for Minimum residential status.
        {
            $('.connection_address_sub_option').fadeOut();
        }
    });
    $(document).on('change', '#terms_and_condition_title', function (e) {
        $('span.error').html('');
        loaderInstance.show();
        $.ajax({
            url: '/provider/terms_and_condition_title',
            type: 'GET',
            data: {
                type: $("#terms_and_condition_title").val(),
                provider_id: $("#provider_id").val(),
                user_id: $("#user_id").val()
            },
            success: (data) => {
                $("#terms_and_cond_list").html('');
                $("#title").val('');
                // CKEDITOR.instances.term_description.setData('');
                list_data = {};
                list_data.list_id = "#terms_and_cond_list";
                list_data.data_target = "add_terms_condition_checkbox";
                list_data.id = "terms_condition_edit";
                list_data.delete = "terms_condition_delete";

                if (data.data.length != 0) {
                    $("#title").val(data.data[0].title);
                    $('#terms_and_condition_title').val(data.data[0].type);
                    $('#termTypeId').val($('#terms_and_condition_title option:selected').text());
                    $('#termTypeId').attr('termId', $('#terms_and_condition_title').val() ?? 0);
                    CKEDITOR.instances.term_description.setData(data.data[0].description);
                    if (data.data[0].getcontentcheckbox != null && data.data[0].getcontentcheckbox != undefined && data.data[0].getcontentcheckbox != '') {
                        for (var i = 0; i < data.data[0].getcontentcheckbox.length; i++) {
                            tableData(data.data[0].getcontentcheckbox[i], i, list_data);
                        }
                    }
                } else {
                    // $("#add_button_show_hide").hide();
                    CKEDITOR.instances.term_description.setData('');
                    $('#term_description').empty();
                    $("#terms_and_cond_list").html(`<tr><td valign="top" colspan="6" class="text-center">There are no records to show'</td></tr>`);
                }
                loaderInstance.hide();
            },
            error: function (error) {
                // if(error.status == 422) {
                //     errors = error.responseJSON;
                //     $.each(errors.errors, function(key, value) {
                //         $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                //     });
                // }
                loaderInstance.hide();
            }
        });
    });
    /** Common function for add and update provider end */

    /*
     * Provider content checkboxes js start
    */
    var checkboxId = null;
    $(document).on('click', '#terms_condition_edit,#add_checkbox_button,#ack_checkbox_button,#provider_ackn_checkbox_edit,#tele_sale_edit,#add_tele_sale_button,#add_statewise_checkbox_button,#statewise_checkbox_edit,#post_submission_checkbox_edit,#direct_debit_checkbox_add,#direct_debit_checkbox_edit ,#plan_permission_checkbox_edit', function (event) {
        $('span.error').html('');
        if (this.id == "terms_condition_edit") {
            CKEDITOR.instances.terms_checkbox_content.setData($(this).attr("data-checkbox_content"));
            CKEDITOR.instances.terms_condition_validates.setData($(this).attr("data-validation_message"));
            if ($(this).attr('data-required_checkbox') == 1) {
                $("#term_checkbox_required_yes").prop('checked', true);
            } else {
                $("#term_checkbox_required_no").prop('checked', true);
            }
            if ($(this).attr('data-save_checkbox') == 1) {
                $("#term_status_save_yes").prop('checked', true);
            } else {
                $("#term_status_save_no").prop('checked', true);
            }
            $('#term_contn_checkbox_order').val($(this).attr('data-order'));
            $("#action").val("edit");
            checkboxId = $(this).attr("data-id");
        }
        if (this.id == "add_checkbox_button") {
            CKEDITOR.instances.terms_checkbox_content.setData("");
            CKEDITOR.instances.terms_condition_validates.setData("");
            $("#action").val("add");
            $("#term_status_save_no").prop('checked', true);
            $("#term_checkbox_required_no").prop('checked', true);
        }
        if (this.id == "ack_checkbox_button") {
            CKEDITOR.instances.ackn_checkbox_content.setData("");
            CKEDITOR.instances.ackn_validation_msg.setData("");
            $("#action").val("add");
            $("#ackn_checkbox_status_save_no").prop('checked', true);
            $("#ackn_checkbox_required_no").prop('checked', true);
        }

        if (this.id == "provider_ackn_checkbox_edit") {
            CKEDITOR.instances.ackn_checkbox_content.setData($(this).attr("data-checkbox_content"));
            CKEDITOR.instances.ackn_validation_msg.setData($(this).attr("data-validation_message"));
            if ($(this).attr('data-required_checkbox') == 1) {
                ;
                $("#ackn_checkbox_required_yes").prop('checked', true);
            } else {
                $("#ackn_checkbox_required_no").prop('checked', true);
            }
            if ($(this).attr('data-save_checkbox') == 1) {
                $("#ackn_checkbox_status_save_yes").prop('checked', true);
            } else {
                $("#ackn_checkbox_status_save_no").prop('checked', true);
            }
            $('#provider_ackn_checkbox_order').val($(this).attr('data-order'));
            $("#action").val("edit");
            checkboxId = $(this).attr("data-id");

        }

        if (this.id == "add_tele_sale_button") {
            CKEDITOR.instances.tele_sale_setting_validation_msg.setData('');
            CKEDITOR.instances.tele_sale_setting_checkbox_content.setData("");
            $("#action").val("add");
            $("#checkbox_required_tele_sale_no").prop('checked', true);
            $("#tele_sale_setting_checkbox_save_no").prop('checked', true);
            $(`select[name^="tele_select_eic_type"] option[value=""]`).attr("selected", "selected");
            $('#select_tele_eic_type').select2();

        }

        if (this.id == "tele_sale_edit") {
            CKEDITOR.instances.tele_sale_setting_checkbox_content.setData($(this).attr("data-checkbox_content"));
            CKEDITOR.instances.tele_sale_setting_validation_msg.setData($(this).attr("data-validation_message"));
            if ($(this).attr('data-required_checkbox') == 1) {
                ;
                $("#checkbox_required_tele_sale_yes").prop('checked', true);
            } else {
                $("#checkbox_required_tele_sale_no").prop('checked', true);
            }
            if ($(this).attr('data-save_checkbox') == 1) {
                $("#tele_sale_setting_checkbox_save_yes").prop('checked', true);
            } else {
                $("#tele_sale_setting_checkbox_save_no").prop('checked', true);
            }
            $(`select[name^="tele_select_eic_type"] option[value="${$(this).attr('data-eic')}"]`).attr("selected", "selected");
            $('#tele_sale_checkbox_order').val($(this).attr('data-order'));
            $('#select_tele_eic_type').select2();
            $("#action").val("edit");
            checkboxId = $(this).attr("data-id");
        }
        if (this.id == "add_statewise_checkbox_button") {
            CKEDITOR.instances.state_eic_content_validation_msg.setData('');
            CKEDITOR.instances.state_eic_content_checkbox_content.setData("");
            $("#state_select_eic_type").select2();
            $("#state_select_eic_type").val("").trigger('change')
            // $('#state_select_eic_type').select2("val", "");
            $("#action").val("add");
            $("#statewise_checkbox_required_no").prop('checked', true);
            $("#statewise_save_status_no").prop('checked', true);
            $('.validation_message').hide();
        }
        if (this.id == "statewise_checkbox_edit") {
            CKEDITOR.instances.state_eic_content_checkbox_content.setData($(this).attr("data-checkbox_content"));
            CKEDITOR.instances.state_eic_content_validation_msg.setData($(this).attr("data-validation_message"));
            $(`select[name^="statewise_select_eic_type"] option[value="${$(this).attr('data-eic')}"]`).attr("selected", "selected");
            $('#state_select_eic_type').select2();
            $('#state_consent_checkbox_order').val($(this).attr('data-order'));
            if ($(this).attr('data-required_checkbox') == 1) {
                ;
                $("#statewise_checkbox_required_yes").prop('checked', true);
                $('.validation_message').show();
            } else {
                $("#statewise_checkbox_required_no").prop('checked', true);
                $('.validation_message').hide();
            }
            if ($(this).attr('data-save_checkbox') == 1) {
                $("#statewise_save_status_yes").prop('checked', true);
            } else {
                $("#statewise_save_status_no").prop('checked', true);
            }
            $("#action").val("edit");
            checkboxId = $(this).attr("data-id");

        }

        if (this.id == "direct_debit_checkbox_add") {
            CKEDITOR.instances.debit_checkbox_content.setData('');
            CKEDITOR.instances.debit_validation_msg.setData('');
            $("#debit_checkbox_required_no").prop('checked', true);
            $("#action").val("add");

        }
        if (this.id == "direct_debit_checkbox_edit") {
            CKEDITOR.instances.debit_checkbox_content.setData($(this).attr("data-checkbox_content"));
            CKEDITOR.instances.debit_validation_msg.setData($(this).attr("data-validation_message"));
            if ($(this).attr('data-required_checkbox') == 1) {
                ;
                $("#debit_checkbox_required_yes").prop('checked', true);
            } else {
                $("#debit_checkbox_required_no").prop('checked', true);
            }
            $('#direct_debit_checkbox_order').val($(this).attr('data-order'));
            $("#action").val("edit");
            checkboxId = $(this).attr("data-id");

        }
        if (this.id == 'post_submission_checkbox_edit') {
            CKEDITOR.instances.post_submission_checkbox_content.setData($(this).attr("data-checkbox_content"));
            CKEDITOR.instances.post_submission_validation_msg.setData($(this).attr("data-validation_message"));
            if ($(this).attr('data-required_checkbox') == 1) {
                ;
                $("#post_submission_checkbox_required_yes").prop('checked', true);
            } else {
                $("#post_submission_checkbox_required_no").prop('checked', true);
            }
            $('#post_submission_checkbox_order').val($(this).attr('data-order'));
            $("#action").val("edit");
            checkboxId = $(this).attr("data-id");
        }
        if(this.id == 'plan_permission_checkbox_edit'){
            CKEDITOR.instances.plan_permission_checkbox_content.setData($(this).attr("data-checkbox_content"));
            CKEDITOR.instances.provider_permission_validation_msg.setData($(this).attr("data-validation_message"));
            let connectnType=$(this).attr('data-connection-type');
            let chckboxReq=$(this).attr('data-required_checkbox');
            $('.permsn_checkbox_class').attr('checked',false);
            if (chckboxReq == 1) { 
                $("#plan_permission_checkbox_required_yes").attr('checked', true);
            } else {
                $("#plan_permission_checkbox_required_no").attr('checked', true);
            }
            $('#plan_permission_checkbox_order').val($(this).attr('data-order'));
            $('#plan_select_connection_type option[value='+ connectnType+']').attr('selected',true);
         
            permissionCheckboxStatus(chckboxReq);
            $("#action").val("edit");
            checkboxId = $(this).attr("data-id");
        }
    });
    let debitCheckbocValidationMsg = $('.debit_checkbox_required').val();
    let statewiseEiccheckboxMsg = $('.tele_sale_setting_checkbox_required').val();
    let acknCheckboxMsg = $('.ackn_checkbox_required').val();
    let termcondCheckboxMsg = $('.terms_checkbox_required').val();
    // let teleSaleEicContent=$('.telesale_eic_allow').attr('checked');
    let teleSaleEicContent = $("input[name='telesale_eic_allow']:checked").val();
    if (teleSaleEicContent == 1) {
        $('.teleSale_eic_content').show();
    } else {
        $('.teleSale_eic_content').hide();

    }

    function checkDebitCheckBoxValue(value) {
        if (value == 1) {
            $('.debit_checkbox_validation_message').show();
        } else {
            $('.debit_checkbox_validation_message').hide();
        }
    }
    checkDebitCheckBoxValue(debitCheckbocValidationMsg);

    $('.checkBoxEdit').click(function () {
        let checkBoxVal = $(this).attr('checkbox-value');
        console.log('---' + checkBoxVal);
        checkDebitCheckBoxValue(checkBoxVal);
    });
    $('#direct_debit_checkbox_add').click(function () {
        let value = $('.debit_checkbox_required').val();
        checkDebitCheckBoxValue(value);
    });
    function checkTeleSaleCheckboxValue(value) {
        if (value == 1) {
            $('.tele_sale_checkbox_validation_message').show();
        } else {
            $('.tele_sale_checkbox_validation_message').hide();
        }
    }
    checkTeleSaleCheckboxValue(statewiseEiccheckboxMsg);
    $('#add_tele_sale_button').click(function () {
        let value = $('.tele_sale_setting_checkbox_required').val();
        checkTeleSaleCheckboxValue(value);
    });
    $('.tele_sale_edit_checkbox').click(function () {
        let checkBoxVal = $(this).attr('checkbox-value');
        console.log('---' + checkBoxVal);
        checkTeleSaleCheckboxValue(checkBoxVal);
    });

    function acknCheckboxValue(value) {
        if (value == 1) {
            $('.ackn_checkbox_validation_message').show();
        } else {
            $('.ackn_checkbox_validation_message').hide();
        }
    }
    acknCheckboxValue(acknCheckboxMsg);
    $('#ack_checkbox_button').click(function () {
        let value = $('.ackn_checkbox_required').val();
        acknCheckboxValue(value);
    });
    $('.acknCheckBoxEdit').click(function () {
        let checkBoxVal = $(this).attr('checkbox-value');
        console.log('---' + checkBoxVal);
        acknCheckboxValue(checkBoxVal);
    });

    function termCondCheckboxValue(value) {
        if (value == 1) {
            $('.terms_and_conditions_checkbox_validation_message').show();
        } else {
            $('.terms_and_conditions_checkbox_validation_message').hide();
        }
    }
    termCondCheckboxValue(termcondCheckboxMsg);
    $('#add_checkbox_button').click(function () {
        let value = $('.terms_checkbox_required').val();
        termCondCheckboxValue(value);
    });
    $('.termCondCheckBoxEdit').click(function () {
        let checkBoxVal = $(this).attr('checkbox-value');
        console.log('---' + checkBoxVal);
        termCondCheckboxValue(checkBoxVal);
    });











    $('input[type=radio][name=state_eic_content_checkbox_required]').change(function () {
        if (this.value == '1') {
            $('.validation_message').show();
        }
        else if (this.value == '0') {
            $('.validation_message').hide();
        }
    });

    $('input[type=radio][name=tele_sale_setting_checkbox_required]').change(function () {
        if (this.value == '1') {
            $('.tele_sale_checkbox_validation_message').show();
        }
        else if (this.value == '0') {
            $('.tele_sale_checkbox_validation_message').hide();
        }
    });
    $('input[type=radio][name=debit_checkbox_required]').change(function () {
        if (this.value == '1') {
            $('.debit_checkbox_validation_message').show();
        }
        else if (this.value == '0') {
            $('.debit_checkbox_validation_message').hide();
        }
    });
    $('input[type=radio][name=telesale_eic_allow]').change(function () {
        if (this.value == '1') {
            $('.teleSale_eic_content').show();
        }
        else if (this.value == '0') {
            $('.teleSale_eic_content').hide();
        }
    });
    $('input[type=radio][name=ackn_checkbox_required]').change(function () {
        if (this.value == '1') {
            $('.ackn_checkbox_validation_message').show();
        }
        else if (this.value == '0') {
            $('.ackn_checkbox_validation_message').hide();
        }
    });

    $('input[type=radio][name=terms_checkbox_required]').change(function () {
        if (this.value == '1') {
            $('.terms_and_conditions_checkbox_validation_message').show();
        }
        else if (this.value == '0') {
            $('.terms_and_conditions_checkbox_validation_message').hide();
        }
    });

    $(document).on('change', "#select_consent_state", function (event) {
        $('span.error').html('');
        CKEDITOR.instances.statewise_consent_content.setData('');
        if ($(this).val() != "") {
            loaderInstance.show();
            var state_id = $("#select_consent_state").val()
            getStateWiseContent(state_id)
        }
    });
    $('input[type=radio][name=eic_type_checkbox]').change(function () {
        $('span.error').html('');
        $('.eic_type_checkbox').removeAttr('checked');
        var masterVal = this.value;
        CKEDITOR.instances.statewise_consent_content.setData('');
        if (masterVal == 'master') {
            console.log(this.id);
            $('#' + this.id).attr('checked', 'checked');
            $('.select_state').hide();
            loaderInstance.show();
            var state_id = 0;
            getStateWiseContent(state_id)
        }
        else if (masterVal == 'state') {
            console.log(this.id);
            $('#' + this.id).attr('checked', 'checked');
            $('.select_state').show();
            loaderInstance.show();
            $("#select_consent_state").select2("val", $("#select_consent_state").val());
            var state_id = $("#select_consent_state").val()
            getStateWiseContent(state_id)
        }
    });

    function getStateWiseContent(state_id) {
        $.ajax({
            url: '/provider/state/tele/consent',
            type: 'GET',
            data: {
                state: state_id,
                provider_id: $("#provider_id").val(),
                user_id: $("#user_id").val()
            },
            success: (data) => {
                $("#statewise_list").html('');
                list_data = {};
                list_data.list_id = "#statewise_list";
                list_data.data_target = "add_provider_state_eic_content_checkbox";
                list_data.id = "statewise_checkbox_edit";
                list_data.delete = "statewise_checkbox_delete";
                if (data.data.length != 0) {
                    // $("#add_button_show_hide").show();
                    $("#title").val(data.data[0].title);
                    CKEDITOR.instances.statewise_consent_content.setData(data.data[0].description);
                    if (data.data[0].getcontentcheckbox != null && data.data[0].getcontentcheckbox != undefined && data.data[0].getcontentcheckbox != '') {
                        for (var i = 0; i < data.data[0].getcontentcheckbox.length; i++) {
                            tableData(data.data[0].getcontentcheckbox[i], i, list_data);
                        }
                    }
                } else {
                    // $("#add_button_show_hide").hide();
                    $("#statewise_list").html(`<tr><td valign="top" colspan="6" class="text-center">There are no records to show'</td></tr>`);
                }
                loaderInstance.hide();
            },
            error: function (error) {
                loaderInstance.hide();
            }
        });
    }
    $(document).on('click', '#term_condition_submit,#provider_ackn_checkbox_submit,#tele_sale_setting_checkbox_submit,#state_eic_content_checkbox_submit,#debit_checkbox_submit, #post_submission_checkbox_submit, #plan_permission_checkbox_submit', function (event) {
        var formData = null;
        var list_data = {};
        var eic_type_value = '';
        var state_id = '';
        var form_name = '';
        loaderInstance.show();
        if (this.id == 'term_condition_submit') {
            formData = new FormData($("#terms_condition_checkbox_form")[0]);
            formData.append('type', $("#terms_and_condition_title").val());
            formData.set('terms_checkbox_content', CKEDITOR.instances.terms_checkbox_content.getData());
            formData.set('terms_condition_validates', CKEDITOR.instances.terms_condition_validates.getData());
            formData.append('form_name', 'terms_condition_checkbox_form');
            list_data.list_id = "#terms_and_cond_list";
            list_data.data_target = "add_terms_condition_checkbox";
            list_data.id = "terms_condition_edit";
            list_data.delete = "terms_condition_delete";
        }
        if (this.id == "provider_ackn_checkbox_submit") {
            formData = new FormData($("#provider_ackn_checkbox_form")[0]);
            formData.set('ackn_checkbox_content', CKEDITOR.instances.ackn_checkbox_content.getData());
            formData.set('ackn_validation_msg', CKEDITOR.instances.ackn_validation_msg.getData());
            formData.append('form_name', 'provider_ackn_checkbox_formm');
            list_data.list_id = "#ack_list";
            list_data.data_target = "add_provider_ack_checkbox";
            list_data.id = "provider_ackn_checkbox_edit";
            list_data.delete = "ack_checkbox_delete";

        }
        if (this.id == "tele_sale_setting_checkbox_submit") {
            formData = new FormData($("#provider_tele_sale_setting_checkbox_form")[0]);
            formData.set('tele_sale_setting_checkbox_content', CKEDITOR.instances.tele_sale_setting_checkbox_content.getData());
            formData.set('tele_sale_setting_validation_msg', CKEDITOR.instances.tele_sale_setting_validation_msg.getData());
            formData.append('form_name', 'tele_sale_setting_checkbox_form');
            list_data.list_id = "#tele_sale_list";
            list_data.data_target = "add_provider_tele_sale_setting_checkbox";
            list_data.id = "tele_sale_edit";
            list_data.delete = "tele_sale_checkbox_delete";
        }
        if (this.id == "state_eic_content_checkbox_submit") {
            eic_type_value = $('input[type=radio][name=eic_type_checkbox]:checked').val();
            if (eic_type_value == 'master') {
                state_id = 0;
                form_name = 'master_checkbox_form';
            }
            else if (eic_type_value == 'state') {
                state_id = $("#select_consent_state").val();
                form_name = 'state_checkbox_form';
            }
            formData = new FormData($("#provider_state_eic_content_checkbox_form")[0]);
            formData.set('state_eic_content_checkbox_content', CKEDITOR.instances.state_eic_content_checkbox_content.getData());
            formData.set('state_eic_content_validation_msg', CKEDITOR.instances.state_eic_content_validation_msg.getData());
            formData.append('form_name', form_name);
            formData.append('state', state_id);
            list_data.list_id = "#statewise_list";
            list_data.data_target = "add_provider_state_eic_content_checkbox";
            list_data.id = "statewise_checkbox_edit";
            list_data.delete = "statewise_checkbox_delete";
        }
        if (this.id == "debit_checkbox_submit") {
            formData = new FormData($("#provider_debit_checkbox_form")[0]);
            formData.set('debit_checkbox_content', CKEDITOR.instances.debit_checkbox_content.getData());
            formData.set('debit_validation_msg', CKEDITOR.instances.debit_validation_msg.getData());
            formData.append('form_name', 'debit_checkbox_form');
            list_data.list_id = "#direct_debit_list";
            list_data.data_target = "add_provider_direct_debit_checkbox";
            list_data.id = "direct_debit_checkbox_edit";
            list_data.delete = "direct_debit_checkbox_delete";
        }
        if (this.id == "post_submission_checkbox_submit") {
            formData = new FormData($("#post_submission_checkbox_form")[0]);
            formData.set('post_submission_checkbox_content', CKEDITOR.instances.post_submission_checkbox_content.getData());
            formData.set('post_submission_validation_msg', CKEDITOR.instances.post_submission_validation_msg.getData());
            formData.append('form_name', 'post_submission_checkbox_form');
            list_data.list_id = "#post_submission_list";
            list_data.data_target = "add_post_submission_checkbox";
            list_data.id = "post_submission_checkbox_edit";
            list_data.delete = "post_submission_checkbox_delete";
        }

        if (this.id == "plan_permission_checkbox_submit") {
            formData = new FormData($("#provider_plan_permission_checkbox_form")[0]);
            formData.set('plan_permission_checkbox_content', CKEDITOR.instances.plan_permission_checkbox_content.getData());
            formData.set('provider_permission_validation_msg', CKEDITOR.instances.provider_permission_validation_msg.getData());
            formData.append('form_name', 'plan_permission_checkbox_form');
            list_data.list_id = "#provider_plan_checkbox_list";
            list_data.data_target = "add_provider_plan_permission_checkbox";
            list_data.id = "plan_permission_checkbox_edit";
            list_data.delete = "plan_permission_checkbox_delete";
        }
        formData.append("provider_id", $("#provider_id").val());
        formData.append("user_id", $("#user_id").val());
        $('span.error').html('');
        if ($("#action").val() == "edit") {
            formData.append('id', checkboxId);
        }
        url = '/provider/store-update-checkbox';
        axios.post(url, formData, list_data)
            .then(function (response) {
                loaderInstance.hide();
                if (response.data.status != 400 && response.data.status != 422) {
                    console.log('==============',response.data.data[0].get_permission_checkbox);
                    toastr.success(response.data.message);
                    if (list_data.id == "terms_condition_edit") {
                        $("#terms_and_cond_list").html('');
                        $("#add_terms_condition_checkbox").modal('hide');
                    }
                    if (list_data.id == "provider_ackn_checkbox_edit") {
                        $('#checkboxes_list_count').val(response.data.data[0].getcontentcheckbox.length);
                        $("#ack_list").html('');
                        $("#add_provider_ack_checkbox").modal('hide');
                    }
                    if (list_data.id == "tele_sale_edit") {
                        $("#tele_sale_list").html('');
                        $("#add_provider_tele_sale_setting_checkbox").modal('hide');
                    }
                    if (list_data.id == "statewise_checkbox_edit") {
                        $("#statewise_list").html('');
                        $("#add_provider_state_eic_content_checkbox").modal('hide');
                    }
                    if (list_data.id == "direct_debit_checkbox_edit") {
                        $("#direct_debit_list").html('');
                        $("#add_provider_direct_debit_checkbox").modal('hide');
                    }
                    if (list_data.id == "post_submission_checkbox_edit") {
                        $("#post_submission_list").html('');
                        $("#add_post_submission_checkbox").modal('hide');
                    }
                    if (list_data.id == "plan_permission_checkbox_edit") {
                        $("#provider_plan_checkbox_list").html('');
                        $("#add_provider_plan_permission_checkbox").modal('hide');
                        CKEDITOR.instances.provider_permission_validation_msg.setData('');
                        $('#plan_select_connection_type').val('');
                        $('#plan_permission_checkbox_order').val('');
                        CKEDITOR.instances.plan_permission_checkbox_content.setData('');
                    }
                    if(list_data.id== 'plan_permission_checkbox_edit'){
                        for (var i = 0; i < response.data.data[0].get_permission_checkbox.length; i++) {
                            tableData(response.data.data[0].get_permission_checkbox[i], i, list_data);
                        }
    
                    }else{
                        for (var i = 0; i < response.data.data[0].getcontentcheckbox.length; i++) {
                            tableData(response.data.data[0].getcontentcheckbox[i], i, list_data);
                        }
                    }
                    

                }
                if (response.data.status == 400) {
                    toastr.error(response.data.message);
                    if (list_data.id == "terms_condition_edit") {
                        $("#add_terms_condition_checkbox").modal('hide');
                    }
                    if (list_data.id == "provider_ackn_checkbox_edit") {
                        $("#add_provider_ack_checkbox").modal('hide');
                    }
                    if (list_data.id == "tele_sale_edit") {
                        $("#add_provider_tele_sale_setting_checkbox").modal('hide');
                    }
                    if (list_data.id == "statewise_checkbox_edit") {
                        $("#add_provider_state_eic_content_checkbox").modal('hide');
                    }
                    if (list_data.id == "direct_debit_checkbox_edit") {
                        $("#add_provider_direct_debit_checkbox").modal('hide');
                    }
                    if (list_data.id == "post_submission_checkbox_edit") {
                        $("#add_post_submission_checkbox").modal('hide');
                    }
                    if (list_data.id == "plan_permission_checkbox_edit") {
                        $("#add_plan_permission_checkbox_button").modal('hide');
                    }
                }
            })
            .catch(function (error) {
                console.log(error);
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('[name="' + key + '"]').parent().find('span.error').empty().addClass(
                            'text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                }
                loaderInstance.hide();
            });
    });

    $(document).on('click', '#terms_condition_delete,#statewise_checkbox_delete,#tele_sale_checkbox_delete,#ack_checkbox_delete,#direct_debit_checkbox_delete,#plan_permission_checkbox_delete', function (event) {
        loaderInstance.show();
        remove = $(this);
        let id = $(this).attr("data-id");
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/provider/remove_content_checkbox',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: (data) => {
                        if (data.status == 200) {
                            toastr.success(data.message);
                            let inc = 1;
                            var siblings = remove.closest('tr').siblings();
                            remove.closest("tr").remove();
                            siblings.each(function () {
                                $(this).children("td").first().html(inc);
                                inc++
                            });
                        }
                        loaderInstance.hide();

                    },
                    error: function (error) {
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

    $(document).on("click", ".concession_provider_parameter, .statewise_select, .statewise_select_checkbox, .post_submission_parameter, .apply_popup_select, .select_tele_sale_eic,.billing_preference_select, .tele_sale_selectbox, .direct_debit_select_checkbox", function (event) {
        let selected = $(this).val();
        // 24-05-2022
        if ($(this).attr("data-id") == "concession_provider_parameter") {
            CKEDITOR.instances.concession_content.insertText(selected);
        }
        // 24-05-2022
        if ($(this).attr("data-id") == "post_submission_parameter") {
            CKEDITOR.instances.what_happen_next_content.insertText(selected);
        }
        if ($(this).attr("data-id") == "statewise_select") {
            CKEDITOR.instances.statewise_consent_content.insertText(selected);
        }
        if ($(this).attr("data-id") == "apply_popup_select") {
            CKEDITOR.instances.pop_up_content.insertText(selected);
        }
        if ($(this).attr("data-id") == "select_tele_sale_eic") {
            CKEDITOR.instances.tele_sale_setting_content.insertText(selected);
        }
        if ($(this).attr("data-id") == "billing_preference_select") {
            CKEDITOR.instances.paper_bill_content.insertText(selected);
        }
        if ($(this).attr("data-id") == "tele_sale_selectbox") {
            CKEDITOR.instances.tele_sale_setting_checkbox_content.insertText(selected);
        }
        if ($(this).attr("data-id") == "statewise_select_checkbox") {
            CKEDITOR.instances.state_eic_content_checkbox_content.insertText(selected);
        }
        if ($(this).attr("data-id") == "direct_debit_select_checkbox") {
            CKEDITOR.instances.debit_checkbox_content.insertText(selected);
        }

    });

    function tableData(data, inc, list_data) {
        console.log(data);
        let str = data.content;
        if ((str === null) || (str === '')) {
            str = '-';
        }
        else {
            str = str.toString();
            str = str.replace(/(<([^>]+)>)/ig, '');
        }
            html='';
            html+=
           `<tr>
            <td>${++inc}</td>
            <td>
                ${data.checkbox_required == 1 ? 'yes' : 'no'}
            </td>
            <td title="${str}">
                <span class="ellipses_table"> ${str}</span>
            </td>`;
            if(list_data.id== 'plan_permission_checkbox_edit'){
                html+=`<td>
                   ${data.connection_name}
                </td>`;
            }
            html+=`
            <td>
              <a href="#" class="btn btn-sm btn-light btn-active-light-primary bb" id="aaa" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
              <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
              <span class="svg-icon svg-icon-5 m-0">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                 </svg>
              </span>
              <!--end::Svg Icon--></a>
              <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                  <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a class="menu-link px-3" id="${list_data.id}" ${data.type != null && data.type != "" ? "data-eic=" + data.type : ""} data-bs-toggle="modal" data-bs-target="#${list_data.data_target}" data-id="${data.id}" data-required_checkbox="${data.checkbox_required}"
                      data-order= "${data.order}"data-save_checkbox="${data.status}" data-validation_message="${data.validation_message}" data-checkbox_content='${data.content}' ${data.connection_type != null && data.connection_type != "" ? "data-connection_type=" + data.connection_type : ""} >Edit</a>
                      <a id="${list_data.delete}" data-id="${data.id}" class="menu-link px-3">Delete</a>
                    </div>
                </div>
              <!--end::Menu-->
            </td>
           </tr> `;
        $(list_data.list_id).append(html);
        KTMenu.createInstances();
    }
    /** provider content checkboxes js end */

    /*
     * provider permission section js start
    */
    $(document).on('submit', '.provider_outbound_link_form, .provider_permission_form, .direct_debit_setting_form, .life_support_equipments_form', function (event) {
        event.preventDefault();
        var formName = $(this).closest('form').attr('name');
        if(formName == 'provider_permission_form'){
            var selected_option = $('input[name="ea_credit_score_check_allow"]:checked').val();
            if (selected_option == 0) {
                $(".credit_score_input").val('');
            }
        }
        var formData = new FormData($(this)[0]);
        var url = '/provider/update';

        formData.append('provider_id', $("#provider_id").val());
        formData.append('user_id', $("#user_id").val());
        if ($('select[name="service_type"]').val()) {
            formData.append('service_type_id', $('select[name="service_type"]').val());
        }
        else {
            formData.append('service_type_id', $("#service_id").val());
        }
        formData.append('request_from', formName);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.error').empty().text('');
                loaderInstance.show();
            },
            complete: function () {
                loaderInstance.hide();
            },
            success: (data) => {
                loaderInstance.hide();
                if (data.status == 200) {
                    toastr.success(data.message);
                    if (formName == 'provider_outbound_link_form') {
                        $('#add_provider_outbound_link').modal('hide');
                        $('#outbound_link_body').html('');
                        var i = 0;
                        var outboundlink_html = `
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                            </tr>`;
                        data.data.forEach(element => {
                            outboundlink_html = `
                                <tr>
                                    <td>${++i}</td>
                                    <td>${element.link_title}</td>
                                    <td>${element.link_url}</td>
                                    <td>${element.order}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon--></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a type="button" class="menu-link px-3 add_edit_link" data-bs-toggle="modal" data-bs-target="#add_provider_outbound_link"  data-order="${element.order}" data-title="${element.link_title}" data-url="${element.link_url}" data-action="edit" data-id="${element.id}">Edit</a>
                                                <a type="button" class="menu-link px-3 delete_link" datta-id="${element.id}">Delete</a>
                                            </div>
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>`;
                            $('#outbound_link_body').append(outboundlink_html);
                            KTMenu.createInstances();
                        });
                    } else if (formName == 'life_support_equipments_form') {
                        $('#life_support_equipments_modal').modal('hide');
                        $('#life_support_equipments_body').html('');
                        var life_support_html = `
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                            </tr>`;
                        data.data.forEach((element, index) => {
                            life_support_html = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${element.title}</td>
                                    <td><div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input change-life-support-status" data-id="${element.id}" type="checkbox" data-status="${element.status}" title="${element.status ? 'Click to disable' : 'Click to enable'}" ${element.status == 1 ? 'checked' : ''}></div></td>
                                    <td>${element.order}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon--></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a type="button" class="menu-link px-3 add_edit_equipment" data-bs-toggle="modal" data-bs-target="#life_support_equipments_modal" data-status="${element.status}" data-order="${element.order}" data-title="${element.title}" data-equipment_id="${element.life_support_equipment_id}" data-action="edit" data-id="${element.id}">Edit</a>
                                                <a type="button" class="menu-link px-3 delete_equipment" data-provider_id="${element.provider_id}" data-id="${element.id}">Delete</a>
                                            </div>
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>`;
                            $('#life_support_equipments_body').append(life_support_html);
                            KTMenu.createInstances();
                        });
                    }
                }
            },
            error: function (error) {
                loaderInstance.hide();
                $(".error").html("");
              
                if (error.status == 422) {
                    errors = error.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('[name="' + key + '"]').parent().find('span.error').empty().addClass(
                            'text-danger').text(value).fadeIn();
                    });
                    toastr.error('Please Check Errors');
                } else if (error.status == 400) {

                    toastr.error(error.responseJSON.message);
                }
                // if (error.status == 422) {
                //     errors = error.responseJSON;
                //     $.each(errors.errors, function (key, value) {
                //         $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                //     });
                //     $('html, body').animate({
                //         scrollTop: ($('.error').offset().top - 300)
                //     }, 1000);
                // } else {
                //     console.log(error)
                // }
            }
        });
    });
    /** provider permission section js end */

    /** */
    $(document).on('submit', '.manage_provider_ips_form, .allow_user_ip_form', function (event) {
        event.preventDefault();
        $('.error').empty().text('');
        var formData = new FormData($(this)[0]);
        var formName = $(this).closest('form').attr('name');
        var url = '';
        var field_empty = 'false';
        if (formName == 'manage_provider_ips_form') {
            url = '/provider/manage-ips';
        } else if (formName == 'allow_user_ip_form') {
            url = '/provider/manage-debit-info-ip';
        }

        formData.append('user_id', $("#user_id").val());
        if ($('select[name="service_type"]').val()) {
            formData.append('service_type_id', $('select[name="service_type"]').val());
        }
        else {
            formData.append('service_type_id', $("#service_id").val());
        }
        formData.append('request_from', formName);
        if (field_empty == 'false') {
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.error').empty().text('');
                    loaderInstance.show();
                },
                complete: function () {
                    loaderInstance.hide();
                },
                success: (data) => {
                    loaderInstance.hide();
                    if (data.status == 200) {
                        toastr.success(data.message);
                    }
                },
                error: function (error) {
                    loaderInstance.hide();
                    if (error.status == 422) {
                        errors = error.responseJSON;
                        $.each(errors.errors, function (key, value) {
                            $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });
                        $('html, body').animate({
                            scrollTop: ($('span.error').offset().top - 300)
                        }, 1000);
                    }
                }
            });
        }

    });
    /** */


    /*
     * Change Status
    */
    $(document).on('click', '.change-status', function (e) {
        var id = $(this).attr("data-id");
        var that = $(this);
        var url = '/provider/update-status';
        var status = 0;
        if ($(this).is(':checked'))
            status = 1;

        var formdata = new FormData();
        formdata.append("user_id", id);
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

    $(".select_options").select2({
        placeholder: "Select options",
        allowClear: true
    });

    $("#terms_and_condition_title").select2({
        placeholder: "Select",
        customClass: "not-set-class",
    });
    $("#debit_info_type").select2({
        placeholder: "Select type",
    });
    $(".logo_category_id").select2({
        placeholder: "Select category",
    });

    $(document).on('change', '.is_life_support_allow', function () {
        if ($(this).val() == 0) {
            $(".life_support_energy_type").prop("checked", false);
        }
    });

    $(document).on('change', '#service_type', function () {
        if ($(this).val() == 1) {
            $('.required_star').addClass('required');
        } else {
            $('.required_star').removeClass('required');
        }
    });

    $(document).on('click', '.add_link', function (e) {
        $('span.error').html('');
        $("#link_id").val('');
        $("#link_title").val('');
        $("#link_url").val('');
        $("#link_order").val('');
        $("#action_type").val($(this).data("action"));
    });
    $(document).on('click', '.add_edit_link', function (e) {
        console.log($(this).data("action"))
        if ($(this).data("action") == 'add') {
            $('span.error').html('');
            $("#link_id").val('');
            $("#link_title").val('');
            $("#link_url").val('');
            $("#link_order").val('');
            $("#action_type").val($(this).data("action"));
        } else {
            $('span.error').html('');
            $("#link_id").val($(this).data("id"));
            $("#link_title").val($(this).data("title"));
            $("#link_url").val($(this).data("url"));
            $("#link_order").val($(this).data("order"));
            $("#action_type").val($(this).data("action"));
        }
    });

    $(document).on('click', '.delete_contact', function (event) {
        var id = $(this).data('id');
        var user_id = $(this).data('user_id');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/provider/contact/delete/' + id,
                    type: 'GET',
                    dataType: 'JSON',
                    headers: {
                        'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id,
                        user_id
                    },
                    success: (data) => {
                        loaderInstance.hide();
                        if (data.status == true) {
                            toastr.success(data.message);
                            $('#provider_contact_body').html('');
                            var i = 0;
                            var provider_contact_html = `
                                    <tr>
                                        <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                                    </tr>`;
                            data.data.forEach(element => {
                                provider_contact_html = `<tr>
                                <td>${++i}</td>
                                <td>${element.name}</td>
                                <td>${element.email}</td>
                                <td>${element.designation}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon--></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                        <a type="button" class="menu-link px-3 edit-contact-button" data-action="edit" data-id="${element.id}" data-name="${element.name}" data-email="${element.email}" data-designation="${element.designation}" data-desc="${element.description}">Edit</a>
                                            <a type="button" class="menu-link px-3 delete_contact" data-user_id="${element.provider_id}" data-id="${element.id}">Delete</a>
                                        </div>
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>`;
                                $('#provider_contact_body').append(provider_contact_html);
                                KTMenu.createInstances();
                            });
                        }
                    },
                    error: function (error) {
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
    $(document).on('click', '.delete_link', function (event) {
        var id = $(this).data('id');
        var user_id = $(this).data('user_id');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/provider/outbound-link/' + id,
                    type: 'DELETE',
                    dataType: 'JSON',
                    headers: {
                        'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id,
                        user_id
                    },
                    success: (data) => {
                        loaderInstance.hide();
                        if (data.status == 200) {
                            toastr.success(data.message);
                            $('#outbound_link_body').html('');
                            var outboundlink_html = `
                                <tr>
                                    <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                                </tr>`;
                            data.data.forEach(element => {
                                outboundlink_html = `
                                    <tr>
                                        <td>${element.id}</td>
                                        <td>${element.link_title}</td>
                                        <td>${element.link_url}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon--></a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a type="button" class="menu-link px-3 add_edit_link" data-bs-toggle="modal" data-bs-target="#add_provider_outbound_link"  data-order="${element.order}" data-title="${element.link_title}" data-url="${element.link_url}" data-action="edit" data-id="${element.id}">Edit</a>
                                                    <a type="button" class="menu-link px-3 delete_link" data-id="${element.id}">Delete</a>
                                                </div>
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                    </tr>`;
                                $('#outbound_link_body').append(outboundlink_html);
                                KTMenu.createInstances();
                            });
                        }
                    },
                    error: function (error) {
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

    $(document).on('click', '#view-provider', function (event) {
        var url = $(this).data('url');
        $('#provider-detail .modal-body').attr('data-kt-indicator', 'on');
        axios.get(url)
            .then(function (response) {
                setTimeout(function () {
                    $('#provider-detail .modal-body').attr('data-kt-indicator', 'off');
                    $('#provider-detail .modal-body').append(response.data)
                }, 1000)
            })
            .catch(function (error) {
                $('#provider-detail .modal-body').attr('data-kt-indicator', 'off');
                console.log(error);
            })
            .then(function () {

            });
    });
    $('#provider-detail').on('hidden.bs.modal', function (e) {
        $('#provider-detail .modal-body').html('<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>');
    });
    /**
     * Start Provider Custom Field
     */
    $(document).on('submit', '#custom_field_form,#connection_custom_field_form', function (event) {
        event.preventDefault();
        var id = null;
        tables = null;
        if ($(this).attr('id') == 'custom_field_form') {
            let myForm = document.getElementById('custom_field_form');
            var formData = new FormData(myForm);
            formData.append('section_id', 1);
            formData.append('form_request', 'personal_form');
            tables = 'personal_form';
            id = $('#custom_field_submit').data('id');
        }
        if ($(this).attr('id') == 'connection_custom_field_form') {
            let myForm = document.getElementById('connection_custom_field_form');
            var formData = new FormData(myForm);
            formData.append('section_id', 2);
            formData.append('form_request', 'connection_form');
            tables = 'connection_form';
            id = $("#connection_custom_field_submit").data('id');
        }
        formData.append("user_id", $("#user_id").val());
        if (id)
            formData.append('id', id);
        url = '/provider/create_update/custom/field';
        axios.post(url, formData)
            .then(function (data) {
                $("#add_provider_custom_field").modal('hide');
                $("#connection_custom_field_add").modal('hide');
                var i = 0;
                if (data.data.status == 200) {
                    if (tables == 'personal_form') {
                        $('#custom_field_body').html("");
                    }
                    if (tables == 'connection_form') {
                        $('#connection_custom_field_body').html("");
                    }
                    toastr.success(data.data.message);
                    data.data.data.forEach(element => {
                        if (tables == 'personal_form') {
                            commonCustomField(++i, element);
                        }
                        if (tables == 'connection_form') {
                            connectionCustomField(++i, element);

                        }

                    });
                }
            })
            .catch(function (error) {
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('[name="' + key + '"]').parent().find('span.error').empty().addClass(
                            'text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                } else if (error.response.status == 400) {

                    toastr.error(error.response.message);
                }
            });
    });


    $(document).on('click', '.edit_custom_fields', function () {
        $("#custom_field_submit").data('id', $(this).data('id'));
        $("#custom_field_message").val($(this).attr("data-message"));
        $("#custom_field_placeholder").val($(this).attr("data-placeholder"));
        $("#custom_field_label").val($(this).attr("data-label"));
        $("input[name=custom_field_mandatory][value=" + $(this).data('mandatory') + "]").prop('checked', true);
        //   $('.custom_field_mandatory').prop('checked', $(this).data('mandatory'));
        $("#add_provider_custom_field").modal('show');

    });

    $(document).on('click', '.edit_connection_custom_fields', function () {
        $('span.error').html('');
        $("#connection_custom_field_submit").data('id', $(this).data('id'));
        $("#connection_custom_field_quest").val($(this).data('question'));
        $('#connection_custom_field_message').val($(this).data('message'));
        $("input[name=connection_custom_field_mandatory][value=" + $(this).data('mandatory') + "]").prop('checked', true);
        // $('#connection_custom_field_mandatory').prop('checked', $(this).data('mandatory'));
        $("#connection_custom_field_type").val($(this).data("answer_type")).change();
        if ($(this).data("answer_type") == 2) {
            $(".count").show();
            $("#connection_custom_field_count").val($(this).data('count')).change();
        } else {
            $("#connection_custom_field_count").val('').change();
            $(".count").hide();
        }

        $("#connection_custom_field_add").modal('show');
    });

    $("#add_provider_custom_field").on('hidden.bs.modal', function () {
        $('#custom_field_submit').data('id', '');
        $('span.error').html('');
        $("#custom_field_message").val('');
        $("#custom_field_placeholder").val('');
        $("#custom_field_label").val('');
        $("input[name=custom_field_mandatory][value=1]").prop('checked', true);
        //$('#custom_field_mandatory').prop('checked', false);
    });
    $("#connection_custom_field_add").on('hidden.bs.modal', function () {
        $("#connection_custom_field_submit").data('id', '');
        $("input[name=connection_custom_field_mandatory][value=1]").prop('checked', true);
        //$('#connection_custom_field_mandatory').prop('checked', false);
        $('span.error').html('');
        $("#connection_custom_field_type").val('').change();
        $("#connection_custom_field_count").val('').change();
        $(".count").hide();
        $("#connection_custom_field_quest").val('');
        $('#connection_custom_field_message').val('');
    });


    function commonCustomField(inc, insertData) {
        const arrayColumn = (array, column) => {
            return array.map(item => item[column]);
        };
        const planString = arrayColumn(insertData.custom_plan_section, 'plan_id');
        let insert = ` <tr>
        <td>${inc}</td>
        <td>${insertData.label}</td>
        <td>${insertData.placeholder}</td>
        <td>${insertData.mandatory == 1 ? "Yes" : "No"}</td>
        <td> <button type="button" class="btn btn-light-primary me-3 custom_field_assign_plan"  data-plans="${planString.toString()}" data-id=${insertData.id}>+Add / View</button></td>
        <td class="text-center">
        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
            <span class="svg-icon svg-icon-5 m-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </a>
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a type="button" class="menu-link px-3 edit_custom_fields" data-placeholder='${insertData.placeholder}' data-label='${insertData.label}' data-id='${insertData.id}' data-mandatory='${insertData.mandatory}' data-message='${insertData.message}'>Edit</a>
                <a type="button" class="menu-link px-3 delete_custom_fields" data-id=${insertData.id}>Delete</a>
            </div>
        </div>
        <!--end::Menu-->
    </td>
     </tr>`;
        $('#custom_field_body').append(insert);
        KTMenu.createInstances();
    }

    function connectionCustomField(inc, insertData) {
        let insert = ` <tr>
        <td>${inc}</td>
        <td>${insertData.answer_type == 1 ? 'Radio Button' : 'Textbox'}</td>
        <td>${insertData.mandatory == 1 ? "Yes" : "No"}</td>
        <td class="text-center">
          <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
          <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
             <span class="svg-icon svg-icon-5 m-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                </svg>
             </span>
             <!--end::Svg Icon-->
          </a>
          <!--begin::Menu-->
          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
            <a type="button" class="menu-link px-3 edit_connection_custom_fields" data-mandatory='${insertData.mandatory}' data-answer_type='${insertData.answer_type}' data-id='${insertData.id}' data-count='${insertData.count}' data-question='${insertData.question}' data-message='${insertData.message}'>Edit</a>
            <a type="button" class="menu-link delete_custom_fields" data-id='${insertData.id}'>Delete</a>
            </div>
          </div>
          <!--end::Menu-->
        </td>
     </tr>`;
        $('#connection_custom_field_body').append(insert);
        KTMenu.createInstances();
    }
    $(document).on('click', '.delete_custom_fields', function (event) {
        remove = $(this);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                loaderInstance.show();
                var formData = new FormData();
                formData.append("id", $(remove).data('id'));
                url = '/provider/delete/custom/field';
                axios.post(url, formData)
                    .then(function (data) {
                        if (data.status == "200") {
                            toastr.success(data.data.message);
                            let inc = 1;
                            var siblings = remove.closest('tr').siblings();
                            remove.closest("tr").remove();
                            siblings.each(function () {
                                $(this).children("td").first().html(inc);
                                inc++
                            });
                        }
                        loaderInstance.hide();
                    }).catch(function (error) {
                        loaderInstance.hide();

                    });
            }
        })
    });
    $(document).on('click', '#connection_custom_field_type', function () {
        if ($(this).val() == 2) {
            $(".count").show();
        } else {
            $(".count").hide();
        }
    })
    var plans = '';
    $(document).on('click', '.custom_field_assign_plan', function (event) {
        var assigned_plan = String($(this).data('plans'));
        assigned_plan = assigned_plan.split(',');
        $("#custom_field_plan_submit").data('id', $(this).data('id'));
        if (plans == '') {
            var formData = new FormData();
            formData.append("user_id", $("#user_id").val());
            url = '/provider/get-plans';
            axios.post(url, formData)
                .then(function (response) {
                    if (response.data.data != null) {
                        $.each(response.data.data, (key, value) => {
                            plans += `<option value="${key}">${value}</option>`;
                        });
                        $("#connection_custom_field_plan").html(plans).change();
                        $("#connection_custom_field_plan").val(assigned_plan).change();
                        $("#add_custom_fields_plans").modal('show');
                    } else {
                        $("#add_custom_fields_plans").modal('hide');
                        toastr.error('No plans available for this provider.');
                    }
                }).catch(function (error) { });

        } else {
            $("#connection_custom_field_plan").val(assigned_plan).change();
            $("#add_custom_fields_plans").modal('show');
        }

    });
    $("#add_custom_fields_plans").on('hidden.bs.modal', function () {
        $("#custom_field_plan_submit").data('id', '');
    });
    $(document).on('click', "#custom_field_plan_submit", function (event) {
        var formData = new FormData();
        formData.append('options', $("#connection_custom_field_plan").val());
        formData.append("user_id", $("#user_id").val());
        id = $(this).data('id');
        if (!id) {
            toastr.error('Something went Wrong.Please refresh page');
        } else {
            formData.append('id', id);
            url = '/provider/assigned-plans';
            axios.post(url, formData)
                .then(function (data) {
                    $("#add_custom_fields_plans").modal('hide');
                    if (data.data.status == 200) {
                        var i = 0;
                        $('#custom_field_body').html("");
                        data.data.data.forEach(element => {
                            commonCustomField(++i, element);
                        });
                    }

                }).catch(function (error) { });
        }

    })
    $("#add_custom_fields_plans,#add_provider_custom_field,#connection_custom_field_add,#add_provider_logo_modal").modal({ backdrop: "static ", keyboard: false });


    /**
     * End Provider Custom Field
     */

    $(document).on('click', '.delete_equipment', function (event) {
        var id = $(this).data('id');
        var provider_id = $(this).data('provider_id');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes"
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/provider/life-support-equipment/' + id,
                    type: 'DELETE',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id,
                        provider_id
                    },
                    success: (data) => {
                        loaderInstance.hide();
                        if (data.status == 200) {
                            toastr.success(data.message);
                            $('#life_support_equipments_body').html('');
                            var life_support_html = `
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show'</td>
                            </tr>`;
                            data.data.forEach((element, index) => {
                                life_support_html = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${element.title}</td>
                                    <td><div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input change-life-support-status" data-id="${element.id}" type="checkbox" data-status="${element.status}" title="${element.status ? 'Click to disable' : 'Click to enable'}" ${element.status == 1 ? 'checked' : ''}></div></td>
                                    <td>${element.order}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon--></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a type="button" class="menu-link px-3 add_edit_equipment" data-bs-toggle="modal" data-bs-target="#life_support_equipments_modal" data-order="${element.order}" data-order="${element.status}" data-title="${element.title}" data-equipment_id="${element.life_support_equipment_id}" data-action="edit" data-id="${element.id}">Edit</a>
                                                <a type="button" class="menu-link px-3 delete_equipment" data-provider_id="${element.provider_id}" data-id="${element.id}">Delete</a>
                                            </div>
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>`;
                                $('#life_support_equipments_body').append(life_support_html);
                                KTMenu.createInstances();
                            });
                        }
                    },
                    error: function (error) {
                        loaderInstance.hide();
                    }
                });
            }
        });

    });

    $(document).on('click', '.change-life-support-status', function () {
        var isChecked = $(this).is(':checked');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to change life support equipment status",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.get("/provider/change-life-support-status/" + $(this).attr('data-id'))
                    .then((response) => {
                        if (response.data.status == true) {
                            $(this).attr('title', isChecked ? 'Click to disable' : 'Click to enable');
                            toastr.success(response.data.message);
                        } else {
                            $(this).prop('checked', !isChecked);
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        $(this).prop('checked', !isChecked);
                        toastr.error('Whoops! something went wrong.');
                    })
                    .then(function () {
                    });
            } else {
                $(this).prop('checked', !isChecked);
            }
        });
    });

    $(document).on('click', '.add_edit_equipment', function (e) {
        if ($(this).data("action") == 'add') {
            $('span.error').html('');
            $("#life_support_equipments_form #equipment").val('');
            $("#life_support_equipments_form #equipment_id").val('');
            $("#life_support_equipments_form #status").val(0);
            $("#life_support_equipments_form #order").val('');
            $("#life_support_equipments_form #action_type").val($(this).data("action"));
        } else {
            $('span.error').html('');
            $("#life_support_equipments_form #equipment").val($(this).data("equipment_id"));
            $("#life_support_equipments_form #equipment_id").val($(this).data("id"));
            $("#life_support_equipments_form #status").val($(this).data("status"));
            $("#life_support_equipments_form #order").val($(this).data("order"));
            $("#life_support_equipments_form #action_type").val($(this).data("action"));
        }
    });

    $(document).on('change', '.debit_checkbox_required', function () {
        if ($(this).val() == '1') {
            $(".debit_validation_msg_div").css('display', 'block');
        } else if ($(this).val() == '0') {
            $(".debit_validation_msg_div").css('display', 'none');
        }
    });

    $("#add_provider_direct_debit_checkbox").on('hidden.bs.modal', function () {
        $(".debit_validation_msg_div").css('display', 'none');
    });
    $(document).on('click', "#add_providers_logo", function (event) {
        $("#logo_cancel").trigger('click');
        $("#logo_remove").trigger('click');
        getProviderCategory(null);

    });

    $(document).on("click", "#provider_logo_submit", function (event) {
        let selectedCategory = $('#category_id :selected').val();
        if(selectedCategory == ""){
            $('.category_id_error').empty().addClass('text-danger').text('Please Select Category First.').finish().fadeIn();
            toastr.error('Please Check Errors');
            return false;
        }
        $(this).attr('data-kt-indicator', 'on');
        $("#provider_logo_submit").prop('disabled', true);
        let myForm = document.getElementById('provider_logo_form');
        let formData = new FormData(myForm);
        id = $("#provider_logo_submit").data('id');
        if (id) {
            formData.append('id', id);
        }
        formData.append('provider_id', $("#user_id").val());
        url = '/provider/save-provider-logo';
        axios.post(url, formData)
            .then(function (data) {
                console.log(data.data);
                if (data.data.status == 200) {
                    toastr.success(data.data.message);
                    var i = 0;
                    $("#provider_logo_body").html('');
                    data.data.data.forEach(element => {
                        providerLogoTable(++i, element);
                    });
                }
                $("#add_provider_logo_modal").modal('hide');
                $("#provider_logo_submit").attr('data-kt-indicator', 'off');
                $("#provider_logo_submit").prop('disabled', false);
            })
            .catch(function (error) {
                console.log(error);
                $(".error").html("");
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                    toastr.error('Please Check Errors');
                }
                else if (error.response.status == 400) {
                    console.log(error.response);
                }
                $("#provider_logo_submit").attr('data-kt-indicator', 'off');
                $("#provider_logo_submit").prop('disabled', false);
            });

    });

    $(document).on('click', '.provider_logo_edit', function (event) {
        $("#provider_logo_submit").data('id', $(this).data('id'));
        $(".image-input-wrapper").css("background-image", `url('${$(this).data("url")}')`);
        $("#logo_description").val($(this).data('description'));
        appendData = {
            'id': $(this).data('category'),
            'title': $(this).data('title')
        }
        getProviderCategory(appendData);
    });
    $("#add_provider_logo_modal").on('hidden.bs.modal', function () {
        $("#provider_logo_submit").data('id', '');
        $("#logo_description").val('');
        $(".logo_dimensions").text(' ');
        $('.error').html('');
    });

    function getProviderCategory(appendData) {
        let formData = new FormData();
        formData.append('provider_id', $("#user_id").val());
        url = '/provider/get-category';
        axios.post(url, formData)
            .then(function (data) {

                options = '<option value="">Please Select</option>';
                if (appendData) {
                    options += `<option value=${appendData.id}>${appendData.title}</option>`;
                }
                $.each(data.data, function (key, value) {
                    options += `<option value=${value.id}>${value.title}  (W: ${value.width} x H: ${value.height})</option>`
                });
                $("#category_id").html(options).select2();
                if (appendData) {
                    $("#category_id").val(appendData.id).select2();
                }
                $("#add_provider_logo_modal").modal('show');
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function providerLogoTable(i, row) {
        insert = `<tr>
                        <td>${i}</td>
                        <td>
                            <img src="${row.name}" alt="1st Energy logo" width="50px">
                        </td>
                        <td>${row.description ? row.description : 'N/A'}</td>
                        <td>${row.title}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a class="menu-link px-3 provider_logo_edit"  data-id="${row.id}" data-url="${row.name}" data-description="${row.description}" data-title="${row.title}" data-category="${row.category_id}">Edit</a>
                                    <a href="" class="menu-link px-3">Delete</a>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>`;
        $('#provider_logo_body').append(insert);
        KTMenu.createInstances();
    }

    $(document).on('change', '.debit_checkbox_required', function () {
        if ($(this).val() == '1') {
            $(".debit_validation_msg_div").css('display', 'block');
        } else if ($(this).val() == '0') {
            $(".debit_validation_msg_div").css('display', 'none');
        }
    });

    $("#add_provider_direct_debit_checkbox").on('hidden.bs.modal', function () {
        $(".debit_validation_msg_div").css('display', 'none');
    });

    $(document).on('change', '.content_allow_status_btn', function () {
        // console.log(123);
        if ($(this).val() == '1') {
            $(".show_billing_parameters_div").css('display', 'block');
        } else if ($(this).val() == '0') {
            $(".show_billing_parameters_div").css('display', 'none');
        }
    });

    $('#add_contact').on('hidden.bs.modal', function (e) {
        $(this).find('form').trigger('reset');
        $("[name='contactId']").val("");
    });
    let providerPlanConnectionStatus=$('input[type=radio][name=connection_allow]:checked').val();
    function planConnectionStatus(val){
        if(val==1){
            $('.plan_permsn_connectn_script_class').show();
        }else{
            $('.plan_permsn_connectn_script_class').hide();
        }
    }
    planConnectionStatus(providerPlanConnectionStatus);
    $(document).on('change', '.connectionClass', function () {
        planConnectionStatus($(this).val());
        
    });

    let providerPortStatus=$('input[type=radio][name=port_allow]:checked').val();
    function planPortStatus(val){
        if(val==1){
            $('.port_script_class').show();
        }else{
            $('.port_script_class').hide();
        }
    }
    planPortStatus(providerPortStatus);
    $(document).on('change', '.port_allow_class', function () {
        planPortStatus($(this).val());
        
    });


    let providerRecontractStatus=$('input[type=radio][name=retention_allow]:checked').val();
    function planRecontratStatus(val){
        if(val==1){
            $('.recontract_script_class').show();
        }else{
            $('.recontract_script_class').hide();
        }
    }
    planRecontratStatus(providerRecontractStatus);
    $(document).on('change', '.recontract_allow_radio_class', function () {
        planRecontratStatus($(this).val());
        
    });

    $('#add_plan_permission_checkbox_button').click(function(){
        let userId=$(this).attr('data-user-id');
        let data={
            'user_id':userId
        }
        url='/provider/check-get-permission'
        if(userId!=''){
            axios.post(url, data)
            .then(function (data) {

                if(data.data.status==true){
                    $('#plan_permission_checkbox_required_yes').attr('checked',true);
                    $('#add_provider_plan_permission_checkbox').modal('show');
                }else if(data.data.status==false){
                    toastr.error(data.data.message);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }
      
    });


    function permissionCheckboxStatus(val){
        if(val==1){
            $('.plan_permission_checkbox_validation_message').show();
        }else{
            $('.plan_permission_checkbox_validation_message').hide();
        }
    }
    // permissionCheckboxStatus(providerPermsnCheckboxStatus);
    $(document).on('change', '.permsn_checkbox_class', function () {
        $('.permsn_checkbox_class').attr('checked',false);
        $('#'+$(this).attr('id')).attr('checked',true);
        permissionCheckboxStatus($(this).val());
        
    });

    let sclerosisStatus=$('input[type=radio][name=other_setting_sclerosis_status]:checked').val();
    function checkSclerosisStatus(val){
        if(val==1){
            $('.other_setting_sclerosis_title').show();
        }else{
            $('.other_setting_sclerosis_title').hide();
        }
    }
    checkSclerosisStatus(sclerosisStatus);
    $(document).on('change', '.other_setting_sclerosis_status', function () {
        checkSclerosisStatus($(this).val());
        
    });

    let medicalCoolingStatus=$('input[type=radio][name=other_setting_medical_cooling_status]:checked').val();
    function checkMedicalCoolingStatus(val){
        if(val==1){
            $('.other_setting_medical_cooling_title').show();
        }else{
            $('.other_setting_medical_cooling_title').hide();
        }
    }
    checkMedicalCoolingStatus(medicalCoolingStatus);
    $(document).on('change', '.other_setting_medical_cooling_status', function () {
        checkMedicalCoolingStatus($(this).val());
        
    });

    $(document).on('submit', '.genrate_token_form', function (event) {
        event.preventDefault();
        $('.error').empty().text('');
        var formData = new FormData($(this)[0]);
        var formName = $(this).closest('form').attr('name');
        var url = '/provider/manage-token';
        formData.append('user_id', $("#user_id").val());
        formData.append('request_from', formName);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to generate Provider Token",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('.error').empty().text('');
                        loaderInstance.show();
                    },
                    complete: function () {
                        loaderInstance.hide();
                    },
                    success: (data) => {
                        loaderInstance.hide();
                        if (data.status == 200) {
                            toastr.success(data.message);
                            $("#token").val(data.token);
                        }
                    },
                    error: function (error) {
                        loaderInstance.hide();
                        if (error.status == 422) {
                            errors = error.responseJSON;
                            $.each(errors.errors, function (key, value) {
                                $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            });
                            $('html, body').animate({
                                scrollTop: ($('span.error').offset().top - 300)
                            }, 1000);
                        }
                    }
                });
            }
        });
    });
    let idValue='';
    CKEDITOR.on('instanceReady', function(ev) {						
     
        $(document).on('click','.cke_button_off',function(){
            idValue= $(this).closest('.modal').attr('id');
             $('#'+idValue).css('display','none');
    });
    $(document).on('click', '.cke_dialog_ui_button_ok , .cke_dialog_ui_button_cancel, .cke_dialog_close_button', function () { 
        let focusId=$('.cke_focus').attr('id');
       let modifyId=focusId.replace('cke_','cke_editor_');
       let finalId =modifyId.concat('_dialog');
        if($('.'+finalId).css('display')=='none'){
            $('#'+idValue).css('display','block');
        }
    
    });
    });
       
  
  
});
