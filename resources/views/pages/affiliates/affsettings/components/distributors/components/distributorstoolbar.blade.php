
        <form id="distributorFilter" name="distributorFilter" accept-charset="UTF-8" class="submitDistibutorServices px-8 py-2">
            <div class="d-flex align-items-top position-relative gap-5 my-1">
                @csrf
                <div class="col-lg-3 fv-row distributorservice">
                <select id="distributorservice" class="form-control form-control-solid form-select  distributorservice" name="distributorservice" data-placeholder="Select energy type" data-control="select2">
                    @if(count($verticals)>0)
                    <option value=""></option>
                    @foreach($verticals as $vertical )
                        @if($vertical->service_title == 'Electricity' || $vertical->service_title == 'Gas' || $vertical->service_title == 'LPG')
                            <option value="{{$vertical->service_id}}">{{$vertical->service_title}}</option>
                        @endif
                    @endforeach
                    @endif
                </select>
                <span class="error text-danger"></span>
                </div>
                <div class="col-lg-6 fv-row distributors">
                <select id="distributors" class="selectmultipledistributor form-control form-control-solid" multiple="multiple" tabindex="-1" aria-hidden="true" name="distributors[]">
                </select>
                <span class="error text-danger"></span>
                </div>
                <div class="col-lg-3 px-8" style="text-align:right;">
                <input type="hidden" value="{{request()->segment(2)}}" id="checksegment" class="justify-content-end">
                <button type="submit" class="btn btn-light-primary justify-content-end me-3">+Assign</button>
                </div>
            </div>
        </form>
