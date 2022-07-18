<div class="modal fade" tabindex="-1" id="backup_security_code">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('2fa.validate') }}" id="twofaSecurityFormValidate" class="form w-100 mb-10 needs-validation" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal-body">
                <div class="backup-invalid-feedback" style="display:none;color:red">{{ __('2fa.fill_all') }}.</div>
                <input type="password" class="form-control mb-2 mb-md-0" name="totp[1]" placeholder="Enter security code" />
            </div>

            {{-- <div class="modal-footer"> --}}
                <div class="d-flex flex-center">
                    <button type="button" class="btn btn-sm btn-danger fw-bolder mx-4" data-bs-dismiss="modal">{{ __('2fa.cancel') }}</button>
                    <button type="submit" id="backup_submit_button" class="btn btn-sm btn-primary fw-bolder">
                        @include('partials.general._button-indicator', ['label' => __('Submit')])
                    </button>
                </div>
            {{-- </div> --}}
        </form>
        </div>
    </div>
</div>