<!--begin::Menu 3-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3 all-table-css-class" data-kt-menu="true">

    <!--begin::Menu item-->
    <div class="menu-item px-3" data-bs-toggle="tooltip" data-bs-placement="left" >
        <a href="{{ theme()->getPageUrl('provider/edit/'.encryptGdprData($provider_id).'/'.encryptGdprData($service_id)) }}" class="menu-link px-3"><i class="bi bi-pencil-square"></i> Edit</a>
    </div>
    <div class="menu-item px-3" data-bs-toggle="tooltip" data-bs-placement="left">
        <a href="{{ theme()->getPageUrl('provider/link-provider/'.encryptGdprData($provider_id)) }}" class="menu-link px-3"><i class="bi bi-gear"></i> Settings</a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3" data-bs-toggle="tooltip" data-bs-placement="left" >
        <a data-bs-toggle="modal" data-bs-target="#provider-detail" id="view-provider" data-url='{{route('provider.view', encryptGdprData($provider_id))}}' class="menu-link px-3"><i class="bi bi-eye"></i> View</a>
  
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-bs-toggle="tooltip" data-bs-placement="left" >
        <a href="" class="menu-link px-3"><i class="bi bi-trash"></i> Delete</a>

    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3 my-1">
        <a href="" class="menu-link px-3"><i class="bi bi-calendar-check"></i> GSSSBDR</a>
    </div>

    <div class="menu-item px-3 my-1">
    @if($service_id == 2)
        <a href="{{ theme()->getPageUrl('provider/assigned-handsets/'.encryptGdprData($provider_id).'/list') }}" class="menu-link px-3"> <i class="bi bi-gear"></i>Assigned Phone(s)</a>
    @endif
    </div>
    <!--end::Menu item-->
</div>
<!--end::Menu 3-->