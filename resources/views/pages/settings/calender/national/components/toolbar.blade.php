
<div class="card-header align-items-center border-0" style="padding:0!important;">
    <div class="card-title">
        <form id="filter_national_holidays" name="filter_national_holidays" accept-charset="UTF-8" class="" method="POST">
       
            <div class="d-flex align-items-center position-relative gap-1 my-1">
                @csrf
                <select class="form-control  form-control-solid form-select w-150px resetvalues" id="sort_year" name="sort_year">
                    <option value="">-Select-</option>
                    <option>{{\Carbon\Carbon::now()->year-3}}</option>
                    <option>{{\Carbon\Carbon::now()->year-2}}</option>
                    <option>{{\Carbon\Carbon::now()->year-1}}</option>
                    <option selected="selected">{{\Carbon\Carbon::now()->year}}</option>
                    <option>{{\Carbon\Carbon::now()->addYear()->year}}</option>
                </select>

                <button type="submit" class="btn btn-primary" id="applynationalfilter">Apply</button>
                <button type="button" class="btn btn-primary resetnationalfilter">Reset</button>

            </div>
        </form>
    </div>
    <div class="card-toolbar flex-row-fluid justify-content-end gap-2">
        <button type="button" class="btn btn-light-primary me-3 national_holday_add_btn" data-bs-toggle="modal" data-bs-target="#national_holiday_modal">+Add </button>

    </div>
</div>