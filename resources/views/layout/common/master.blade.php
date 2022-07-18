@extends('base.base')

@section('content')

    <!--begin::Main-->
    @if (theme()->getOption('layout', 'main/type') === 'blank')
        <div class="d-flex flex-column flex-root">
            {{ $slot }}
        </div>
    @else
        <!--begin::Root-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="page d-flex flex-row flex-column-fluid">
            {{ theme()->getView('layout/aside/_base') }}

            <!--begin::Wrapper-->
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                {{ theme()->getView('layout/header/_base') }}

                <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid mt-0 mx-0 px-8" id="kt_content">
                        {{ theme()->getView('layout/_content', compact('slot')) }}
                    </div>
                    <!--end::Content-->

                    {{ theme()->getView('layout/_footer') }}
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Root-->

        <!--begin::Drawers-->
        {{ theme()->getView('partials/topbar/_activity-drawer') }}
        <!--end::Drawers-->

        <!--begin::Loader-->
        {{ theme()->getView('partials/general/_loader') }}
        <!--end::Loader-->

        @if(theme()->getOption('layout', 'scrolltop/display') === true)
            {{ theme()->getView('layout/_scrolltop') }}
        @endif
    @endif
    <!--end::Main-->
    @include("layout.common.custom_ck_editor")
    @include("layout.common.custom_ckeditor")
@endsection
