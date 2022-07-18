<div class="card-header">
    <!-- <h2 class="card-title fw-bolder">Move In Calendar</h2> -->
    <div class="card-toolbar">
        <div class="col-lg-1-half">
            <select class="form-control form-control-solid form-select" name="state_requested" id="state_requested">
                <option value="ACT">ACT</option>
                <option value="NSW">NSW</option>
                <option value="NT">NT</option>
                <option value="QLD">QLD</option>
                <option value="SA">SA</option>
                <option value="TAS">TAS</option>
                <option value="VIC">VIC</option>
                <option value="WA">WA</option>
            </select>
        </div>
        <div class="col-lg-2-half">
             <a href="{{ url('settings/national-holidays') }}" class="btn btn-success pull-left">National Holidays</a>
        </div>
        <div class="col-lg-2-half">
            <a href="{{ url('settings/state-holidays') }}" class="btn btn-success pull-left state_holiday_btn">State Holidays</a>
        </div>
        <div class="col-lg-2-half">
             <a href="javascript:void(0);" class="btn btn-success pull-left weekend_content">Weekend Content</a>
        </div>
        <!-- <div class="col-lg-2-half">
            <a href="javascript:void(0);" class="btn btn-success pull-left move_in_close_time_btn">Set Closing Time</a>
        </div> -->
        <div class="clearfix"></div>
        <br>
    </div>
</div>