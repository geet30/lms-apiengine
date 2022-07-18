<div class="tab-pane fade" id="salestatus" role="tab-panel">
    <!-- Electricity Status Start-->
    {{ theme()->getView('pages/leads/components/detail/status/status',array('statuses'=>$statuses,'saleProduct'=>$saleProduct,'verticalId'=>$verticalId,'gasSaleProduct'=>$gasSaleProduct,'gasStatuses'=>$gasStatuses,'saleDetail' => $saleDetail,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions)) }}
    <!-- Electricity Status End -->
</div>
