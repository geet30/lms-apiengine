@php
    $itemClass = "ms-1 ms-lg-3";
    $btnClass = "btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px";
    $userAvatarClass = "symbol-30px symbol-md-40px";
    $btnIconClass = "svg-icon-1";
@endphp
<!--begin::Toolbar-->
<div class="{{ theme()->printHtmlClasses('header-container', false) }} py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
    {{ theme()->getView('layout/_page-title') }}

    <!--begin::Action group-->
    <div class="d-flex align-items-center overflow-auto pt-3 pt-lg-0">
        <!--begin::Action wrapper-->

        {{-- <div class="d-flex align-items-center">
            <!--begin::Label-->
            <span class="fs-7 fw-bolder text-gray-700 pe-4 text-nowrap d-none d-xxl-block">Sort By:</span>
            <!--end::Label-->

            <!--begin::Select-->
            <select class="form-select form-select-sm form-select-solid w-100px w-xxl-125px" data-control="select2" data-placeholder="Latest" data-hide-search="true">
                <option value=""></option>
                <option value="1" selected>Latest</option>
                <option value="2">In Progress</option>
                <option value="3">Done</option>
            </select>
            <!--end::Select-->
        </div> --}}
        <a href="{{ URL::previous() }}" id="back_button" class="btn btn-primary black pull-right page_speed_1632380136">&nbsp;&nbsp;Back</a>
        <!--end::Action wrapper-->


        <!--begin::User menu-->
    {{-- <div class="d-flex align-items-center {{ $itemClass }}" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol {{ $userAvatarClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="{{ (theme()->isRtl() ? "bottom-start" : "bottom-end") }}">
            <img src="{{ auth()->user()->avatarUrl }}" alt="user"/>
        </div>
    {{ theme()->getView('partials/topbar/_user-menu') }}
    <!--end::Menu wrapper-->
    </div> --}}
    <!--end::User menu-->
    </div>
    <!--end::Action group-->
</div>
<!--end::Toolbar-->
