<div class="card" style="border-bottom:1px solid #eff2f5;">
    <div class="card-header align-items-center border-0">
            <div class="card-title">
                    <div class="d-flex align-items-center position-relative gap-5 my-1"> 
                        <select data-control="select2" data-placeholder="Select Service" data-hide-search="true" name="service_id[]" id="select_service" class="form-select form-select-solid select2-hidden-accessible w-250px service_type" multiple tabindex="-1" aria-hidden="true">
                        <option></option>
                        <?php $services = explode(',', $user->permission_services) ?>
                        @foreach($allServices as $service)
                            <option value="{{$service->id}}" <?php if(in_array($service->id, $services)) echo'selected'; ?>>{{$service->service_title}}</option> 
                        @endforeach
                        </select> 
                        
                        <select data-control="select2" data-placeholder="Select Template" data-hide-search="true" name="permission_template" id="select_template" class="form-select form-select-solid select2-hidden-accessible w-250px" tabindex="-1" aria-hidden="true">
                        <option>Select Template</option>
                        @foreach($templates as $key=>$value)
                            <option value="{{$key}}" <?php if($user->permission_template == $key) echo'selected'; ?>>{{$value}}</option> 
                        @endforeach
                        </select> 
                        <button type="button" class="btn btn-primary reset_all" id="reset_permissions">Reset</button>
                    </div>  
            </div>
    </div>
</div>