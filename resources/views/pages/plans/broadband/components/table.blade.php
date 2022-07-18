		<!--begin::Card body-->
		<div class="pt-0 table-responsive">
			<!--begin::Table-->
			<table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="lead_data_table">
				<!--begin::Table head-->
				<thead>
					<!--begin::Table row-->
					<tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
						<th class="min-w-50px text-capitalize text-nowrap">{{__('plans/broadband.sr_no')}}</th>
						<th class="min-w-50 text-capitalize text-nowrap">{{__('plans/broadband.planname')}}</th>
						<th class="min-w-100px text-capitalize text-nowrap">{{__('plans/broadband.table_connection_type')}}</th>
						<th class="min-w-30px text-capitalize text-nowrap">{{__('plans/broadband.status')}}</th>
						<th class="text-end min-w-70px text-capitalize text-nowrap">{{__('plans/broadband.table_actions')}}</th>
					</tr>
					<!--end::Table row-->
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody class="fw-bold text-gray-600">
				<?php $inc = 1; ?>
                @if(isset($plans) && count($plans)>0)
                    @foreach($plans as $plan)
						<tr>
							<td>{{$inc}}</td>
							<td>{{$plan->name}}</td>
							<td>{{$plan->connectionData->name}}</td>
							<td>
								<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
									<input class="form-check-input sweetalert_demo change-status" type="checkbox" value="" name="notifications" {{$plan->status == 1?'checked':''}} data-status="{{encryptGdprData($plan->id)}}">
								</div>
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
									@if(checkPermission('edit_broadband_plan',$userPermissions,$appPermissions))
										<div class="menu-item px-3">
											<a href="{{ theme()->getPageUrl('provider/plans/broadband/edit/'.encryptGdprData($plan->id)) }}" class="menu-link px-3">Edit Plan</a>
										</div>
									@endif
								</div>
								<!--end::Menu-->
							</td>
						</tr>
						<?php $inc++; ?>
						@endforeach
					@else
						<tr>
							<td class="text-center" colspan="5">
								{{__('plans/broadband.no_plan_found')}}
							</td>
						</tr>
					@endif
				</tbody>
				<!--end::Table body-->
			</table>
			<!--end::Table-->
		</div>
		<!--end::Card body-->

		@section('styles')
		<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
		@endsection
