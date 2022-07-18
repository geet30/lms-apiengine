<div class="card-header align-items-center py-0 gap-2 gap-md-5 px-0 border-0">
    Commission
    <div class="card-toolbar flex-row-fluid justify-content-md-end">
        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
            <button type="button" class="btn btn-light-primary filter_commission collapsible collapsed me-3 ms-0" data-bs-toggle="collapse" data-bs-target="#commission_filters">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                    </svg>
                </span>
                Filter
            </button>
        </div>
        <div class="col-2" id="affiliate-services-dropdown" style="min-width: 98px">
            <div class="input-group">
                <select data-placeholder="Select services" class="form-select form-select-solid" name="service" data-control="select2" data-hide-search="true" id="affiliate-services">
                    @foreach($services as $service)
                    <option value="{{$service['id']}}" @if($loop->first) selected @endif>{{$service['service_title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button  id="btn-add-commission" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#add-commission-modal">+Add</button>
    </div>
</div>
<form role="form" name="affiliate_commission" id="commission_filters" class="collapse commission_filters">
    @csrf
    <input type="hidden" value="{{encryptGdprData($affiliate->user_id)}}" id="affiliate-id">
    <div class="row">
        <div class="col">
            <div class="input-group mb-1">
                <select data-placeholder="Select year" class="form-select form-select-solid custom-width" name="year" data-control="select2" data-hide-search="true">
                    <option></option>
                    <option value="{{date('Y', strtotime('-1 year'))}}">{{date('Y', strtotime('-1 year'))}}</option>
                    <option value="{{date('Y')}}" selected>{{date('Y')}}</option>
                    <option value="{{date('Y', strtotime('+1 year'))}}">{{date('Y', strtotime('+1 year'))}}</option>
                </select>
            </div>
        </div>
        <div class="col">
            @php $months = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec']  @endphp
            <div class="input-group mb-1">
                <select data-placeholder="Select month" class="form-select form-select-solid custom-width" name="month" data-control="select2" data-hide-search="true">
                    @foreach($months as $key=>$month)
                        <option value="{{$key}}" {{ $key== date('m') ?'selected' : ''}}>{{$month}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <div class="input-group mb-1">
                <select data-placeholder="Select state" class="form-select form-select-solid custom-width" name="state" data-control="select2" data-hide-search="true">
                    <option></option>
                    @foreach($states as $state)
                        <option value="{{$state->state_id}}">{{$state->state_code}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-1">
                <select data-placeholder="Select providers" class="form-select form-select-solid custom-width" name="providers[]" data-control="select2" data-hide-search="true" multiple="multiple" id="providers-multiselect">
                    <option></option>
                    @foreach($providers as $provider)
                        <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <div class="input-group mb-1">
                <select data-placeholder="Select property" class="form-select form-select-solid custom-width" name="property" data-control="select2" data-hide-search="true">
                    <option value="both">Both</option>
                    <option value="residential">Residential</option>
                    <option value="business">Business</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="input-group mb-1">
                <select data-placeholder="Select sale type" class="form-select form-select-solid custom-width" name="sale" data-control="select2" data-hide-search="true">
                    <option value="both">Both(A/R)</option>
                    <option value="aquisition">Aquisition</option>
                    <option value="retention">Retention</option>
                </select>
            </div>
        </div>
        <div class="align-items-center py-5 gap-2 gap-md-5">
            <div class="input-group mb-1w-500px">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-light btn-active-light-primary me-2 resetbutton" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset" data-id="">Reset</button>
                    <button type="submit" class="btn btn-primary" id="apply_commission_filters">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
</form>

