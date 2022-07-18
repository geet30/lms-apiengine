<div class="card distributors-section">
    <div class="card-header collapsed" data-bs-toggle="collapse" href="#collapseDistributors" role="button" aria-expanded="false" aria-controls="collapseDistributors">
        <h4 class="my-auto">Distributors</h4>
    </div>
    <div class="card-body p-0 collapse" id="collapseDistributors">
        @include('pages.affiliates.affsettings.components.distributors.components.distributorstoolbar')
        @include('pages.affiliates.affsettings.components.distributors.components.table')
    </div>
</div>

<div class="card mt-10" id="life-support-card">
    <div class="card-header collapsed" data-bs-toggle="collapse" href="#collapseLifeSupport" role="button" aria-expanded="false" aria-controls="collapseLifeSupport">
        <h4 class="my-auto">Life Support Content</h4>
    </div>
    <div class="card-body p-0 collapse" id="collapseLifeSupport">
        <div id="kt_affliate_form_details" class="">
            <form class="affiliate_life_support_content_form" method="POST" action='/affiliates/saveidmatrix' accept-charset="UTF-8" name="affiliate_life_support_content_form" id="affiliate_life_support_content_form">
                @csrf
                <input type="hidden" value="{{encryptGdprData($affiliate->user_id)}}" name="user_id" id="affiliate_user_id">
                <input type="hidden" value="" name="edit_id" id="life_support_edit_id">
                <div class="card border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Life Support Content</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input radio-w-h-18" name="life_support_status" type="radio" value="1" id="life_support_enable" @if($affiliate->life_support_status == 1) checked @endif/>
                                    <span class=" fw-bold ps-2 fs-6">
                                        Active
                                    </span>
                                </label>
                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input radio-w-h-18" name="life_support_status" type="radio" value="0" id="life_support_disable" @if($affiliate->life_support_status == 0) checked @endif/>
                                    <span class="fw-bold ps-2 fs-6">
                                        Inactive
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6 required">Content</label>
                        <div class="col-lg-8 fv-row field-holder">
                            <textarea name="content" class="form-control form-control-lg form-control-solid ckeditor" id="content">{{$affiliate->life_support_content}}</textarea>
                            <span class="form_error" style="color: red;"></span>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9 border-0">
                    <a href="{{ theme()->getPageUrl('affiliates/list') }}" class="btn btn-white btn-active-light-primary me-2">{{ __('buttons.cancel') }}</a>
                    <button type="submit" class="btn btn-primary" id="add_life_support">
                        <span class="indicator-label">{{ __('buttons.save') }}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>