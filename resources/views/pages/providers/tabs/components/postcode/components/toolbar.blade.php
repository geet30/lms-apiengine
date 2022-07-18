<div class="postcode_toolbar row my-1 px-8 py-2">
    <div class="col-md-6 d-flex align-items-center">
        <h3 class="fw-bolder m-0">Post Codes</h3>
    </div>
    <div class="col-md-6 d-flex justify-content-end py-1 py-md-0">
        <div class="col-md-6 energy_type my-1 my-md-0 me-3">
            <select id="energy_type" class="form-control form-control-solid form-select select2-hidden-accessible" name="postcode_energy_type" data-placeholder="Select energy type" data-control="select2" data-select2-id="select2-data-postcode_energy_type" tabindex="-1" aria-hidden="true">
                <option value=""></option>
                <option value="1">Electricity</option>
                <option value="2">Gas</option>
                <option value="3">LPG</option>
            </select>
            <span class="errors text-danger"></span>
        </div>
        <div class="col-md-6 distributors my-1 my-md-0">
            <select id="distributor_id" class="form-control form-control-solid form-select select2-hidden-accessible" data-control="select2" tabindex="-1" aria-hidden="true" name="postcode_distributor" data-select2-id="select2-data-postcode_distributor" data-placeholder="Select distributor" data-allow-clear="true">
                <option value=""></option>
            </select>
            <span class="errors text-danger"></span>
        </div>
    </div>
</div>
