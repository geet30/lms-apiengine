<div class="tab-pane fade" id="plan_info" role="tab-panel">

    @if ($verticalId == '1')
        <!-- NMI Numbers Start-->
        {{ theme()->getView('pages/leads/components/detail/plan_info/nmi-number', ['verticalId' => $verticalId, 'saleDetail' => $saleDetail, 'gasSaleDetail' => $gasSaleDetail]) }}
        <!-- NMI Numbers End -->
    @endif
    <!-- plan-info Start-->
    {{ theme()->getView('pages/leads/components/detail/plan_info/plan-info', ['verticalId' => $verticalId, 'saleDetail' => $saleDetail, 'contract' => $contractData, 'providers' => $providers]) }}
    <!-- plan-info End -->

    @if ($verticalId == 2)
        @if (isset($connectionDetails))
            <!-- Connection Details Start-->
            {{ theme()->getView('pages/leads/components/detail/plan_info/connection-details', ['verticalId' => $verticalId, 'saleDetail' => $saleDetail,'connectionDetails'=>$connectionDetails]) }}
        @endif

        <!-- Plan Fees Start-->
        {{ theme()->getView('pages/leads/components/detail/addons/plan-fees', ['verticalId' => $verticalId, 'saleDetail' => $saleDetail, 'costType' => $costType, 'contract' => $contractData]) }}
        <!-- Plan Fees End -->

        @if ($saleDetail->journey_plan_type == 2)
            <!-- handset-info Start-->
            {{ theme()->getView('pages/leads/components/detail/plan_info/handset-info', ['verticalId' => $verticalId, 'saleDetail' => $saleDetail, 'handsetData' => $handsetData, 'contract' => $contractData]) }}
            <!-- handset-info End -->
        @endif
    @endif

    <!-- employment-info Start-->
    {{ theme()->getView('pages/leads/components/detail/plan_info/employment-details', ['verticalId' => $verticalId, 'saleDetail' => $saleDetail, 'employmentDetails' => $employmentDetails, 'masterEmploymentDetails' => $masterEmploymentDetails]) }}
    <!-- employment-info End -->
</div>
