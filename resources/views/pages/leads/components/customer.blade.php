<div class="tab-pane fade {{ isset($saleType) && $saleType == 'leads' ? 'show active':'' }}" id="customer" role="tab-panel">

    <!-- User Analytics Start-->
    {{ theme()->getView('pages/leads/components/detail/customer_info/user-analytics',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'saleType'=>$saleType)) }}
    <!-- User Analytics End -->
    @if($saleType == 'sales' || $saleType == 'leads')
    @if ($verticalId == 1)
    <!--Site Access Info Start -->
    {{ theme()->getView('pages/leads/components/detail/customer_info/site-access-info',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'saleType'=>$saleType)) }}
    <!--Site Access Info End -->
    @endif
    <!--Joint Access Info Start -->
    @if ($verticalId == 1)
      {{ theme()->getView('pages/leads/components/detail/customer_info/joint-access-info',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'saleType'=>$saleType,'titles' => $customerTitles)) }}
    @endif
    <!--Joint Access Info End -->
     <!-- User Analytics Start-->
     {{ theme()->getView('pages/leads/components/detail/customer_info/customer-info',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail, 'titles' => $customerTitles)) }}
     <!-- User Analytics End -->

     @if($verticalId == 1)
      <!-- User Analytics Start-->
    {{ theme()->getView('pages/leads/components/detail/customer_info/business-details',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
    <!-- User Analytics End -->
    @endif

    <!-- connection-address Start-->
    {{ theme()->getView('pages/leads/components/detail/customer_info/connection-address',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'connectionAddress'=>$connectionAddress,'states'=>$states,'unitTypes'=>$unitTypes,'unitTypeCodes'=>$unitTypeCodes,'floorTypeCodes'=>$floorTypeCodes,'streetTypeCodes'=>$streetTypeCodes)) }}
    <!-- connection-address End -->

    <!-- billing-address Start-->
    {{ theme()->getView('pages/leads/components/detail/customer_info/billing-address',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'billingAddress'=>$billingAddress,'states'=>$states,'unitTypes'=>$unitTypes,'unitTypeCodes'=>$unitTypeCodes,'floorTypeCodes'=>$floorTypeCodes,'streetTypeCodes'=>$streetTypeCodes,'connectionAddress'=>$connectionAddress,)) }}
    <!-- billing-address End -->

    @if($verticalId == 2)
    <!-- delivery-address Start-->
    {{ theme()->getView('pages/leads/components/detail/customer_info/delivery-address',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'deliveryAddress'=>$deliveryAddress,'states'=>$states,'unitTypes'=>$unitTypes,'unitTypeCodes'=>$unitTypeCodes,'floorTypeCodes'=>$floorTypeCodes,'streetTypeCodes'=>$streetTypeCodes,'connectionAddress'=>$connectionAddress,)) }}
    <!-- delivery-address End -->
    @endif

    @if($verticalId == 1)
     <!-- PO Box Address Start-->
     {{ theme()->getView('pages/leads/components/detail/customer_info/po-box-address',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'poBoxAddress'=>$poBoxAddress,'states'=>$states)) }}
     <!-- PO Box Address End -->
    @endif
      {{-- <!-- manual connection Address Start-->
      {{ theme()->getView('pages/leads/components/detail/customer_info/manual-connection-address',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'manualConnectionAddress'=>$manualConnectionAddress)) }}
      <!-- manual connection Address End --> --}}

      @if(isset($saleDetail) && isset($gasSaleDetail))
      <!-- Gas connection Address Start-->
      {{ theme()->getView('pages/leads/components/detail/customer_info/gas-connection-address',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'states'=>$states,'gasConnectionAddress'=>$gasConnectionAddress,'unitTypes'=>$unitTypes,'unitTypeCodes'=>$unitTypeCodes,'floorTypeCodes'=>$floorTypeCodes,'streetTypeCodes'=>$streetTypeCodes)) }}
      <!-- Gas connection Address End -->
      @endif

      <!-- note Start-->
        {{ theme()->getView('pages/leads/components/detail/customer_info/note',array('verticalId'=>$verticalId,'gasSaleDetail'=> $gasSaleDetail,'saleDetail'=>$saleDetail)) }}
      <!-- note End -->
    @endif

</div>
