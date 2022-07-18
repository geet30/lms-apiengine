<!--begin::Card header-->
<div class="card-header py-0 gap-2 gap-md-5 px-5 border-0">
    <!--begin::Card title-->
    <!--begin::Card toolbar-->
    <div class="card-title">
        <!--begin::Toolbar-->
        <form name="connection_form" id="connection_graph_toolbar">
            <div class="p-5" data-kt-customer-table-toolbar="base">
                <div class="row mt-5 mb-5 d-block">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                        <div class="d-flex align-items-center mt-3">
                            <div class="input-group w-300px" style="margin-right: 1rem;">
                                <select data-placeholder="Service" class="form-select form-select-solid "
                                    data-control="select2" data-hide-search="true" name="serviceId"
                                    id="connection_service_id">
                                    <option></option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ $service->id == 2 ? 'selected' : '' }}>
                                            {{ $service->service_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                <input class="form-check-input check_connection_retailer_affiliate"
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
                            <button class="btn btn-primary" id="connection_graph_apply_button">Apply</button>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                        <!--begin::Options-->
                        <div class="d-flex align-items-center mt-3">
                    <div class="input-group w-300px {{ $chartType }}_affiliate_section">
                        <select data-placeholder="Affiliates" class="form-select form-select-solid"
                            id="connection_affiliate_id" data-control="select2" data-hide-search="true"
                            name="affiliates[]" multiple>
                            <option></option>
                        </select>
                    </div>

                    <div class="input-group w-300px {{ $chartType }}_affiliate_section">
                        <select data-placeholder="Sub Affiliates" class="form-select form-select-solid"
                            id="connection_sub_affiliate_id" data-control="select2" data-hide-search="true"
                            name="sub_affiliates[]" multiple>
                            <option></option>
                        </select>
                    </div>

                    <div class="input-group d-none w-300px {{ $chartType }}_provider_section">
                        <select data-placeholder="Providers" class="form-select form-select-solid"
                            id="connection_provider_id" data-control="select2" data-hide-search="true"
                            name="providers[]" multiple>
                            <option></option>
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
