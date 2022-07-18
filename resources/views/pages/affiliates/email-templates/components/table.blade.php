<div class="table-responsive px-8">
    <table class="table border table-hover table-hov$info == 'sub-affiliates'er align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="affilate_email_template_table" email_sms_list>
        <thead id="email_sms_list_head">
        </thead>
        <tbody class="text-gray-600" id="email_sms_list_body">
        </tbody>
    </table>
</div>

@section('styles')
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
<script src="/custom/js/breadcrumbs.js"></script>
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/common/plugins/custom/flatpickr/flatpickr.bundle.js"></script>

<script>
    var index_url = "<?php echo url('/affiliates/templates/' . $affiliate_id) ?>";
    var geturl = "<?php echo url("/affiliates/add-template/" . $affiliate_id) ?>";
    var affiliate_name = "<?php echo $affiliateData; ?>";
    // var smsurl = "<?php echo url("/affiliates/templates/add-message-template/" . $affiliate_id) ?>";
</script>
<script src="/custom/js/affiliate-template.js"></script>
@endsection