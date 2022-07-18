<!--begin::Main column-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="footer_content_form" class="footer_content_form" name="footer_content_form">
        @csrf
        <!--begin::General options-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body px-8">
                <!--begin::Input group-->
                <div class="row mb-5">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label fw-bold fs-6">Footer Content:</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 fv-row">
                        <textarea type="text" id="pop_up_text" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="footer_content">{{$footer_content["description"]??''}}</textarea>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="footer_content_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Actions-->
            </div>
        </div>
        <!--end::Pricing-->
    </form>
</div>
<!--end::Main column-->

