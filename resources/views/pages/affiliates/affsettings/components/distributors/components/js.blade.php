<script>
    $(document).ready(function() {
        localStorage.removeItem('distributors');
        //Distributor click
        $(document).on('click', '.getdistributors', function(e) {
            if (localStorage.getItem("distributors")) {

            } else {
                localStorage.setItem("distributors", 1);
                CardLoaderInstance.show('.distributors-section');
                var id = $('#show_apikeypopup').data('user_id');
                let myForm = document.getElementById('distributorFilter');
                let formData = new FormData(myForm);
                formData.append('user', $('#checksegment').val());
                formData.append('request_from', $('#distributorFilter').closest('form').attr('name'));
                var url = "/affiliates/link-distributors/" + id;
                axios.post(url, formData)
                    .then(function(response) {

                        $('.distributorTabledata').empty();
                        if (response.data.getAssignedDistributors.length > 0) {
                            var users = ``;
                            $.each(response.data.getAssignedDistributors, function(key, val) {
                                users += `
                            <tr>
                            <td>${val.name}</td>
                            <td>${val.service}</td>
                            <td>${val.assignedby}</td>
                            <td class="text-end">
                                <a class="deletemanagedistributor" data-id="${val.id}" title="Delete">
                                    <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                                </a>
                            </td>
                            </tr>
                            `;
                            });

                        } else {
                            users = `<tr class="no_record"><td colspan="4" align="center">{{trans('affiliates.norecord')}}</td></tr>`;
                        }
                        $('.distributorTabledata').append(users);
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

        $(document).on('change', '#distributorservice', function(e) {
            CardLoaderInstance.show('.distributors-section');
            var service = $(this).val();
            let myForm = document.getElementById('distributorFilter');
            let formData = new FormData(myForm);
            formData.append('id', $('#show_apikeypopup').data('user_id'));
            formData.append('user', $('#checksegment').val());
            var url = "/affiliates/get-distributors";
            axios.post(url, formData)
                .then(function(response) {

                    $('#distributors').empty();
                    var html = ``;
                    if (response.data.result.distributors.length > 0) {
                        html += `<option value="select_all">{{trans('affiliates.select_all')}}</option>`;
                        $.each(response.data.result.distributors, function(key, val) {
                            html += `<option value="${val.id}">${val.name}</option>`;
                        });
                    }
                    $('#distributors').append(html);
                    $('#distributors').select2({
                        placeholder: "Select Distributors",
                    });

                    $('.distributorTabledata').empty();
                    if (response.data.result.getAssignedDistributors.length > 0) {
                        var users = ``;
                        $.each(response.data.result.getAssignedDistributors, function(key, val) {
                            users += `
                        <tr>
                        <td>${val.name}</td>
                        <td>${val.service}</td>
                        <td>${val.assignedby}</td>
                        <td class="text-end">
                            <a class="deletemanagedistributor" data-id="${val.id}" title="Delete">
                                <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                            </a>
                        </td>
                        </tr>
                        `;
                        });

                    } else {
                        users = `<tr class="no_record"><td colspan="4" align="center">{{trans('affiliates.norecord')}}</td></tr>`;
                    }
                    $('.distributorTabledata').append(users);
                    CardLoaderInstance.hide();
                })
                .catch(function(error) {
                    console.log(error);
                    CardLoaderInstance.hide();
                })
                .then(function() {
                    CardLoaderInstance.hide();
                });
        });

        $(document).on('submit', '.submitDistibutorServices', function(e) {
            e.preventDefault();
            CardLoaderInstance.show('.distributors-section');
            let myForm = document.getElementById('distributorFilter');
            let formData = new FormData(myForm);
            formData.append('id', $('#show_apikeypopup').data('user_id'));
            formData.append('user', $('#checksegment').val());
            formData.append('request_from', $('#distributorFilter').closest('form').attr('name'));
            var url = "/affiliates/assign-distributors";
            axios.post(url, formData)
                .then(function(response) {
                    $(".error").html("");
                    if (response.data.status == 200) {
                        toastr.success(response.data.message);

                        $('.distributorTabledata').empty();
                        if (response.data.result.length > 0) {
                            var users = ``;
                            $.each(response.data.result, function(key, val) {
                                users += `
                            <tr>
                            <td>${val.name}</td>
                            <td>${val.service}</td>
                            <td>${val.assignedby}</td>
                            <td class="text-end">
                                <a class="deletemanagedistributor" data-id="${val.id}" title="Delete">
                                    <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                                </a>
                            </td>
                            <tr>
                            `;
                            });

                        } else {
                            users = `<tr class="no_record"><td colspan="4" align="center">{{trans('affiliates.norecord')}}</td></tr>`;
                        }

                        $('.distributorTabledata').append(users);

                        $('#distributors').empty();
                        var html = ``;
                        if (response.data.distributors.length > 0) {
                            html += `<option value="select_all">{{trans('affiliates.select_all')}}</option>`;
                            $.each(response.data.distributors, function(key, val) {
                                html += `<option value="${val.id}">${val.name}</option>`;
                            });
                        }
                        $('#distributors').append(html);
                        $('#distributors').select2({
                            placeholder: "Select Distributors",
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

        $('.selectmultipledistributor').select2({
            placeholder: 'Select Distributors',
        });

        $(document).on('click', '.deletemanagedistributor', function(e) {
            e.preventDefault();
            var check = $(this);
            var id = check.attr("data-id");
            var url = '/affiliates/deletedistributor';

            let myForm = document.getElementById('distributorFilter');
            var formdata = new FormData();
            formdata.append("did", id);
            formdata.append('id', $('#show_apikeypopup').data('user_id'));
            formdata.append('user', $('#checksegment').val());
            formdata.append('distributorservice', $('#distributorservice').val());
            Swal.fire({
                title: "{{trans('affiliates.warning_msg_title')}}",
                text: "{{trans('affiliates.delete_msg_text')}}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{trans('affiliates.yes_text')}}",
            }).then(function(result) {
                if (result.isConfirmed) {
                    CardLoaderInstance.show('.distributors-section');
                    axios.post(url, formdata)
                        .then(function(response) {
                            if (response.data.status == 400) {
                                toastr.error(response.data.message);
                            } else {
                                toastr.success(response.data.message);
                                check.closest('tr').remove();

                                $('#distributors').empty();
                                var html = ``;
                                if (response.data.distributors.length > 0) {
                                    html += `<option value="select_all">{{trans('affiliates.select_all')}}</option>`;
                                    $.each(response.data.distributors, function(key, val) {
                                        html += `<option value="${val.id}">${val.name}</option>`;
                                    });
                                }
                                $('#distributors').append(html);
                                $('#distributors').select2({
                                    placeholder: "Select Distributors",
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


        //This code is done for add Select All Button on Multiselect
        $(".selectmultipledistributor").on('change', function() {
            //Check Select All Selected
            if ($(this).children("option[value=select_all]:selected").length > 0) {
                $(this).children('option').prop('selected', true);
                $(this).children('option[value=select_all]').prop('selected', false);
                $(this).children("option[value=select_all]").hide();
                $('#distributors').select2({});
            } else {
                //if not select all selected option selected
                var total_option = $(this).children('option').length;
                var selected_option = $(this).children('option:selected').length;
                if (total_option === (selected_option + 1)) {
                    $(this).children("option[value=select_all]").hide();

                } else {

                    $(this).children("option[value=select_all]").show();
                    $('#distributors').select2({
                        placeholder: "Select Distributors",
                    });
                }
            }
        });

    });
</script>