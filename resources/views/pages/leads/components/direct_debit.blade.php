<div class="tab-pane fade" id="direct_debit" role="tab-panel">
    @if(isset($visitorBankInfo))
    <!-- Bank Details Start-->
    {{ theme()->getView('pages/leads/components/detail/addons/bank-details',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions, 'saleType' =>  $saleType,'visitorBankInfo'=>$visitorBankInfo)) }}
    <!-- Bank Details End -->
    @endif
    @if(isset($visitorDebitInfo))
    <!--Credit card details-->
    {{ theme()->getView('pages/leads/components/detail/addons/debit-info',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'userPermissions' =>$userPermissions,'appPermissions' => $appPermissions, 'saleType' =>  $saleType,'visitorDebitInfo'=>$visitorDebitInfo)) }}
    <!-- Credit card details -->
    @endif
</div>
