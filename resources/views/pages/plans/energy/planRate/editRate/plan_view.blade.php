<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Plan View</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Input group-->


            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Discount</label>

                <div class="col-lg-8 fv-row">
                <textarea name="dicunt" class="form-control form-control-lg form-control-solid " value=""></textarea>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Bonus</label>

                <div class="col-lg-8 fv-row">
                <textarea name="bonus" class="form-control form-control-lg form-control-solid " value=""></textarea>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Contract</label>

                <div class="col-lg-8 fv-row">
                <textarea name="contract" class="form-control form-control-lg form-control-solid " value=""></textarea>
                </div>
            </div>

            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Exit Fee</label>

                <div class="col-lg-8 fv-row">
                <textarea name="exit_fee" class="form-control form-control-lg form-control-solid " value=""></textarea>
                </div>
            </div>
            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Benefit Terms</label>

                <div class="col-lg-8 fv-row">
                <textarea name="benefit_terms" row="10" class="form-control form-control-lg form-control-solid " value=""></textarea>
                </div>
            </div>





            <!--end::Input group-->
        </div>
        <!--end::Card header-->
        <div class="d-flex justify-content-start">
                            <!--begin::Button-->
                            <a href="{{ theme()->getPageUrl('provider/plans/energy/plan-rates/'.encryptGdprData($editRate['plan_id']))}}" id="" class="btn btn-light me-5">Cancel</a>
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


    <!--end::Pricing-->
</div>
