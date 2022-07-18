<x-base-layout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Form-->
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="../../demo8/dist/apps/ecommerce/catalog/products.html">

                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
    @section('scripts')
        <script src="/custom/js/provider.js"></script>
        <script src="/custom/js/breadcrumbs.js"></script>
        <script>
            const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: 'Provider',
                    link: `{{ theme()->getPageUrl('provider/list') }}`,
                    active: false
                },
                {
                    title: 'Provider Detail',
                    link: '#',
                    active: true
                },
            ];
            const breadInstance = new BreadCrumbs(breadArray);
            breadInstance.init();
        </script>
    @endsection
</x-base-layout>

