<div class="modal fade" id="distributor_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="distributor_form" class="form">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Add Distributor</h2>
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
                    <input type="hidden" name="distributor_id" value="">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label required" for="distributor_name">Distributor Name</label>
                                <input type="text" min="0.00" step="0.01" id="distributor_name" autocomplete="off" name="distributor_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="e.g. Essential Energy" value=""/>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12 my-3">
                                <label class="form-label required">Energy Type</label>
                                <div>
                                    <label class="form-check form-check-inline form-check-solid me-5">
                                        <input class="form-check-input radio-w-h-18 energy_type" id="energy_type_electricity" name="energy_type" type="radio" value="1" checked/>
                                        <span class=" fw-bold ps-2 fs-6">
                                            Electricity
                                        </span>
                                    </label>
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input class="form-check-input radio-w-h-18" id="energy_type_gas" name="energy_type" type="radio" value="2"/>
                                        <span class="fw-bold ps-2 fs-6">
                                            Gas
                                        </span>
                                    </label>
                                    <label class="form-check form-check-inline form-check-solid">
                                        <input class="form-check-input radio-w-h-18" id="energy_type_lpg" name="energy_type" type="radio" value="3"/>
                                        <span class="fw-bold ps-2 fs-6">
                                            LPG
                                        </span>
                                    </label>
                                </div>
                                <span class="text-danger errors text-center"></span>
                            </div>
                        </div>

                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <label class="form-label" for="post_codes">Post Codes</label>
                                <input type="text" id="post_codes" autocomplete="off" name="post_codes" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="e.g. 1234" value=""/>
                                <span class="text-danger errors"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-right">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
                    <button id="remove_all_postcodes" class="btn btn-light me-3">Clear All Postcodes</button>
                    <button type="button" id="distributor_form_submit_btn" class="btn btn-primary" data-form="distributor_form">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="import_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="import_form" class="import_form" enctype="multipart/form-data">
                <div class="modal-header" id="kt_modal_assigned_user_header">
                    <h2 class="fw-bolder title">Import Post Codes</h2>
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
                        <input type="hidden" name="distributor_id" value="">
                        <div class="row mb-4 field-holder">
                            <div class="col-12">
                                <div class="from-group">
                                    {!! Form::file('file', ['class'=>'form-control', 'name'=>'file' , 'id' => 'file']) !!}
                                    <span class="text-danger errors"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fs-8">
                        <span class="fw-bold">Note:</span> Previous assigned post code for this Distributor get deleted, if there is any.
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
                    <button type="button" id="import_form_submit_btn" class="btn btn-primary" data-form="import_form">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
