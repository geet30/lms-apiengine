<x-base-layout>
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            {{ theme()->getView('pages/plans/common/header',['selectedProvider' => $selectedProvider]) }}
        </div>
    </div>
    <!--end::Navbar-->
    {{ theme()->getView('pages/providers/components/modal') }}
    <!--begin::Basic info-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/plans/broadband/components/toolbar',['providerUser' => $providerUser[0] ,'connectionTypes' => $connectionTypes ,'filterVars' => $filterVars,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions]) }}
        {{ theme()->getView('pages/plans/broadband/components/table',['plans' => $plans ,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions]) }}
    </div>
    
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
        var type = 'Broadband Plans';
        var diff_aff = '/provider/list';
        var aff_head = 'Providers';
        var current_head = "{{ ucwords($selectedProvider->name) }}";
        var current_head_url = "/provider/plans/broadband/{{ encryptGdprData($selectedProvider->user_id) }}";

        const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: aff_head,
                    link: diff_aff,
                    active: false
                },
                {
                    title: current_head,
                    link: current_head_url,
                    active: false
                },
                {
                    title: type,
                    link: '#',
                    active: true
                },
            ];
        const breadInstance = new BreadCrumbs(breadArray,'Plans');
        breadInstance.init();

        var changeStatusTitle = "{{__('plans/broadband.change_status_title')}}";
        var changeStatusText = "{{__('plans/broadband.change_status_text')}}";

        var disableStatusTitle = "{{__('plans/broadband.disable_status_title')}}";
        var disableStatusText = "{{__('plans/broadband.disable_status_text')}}";
    </script>
    <script src="/custom/js/broadband-plans.js"></script>
    @endsection
</x-base-layout>