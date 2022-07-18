<x-base-layout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Form-->
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="../../demo8/dist/apps/ecommerce/catalog/products.html">

                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <!--begin::General options-->
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="my-3">
                                    <a href="list" id="provider" class="btn btn-primary me-3 float-md-end" >back</a>
                                </div>
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Account Details</h2>
                                    </div>
                                </div>            
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Service:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="checkbox" class="" id="1" name="service_type[]" value="1"> Energy
                                        <input type="checkbox" class="" id="2" name="service_type[]" value="2"> Mobile
                                        <input type="checkbox" class="" id="3" name="service_type[]" value="3"> Broadband
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Business Name:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control d-md-inline-flex w-md-50" placeholder="Enter Business Name" name="business_name" tabindex="1" maxlength="100" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Legal Name:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control d-md-inline-flex w-md-50" placeholder="Enter Legal Name" name="legal_name" tabindex="2" >
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">ABN/ ACN:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control d-md-inline-flex w-md-50" placeholder="Enter ABN/ ACN" name="abn" tabindex="3" >
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Email:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control d-md-inline-flex w-md-50" placeholder="Enter Email" name="email" tabindex="4" >
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Support Email (Optional):</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control d-md-inline-flex w-md-50" placeholder="Enter Support Email" name="support_email" tabindex="5" >
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Escalation Email (Optional):</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control d-md-inline-flex w-md-50" placeholder="Enter Escalation Email" name="complaint_email" tabindex="6" >
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Contact Number:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control d-md-inline-flex w-md-50" placeholder="Enter Contact Number" name="contact_no" tabindex="7"  >
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Address:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea class="form-control d-md-inline-flex w-md-50" tabindex="8" placeholder="Enter Address" rows="2" name="address"></textarea>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-4">
                                        <!--begin::Label-->
                                        <label class="fs-5 mb-5 col-5">Description (Optional):</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea class="form-control d-md-inline-flex w-md-50" tabindex="9" placeholder="Enter Description" rows="2" name="description" id="description"></textarea>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--begin::Actions-->
                                <div class="text-center">
                                    <a type="reset" href="list" class="btn btn-light me-3">Discard</a>
                                    <button type="submit" id="add_provider" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->

                            </div>
                            <!--end::Pricing-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
</x-base-layout>

