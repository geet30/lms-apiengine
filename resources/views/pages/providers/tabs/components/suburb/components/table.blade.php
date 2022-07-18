<div class="pt-0 table-responsive px-8">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="suburb-table">
        <thead>
        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
            <th class="w-5% pe-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input check-all main" type="checkbox" data-kt-check="true" data-kt-check-target="#suburb-table .check-all" value="1"/>
                </div>
            </th>
            <th class="w-10% text-capitalize text-nowrap">S.No.</th>
            <th class="w-20% text-capitalize text-nowrap">Postcode</th>
            <th class="w-20% text-capitalize text-nowrap">Suburb</th>
            <th class="w-20% text-capitalize text-nowrap">State</th>
            <th class="w-10% text-capitalize text-nowrap">{{ __('affiliates_label.table.status') }}</th>
            <th class="w-10% text-capitalize text-nowrap">{{ __('affiliates_label.table.actions') }}</th>
        </tr>
        </thead>

        <tbody class="fw-bold text-gray-600 suburbTabledata">
        @if(count($assignedSubrubs)>0)
            @php $count = 1 @endphp
            @foreach($userStates as $userState )
                @foreach($userState->userSubrubs as $key => $userSubrub )
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input check-all check-row" type="checkbox" value="{{$userSubrub->id}}"/>
                            </div>
                        </td>
                        <td>{{$count++}}</td>
                        <td>{{$userSubrub->subrubs->postcode}}</td>
                        <td>{{ $userSubrub->subrubs->suburb }}</td>
                        <td>{{ $userSubrub->subrubs->state }}</td>
                        <td>
                            <span class="d-none row_status">{{$userSubrub->status == 1 ? 'status_enabled' : 'status_disabled'}}</span>
                            <span>
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                                    <input class="form-check-input sweetalert_demo changeSuburbStatus" data-id="{{$userSubrub->id}}" type="checkbox" data-status="{{$userSubrub->status}}" title="Change Status" {{$userSubrub->status== 1 ? 'checked' : ''}}>
                                </div>
                            </span>
                        </td>
                        <td class="">
                            <a class="deleteSuburb" data-id="{{$userSubrub->id}}" title="Delete">
                                <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endif
        </tbody>
    </table>
</div>
