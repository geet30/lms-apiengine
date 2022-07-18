<x-base-layout>

    <div class="card mb-5 mb-xl-10">

        {{ theme()->getView('pages.mobilesettings.handsets.tab', array('nav'=>'yes','userPermissions'=>$userPermissions,'appPermissions' => $appPermissions)) }}
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="tab-content" id="handset_index_permissions">
            <!--begin::Tab pane-->
            <!-- manage_handset_phones -->
          
                <div class="tab-pane fade" id="phones" role="tab-panel">
                @include('pages.mobilesettings.handsets.phones.index')
                </div>
            
            <!--end::Tab pane-->
            @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_brands',$userPermissions,$appPermissions))
                <div class="tab-pane fade" id="brands" role="tab-panel">
                    @include('pages.mobilesettings.handsets.brands.index')
                </div>
            @endif 
            @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_rams',$userPermissions,$appPermissions))   
                <div class="tab-pane fade" id="ram" role="tab-panel">
                    @include('pages.mobilesettings.handsets.ram.index')
                </div>
            @endif
            @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_interanl_storage',$userPermissions,$appPermissions))
                <div class="tab-pane fade" id="internal_storage" role="tab-panel">
                    @include('pages.mobilesettings.handsets.internal_storage.index')
                </div>
            @endif
            @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_colors',$userPermissions,$appPermissions))
                <div class="tab-pane fade" id="colors" role="tab-panel">
                    @include('pages.mobilesettings.handsets.colors.index')
                </div>
            @endif
            @if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_contracts',$userPermissions,$appPermissions))
                <div class="tab-pane fade" id="contracts" role="tab-panel">
                    @include('pages.mobilesettings.handsets.contracts.index')
                </div>
            @endif
        </div>

    </div>

</x-base-layout>

<script>
   heading_affiliate_setting = $("#handset_index_permissions").children("div").attr('id');
   $("#"+heading_affiliate_setting).addClass("show active");
   $("#handset_tab_permission").find('li a').first().addClass("active");
</script>