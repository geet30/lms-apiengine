<x-base-layout>

    <!--begin::Content-->
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container">
                <!--begin::Form-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0">
                        @include('pages.plans.common.header')
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                                <!--begin:::Tab item-->
                                <li class="nav-item">
                                    <a class="ms-md-4 nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                        href="#plan_view">{{ __('plans/energyPlans.plan_view') }}</a>
                                </li>
                                <!--end:::Tab item-->
                                <!--begin:::Tab item-->
                                <li class="nav-item">
                                    <a class="ms-md-4 nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                                        href="#plan_info">{{ __('plans/energyPlans.plan_information') }}</a>
                                </li>
                                <!--end:::Tab item-->
                                <!--begin:::Tab item-->
                                <li class="nav-item">
                                    <a class="ms-md-4 nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                                        href="#apply_now">{{ __('plans/energyPlans.apply_now_content') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="ms-md-4 nav-link text-active-primary pb-4 get_remarketing_info"
                                        data-bs-toggle="tab" href="#remarketing_info">{{ __('plans/energyPlans.remarketing_information') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="ms-md-4 nav-link text-active-primary pb-4 get_plan_tag" data-bs-toggle="tab"
                                        href="#tag_info">{{ __('plans/energyPlans.tag_information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="ms-md-4 nav-link text-active-primary pb-4 get_plan_eic" data-bs-toggle="tab"
                                        href="#plan_eic">{{ __('plans/energyPlans.plan_eic') }}</a>
                                </li>

                                <!--end:::Tab item-->
                            </ul>
                    </div>
                </div>



                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin:::Tabs-->
                    <!--end:::Tabs-->
                    <!--begin::Tab content-->

                    <div class="tab-content ">

                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="plan_view" role="tab-panel">
                            @include('pages.plans.energy.edit.plan_view')
                        </div>
                        <div class="tab-pane fade show " id="plan_info" role="tab-panel">
                            @include('pages.plans.energy.edit.plan_info')
                        </div>
                        <div class="tab-pane fade show " id="remarketing_info" role="tab-panel">
                            @include('pages.plans.energy.edit.remarketing_info')
                        </div>
                        <div class="tab-pane fade show " id="apply_now" role="tab-panel">
                            @include('pages.plans.energy.edit.apply_now')
                        </div>
                        <div class="tab-pane fade show " id="tag_info" role="tab-panel">
                            @include('pages.plans.energy.edit.tag_info')
                        </div>
                        <div class="tab-pane fade show " id="plan_eic" role="tab-panel">
                            @include('pages.plans.energy.edit.plan_eic')
                        </div>


                        <!--end::Tab pane-->
                    </div>
                    <!--end::Tab content-->

                </div>
                <!--end::Main column-->
                <!--end::Form-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
        {{ theme()->getView('pages/providers/components/modal') }}
    </div>
    @section('scripts')
    @include('pages.plans.energy.edit.js')
    @endsection
    <!--end::Content-->
</x-base-layout>
