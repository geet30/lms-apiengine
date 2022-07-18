<script src="/custom/js/loader.js"></script>
<script>
    var provider_codes_data = [];

    $(document).on('submit', '.life_support_form', function (e) {
        e.preventDefault();
        $('span.error').text('').fadeOut();
        CardLoaderInstance.show('.card-body');
        url = '/provider/store_provider_lifesupport'
        var formData = new FormData($(this)[0]);
        axios.post(url, formData)
            .then(function (response) {
                var provider_codes = response.data.provider_codes;
                $('input[name=life_support_code_id]').val(provider_codes[0].id);
                provider_codes_data['provider_code_' + provider_codes[0].provider_id + '_' + provider_codes[0].life_support_equip_id] = response.data;
                if (response.data.status == 200) {
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                console.log(error)
                CardLoaderInstance.hide();
                if (error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function (key, value) {
                        $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                }
                toastr.error(error.response.data.message);
            })
            .then(function () {
                CardLoaderInstance.hide();
            });
    });

    $('#life_support_equip_id').on('change', function () {
        $("#life_support_form span.errors").text('');
        var equip_id = $(this).val();
        var provider = $('#code_provider_id').val();
        var cache_data = 'provider_code_' + provider + '_' + equip_id;
        if (provider_codes_data.hasOwnProperty(cache_data)) {
            if (provider_codes_data[cache_data].provider_codes.length)
                setProviderCodesResponse(provider_codes_data[cache_data]);
            else
                resetForm();
        } else {
            getFromServer(provider, equip_id);
        }
    });

    function getFromServer(provider, equip_id) {
        CardLoaderInstance.show('#life_support_form');
        axios.get('/provider/get_provider_lifesupport/' + provider + '/' + equip_id)
            .then(response => {
                provider_codes_data['provider_code_' + provider + '_' + equip_id] = response.data;
                if (response.data.provider_codes.length) {
                    setProviderCodesResponse(response.data);
                } else {
                    resetForm();
                }
            }).catch(error => {
            console.log(error)
            toastr.error('Whoops! something went wrong');
        }).then(() => {
            CardLoaderInstance.hide();
        });
    }

    function setProviderCodesResponse(response) {
        var provider_codes = response.provider_codes[0];
        $('input[name=code]').val(provider_codes.code);
        $('input[name=life_support_code_id]').val(provider_codes.id);
    }

    function resetForm() {
        $('span.error').text('').fadeOut();
        $('input[name=code]').val('');
        $('input[name=life_support_code_id]').val('');
    }
</script>
