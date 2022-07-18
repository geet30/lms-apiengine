<style>
    .showRefBtn{
        display: block;
    }
    .hideRefBtn{
        display: none;
    }
</style>
<div class="tab-pane fade" id="plan-reference" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#plan_reference_section">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.planRef.sectionTitle')}}  </h3>
            </div>


            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <button type="button" class="btn btn-light-primary addPlanRefButton {{ isset($plan->planMobileReferences) && count($plan->planMobileReferences)>=1 ? 'hideRefBtn' : 'showRefBtn'}}"   data-bs-toggle="modal"   data-bs-target="#plan-reference-modal">{{ __ ('mobile.formPage.planRef.addButton')}}</button>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="plan_reference_section" class="collapse show">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">


                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-capitalize gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_sales_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="text-center min-w-100px text-capitalize text-nowrap">{{ __ ('mobile.formPage.planRef.sr_no')}}</th>
                            <th class="text-center min-w-100px text-capitalize text-nowrap">{{ __ ('mobile.formPage.planRef.title')}}</th>
                            <th class="text-center min-w-100px text-capitalize text-nowrap">{{ __ ('mobile.formPage.planRef.url')}}</th>
                            <th class="text-center min-w-100px text-capitalize text-nowrap">{{ __ ('mobile.formPage.planRef.actions')}}</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600" id="dynamic_plan_reference_data">
                        @foreach($plan->planMobileReferences as $planMobileReference )
                        <!--begin::Table row-->
                        <tr id="row-{{$loop->iteration}}">

                            <td class="text-center">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>

                            <td data-kt-ecommerce-order-filter="order_id" class="text-center">
                                <a href="javascript:void(0)" class="text-gray-800 text-hover-primary fw-bolder">{{$planMobileReference->s_no}}</a>
                            </td>

                            <td class="text-center">
                                <a href="javascript:void(0)" class="text-gray-800 text-hover-primary fw-bolder">{{$planMobileReference->title}}</a>
                            </td>

                            <td class="text-center">
                                <a href="{{$planMobileReference->url}}" target="_blank" rel="noopener noreferrer">
                                    <span class="text-sky-800 text-hover-primary fs-5 fw-bolder">View</span>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{ __ ('mobile.formPage.planRef.actions')}}

                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                        </svg>
                                    </span>

                                </a>

                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">

                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0)" class="menu-link px-3 edit-plan-ref" data-id="{{$planMobileReference->id}}" data-sno="{{$planMobileReference->s_no}}" data-title="{{$planMobileReference->title}}" data-url="{{$planMobileReference->url}}">{{ __ ('mobile.formPage.planRef.edit')}}</a>
                                    </div>

                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0)" class="menu-link px-3 delete-plan-ref" data-id="{{$planMobileReference->id}}" data-kt-ecommerce-order-filter="delete_row">{{ __ ('mobile.formPage.planRef.delete')}}</a>
                                    </div>

                                </div>

                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Content-->
    </div>
</div>
