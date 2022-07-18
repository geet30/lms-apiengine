<div class="modal fade" id="master_tariff_codes_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="master_tariff_codes_form" class="form">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Add Master Tariff Code</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Tariff Code</label>
                                <input type="text" min="0.00" step="0.01" id="tariff_code" autocomplete="off" name="tariff_code" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter tariff code" value=""/>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Tariff Type</label>
                                <select id="tariff_type" name="tariff_type" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Select" data-dropdown-parent="#master_tariff_codes_modal" data-allow-clear="true" data-select2-id="select2-data-tariff_type" aria-hidden="true">
                                    <option></option>
                                    <option value="Demand">Demand</option>
                                </select>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Property Type</label>
                                <select id="property_type" name="property_type" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Select" data-dropdown-parent="#master_tariff_codes_modal" data-allow-clear="true" data-select2-id="select2-data-property_type" aria-hidden="true">
                                    <option></option>
                                    <option value="1">Residential</option>
                                    <option value="2">Business</option>
                                </select>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Distributor</label>
                                <select id="distributor" name="distributor" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Select" data-dropdown-parent="#master_tariff_codes_modal" data-allow-clear="true" data-select2-id="select2-data-distributor" aria-hidden="true">
                                    <option></option>
                                    @foreach($distributors as $distributor)
                                        <option value="{{$distributor->id}}">{{$distributor->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Units Type</label>
                                <select id="units_type" name="units_type" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Select" data-dropdown-parent="#master_tariff_codes_modal" data-allow-clear="true" data-select2-id="select2-data-units_type" aria-hidden="true">
                                    <option></option>
                                    <option value="1">kVA</option>
                                    <option value="2">kWh</option>
                                </select>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Status</label>
                            </div>
                            <div class="col-12 text-center" id="status">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" id="master_tariff_status_enabled" name="status" type="radio" value="1"/>
                                    <span class=" fw-bold ps-2 fs-6">
                                        Enabled
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input radio-w-h-18" id="master_tariff_status_disabled" name="status" type="radio" value="0"/>
                                    <span class="fw-bold ps-2 fs-6">
                                        Disabled
                                    </span>
                                </label>
                            </div>
                            <span class="text-danger errors text-center"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.tnc.modalCancelButton')}}</button>
                    <button type="button" id="master_tariff_codes_form_submit_btn" class="btn btn-primary" data-form="master_tariff_codes_form">
                        {{ __ ('mobile.formPage.tnc.modalSubmitButton')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="import_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="import_form" class="form" enctype="multipart/form-data">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Import Tariff Code</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <div class="from-group">
                                    {!! Form::file('file', ['class'=>'form-control', 'name'=>'file' , 'id' => 'file']) !!}
                                    <span class="text-danger errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Select Method</label>
                            </div>
                            <div class="col-12" id="method">
                                <label class="form-check form-check-inline form-check-solid me-5 mb-4">
                                    <input class="form-check-input radio-w-h-18" id="replace_all" name="method" type="radio" value="replace_all"/>
                                    <span class=" fw-bold ps-2 fs-6">
                                        Replace all data
                                    </span>
                                </label>

                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input radio-w-h-18" id="keep_existing" name="method" type="radio" value="replace_existing"/>
                                    <span class="fw-bold ps-2 fs-6">
                                        Add new records and keep existings
                                    </span>
                                </label>
                            </div>
                            <span class="text-danger errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.tnc.modalCancelButton')}}</button>
                    <button type="button" id="import_form_submit_btn" class="btn btn-primary" data-form="import_form">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
