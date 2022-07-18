<x-base-layout>

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Apps-->
                    <div data-kt-element="apps">
                        <!--begin::Heading-->
                        <h3 class="text-dark fw-bolder mb-7">{{ __('2fa.authenticator_apps') }}</h3>
                        <!--end::Heading-->
                        <!--begin::Description-->

                        <div class="text-gray-500 fw-bold fs-6 mb-10">{!! __('2fa.usage', [
                            'authenticators' => '<a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">Google Authenticator</a>,
                            <a href="https://www.microsoft.com/en-us/account/authenticator" target="_blank">Microsoft Authenticator</a>,
                            <a href="https://authy.com/download/" target="_blank">Authy</a>, or
                            <a href="https://support.1password.com/one-time-passwords/" target="_blank">1Password</a>',
                            ]) !!}
                            <!--begin::QR code image-->
                            <div class="pt-5 text-center">
                                {!! $image !!}
                            </div>
                            <!--end::QR code image-->
                        </div>
                        <!--end::Description-->
                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                            {!! theme()->getSvgIcon('icons/duotune/general/gen044.svg', 'svg-icon-2tx svg-icon-warning me-4') !!}

                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-bold">
                                    <div class="fs-6 text-gray-700">{{ __('2fa.note') }}:
                                        <div class="fw-bolder text-dark pt-2">{{ $secret }}</div>
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                        <!--begin::Form-->
                        <form method="post" action="{{ route('2fa.manage') }}" id="twofaFormValidate" class="disable-two-factor">
                            <!--begin::Input group-->
                            {{ csrf_field() }}
                            {{-- <input type="text" class="form-control form-control-lg form-control-solid" placeholder="Enter authentication code" name="totp" /> --}}
                            <!--begin::Section-->
                            <div class="mb-10 px-md-10 w-lg-600px m-auto fv-row">
                                <!--begin::Label-->
                                <div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">
                                    {{ __('2fa.enter_security_code') }}
                                </div>
                                <!--end::Label-->
                                <!--begin::Input group-->
                                <div class="invalid-feedback">{{ __('2fa.fill_all') }}.</div>
                                <div class="d-flex flex-wrap flex-stack totp_container">
                                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" name="totp[1]" />
                                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" name="totp[2]" />
                                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" name="totp[3]" />
                                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" name="totp[4]" />
                                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" name="totp[5]" />
                                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" name="totp[6]" />
                                </div>
                                <!--begin::Input group-->
                            </div>
                            <!--end::Section-->
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex flex-center">
                                <button type="submit" data-kt-element="apps-submit" id="submit_button" class="btn btn-primary btn-sm">
                                    <span class="indicator-label">
                                        @if ($is2faActivated)
                                        {{ __('2fa.deactivate') }} @else
                                        {{ __('2fa.activate') }} @endif
                                    </span>
                                    <span class="indicator-progress">{{ __('2fa.wait') }}
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Options-->

                    <!--begin::Illustration-->
                    <div class="text-center pb-5 px-5 mt-8">

                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-2 p-6">
                            {!! theme()->getSvgIcon('icons/duotune/general/gen044.svg', 'svg-icon-2tx svg-icon-warning me-4') !!}
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold">
                                    <div class="fs-6 text-gray-700">{{ __('2fa.recovery_code_note') }}.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-sm">
                            <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse" data-bs-target="#kt_docs_card_collapsible">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder text-dark">{{ __('2fa.backup_recovery_code') }}</span>
                                </h3>
                                <div class="card-toolbar rotate-180">
                                    {!! theme()->getSvgIcon('icons/duotune/arrows/arr065.svg', 'svg-icon-1') !!}
                                </div>
                            </div>
                            <div id="kt_docs_card_collapsible" class="collapse show">
                                <!--begin::Body-->
                                @if (count($recoveryCodes))
                                <div class="card-body pt-2">
                                    @foreach ($recoveryCodes as $code)
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Bullet-->
                                        <span class="bullet bullet-vertical h-40px"></span>
                                        <!--end::Bullet-->
                                        <!--begin::Description-->
                                        <div class="flex-grow-1">
                                            <span id="recovery_code_{{ $code }}">{{ $code }}</span>
                                        </div>
                                        <!--end::Description-->
                                        <button class="highlight-copy btn badge badge-light-success btn-sm" onclick="copyToClipboard('#recovery_code_{{ $code }}', this)" data-bs-toggle="tooltip" title="Copy code">{{ __('2fa.copy') }}</button>
                                    </div>
                                    <!--end:Item-->
                                    @endforeach
                                </div>
                                <!--end::Body-->
                                @endif
                                <div class="card-footer">
                                    <form method="post" action="{{ route('2fa.recovery-codes') }}" id="recoveryCodes">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="processType" id="processType" value="" />
                                        &nbsp;&nbsp;&nbsp;
                                        @if (count($recoveryCodes))
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="jQuery('#processType').val('download')">{{ __('2fa.download') }}</button>
                                        @endif
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="jQuery('#processType').val('generate')">
                                            @if (!empty($recoveryCodes)) {{ __('2fa.re_generate_codes') }} @else {{ __('2fa.generate_codes') }} @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Illustration-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
    @section('scripts')
    <script src="/custom/js/totp.js"></script>
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
        const breadArray = [{
                title: 'Dashboard',
                link: '/',
                active: false
            },
            {
                title: 'Two Factor Authentication',
                link: '#',
                active: true
            }
        ];
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();
    </script>
    @endsection
</x-base-layout>