<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="pt-0 table-responsive">
    <input type="hidden" id="currentURL" value="{{ $currentURL }}">
    <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="state_holiday_table">
        <thead>
           <tr class="fw-bolder fs-7 text-gray-800 px-7">
                <th class="text-capitalize text-nowrap">Sr.No.</th>
                <th class="text-capitalize text-nowrap">Day</th>
                <th class="text-capitalize text-nowrap">Title</th>
                <th class="text-capitalize text-nowrap">Description</th>
                <th class="text-capitalize text-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody class="fw-bold text-gray-600" id="state_list_table">

        </tbody>
    </table>
</div>
@section('styles')
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/custom/js/breadcrumbs.js"></script>
<script src="/custom/js/calender.js"></script>


<script>

    $('#back_button').attr("href", '{{url("settings/holiday-calendar")}}');
    KTMenu.createInstances();
    const breadArray = [{
			title: 'Dashboard',
			link: '/',
			active: false
		},
		{
			title: 'Holiday Calendar',
			link: "{{url('settings/holiday-calendar')}}",
			active: false
		},
		{
			title: 'State Holidays',
			link: '#',
			active: true
		},
	];
	const breadInstance = new BreadCrumbs(breadArray);
	breadInstance.init();
</script>
@endsection
