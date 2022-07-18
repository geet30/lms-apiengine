<form role="form" name="suburb_filters" id="suburb_filters" class="collapse suburb_filters">
    <div class="row px-8">
        <div class="col-lg-3 my-1">
            <div class="input-group">
                <input class="form-control form-control-solid rounded rounded-end-0 input filter_suburb" type="text" name="filter_suburb" placeholder="Post code" />
            </div>
        </div>
        <div class="col-lg-3 my-1">
            <div class="input-group">
                <input class="form-control form-control-solid rounded rounded-end-0 input filter_suburb" type="text" name="filter_suburb" placeholder="Suburb" />
            </div>
        </div>
        <div class="col-lg-3 my-1">
            <div class="input-group ">
                <select data-placeholder="State" class="form-select form-select-solid filter_state" name="filter_state" data-control="select2" data-hide-search="true">
                    <option value=""></option>
                    @foreach($userStates as $userState )
                        <option value="{{$userState->state->state_code}}">{{$userState->state->state_code}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 my-1">
            <div class="input-group ">
                <select data-placeholder="Status" class="form-select form-select-solid filter_status" name="filter_status" data-control="select2" data-hide-search="true">
                    <option></option>
                    <option value="status_enabled">Enabled</option>
                    <option value="status_disabled">Disabled</option>
                </select>
            </div>
        </div>
        <div class="align-items-center py-5 gap-2 gap-md-5">
            <div class="input-group w-500px">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-light btn-active-light-primary me-2 reset_suburb_filter" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset" data-id="">Reset</button>
                    <button type="submit" class="btn btn-primary" id="apply_suburb_filters">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
</form>
