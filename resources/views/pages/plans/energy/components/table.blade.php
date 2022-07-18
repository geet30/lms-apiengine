<div class="card-body pt-0">

    <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class dataTable no-footer dtr-inline" id="plan_data_table">
        <thead>
            <tr class="fw-bolder fs-7 text-gray-400 px-7">
                <!-- <th class="min-w-300px" data-priority="1">Records</th> -->
                <th class="text-capitalize text-nowrap" data-priority="1">Sr.No.</th>
                <th class="text-capitalize text-nowrap" data-priority="1">Plan ID</th>
                <th class="text-capitalize text-nowrap">Plan Name</th>
                <th class="text-capitalize text-nowrap">plan type</th>
                <th class="text-capitalize text-nowrap">upload plan pdf</th>
                <th class="text-capitalize text-nowrap">upload on</th>
                <th class="text-capitalize text-nowrap">active on</th>
                <th class="text-capitalize text-nowrap">Status</th>
                <th class="text-capitalize text-nowrap">Show on Agents</th>
                <th class="text-capitalize text-nowrap">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i =1;

            @endphp
            @foreach ($allPlans as $plan)
            <tr>
                <!-- <td>1</td> -->
                <td>{{$i++}}</td>
                <td>{{$plan['id']}}</td>
                <td>{{$plan['name']}}</td>
                <td>
                    @if($plan['plan_type']==1)
                    Residential
                    @elseif($plan['plan_type']==2)
                    Business
                    @endif
                </td>
                <td>
                    <a title="Download plan pdf" class="btn btn-circle btn-icon-only btn-default downloadPlanPdf"
                        data-providername="" data-energytype="electricity" data-filename=" Res_39781617460638.pdf"
                        data-planname="" target="_blank"><span class="fa fa-arrow-circle-o-down"
                            style="color:#578ebe;"></span></a>
                    <a title="Upload plan pdf" class="btn btn-circle btn-icon-only btn-default uploadPlan"
                        data-toggle="modal" data-id="" data-plan=""><span class="fa fa-cloud-upload"
                            style="color:#578ebe;"></span></a>
                </td>

                <td>{{$plan['upload_on']}}</td>
                <td>{{$plan['active_on']}}</td>
                <td>
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input sweetalert_demo plan_status" type="checkbox" value="" name="plan_status" id ="plan_status" data-id={{$plan['id']}} data-status="{{$plan['status']}}" @if($plan['status']==1) checked="checked"@endif>
                    </div>
                </td>
                <td>
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input sweetalert_demo agentportal" type="checkbox" value="" name="agentportal" id ="agentportal" data-id={{$plan['id']}} data-status="{{$plan['show_on_agents']}}" @if($plan['show_on_agents']==1) checked="checked"@endif>
                    </div>
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">Actions
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            @php $planId = isset($plan["id"])?$plan["id"]:'' @endphp
                            @if(checkPermission('edit_energy_plan',$userPermissions,$appPermissions))
                                <a href=" {{ theme()->getPageUrl('provider/plans/energy/get-edit/'.encryptGdprData($planId)) }}" class="menu-link px-3">Edit plan</a>
                            @endif

                            @if($plan['energy_type']== '1' && checkPermission('energy_solar_rate',$userPermissions,$appPermissions))
                                <a href=" {{ theme()->getPageUrl('provider/plans/energy/solar-rates/'.encryptGdprData($providerId).'/'.encryptGdprData($planId)) }}" class="menu-link px-3">Solar Rate</a>
                            @endif

                            @if(checkPermission('energy_plan_rate_detail',$userPermissions,$appPermissions))
                                <a href="{{ theme()->getPageUrl('provider/plans/energy/plan-rates/'.encryptGdprData($planId)) }}" class="menu-link px-3">Plan Rate Details</a>
                            @endif

                            @if(checkPermission('delete_energy_plan',$userPermissions,$appPermissions))
                                <a href="" class="menu-link px-3">Delete plan</a>
                            @endif
                            <a href="" class="menu-link px-3">History</a>
                        </div>
                    </div>
                    <!--end::Menu-->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@section('styles')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
