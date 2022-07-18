<form id="providerStates" name="providerStates" accept-charset="UTF-8" class="submitStates">
    @csrf
    <div class="row my-1 px-8 py-2">
        <div class="col-md-6 d-flex align-items-center">
            <h3 class="fw-bolder m-0">States</h3>
        </div>
        <div class="col-md-6 py-1 py-md-0">
            <input type="hidden" name="id" value="{{$providerId}}">
            <div class="row">
                <div class="col-10">
                    <select id="states" class="multiplestates form-control form-control-solid min-h-45px" multiple="multiple" name="states[]" aria-hidden="true" data-control="select2" data-placeholder="Select States">
                        @if(count($states)>0)
                            <option value="select_all">Select All</option>
                            @foreach($states as $state )
                                <option value="{{$state->state_id}}">{{$state->state_code}}</option>
                            @endforeach
                        @endif
                    </select>
                    <span class="errors text-danger"></span>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-light-primary h-45px">+Assign</button>
                </div>
            </div>
        </div>
    </div>
</form>
