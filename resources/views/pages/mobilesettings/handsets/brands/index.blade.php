
    <!--begin::Content-->
{{ theme()->getView('pages/mobilesettings/handsets/brands/components/filtertoolbar', array('modal_id'=>'#mobile_brands_modal', 'os'=>$os,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions)) }}
{{ theme()->getView('pages/mobilesettings/handsets/brands/components/modal', array('brands' => $brands,'os'=>$os,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions)) }}
{{ theme()->getView('pages/mobilesettings/handsets/brands/components/table')}}

<!--end::Content-->

