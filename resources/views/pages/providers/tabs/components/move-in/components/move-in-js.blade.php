<script>
    
    /* Movin provider data start here */
    moveInEnergy = null;
    movein_content = {};

    thiss = null;

    $(document).on('click', '.moveincontent', function() {
        loaderInstance.show();
        thiss = this;
        var formdata = new FormData();
        var providerId = '{{request()->segment(3)}}';
        formdata.append("providerid", providerId);
        formdata.append("distributor", $("#move_in_elec_distributor").val());
        formdata.append("energy_type", $("#move_in_energy_type").val());
        if ($(thiss).attr("data-prop") == 1) {
            formdata.append("property_type", 1);
        } else if ($(thiss).attr("data-prop") == 2) {
            formdata.append("property_type", 2);
        }
        axios.post("/provider/provider-movin-details", formdata)
            .then(function(response) {
                loaderInstance.hide();
                if (response.data.data.length) {
                    if ($(thiss).attr("data-type") == 'move_in_eic_content') {
                        CKEDITOR.instances.move_in_content.setData(response.data.data[0].move_in_eic_content);
                    } else if ($(thiss).attr("data-type") == 'move_in_content') {
                        CKEDITOR.instances.move_in_content.setData(response.data.data[0].move_in_content);
                    }
                } else {
                    CKEDITOR.instances.move_in_content.setData('');
                }

                $('#moveincontent').modal('show');
            }).catch(function(error) {
            loaderInstance.hide();
            if (error.response.status == 422) {
                showValidationMessages(error.response.data.errors)
            }
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        })


    });

    $(document).on('click', '#save_movin_content', function() {
        //if content is empty and enable button is checked
        if (CKEDITOR.instances['move_in_content'].getData() == "" && $("input[name='movin_status']:checked").val() != 0) {
            var movin_type = $(thiss).attr("data-type");
            var message = 'Please enter the move in content';
            if (movin_type == 'move_in_eic_content') {
                message = 'Please enter the move in eic content';
            }
            //show error
            $('#move_in_content_error').html(message).show();
            return false;
        } else {
            var formdata = new FormData();
            var providerId = '{{request()->segment(3)}}';
            formdata.append("providerid", providerId);
            formdata.append("distributor", $("#move_in_elec_distributor").val());
            formdata.append("energy_type", $("#move_in_energy_type").val());
            if ($(thiss).attr("data-type") == 'move_in_content') {
                formdata.append("move_in_content", CKEDITOR.instances['move_in_content'].getData());
                formdata.append("movin_status", $("input[name='movin_status']:checked").val());
            }
            if ($(thiss).attr("data-type") == 'move_in_eic_content') {
                formdata.append("move_in_eic_content", CKEDITOR.instances['move_in_content'].getData());
                formdata.append("move_in_eic_content_status", $("input[name='movin_status']:checked").val());
            }
            formdata.append("property_type", $(thiss).attr("data-prop"));
            //send ajax to update move in content and its status
            axios.post("/provider/save-eic_content_data", formdata).then(function(response) {
                loaderInstance.hide();
                if ($(thiss).attr("data-prop") == 1) {
                    $("#residence_id").val(response.data.data);
                } else if ($(thiss).attr("data-prop") == 2) {
                    $("#sme_id").val(response.data.data);
                }
                $('#moveincontent').modal('hide');
            }).catch(function(error) {
                loaderInstance.hide();
                if (error.response.status == 422) {
                    showValidationMessages(error.response.data.errors)
                }
                if (error.response.status && error.response.data.message)
                    toastr.error(error.response.data.message);
                else
                    toastr.error('Whoops! something went wrong.');
            })

        }
    });

    //when attributes are selected from attribute list
    $(document).on('change', '#move_in_attribute', function() {
        var selected = jQuery('#move_in_attribute :selected').val();
        CKEDITOR.instances['move_in_content'].insertHtml(selected);
    });

	$(document).on('change', "#move_in_elec_distributor", function(event) {
		var formdata = new FormData();
		loaderInstance.show();
		var providerId = '{{request()->segment(3)}}';
		formdata.append("providerid", providerId);
		formdata.append("distributor", $("#move_in_elec_distributor").val());
		formdata.append("energy_type", $("#move_in_energy_type").val());
		axios.post("/provider/provider-movin-details", formdata)
			.then(function(response) {
				loaderInstance.hide();
				console.log(response.data.data);
				check1 = 0;
				check2 = 0;
				$.each(response.data.data, function(key, value) {
					
					if(value.name)
						$("#selected_distributor").html(value.name);
					else
						$("#selected_distributor").html('Other Distributor');
					if (value.energy_type == 1) {
						$(".td_energy_type").html('Electricity');
					}
					else{
						$(".td_energy_type").html('Gas');

					}
					if (value.property_type == 1) {
						if (value.grace_day != null) {
							console.log('tt');console.log(value.grace_day);
							$("#day_interval_residence").val(value.grace_day);
							$("#restrict_residence_time").val(value.restricted_start_time);
						} else {
							$("#day_interval_residence").val('');
							$("#restrict_residence_time").val("0:00");

						}
						$("#residence_id").val(value.id);
						check1 = 1;
					}
					if (value.property_type == 2) {
						if (value.grace_day != null) {
							$("#day_interval_bussiness").val(value.grace_day);
							$("#restrict_bussiness_time").val(value.restricted_start_time);
						} else {
							$("#day_interval_bussiness").val('');
							$("#restrict_bussiness_time").val("0:00");
						}

						$("#sme_id").val(value.id);
						check2 = 1;
					}
					movein_content[key] = value;
					if (check1 != 1) {

						$("#day_interval_residence").val('');
						$("#residence_id").val('');
						$("#restrict_residence_time").val("0:00");
					}
					if (check2 != 1) {

						$("#day_interval_bussiness").val('');
						$("#sme_id").val('');
						$("#restrict_bussiness_time").val("0:00");
					}


				});
				if (response.data.data.length == 0) {
				
					movein_content = {};
					$("#selected_distributor").html($("#move_in_elec_distributor option:selected").text());
					$(".td_energy_type").html($("#move_in_energy_type option:selected").text());
					

					$("#sme_id").val("");
					$("#residence_id").val("");
					$("#day_interval_bussiness").val('');
					$("#day_interval_residence").val('');
					$("#restrict_bussiness_time").val("0:00");
					$("#restrict_residence_time").val("0:00");
				}
				// toastr.success(response.data.message)
			}).catch(function(error) {
				loaderInstance.hide();
				if (error.response.status == 422) {
					showValidationMessages(error.response.data.errors)
				}
				if (error.response.status && error.response.data.message)
					toastr.error(error.response.data.message);
				else
					toastr.error('Whoops! something went wrong.');
			})
	});
	$(document).on('change', "#move_in_energy_type", function(event) {
		var formdata = new FormData();
		loaderInstance.show();
		var providerId = '{{request()->segment(3)}}';
		formdata.append("provider_id", providerId);
		formdata.append("energy_type", $(this).val());
		axios.post("/provider/get_distibutors", formdata).then(function(response) {
			loaderInstance.hide();
			options = '<option value="0">Other distributor(Default)</option>';
			$.each(response.data.distributor, function(key, value) {
				options += `<option value="${value.id}">${value.name}</option>`;

			});
			$("#move_in_elec_distributor").empty().append(options);
			if (response.data.residence.length != 0) {
				$("#residence_id").val(response.data.residence[0].id);
				if (response.data.residence[0].grace_day != null) {
					$("#day_interval_residence").val(response.data.residence[0].grace_day);
					$("#restrict_residence_time").val(response.data.residence[0].restricted_start_time);

				} else {
					$("#day_interval_residence").val('');
					$("#restrict_residence_time").val("0:00");
				}
			} else {
				$("#residence_id").val("");
				$("#day_interval_residence").val('');
				$("#restrict_residence_time").val("0:00");
			}
			if (response.data.sme.length != 0) {
				$("#sme_id").val(response.data.sme[0].id);
				if (response.data.sme[0].grace_day != null) {
					$("#day_interval_bussiness").val(response.data.sme[0].grace_day);
					$("#restrict_bussiness_time").val(response.data.sme[0].restricted_start_time);
				} else {
					$("#day_interval_bussiness").val('');
					$("#restrict_bussiness_time").val("0:00");
				}

			} else {
				$("#sme_id").val("");
				$("#day_interval_bussiness").val('');
				$("#restrict_bussiness_time").val("0:00");
			}

		}).catch(function(error) {
			loaderInstance.hide();
			if (error.response.status == 422) {
				showValidationMessages(error.response.data.errors)
			}
			if (error.response.status && error.response.data.message)
				toastr.error(error.response.data.message);
			else
				toastr.error('Whoops! something went wrong.');
		})
	});

    /*
     * start intialize flatpicker
     */
    $("#restrict_bussiness_time").flatpickr({
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        dateFormat: "H:i",
        defaultMinute: 5

    });
    $("#restrict_residence_time").flatpickr({
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        dateFormat: "H:i",
        defaultMinute: 5


    });
    /*
     * end intialize flatpicker
     */

    $(document).on('click', "#grace_day", function(event) {
        loaderInstance.show();
        var providerId = '{{request()->segment(3)}}';
        var formdata = new FormData();
        formdata.append("sme_id", $("#sme_id").val());
        formdata.append("residence_id", $("#residence_id").val());
        formdata.append("providerid", providerId);
        formdata.append("day_interval_residenced", $("#day_interval_residence").val());
        formdata.append("day_interval_bussiness", $("#day_interval_bussiness").val());
        formdata.append("distributor", $("#move_in_elec_distributor").val());
        formdata.append("energy_type", $("#move_in_energy_type").val());
        formdata.append("restrict_bussiness", $("#restrict_bussiness_time").val());
        formdata.append("restrict_residence", $("#restrict_residence_time").val());
        formdata.append("type", 'day');
        axios.post("/provider/grace-day", formdata)
            .then(function(response) {
                loaderInstance.hide();
                toastr.success(response.data.message);


                if (response.data.data.residence.name == 'residence') {
                    $("#residence_id").val(response.data.data.residence.id);
                }
                if (response.data.data.sme.name == 'sme') {
                    $("#sme_id").val(response.data.data.sme.id);

                }
            }).catch(function(error) {
            loaderInstance.hide();
            if (error.response.status == 422) {
                showValidationMessages(error.response.data.errors)
            }
            if (error.response.status && error.response.data.message)
                toastr.error(error.response.data.message);
            else
                toastr.error('Whoops! something went wrong.');
        })
    });

    /* Movin provider data end here */
</script>
