<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>@yield('title')</title>

        @if (theme()->hasOption('page', 'assets/vendors/css'))
            {{-- begin::Page Vendor Stylesheets(used by this page) --}}
            @foreach (array_unique(theme()->getOption('page', 'assets/vendors/css')) as $file)
                {!! preloadCss(assetCustom($file)) !!}
            @endforeach
            {{-- end::Page Vendor Stylesheets --}}
        @endif

        @if (theme()->hasOption('page', 'assets/custom/css'))
            {{-- begin::Page Custom Stylesheets(used by this page) --}}
            @foreach (array_unique(theme()->getOption('page', 'assets/custom/css')) as $file)
                {!! preloadCss(assetCustom($file)) !!}
            @endforeach
            {{-- end::Page Custom Stylesheets --}}
        @endif

        @if (theme()->hasOption('assets', 'css'))
            {{-- begin::Global Stylesheets Bundle(used by all pages) --}}
            @foreach (array_unique(theme()->getOption('assets', 'css')) as $file)
                @if (strpos($file, 'plugins') !== false)
                    {!! preloadCss(assetCustom($file)) !!}
                @else
                    <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css"/>
                @endif
            @endforeach
            {{-- end::Global Stylesheets Bundle --}}
        @endif
    </head>
    <body id="kt_body" class="auth-bg">
        <!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - 404 Page-->
			<div class="d-flex flex-column flex-center flex-column-fluid p-10">
				<!--begin::Illustration-->
                @yield('image')
				<!--end::Illustration-->
				<!--begin::Message-->
                @yield('message')
				<!--end::Message-->
				<!--begin::Link-->
				<a href="{{ app('router')->has('home') ? route('home') : url('/') }}" class="btn btn-primary">{{ __('Go Home') }}</a>
				<!--end::Link-->
			</div>
		</div>
		<!--end::Root-->
    </body>
</html>
