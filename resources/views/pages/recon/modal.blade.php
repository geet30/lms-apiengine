<div class="modal fade" id="reconpop" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">{{ __('recon.popupaddlabel') }}</h2>
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
                <form role="form" name="managerecon" class="managerecon" accept-charset="UTF-8" class="pb-0">
                    @csrf
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('recon.enablereconlable')}}</label>
                        <div class="col-lg-8 fv-row ">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input radio-w-h-18" name="status" type="radio" value="1" @if(@$template[0]->status == 1) {{'checked'}} @endif/>
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('recon.enable') }}
                                </span>
                            </label>
                            <label class="form-check form-check-inline form-check-solid">
                                <input class="form-check-input radio-w-h-18" name="status" type="radio" value="0" @if(@$template[0]->status == 0) {{'checked'}} @endif/>
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('recon.disable') }}
                                </span>
                            </label>
                            <br />
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('recon.fromname')}}</label>
                        <div class="col-lg-8 fv-row fromname">
                            <input type="text" name="fromname" class="form-control form-control-lg form-control-solid" placeholder="{{__('recon.fromnameplaceholder')}}" value="{{ @$template[0]->from_name }}"/>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('recon.fromemail')}}</label>
                        <div class="col-lg-8 fv-row fromemail">
                            <input type="text" name="fromemail" class="form-control form-control-lg form-control-solid" placeholder="{{__('recon.fromemailplaceholder')}}" value="{{ @$template[0]->from_email }}"/>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('recon.emailsubject')}}</label>
                        <div class="col-lg-8 fv-row emailsubject">
                            <input type="text" name="emailsubject" class="form-control form-control-lg form-control-solid" placeholder="{{__('recon.fromsubjectplaceholder')}}" value="{{ @$template[0]->subject }}"/>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('recon.enteremailslabel')}}</label>
                        <div class="col-lg-8 fv-row reciveremails">
                            <textarea class="form-control form-control-lg form-control-solid" name="reciveremails" placeholder="{{__('recon.reciveremailplaceholder')}}">{{ @$template[0]->to_email }}</textarea>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <input type="hidden" name="templateid" value="{{encryptGdprData(@$template[0]->id)}}">
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