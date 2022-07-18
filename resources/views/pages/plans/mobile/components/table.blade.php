<div class="pt-0 table-responsive">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="mobile_plans_data_table">
        <thead>
            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                <th class="text-capitalize text-nowrap" data-priority="1">{{ __ ('mobile.listPage.sNo')}}</th>
                <th class="text-capitalize text-nowrap" data-priority="1">{{ __ ('mobile.listPage.planId')}}</th>
                <th class="text-capitalize text-nowrap">{{ __ ('mobile.listPage.planName')}}</th>
                <th class="text-capitalize text-nowrap">{{ __ ('mobile.listPage.connectionType')}}</th>
                <th class="text-capitalize text-nowrap">{{ __ ('mobile.listPage.planType')}}</th>
                <th class="text-capitalize text-nowrap">{{ __ ('mobile.listPage.status')}}</th>
                <th class="text-end min-w-70px text-capitalize text-nowrap">{{ __ ('mobile.listPage.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$plan->id}}</td>
                <td>{{$plan->name}}</td>
                <td>{{isset($plan->connectionType) ? $plan->connectionType->name :'N/A'}}</td>
                <td>{{$planTypes[$plan->plan_type]}}</td>
                <td>
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input sweetalert_demo status" type="checkbox" data-id="{{encryptGdprData($plan->id)}}" value="{{$plan->status == 1 ? '0' : '1'}}" {{$plan->status == 1 ? 'checked' : ''}}>
                    </div>
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
                    @if(checkPermission('edit_mobile_plan',$userPermissions,$appPermissions))
                        <div class="menu-item px-3">
                            <a href="{{ theme()->getPageUrl('provider/plans/mobile/'.$providerId.'/edit/'.encryptGdprData($plan->id)) }}" class="menu-link px-3">{{ __ ('mobile.listPage.editPlan')}}</a>
                        </div>
                    @endif

                    @if(checkPermission('delete_mobile_plan',$userPermissions,$appPermissions))
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" class="menu-link px-3 delete-plan" data-id="{{encryptGdprData($plan->id)}}">{{ __ ('mobile.listPage.deletePlan')}}</a>
                        </div>
                    @endif

                    @if($plan->plan_type == 2 && checkPermission('mobile_section_manage_phones',$userPermissions,$appPermissions)) 
                        <div class="menu-item px-3">
                            <a href="{{ theme()->getPageUrl('provider/plans/mobile/'.$providerId.'/manage-phone/'.encryptGdprData($plan->id)) }}" class="menu-link px-3">{{ __ ('mobile.listPage.managePhone')}}</a>
                        </div> 
                    @endif
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
