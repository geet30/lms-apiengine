<x-base-layout>
    {{ theme()->getView('pages/settings/tags/components/modal') }}
    <!--begin::Row-->
        <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
            {{ theme()->getView('pages/settings/tags/components/toolbar') }}
            {{ theme()->getView('pages/settings/tags/components/table',array('tagsData'=>$tagsData,)) }}
        </div>
        <!--end::Row-->
        @section('scripts')
        @include('pages.settings.tags.components.js');
        @endsection
</x-base-layout>
