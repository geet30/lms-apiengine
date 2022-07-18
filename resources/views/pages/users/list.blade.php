<x-base-layout>
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
		
    <!--begin::Basic info-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/users/components/toolbar',compact('users','services','roles','userPermissions','appPermissions')) }}
        {{ theme()->getView('pages/users/components/table',compact('users','services','roles','userPermissions','appPermissions')) }}
        {{ theme()->getView('pages/users/components/modal',compact('users','services','roles','userPermissions','appPermissions')) }}
    </div>
    
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/custom/js/permission.js"></script>
    <script src="/custom/js/users.js"></script>
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script>
        var type = 'Manage User'; 

        const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                }, 
                {
                    title: type,
                    link: '#',
                    active: true
                },
            ];
        const breadInstance = new BreadCrumbs(breadArray,type);
        breadInstance.init(); 

        KTMenu.createInstances();
        let dataTable = $("#lead_data_table").DataTable({
            responsive: false,
            searching: true,
            "sDom": "tipr",
        });
    </script> 
    @endsection
</x-base-layout>