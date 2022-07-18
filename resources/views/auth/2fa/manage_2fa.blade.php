<x-base-layout>
    <!--begin::Content-->
    <div class="card shadow-sm">
        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-2 p-6">
            {!! theme()->getSvgIcon('icons/duotune/general/gen044.svg', 'svg-icon-2tx svg-icon-warning me-4') !!}
            <div class="d-flex flex-stack flex-grow-1">
                <div class="fw-bold">
                    <div class="fs-6 text-gray-700">{{ __('2fa.force_note') }}.
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
            data-bs-target="#kt_docs_card_collapsible">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder text-dark">{{ __('2fa.manage_two_factor') }}</span>
            </h3>
            <div class="card-toolbar rotate-180">
                {!! theme()->getSvgIcon('icons/duotune/arrows/arr065.svg', 'svg-icon-1') !!}
            </div>
        </div>
        <div id="kt_docs_card_collapsible" class="collapse show">
            <!--begin::Body-->
            <div class="card-body pt-2">
                <div class="d-flex flex-stack w-lg-50">
                    <!--begin::Label-->
                    <div class="me-5">
                        <label class="fs-6 fw-bold form-label">{!! __('2fa.force_note_two') !!}
                    </div>
                    <!--end::Label-->
                    <form method="post" action="{{ route('2fa.post.force') }}" id="twofaFormValidate"
                        class="form w-100 mb-10 needs-validation" novalidate="novalidate">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <!--begin::Switch-->
                        <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success"
                            onclick="areYouSure('#2fa_force_checkbox')">
                            {{-- checked="checked" --}}
                            <input class="form-check-input" @if ($isForced == 1) checked @endif type="checkbox" data-message="User would not be able to login without Two
                        Factor Authentication" value="1" id="2fa_force_checkbox" name="two_fa_force" />
                            <span class="pulse-ring ms-n1"></span>
                            <span class="form-check-label fw-bold text-muted">
                                @if ($isForced == 1) {{ __('2fa.deactivate') }} it @else {{ __('2fa.force') }} it @endif
                            </span>
                        </label>
                        <!--end::Switch-->
                    </form>
                </div>

                <div class="d-flex flex-stack w-lg-50 mt-8">
                    <!--begin::Label-->
                    <div class="me-5">
                        <label class="fs-6 fw-bold form-label">{{ __('2fa.deactivate') }} 2FA</label>
                        {!! __('2fa.deactivate_note') !!}
                        
                    </div>
                    <!--end::Label-->
                    <form method="post" action="{{ route('2fa.disable') }}" id="deactivate_2fa"
                        class="form w-100 mb-10 needs-validation" novalidate="novalidate">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <!--begin::Switch-->
                        <button type="button"
                            @if (!$is2faActivated) disabled @endif
                            data-message="{{ __('2fa.deactivate_alert') }}"
                            class="btn btn-sm btn-danger fw-bolder" id="2fa_disable_checkbox"
                            onclick="areYouSure(false)">
                            @include('partials.general._button-indicator', ['label' =>__('2fa.deactivate'). " 2FA"])
                        </button>
                    </form>
                    <!--end::Switch-->
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
        <script>
            /** Intilize Breadcrumbs **/
            const breadArray = [
                {
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: 'Affiliates',
                    link: '/affiliates/list',
                    active: false
                },
                {
                    title: 'Manage Two Factor Authentication',
                    link: '#',
                    active: true
                }
            ];
            const breadInstance = new BreadCrumbs(breadArray);
            breadInstance.init();

            function areYouSure(currentInstance) {
                var deactivateButton, checkBox, isChecked;
                if (currentInstance) {
                    checkBox = $(currentInstance);
                    isChecked = checkBox.is(":checked");

                    $confirmMsg = "{{ __('2fa.yes_activate_it') }}";
                    $confirmText = "{{ __('2fa.activate_alert') }}";
                    if (!isChecked) {
                        $confirmMsg = "{{ __('2fa.yes_deactivate_it') }}";
                        $confirmText = "{{ __('2fa.yes_deactivate_text') }}";
                    }
                } else {
                    deactivateButton = document.getElementById('2fa_disable_checkbox');
                    deactivateButton.setAttribute('data-kt-indicator', 'on');
                    deactivateButton.disabled = true;
                    
                    $confirmText = "{{ __('2fa.deactivate_alert') }}"
                    $confirmMsg = "{{ __('2fa.yes_deactivate_it') }}";
                }

                Swal.fire({
                    title: "{{ __('2fa.are_you_sure') }}?",
                    text: $confirmText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: $confirmMsg
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (!currentInstance) {
                            deactivateButton.setAttribute('data-kt-indicator', 'off');
                            deactivateButton.innerText = 'Deactivated'
                            $('#2fa_force_checkbox').prop('checked', false)
                            $('form#deactivate_2fa').submit();
                            
                        } else {
                            $('form#twofaFormValidate').submit();
                        }
                    } else if (currentInstance) {
                        if (isChecked) {
                            checkBox.prop('checked', false);
                        } else {
                            checkBox.prop('checked', true);
                        }
                    } else {
                        deactivateButton.setAttribute('data-kt-indicator', 'off');
                        deactivateButton.disabled = false;
                    }
                })
            }
        </script>
    @endsection
</x-base-layout>
