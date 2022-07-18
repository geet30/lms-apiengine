<x-base-layout>
    
    <!--begin::Content-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/settings/calender/state/components/modal') }}
        {{ theme()->getView('pages/settings/calender/state/components/toolbar', array('contents' => $contents)) }}
        {{ theme()->getView('pages/settings/calender/state/components/table', array('info' => $info,'currentURL'=>$currentURL))}}
    </div>
    <!--end::Content-->
</x-base-layout>