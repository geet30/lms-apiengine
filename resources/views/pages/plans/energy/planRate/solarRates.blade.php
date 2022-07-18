
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class dataTable no-footer dtr-inline" id="solar_data_table">
                <thead>
                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                        <!-- <th class="min-w-300px" data-priority="1">Records</th> -->
                        <th data-priority="1" class="text-capitalize text-nowrap">{{ __('plans/energyPlans.sr_no') }}</th>
                        <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.plan_rate') }}</th>
                        <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.plan_desc') }}</th>
                        <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.show_on_front') }}</th>
                        <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.solar_plan_active') }}</th>
                        <th class="text-capitalize text-nowrap">{{ __('plans/energyPlans.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sr=1;?>

                    @foreach ($solarRate as $rate)
                    <tr>

                        <td>{{$sr++}}</td>
                        <td>{{$rate->solar_price}}</td>
                        <td>{{strip_tags($rate->solar_description)}}</td>
                        <td><div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                            <input class="form-check-input sweetalert_demo change_show_frontend" type="checkbox" value="" name="is_show_frontend" data-id="{{encryptGdprData($rate->id)}}" data-show_frontend="{{$rate->is_show_frontend}}"@if($rate->is_show_frontend == 1)checked @endif>
                        </div></td>
                        <td><div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                            <input class="form-check-input sweetalert_demo change-status change_status" type="checkbox" value="" name="status"data-status="{{$rate->status}}" data-id="{{encryptGdprData($rate->id)}}" @if($rate->status == 1)checked @endif>
                        </div></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary text-nowrap" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">Actions
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary w-125px"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">

                                        <button type="button" class="btn me-3 @if($type == 'normal') edit_solar_rate @else edit_solar_rate_premium @endif" data-bs-toggle="modal" @if($type == 'normal') data-bs-target="#add_solar_rate_modal" @else data-bs-target="#add_solar_rate_modal_premium" @endif data-id="{{encryptGdprData($rate->id)}}" data-name="{{$rate->solar_price}}" data-charge="{{$rate->charge}}" data-desc="{{$rate->solar_description}}" data-is_show_frontend="{{$rate->is_show_frontend}}" data-solar_rate_price_description="{{ $rate->solar_rate_price_description }}" data-solar_supply_charge_description="{{ $rate->solar_supply_charge_description }}">
                                            {{ __('plans/energyPlans.edit') }}
                                        </button>
                                        <button type="button" class="btn me-3 delete_solar_rate" data-id="{{encryptGdprData($rate->id)}}">
                                            {{ __('plans/energyPlans.delete') }}
                                            </button>
                                    </div>

                                </div>
                                <!--end::Menu-->
                            </td>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @section('styles')
        <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    @endsection
    @section('scripts')
    @include('pages.plans.energy.planRate.js')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
           var diff_aff = '/provider/list';
            var aff_head = 'Providers';
            let selectedProvider = "{{ ucwords(decryptGdprData($selectedProvider->name)) }}";
            let selectedPlan = "{{ ucwords($selectedPlan[0]['name']) }}";
            let selectedProviderUrl = "/provider/plans/energy/electricity/list/{{ encryptGdprData($selectedProvider->user_id) }}";
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
                link: "#",
                active: false
            },
            {
                title: "Solar Rates",
                link: "#",
                active: true
            },
            
        ];
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();
    </script>

    @endsection


