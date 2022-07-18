<div class="tab-pane fade" id="fees" role="tab-panel">
    {{ theme()->getView('pages/plans/common/fee',['plan' => $plan ,'costTypes' => $costTypes ,'feeTypes' => $feeTypes ,'cancelButtonUrl' => $cancelButtonUrl, 'serviceType' => '2']) }}
</div>