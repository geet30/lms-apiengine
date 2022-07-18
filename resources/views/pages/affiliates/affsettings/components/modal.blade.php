<div class="modal fade" id="apicreatemodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white popheading">{{ __('affiliates_label.api_key.add_api_key') }}</h2>
                <div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">
                <form id="add_update_apikeyform" name="add_update_apikeyform" accept-charset="UTF-8"
                    class="form submit_apikey_form pb-0">
                    <input type="hidden" name="request_from" value="{{ $headArr['requestFrom'] }}">
                    <input type="hidden" id="form_action" value="{{ route('apikey.store') }}">
                    @csrf
                    <div class="fv-row mb-5">
                        <label
                            class="fs-5 fw-bold  required form-label mb-1">{{ __('affiliates_label.api_key.name') }}</label>
                        <input class="form-control form-control-solid h-50px border"
                            placeholder="{{ __('affiliates_label.api_key.name') }}" name="name" />
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </div>
                    <div class="fv-row mb-5">
                        <label
                            class="fs-5 fw-bold required form-label mb-1">{{ __('affiliates_label.api_key.page_url') }}</label>
                        <input class="form-control form-control-solid h-50px border"
                            placeholder="{{ __('affiliates_label.api_key.url_placeholder') }}" name="page_url" />
                        <span class="form_error_page_url form_error" style="color: red;"></span>

                    </div>
                    <div class="fv-row mb-5">
                        <label
                            class="fs-5 fw-bold required form-label mb-5">{{ __('affiliates_label.api_key.tokenx_origin') }}</label>
                        <input class="form-control form-control-solid h-50px border"
                            placeholder="{{ __('affiliates_label.api_key.token_placeholder') }}" name="origin_url" />
                        <span class="form_error_origin_url form_error" style="color: red;"></span>
                    </div>
                    @if ($headArr['requestFrom'])
                        <div class="fv-row mb-5">
                            <label
                                class="fs-5 fw-bold form-label mb-1">{{ __('affiliates_label.api_key.create_api_key') }}
                            </label>
                            <input checked="checked" name="create_api_key" type="checkbox" value="1">
                            <span class="form_error_create_api_key form_error" style="color: red;"></span>

                        </div>
                    @endif
                    <div class="text-end">
                        <button type="button" class="btn btn-light me-3"
                            data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                        <button type="submit" id="submit_apikeydata" class="btn btn-primary">
                            <span class="indicator-label">{{ __('buttons.save') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="apikeyshow" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h4 class="fw-bolder fs-12 text-white">API key</h4>
                <div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1 hideapkipopup">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <span class="form-control form-control-solid h-50px border" id="api-key-input"></span>
                    <button class="highlight-copy btn copyapikey  badge-dd btn btn-primary btn-sm"
                        onClick="$(this).text('Copied');$(' #search_affiliate').focus();" data-bs-toggle=" tooltip"
                        title="Copy code"> {{ __('2fa.copy') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
