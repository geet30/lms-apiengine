<div class="tab-pane fade" id="plan_fees" role="tab-panel">
    {{ theme()->getView('pages/plans/common/fee',['plan' => $plan ,'costTypes' => $costTypes ,'feeTypes' => $feeTypes ,'cancelButtonUrl' => $cancelButtonUrl, 'serviceType' => '3']) }}
</div>