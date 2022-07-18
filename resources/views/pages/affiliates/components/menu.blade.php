<?php 
$userPermissions = getUserPermissions(); 
$appPermissions = getAppPermissions();
 ?>
<!--begin::Menu 3-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
    @if(Request::is('affiliates/affiliate-settings/*') && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_commission_structure',$userPermissions,$appPermissions))
        <!--begin::Menu item-->
            <div class="menu-item px-3" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" title="Affiliate Commission">
                <a href="{{route('affiliates.commission', $affiliate_id)}}" class="menu-link px-3">
                    Commission
                </a>
            </div>
        <!--end::Menu item-->
    @endif
    
    @if(request()->segment(2) == 'affiliate-settings' || request()->segment(2) == 'edit' || request()->segment(2) == 'affiliate-bdm-permissions')
    <div class="menu-item px-3">
        <a href="{{ theme()->getPageUrl('affiliates/edit/'.$user_id) }}" class="menu-link px-3">
            Edit
        </a>
    </div>
    <div class="menu-item px-3">
        <a href="{{ route('affiliate-keys.list', [$user_id, 'mode' => theme()->getCurrentMode()]); }}" class="menu-link px-3">
            Settings
        </a>
    </div>
    <div class="menu-item px-3">
        <a href="{{ theme()->getPageUrl('affiliates/sub-affiliates/'.$user_id) }}" class="menu-link px-3">
            Sub-Affiliates
        </a>
    </div>
    @elseif(request()->segment(2) == 'sub-affiliates')
    <div class="menu-item px-3">
        <a href="{{ theme()->getPageUrl('affiliates/sub-affiliates/edit/'.$user_id) }}" class="menu-link px-3">
            Edit
        </a>
    </div>
    <div class="menu-item px-3">
        <a href="{{ route('sub-affiliates.affiliate-keys.list', [$user_id, 'mode' => theme()->getCurrentMode()]); }}" class="menu-link px-3">
            Settings
        </a>
    </div>
    @endif

    <div class="menu-item px-3">
        <a href="{{ route('2fa.settings', ['id' => $user_id , 'mode' => theme()->getCurrentMode() ]) }}" class="menu-link px-3">
            Manage 2FA
        </a>
    </div>

    <div class="menu-item px-3">
        <a href="{{ theme()->getPageUrl('affiliates/templates/'.$user_id) }}" class="menu-link px-3">
            Templates
        </a>
    </div>
    
    
   
</div>
<!--end::Menu 3-->
