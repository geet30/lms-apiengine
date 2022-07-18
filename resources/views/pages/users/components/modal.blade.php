<div class="modal fade" id="add_user_form_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <form id="add_user_form" class="form">
                <div class="modal-header" id="">
                    <h2 class="fw-bolder title add_edit_user_title">Add User</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                                </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                <input type="hidden" name="id"  value="" /> 
                <input type="hidden" name="action" value="" /> 
                    <div class="row">
                        <label class="col-12 col-form-label fw-bold fs-6 required">First Name:</label>
                        <div class="col-12 fv-row field-holder">
                            <input type="text" name="first_name" class="form-control form-control-lg form-control-solid" placeholder="e.g. Steve"> 
                            <span class="errors text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-12 col-form-label fw-bold fs-6 required">Last Name:</label>
                        <div class="col-12 fv-row field-holder">
                            <input type="text" name="last_name" class="form-control form-control-lg form-control-solid"  placeholder="e.g. Waugh"> 
                            <span class="errors text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-12 col-form-label fw-bold fs-6 required">Email:</label>
                        <div class="col-12 fv-row field-holder">
                            <input type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="e.g. steve.waugh@gmail.com"> 
                            <span class="errors text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-12 col-form-label fw-bold fs-6">Phone</label>
                        <div class="col-12 fv-row field-holder">
                            <input type="text" name="phone" class="form-control form-control-lg form-control-solid" placeholder="e.g. 9999999999"> 
                            <span class="errors text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-12 col-form-label fw-bold fs-6 required">Service:</label>
                        <div class="col-12 fv-row field-holder">
                                <select name="service[]"   data-control="select2" data-placeholder="e.g. Energy" class="form-select form-select-solid form-select-lg" id="serviceField" multiple="multiple">  
                                    <option></option>  
                                    @foreach($services as $service)
                                        <option value="{{$service->id}}">{{$service->service_title}}</option>
                                    @endforeach
                                </select>
                            <span class="errors service_errors text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-12 col-form-label fw-bold fs-6 required">Role:</label>
                        <div class="col-12 fv-row field-holder">
                                <select class="form-control form-control-solid form-select userservice p-4" id="roleField" name="role" data-placeholder="Select Role" data-control="select2">
                                <option></option>  
                                @foreach($roles as $key => $value)
                                    <option value="{{$key}}">{{getModifyRoleName($key)}}</option>
                                @endforeach
                                </select>
                            <span class="errors text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right">
                    <button type="reset" id="kt_modal_assigned_user_cancel2" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                    <button type="submit" class="btn btn-primary" data-form="master_life_support_form">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
 