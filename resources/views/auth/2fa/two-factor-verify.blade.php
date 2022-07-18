<x-auth-layout>
<!--begin::Wrapper-->
    <!--begin::Form-->
    <form method="post" action="{{ route('2fa.validate') }}" id="twofaFormValidate" class="form w-100 mb-10 needs-validation" novalidate="novalidate">
        {{ csrf_field() }}
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">{{ __('2fa.two_step_verification') }}</h1>
            <!--end::Title-->
            <!--begin::Sub-title-->
            <div class="text-muted fw-bold fs-5 mb-5">{{ __('2fa.enter_verification_code') }}</div>
            <!--end::Sub-title-->
        </div>
        <!--end::Heading-->
        <!--begin::Section-->
        <div class="mb-10 px-md-10">
            <!--begin::Label-->
            <div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">{{ __('2fa.enter_security_code') }}</div>
            <!--end::Label-->
            <!--begin::Input group-->
            <div class="invalid-feedback">{{ __('2fa.fill_all') }}.</div>
            <div class="d-flex flex-wrap flex-stack totp_container">
                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"  name="totp[1]" />
                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"  name="totp[2]" />
                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"  name="totp[3]" />
                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"  name="totp[4]" />
                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"  name="totp[5]" />
                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2"  name="totp[6]" />
            </div>
            <!--begin::Input group-->
        </div>
        <!--end::Section-->
        <!--begin::Submit-->
        <div class="d-flex flex-center">
            <a href="{{ url('/2fa/cancel') }}" class="btn btn-sm btn-danger fw-bolder mx-4">{{ __('2fa.cancel') }}</a>
            <button type="submit" id="submit_button" class="btn btn-sm btn-primary fw-bolder">
                @include('partials.general._button-indicator', ['label' => __('Submit')])
            </button>
        </div>
        <!--end::Submit-->
    </form>
    <!--end::Form-->
    <div class="text-center fw-bold fs-5">
        <span class="text-muted me-1">{{ __('2fa.security_codes') }} ?</span>
        <a href="#" data-bs-toggle="modal" data-bs-target="#backup_security_code" class="link-primary fw-bolder fs-5">Click here</a>
    </div>
    <!--begin::Notice-->
    <div class="text-center fw-bold fs-5">
        <span class="text-muted me-1">{{ __('2fa.did_not_get_code') }} ?</span>
        <a href="mailto:affiliate@cimet.com.au" class="link-primary fw-bolder fs-5">Contact Us</a>
    </div>
    <!--end::Notice-->
<!--end::Wrapper-->
@include('auth.2fa.modal')
@section('scripts')
<!-- Prevent browser back button -->
<script src="/custom/js/prevent.js"></script>
<script src="/custom/js/totp.js"></script>
@endsection
</x-auth-layout>