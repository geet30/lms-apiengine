<!--begin::Card header-->
<div class="card-header py-0 gap-2 gap-md-5 px-5 border-0">
    <!--begin::Card title-->
    <!--begin::Card toolbar-->
    <div class="card-title">
        <!--begin::Toolbar-->
        <div class="p-5" data-kt-customer-table-toolbar="base">
            <div class="row d-block">
                <div class="col-lg-12 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                    <!--begin::Options-->
                    <div class="d-flex align-items-center mt-3">
                        <div class="input-group w-300px" style="margin-right: 1rem;">
                            <select name="services[]" data-control="select2" data-placeholder="Service Type"
                                class="form-select form-select-solid form-select-lg statistics_service_type">
                                @if (isset($services))
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            @if ($service->id == 2) selected @endif>
                                            {{ $service->service_title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                            <input class="form-check-input check_retailer_affiliate"
                                name="{{ $chartType }}_retailer_affiliate" data-id="{{ $chartType }}" type="radio"
                                value="1">
                            <span class="fw-bold ps-2 fs-6">Affiliates</span>
                        </label>
                        <!--end::Option-->
                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid is-valid">
                            <input class="form-check-input check_retailer_affiliate"
                                name="{{ $chartType }}_retailer_affiliate" data-id="{{ $chartType }}" type="radio"
                                value="2">
                            <span class="fw-bold ps-2 fs-6">Retailers</span>
                        </label>
                        <!--end::Option-->
                        <button type="submit" class="btn btn-primary {{ $chartType }}_affiliate_filters"
                            id="apply_affiliate_filters">Apply</button>
                    </div>
                    <!--end::Options-->
                    <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>
            </div>

            <div class="row mt-5 d-none affiliate_section" id="{{ $chartType }}_affiliate_section">
                <div class="input-group w-300px">
                    <select data-placeholder="Affiliates"
                        class="form-select form-select-solid {{ $chartType }}_affiliates" data-control="select2"
                        id="{{ $chartType }}_affiliate_id" data-hide-search="true" name="affiliates" multiple>
                    </select>
                </div>

                <div class="input-group w-300px">
                    <select data-placeholder="Sub Affiliates"
                        class="form-select form-select-solid {{ $chartType }}_sub_affiliates" data-control="select2"
                        id="{{ $chartType }}_sub_affiliate_id" data-hide-search="true" name="sub_affiliates[]"
                        multiple>

                    </select>
                </div>
            </div>

            <div class="row mt-5 d-none provider_section" id="{{ $chartType }}_provider_section">
                <div class="input-group w-300px">
                    <select data-placeholder="Providers" id="{{ $chartType }}_provider_id"
                        class="form-select form-select-solid {{ $chartType }}_providers" data-control="select2"
                        data-hide-search="true" name="provider[]" multiple>

                    </select>
                </div>
            </div>
        </div>

    <!--end::Card toolbar-->
    </div>
</div>
