<div class="pt-0 table-responsive px-8">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class">
        <thead>
        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
            <th class="text-capitalize text-nowrap" width="40%">{{ __('affiliates_label.api_key.name') }}</th>
            <th class="text-capitalize text-nowrap" width="30%">{{ __('affiliates_label.table.assigned_by') }}</th>
            <th class="text-capitalize text-nowrap" width="20%">{{ __('affiliates_label.table.status') }}</th>
            <th class="text-capitalize text-nowrap" width="10%">{{ __('affiliates_label.table.actions') }}</th>
        </tr>
        </thead>

        <tbody class="fw-bold text-gray-600 affiliateTabledata">
        @if(count($assignedProviders)>0)
            @foreach($assignedProviders as $providers )
                <tr>
                    <td>{{$providers['company_name']}}</td>
                    <td>{{$providers['assignedby']}}</td>
                    <td>
                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                            <input class="form-check-input sweetalert_demo change-provider-status" type="checkbox" data-id="{{$providers['id']}}" @if ($providers['status']==1) checked @endif>
                        </div>
                    </td>
                    <td class="">
                        <a class="deletemanageprovider" data-id="{{$providers['id']}}" data-relation="{{$providers['relationaluser']}}" data-service="{{$providers['servive_id']}}" data-source="{{$providers['source_user_id']}}" title="Delete">
                            <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <td colspan="4" align="center">{{ __('affiliates.norecord') }}</td>
        @endif
        </tbody>

    </table>

</div>
