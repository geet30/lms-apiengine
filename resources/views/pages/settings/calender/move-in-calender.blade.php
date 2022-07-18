<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.css' rel='stylesheet' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
<link rel="stylesheet" href="{{ URL::asset('common/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}"> 
<script type="text/javascript" href="{{ URL::asset('common/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>

<x-base-layout>
<div class="card mb-5 mb-xl-10">
	<input type="hidden" id="currentURL" value="{{ $currentURL }}">
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	{{ theme()->getView('pages/settings/calender/components/modal', array('weekend_content' => $weekend_content,'closing_time'=>$closing_time)) }}
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<!--begin::Container-->
			<div id="kt_content_container" class="container-xxl">
				<!--begin::Card-->
				<div class="card">
					<!--begin::Card header-->
					
					{{ theme()->getView('pages/settings/calender/components/toolbar') }}
					<!--end::Card header-->
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Calendar-->
						<div class="row g-5 gx-xxl-8">
							<div id="kt_docs_fullcalendar_background_events"></div>
						</div>
						<!--end::Calendar-->
					</div>
					<!--end::Card body-->
				</div>
			</div>
		</div>
	</div>
</div>
@section('scripts')
@include('pages.settings.calender.calenderjs')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="/custom/js/breadcrumbs.js"></script>
<script src="/custom/js/calender.js"></script>
<script>
 	$('#back_button').attr("href", '{{url("/")}}');
    var info = '{{$info}}';

	const breadArray = [{
            title: 'Dashboard',
            link: '/',
            active: false
        },
        {
            title: info,
            link: `#`,
            active: false
        },
    ];
    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();
</script>
@endsection


</x-base-layout>