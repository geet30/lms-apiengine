<div class="pb-5 pt-3">
    <div class="card shadow-sm">
        <div class="card-header collapsible cursor-pointer rotate collapsed top_worst_plans_header" data-bs-toggle="collapse" data-bs-target="#top_worst_plans_collapsible">
            <h3 class="card-title">Top and Lowest Preferred Plans</h3>
            <div class="card-toolbar rotate-180">
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
                        <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor"></path>
                    </svg>
                </span>
            </div>
        </div>

        <div id="top_worst_plans_collapsible" class="collapse">
            {{ theme()->getView('pages/statistics/component/separate_toolbar',array('chartType'=> 'top_worst_plans_chart', 'subAffiliates' => $subAffiliates, 'affiliates' => $affiliates, 'providers' => $providers, 'services' => $services)) }}
            <div class="card-body">
                <div class="card card-bordered">
                    <div class="card-body">
                        <div class="col-xl-12 mb-5 mb-xl-12">
                            <!--begin::Tables widget 6-->
                            <div class="card card-flush h-xl-100">
                                <!--begin::Header-->
                                <div class="card-header pt-7">
                                    <!--begin::Title-->
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder text-gray-800">Top Preferred Plans</span> 
                                    </h3>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Tab Content-->
                                    <div class="tab-content">
                                        <!--begin::Tap pane-->
                                        <div class="tab-pane fade active show" id="kt_stats_widget_6_tab_1">
                                            <!--begin::Table container-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <tr class="fs-7 fw-bolder text-gray-500 border-bottom-0">
                                                            <th class="p-0 w-150px text-gray-800">Sr. No</th>
                                                            <th class="p-0 min-w-190px text-gray-800">Plan Name</th>
                                                            <th class="p-0 min-w-190px text-gray-800">Provider Name</th>
                                                            <th class="p-0 min-w-150px text-gray-800">Plan Price</th>
                                                            <th class="p-0 min-w-150px text-gray-800">Plan Net Sales</th>
                                                        </tr>
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="top_plans_tbody">     
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Tap pane-->
                                    </div>
                                    <!--end::Tab Content-->
                                </div>
                                <!--end: Card Body-->
                            </div>
                            <!--end::Tables widget 6-->
                        </div>
                    </div>
                </div>

                <div class="card card-bordered pt-5">
                    <div class="card-body">
                        <div class="col-xl-12 mb-5 mb-xl-12">
                            <!--begin::Tables widget 6-->
                            <div class="card card-flush h-xl-100">
                                <!--begin::Header-->
                                <div class="card-header pt-7">
                                    <!--begin::Title-->
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder text-gray-800">Lowest Preferred Plans</span> 
                                    </h3>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Tab Content-->
                                    <div class="tab-content">
                                        <!--begin::Tap pane-->
                                        <div class="tab-pane fade active show" id="kt_stats_widget_6_tab_1">
                                            <!--begin::Table container-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <tr class="fs-7 fw-bolder text-gray-500 border-bottom-0">
                                                            <th class="p-0 w-150px text-gray-800">Sr. No</th>
                                                            <th class="p-0 min-w-190px text-gray-800">Plan Name</th>
                                                            <th class="p-0 min-w-190px text-gray-800">Provider Name</th>
                                                            <th class="p-0 min-w-150px text-gray-800">Plan Price</th>
                                                            <th class="p-0 min-w-150px text-gray-800">Plan Net Sales</th>
                                                        </tr>
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="worst_plans_tbody">
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Tap pane-->
                                    </div>
                                    <!--end::Tab Content-->
                                </div>
                                <!--end: Card Body-->
                            </div>
                            <!--end::Tables widget 6-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
