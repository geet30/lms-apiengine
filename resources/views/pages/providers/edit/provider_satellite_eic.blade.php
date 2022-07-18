<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="satellite_eic_form" class="satellite_eic_form" name="satellite_eic_form">
        @csrf
        <!--begin::General options-->
        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body px-8">
                <!--begin::Input group-->
                <div class="row mb-3">
                    <!--begin::Label-->
                    <label class="col-lg-6 required fw-bold fs-6">Does this section require satellite EIC to be enabled?</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-6 satellite_eic_status">
                        <label class="form-check form-check-inline form-check-solid me-5">
                            <!-- <input type="hidden" name="satellite_eic_status" value="1"> -->
                            <input class="form-check-input" name="satellite_eic_status" type="radio" value="1" {{isset($satellite_eic["status"]) && $satellite_eic["status"] ? 'checked' : ''}} />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('Yes') }}
                            </span>
                        </label>
                        <!--end::Option-->

                        <!--begin::Option-->
                        <label class="form-check form-check-inline form-check-solid">
                            <!-- <input type="hidden" name="satellite_eic_status" value="0"> -->
                            <input class="form-check-input" name="satellite_eic_status" type="radio" value="0" {{isset($satellite_eic["status"]) && $satellite_eic["status"] ? '' : 'checked'}} />
                            <span class="fw-bold ps-2 fs-6">
                                {{ __('No') }}
                            </span>
                        </label>
                        <p><span class="error text-danger"></span></p>
                    </div>
                    <!--end::Input-->
                </div>
                <div class="row mb-3">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label required fw-bold fs-6">Description:</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 satellite_eic_description">
                        <textarea type="text" id="satellite_eic_description" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="satellite_eic_description">{{$satellite_eic["description"] ?? ''}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <div class="card-footer px-8 pt-0">
                <div class="pull-right">
                    <!--begin::Button-->
                    <a href="../../demo8/dist/apps/ecommerce/catalog/products.html" id="" class="btn btn-light me-5">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
        </div>
        <!--end::Pricing-->
    </form>
</div>
