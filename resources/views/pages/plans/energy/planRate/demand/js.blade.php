<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
var rate_id = "{{isset($demandList[0]->plan_rate_ref_id)?$demandList[0]->plan_rate_ref_id:''}}";
var distributorId = $('#distributorId').val();
// var distributorId = "{{isset($distributorId)?$distributorId:''}}";
var deamd_id = "{{isset($rateId)?$rateId:''}}";
// var property_type = "{{isset($property_type)?$property_type:''}}";
var property_type = $('#property_type').val();
console.log(property_type);
var selectedTariffForEdit = '';
var selectedRelTariffForEdit = '';
var id = '';
$("#add_demand").click(function() {
        var formData = new FormData($("#demand_form")[0]);
        action = $('#demand_form').attr('action');
        //formData.append('plan_id', plan_id);
        form_submit(action, formData);
    });
$("#add_demand_rate_btn").click(function() {
    var formData = new FormData($("#add_demand_rate_form")[0]);
    action = $('#add_demand_rate_form').attr('action');
    formData.append('tariff_info_ref_id',deamd_id);
    form_submit(action, formData);
});
    $(".edit_demand").click(function() {

         id = $(this).data('id');
        var tarrif_code = $(this).data('tarrif_code');
        var aliases = $(this).data('aliases');
        var discount = $(this).data('discount');
        var supply = $(this).data('supply');
        var supply_discount_desc = $(this).data('supply_discount_desc');
        var usage_desc = $(this).data('usage_desc');
        var supply_desc = $(this).data('supply_desc');
        var daily_supply = $(this).data('daily_supply');
        var allises = $(this).data('allises');
        $("#add_edit_demand").modal('show');

        selectedTariffForEdit = tarrif_code;
		selectedRelTariffForEdit = allises;

        $('input[name=tariff_discount]').val(discount);
        $('input[name=tariff_supply_discount]').val(supply);
        $('textarea[name=daily_supply_charges_description]').val(supply_desc);
        $('textarea[name=discount_on_usage_description]').val(usage_desc);
        $('textarea[name=discount_on_supply_description]').val(supply_discount_desc);
        $('input[name=tariff_daily_supply]').val(daily_supply);

        $('input[name=id]').val(id);
        //$("#tariff_code_ref_id").select2("val", tarrif_code);
        $('select[name="tariff_code_ref_id"]').find('option[value="'+tarrif_code+'"]').attr("selected",true)
    });
    $(".edit_demand_rate").click(function() {
        $('input[name=id]').val($(this).data('id'));
        $('input[name=limit_daily]').val($(this).data('limit_daily'));
        $('input[name=limit_yearly]').val($(this).data('limit_yearly'));
        $('textarea[name=usage_discription]').val($(this).data('usage_desc'));
        $('input[name=limit_charges]').val($(this).data('limit_charges'));
        $('.hide_selects').hide();
        $('.limit_level_text').html($(this).data('limit_level')).show();
        $('.season_rate_type_text').html($(this).data('season_rate_type')).show();
        $('.usage_type_text').html($(this).data('usage_type')).show();
    });

    $(".add_new_rate").click(function() {
        $('.hide_selects').show();
        $('.limit_level_text').hide();
        $('.season_rate_type_text').hide();
        $('.usage_type_text').hide();
    });




function form_submit(action, formData) {
    $('form').find('input').css('border-color', '');
    $(".form_error").text("");
    let submitButton = document.querySelector('.submit_button');
    submitButton.setAttribute('data-kt-indicator', 'on');
    submitButton.disabled = true;
    axios.post(action, formData)
        .then(function(response) {
            console.log(response.data);
            if (response.data.status == 1) {

                $("#add_edit_demand").modal('hide');

                toastr.success(response.data.message);
                console.log(response.data);
                    location.reload();
            } else {
                toastr.error(response.data.message);
            }


        })
        .catch(function(error) {
            console.log(error);
            if (error.response.status == 422) {
                errors = error.response.data.errors;

                $.each(errors, function(key, value) {
                    $('textarea[name=' + key + ']').parent('.field-holder').find('span.form_error')
                        .slideDown(400).html(value);
                    $('textarea[name=' + key + ']').css('border-color', 'red');
                    $('input[name=' + key + ']').parent('.field-holder').find('span.form_error')
                        .slideDown(400).html(value);
                    $('input[name=' + key + ']').css('border-color', 'red');
                    $('select[name=' + key + ']').parent('.field-holder').find('span.form_error')
                        .slideDown(400).html(value);
                    $('select[name=' + key + ']').css('border-color', 'red');

                });

            } else {
                toastr.error(error.response.data.message);
            }
        })
        .then(function() {
            submitButton.setAttribute('data-kt-indicator', 'off');
            submitButton.disabled = false;
            // always executed
        });
}


