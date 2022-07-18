<!--begin::Card header-->
<div class="card-header border-0 pt-6 mb-4">
	<!--begin::Card title-->
	<div class="card-title">
		<!--begin::Search-->
		<div class="d-flex align-items-center position-relative my-1">
			<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->

			<!--end::Svg Icon-->
		</div>
		<!--end::Search-->
	</div>
	<!--begin::Card title-->
	<!--begin::Card toolbar-->
	<div class="card-toolbar">
		<!--begin::Toolbar-->
		<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

			<!--begin::Trigger-->
			<button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
				Send Email/SMS
				<!-- <span class="svg-icon svg-icon-5 rotate-180 ms-3 me-0">...</span> -->
			</button>
			<!--end::Trigger-->

			<!--begin::Menu-->
			<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3">
						Send Email
					</a>
				</div>
				<!--end::Menu item-->

				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3">
						Send SMS
					</a>
				</div>
				<!--end::Menu item-->

				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3">
						Check Histroy
					</a>
				</div>
				<!--end::Menu item-->

			</div>
			<!--end::Menu-->
			<!--begin::Export-->
			<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">View Sale Update Histroy</button>
			<!--end::Export-->

			<!--begin::Export-->
			<button type="button" class="btn btn-light-danger me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">Delete Sale</button>
			<!--end::Export-->


			<!--begin::Add Leads-->
			<button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">Resend Welcome Email</button>
			<!--end::Add Leads-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Group actions-->
		<div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
			<div class="fw-bolder me-5">
				<span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
			</div>
			<button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
		</div>
		<!--end::Group actions-->
	</div>
	<!--end::Card toolbar-->
</div>