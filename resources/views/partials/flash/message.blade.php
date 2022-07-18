@if (!Session::get('toast'))
    @if ($message = Session::get('success'))
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row w-100 p-5 mb-10">
            {!! theme()->getSvgIcon('icons/duotune/general/gen048.svg', 'svg-icon-2hx svg-icon-light me-4') !!}
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <h4 class="mb-2 text-light">{{ $message }}</h4>
            </div>
            <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
                {!! theme()->getSvgIcon('icons/duotune/arrows/arr061.svg', 'svg-icon-2x svg-icon-light') !!}
            </button>
        </div>
        <!--end::Alert-->
    @endif



    @if ($message = Session::get('error'))
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10">
            {!! theme()->getSvgIcon('icons/duotune/general/gen048.svg', 'svg-icon-2hx svg-icon-light me-4') !!}
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <h4 class="mb-2 text-light">{{ $message }}</h4>
            </div>
            <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
                {!! theme()->getSvgIcon('icons/duotune/arrows/arr061.svg', 'svg-icon-2x svg-icon-light') !!}
            </button>
        </div>
        <!--end::Alert-->
    @endif



    @if ($message = Session::get('warning'))
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row w-100 p-5 mb-10">
            {!! theme()->getSvgIcon('icons/duotune/general/gen048.svg', 'svg-icon-2hx svg-icon-light me-4') !!}
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <h4 class="mb-2 text-light">{{ $message }}</h4>
            </div>
            <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
                {!! theme()->getSvgIcon('icons/duotune/arrows/arr061.svg', 'svg-icon-2x svg-icon-light') !!}
            </button>
        </div>
        <!--end::Alert-->
    @endif



    @if ($message = Session::get('info'))
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-info d-flex flex-column flex-sm-row w-100 p-5 mb-10">
            {!! theme()->getSvgIcon('icons/duotune/general/gen048.svg', 'svg-icon-2hx svg-icon-light me-4') !!}
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <h4 class="mb-2 text-light">{{ $message }}</h4>
            </div>
            <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
                {!! theme()->getSvgIcon('icons/duotune/arrows/arr061.svg', 'svg-icon-2x svg-icon-light') !!}
            </button>
        </div>
        <!--end::Alert-->
    @endif



    @if ($errors->any())
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10">
            {!! theme()->getSvgIcon('icons/duotune/general/gen048.svg', 'svg-icon-2hx svg-icon-light me-4') !!}
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <h4 class="mb-2 text-light">{{ $errors->first() }}</h4>
            </div>
            <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
                {!! theme()->getSvgIcon('icons/duotune/arrows/arr061.svg', 'svg-icon-2x svg-icon-light') !!}
            </button>
        </div>
        <!--end::Alert-->
    @endif
@endif
