<div class="card-body pt-0 table-responsive " id="">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="plan_fees_table">
        <thead>
            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                <th class="text-capitalize text-nowrap">{{__('plans/broadband.sr_no')}}</th>
                <th class="text-capitalize text-nowrap">{{__('plans/broadband.fees.label')}}</th>
                <th class="text-capitalize text-nowrap">{{__('plans/broadband.fees_cost_type.label')}}</th>
                <th class="text-capitalize text-nowrap">{{__('plans/broadband.fees_amount.label')}}</th>
                <th class="text-capitalize text-nowrap">{{__('plans/broadband.fees_action')}}</th>
            </tr>
        </thead>
        <tbody class="fw-bold text-gray-600 plan_fees_table_body">
            @foreach($plan->planFees as $fees)
                <tr>
                    <td>
                        {{$loop->iteration}}
                    </td>
                    <td>
                        {{ isset($fees->feeType->fee_name)? $fees->feeType->fee_name: '' }}
                    </td>
                    <td>
                        {{ isset($fees->costType->cost_name)? $fees->costType->cost_name: '' }}
                    </td>
                    <td>
                        {{ $fees->fees}}
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                        </svg>
                                    </span>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                    <div class="menu-item">
                                        <a class="menu-link px-3 cursor-pointer edit_plan_fees_class" data-bs-toggle="modal"  data-bs-target="#add_fees_modal" data-id='{{$fees->id}}' data-fee_id='{{$fees->fee_id}}' data-cost_id='{{$fees->cost_type_id}}' data-fees='{{$fees->fees}}'
                                        data-additional_info='{{$fees->additional_info}}' >{{__('plans/broadband.edit')}}</a>
                                    </div>
                                    <div class="menu-item">
                                    <a class="menu-link px-3 cursor-pointer delete_plan_fees" data-id='{{$fees->id}}'>{{__('plans/broadband.delete')}}</a>
                                    </div>
                                </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
