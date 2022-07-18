<div class="modal fade" id="paramterpopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">{{ __('affiliates.parametersheading') }}<span class="selectedcompany"></span></h2>
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
                <form role="form" name="submitparamter" class="submitparamter" accept-charset="UTF-8" class="pb-0">
                    @csrf
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('affiliates.planlisting')}}</label>
                        <div class="col-lg-8 fv-row status planlisting">
                            <input type="text" name="planlisting" class="form-control form-control-lg form-control-solid planlistingval popclass" placeholder="{!! __('affiliates.planlistingplaceholder') !!}"  />
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('affiliates.plandetail')}}</label>
                        <div class="col-lg-8 fv-row status plandetail">
                            <input type="text" name="plandetail" class="form-control form-control-lg form-control-solid plandetailval popclass" placeholder="{!! __('affiliates.plandetailplaceholder') !!}"  />
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('affiliates.remarketing')}}</label>
                        <div class="col-lg-8 fv-row status remarketing">
                            <input type="text" name="remarketing" class="form-control form-control-lg form-control-solid remarketingval popclass" placeholder="{!! __('affiliates.remarketingplaceholder') !!}"  />
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('affiliates.slug')}}</label>
                        <div class="col-lg-8 fv-row status slug">
                            <input type="text" name="slug" class="form-control form-control-lg form-control-solid slugval popclass" placeholder="{!! __('affiliates.slugplaceholder') !!}"  />
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{__('affiliates.terms')}}</label>
                        <div class="col-lg-8 fv-row status terms">
                            <input type="text" name="terms" class="form-control form-control-lg form-control-solid termsval popclass" placeholder="{!! __('affiliates.termsplaceholder') !!}"  />
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('affiliates.journeylabel')}}</label>
                        <div class="col-lg-8 fv-row journey">
                            <input type="text" name="journey" class="form-control form-control-lg form-control-solid journeyval popclass" placeholder="{!! __('affiliates.journeyplaceholder') !!}"  id="journeyinput"/>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <input type="hidden" name="paramuser" value="{{@encryptGdprData($affiliateuser[0]['user_id'])}}">
                    <input type="hidden" name="paramid" class="paramid popclass">
                    <input type="hidden" name="paramservice" class="paramservice popclass">
                    <div class="text-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                        <button type="submit" class="btn btn-primary parameter_button">
                            @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>