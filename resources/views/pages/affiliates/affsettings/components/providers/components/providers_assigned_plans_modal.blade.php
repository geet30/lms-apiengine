<!-- weekdays title -->
<div class="modal fade" id="providerAssignedPlansModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="providerAssignedPlansForm" name="providerAssignedPlansForm">
                <div class="modal-header bg-primary px-5 py-4">
                    <h2 class="fw-bolder fs-12 text-white titleDisallowPlan">
                        Provider Assigned Plans
                    </h2>
                    <div data-bs-dismiss="modal"
                         class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                  transform="rotate(-45 6 17.3137)" fill="black"/>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                  fill="black"/>
                        </svg>
                    </span>
                    </div>
                </div>
                <div class="modal-body px-5">
                    <input class="affiliate_id" type="hidden" name="affiliate_id" value="">
                    <input class="provider_id" type="hidden" name="provider_id" value="">
                    <div class="row mb-4 field-holder">
                        <div class="col-12">
                            <label class="form-label">Disallow Plans on Frontend</label>
                            <select id="assigned_plans" name="assigned_plans[]" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Select" data-dropdown-parent="#providerAssignedPlansModal" data-allow-clear="true" data-select2-id="select2-data-assigned_plans" aria-hidden="true" multiple>
                            </select>
                            <span class="text-danger errors"></span>
                        </div>
                    </div>
                </div>
                <div class="model-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" id="" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
                    <button type="submit" class="btn btn-primary" id="submit_providers_assigned_plans" data-id="" data-status="">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
