@php
    $breadcrumb = bootstrap()->getBreadcrumb();
@endphp

<!--begin::Page title-->
<div class="page-title d-flex flex-column me-5">
    <!--begin::Title-->
    <h1 class="d-flex flex-column text-dark fw-bolder  mb-0" id="breadcrumbs_custom_title">
        {{ theme()->getOption('page', 'title')??ucfirst(app('request')->segment(1)) }}
    </h1>
    <!--end::Title-->

    @if ( !empty($breadcrumb) )
    <nav aria-label="breadcrumb">
        <!--begin::Breadcrumb-->
        <ol class="breadcrumb" id="custom_id_for_custom_breadcrumbs">
            @foreach ($breadcrumb as $item)
                <!--begin::Item-->
                @if ( $item['active'] === true )
                    <li class="breadcrumb-item text-dark">
                        {{ $item['title'] }}
                    </li>
                @else
                    <li class="breadcrumb-item text-muted">
                        @if ( ! empty($item['path']) )
                            <a href="{{ theme()->getPageUrl($item['path']) }}" class="text-muted text-hover-primary">
                                {{ $item['title'] }}
                            </a>
                        @else
                            {{ $item['title'] }}
                        @endif
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
        <!--end::Breadcrumb-->
    @else
    <nav aria-label="breadcrumb">
        <!--begin::Breadcrumb-->
        <ol class="breadcrumb" id="custom_id_for_custom_breadcrumbs">
        </ol>
    </nav>
    @endif
</div>
<!--end::Page title-->
