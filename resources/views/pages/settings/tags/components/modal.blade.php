<div class="modal fade" id="addtagmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white modal-title">Add Tag</h2>
                <div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">
                <form role="form" name="add_update_tag_form" id="add_update_tag_form">
                    @csrf
                    <input type="hidden" name="tagId" value="">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Tag Title</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid"
                                placeholder="Enter Tag Title" />
                            <span class="error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Tag Highlight</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox" name="isHighlighted"
                                    value="1" checked />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Top On The List</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox" name="isTopOfList"
                                    value="1" checked />
                                <select name="rank"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">One In A State</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox" name="isOneInState"
                                    value="1" checked />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6 for-all-tr">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">For All Affiliate Set Role As</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox" name="setForAll"
                                    value="1" checked />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6  for-all-plans">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Assign This Tag To All Plans</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox" name="setForAllPlans"
                                    value="1" checked />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a class="btn btn-light btn-active-light-primary me-2" href=""
                            data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="submit_button" id="submit_tagData"
                            class="btn btn-primary save">@include('partials.general._button-indicator', ['label' => __('buttons.save')])</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
