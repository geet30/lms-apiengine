<div class="modal fade" id="editreconpop" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">{{ __('recon.editreconpermission') }}<span class="selectedcompany"></span></h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">
                <form role="form" name="addpermission" class="addpermission" accept-charset="UTF-8" class="pb-0">
                    @csrf
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('recon.reconmethod')}}</label>
                        <div class="col-lg-8 fv-row status">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input radio-w-h-18 reconmonthly" name="status" type="radio" value="1"/>
                                <span class="fw-bold ps-2 fs-6">
                                    {{__('affiliates.monthly')}}
                                </span>
                            </label>
                            <label class="form-check form-check-inline form-check-solid">
                                <input class="form-check-input radio-w-h-18 reconbimonthly" name="status" type="radio" value="2" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{__('affiliates.bimonthly')}}
                                </span>
                            </label>
                            <br />
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('recon.permissonlabel')}}</label>
                        <div class="col-lg-8 fv-row permission checkbox-inline">
                        @foreach($masterpermissions as $permission )
                            <label class="checkbox">
                            <input class="checkbox-w-h-18 permissioncheck" name="permission[]" type="checkbox" value="{{$permission['id']}}" />
                            <span></span>{{$permission['name']}}</label>
                        @endforeach
                        <br/>
                        <span class="error text-danger"></span>
                        </div>
                    </div>
                    <input type="hidden" name="id" class="setid">
                    <div class="text-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">{{ __('buttons.save') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>