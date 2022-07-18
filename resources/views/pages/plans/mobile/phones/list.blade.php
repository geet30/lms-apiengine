<x-base-layout>
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            {{ theme()->getView('pages/plans/common/header',['selectedProvider' => $selectedProvider]) }}
        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::Basic info-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/plans/mobile/phones/components/toolbar',['brands' => $brands,'filterVars' => $filterVars]) }}
        {{ theme()->getView('pages/plans/mobile/phones/components/table',['brands' => $brands,'assignHandset' => $assignHandset,'planId' => $planId ,'providerId' => $providerId]) }}
        {{ theme()->getView('pages/plans/mobile/phones/components/modals',['brands' => $brands,'assignHandset' => $assignHandset,'providerId' =>$providerId ,'planId' =>$planId]) }}
    </div>
    
    @section('scripts')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script> 
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
        var providerId = '{{encryptGdprData($providerId)}}';
        var planId = '{{encryptGdprData($planId)}}';
        var type = 'Manage Phone(s)';
        var diff_aff = '/provider/list';
        var aff_head = 'Providers';

        const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: aff_head,
                    link: diff_aff,
                    active: false
                },
                {
                    title: 'Mobile Plans',
                    link: "{{ theme()->getPageUrl('provider/plans/mobile/'.encryptGdprData($providerId)) }}",
                    active: false
                },
                {
                    title: type,
                    link: '#',
                    active: true
                },
            ];
        const breadInstance = new BreadCrumbs(breadArray,'Plans');
        breadInstance.init();

        $(document).on('click','.assign_handsets',function(event)
        {
            var url = '/provider/plans/mobile/{{$providerId}}/get-phone-list/{{$planId}}'; 
            axios.get(url)
            .then(function (response) {  
                var html='';
                if(response.data.data.length>0){
                    $.each(response.data.data, function(i,v){
                        html+='<option value='+v.id+'>'+v.name+'</option>';
                    }); 
                }
                $('.all_handsets_list').html(html).select2(); 
            })
            .catch(function (error) { 
            });
        });

        $(document).on('submit','#assign_phone_form',function(event)
        { 
            if($("#select_assign_handset").val() == null || $("#select_assign_handset").val() =="" || $("#select_assign_handset").val() == "undefined"){
                toastr.error('Please select any Phone(s).');
                return false;
            }
            let formData = new FormData(this);
            var url = '/provider/plans/mobile/{{$providerId}}/assign-phone';
            event.preventDefault();
            axios.post(url,formData)
            .then(function (response) {  
                toastr.success(response.data.message);
                loadListing(response.data.handsets);
                $('#assign_phone_modal').modal('hide');
            })
            .catch(function (error) { 
                toastr.error(error.message);
            });
        });

        function loadListing(data)
        {
            var html = '';
            if(data.length > 0)
			{ 
                var i =1;
				$.each(data, function (key, val) {
					html += `
					    <tr>
							<td>
								${i++}
                            </td>
                            <td>${val.handset.name}</td> 
                            <td>${val.handset.brand.title}</td>  
							<td>
							<td>
								<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
									<input class="form-check-input sweetalert_demo change-status" type="checkbox" value="" name="notifications" ${val.status == 1 ?'checked': ''} data-id="${val.id}">
								</div>
							</td>
							</td>
							<td>
								<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{__('plans/mobile.table_actions')}}
								<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
								<span class="svg-icon svg-icon-5 m-0">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
									</svg>
								</span>
								<!--end::Svg Icon--></a>
								<!--begin::Menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
                                        <a href="/provider/plans/mobile/${providerId}/manage-phone/${planId}/manage-phone-variant/${val.handset_id}" class="menu-link px-3">Manage Variant</a>
									</div>
								</div>
							</td>
						</tr> 
                        `;
					});
				processing = false;
			}
			else
			{
				html = '<tr style="text-align:center"><td colspan="11">No Data Found</td></tr>'
			} 
            $('.handset_table_body').html(html);
            KTMenu.createInstances(); 
        }
        
        /*
        * Change Status 
        */
        $(document).on('click','.change-status', function(e){ 
            var check = $(this);
            var id = check.attr("data-id");
            var url = '/provider/plans/mobile/{{$providerId}}/phones/change-status/{id}';
            var isChecked = check.is(':checked');
            var status = 0;
            var title = 'Are you sure?';
            var text = 'You want to change status!';
            if(isChecked)
            {
                var status = 1; 
                title = 'Are you sure?';
                text = 'You want to change status!';
            }
            var formdata = new FormData();
            formdata.append("id", id);
            formdata.append("status", status);
            Swal.fire({
                title: title,
                text: text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then(function(result) {
                if (result.isConfirmed) {
                    axios.post(url,formdata )
                    .then(function (response) {
                        if(response.data.status == 400){
                            toastr.error(response.data.message);
                        }else{
                            toastr.success(response.data.message);
                        }
                    })
                    .catch(function (error) { 
                        toastr.error(error.response.data.message);
                        if (isChecked) {
                            check.prop('checked', false);
                        } else {
                            check.prop('checked', true);
                        }
                    });
                }else{
                    if (isChecked) {
                        check.prop('checked', false);
                    } else {
                        check.prop('checked', true);
                    }
                }
            }) 
        });
    </script> 
    @endsection
</x-base-layout>