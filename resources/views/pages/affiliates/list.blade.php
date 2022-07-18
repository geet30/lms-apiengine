<x-base-layout>
    <!--begin::Content-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/affiliates/components/modal') }}
        {{ theme()->getView('pages/affiliates/components/listingtoolbar', array('info' => $info,'affId'=>$affId,'affiliateuser' => $affiliateuser,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions)) }}
        {{ theme()->getView('pages/affiliates/components/table', array('info' => $info,'affId'=>$affId,'affiliateuser' => $affiliateuser,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions)) }}
    </div>
    <!--end::Content-->
</x-base-layout>
