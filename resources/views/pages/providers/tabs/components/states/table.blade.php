<div class=" table-responsive px-8">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class">
        <thead>
        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
            <th class="w-30 text-capitalize text-nowrap" width="30%">{{ __('affiliates_label.api_key.name') }}</th>
            <th class="w-30 text-capitalize text-nowrap" width="30%">{{ __('affiliates_label.table.status') }}</th>
            <th class="w-30 text-capitalize text-nowrap" width="30%">{{ __('affiliates_label.table.retentionalloweded') }}</th>
            <th class="w-10 text-capitalize text-nowrap" width="10%">{{ __('affiliates_label.table.actions') }}</th>
        </tr>
        </thead>

        <tbody class="fw-bold text-gray-600 statesTabledata">
        @if(count($assignedStates)>0)
            @foreach($userStates as $data )
                <tr>
                    <td>{{$data->state->state_code}}</td>
                    <td>
                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                            <input class="form-check-input sweetalert_demo changestatestatus" type="checkbox" data-id="{{$data->user_state_id}}" @if ($data->status==1) checked @endif>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Retention Allowed">
                            <input class="form-check-input sweetalert_demo changeretentionalloweded" type="checkbox" data-id="{{$data->user_state_id}}" @if ($data->retention_alloweded==1) checked @endif>
                        </div>
                    </td>
                    <td class="">
                        <a href="#" class="deletestate" data-id="{{$data->user_state_id}}" title="Delete">
                            <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <td colspan="3" align="center">{{ __('affiliates.norecord') }}</td>
        @endif
        </tbody>

    </table>

</div>
