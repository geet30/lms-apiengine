<!--begin::Card header-->
<div class="card-header align-items-center py-0 gap-2 gap-md-1 px-8 border-0">
    <!--begin::Card toolbar-->
    <div class="card-title">
        <form role="form" name="affiliate_filters" id="affiliate_template_filters" accept-charset="UTF-8" class="">

            <div class="d-flex align-items-center position-relative gap-5 my-1">
                <input type="hidden" id="users_id" name="users_id" value="{{$affiliate_id}}">
                <select id="select_source" class="form-control form-control-solid form-select w-180px" name="select_source">
                    <option value="1" selected>Email</option>
                    <option value="2">Sms</option>
                </select>
                <?php
                   $userPermissions = getUserPermissions(); 
                   $appPermissions = getAppPermissions();
                   //dd($appPermissions);
                ?>
                <select class="form-control form-control-solid form-select w-160px" id="select_email_type" name="select_email_type">
                @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_templates',$userPermissions,$appPermissions) && checkPermission('affiliate_welcome_template',$userPermissions,$appPermissions))
                    <option value="1" selected>Welcome</option>
                @endif    
                @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_templates',$userPermissions,$appPermissions) && checkPermission('affiliate_remarketing_template',$userPermissions,$appPermissions))
                    <option value="2">Remarketing</option>
                @endif 
                @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_templates',$userPermissions,$appPermissions) && checkPermission('affiliate_2way_sms_template',$userPermissions,$appPermissions))   
                    <option value="3" disabled>2-way-Confirmation</option>
                @endif 
                @if(checkPermission('show_affiliates',$userPermissions,$appPermissions) && checkPermission('affiliate_templates',$userPermissions,$appPermissions) && checkPermission('affiliate_send_plan_template',$userPermissions,$appPermissions))   
                    <option value="4">Send Plan</option>
                @endif    
                </select>
                <select class="form-control form-control-solid form-select w-160px" id="select_welcome_email_type" name="service_email_sms_type">
                    @foreach ($services as $service)
                    <option value="{{$service->service_id}}">{{$service->service_title}}</option>
                    @endforeach
                </select>
                <select class="form-control form-control-solid form-select w-150px" id="template_type_energy" name="template_type">
                </select>
                <button type="button" class="btn btn-light btn-active-light-primary me-2 reset-button" data-kt-menu-dismiss="true">{{trans('affiliates.reset')}}</button>
            </div>
        </form>
    </div>
    <div class="card-toolbar flex-row-fluid justify-content-end gap-5 show_error">
        <button type="button" class="btn btn-primary px-3 mt-5" id="filter_emai_sms_button">{{trans('affiliates.apply_filter')}}</button>
        <a id="change_url" href="" id="add_url_email" class="btn btn-primary mt-5">{{trans('affiliates.add')}}</a>
    </div>
</div>