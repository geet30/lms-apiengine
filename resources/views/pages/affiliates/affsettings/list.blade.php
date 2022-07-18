
<x-base-layout>
    <div class="card mb-5 mb-xl-10">
        {{ theme()->getView('pages/affiliates/components/affiliatedetails', array('records' => $records,'nav'=>'yes','userPermissions' => $userPermissions,'appPermissions' => $appPermissions,'verticals' => $verticals,'activeVerticals' => $activeVerticals ,'energyServiceStatus' => $energyServiceStatus)) }}
    </div>

    <div class="mb-5 mb-xl-10 tab-content" id="heading_affiliate_setting">
       @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_api_key',$userPermissions,$appPermissions)) 
            <div class="tab-pane fade" id="api_keys" role="tab-panel">
                <div class="card">
                    @include('pages.affiliates.affsettings.components.listingtoolbar')
                    @include('pages.affiliates.affsettings.components.table')
                    @include('pages.affiliates.affsettings.components.modal')
                </div>
            </div>
        @endif 
        
        @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_assign_users',$userPermissions,$appPermissions))
        <div class="tab-pane fade" id="manageusers" role="tab-panel">
            <div class="card">
                @include('pages.affiliates.affsettings.components.users.list')
            </div>
        </div>
        @endif
        @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_assign_providers',$userPermissions,$appPermissions))
        <div class="tab-pane fade" id="manageproviders" role="tab-panel">
            <div class="card">
                @include('pages.affiliates.affsettings.components.providers.list')
            </div>
        </div>
        @endif
        @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_ip_whitelist',$userPermissions,$appPermissions))
        <div class="tab-pane fade" id="manageipwhitelist" role="tab-panel">
            <div class="card">
                @include('pages.affiliates.affsettings.components.ipwhitelist.list')
            </div>
        </div>

        <div class="tab-pane fade" id="affiiate_permissions" role="tab-panel">
            @include("pages.affiliates.affsettings.components.permissions.permissions")
        </div>
        @endif
        @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_target',$userPermissions,$appPermissions)) 
        <div class="tab-pane fade" id="managetarget" role="tab-panel">
            <div class="card">
                @include('pages.affiliates.affsettings.components.target.list')
            </div>
        </div>
        @endif
        @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_retention_sale',$userPermissions,$appPermissions))        <div class="tab-pane fade" id="retention_sale" role="tab-panel">
            @include('pages.affiliates.affsettings.components.retention.list')
        </div>
        @endif
        
        @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_tags',$userPermissions,$appPermissions))
        <div class="tab-pane fade" id="managetags" role="tab-panel">
            <div class="card">
                @include('pages.affiliates.affsettings.components.tags.list')
            </div>
        </div>
        @endif
        @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_id_matrix',$userPermissions,$appPermissions))
        <div class="tab-pane fade" id="matrix" role="tab-panel">
            @include('pages.affiliates.affsettings.components.matrix.create_update')
        </div>
        @endif
        <div class="tab-pane fade " id="affiiate_permissions" role="tab-panel">
            @include("pages.affiliates.affsettings.components.permissions.permissions")
        </div>
        @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_actions',$userPermissions,$appPermissions) && checkPermission('affiliate_assign_distributor',$userPermissions,$appPermissions))
        <div class="tab-pane fade" id="life_support" role="tab-panel">
            @include('pages.affiliates.affsettings.components.lifesupport.create_update')
        </div>
        @endif 
    </div>
</x-base-layout>

<script>
   heading_affiliate_setting = $("#heading_affiliate_setting").children("div").attr('id');
   $("#"+heading_affiliate_setting).addClass("show active");
   $("#affiliate_list_detailss").find('li a').first().addClass("active");
</script>
