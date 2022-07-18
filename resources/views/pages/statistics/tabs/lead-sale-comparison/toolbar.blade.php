<!--begin::Card header-->
<div class="card-header py-0 gap-2 gap-md-5 px-5 border-0">
    <!--begin::Card title-->
    <!--begin::Card toolbar-->
    <div class="card-title">
        <!--begin::Toolbar-->
        <form name="comparison_form" id="comparison_graph_toolbar">
            <div class="p-5" data-kt-customer-table-toolbar="base">
                <div class="row mt-5 mb-5">
                    <div class="input-group w-300px">
                        <select data-placeholder="Service" class="form-select form-select-solid " data-control="select2"
                            data-hide-search="true" name="serviceId[]" id="comparison_service_id" multiple>
                            <option></option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ $service->id == 2 ? 'selected' : '' }}>
                                    {{ $service->service_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group w-300px">
                        <!--begin::Options-->
                        <div class="d-flex align-items-center mt-3">
                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                <input class="form-check-input check_comparison_retailer_affiliate"
                                    name="{{ $chartType }}_retailer_affiliate" data-id="{{ $chartType }}"
                                    type="radio" checked value="1">
                                <span class="fw-bold ps-2 fs-6">Affiliates</span>
                            </label>
                            <!--end::Option-->
                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid is-valid">
                                <input class="form-check-input check_connection_retailer_affiliate"
                                    name="{{ $chartType }}_retailer_affiliate" data-id="{{ $chartType }}"
                                    type="radio" value="2">
                                <span class="fw-bold ps-2 fs-6">Retailers</span>
                            </label>
                            <!--end::Option-->
                        </div>
                        <!--end::Options-->
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                    <div class="input-group w-300px">
                        <button class="btn btn-primary" id="connection_graph_apply_button">Apply</button>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                        <!--begin::Options-->
                        <div class="d-flex align-items-center mt-3">
                    <div class="input-group w-300px {{ $chartType }}_affiliate_section">
                        <select data-placeholder="Affiliates" class="form-select form-select-solid"
                            id="comparison_affiliate_id" data-control="select2" data-hide-search="true"
                            name="affiliates[]" multiple>
                            <option></option>
                        </select>
                    </div>

                    <div class="input-group w-300px {{ $chartType }}_affiliate_section">
                        <select data-placeholder="Sub Affiliates" class="form-select form-select-solid"
                            id="comparison_sub_affiliate_id" data-control="select2" data-hide-search="true"
                            name="sub_affiliates[]" multiple>
                            <option></option>
                        </select>
                    </div>

                    <div class="input-group d-none w-300px {{ $chartType }}_provider_section">
                        <select data-placeholder="Providers" class="form-select form-select-solid"
                            id="comparison_provider_id" data-control="select2" data-hide-search="true"
                            name="providers[]" multiple>
                            <option></option>
                        </select>
                    </div>


                    <div class="input-group w-300px">
                        <select data-placeholder="Type" class="form-select form-select-solid " data-control="select2" data-hide-search="true"  name="type">
                            <option value="1" selected>Visits, Leads, Net Sales</option>
                            <option value="2">Visits, Leads, Gross Sales</option>
                            <option value="3">Visits, Unique Leads, Net Sales</option>
                            <option value="4">Visits, Unique Leads, Gross Sales</option>
                        </select>
                    </div>
                        </div>
                    </div>
                </div>

                <!--end::Export-->
            </div>
        </form>
        <!--end::Toolbar-->
    </div>
    <!--end::Card toolbar-->
</div>
