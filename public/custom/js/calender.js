jQuery(function () {
    var currentURL = $('#currentURL').val() ;
    let stateDataTable = nationalDataTable = '';
    if(currentURL == 'settings/state-holidays'){
        stateDataTable = $("#state_holiday_table").DataTable({
            responsive: false,
            searching: true,
            "sDom": "tipr",
            "pageLength": 10
        });
        loadStateListings();
	}
    if(currentURL == 'settings/national-holidays'){
        nationalDataTable = $("#national_holiday_table").DataTable({
            responsive: false,
            searching: true,
            "sDom": "tipr",
            "pageLength": 10
        });
        loadNationalListings();
	}
 
   
    	    // on change year value ajax request
        
    $(document).on('click', '#applystatefilter', function(e){
        e.preventDefault();
        loaderInstance.show();
        $.when(loadStateListings()).done(function(){
            loaderInstance.hide();
        });
    });
    $(document).on("click", ".resetstatefilter", function(e) {
       
        $('#sort_year').val("");
        $('#sort_state').val("1").change();
        $('#filter_state_holidays').trigger("reset");
        $.when(loadStateListings()).done(function(){
            loaderInstance.hide();
        });
    });
    
    $(document).on('click', '#applynationalfilter', function(e){
        e.preventDefault();
        loaderInstance.show();
        $.when(loadNationalListings()).done(function(){
            loaderInstance.hide();
        });
    });
    $(document).on("click", ".resetnationalfilter", function(e) {
       
        $('#sort_year').val("");
        $('#filter_national_holidays').trigger("reset");
        $.when(loadNationalListings()).done(function(){
            loaderInstance.hide();
        });
    });
    
   
  
    $('#move_in_closing_time').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });

    $(document).on('click','.national_holday_add_btn', function(){
        $('.national_holiday_title').html('Add National Holidays');
        $('.national_holday_submit_btn').html('Add');
        $('#move_in_calender_id').val('');
    });
    $(document).on('click','.edit_national_btn', function(){
        $('.national_holiday_title').html('Edit National Holidays');
        $('.national_holday_submit_btn').html('Save');
        $('#move_in_calender_id').val($(this).attr('data-id'));
        $('#date').val($(this).attr('data-date'));
        $('.date').daterangepicker({ singleDatePicker: true, setDate: $('#date').val() });

        $('#holiday_title').val($(this).attr('data-title'));
        $('#holiday_content').val($(this).attr('data-content'));
    });
    $(document).on('click','.state_holday_add_btn', function(){
        $('.state_holiday_title').html('Add State Holidays');
        $('.state_holiday_submit_btn').html('Add');
        $('#move_in_calender_id').val('');
    });

    // edit state holiday
    $(document).on('click','.edit_state_btn', function(){
        $('.state_holiday_title').html('Edit State Holidays');
        console.log($(this).attr('data-state'));
        $('.state_holiday_submit_btn').html('Save');
        $('#move_in_calender_id').val($(this).attr('data-id'));
        $('#date').val($(this).attr('data-date'));
        $('.date').daterangepicker({ singleDatePicker: true, setDate: $('#date').val() });
        $('#state').val($(this).attr('data-state'));
        $('#holiday_title').val($(this).attr('data-title'));
        $('#holiday_content').val($(this).attr('data-content'));
    });

		// date picker
    $("#date").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
            
        maxYear: parseInt(moment().format("YYYY"),10)
        }, function(start, end, label) {
            var years = moment().diff(start, "years");
        }
    );

    $('#national_holiday_modal').on('hidden.bs.modal', function() {
        // $('#add_national_holiday')[0].reset();
        $('#holiday_title').val('');
        $('#holiday_content').text('');
        $('.error').text('');
    })
    
    function national_holiday_ajax(){   
        var formdata = $("#add_national_holiday").serialize();    
        var url = "save-national-holidays";
		
        axios.post(url, formdata).then((response) => {
            
            if (response.data.status == 200) {
                $('#national_holiday_modal').modal('hide');
                toastr.success(response.data.message);
                setTimeout(function(){ 
                    window.location.reload(); 
                }, 1000);
            } 
            else if(response.data.status == 422){
                toastr.error(response.data.message);
            }
           

        }).catch((error) => {
            if (error.response.status == 422) {
                errors = error.response.data.errors;
                $.each(errors, function(key, value) {
                    $('[name="' + key + '"]').parent().find('span.error').empty().addClass(
                        'text-danger').text(value).finish().fadeIn();
                });
            } 
            toastr.error('Please Check Errors');
            return false;
        })
       
	}
    function state_holiday_ajax(){
        $.ajax({
            url : 'save-state-holidays', //path
            type:'post',
            data :$("#add_state_holiday").serialize(),//data
            dataType : 'json',
           
            success : function(data){
                if(data.status == 200){
                    $('#state_holiday_modal').modal('hide');
                    toastr.success(data.message);
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }else if(data.status == 422){
                    toastr.error(data.message);
                }
            },
            error : function(data){
                if(data.responseJSON)
                {
                    var errors = data.responseJSON.errors;
                    $.each(errors, function(i, obj){
                        $('[name="' + i + '"]').parent().find('span.error').empty().addClass(
                                'text-danger').text(obj).finish().fadeIn();
                        
                    });
                    toastr.error('Please Check Errors');
                    return false;
                }
            }
        });
    }
    $(document).on('click','.national_holday_submit_btn',function(){
        national_holiday_ajax();
    });

    function loadNationalListings(){
        $("#national_list_table").empty();
        var filter_data = $("form[name=filter_national_holidays]").serialize();
        return $.ajax({
               type : 'get',
               url : 'national-holidays', 
               data : filter_data,
               dataType : 'json',
               async: false,
               success : function(data){
                   if(data.success == 'false'){
                    toastr.error(data.message);
                   }
                   else{
                    
                        nationalDataTable.destroy();
                        $("#national_list_table").html(data.html);	
                        nationalDataTable =   $("#national_holiday_table").DataTable({
                            responsive: false,
                            searching: true,
                            "sDom": "tipr",
                            "pageLength": 10
                        });
                        KTMenu.createInstances();
                    }
               },
                error : function(xhr,ajaxOptions,thrownError){
                    loaderInstance.hide();
                },
                complete:function(){
                   //stopLoader('#datatable_ajax');
                }
           });
    }
    function loadStateListings(){
        var filter_data = $("form[name=filter_state_holidays]").serialize();
        $.ajax({
            type : 'get',
            url : 'state-holidays', //path
            data : filter_data,
            dataType : 'json',
            async: false,
            
            success : function(data){
                if(data.success == 'false'){
                    toastr.error(data.message);
                }
                else{ 
      
                    stateDataTable.destroy();
                    $("#state_list_table").html(data.html);
                    stateDataTable =   $("#state_holiday_table").DataTable({
                        responsive: false,
                        searching: true,
                        "sDom": "tipr",
                        "pageLength": 10
                    });
                    KTMenu.createInstances();
                }  	
            },
            error : function(xhr,ajaxOptions,thrownError){
                loaderInstance.hide();
            },
            complete:function(){
                //stopLoader('#datatable_ajax');
            }
        });
    }

    function delete_state_holiday_ajax(id){
        // hide all error messages before ajax request.		
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });	
		$.ajax({
			url : 'delete-state-holiday', //path
			type:'post',
			data :{
				id:id
			},
			dataType : 'json',
			
			success : function(data){
				if(data.status){
					toastr.success(data.message);
					setTimeout(function(){ 
						loadStateListings(); 
					}, 1000);
				}else{
					toastr.error(data.message);
				}
			},
			error : function(data){
				if(data.responseJSON)
				{
					var err_response = data.responseJSON;
					// if response has error message then alertify error message.
					if(err_response.message){
						toastr.error(err_response.message);
					}
				}
			}
		});
    }

    function delete_national_holiday_ajax(id){
		// hide all error messages before ajax request.	
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });	
		$.ajax({
			url : 'delete-national-holiday', //path
			type:'post',
			data :{
				id:id
			},
			dataType : 'json',
			
			success : function(data){
				if(data.status){
					toastr.success(data.message);
					setTimeout(function(){ 
						loadNationalListings(); 
					}, 1000);
				}else{
					toastr.error(data.message);
				}
			},
			error : function(data){
				if(data.responseJSON)
				{
					var err_response = data.responseJSON;
					// if response has error message then alertify error message.
					if(err_response.message){
						toastr.error(err_response.message);
					}
				}
			}
		});
	}

    function weekend_content_ajax(){
		$.ajax({
			url : 'weekend-content',
			type:'post',
			data :$("#move_in_weekend_form").serialize(),//data
			dataType : 'json',
			success : function(data){
				
                if(data.status == 200){
                    $('.move_in_weekend_modal').modal('hide');
                    toastr.success(data.message);
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }else if(data.status == 422){
                    toastr.error(data.message);
                }
			
			},
			error : function(data){
				if(data.responseJSON)
                {
                    var errors = data.responseJSON.errors;
                    $.each(errors, function(i, obj){
                        $('[name="' + i + '"]').parent().find('span.error').empty().addClass(
                                'text-danger').text(obj).finish().fadeIn();
                        
                    });
                    toastr.error('Please Check Errors');
                    return false;
                }
			}
		});
	}

    // function closing_time_ajax(){
	// 	$.ajax({
	// 		url : 'closing-time',
	// 		type:'post',
	// 		data :$("#move_in_closing_time_form").serialize(),//data
	// 		dataType : 'json',
	// 		success : function(data){
    //             console.log('test');
    //             console.log(data);
    //             if(data.status == 200){
    //                 $('.move_close_time_modal').modal('hide');
    //                 toastr.success(data.message);
    //                 setTimeout(function(){
    //                     window.location.reload();
    //                 }, 1000);
    //             }else if(data.status == 422){
    //                 toastr.error(data.message);
    //             }
	// 		},
	// 		error : function(data){
	// 			if(data.responseJSON)
    //             {
    //                 var errors = data.responseJSON.errors;
    //                 $.each(errors, function(i, obj){
    //                     $('[name="' + i + '"]').parent().find('span.error').empty().addClass(
    //                             'text-danger').text(obj).finish().fadeIn();
                        
    //                 });
    //                 toastr.error('Please Check Errors');
    //                 return false;
    //             }
	// 		}
	// 	});
	// }
    	    // key press in closing time
    // $('#move_in_closing_time').keypress(function(e){
    //     if (e.which == '13')
    //     {
    //         $('#move_in_closing_time').parent('.field-holder').find('span.form_error').slideDown(200).html('');
    //         $('#move_in_closing_time').css('border-color','');
    //         // 
    //         if($('#move_in_closing_time').val()=='')
    //         {
    //             $('#move_in_closing_time').parent('.field-holder').find('span.form_error').slideDown(200).html('Please enter closing time.');
    //             $('#move_in_closing_time').css('border-color','red');
    //             return false;
    //         }else{
    //             closing_time_ajax();
    //             return false;
    //         }
    //     }
    // });
    $(document).on('click','.move_in_week_btn',function(){
        weekend_content_ajax();
    });
    $(document).on('click','.delete_national_btn',function(){
        var id=$(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
              delete_national_holiday_ajax(id);
              Swal.fire(
                'Deleted!',
                'Holiday has been deleted.',
                'success'
              )
            }
        });
   
    });
    $(document).on('click','#move_in_closing_time_btn',function(){
        closing_time_ajax();
    });
    $(document).on('click','.state_holiday_submit_btn',function(){
        state_holiday_ajax();
    });
    $(document).on('click','.weekend_content',function(){
       $('#move_in_weekend_modal').modal('show');
    });
    $(document).on('click', '.move_in_close_time_btn', function(){
        $('#move_close_time_modal').modal('show');
    });
    $(document).on('click','.delete_state_btn',function(){
        var id=$(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_state_holiday_ajax(id);
                Swal.fire(
                    'Deleted!',
                    'Holiday has been deleted.',
                    'success'
                )
            }
        });
    });
});
