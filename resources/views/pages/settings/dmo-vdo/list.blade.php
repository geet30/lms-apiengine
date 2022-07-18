<x-base-layout>
    <!--begin::Row-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/settings/dmo-vdo/components/toolbar') }}
        {{ theme()->getView('pages/settings/dmo-vdo/components/table') }}
    </div>
    {{ theme()->getView('pages/settings/dmo-vdo/components/modal',['distributors'=>$distributors, 'tariff_types'=>$tariff_types, 'states'=>$states, 'dmo_states'=>$dmo_states]) }}
    <!--end::Row-->
    @section('styles')
        <link href="/custom/css/loader.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

        <style>
            .bluebox {
                box-sizing: border-box;
                padding: 5px;
                width:110px;
                height:30px;
                margin-bottom: 5px;
                float:left;
            }
            .marquee {
                white-space: nowrap;
                overflow: hidden;
            }
            .marquee span {
                display: inline-block;
                width: 100%;
            }
            .marquee span span {
                transition: left 4s linear;
                position: relative;
                overflow-x: hidden;
                text-overflow: ellipsis;
                left: 0px;
            }
            .marquee:active, .marquee:hover {
            }
            .marquee:active span, .marquee:hover span {
                width: auto;
            }
            .marquee:active span span, .marquee:hover span span {
                left: calc(110px - 15px - 100%);
            }
            div.dataTables_wrapper div.dataTables_paginate ul.pagination {
                justify-content: flex-end;
            }
        </style>
    @endsection
    @section('scripts')
        <script src="/custom/js/breadcrumbs.js"></script>
        <script src="/custom/js/loader.js"></script>
        <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
        @include('pages.settings.dmo-vdo.components.js');

        <script>
            const breadArray = [{
                title: 'Dashboard',
                link: '/',
                active: false
            },
                {
                    title: 'DMO VDO',
                    link: '#',
                    active: true
                },
            ];
            const breadInstance = new BreadCrumbs(breadArray);
            breadInstance.init();
        </script>
    @endsection
</x-base-layout>
