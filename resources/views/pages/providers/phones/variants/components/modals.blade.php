<div class="modal fade" id="vhaCodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">Update SKU Code For Variant: <strong><span id="variantname"></span></strong></h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">
                <div class="alert-danger VHA_code_warning" style="padding: 15px;margin-bottom: 15px;border: 1px solid;border-radius: 4px;">
                    Please enter SKU code first to enable variant.
                </div>
                <form id="vha_code_form" name="add_update_apikeyform" accept-charset="UTF-8" class="form submit_apikey_form pb-0">
                <input type="hidden" name="variant_id" id="variantid" readonly="">
                <input type="hidden" name="handset_id" id="handset_id" value="{{$handsetId}}" readonly="">
                <input type="hidden" name="provider_id" id="provider_id" value="{{$providerId}}" readonly="">
                <input type="hidden" name="provider_variant_table_id" id="provider_variant_table_id" value="">
                <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label required">SKU Code</label>
                            <input type="text" name="vha_code" class="form-control" id="vha_code" placeholder="Enter SKU Code">
                            <span class="text-danger errors"></span>
                        </div>
                    </div> 
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                        <button type="submit" id="submit_apikeydata" class="btn btn-primary">
                            <span class="indicator-label">{{ __('buttons.save') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
<div class="modal fade" id="viewVariantImagesModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">Variant Images: </h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">  
                    <div class="row"> 
                        <table class="table table-striped table-bordered"> 
                        <tr>
                            <td class="td_var_images"></td>
                        </tr>
                        </table>
                    </div>
                    <!-- <div class="text-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button> 
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>
 
 
        
<div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
    <div class="modal fade" id="imagemodal" tabindex="1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-350px">
            <div class="modal-content">
                <img src="" class="img_src" st>
            </div>
        </div>
    </div>
</div>