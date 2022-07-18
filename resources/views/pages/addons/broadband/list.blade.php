<x-base-layout>
    {{-- {{ theme()->getView('pages/providers/components/modal') }} --}}
    <!--begin::Row-->
        <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
            {{ theme()->getView('pages/addons/broadband/components/toolbar',array('addon_data'=>$addon_data,'category'=>$category,'appPermissions' => $appPermissions, 'userPermissions' => $userPermissions)) }}
            {{ theme()->getView('pages/addons/broadband/components/table',array('addon_data'=>$addon_data,'category'=>$category,'appPermissions' => $appPermissions, 'userPermissions' => $userPermissions)) }}
        </div>
        <!--end::Row-->
        @section('scripts')
            <script src="/custom/js/addons.js"></script>
        @endsection
</x-base-layout>