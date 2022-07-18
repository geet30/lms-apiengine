		<!--begin::Card body-->
		<div class="pt-0 table-responsive">
			<!--begin::Table-->
			<table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="lead_data_table">
				<!--begin::Table head-->
				<thead>
					<!--begin::Table row-->
					<tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
						<th class="min-w-50px text-capitalize text-nowrap">{{__('plans/mobile.sr_no')}}</th>
						<th class="min-w-50 text-capitalize text-nowrap">{{__('plans/mobile.phone_name_title')}}</th>
						<th class="min-w-50px text-capitalize text-nowrap">{{__('plans/mobile.phone_brand')}}</th>
						<th class="min-w-30px text-capitalize text-nowrap">{{__('plans/mobile.status')}}</th>
						<th class="text-end min-w-70px text-capitalize text-nowrap">{{__('plans/mobile.table_actions')}}</th>
					</tr>
					<!--end::Table row-->
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody class="fw-bold text-gray-600">
				<?php $inc = 1; ?>
                	@if(isset($assignHandset) && count($assignHandset)>0)
						@foreach($assignHandset as $row)
							<tr>
							<td>
								{{$loop->iteration}}</td>
							<td>{{ isset($row->handset->name) ? $row->handset->name:'N/A' }}</td>
							<td>{{ isset($row->handset->brand->title)?$row->handset->brand->title :'N/A' }}</td>
							<td>
								<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
									<input class="form-check-input sweetalert_demo change-status" type="checkbox" value="" name="notifications" {{$row->status == 1?'checked':''}} data-id="{{encryptGdprData($row->id)}}">
								</div>
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
										<a href="{{ theme()->getPageUrl('provider/assigned-handsets/'.encryptGdprData($providerId).'/manage-phone-variant/'.encryptGdprData($row->handset_id)).'/list' }}" class="menu-link px-3">{{__('plans/mobile.manage_variant')}}</a>

										<a data-id="{{encryptGdprData($row->handset_id)}}" class="menu-link px-3 remove_handset">Remove Handset</a>
									</div>
								</div>
							</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td class="text-center" colspan="5">
								{{__('plans/mobile.no_handset_found')}}
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
