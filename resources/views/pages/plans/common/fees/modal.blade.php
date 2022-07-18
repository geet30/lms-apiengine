<div class="modal fade" id="add_fees_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder" id="add_fees_modal_heading">{{__('plans/broadband.fees_add')}}</h2> 
                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span> 
                </div> 
            </div> 
            <form id="add_fees_form" class="form">
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <input type="hidden" name="id"  value="" /> 
                <input type="hidden" name="action" value="" />
                <input type="hidden" name="service_id" value="{{$serviceType}}" id="plan_fees_service_id"/>
                <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                    @csrf
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold  required form-label mb-5">{{__('plans/broadband.fees.label')}}</label>
                        <select name="fee_id" aria-label="{{__('plans/broadband.fees.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.fees.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg fee_id_select_class"> 
                        </select>
                        <span class="error text-danger"></span>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold required form-label mb-5">{{__('plans/broadband.fees_cost_type.label')}}</label>
                        <select name="cost_type" aria-label="{{__('plans/broadband.fees_cost_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.fees_cost_type.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg form-custom">
                            @foreach($costTypes as $costType)
                                <option value="{{ $costType->id }}">{{ $costType->cost_name}} </option>
                            @endforeach
                        </select>
                        <span class="error text-danger"></span>
                    </div>
                    
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold required form-label mb-5">{{__('plans/broadband.fees_amount.label')}}</label>
                        <input type="text" name="amount" class="form-control form-control-lg form-control-solid" placeholder="{{__('plans/broadband.fees_amount.placeholder')}}" value="" />
                        <span class="error text-danger"></span>
                    </div> 
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold form-label mb-5">{{__('plans/broadband.additional_info.label')}}</label>
                        <textarea name="additional_info" id="additional_info" class="form-control form-control-lg form-control-solid ckeditor" ></textarea>
                        <span class="error text-danger"></span>
                    </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('plans/broadband.discard_button')}}</button> 
                <button type="submit" class="btn btn-primary fees_submit_btn" data-title="Fees">{{__('plans/broadband.save_changes_button')}}</button>
            </div>

            </form>
        </div>
    </div>
</div>