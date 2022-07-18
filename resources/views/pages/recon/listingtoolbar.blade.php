<div class="card-header align-items-center border-0">
    <div class="card-title">
        <form  name="filterrecon" id="filterrecon" accept-charset="UTF-8"  method="POST">
            <div class="d-flex align-items-top position-relative gap-1 my-1">
                @csrf
                <div class="col-lg-2">
                <select id="rolefilter" name="rolefilter" class="form-control form-control-solid form-select " data-control="select2"  data-placeholder="{{__('recon.type')}}">
                    <option value=""></option>
                    <option value="0">{{__('recon.all')}}</option>
                    <option value="1">{{__('recon.affiliate')}}</option>
                    <option value="2">{{__('recon.subaffiliate')}}</option>
                </select>
                </div>
                <div class="col-lg-3">
                <select id="affiliates" name="affiliates[]" class="form-control form-control-solid form-select" data-control="select2"  data-placeholder="{{__('recon.searchby')}}" multiple>
                    <option value=""></option>
                    @foreach($affiliates as $affiliate )
                        <option value="{{$affiliate['id']}}">{{$affiliate['company_name']}}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-lg-3" id="hidesub">
                    <select id="subaffiliates" name="subaffiliates[]" class="form-control form-control-solid form-select" data-control="select2"  data-placeholder="{{__('recon.searchbysub')}}" multiple>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select id="reconmethod" name="reconmethod" class="form-control form-control-solid form-select" data-control="select2"  data-placeholder="{{__('recon.reconmethod')}}">
                        <option value=""></option>
                        <option value="0">{{__('recon.all')}}</option>
                        <option value="1">{{__('affiliates.monthly')}}</option>
                        <option value="2">{{__('affiliates.bimonthly')}}</option>
                    </select>
                </div>
                <div class="col-lg-1">
                    <button type="submit" class="btn btn-primary applyfilter">{{__('recon.apply')}}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-toolbar flex-row-fluid justify-content-end gap-2">
        <button type="submit" class="btn btn-light btn-active-light-primary resetbutton resetbutton">{{__('recon.reset')}}</button>
        <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#reconpop">
        {{ __('recon.popupaddlabel') }}
        </button>
    </div>
</div>