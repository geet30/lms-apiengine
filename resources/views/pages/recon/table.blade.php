@php
use app\Repositories\Recon\GeneralMethods;
@endphp
<div class="card-body pt-0 table-responsive ">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class mx-0" id="">
        <thead>
            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                <th class="text-capitalize text-nowrap">{{ __('S.No.') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('recon.companyname') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('recon.role') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('recon.masteraffiliate') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('recon.reconmethod') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('recon.action') }}</th>
            </tr>
        </thead>
        <tbody class="fw-bold text-gray-600" id="reconlisting">
            @if(count($result)>0)
                @foreach($result as $index => $data )
                @php $myArray = array()  @endphp
                @foreach($data['getreconAffiliates'] as $permissions )
                @php $myArray[] = $permissions['permission_id'] @endphp
                @endforeach
                @php $setpermissions = implode( ',', $myArray ) @endphp
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$data['company_name']}}</td>
                        <td>@if($data['parent_id'] == 0) {{__('recon.affiliate')}} @else {{__('recon.subaffiliate')}} @endif </td>
                        <td>
                            @if($data['parent_id'] == 0)
                                N/A
                            @else
                            {{GeneralMethods::subaffiliatesParentName($data['parent_id'])}}
                            @endif
                        </td>
                        <td>@if($data['reconmethod'] == 1) {{__('affiliates.monthly')}} @elseif($data['reconmethod'] == 2) {{__('affiliates.bimonthly')}} @endif </td>
                        </td>
                        <td>
                            <a title="Edit" class="editreconpop" data-companyname="{{$data['company_name']}}" data-recon="{{$data['reconmethod']}}" data-userid="{{$data['user_id']}}" data-permissions="{{$setpermissions}}" style="cursor:pointer">
                                <i class="bi bi-pencil fs-2 mx-1 text-primary"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

@section('scripts')
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/custom/js/breadcrumbs.js"></script>
@include('pages.recon.js');
@endsection
