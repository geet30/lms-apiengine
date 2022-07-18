@if (Session::get('toast'))
<script>
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toastr-top-right",
    "preventDuplicates": false,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    };
</script>
@if ($message = Session::get('success'))
    <!--begin::Alert-->
    <script>
        toastr.success('{{ $message }}');
    </script>
    <!--end::Alert-->
@endif

@if ($message = Session::get('error'))
    <!--begin::Alert-->
    <script>
        toastr.error('{{ $message }}');
    </script>
    <!--end::Alert-->
@endif

@if ($message = Session::get('warning'))
    <!--begin::Alert-->
    <script>
        toastr.warning('{{ $message }}');
    </script>
    <!--end::Alert-->
@endif

@if ($message = Session::get('info'))
    <!--begin::Alert-->
    <script>
        toastr.info('{{ $message }}');
    </script>
    <!--end::Alert-->
@endif

@if ($errors->any())
    <!--begin::Alert-->
    <script>
        toastr.error('{{ $errors->first() }}');
    </script>
    <!--end::Alert-->
@endif
<script>
    $('#toast-container').addClass('nopacity');
</script>
@endif
