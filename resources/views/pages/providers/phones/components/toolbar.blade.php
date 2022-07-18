<!--begin::Card header-->
<div class="card-header py-0 gap-2 gap-md-5 px-0">
	<!--begin::Card title-->
	<div class="card-title"></div>
	<!--begin::Card title-->
		<!--begin::Card toolbar-->
		<div class="card-toolbar">
			<!--begin::Toolbar-->
			<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
				<!--begin::Filter-->

				<button type="button" class="btn btn-light-primary filter_leads collapsible collapsed me-3" data-bs-toggle="collapse" data-bs-target="#filter_leads">
				<!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
				<span class="svg-icon svg-icon-2">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
					</svg>
				</span>
				<!--end::Svg Icon-->
				{{__('plans/mobile.filter')}}</button>


			</div>
		</div>
	</div>
	<!--end::Card toolbar-->

	<form name="filter_handsets" id="filter_leads" class="collapse" action="" method="post">
		@csrf
		<div class="card-header align-items-center py-5 gap-2 gap-md-5">
			<div class="input-group w-250px">
				<input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="handset_name" placeholder="{{__('plans/mobile.phone_name.placeholder')}}" value="{{isset($filterVars['handset_name'])?$filterVars['handset_name']:''}}"/>
			</div>

			<div class="input-group w-250px">
				<select name="brand" aria-label="{{__('plans/mobile.brands_filter.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/mobile.brands_filter.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg">
					<option value=""></option>
					 @foreach($brands as $brand)
					 	<option value="{{$brand->id}}" {{isset($filterVars['brand']) && $filterVars['brand'] == $brand->id?'selected':''}}> {{$brand->title}} </option>
					 @endforeach
				</select>
			</div>
			<div class="input-group w-250px">
				<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" name="status">
					<option value="1" {{isset($filterVars['status']) && $filterVars['status'] == 1?'selected':''}}> Enabled </option>
					<option value="0" {{isset($filterVars['status']) && $filterVars['status'] == 0?'selected':''}}> Disabled </option>
					<option value="2" {{isset($filterVars['status']) && $filterVars['status'] == 2?'selected':''}}> All </option>
				</select>
			</div>
			<div class="align-items-center py-5 gap-2 gap-md-5 w-100">
				<div class="input-group w-500px">
					<div class="d-flex justify-content-end">
						<a class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset" href="">{{__('plans/mobile.reset')}}</a>
						<button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter" id="apply_lead_filters">{{__('plans/mobile.apply_filter')}}</button>
					</div>
			</div>
		</div>
	</form>
</div>
