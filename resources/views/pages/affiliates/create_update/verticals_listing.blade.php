<div class="pt-0 table-responsive px-8 card">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class">
        <thead>
            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                <th class="min-w-50px text-capitalize text-nowrap">{{ __('Service') }}</th>
                <th class="min-w-50px text-capitalize text-nowrap">{{ __('Assigned By') }}</th>
                <th class="min-w-50px text-capitalize text-nowrap">{{ __('Status') }}</th>
                <th class="min-w-50px text-capitalize text-nowrap">{{ __('Created') }}</th>
                <th class="text-end min-w-70px text-capitalize text-nowrap">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody class="fw-bold text-gray-600" id="verticalListing">
        @if(count($verticals)>0 )
            @foreach($verticals as $row)
            <tr>
                <td>{{$row->service_title}}</td>
                <td>{{ucfirst(decryptGdprData($row->first_name)).' '.ucfirst(decryptGdprData($row->last_name))}}</td>
                <td>
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input verticalStatus" type="checkbox"  name="notifications" @if ($row->status==1) checked @endif data-status="{{encryptGdprData($row->id)}}">
                    </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i:s') }}</td>
                <td>
                    <a class="deletevertical" data-id="{{encryptGdprData($row->id)}}" data-service={{$row->service_id}} title="Delete" style="cursor:pointer">
                        <i class="bi bi-trash fs-2 mx-1 text-primary"></i>
                    </a>
                    <a title="Setting" class="editparameter" data-service="{{$row->service_id}}" style="cursor:pointer">
                        <i class="bi bi-gear fs-2 mx-1 text-primary"></i>
                    </a>
                    @if($row->service_id==2)
                        <a  title="Vertical settings"  id="affiliate_plan_type" data-simValue="" data-simMobileValie="" class=" btn-circle btn-icon-only btn-default " style="cursor:pointer"><i class="bi-receipt-cutoff fs-2 mx-1 text-primary"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach

        @else
        <td colspan="5" align="center">{{trans('affiliates.norecord')}}</td>
        @endif
        </tbody>
    </table>
</div>
