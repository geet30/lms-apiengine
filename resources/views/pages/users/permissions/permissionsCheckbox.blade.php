<style>
    .checker
    {
        width: 200px;
    }
    .tab-content>.active { 
        padding: 25px;
    }
</style>
    <?php $tab= 0; ?>
    @foreach($allPermission as $main_permissions)
        <div class="tab-pane show row gy-5 gx-xl-8 {{$tab == 0 ?'active' :''}} tab_{{$main_permissions[2]}}_content" id="tab_{{$main_permissions[1]}}" role="tab-panel">
            <div class="permission_main_section"> 
                <div class="row mb-2 pb-3">
                    <div class="col-lg-12">
                        <label class="checkbox-inline">
                            <div class="checker">
                                <input class="permission_main_checkbox" type="checkbox" name="template_permission[]" value="{{ $main_permissions[1] }}" id="{{ $main_permissions[1] }}" {{in_array($main_permissions[1], $assignPermissions) ? 'checked':'' }} >
                                <b>{{ $main_permissions[0] }}</b>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-lg-10" style="margin-left: 15%;">
                    @foreach($main_permissions[3] as $sub_permission)  
                        <div class="{{$sub_permission[2]}}_service_sub_heading main">
                            <div class="heading pb-2">
                                <label class="checkbox-inline">
                                    <div class="checker"> 
                                        {{ Form::checkbox('template_permission[]', $sub_permission[1], in_array($sub_permission[1], $assignPermissions) ? true : false, array('class' => 'name','id' => $sub_permission[1])) }} 
                                        <b>
                                        {{ $sub_permission[0]}}
                                        </b>
                                    </div>
                                </label>
                            </div>
                            <div class="checkbox-list pb-5 px-5"> 
                             @foreach($sub_permission[3] as $key => $value) 
                                    <label class="checkbox-inline" style="vertical-align: top">
                                        <div class="checker">
                                            {{ Form::checkbox('template_permission[]', $value[1], in_array($value[1], $assignPermissions) ? true : false, array('class' => 'name '.$value[2].'_service','id' => $value[1])) }}
                                            {{$value[0]}}
                                        </div>
                                    </label> 
                                @endforeach
                            </div>
                        </div>  
                    @endforeach 
                </div>    
                @if($main_permissions[1] == 'show_users')
                            <label class="col-md-3" style="margin-top: 10px">
                                <b>Select roles for above permissions</b>
                            </label>
                            <div class="col-md-9 field-holder">
                                <div class="heading">
                                    <select data-control="select2" data-placeholder="Select Permission" data-hide-search="true" name="template_permission[]" class="form-select form-select-solid select2-hidden-accessible w-250px users_select" multiple tabindex="-1" aria-hidden="true"> 
                                                    <option id="users_assign_admin_permission" value="users_assign_admin_permission" @if(in_array('users_assign_admin_permission', $assignPermissions)) selected @endif >Admin</option> 
                                                    <option id="users_assign_qa_permission" value="users_assign_qa_permission" @if(in_array('users_assign_qa_permission', $assignPermissions)) selected @endif >QA</option> 
                                                    <option id="users_assign_bdm_permission" value="users_assign_bdm_permission" @if(in_array('users_assign_bdm_permission', $assignPermissions)) selected @endif >BDM</option> 
                                                    <option id="users_assign_accountant_permission" value="users_assign_accountant_permission" @if(in_array('users_assign_accountant_permission', $assignPermissions)) selected @endif >Accountant</option> 
                                        </select> 
                                </div>
                            </div>
                            @endif
            </div> 
        </div>
        <?php $tab++; ?>
    @endforeach