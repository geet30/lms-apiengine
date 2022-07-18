<x-base-layout>
    {{ theme()->getView('pages/providers/components/modal') }}
        <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
            {{ theme()->getView('pages/providers/components/toolbar', array('services' => $services,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions)) }}
            {{ theme()->getView('pages/providers/components/table', array('info' => $info,'provideruser' => $provideruser ,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions)) }}
        </div>
        @section('scripts')
            <script src="/custom/js/provider.js"></script>
        @endsection
</x-base-layout>
