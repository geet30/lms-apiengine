<div class="modal fade" id="add_provider_ack_checkbox" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">{{__('plans/broadband.acknowledgement_checkbox')}}</h2> 
                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                    
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span> 
                </div> 
            </div>
            <form id="provider_ackn_checkbox_form" class="form" action="#">
            <input type="hidden" name="checkbox_id"  value="" /> 
            <input type="hidden" name="action" value="" /> 
            <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
            <div class="modal-body scroll-y">

                    <div class="row mb-2">
                        <label class="col-lg-4 fw-bold fs-6 mb-5">{{__('plans/broadband.checkbox_required.label')}}</label> 
                        <div class="col-lg-8 ackn_checkbox_required">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input" name="required" type="radio" value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                {{__('plans/broadband.yes')}}
                                </span>
                            </label>
                            <label class="form-check form-check-inline form-check-solid">
                                <input class="form-check-input" name="required" type="radio" value="0" />
                                <span class="fw-bold ps-2 fs-6">
                                {{__('plans/broadband.no')}}
                                </span>
                            </label>
                            <p>
                                <span class="error text-danger required-error"></span>
                            </p>
                        </div> 
                    </div> 
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label fw-bold fs-6 mb-5">{{__('plans/broadband.ack_form_save_checkbox_status_in_database.label')}}</label> 
                        <div class="col-lg-8 ackn_checkbox_status_save">
                            <label class="form-check form-check-inline form-check-solid me-5"> 
                                <input class="form-check-input" name="status" type="radio" value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                {{__('plans/broadband.yes')}}
                                </span>
                            </label> 
                            <label class="form-check form-check-inline form-check-solid">
                                
                                <input class="form-check-input" name="status" type="radio" value="0" />
                                <span class="fw-bold ps-2 fs-6">
                                {{__('plans/broadband.no')}}
                                </span>
                            </label>
                            <p>
                                <span class="error text-danger status-error"></span>
                            </p>
                        </div>
                    </div> 
                    <div class=" mb-2"> 
                        <label class="col-lg-12 col-form-label fw-bold fs-6 mb-5">{{__('plans/broadband.ack_form_validation_message.label')}}</label>
                         
                        <div class="col-lg-12 ackn_validation_msg">
                            <textarea type="text" id="ackn_validation_msg" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="3" name="validation_message"></textarea>
                            <span class="error text-danger"></span>
                        </div> 
                    </div>
                     
                    <div class="mb-2">
                        <label class="col-lg-12 col-form-label required fw-bold fs-6 mb-5">{{__('plans/broadband.ack_form_content.label')}}</label>
                        <div class="col-lg-12 ackn_checkbox_content">
                            <textarea type="text" id="ackn_checkbox_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="3" name="checkbox_content"></textarea>
                            <span class="error text-danger"></span>
                        </div> 
                    </div>
                     
            </div>
            
            <div class="text-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('plans/broadband.discard_button')}}</button>
                <button type="submit"  class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_terms_and_condition_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h2 class="fw-bolder fs-12 text-white">Terms and Conditions</h2> 
                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                    
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span> 
                </div> 
            </div> 
            <form id="edit_terms_and_condition_form" class="form">
            <div class="modal-body scroll-y">
                    <input type="hidden" name="id" id="term_id" value="" /> 
                    <div class=" mb-2"> 
                        <label class="col-lg-12 required col-form-label fw-bold fs-6 mb-5">{{__('plans/broadband.title')}}</label>
                        <div class="col-lg-12 ackn_validation_msg">
                            <input type="text" name="title" class="form-control form-control-lg form-control-solid" id="term_title" placeholder="Title" value="" /> 
                            <span class="error text-danger"></span>
                        </div> 
                    </div>
                     
                    <div class=" mb-2">
                        <label class="col-lg-12 col-form-label fw-bold fs-6 mb-5">{{__('plans/broadband.content')}}</label>
                        <div class="col-lg-12 term_title_content">
                            <textarea type="text" id="term_title_content" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="3" name="term_title_content"></textarea>
                            <span class="error text-danger"></span>
                        </div> 
                    </div>
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('plans/broadband.discard_button')}}</button> 
                <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
            </div>

            </form>
        </div>
    </div>
</div>