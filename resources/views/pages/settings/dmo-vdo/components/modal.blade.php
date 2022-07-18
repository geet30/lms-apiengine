<div class="modal fade" id="dmo_vdo_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="dmo_vdo_form" class="form">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Add DMO VDO</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="modal-body py-10 px-lg-17">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-4 field-holder">
                                    <div class="col-12">
                                        <label class="form-label required">Distributor</label>
                                        <select id="distributor" name="distributor" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Select option" data-dropdown-parent="#dmo_vdo_modal" data-allow-clear="true" data-select2-id="select2-data-distributor" aria-hidden="true">
                                            <option></option>
                                            @foreach($distributors as $distributor)
                                                <option value="{{$distributor->id}}">{{$distributor->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger errors"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row mb-4 field-holder">
                                    <div class="col-12">
                                        <label class="form-label required">Property type</label>
                                        <select id="property_type" name="property_type" class="form-select form-select-solid select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#dmo_vdo_modal" data-allow-clear="true" data-select2-id="select2-data-property_type" tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            <option value="1">Residential</option>
                                            <option value="2">Business</option>
                                        </select>
                                        <span class="text-danger errors"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-4 field-holder">
                                    <div class="col-12">
                                        <label class="form-label required">Tariff type</label>
                                        <select id="tariff_type" name="tariff_type" class="form-select form-select-solid select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#dmo_vdo_modal" data-allow-clear="true" data-select2-id="select2-data-tariff_type" tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            @foreach($tariff_types as $tariff_type)
                                                <option value="{{$tariff_type->id}}">{{$tariff_type->tariff_types}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger errors"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row mb-4 field-holder">
                                    <div class="col-12">
                                        <label class="form-label required">Tariff Name</label>
                                        <input type="text" id="tariff_name" autocomplete="off" name="tariff_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Tariff Name" value=""/>
                                        <span class="text-danger errors"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-4 field-holder">
                                    <div class="col-12">
                                        <label class="form-label required">Offer type</label>
                                        <select id="offer_type" name="offer_type" class="form-select form-select-solid select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#dmo_vdo_modal" data-allow-clear="true" data-select2-id="select2-data-offer_type" tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            <option value="1">DMO</option>
                                            <option value="2">VDO</option>
                                        </select>
                                        <span class="text-danger errors"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row mb-4 field-holder">
                                    <div class="col-12">
                                        <label class="form-label required">DMO/VDO annual Price</label>
                                        <input type="number" min="0.00" step="0.01" id="annual_price" autocomplete="off" name="annual_price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="DMO/VDO annual Price" value=""/>
                                        <span class="text-danger errors"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Peak Usage Only</label>
                                <input type="number" min="0.00" step="0.01" id="peak_only" autocomplete="off" name="peak_only" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Peak Usage Only" value=""/>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-12 pt-md-0 pt-3 pb-0 mx-auto">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Peak-Offpeak Usage</div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-lg-6 fv-row mb-3 mb-lg-0">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Peak" id="peak_offpeak_peak" name="peak_offpeak_peak" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                            <div class="col-lg-6 fv-row">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Off-Peak" id="peak_offpeak_offpeak" name="peak_offpeak_offpeak" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-12 pt-md-0 pt-3 pb-0 mx-auto">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Peak-Offpeak Shoulder</div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-lg-4 fv-row mb-3 mb-lg-0">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Peak" id="peak_shoulder_peak" name="peak_shoulder_peak" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                            <div class="col-lg-4 fv-row mb-3 mb-lg-0">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Off-Peak" id="peak_shoulder_offpeak" name="peak_shoulder_offpeak" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                            <div class="col-lg-4 fv-row">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Shoulder" id="peak_shoulder_shoulder" name="peak_shoulder_shoulder" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-12 pt-md-0 pt-3 pb-0 mx-auto">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Peak-Offpeak Shoulder 1 & 2</div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-lg-6 fv-row mb-3" mb-lg-0>
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Peak" id="peak_shoulder_1_2_peak" name="peak_shoulder_1_2_peak" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                            <div class="col-lg-6 fv-row mb-3 mb-lg-0">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Off-Peak" id="peak_shoulder_1_2_offpeak" name="peak_shoulder_1_2_offpeak" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                            <div class="col-lg-6 fv-row mb-3 mb-lg-0">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Shoulder 1" id="peak_shoulder_1_2_shoulder_1" name="peak_shoulder_1_2_shoulder_1" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                            <div class="col-lg-6 fv-row">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Shoulder 2" id="peak_shoulder_1_2_shoulder_2" name="peak_shoulder_1_2_shoulder_2" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-6 pt-md-0 pt-3 pb-0 mx-auto">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Control Load 1 only</div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-lg-12 fv-row">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Control load 1 only" id="control_load_1" name="control_load_1" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pt-md-0 pt-3 pb-0 mx-auto">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Control Load 2 only</div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-lg-12 fv-row">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Control load 2 only" id="control_load_2" name="control_load_2" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-12 pt-md-0 pt-3 pb-0 mx-auto">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Control Load 1 & 2</div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-lg-6 fv-row mb-3 mb-lg-0">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Control load 1" id="control_load_1_2_1" name="control_load_1_2_1" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                            <div class="col-lg-6 fv-row mb-3 mb-lg-0">
                                                <input type="number" min="0.00" step="0.01" class="form-control form-control-solid" placeholder="Control load 2" id="control_load_1_2_2" name="control_load_1_2_2" tabindex="6" value="">
                                                <span class="text-danger errors"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required">Total Usage</label>
                                <input type="number" min="0.00" step="0.01" id="annual_usage" name="annual_usage" autocomplete="off" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Total Usage" value=""/>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.tnc.modalCancelButton')}}</button>
                    <button type="button" id="dmo_vdo_form_submit_btn" class="btn btn-primary" data-form="dmo_vdo_form">
                        {{ __ ('mobile.formPage.tnc.modalSubmitButton')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="states_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog mw-550px">
        <div class="modal-content">
            <form id="states_form" class="form">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">DMO State</h2>
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
                        <div class="row field-holder">
                            <div class="col-12">
                                <label class="form-label required">States</label>
                                <select id="states" name="states[]" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Select" data-dropdown-parent="#states_modal" data-select2-id="select2-data-states" aria-hidden="true" multiple>
                                    <option></option>
                                    @foreach($states as $state)
                                        <option value="{{$state->state_id}}" {{in_array($state->state_id, $dmo_states) ? 'selected' : ''}}>{{$state->state_code}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __ ('mobile.formPage.tnc.modalCancelButton')}}</button>
                    <button type="button" id="states_form_submit_btn" class="btn btn-primary" data-form="states_form">
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
                    <h2 class="fw-bolder title">Upload Price List</h2>
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
                        <div class="row field-holder">
                            <div class="col-12">
                                <div class="from-group">
                                    {!! Form::file('file', ['class'=>'form-control', 'name'=>'file' , 'id' => 'file']) !!}
                                    <span class="text-danger errors"></span>
                                </div>
                            </div>
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
