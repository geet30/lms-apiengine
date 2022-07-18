<div class="tab-pane fade" id="identification" role="tab-panel">
    <!--begin::Content-->

     <!-- Identification details Start-->
     {{ theme()->getView('pages/leads/components/detail/identification/identification-detail',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'identificationDetails'=> $identificationDetails,'states'=> $states ,'countriesData'=>$countriesData, 'identificationTypes' => $identificationTypes,'cardColors'=>$cardColors,'referenceNumbers'=>$referenceNumbers)) }}
     <!-- Identification details End -->

        <!-- Identification Documents Start-->
        {{ theme()->getView('pages/leads/components/detail/identification/identification-document',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'visitorDocuments'=>$visitorDocuments)) }}
        <!-- Identifucation Documents End -->

        <!-- Customer Documents Start-->
        {{ theme()->getView('pages/leads/components/detail/identification/customer-document',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
        <!-- Customer Documents End -->

        @if ($verticalId == 1)
            <!-- customer-consent-acceptance Start-->
        {{ theme()->getView('pages/leads/components/detail/identification/customer-consent-acceptance',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail,'checkboxStatuses'=>$checkboxStatuses)) }}
        <!-- customer-consent-acceptance End -->
        @endif


</div>
