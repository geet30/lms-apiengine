<form id="userFilter" name="userFilter" accept-charset="UTF-8" class="submitServices px-8 py-2">
    <div class="d-flex align-items-top position-relative gap-5 my-1">
        @csrf
        <div class="col-lg-3 userservice">
            <select id="userservice" class="form-control form-control-solid form-select userservice" name="userservice" data-placeholder="Select Verticals" data-control="select2">
                @if(count($verticals)>0)
                <option value=""></option>
                @foreach($verticals as $vertical )
                <option value="{{$vertical->service_id}}">{{$vertical->service_title}}</option>
                @endforeach
                @endif
            </select>
            <span class="error text-danger"></span>
        </div>
        <div class="col-lg-6 users">
            <select id="users" class="multipleusers form-control form-control-solid  h-45px" multiple="multiple" tabindex="-1" aria-hidden="true" name="users[]">
            </select>
            <span class="error text-danger"></span>
        </div>
        <div class="col-lg-3 px-8" style="text-align:right;">
            <input type="hidden" value="{{request()->segment(2)}}" id="checksegment">
            <button type="submit" class="btn btn-light-primary me-3">+Assign</button>
        </div>
    </div>
</form>