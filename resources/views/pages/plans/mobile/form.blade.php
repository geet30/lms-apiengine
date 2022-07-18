<x-base-layout>
    <!--begin::Content-->
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0">
                        <!--begin::Details-->
                        @include('pages.plans.common.header')
                        <!--end::Details-->
                        <!--begin::Navs-->
                        @include('pages.plans.mobile.components.form.tabs-nav')
                        <!--begin::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->

                <!-- Tabs -->
                <div class="tab-content">
                
                    @include('pages.plans.mobile.components.form.basic-details')
                    @if(isset($plan))
                    @include('pages.plans.mobile.components.form.inclusions')
                    @include('pages.plans.mobile.components.form.fees')
                    @include('pages.plans.mobile.components.form.other-info')
                    @include('pages.plans.mobile.components.form.plan-reference')
                    @include('pages.plans.mobile.components.form.terms-conditions')
                    @endif
                </div>
                <!-- End Tabs -->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
        {{ theme()->getView('pages/providers/components/modal') }}
        @if(isset($plan))
        @include('pages.plans.mobile.components.modals')
        @endif
    </div>
    @section('scripts')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script> 
    <script src="/custom/js/plans/common-fee.js"></script>
    @include('pages.plans.mobile.js')
    @endsection
    <!--end::Content-->
</x-base-layout>