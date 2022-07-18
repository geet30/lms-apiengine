<div class="modal fade" id="usagepopup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px scroll-y">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">{{ __('usagelimits.usagelimitslabel') }}</h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5 h-500px scroll-y">
                <form role="form" name="addusage" class="addusageform" accept-charset="UTF-8" class="pb-0">
                    @csrf
                    <div class="row mb-5">
                        <input type="hidden" class="usageset" name="usageset">
                        <div class="col usage_type">
                            <label class="fs-5 fw-bold  required form-label mb-1">{{ __('usagelimits.usagelimitslabel') }}</label>
                            <select id="usage_type" class="form-control form-control-solid form-select" data-control="select2" name="usage_type" data-placeholder="{{__('usagelimits.usagelimits')}}">
                                <option value="">{{__('usagelimits.usagelimits')}}</option>
                                <option value="1">{{__('usagelimits.business')}}</option>
                                <option value="2">{{__('usagelimits.residence')}}</option>
                            </select>
                            <span class="error text-danger"></span>
                        </div>
                        <div class="col state">
                            <label class="fs-5 fw-bold required form-label mb-1">{{ __('usagelimits.state') }}</label>
                            <select id="state" class="form-control form-control-solid form-select" data-control="select2" name="state" data-placeholder="{{__('usagelimits.state')}}">
                                <option value="">{{__('usagelimits.state')}}</option>
                                @if(count(states())>0)
                                    @foreach(states() as $state )
                                        <option value="{{$state->state}}">{{$state->state}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="fv-row mb-5 post_codes">
                        <label class="fs-5 fw-bold control form-label mb-5">{{ __('usagelimits.postcodes') }}</label>
                        <textarea class="form-control form-control-solid" name="post_codes" row="5" placeholder="{{ __('usagelimits.postcodeeg') }}" id="kt_tagify_1"></textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('usagelimits.electricitylabel') }}</label>
                    </div>
                    <div class="row mb-5">
                        <div class="col elec_low_range">
                            <label class="fs-5 fw-bold form-label mb-5 required">{{ __('usagelimits.lowlabel') }}</label>
                            <input class="form-control form-control-solid" name="elec_low_range" placeholder="{{ __('usagelimits.loweg') }}"/>
                            <span class="error text-danger"></span>
                        </div>
                        <div class="col elec_medium_range">
                            <label class="fs-5 fw-bold form-label mb-5 required">{{ __('usagelimits.mediumlabel') }}</label>
                            <input class="form-control form-control-solid" name="elec_medium_range" placeholder="{{ __('usagelimits.loweg') }}"/>
                            <span class="error text-danger"></span>
                        </div>
                        <div class="col elec_high_range">
                            <label class="fs-5 fw-bold form-label mb-5 required">{{ __('usagelimits.highlabel') }}</label>
                            <input class="form-control form-control-solid" name="elec_high_range" placeholder="{{ __('usagelimits.loweg') }}"/>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-bold form-label mb-5">{{ __('usagelimits.gaslimits') }}</label>
                    </div>
                    <div class="row mb-5">
                        <div class="col gas_low_range">
                            <label class="fs-5 fw-bold form-label mb-5 required">{{ __('usagelimits.lowlabel') }}</label>
                            <input class="form-control form-control-solid" name="gas_low_range" placeholder="{{ __('usagelimits.loweg') }}"/>
                            <span class="error text-danger"></span>
                        </div>
                        <div class="col gas_medium_range">
                            <label class="fs-5 fw-bold form-label mb-5 required">{{ __('usagelimits.mediumlabel') }}</label>
                            <input class="form-control form-control-solid" name="gas_medium_range" placeholder="{{ __('usagelimits.loweg') }}"/>
                            <span class="error text-danger"></span>
                        </div>
                        <div class="col gas_high_range">
                            <label class="fs-5 fw-bold form-label mb-5 required">{{ __('usagelimits.highlabel') }}</label>
                            <input class="form-control form-control-solid" name="gas_high_range" placeholder="{{ __('usagelimits.loweg') }}"/>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <input type="hidden" name="id" class="usageid">
                    <div class="text-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                        <button type="submit" id="submit_apikeydata" class="btn btn-primary">
                            <span class="indicator-label">{{ __('buttons.save') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>