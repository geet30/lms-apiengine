<div class="tab-pane fade" id="addon" role="tab-panel">

    <!-- Included addon Start-->
    {{ theme()->getView('pages/leads/components/detail/addons/included-addons',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
    <!-- Included addon End -->

    <!-- Addon Start-->
    {{ theme()->getView('pages/leads/components/detail/addons/addon',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
    <!-- Addon End -->

    <!-- Connection Details Start-->
    {{ theme()->getView('pages/leads/components/detail/addons/connection-details',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
    <!-- Connection Details End -->

    <!-- Installation Details Start-->
    {{ theme()->getView('pages/leads/components/detail/addons/installation-details',array('verticalId'=>$verticalId,'saleDetail'=>$saleDetail)) }}
    <!-- Installation Details End -->
 

</div>
