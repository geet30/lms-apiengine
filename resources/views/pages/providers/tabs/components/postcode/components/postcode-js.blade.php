<script>
    var distributors = [], energy_type = 'all', postcodes = [], distributor_id = '', user_id = $('#postcodes_assign_form .user_id').val();

    $(document).ready(function () {

    });

    $('#energy_type').change(function () {
        $('#provider_postcodes').val('').change();
        $('#provider_postcodes').html('<option value=""></option>');
        energy_type = $(this).val();
        if (distributors[energy_type] && distributors[energy_type].length) {
            setDistributorsOptions(distributors[energy_type]);
        } else {
            getDistributorsFromServer();
        }
    });

    function getDistributorsFromServer() {
        CardLoaderInstance.show('#postcode-tab-panel')
        axios.get("/provider/get-distributors/" + user_id + "/" + energy_type)
            .then(function (response) {
                distributors[energy_type] = response.data.distributors;
                setDistributorsOptions(distributors[energy_type]);
            })
            .catch(function (error) {
                if (error.response.data.message)
                    toastr.error(error.response.data.message);
                else
                    toastr.error('Whoops! something went wrong.');
            })
            .then(function () {
                CardLoaderInstance.hide()
            })
    }

    function setDistributorsOptions(distributors) {
        var html = `<option value=""></option>`;
        $('#distributor_id').html('');
        distributors.forEach(element => {
            html += `<option value="${element.id}">${element.name}</option>`
        });
        $('#distributor_id').html(html);
    }

    $('#postcodes_assign_form .postcodes_assign_form_submit_btn').click(function () {
        removeValidationErrors();
        CardLoaderInstance.show('#postcode-tab-panel')
        var formData = new FormData(document.getElementById('postcodes_assign_form'));
        formData.append('energy_type', energy_type);
        formData.append('distributor_id', distributor_id);
        axios.post("/provider/assign-postcodes", formData)
            .then(response => {
                console.log(response.data)
                if (response.data.status == 1) {
                    postcodes[distributor_id] = response.data.postcodes;
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(error => {
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    showValidationMessages(errors);
                }
                if (error.response.data.message)
                    toastr.error(error.response.data.message);
                else
                    toastr.error('Whoops! something went wrong.');
            }).then(function () {
            CardLoaderInstance.hide();
        })
    });

    $("#postcodes_assign_form #provider_postcodes").on('change', function () {
        if ($(this).children("option[value=select_all]:selected").length > 0) {
            $(this).children('option').prop('selected', true);
            $(this).children('option[value=select_all]').prop('selected', false);
        }
    });

    $('#distributor_id').change(function () {
        distributor_id = $(this).val();
        if (postcodes[distributor_id] && postcodes[distributor_id].length) {
            setPostcodesOptions(postcodes[distributor_id]);
        } else {
            getPostcodesFromServer();
        }
    });

    function getPostcodesFromServer() {
        CardLoaderInstance.show('#postcode-tab-panel')
        axios.get("/provider/get-postcodes/" + user_id + "/" + distributor_id + "/" + energy_type)
            .then(function (response) {
                postcodes[distributor_id] = response.data.postcodes;
                setPostcodesOptions(postcodes[distributor_id]);
            })
            .catch(function (error) {
                if (error.response.data.message)
                    toastr.error(error.response.data.message);
                else
                    toastr.error('Whoops! something went wrong.');
            })
            .then(function () {
                CardLoaderInstance.hide()
            })
    }

    function setPostcodesOptions(postcodes) {
        var html = `<option value="select_all">Select All</option>`;
        $('#provider_postcodes').val('').change();
        $('#provider_postcodes').html('<option value=""></option>');
        postcodes.forEach(element => {
            html += `<option value="${element.post_code}" ${element.selected == 1 ? 'selected' : ''}>${element.post_code}</option>`
        });
        $('#provider_postcodes').html(html).focus();
    }
</script>
