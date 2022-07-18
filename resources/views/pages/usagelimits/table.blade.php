<div class="card-body pt-0 table-responsive ">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class mx-0" id="usage_table">
        <thead>
            <tr class="fw-bolder fs-6 text-gray-800 px-7">

                <th class="text-capitalize text-nowrap">{{ __('usagelimits.state') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('usagelimits.postcodes') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('usagelimits.electric') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('usagelimits.gas') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('usagelimits.action') }}</th>
            </tr>
        </thead>
        <tbody class="fw-bold text-gray-600" id="usagebody">
        @if(count($result)>0)
            @foreach($result as $data )
            @php $usagetype = 1 @endphp
            <tr>
               <td>{{$data->state}}</td>
               <td>
                @php $myArray = array() @endphp
                @foreach($data->postcodes as $postcode )
                @php  $myArray[] = $postcode->post_code @endphp
                @endforeach
                @php $postcodes = implode( ', ', $myArray ) @endphp
                {{$postcodes}}
               </td>
               <td>
                Low: {{$data->elec_low_range}} ,
                Medium: {{$data->elec_medium_range}} ,
                High: {{$data->elec_high_range}}
               </td>
               <td>
                Low: {{$data->gas_low_range}} ,
                Medium: {{$data->gas_medium_range}} ,
                High: {{$data->gas_high_range}}
               </td>
               <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <div class="menu-item">
                            <a  class="menu-link editpopup" data-state="{{$data->state}}" data-usagetype="{{$usagetype}}" data-id="{{$data->id}}" data-postcodes="{{$postcodes}}" data-elow="{{$data->elec_low_range}}" data-emedium="{{$data->elec_medium_range}}" data-ehigh="{{$data->elec_high_range}}" data-glow="{{$data->gas_low_range}}" data-gmedium="{{$data->gas_medium_range}}" data-ghigh="{{$data->gas_high_range}}">
                            {{ __('usagelimits.edit') }}
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="" class="menu-link ">{{ __('usagelimits.delete') }}</a>
                        </div>
                    </div>
               </td>
            </tr>
            @endforeach
            @else

        @endif
        </tbody>
    </table>
</div>

@section('styles')
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/custom/js/breadcrumbs.js"></script>
@include('pages.usagelimits.js');
@endsection
