<div class="modal fade" id="state_holiday_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white state_holiday_title"></h2>
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
                <form role="form" name="add_state_holiday" id="add_state_holiday" method="post">
                    @csrf
					<input type="hidden" name="move_in_calender_id" id="move_in_calender_id" value="">
					<div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6 required">Select Day</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
							<input type="text" name="date" id="date" class="form-control form-control-lg form-control-solid date" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6 required">Select State</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
							<select class="form-control form-control-solid form-select" id="state" name="state">
								<option value="">Select State</option>
								<option value="ACT">ACT</option>
								<option value="NSW">NSW</option>
								<option value="NT">NT</option>
								<option value="QLD">QLD</option>
								<option value="SA">SA</option>
								<option value="TAS">TAS</option>
								<option value="VIC">VIC</option>
								<option value="WA">WA</option>
							</select>
                            <span class="error" style="color: red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6 required">Holiday Title</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
							<input type="text" name="holiday_title" id="holiday_title" class="form-control form-control-lg form-control-solid" placeholder="e.g. Good Friday" value="" />
                            <span class="error" style="color: red;"></span>
                            

                            </div>
                        </div>
                    </div>
                   
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6 required">Description</label>
                        <div class="col-lg-8 fv-row">
                            <div class="form-check form-check-solid form-switch fv-row">
							<textarea name="holiday_content" id="holiday_content" class="form-control form-control-lg form-control-solid"  placeholder="e.g. This is Good Friday" rows = "4", cols = "40"></textarea>
                            <span class="error" style="color: red;"></span>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a class="btn btn-light btn-active-light-primary me-2" href="" data-bs-dismiss="modal">Cancel</a>
                <button type="button" class="submit_button" class="btn btn-primary state_holiday_submit_btn"></button>
            </div>
        </div>

        </form>
    </div>
</div>
