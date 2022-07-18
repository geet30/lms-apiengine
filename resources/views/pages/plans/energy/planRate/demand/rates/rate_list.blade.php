<div class="card-body pt-0">
    <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="demand_rate_list">
        <thead>
            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                <th width="6%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.sr_no') }}</th>
                <th width="10%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.seasonal_rates') }}</th>
                <th width="10%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.usage_type') }}</th>
                <th width="10%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.usage_limit') }}</th>
                <th width="10%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.usage_charges') }}</th>
                <th width="10%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.limit_daily') }}</th>
                <th width="15%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.created_time') }}</th>
                <th width="15%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.updated_time') }}</th>
                <th width="10%" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.actions') }}</th>
            </tr>
        </thead>
        <tbody id="dynamicContent">
            @php
                $sr= 1 ;
            @endphp
            @foreach (  $demandRates as $rate)
            <tr>
             <td>{{$sr++}}</td>
            <td>{{getDemandRateType($rate->season_rate_type)}}</td>
            <td>{{$rate->usage_type}}</td>
            <td>{{getLimitLevel($rate->limit_level)}}</td>
            <td>{{$rate->limit_charges}}</td>
            <td>{{$rate->limit_daily}}</td>
            <td>{{$rate->created_at}}</td>
            <td>{{$rate->updated_at}}</td>
            <td>
                <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">Actions

                    <span class="svg-icon svg-icon-5 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                fill="black"></path>
                        </svg>
                    </span>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                    data-kt-menu="true" style="">
                    <div class="menu-item px-3">
                        <button type="button" class="btn me-3 edit_demand_rate" data-bs-toggle="modal"
                            data-bs-target="#add_plan_rate_modal" data-id="{{$rate->id}}" data-usage_type="{{$rate->usage_type }}" data-limit_level="{{getLimitLevel($rate->limit_level)}}"data-limit_charges="{{$rate->limit_charges}}"data-limit_daily="{{$rate->limit_daily}}" data-limit_yearly="{{$rate->limit_yearly}}" data-season_rate_type="{{getDemandRateType($rate->season_rate_type)}}" data-usage_desc ="{{$rate->usage_discription}}">
                            {{ __('plans/energyPlans.edit') }}
                        </button>
                        <button type="button" class="btn me-3" data-bs-toggle="modal" data-bs-target="">
                            {{ __('plans/energyPlans.delete') }}
                        </button>
                    </div>
                </div>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@section('styles')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
@include('pages.plans.energy.planRate.demand.js');
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
        var diff_aff = '/provider/list';
        var aff_head = 'Providers';
        let selectedProvider = "{{ ucwords(decryptGdprData($selectedProvider->name)) }}";
        let selectedPlan = "{{ ucwords($selectedPlan[0]['name']) }}";
        let selectedPlanRate = "{{ ucwords($selectedPlanRate[0]['name']) }}";
        let selectedProviderUrl = "/provider/plans/energy/electricity/list/{{ encryptGdprData($selectedProvider->user_id) }}";
        let selectedPlanUrl = "/provider/plans/energy/plan-rates/{{ encryptGdprData($selectedPlan[0]['id']) }}";
        let selectedPlanRateUrl = "/provider/plans/energy/rates/demand/{{ $planRateId }}/{{ $rateId }}/{{ $propertyType }}"
         const breadArray = [{
            title: 'Dashboard',
            link: '/',
            active: false
        },
        {
            title: aff_head,
            link: diff_aff,
            active: false
        },
        {
            title: selectedProvider,
            link: selectedProviderUrl,
            active: false
        },
        {
            title: "Electricity Plans",
            link: selectedProviderUrl,
            active: false
        },
        {
            title: selectedPlan,
            link: selectedPlanUrl,
            active: false
        },
        {
            title: "Plan Rates",
            link: selectedPlanUrl,
            active: false
        },
        {
            title: selectedPlanRate,
            link: selectedPlanRateUrl,
            active: false
        },
        {
            title: "Demand Rates",
            link: selectedPlanRateUrl,
            active: false
        },
        {
            title: "Tariff Rate",
            link: '#',
            active: true
        },
    ];
   const breadInstance = new BreadCrumbs(breadArray);
   breadInstance.init();
        const dataTable = $("#demand_rate_list").DataTable({
            responsive: true,
            searching: true,
            "sDom": "tipr"
        });

        $('#search_data').keyup(function() {
            console.log($(this).val());
            dataTable.search($(this).val()).draw();
        })
        $('#add_plan_close, #cancel').click(function() {
            $("#add_plan_modal").modal('hide');
        });

    </script>
@endsection
