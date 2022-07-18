<x-base-layout>
    <!--begin::Row-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/settings/life-support-equipments/components/toolbar') }}
        {{ theme()->getView('pages/settings/life-support-equipments/components/table') }}
    </div>
    {{ theme()->getView('pages/settings/life-support-equipments/components/modal') }}
    <!--end::Row-->
    @section('styles')
        <link href="/custom/css/loader.css" rel="stylesheet" type="text/css" />
        <style>
            div.dataTables_wrapper div.dataTables_paginate ul.pagination {
                justify-content: flex-end;
            }
        </style>
    @endsection
    @section('scripts')
        <script src="/custom/js/breadcrumbs.js"></script>
        <script src="/custom/js/loader.js"></script>
        <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
        @include('pages.settings.life-support-equipments.components.js');

        <script>
            const breadArray = [{
                title: 'Dashboard',
                link: '/',
                active: false
            },
                {
                    title: 'Life Support Equipments',
                    link: '#',
                    active: true
                },
            ];
            const breadInstance = new BreadCrumbs(breadArray);
            breadInstance.init();
        </script>
    @endsection
</x-base-layout>
