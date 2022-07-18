<!--begin::Main column-->
<x-base-layout>
    {{ theme()->getView('pages/settings/export-settings/export-setting',array('exportSettingData' => $exportSettingData)) }}

@section('scripts')
    @include('pages.settings.export-settings.components.js');
@endsection
</x-base-layout>
