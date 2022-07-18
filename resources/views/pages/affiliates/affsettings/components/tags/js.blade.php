<script>
    var tagsArr = "";
    $(".tag_role_div").hide();
    //gettag data
    $(document).on('click', '.getafftag', function(e) {
        CardLoaderInstance.show('.tab-content');

        let action = "/affiliates/manage-tag/" + $('#show_apikeypopup').data('user_id')
        if (tagsArr.length === 0 || tagsArr === "") {
            axios.get(action)
                .then(function(response) {
                    tagsArr = response.data.tags;
                    var options = '';
                    $("#tag").append('');
                    if (tagsArr) {
                        $.each(tagsArr, function(key, value) {
                            options += `<option value="${key}" selected>${value}</option>`
                        })
                        $("#tagselect").append(options);
                        $(".tag_role_div").show();
                        if (response.data.default_tags !== null && response.data.default_tags !== undefined)
                            setValue(response.data.default_tags);
                    } else {
                        $(".tag_role_div").hide();

                        $("#tagselect").append('<option value="no tags found" "selected">No Tags found</option>');

                    }
                    CardLoaderInstance.hide();

                })
                .catch(function(error) {
                    toastr.error(error);
                })
        }
        CardLoaderInstance.hide();

    });
    //get values of target role onchange of select
    $(document).on('change', '#tagselect', function(e) {
        let action = "/affiliates/tagdetails/" + $('#show_apikeypopup').data('user_id');
        var tag_id = $(this).val();
        axios.get(action, {
                params: {
                    tag_id: tag_id
                }
            })
            .then(function(response) {
                if (response.data.default_tags !== null && response.data.default_tags !== undefined)
                    setValue(response.data.default_tags);
            })
            .catch(function(error) {
                toastr.error(error);
            })
    });
    //set tags radio button values
    function setValue(defaultTags) {

        if (defaultTags.is_advertisement == 0) {
            $('input[name="is_advertisement"]').prop('checked', false).change();
        } else {
            $('input[name="is_advertisement"]').prop('checked', true).change();
        }
        if (defaultTags.is_any_time == 0) {
            $('input[name="is_any_time"]').prop('checked', false).change();
        } else {
            $('input[name="is_any_time"]').prop('checked', true).change();
        }
        if (defaultTags.is_remarketing == 0) {
            $('input[name="is_remarketing"]').prop('checked', false).change();
        } else {
            $('input[name="is_remarketing"]').prop('checked', true).change();
        }
        if (defaultTags.is_cookies == 0) {
            $('input[name="is_cookies"]').prop('checked', false).change();
        } else {
            $('input[name="is_cookies"]').prop('checked', true).change();
        }
    }
    //update tag information
    $(document).on('click', '#aff_tag_btn', function(e) {
        var formData = new FormData($("#aff_tag_form")[0]);
        action = $('#aff_tag_form').attr('action');
        formSubmit(action, formData);
    });
</script>