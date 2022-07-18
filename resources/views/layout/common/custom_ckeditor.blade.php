<!--begin::Scrolltop-->
<script src="/common/plugins/custom/ckeditor-standard/ckeditor.js"></script>
<script>
    function ckEditoCustomSettings() {
        CKEDITOR.config.toolbar = [
                ['Bold','Italic','Underline','NumberedList','BulletedList','Link','Unlink'],
                ] ;
        CKEDITOR.config.baseFloatZIndex = 102000;
        CKEDITOR.config.height = 100; 
        CKEDITOR.config.resize_enabled = false;
        CKEDITOR.config.uiColor = '#ffffff';
    }
    ckEditoCustomSettings();
</script>
