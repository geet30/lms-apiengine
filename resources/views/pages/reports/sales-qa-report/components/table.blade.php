<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="d-flex flex-column gap-7 gap-lg-10">
    <div class="card card-flush py-0">
        <div class="card-body px-0 pt-0">
            <div class="tab-pane fade show active" id="name_dialler_ignore" role="tab-panel">
                <div class="pt-0 table-responsive">
                    <table class="table border table-hover table-row-dashed align-middle mx-0 fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="tags_table1">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
                                <th class="text-capitalize text-nowrap">Sr.No.</th>
                                <th class="text-capitalize text-nowrap">Sale ID</th>
                                <th class="text-capitalize text-nowrap">Ref. No.</th>
                                <th class="text-capitalize text-nowrap">IP Address</th>
                                <th class="text-capitalize text-nowrap">Action</th>
                                <th class="text-capitalize text-nowrap">Assigned QA/Collaborator</th>
                                <th class="text-capitalize text-nowrap">Action performed by </th>
                                <th class="text-capitalize text-nowrap">Comments</th>
                                <th class="text-capitalize text-nowrap">Created date & time</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600" class="sales_qa_table_body" id="tag_body_1">
                            <?php $inc = 1; ?>
                            @foreach($data as $key => $val)
                            <tr>
                                <td>{{ $inc }}</td>
                                <td>{{ $val['lead_id'] }}</td>
                                <td>{{ $val['reference_no'] }}</td>
                                <td>{{ $val['ip'] }}</td>
                                <td>{{actionSalesQaLogs($val['action'])}}</td>
                                <td>{{ isset($val['qa_name']) ? $val['qa_name'] : "N/A" }}</td>
                                <td>{{ isset($val['collaborator_name']) ? $val['collaborator_name'] : "N/A"}}</td>
                                <td>{{ $val['Comment'] }}</td>
                                <td>{{ $val['created_at']}}</td>
                            </tr>
                            <?php $inc++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
@section('styles')
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
@include('pages.reports.sales-qa-report.components.js');
<script>
    KTMenu.createInstances();
    let dataTable = $("#tags_table1").DataTable({
        pageLength: 50,
        responsive: false,
        searching: true,
        "sDom": "tipr",
    });
</script>
@endsection