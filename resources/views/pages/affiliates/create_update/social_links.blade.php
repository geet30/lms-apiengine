<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" name="affiliate_social_links_form" class="affiliate_social_links_form">
        @csrf
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Social Links
                    </h2>
                </div>
            </div>
            <div class="card-body pt-0">

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Website URL
                    </label>
                    <div class="col-lg-8 fv-row dedicated_page">
                        <input type="text" name="dedicated_page" class="form-control form-control-lg form-control-solid" placeholder="Website URL" value="{{@$affiliateuser[0]['dedicated_page']}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Facebook Link
                    </label>
                    <div class="col-lg-8 fv-row facebook_url">
                        <input type="text" name="facebook_url" class="form-control form-control-lg form-control-solid" placeholder="Facebook Link" value="{{@$affiliateuser[0]['facebook_url']}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Twitter Link
                    </label>
                    <div class="col-lg-8 fv-row twitter_url">
                        <input type="text" name="twitter_url" class="form-control form-control-lg form-control-solid" placeholder="Twitter Link" value="{{@$affiliateuser[0]['twitter_url']}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Instagram Link
                    </label>
                    <div class="col-lg-8 fv-row instagram_url">
                        <input type="text" name="instagram_url" class="form-control form-control-lg form-control-solid" placeholder="Instagram Link" value="{{@$affiliateuser[0]['instagram_url']}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Youtube Link
                    </label>
                    <div class="col-lg-8 fv-row youtube_url">
                        <input type="text" name="youtube_url" class="form-control form-control-lg form-control-solid" placeholder="Youtube Link" value="{{@$affiliateuser[0]['youtube_url']}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">LinkedIn Link
                    </label>
                    <div class="col-lg-8 fv-row linkedin_url">
                        <input type="text" name="linkedin_url" class="form-control form-control-lg form-control-solid" placeholder="LinkedIn Link" value="{{@$affiliateuser[0]['linkedin_url']}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>

                <!-- <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Google Plus Link
                    </label>
                    <div class="col-lg-8 fv-row google_plus_url">
                        <input type="text" name="google_plus_url" class="form-control form-control-lg form-control-solid" placeholder="Google Plus Link" value="{{@$affiliateuser[0]['google_plus_url']}}" />
                        <span class="error text-danger"></span>
                    </div>
                </div> -->
            </div>
            <input type="hidden" name="id" class="affiliate_user_id" value="{{@encryptGdprData($affiliateuser[0]['user_id'])}}">
            <input type="hidden" name="parent_id" value="{{@encryptGdprData($affiliateuser[0]['parent_id'])}}">
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ theme()->getPageUrl('affiliates/list') }}" class="btn btn-white btn-active-light-primary me-2">{!! __('buttons.cancel') !!}</a>
               
                <button type="submit" class="submit_button" class="btn btn-primary">
                    @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                </button>
            </div>
        </div>
    </form>
</div>