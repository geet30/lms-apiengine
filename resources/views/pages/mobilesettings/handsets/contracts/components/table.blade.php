<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="card-body pt-0 table-responsive " id="">
    <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="contract_table">
        <thead>
            <tr class="fw-bolder fs-7 text-gray-800 px-7">
                <th class="text-capitalize w-5 text-nowrap">Sr.No</th>
                <th class="text-capitalize w-40 text-nowrap">Contract Name</th>
                <th class="text-capitalize w-30 text-nowrap">Validity in Months</th>
				<th class="text-capitalize w-15">Status</th>
                <th class="text-capitalize w-10">Actions</th>
            </tr>
        </thead>
		@include('pages.mobilesettings.handsets.contracts.components.filtertable')

    </table>
</div>

@section('scripts')
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/custom/js/breadcrumbs.js"></script>
<script>
 	$('#back_button').attr("href", '{{url("/")}}');

    const breadArray = [{
			title: 'Dashboard',
			link: '/',
			active: false
		},
		{
			title: 'Handsets',
			link: "#",
			active: false
		},
	];

	const breadInstance = new BreadCrumbs(breadArray);
	breadInstance.init();

</script>
@endsection
