<x-base-layout>
    <!--begin::Row-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/settings/distributors/components/toolbar') }}
        {{ theme()->getView('pages/settings/distributors/components/table') }}
    </div>
    {{ theme()->getView('pages/settings/distributors/components/modal',['post_codes'=>$post_codes]) }}
    <!--end::Row-->
    @section('styles')
        <link href="/custom/css/loader.css" rel="stylesheet" type="text/css"/>
        <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
        <style>
            div.dataTables_wrapper div.dataTables_paginate ul.pagination {
                justify-content: flex-end;
            }
            .dataTables_info {
                margin: auto 1rem;
            }
            tags {
                padding-left: 10px!important;
            }
        </style>
    @endsection
    @section('scripts')
        <script src="/custom/js/breadcrumbs.js"></script>
        <script src="/custom/js/loader.js"></script>
        <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="https://unpkg.com/@yaireo/tagify"></script>
        <script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
        @include('pages.settings.distributors.components.js');

        <script>
            const breadArray = [
                {
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: 'Distributors',
                    link: '#',
                    active: true
                },
            ];
            const breadInstance = new BreadCrumbs(breadArray);
            breadInstance.init();
        </script>
    @endsection
</x-base-layout>
