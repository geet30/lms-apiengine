								<!--begin::Card header-->
								<div class="card-header py-0 gap-2 gap-md-5 px-0 border-0">

										<!--begin::Card title-->
										<div class="card-title">
											<div class="input-group w-250px">
												<select data-placeholder="Vertical" class="form-select form-select-solid vertical_id_field" data-control="select2" data-hide-search="true" id="vertical_id_field" name="verticalId">
											
													@foreach($userServices as $service)
														<option value="{{$service->service_id }}">{{$service->serviceName->service_title }}</option>
													@endforeach
													 
												</select>
											</div>
										</div>
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
												<!--end::Svg Icon-->Filter</button>

												@if($saleType == 'leads')
													<!--begin::Export-->
													<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#leads_export_modal">
													<!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black" />
															<path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black" />
															<path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4" />
														</svg>
													</span>

													<!--end::Svg Icon-->Export</button>
												@endif
												@if($saleType == 'sales')
													<!--begin::Export-->
													<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#sales_export_modal">
													<!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black" />
															<path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black" />
															<path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4" />
														</svg>
													</span>

													<!--end::Svg Icon-->Export</button>

													@if(checkPermission('sale_assign_qa_section',$userPermissions,$appPermissions) && (checkPermission('sale_assign_qa_to_sale',$userPermissions,$appPermissions) || checkPermission('sale_assign_collaborator_to_sale',$userPermissions,$appPermissions)))
														<button type="button" class="btn btn-light-primary me-3" id="assign-qa">
														<!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black"></path>
															<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black"></rect>
														</svg>
														</span>
														<!--end::Svg Icon-->Assign QA</button>
													@endif
												@endif


												<button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset"  id="reset_lead_filters">Reset</button>
												<button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter" id="apply_lead_filters">Apply</button>

												<!--end::Export-->
											</div>
											<!--end::Toolbar-->
											<!--begin::Group actions-->
											<div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
												<div class="fw-bolder me-5">
													<span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
													<button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
												</div>
											</div>
											<!--end::Group actions-->
										</div>
										<!--end::Card toolbar-->

										<form name="filter_leads" id="filter_leads" class="collapse">
											<div class="card-header align-items-center py-5 gap-2 gap-md-5 px-0">
												<input name="saleType" id="saleTypeId" type="hidden" value="{{$saleType}}">
												@if($saleType == 'sales' || $saleType == 'leads')
												<div class="input-group w-250px">
													<input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="first_name" placeholder="First Name" />
												</div>
												<div class="input-group w-250px">
													<input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="last_name" placeholder="Last Name" />
												</div>
												<div class="input-group w-250px">
															<input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="email" placeholder="Email" />
												</div>
												<div class="input-group w-250px">
															<input class="form-control form-control-solid rounded rounded-end-0 input" type="number" name="phone" placeholder="Phone no" />
												</div>
												<div class="input-group w-250px">
															<input class="form-control form-control-solid rounded rounded-end-0 input" type="number" name="leadId" name="leadId" id="searchLeadId" placeholder="Lead Id"/>
												</div>
                                                @endif
												@if($saleType == 'sales')
													<div class="input-group w-250px">
																<input class="form-control form-control-solid rounded rounded-end-0 input" type="number" name="referenceNo" id="searchReferenceNumber" placeholder="Reference Number"/>
													</div>
												@endif
												<div class="input-group w-250px">
															<input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="ipAddress" placeholder="IP Address" />
												</div>
                                                @if($saleType == 'leads' || $saleType == 'sales')
												<div class="input-group w-250px">
													<input class="form-control form-control-solid rounded rounded-end-0 flatpickr-input" placeholder="Date" id="lead_date_id" name="date">
												</div>
                                                @elseif ($saleType == 'visits')
                                                <div class="input-group w-250px">
													<input class="form-control form-control-solid rounded rounded-end-0 flatpickr-input" placeholder="Date" id="lead_date_id" name="date">
												</div>
                                                @endif
                                                @if($saleType == 'sales' || $saleType == 'leads')
												<div class="input-group w-250px energy">
															<select data-placeholder="Product Type" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" id="productType" name="productType">
																<option></option>
																<option data-id="energy" value="1">Electricty</option>
																<option data-id="energy" value="2">Gas</option>
																<option data-id="energy" value="3">LPG</option>
															</select>
												</div>
                                                @endif
												<div class="input-group w-250px connectionType">
															<select data-placeholder="Connection Type" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" id="connectionType" name="connectionType">
																<option></option>
																@foreach($connectionTypes as $connectionType)
																	@if($connectionType->service_id == 2 && $connectionType->connection_type_id == 1)
																		<option data-id="mobile" value="{{ $connectionType->local_id }}">{{ $connectionType->name }}</option>
																	@elseif(($connectionType->service_id == 3 && $connectionType->connection_type_id == 0) && ($connectionType->connection_type_id == null || $connectionType->connection_type_id == ''))
																		<option data-id="broadband" value="{{$connectionType->local_id}}">{{ $connectionType->name }}</option>
																	@endif
																@endforeach

															</select>
												</div>

												<div class="input-group w-250px mobile">
															<select data-placeholder="Plan Type" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" id="planType" name="planType">
																  <option></option>
																@foreach($connectionTypes as $connectionType)
																	@if($connectionType->service_id == 2 && $connectionType->connection_type_id == 2)
																		<option  value="{{$connectionType->local_id}}">{{ $connectionType->name }}</option>
																	@endif
																@endforeach

															</select>
												</div>
                                                @if($saleType == 'sales' || $saleType == 'leads')
												<div class="input-group w-250px mobile">
															<select data-placeholder="Buy Through" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" name="buyThrough">
																<option></option>
																<option value="1">Own</option>
																<option value="2">Lease</option>
															</select>
												</div>
												<div class="input-group w-250px energy">
															<input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="postcode" placeholder="Post Code" />
												</div>
												<div class="input-group w-250px energy">
															<input class="form-control form-control-solid rounded rounded-end-0 input" type="text" name="suburb" placeholder="Suburb" />
												</div>

												<div class="input-group w-250px energy">
															<select data-placeholder="state" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" name="state">
															<option></option>
																@foreach($states as $state)
																	<option value="{{$state->state_code}}">{{ $state->state_code }}</option>
																@endforeach
															</select>
												</div>
												<div class="input-group w-250px techTypeId" >
                                                    <select data-placeholder="Tech Type" class="form-select form-select-solid" data-control="select2" data-hide-search="true" name="techType">
                                                    </select>
												</div>
                                                @endif
												<div class="input-group w-250px">
															<select data-placeholder="Affiliate" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" id="affiliateId" name="affiliateId">
																<option></option>
																@foreach($affiliates as $affiliate)
																	<option value="{{$affiliate->user_id}}">{{ ucwords($affiliate->company_name) }}</option>
																@endforeach
															</select>
												</div>
												@if(!in_array($userRole,[2,3]))
												<div class="input-group w-250px">
															<select data-placeholder="Sub-Affiliate" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" id="subAffiliateId" name="subAffiliateId">
															<option></option>
																@foreach($subAffiliates as $affiliate)
																	<option value="{{$affiliate->user_id}}">{{ ucwords($affiliate->company_name) }}</option>
																@endforeach
															</select>
												</div>
												@endif
                                                @if($saleType == 'sales' || $saleType == 'leads')
												<div class="input-group w-250px">
															<select data-placeholder="Provider" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" id="providerId" name="providerId">
																<option></option>
																@foreach($providers as $provider)
																	<option value="{{$provider->user_id}}">{{ ucwords($provider->name) }}</option>
																@endforeach
															</select>
												</div>

												<div class="input-group w-250px propertyTypeId energy">
															<select data-placeholder="Property Type" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" id="propertyTypeId" name="propertyType">
																<option></option>
																<option value="1">Residential</option>
																<option value="2">Business</option>
															</select>
												</div>
												<div class="input-group w-250px move_in_div">
															<select data-placeholder="Move-in" class="form-select form-select-solid listing_filters" data-control="select2" data-hide-search="true" name="moveIn" id="moveInId">
																<option></option>
																<option value="1">Yes</option>
																<option value="0">No</option>
															</select>
												</div>
												<div class="input-group w-250px moveInDate">
													<input class="form-control form-control-solid rounded rounded-end-0 flatpickr-input" placeholder="Move-In Date" id="lead_movin_date_id" name="moveInDate">

												</div>

												<div class="input-group w-250px">
													<select data-placeholder="Assigned QA" class="form-select form-select-solid" data-control="select2" data-hide-search="true" name="assigned_qa" id="assigned_qa">
														<option></option>
														@foreach($qaList as $qa)
															<option value="{{$qa->id}}">{{ ucwords(decryptGdprData($qa->first_name)) }} {{ ucwords(decryptGdprData($qa->last_name)) }}</option>
														@endforeach
													</select>
												</div> 
                                                @endif
											</div>
										</form>
