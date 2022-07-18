<div class="tab-pane fade" id="journey" role="tab-panel">


    <!-- Customer Journey Start-->
    {{ theme()->getView('pages/leads/components/detail/journey/customer-journey',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'gasSaleDetail'=>$gasSaleDetail,'distributors'=>$distributors,'providers'=>$providers,'lifeSupportEquipments' => $lifeSupportEquipments,'currentProvider'=>$currentProvider,'handsetData'=>$handsetData)) }}
    <!-- Customer Journey End -->


    @if($verticalId == 1 && (isset($saleDetail) && $saleDetail->sale_product_product_type == 1))
    <!-- demand-details Start-->
    {{ theme()->getView('pages/leads/components/detail/journey/demand-details',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'masterTariffs' => $masterTariffs)) }}
    <!-- demand-details End -->
    @endif
</div>
