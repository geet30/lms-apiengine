<form id="affiliateFilter" name="affiliateFilter" accept-charset="UTF-8" class="submitsubmitAffiliate">
    @csrf
    <div class="row my-1 px-8 py-2">
        <div class="col-md-6 d-flex align-items-center">
            <h3 class="fw-bolder m-0">Affiliates</h3>
        </div>
        <div class="col-md-6 py-1 py-md-0 providers">
            <input type="hidden" name="id" value="{{$providerId}}">
            <div class="row gap-0">
                <div class="col-10">
                    <select id="providers" class="multipleaffiliates form-control form-control-solid  min-h-45px" multiple="multiple" name="providers[]" aria-hidden="true" data-control="select2" data-placeholder="Select Affiliates">
                        @if(count($users)>0)
                            <option value="select_all">Select All</option>
                            @foreach($users as $user)
                                <option value="{{$user->user_id}}">{{$user->company_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <span class="errors text-danger"></span>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-light-primary h-45px float-right">+Assign</button>
                </div>
            </div>
        </div>
    </div>
</form>
