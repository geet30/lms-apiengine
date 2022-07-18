<div class="card-header align-items-center border-0">
    <div class="card-title">
        <form id="" name="" accept-charset="UTF-8" class="" method="POST">
            <div class="d-flex align-items-center position-relative gap-1 my-1">
                @csrf
                <select id="usagefilter" class="form-control form-control-solid form-select w-250px" data-control="select2"  data-placeholder="{{__('usagelimits.usagelimits')}}">
                    <option value="">{{__('usagelimits.usagelimits')}}</option>
                    <option value="1">{{__('usagelimits.business')}}</option>
                    <option value="2">{{__('usagelimits.residence')}}</option>
                </select>
                <button type="button" class="btn btn-light-primary applyusagefilter">{{__('usagelimits.apply')}}</button>
            </div>
        </form>
    </div>
    <div class="card-toolbar flex-row-fluid justify-content-end gap-2">
        <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" class="usagepopup" data-bs-target="#usagepopup">
        {{ __('usagelimits.add') }}
        </button>
    </div>
</div>