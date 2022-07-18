<script src="/custom/js/loader.js"></script>
<script>
    var pageNumber = 2, processing = false;
    localStorage.removeItem('pagenumber');
    $('#breadcrumbs_custom_title').text('Recon Setting');
    const breadArray = [{
        title: 'Dashboard',
        link: '/',
        active: false
        },
        {
        title: 'Recon',
        link: '#',
        active: false
    }];

    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();



    /*
     * popup show
    */
    $(document).on('click', '.editreconpop', function(e) {
        e.preventDefault();
        $(".error").html("");
        $("#setpermission").select2().val('').trigger('change.select2')
        var myModal = new bootstrap.Modal(document.getElementById("editreconpop"), {});
        myModal.show();
        $('.selectedcompany').text($(this).data('companyname'));
        $('.reconmonthly,.reconbimonthly').prop('checked',false);
        if($(this).data('recon') == 1){
            $('.reconmonthly').prop('checked',true);
        }

        if($(this).data('recon') == 2){
            $('.reconbimonthly').prop('checked',true);
        }
        $('.setid').val($(this).data('userid'));
        $('input:checkbox').removeAttr('checked');
        var permissions = $(this).data('permissions');
        if(typeof permissions == 'string'){
            let length = permissions.length;
            if(length > 0  ){
                var strarray = permissions.split(',');
                $.each(strarray, function (key, value) {
                    $(":checkbox[value="+value+"]").attr("checked","true");
                });
                
                $("#setpermission").select2().val(strarray).trigger('change.select2')
            }
        }else{
            $(":checkbox[value="+permissions+"]").attr("checked","true");
        } 
    });
   
    
    $(document).on('change', '#setpermission', function(e) {
        arr = $("#setpermission").val();
        arr = $("#setpermission").val().filter(function(e){return e}); 
        $("#setpermission").select2().val(arr).trigger('change.select2')
    });
   
    $("#hidesub").hide();
    $(document).on('change', '#affiliates', function(e) {
        if($('#affiliates').val().length == 0 || $('#rolefilter').val() == 1){
            $("#hidesub").hide();return false;
        }
        CardLoaderInstance.show('.tab-content');
        var url = '/reconsettings/getsubaffiliates';
        var id  = $(this).val();
        axios.post(url, {'id':id})
        .then(function (response) {
            if(response.data.status == 200){
                if (response.data.result.length > 0) {
                    $('#subaffiliates').empty();
                    var html = `<option value=""></option>`;
                    $.each(response.data.result, function (key, value) {
                        html += `
                            <option value="${value.id}">${value.company_name}</option>
                        `; 
                    });
                    
                    $("#hidesub").show();
                    $('#subaffiliates').append(html);
                    $('#subaffiliates').select2({
                        placeholder: "{{trans('recon.searchbysub')}}",
                    });
                }
            }
            CardLoaderInstance.hide();
        })
        .catch(function (error) {
            CardLoaderInstance.hide();
            toastr.error(response.data.message);
        })
        .then(function () {
            CardLoaderInstance.hide();
        });
    });
    
    $(document).on('submit', '.addpermission', function(e) {
        e.preventDefault();
        CardLoaderInstance.show('.modal-content');
        url = '/reconsettings/addreconpermission'
        var formData = new FormData($(this)[0]);
        axios.post(url, formData)
        .then(function (response) {
            if (response.data.status == 200) {
                $('.addpermission')[0].reset();
                $('#editreconpop').modal('hide');
                toastr.success(response.data.message);
                location.reload();
            }else{
                toastr.error(response.data.message);
            } 
            CardLoaderInstance.hide();
        })
        .catch(function (error) {
            CardLoaderInstance.hide();
            $(".error").html("");
            if (error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function (key, value) {
                    $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }else if(error.response.status == 400) {
                CardLoaderInstance.hide();
                toastr.error(error.response.message);
            }
        })
        .then(function () {
            CardLoaderInstance.hide();
        });
    });
    

    $(document).on('submit', '.managerecon', function(e) {
        e.preventDefault();
        CardLoaderInstance.show('.modal-content');
        url = '/reconsettings/managerecon'
        var formData = new FormData($(this)[0]);
        axios.post(url, formData)
        .then(function (response) {
            $(".error").html("");
            if (response.data.status == 200) {
                $('#reconpop').modal('hide');
                toastr.success(response.data.message);
            }else{
                toastr.error(response.data.message);
            } 
            CardLoaderInstance.hide();
            
        })
        .catch(function (error) {
            CardLoaderInstance.hide();
            $(".error").html("");
            if (error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function (key, value) {
                    $('.' + key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                });
            }
        })
        .then(function () {
            CardLoaderInstance.hide();
        });
    });

    $(document).on('click', '.applyfilter', function(e) {
        e.preventDefault();
        pageNumber = 1;
        getFilterData();
    });

    function getFilterData(type,count) {
        if(count == undefined || count == NaN) {
            count = 0;
        }
        
        processing = true;
        CardLoaderInstance.show('.tab-content');
        let myForm = document.getElementById('filterrecon');
        var formData = new FormData(myForm);
        url = '/reconsettings/listing?page=' + pageNumber;
        axios.post(url, formData)
        .then(function (response) {
            if (response.data.affiliates.length > 0) {
                var html = '';
                var srno = parseInt(count);
                $.each(response.data.affiliates, function (key, val) {
                    srno++;
                    html+=`
                        <tr>
                            <td>${srno}</td>
                            <td>${val.companyname}</td>
                            <td>${val.role}</td>
                            <td>${val.parentname}</td>
                            <td>${val.reconmethod}</td>
                            <td>
                                <a title="Edit" class="editreconpop" data-companyname="${val.companyname}" data-recon="${val.recon}" data-userid="${val.userid}" data-permissions="${val.setpermissions}" style="cursor:pointer">
                                    <i class="bi bi-pencil fs-2 mx-1 text-primary"></i>
                                </a>
                            </td>
                        </tr>
                    `;
                    
                });

                if (type == 'scroll') {
                    $('#reconlisting').append(html);
                    pageNumber += 1;
                    return;
                }

                pageNumber = 2;
                $('#reconlisting').html(html);
            }else{
                if (type != 'scroll') {
                    $('#reconlisting').html("<td colspan='5' align='center'>{{trans('recon.norecord')}}</td>");
                }
                localStorage.setItem("pagenumber", 1);
            }
        })
        .catch(function (error) {
            CardLoaderInstance.hide();
        })
        .then(function () {
            CardLoaderInstance.hide();
        });
    }

    $(".resetbutton").on('click', function () {
        $('#filterrecon')[0].reset();

        arr = $("#affiliates").val();
        arr = $("#affiliates").val().filter(function(e){return e}); 
        $("#affiliates").select2().val(arr).trigger('change.select2')

        subarr = $("#subaffiliates").val();
        subarr = $("#subaffiliates").val().filter(function(e){return e}); 
        $("#subaffiliates").select2().val(subarr).trigger('change.select2')
        $("#hidesub").hide();
        
        $("#rolefilter").select2().val('').trigger('change.select2')
        $("#reconmethod").select2().val('').trigger('change.select2')
        $(".applyfilter").trigger("click");
    });


    $(document).scroll(function (e) {
        if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
            if(localStorage.getItem("pagenumber") == 1){
                return false;
            }
            getFilterData('scroll',$('#reconlisting tr:last td:first').html());
        }
    });
 
</script>
