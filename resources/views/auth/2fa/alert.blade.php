<script>
    Swal.fire({
        title: "{{ __('2fa.backup_recovery_code') }}", 
        html: "{{ __('2fa.recovery_code_startup_note') }}",
        confirmButtonText: '<form action="/2fa/download-recovery-codes" method="post">{{ csrf_field() }}<button type="submit" style="color: white;background: transparent;border: 0px;">{{ __("2fa.download") }}</button></form>',
        allowOutsideClick: false,
    });
</script>
