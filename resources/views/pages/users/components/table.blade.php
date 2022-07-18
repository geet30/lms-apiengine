		<!--begin::Card body-->
		<div class="pt-0 table-responsive">
			<!--begin::Table-->
			<table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="lead_data_table">
				<!--begin::Table head-->
				<thead>
					<!--begin::Table row-->
					<tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
						<th class="min-w-50px text-capitalize text-nowrap">Sr. No</th>
						<th class="min-w-50 text-capitalize text-nowrap">Name </th>
						<th class="min-w-100px text-capitalize text-nowrap">Email</th>
						<th class="min-w-50 text-capitalize text-nowrap">Role </th>
						<th class="min-w-30px text-capitalize text-nowrap">Status</th>
						<th class="text-end min-w-70px text-capitalize text-nowrap">Action</th>
					</tr>
					<!--end::Table row-->
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody class="fw-bold text-gray-600" id="users_table_body_data"> 
                	@if(isset($users) && count($users)>0)
                   		@foreach($users as $user)
						   	<tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
								<td>{{ $loop->iteration}}</td>
								<td>{{ decryptGdprData($user->first_name) }} {{ decryptGdprData($user->last_name) }}</td>
								<td>{{decryptGdprData($user->email) }} </td>
								<td>{{isset($roles[$user->role]) ? getModifyRoleName($user->role) :'N/A' }} </td>
								<td>
									@if(checkPermission('change_status_user',$userPermissions,$appPermissions))
									<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
										<input class="form-check-input sweetalert_demo change-status" type="checkbox" value="" name="notifications" {{$user->status == 1?'checked':''}} data-id="{{encryptGdprData($user->id)}}">
									</div>
									@else
										--	
									@endif
								</td>
								<td>
									<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
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
										<?php 
											$assignServices = implode(',',array_column($user->userService->toArray(),'service_id'));
										?>
										@if(checkPermission('users_action',$userPermissions,$appPermissions))
											@if(checkPermission('edit_user',$userPermissions,$appPermissions))
											<div class="menu-item px-3">
												<a class="menu-link px-3 edit_user" data-id="{{encryptGdprData($user->id)}}" data-first_name="{{decryptGdprData($user->first_name)}}" data-last_name="{{decryptGdprData($user->last_name)}}" data-phone="{{decryptGdprData($user->phone)}}" data-email="{{decryptGdprData($user->email)}}" data-role="{{$user->role}}" data-service="{{$assignServices}}">Edit</a>
											</div>
											@endif

											@if(checkPermission('assign_affliate',$userPermissions,$appPermissions))
											<div class="menu-item px-3">
												<a href="/manage-user/assign-affiliate/{{encryptGdprData($user->id)}}" class="menu-link px-3" >Assign Affiliate</a>
											</div> 
											@endif

											@if(checkPermission('assign_permissions',$userPermissions,$appPermissions))
											<div class="menu-item px-3">
												<a href="/manage-user/assign-permissions/{{encryptGdprData($user->id)}}" class="menu-link px-3" >Permissions</a>
											</div> 
											@endif

											@if(checkPermission('delete_user',$userPermissions,$appPermissions))
											<div class="menu-item px-3">
												<a href="#" class="menu-link px-3" >Delete</a>
											</div> 
											@endif

											@if(checkPermission('manage_user_2fa',$userPermissions,$appPermissions))
											<div class="menu-item px-3">
												<a href="#" class="menu-link px-3" >Manage 2FA</a>
											</div> 
											@endif
										@endif
									</div>
									<!--end::Menu-->
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td class="text-center" colspan="5">
								No user found.
							</td>
						</tr>
					@endif
				</tbody>
				<!--end::Table body-->
			</table>
			<!--end::Table-->
		</div>
		<!--end::Card body-->
 
