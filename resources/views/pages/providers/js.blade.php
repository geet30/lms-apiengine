<script>
	let postcodeData = {};
	$(document).on('submit', '.submitsubmitAffiliate', function(e) {
		e.preventDefault();
		CardLoaderInstance.show('.tab-content');
		let myForm = document.getElementById('affiliateFilter');
		let formData = new FormData(myForm);
		formData.append('providerservice', 1);
		formData.append('requesttype', 'affiliates');
		var url = "/provider/assign-providers-affiliates";
		axios.post(url, formData)
			.then(function(response) {
				$(".error").html("");
				if (response.data.status == 200) {
					toastr.success(response.data.message);
					$('.affiliateTabledata').empty();
					if (response.data.result.length > 0) {
						var users = ``;
						$.each(response.data.result, function(key, val) {
							checked = '';
							if (val.status == 1) {
								checked = 'checked'
							}
							users += `
					<tr>
					<td>${val.company_name}</td>
					<td>${val.assignedby}</td>
					<td>
						<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
							<input class="form-check-input sweetalert_demo change-provider-status" type="checkbox"  ${checked}  data-id="${val.id}">
						</div>
					</td>
					<td class="text-end">
						<a class="deletemanageprovider" data-id="${val.id}" data-relation="${val.relationaluser}" data-service="${val.servive_id}" data-source="${val.source_user_id}" title="Delete">
							<i class="bi bi-trash fs-2 mx-1 text-primary"></i>
						</a>
					</td>
					</tr>
					`;
						});
					}
					$('.affiliateTabledata').append(users);

					$('.multipleaffiliates').empty();
					var html = ``;
					if (response.data.users.length > 0) {
						html += `<option value="all">Select All</option>`;
						$.each(response.data.users, function(key, val) {
							html += `<option value="${val.user_id}">${val.company_name}</option>`;
						});
					}
					$('.multipleaffiliates').append(html);
					$('.multipleaffiliates').select2({
						placeholder: "Select Affiliates",
						allowClear: true
					});

				} else {
					toastr.error(response.data.message);
				}
			})
			.catch(function(error) {
				CardLoaderInstance.hide();
				$(".error").html("");
				if (error.response.status == 422) {
					errors = error.response.data.errors;
					$.each(errors, function(key, value) {
						$('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
					});
				} else if (error.response.status == 400) {
					console.log(error.response);
				}
			})
			.then(function() {
				CardLoaderInstance.hide();
			});
	});

	//Change Status
	$(document).on('click', '.change-provider-status', function(e) {
		var check = $(this);
		var id = check.attr("data-id");
		var isChecked = check.is(':checked');
		if (check.is(':checked'))
			var status = 1;
		else
			var status = 0;

		var url = '/affiliates/change-provider-status';
		var formdata = new FormData();
		formdata.append("id", id);
		formdata.append("status", status);
		Swal.fire({
			title: "{{trans('affiliates.warning_msg_title')}}",
			text: "{{trans('affiliates.warning_msg_text')}}",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "{{trans('affiliates.yes_text')}}",
		}).then(function(result) {
			if (result.isConfirmed) {
				axios.post(url, formdata)
					.then(function(response) {

						if (response.data.status == 400) {
							toastr.error(response.data.message);
							if (isChecked) {
								check.prop('checked', false);
							} else {
								check.prop('checked', true);
							}
						} else {
							toastr.success(response.data.message);
						}

					})
					.catch(function(error) {
						console.log(error);
						if (isChecked) {
							check.prop('checked', false);
						} else {
							check.prop('checked', true);
						}
					})
					.then(function() {

					});
			} else {
				if (isChecked) {
					check.prop('checked', false);
				} else {
					check.prop('checked', true);
				}
			}
		});
	});


	$(document).on('click', '.deletemanageprovider', function(e) {
		e.preventDefault();
		var check = $(this);
		var id = check.attr("data-id");
		var service = check.attr("data-service");
		var relation = check.attr("data-relation");
		var source = check.attr("data-source");
		var providerId = '{{request()->segment(3)}}';
		var url = '/affiliates/deleteprovider';
		var formdata = new FormData();
		formdata.append("did", id);
		formdata.append("service", service);
		formdata.append("relation", relation);
		formdata.append("source", source);
		formdata.append('id', providerId);
		formdata.append('user', '');
		formdata.append('type', 2);
		formdata.append('providerservice', 1);
		formdata.append('providertype', 1);
		Swal.fire({
			title: "{{trans('affiliates.warning_msg_title')}}",
			text: "{{trans('affiliates.delete_msg_text')}}",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "{{trans('affiliates.yes_text')}}",
		}).then(function(result) {
			if (result.isConfirmed) {
				CardLoaderInstance.show('.tab-content');
				axios.post(url, formdata)
					.then(function(response) {
						if (response.data.status == 400) {
							toastr.error(response.data.message);
						} else {
							check.closest('tr').remove();
							toastr.success(response.data.message);
							$('.multipleaffiliates').empty();
							var html = ``;
							if (response.data.users.length > 0) {
								html += `<option value="all">Select All</option>`;
								$.each(response.data.users, function(key, val) {
									html += `<option value="${val.user_id}">${val.company_name}</option>`;
								});
							}
							$('.multipleaffiliates').append(html);
							$('.multipleaffiliates').select2({
								placeholder: "Select Affiliates",
								allowClear: true
							});
						}
						CardLoaderInstance.hide();
					})
					.catch(function(error) {
						console.log(error);
						CardLoaderInstance.hide();
					})
					.then(function() {
						CardLoaderInstance.hide();
					});
			}
		});

	});



	$(document).on('submit', '.submitStates', function(e) {
		e.preventDefault();
		CardLoaderInstance.show('.tab-content');
		let myForm = document.getElementById('providerStates');
		let formData = new FormData(myForm);
		formData.append('user_type', 2);
		var url = "/provider/assign-providers-states";
		axios.post(url, formData)
			.then(function(response) {
				$(".error").html("");
				if (response.data.status == 200) {
					toastr.success(response.data.message);
					$('.statesTabledata').empty();
					if (response.data.result.length > 0) {
						var users = ``;
						$.each(response.data.result, function(key, val) {
							checked = '';
							checkedRetention = '';
							if (val.status == 1) {
								checked = 'checked';
							}
							if(val.retention_alloweded == 1){
								checkedRetention = 'checked';
							}
							users += `
									<tr>
									<td>${val.state_code}</td>
									<td>
										<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
											<input class="form-check-input sweetalert_demo changestatestatus" type="checkbox"  ${checked}  data-id="${val.user_state_id}">
										</div>
									</td>
									<td>
										<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Retention Allowed">
											<input class="form-check-input sweetalert_demo changeretentionalloweded" type="checkbox" data-id="${val.user_state_id}" ${checkedRetention}>
										</div>
									</td>
									<td class="text-end">
										<a class="deletestate" title="Delete" data-id="${val.user_state_id}">
											<i class="bi bi-trash fs-2 mx-1 text-primary"></i>
										</a>
									</td>
									</tr>
									`;
						});
						$('.statesTabledata').append(users);

						$('.multiplestates').empty();
						var html = ``;
						if (response.data.states.length > 0) {
							html += `<option value="all">Select All</option>`;
							$.each(response.data.states, function(key, val) {
								html += `<option value="${val.state_id}">${val.state_code}</option>`;
							});
						}
						$('.multiplestates').append(html);
						$('.multiplestates').select2({
							placeholder: "Select States",
							allowClear: true
						});
					}
				} else {
					toastr.error(response.data.message);
				}
				CardLoaderInstance.hide();
				window.location.href = window.location.href ;
			})
			.catch(function(error) {
				CardLoaderInstance.hide();
				$(".error").html("");
				if (error.response.status == 422) {
					errors = error.response.data.errors;
					$.each(errors, function(key, value) {
						$('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
					});
				} else if (error.response.status == 400) {
					console.log(error.response);
				}
			})
			.then(function() {
				CardLoaderInstance.hide();
			});


	});

	//Change Status state
	$(document).on('click', '.changestatestatus', function(e) {
		var check = $(this);
		var id = check.attr("data-id");
		var isChecked = check.is(':checked');
		if (check.is(':checked'))
			var status = 1;
		else
			var status = 2;

		var url = '/provider/change-state-status';
		var formdata = new FormData();
		formdata.append("id", id);
		formdata.append("status", status);
		Swal.fire({
			title: "{{trans('affiliates.warning_msg_title')}}",
			text: "{{trans('affiliates.warning_msg_text')}}",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "{{trans('affiliates.yes_text')}}",
		}).then(function(result) {
			if (result.isConfirmed) {
				axios.post(url, formdata)
					.then(function(response) {

						if (response.data.status == 400) {
							toastr.error(response.data.message);
							if (isChecked) {
								check.prop('checked', false);
							} else {
								check.prop('checked', true);
							}
						} else {
							toastr.success(response.data.message);
						}

					})
					.catch(function(error) {
						console.log(error);
						if (isChecked) {
							check.prop('checked', false);
						} else {
							check.prop('checked', true);
						}
					})
					.then(function() {

					});
			} else {
				if (isChecked) {
					check.prop('checked', false);
				} else {
					check.prop('checked', true);
				}
			}
		});
	});


	//Change Retention Alloweded state
	$(document).on('click', '.changeretentionalloweded', function(e) {
		var check = $(this);
		var id = check.attr("data-id");
		var isChecked = check.is(':checked');
		if (check.is(':checked'))
			var status = 1;
		else
			var status = 2;

		var url = '/provider/retention-allowed';
		var formdata = new FormData();
		formdata.append("id", id);
		formdata.append("retention_alloweded", status);
		Swal.fire({
			title: "{{trans('affiliates.warning_msg_title')}}",
			text: "{{trans('affiliates.warning_msg_text_retention')}}",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "{{trans('affiliates.yes_text')}}",
		}).then(function(result) {
			if (result.isConfirmed) {
				axios.post(url, formdata)
					.then(function(response) {

						if (response.data.status == 400) {
							toastr.error(response.data.message);
							if (isChecked) {
								check.prop('checked', false);
							} else {
								check.prop('checked', true);
							}
						} else {
							toastr.success(response.data.message);
						}

					})
					.catch(function(error) {
						console.log(error);
						if (isChecked) {
							check.prop('checked', false);
						} else {
							check.prop('checked', true);
						}
					})
					.then(function() {

					});
			} else {
				if (isChecked) {
					check.prop('checked', false);
				} else {
					check.prop('checked', true);
				}
			}
		});
	});
	//Delete state
	$(document).on('click', '.deletestate', function(e) {
		e.preventDefault();
		var check = $(this);
		var id = check.attr("data-id");
		var url = '/provider/deletestate';
		var providerId = '{{request()->segment(3)}}';
		var formdata = new FormData();
		formdata.append("id", id);
		formdata.append("providerid", providerId);
		Swal.fire({
			title: "{{trans('affiliates.warning_msg_title')}}",
			text: "{{trans('affiliates.delete_msg_text')}}",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "{{trans('affiliates.yes_text')}}",
		}).then(function(result) {
			if (result.isConfirmed) {
				CardLoaderInstance.show('.tab-content');
				axios.post(url, formdata)
					.then(function(response) {
						if (response.data.status == 400) {
							toastr.error(response.data.message);
						} else {
							check.closest('tr').remove();
							toastr.success(response.data.message);
							$('.multiplestates').empty();
							var html = ``;
							if (response.data.states.length > 0) {
								html += `<option value="all">Select All</option>`;
								$.each(response.data.states, function(key, val) {
									html += `<option value="${val.state_id}">${val.state_code}</option>`;
								});
							}
							$('.multiplestates').append(html);
							$('.multiplestates').select2({
								placeholder: "Select States",
								allowClear: true
							});
						}
						CardLoaderInstance.hide();
					})
					.catch(function(error) {
						console.log(error);
						CardLoaderInstance.hide();
					})
					.then(function() {
						CardLoaderInstance.hide();
					});
			}
		});

	});
	/**
	 * description : get distributors On change dropdown value according to selected energy. It wil fetch data only once for each energy types.
	 * 				 store data in global variable (postcodeData) to manipulate dropdowns
	 * 				 call setDistributorOptions() on success to set options of Distributor's dropdown according to selected energy type
	 */
	$("#energy_type").on('change', function() {
		let energyType = $(this).val();
		if (energyType != '' && !postcodeData[energyType]) {
			loaderInstance.show();
			axios.post("/provider/get-distributors", {
					energyType,
					providerId: $('[name="provider_id"]').val()
				})
				.then(function(response) {
					postcodeData[energyType] = response.data;
					setDistributorOptions();
					loaderInstance.hide();

				})
				.catch(function(error) {
					loaderInstance.hide();
				})
		} else {
			setDistributorOptions();
		}
	})
	/**
	 * description : get distributors from global variable (postcodeData) and set options of Distributor's dropdown according to selected energy type
	 */
	const setDistributorOptions = () => {
		$('.errors').text('').removeClass('field-error').hide();
		let energyType = $("#energy_type").val();
		$('#distributor').html('<option value=""></option>')
		if (energyType != '' && postcodeData[energyType]) {
			postcodeData[energyType].forEach(element => {
				$('#distributor').append(`
					<option value="${element.id}">${element.name}</option>
				`);
			});
			$('#distributor_box').fadeIn();
		} else
			$('#distributor_box').hide();
		$('#distributor').change();

	}

	/**
	 * description : set options of postcodes's dropdown according to selected distributor using global variable (postcodeData)
	 */
	$("#distributor").on('change', function() {
		$('.errors').text('').removeClass('field-error').hide();
		let energyType = $("#energy_type").val();
		let distributor = $("#distributor").val();
		$('#postcode').html('<option value=""></option>')
		if (energyType != '' && distributor != '' && postcodeData[energyType]) {
			let distributorData = postcodeData[energyType].filter(dist => dist.id == distributor);
			distributorData[0]['post_codes'].forEach(element => {
				$('#postcode').append(`
					<option value="${element.post_code}">${element.post_code}</option>
				`);
			});

			distributorData[0]['provider_post_codes'].forEach(element => {
				$('#postcode option[value=' + element.postcode + ']').attr('selected', 'selected');
			});
			$('#postcode_box').fadeIn();
		} else
			$('#postcode_box').hide();

		$('#postcode').change();
	});

	/**
	 * description : submit form on click of #assign_postcode_form_submit_btn
	 * 				 update global variable (postcodeData) according to selected postcodes on success.
	 */
	$('#assign_postcode_form_submit_btn').click(() => {
		$('.errors').text('').removeClass('field-error').hide();
		loaderInstance.show();
		if (!validateForm()) {
			loaderInstance.hide();
			return false;
		}
		let formData = new FormData($('#assign_postcode_form')[0]);
		formData.set('postcodes', $('#postcode').val());
		axios.post("/provider/assign-postcodes", formData)
			.then(function(response) {
				let energyType = $("#energy_type").val();
				let distributor = $("#distributor").val();
				let selectedPostcodes = $('#postcode').val();
				postcodeData[energyType].forEach(dist => {
					if (dist.id == distributor) {
						dist['provider_post_codes'] = [];
						selectedPostcodes.forEach(postcode => {
							dist['provider_post_codes'].push({
								'postcode': postcode
							});
						});
					}
				});

				loaderInstance.hide();
				toastr.success(response.data.message)
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
	const validateForm = () => {
		let errors = {};
		let isError = false;
		if ($('[name=energy_type]').val() == '') {
			errors['energy_type'] = "{{ __('providers.assignPostcodeSection.energy_type.errors.required') }}";
			isError = true;
		}
		if ($('[name=distributor]').val() == '') {
			errors['distributor'] = "{{ __('providers.assignPostcodeSection.distributor.errors.required') }}";
			isError = true;
		}
		if (isError) {
			showValidationMessages(errors)
			toastr.error('The given data was invalid.');
			//return false;
		}
		return true;
	}

	const showValidationMessages = (errors) => {
		$.each(errors, function(key, value) {
			var input = $("input[name='" + key + "']");
			var textarea = $("textarea[name='" + key + "']");
			var select = $("select[name='" + key + "']");
			var select2_id = $("#" + key);

			if (key.indexOf(".") != -1) {
				var arr = key.split(".");
				input = $("input[name='" + arr[0] + "[]']:eq(" + arr[1] + ")");
				select = $("input[name='" + arr[0] + "[]']:eq(" + arr[1] + ")"); // simple select
				textarea = select = $("input[name='" + arr[0] + "[]']:eq(" + arr[1] + ")");
				select2_id = $("select[name='" + arr[0] + "[]']:eq(" + arr[1] + ")");
			}

			$(input).next('span.errors').addClass('field-error').text(value).fadeIn();
			$(input).next('span.form_error').addClass('field-error').text(value).fadeIn();
			$(input).css('border-color', 'red');

			$(textarea).next('span.errors').addClass('field-error').text(value).fadeIn();
			$(textarea).next('span.form_error').addClass('field-error').text(value).fadeIn();
			$(textarea).css('border-color', 'red');

			$(select).next('span.errors').addClass('field-error').text(value).fadeIn();
			$(select).next('span.form_error').addClass('field-error').text(value).fadeIn();
			$(select).css('border-color', 'red');

			// if select2
			var error_field = $(select2_id).nextAll('.form_error').addClass('field-error').text(value).fadeIn();
			$(error_field).parent().find('.select2-selection').css('border-color', 'red');

            $(select2_id).find('span.errors').addClass('field-error').text(value).fadeIn();
		});
	}

	const removeValidationErrors = () => {
		$("span.errors").text('').hide();
		$("span.form_error").text('').hide();
		$("input").css('border-color', '');
		$("select").css('border-color', '');
		$("textarea").css('border-color', '');
		$(".select2-selection").css('border-color', '');
	}


	/* Movin provider data start here */
	moveInEnergy = null;
	movein_content = {};

	thiss = null;

	$(document).on('click', '.moveincontent', function() {
		$('#move_in_content_error').html('');
		$('#move_in_eic_content_value').val('');
		$('#move_in_content_value').val('');
		$('#movin_status_no').prop('checked', true);
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
		if ($(thiss).attr("data-type") == 'move_in_eic_content') {
			formdata.append("requestType", 20);
		}else if ($(thiss).attr("data-type")  == 'move_in_content') {
			formdata.append("requestType", 19);
		}

		axios.post("/provider/provider-movin-details", formdata)
			.then(function(response) {
				
				loaderInstance.hide();
				if (response.data.data.length) {
					if ($(thiss).attr("data-type") == 'move_in_eic_content') {
						$('#modal_type').val('move_in_eic_content');
						
						CKEDITOR.instances.move_in_content.setData(response.data.data[0].move_in_eic_content);
						if(response.data.data[0].move_in_eic_content_status != 0 && response.data.data[0].move_in_eic_content_status !=null){
							$('#move_in_eic_content_value').val('value_exist');
							$('#movin_status_yes').prop('checked', true);
						}
						

					} else if ($(thiss).attr("data-type") == 'move_in_content') {
						
						$('#modal_type').val('move_in_content');
						if(response.data.data[0].move_in_content_status != 0 && response.data.data[0].move_in_content_status !=null){
							$('#move_in_content_value').val('value_exist');
							$('#movin_status_yes').prop('checked', true);
						}
						

						CKEDITOR.instances.move_in_content.setData(response.data.data[0].move_in_content);
					}
				} else {
					CKEDITOR.instances.move_in_content.setData('');
				}
				console.log(response.data.providerContent[0]);
				
				if(response.data.providerContent.length){
				
					$("#movein_eic_list").html('');
					var list_data = {};
					list_data.list_id = "#movein_eic_list";
					list_data.data_target = "add_movein_eic_content_checkbox";
					list_data.id = "movein_provider_eic_content_checkbox_edit";
					list_data.delete = "movein_provider_eic_content_checkbox_delete";
			

					for (var i = 0; i < response.data.providerContent[0].get_movein_checkbox.length; i++) {
						tableData(response.data.providerContent[0].get_movein_checkbox[i], i, list_data);
					}
				}

				$('#moveincontent').modal('show');
			}).catch(function(error) {
				loaderInstance.hide();
				console.log(error);
				if (error.response.status == 422) {
					showValidationMessages(error.response.data.errors)
				}
				if (error.response.status && error.response.data.message)
					toastr.error(error.response.data.message);
				else
					toastr.error('Whoops! something went wrong.');
			})


	});
	$(document).on('click', '#movein_provider_eic_content_checkbox_delete', function (event) {
        loaderInstance.show();
        remove = $(this);
        let id=$(this).attr("data-id");
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
                        if (data.message == "Success") {
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
                        loaderInstance.hide();
                    }
                });
        
            }
        });
       

    });
	var checkboxId = null;
	$(document).on('click', '#movein_provider_eic_content_checkbox_edit', function (event) {
        $('span.error').html('');
		CKEDITOR.instances.movein_eic_content_checkbox_content.setData($(this).attr("data-checkbox_content"));
		CKEDITOR.instances.movein_eic_content_validation_msg.setData($(this).attr("data-validation_message"));

	
		$('#movein_checkbox_order').val($(this).attr('data-order'));
		if ($(this).attr('data-required_checkbox') == 1) {
			;
			$("#movein_checkbox_required_yes").prop('checked', true);
			$('.validation_message').show();
		} else {
			$("#movein_checkbox_required_no").prop('checked', true);
			$('.validation_message').hide();
		}
		if ($(this).attr('data-save_checkbox') == 1) {
			$("#movein_save_status_yes").prop('checked', true);
		} else {
			$("#movein_save_status_no").prop('checked', true);
		}
		$("#action").val("edit");
		checkboxId = $(this).attr("data-id");
	});
	$('input[type=radio][name=movein_eic_content_checkbox_required]').change(function () {
        if (this.value == '1') {
            $('.validation_message').show();
        }
        else if (this.value == '0') {
            $('.validation_message').hide();
        }
    });
	$(document).on('click', '#add_movein_eic_content', function (event) {
		CKEDITOR.instances.movein_eic_content_validation_msg.setData('');
		CKEDITOR.instances.movein_eic_content_checkbox_content.setData("");
		let moveinContent= '';
		
		if ($('#modal_type').val() == 'move_in_content') {
			moveinContent=$('#move_in_content_value').val();
		}else{
			moveinContent=$('#move_in_eic_content_value').val();
		}
		
		
		
		$("#action").val("add");
		if(moveinContent==null || moveinContent==''){
			toastr.error("Please add content",{timeOut: 1000});
			
        }else{
            $("#add_movein_eic_content_checkbox").modal('show');
        }

		$("#movein_checkbox_required_no").prop('checked', true);
		$("#movein_save_status_no").prop('checked', true);
		$('.validation_message').hide();
	});
    $(document).on('click', '#movin_eic_content_checkbox_submit', function (event) {
        var formData = null;
        var list_data = {};
        var form_name = '';
        loaderInstance.show();
      
		formData = new FormData($("#movein_provider_eic_content_checkbox_form")[0]);
		formData.set('movein_eic_content_checkbox_content', CKEDITOR.instances.movein_eic_content_checkbox_content.getData());
		formData.set('movein_eic_content_validation_msg', CKEDITOR.instances.movein_eic_content_validation_msg.getData());
		formData.append('form_name', "movein_provider_eic_content_checkbox_form");
		if ($("#modal_type").val() == "move_in_eic_content") {
			formData.append('form_type_movein', "move_in_eic_content");
        }
		if ($("#modal_type").val() == "move_in_content") {
			formData.append('form_type_movein', "move_in_content");
		}
	
		
		
		list_data.list_id = "#movein_eic_list";
		list_data.data_target = "add_movein_eic_content_checkbox";
		list_data.id = "movein_provider_eic_content_checkbox_edit";
		list_data.delete = "movein_provider_eic_content_checkbox_delete";
		var providerId = '{{request()->segment(3)}}';
		formData.append("provider_id", providerId);
        formData.append("user_id",providerId);
        $('span.error').html('');
        if ($("#action").val() == "edit") {
            formData.append('id', checkboxId);
        }
        url = '/provider/store-update-checkbox';
        axios.post(url, formData, list_data)
            .then(function (response) {
                loaderInstance.hide();
                if (response.data.status != 400 && response.data.status != 422) {
					console.log(response.data);
                    toastr.success(response.data.message);
					$('#add_movein_eic_content_checkbox').modal('hide');
					$('.moveincontent_modal').modal('show');
					
					$("#movein_eic_list").html('');
                    for (var i = 0; i < response.data.data[0].get_movein_checkbox.length; i++) {
                        tableData(response.data.data[0].get_movein_checkbox[i], i, list_data);
                    }

                }
                if (response.data.status == 400) {
                    toastr.error(response.data.message);
					$('#add_movein_eic_content_checkbox').modal('hide');
                  
                }
            })
            .catch(function (error) {
				console.log('resposne');  console.log(error);
                if (error && error.response.status == 422) {
					
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
	function tableData(data, inc, list_data) {
		
            let str = data.content;
            if ((str===null) || (str==='')){
                str = '-';
            }
            else{
            str = str.toString();
            str =  str.replace( /(<([^>]+)>)/ig, '');
            }
        $(list_data.list_id).append(`
           <tr>
            <td>${++inc}</td>
            <td>
                ${data.checkbox_required == 1 ? 'yes' : 'no'}
            </td>
            <td title="${str}">
                <span class="ellipses_table"> ${str}</span>
            </td>                 
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
                      data-order= "${data.order}"data-save_checkbox="${data.status}" data-validation_message="${data.validation_message}" data-checkbox_content="${data.content}">Edit</a>
                      <a id="${list_data.delete}" data-id="${data.id}" class="menu-link px-3">Delete</a>
                    </div>
                </div>
              <!--end::Menu-->
            </td>
           </tr> `);
        KTMenu.createInstances();
    }
	$(document).on('click', '#save_movin_content', function() {
		//if content is empty and enable button is checked
		if (CKEDITOR.instances['move_in_content'].getData() == "" && $("input[name='movin_status']:checked").val() != 0) {
			var movin_type = $(thiss).attr("data-type");
			
			if (movin_type == 'move_in_content') {
				message = 'Please enter the move in content';
			}
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
	$(document).on('change', '#move_in_checkbox_parameter', function() {
		var selected = jQuery('#move_in_checkbox_parameter :selected').val();
		CKEDITOR.instances['movein_eic_content_checkbox_content'].insertHtml(selected);
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
				if (response.data.residence[0].grace_day) {
					$("#day_interval_residence").val(response.data.residence[0].grace_day);
					$("#restrict_residence_time").val(response.data.residence[0].restricted_start_time);

				} else {
					$("#day_interval_residence").val(2);
					$("#restrict_residence_time").val("17:00");
				}
			} else {
				$("#residence_id").val("");
				$("#day_interval_residence").val(2);
				$("#restrict_residence_time").val("17:00");
			}
			if (response.data.sme.length != 0) {
				$("#sme_id").val(response.data.sme[0].id);
				if (response.data.sme[0].grace_day) {
					$("#day_interval_bussiness").val(response.data.sme[0].grace_day);
					$("#restrict_bussiness_time").val(response.data.sme[0].restricted_start_time);
				} else {
					$("#day_interval_bussiness").val(2);
					$("#restrict_bussiness_time").val("17:00");
				}

			} else {
				$("#sme_id").val("");
				$("#day_interval_bussiness").val(2);
				$("#restrict_bussiness_time").val("17:00");
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
	/* Movin provider data end here */
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

	$(document).on('change', '#states', function(){
		let selected = $(this).val();
		if(selected != ''){
			if(selected == 'all'){
				$("#states option").prop("selected", true);
				$("#states option[value='all']").prop("selected", false);
				$('.multiplestates').select2({
					placeholder: "Select States",
					allowClear: true
				});
			}
		}
    });

	$(document).on('change', '#providers', function(){
		let selected = $(this).val();
		if(selected != ''){
			if(selected == 'all'){
				$("#providers option").prop("selected", true);
				$("#providers option[value='all']").prop("selected", false);
				$('.multipleaffiliates').select2({
					placeholder: "Select Affiliates",
					allowClear: true
				});
			}
		}
    });

	$(document).on('change', '#suburb', function(){ 
		let selected = $(this).val();
		if(selected != ''){
			if(selected == 'all'){
				$("#suburb").val([]);
				$("#suburb option[value='all']").prop("selected", false);
				$('.suburbModal').select2({
					placeholder: "Select Suburb",
					allowClear: true
				});
			}
		}
    });
</script>
