<?php $i=1;?>
@if(count($contents) >0)
	@foreach($contents as $rows)

		<?php $id = \Crypt::encrypt($rows->id);?>
		<tr>
			<td>{{$i}}</td>
			<td>{{date('d-F-Y', strtotime($rows->date))}}</td>
			<td>{{$rows->holiday_title}}</td>
			<td>{{strlen($rows->holiday_content) > 100 ? substr($rows->holiday_content,0,50)."..." : $rows->holiday_content}}</td>
			
			<td>
				<a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click"
					data-kt-menu-placement="bottom-end">Actions
					<span class="svg-icon svg-icon-5 m-0">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
							fill="none">
							<path
								d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
								fill="black" />
						</svg>
					</span>
				</a>
				<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
					data-kt-menu="true">
					<div class="menu-item ">
						<a href="" data-bs-toggle="modal"
						data-bs-target="#national_holiday_modal" data-id="{{$id}}" data-title="{{$rows->holiday_title}}" data-content="{{$rows->holiday_content}}" data-date="{{date('m/d/Y', strtotime($rows->date))}}" class="menu-link edit_national_btn">Edit</a>
					</div>
					<div class="menu-item ">
						<a href="javascript:void(0);" data-id="{{$id}}" class="menu-link delete_national_btn">Delete</a>
					</div>
				</div>
			</td>
		</tr>
		<?php $i++;?>
	@endforeach


@endif
