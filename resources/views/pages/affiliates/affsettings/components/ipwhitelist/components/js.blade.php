
<script>
    
    $(document).ready(function() {
        localStorage.removeItem('whitelist');
        //Ip Whitelist click
        $(document).on('click', '.getwhitelist', function(e) {
            if(localStorage.getItem("whitelist")){
                
            }else{
                localStorage.setItem("whitelist", 1);
                CardLoaderInstance.show('.tab-content');
                var id = $('#show_apikeypopup').data('user_id');
                var formData = new FormData();
                formData.append("id", id);
                formData.append('user',$('#checksegment').val());
                formData.append('request_from',$('#ipFilter').closest('form').attr('name'));
                var url = "/affiliates/link-whitelistip";
                axios.post(url, formData)
                .then(function (response) {
                    $('.ipTabledata').empty();
                    if(response.data.result.length > 0){
                        var users = ``;
                        $.each(response.data.result, function (key, val) {
                            const splitDate = val.created.split(" ");
                            var convertdateformat = dateFormat(splitDate[0], 'dd-MM-yyyy');
                            var newdate = convertdateformat+" "+splitDate[1];
                            users+= `
                            <tr>
                            <td>${val.ips}</td>
                            <td>${val.assignedby}</td>
                            <td>${newdate}</td>
                            <td class="text-end">
                                <a class="deleteips" data-id="${val.id}" title="Delete">
                                    <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                                </a>
                            </td>
                            </tr>
                            `;
                        });
                        
                    }else{
                        users = `<tr class="no_record"><td colspan="4" align="center">{{trans('affiliates.norecord')}}</td></tr>`;
                    }
                    $('.ipTabledata').append(users);
                    CardLoaderInstance.hide();
                })
                .catch(function (error) {
                    console.log(error);
                    CardLoaderInstance.hide();
                })
                .then(function () {
                    CardLoaderInstance.hide();
                });

            } 
        });


        $(document).on('submit', '.submitIpWhitelist', function(e) {
            e.preventDefault();
            CardLoaderInstance.show('.tab-content');
            let myForm = document.getElementById('ipFilter');
            let formData = new FormData(myForm);
            formData.append('id',$('#show_apikeypopup').data('user_id'));
            formData.append('user',$('#checksegment').val());
            formData.append('request_from',$('#ipFilter').closest('form').attr('name'));
            var url = "/affiliates/assign-whitelistip";
            axios.post(url, formData)
            .then(function (response) {
                $(".error").html("");
                if (response.data.status == 200) {
                    localStorage.removeItem('whitelist');
                    toastr.success(response.data.message);
                    $('#ipFilter')[0].reset();
                }else{
                    toastr.error(response.data.message);
                } 

                $('.getwhitelist').trigger('click');

            })
            .catch(function (error) {
                CardLoaderInstance.hide();
                $(".error").html("");
                if(error.response.status == 422) {
                    errors = error.response.data.errors;
                    $.each(errors, function(key, value) {
                        $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    });
                }
                else if(error.response.status == 400) {
                    console.log(error.response);
                }
            })
            .then(function () {
                CardLoaderInstance.hide();
            });
        });


        $(document).on('click', '.deleteips', function(e) {
            e.preventDefault();
            var check = $(this);
            var id = check.attr("data-id");
            var url = '/affiliates/deletewhitelistips';
            
            var formdata = new FormData();
            formdata.append("id", id);
            Swal.fire({
                title: "{{trans('affiliates.warning_msg_title')}}",
                text: "{{trans('affiliates.delete_msg_text')}}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{trans('affiliates.yes_text')}}",
            }).then(function(result) {
                if (result.isConfirmed) {
                    CardLoaderInstance.show('.tab-content');
                    axios.post(url,formdata )
                    .then(function (response) {
                        if(response.data.status == 400){
                            toastr.error(response.data.message);
                        }else{
                            toastr.success(response.data.message);
                            check.closest('tr').remove();
                        }
                        
                    })
                    .catch(function (error) {
                        console.log(error);
                        CardLoaderInstance.hide();
                    })
                    .then(function () {
                        CardLoaderInstance.hide();
                    });
                }
            });

        });


        function dateFormat(inputDate, format) {
            //parse the input date
            const date = new Date(inputDate);

            //extract the parts of the date
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();    

            //replace the month
            format = format.replace("MM", month.toString().padStart(2,"0"));        

            //replace the year
            if (format.indexOf("yyyy") > -1) {
                format = format.replace("yyyy", year.toString());
            } else if (format.indexOf("yy") > -1) {
                format = format.replace("yy", year.toString().substr(2,2));
            }

            //replace the day
            format = format.replace("dd", day.toString().padStart(2,"0"));

            return format;
        }

    });
   
</script>