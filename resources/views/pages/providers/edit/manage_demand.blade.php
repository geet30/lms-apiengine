<!--begin::Main column-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <form role="form" id="manage_demand_form" class="manage_demand_form" name="manage_demand_form">
        @csrf
        <!--begin::General options-->
        <div class="card card-flush py-4">
            <!--begin::Card body-->
            <div class="card-body px-8">
                <!--begin::Input group-->
                <div class="row mb-3">
                    <!--begin::Label-->
                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="If demand calculation is allowed, plan details will show demand rates. If demand calculation is not allowed, then plan details will not show demand calculation.">
                        <label class="col-lg-4 fw-bold fs-6">Do you want to enable demand calculation?</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-8">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <!-- <input type="hidden" name="manage_demand_status" value="1"> -->
                                <input class="form-check-input" name="manage_demand_status" type="radio" value="1" checked />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <!-- <input type="hidden" name="manage_demand_status" value="0"> -->
                                <input class="form-check-input" name="manage_demand_status" type="radio" value="0" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                        </div>
                    </span>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <div class="card-footer px-8  pt-0">
                <!--begin::Actions-->
                <div class="pull-right">
                    <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="manage_demand_submit" class="btn btn-primary">
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

