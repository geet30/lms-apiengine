<x-auth-layout>
    {{-- <div class="row"> --}}
    <div data-kt-element="apps">
        <!--begin::Heading-->
        <h3 class="text-dark fw-bolder mb-7">{{ __('2fa.authenticator_apps') }}</h3>
        <!--end::Heading-->
        <!--begin::Description-->
        <div class="text-gray-500 fw-bold fs-6 mb-10">{!! __('2fa.usage', [
            'authenticators' => '<a href="https://support.google.com/accounts/answer/1066447?hl=en"
                                            target="_blank">Google Authenticator</a>,
                                        <a href="https://www.microsoft.com/en-us/account/authenticator"
                                            target="_blank">Microsoft Authenticator</a>,
                                        <a href="https://authy.com/download/" target="_blank">Authy</a>, or
                                        <a href="https://support.1password.com/one-time-passwords/"
                                            target="_blank">1Password</a>',
        ]) !!}
            <!--begin::QR code image-->
            <br /><br />
            <strong>Note: {{ __('2fa.force_enable') }} </strong>
            <br />
            <div class="pt-5 text-center">
                {!! $qrCode !!}
            </div>
        </div>
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
        <!--begin::Section-->
        <div class="mb-10 px-md-10">
            <!--begin::Label-->
            <div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">{{ __('2fa.enter_security_code') }}</div>
            <!--end::Label-->
            <div class="invalid-feedback">{{ __('2fa.fill_all') }}.</div>
            <!--begin::Input group-->
            <form method="post" action="{{ route('2fa.manage') }}" id="twofaFormValidate">
                {{ csrf_field() }}
                <input type="hidden" value="1" name="show-popup" />
                <div class="d-flex flex-wrap flex-stack totp_container">
                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                        class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"
                        name="totp[1]" />
                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                        class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"
                        name="totp[2]" />
                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                        class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"
                        name="totp[3]" />
                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                        class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"
                        name="totp[4]" />
                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                        class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"
                        name="totp[5]" />
                    <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                        class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"
                        name="totp[6]" />
                </div>
                <button type="submit" id="submit_button"
                    class="btn btn-sm btn-primary fw-bolder float-right">
                    @include('partials.general._button-indicator', ['label' => __('activate')])
                </button>
            </form>

            <!--begin::Input group-->
        </div>
        <!--end::Section-->
    </div>

    @section('scripts')
    <script src="/custom/js/totp.js"></script>
    @endsection
</x-auth-layout>
