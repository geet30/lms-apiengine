<div class="tab-pane" id="api_response" role="tab-panel">

    <!--begin::Content-->
<!-- API Responses Start-->
{{ theme()->getView('pages/leads/components/detail/api_responses/api-response',array('apiResponses'=>$apiResponses,'saleSubmissionResponse' =>$saleSubmissionResponse,'verticalId' => $verticalId,'tokenExLogs'=>$tokenExLogs,'smsLogs'=>$smsLogs,'sendEmailLogs'=>$sendEmailLogs)) }}
<!-- API Responses End -->
</div>