$("#add_edit_demand").on('show.bs.modal', function(){
    forData = {
                'distriibutor_id':distributorId,
                'property_type':property_type,
                'plan_rate_ref_id':rate_id,
                'id':id
    }
    action = "/provider/plans/energy/get-master-tariff-codes";

    axios.post(action,forData)
        .then(function(response) {
            console.log('found');
            masterTariffData = response.data.masterTariffCodes;
            console.log(masterTariffData);
            $.each(masterTariffData,(key,value)=>{
					$('#tariff_code_ref_id').append(`
						<option value="${key}">${value}</option>
					`)
				})
        if(forData.id){
            if(typeof(selectedRelTariffForEdit) == 'string')
                selectedRelTariffForEdit = selectedRelTariffForEdit.split(',');

            $('#tariff_code_ref_id').val(selectedTariffForEdit).change();
            $('#tariff_code_aliases').val(selectedRelTariffForEdit).change();

        }
        }).catch(function(error) {
                toastr.error(error);
        })
});
$(document).on('change', '#tariff_code_ref_id', function() {
		$('#tariff_code_aliases').html('');
		let selectedTariffId = $(this).val();
		if(!selectedTariffId){
			$('#tariff_code_aliases').change();
			return false;
		}
		$.each(masterTariffData,(key,value)=>{
			if(selectedTariffId != key){
				$('#tariff_code_aliases').append(`
					<option value="${key}">${value}</option>
				`)
			}
		})
		if($('#tariff_code_aliases').children().length <=1){
            toastr.error('No Relational Tariff found for this tariff code');
		}

	})

    $("#add_edit_demand").on('hidden.bs.modal', function(){
        $("#add_demand_rate_form").trigger("reset");
        id ="";
        selectedRelTariffForEdit = '';
		$('#tariff_code_ref_id, #tariff_code_aliases ').html(`<option value="">Select Tariff Code</option>`)
		$('#tariff_code_ref_id, #tariff_code_aliases ').change();
    });


    //Conditional limit
	$(document).on('change','select[name=season_rate_type]',function()
	{
		var inputField = $(this).attr('id');
		$('#usage_type').html('');
		$('#limit_level').html('');
		var seasonRateType=$('#season_rate_type').val();
		if(seasonRateType == ''){
			$('#limit_level').append('<option value="">Select Usage Limit </option>');
			$('#usage_type').append('<option value="">Select Usage Type</option>');
			return;
		}
		let formData = {'tariff_info_ref_id':deamd_id,'season_rate_type':seasonRateType,'inputField':inputField} ;
		getDropDownValues(formData,'season_rate_type');
	});

    const getDropDownValues = (data,type)=>{
		$('.errors').text('');
        action = "{{route('energyplans.tariff-rate-limit')}}";

        axios.post(action,data)
        .then(function(response) {
            $('span.form_error').html('');
				$('#limit_level').html('<option value="">Select Usage Limit </option>');
				switch (type) {
					case 'season_rate_type':
						$('#usage_type').html('<option value="">Select Usage Type </option>');
						var usage_text;
						$.each(response.data.usage_type_dropdown,function(i,val){
							if(val=='peak')
							usage_text = 'Peak Only';
							if(val=='off_peak')
							usage_text = 'Off Peak';
							if(val=='shoulder')
							usage_text = 'Shoulder';
							$('#usage_type').append('<option value='+val+'>'+usage_text+'</option>');
						});
						break;

					case 'usage_type':
						var numeric_text;
						$.each(response.data.Limit_type_dropdown,function(i,val){
							if(val==1)
								numeric_text = 'Limit 1';
							if(val==2)
								numeric_text = 'Limit 2';
							if(val==32768)
								numeric_text = 'Remaining';
							$('#limit_level').append('<option value='+val+'>'+numeric_text+'</option>');
						});
						break;
				}

        }).catch(function(error) {
                toastr.error(error.response.data.message);
        })
	}

    $(document).on('change','select[name=usage_type]',function(){
		var inputField = $(this).attr('id');
		$('#limit_level').html('');
		var seasonRateType=$('#season_rate_type').val();
		var usageType=$('#usage_type').val();
		if(usageType == '')
		{
			$('#limit_level').append('<option value="">Select Usage Limit </option>');
			return;
		}
		let data = {'tariff_info_ref_id':deamd_id,'season_rate_type':seasonRateType,'inputField':inputField,'usage_type':usageType};
		getDropDownValues(data,'usage_type')
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
</script>

