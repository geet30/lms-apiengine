<!--begin::Container-->
<div id="kt_content_container" class="{{ theme()->printHtmlClasses('content-container', true) }}">
    @include('partials.flash.message')
    {{ $slot }}
</div>
<!--end::Container-->
