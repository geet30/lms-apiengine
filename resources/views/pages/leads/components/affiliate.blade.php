<div class="tab-pane fade" id="affiliates" role="tab-panel">

            <!-- Affiliate Information Start-->
        {{ theme()->getView('pages/leads/components/detail/affiliate/affiliate-info',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'saleType'=>$saleType,'subAffiliate'=> $subAffiliate,'affiliateData'=>$affiliateData,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions)) }}
        <!-- Affiliate Information End -->
        @if($saleType == 'sales' || $saleType == 'leads')
        <!-- Affiliate Comment Start-->
        {{ theme()->getView('pages/leads/components/detail/affiliate/affiliate-comment',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
        <!-- Affiliate Comment End -->
    @endif
    </div>
