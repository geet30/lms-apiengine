<div class="tab-pane fade" id="addons" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{__('plans/broadband.addons')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_plan_info" class="collapse show">
                
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10 border-top">
                    <div class="card-body pt-9 pb-0">
                             
                        <!--begin::Navs-->
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                            <li class="nav-item  mt-2">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#phone_home_line_connection">{{__('plans/broadband.phone_home_line_connection')}}</a>
                            </li>
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#modem_connection">
                                {{__('plans/broadband.modem')}}
                                </a>
                            </li>
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#addon_connection">
                                {{__('plans/broadband.addon')}}
                                </a>
                            </li>
                                
                        </ul>
                        <!--begin::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->
                <!--begin::Basic info-->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="phone_home_line_connection" role="tab-panel">  
                        <form class="form" id="other_addon_home_connection_form">
                            <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                            <input type='hidden' name='category' value="3">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <div class="pt-0 table-responsive">
                                    <!--begin::Table-->
                                    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="lead_data_table"> 
                                        <tbody class="fw-bold text-gray-600" id="other-addon-home-tbody">  
                                            @foreach($otherAddons['homeConnection'] as $connection)
                                                <tr>
                                                    <td>
                                                        <div class="row mb-2 mt-3"> 
                                                            <div class="col-lg-1 fv-row connection_allow">
                                                                <label class="form-check form-check-inline form-check-solid me-5">
                                                                    <input class="form-check-input" name="addon_id[]" type="checkbox" value="{{$connection['id']}}" {{$connection['exist'] == 1?'checked':''}}>
                                                                    
                                                                </label> 
                                                            </div>
                                                            <label class="col-lg-6 fw-bold fs-6">{{$connection['name']}}</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                                <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                            </div>
                        </form>     
                    </div>
                    <div class="tab-pane fade" id="modem_connection" role="tab-panel">
                        <form id="other_addon_modem_form" class="form">
                            <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                            <input type='hidden' name='category' value="4">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9" id="other-addon-modem-tbody">  
                                @foreach($otherAddons['modem'] as $connection)          
                                <div class="row mb-2 mt-3 border pt-2 pb-2"> 
                                    <div class="col-lg-4"> 
                                        <div class="row mb-2 mt-3"> 
                                            <div class="col-lg-1 fv-row connection_allow">
                                                <label class="form-check form-check-inline form-check-solid me-5">
                                                    <input class="form-check-input other-modem-checkbox-display" name="addon_id[{{$connection['id']}}]" type="checkbox" value="{{$connection['id']}}" {{$connection['exist'] == 1?'checked':''}}>
                                                </label>
                                            </div>
                                            <label class="col-lg-6 fw-bold fs-6">{{$connection['name']}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 other-modem-checkbox-hide {{$connection['exist'] == 0?'d-none':''}}"> 
                                        <select name="cost_type[{{$connection['id']}}]" aria-label="{{__('plans/broadband.addon_cost_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.addon_cost_type.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg"> 
                                            @foreach($costTypes as $costType) 
                                                <option value="{{ $costType->id }}" {{($connection['cost_type_id'] == $costType->id)?'selected':''}}>{{ $costType->cost_name}} </option>
                                            @endforeach
                                        </select>

                                        <input type="text" name="amount[{{$connection['id']}}]" class="form-control form-control-lg form-control-solid mt-2" placeholder="{{__('plans/broadband.addon_cost.placeholder')}}" value="{{$connection['price']}}" />
                                    </div>  
                                    <div class="col-lg-4 other-modem-checkbox-hide {{$connection['exist'] == 0?'d-none':''}}"> 
                                        <textarea type="text" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="script[{{$connection['id']}}]" style="display: none;">{{$connection['script']}}</textarea>
                                    </div>   
                                </div>
                                @endforeach 
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                                <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                            </div>
                        </form>  
                    </div>
                    <div class="tab-pane fade" id="addon_connection" role="tab-panel">
                        <form class="form" id="other_addon_addons_form">
                            <input type='hidden' name='plan_id' value="{{isset($plan)?encryptGdprData($plan->id):''}}">
                            <input type='hidden' name='category' value="5">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9" id="other-addon-addons-tbody">  
                                @foreach($otherAddons['addon'] as $connection)
                                <div class="row mb-2 mt-3  border pt-2 pb-2"> 
                                    <div class="col-lg-4"> 
                                        <div class="row mb-2 mt-3"> 
                                            <div class="col-lg-1 fv-row connection_allow">
                                                <label class="form-check form-check-inline form-check-solid me-5">
                                                    <input class="form-check-input other-addon-checkbox-display" name="addon_id[{{$connection['id']}}]" type="checkbox" value="{{$connection['id']}}" {{$connection['exist'] == 1?'checked':''}}>
                                                </label>
                                            </div>
                                            <label class="col-lg-6 fw-bold fs-6">{{$connection['name']}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 other-addon-checkbox-hide {{$connection['exist'] == 0?'d-none':''}}"> 
                                        <select name="cost_type[{{$connection['id']}}]" aria-label="{{__('plans/broadband.addon_cost_type.placeholder')}}" data-control="select2" data-placeholder="{{__('plans/broadband.addon_cost_type.placeholder')}}" class="form-select form-select-sm form-select-solid form-select-lg cost_type_field_addon"> 
                                            @foreach($costTypes as $costType)
                                                <option value="{{ $costType->id }}" {{($connection['cost_type_id'] == $costType->id)?'selected':''}}>{{ $costType->cost_name}} </option>
                                            @endforeach
                                        </select>

                                        <input type="text" name="amount[{{$connection['id']}}]" class="form-control form-control-lg form-control-solid mt-2 amount_field_addon" placeholder="{{__('plans/broadband.addon_cost.placeholder')}}" value="{{$connection['price']}}" />
                                    </div>  
                                    <div class="col-lg-4 other-addon-checkbox-hide {{$connection['exist'] == 0?'d-none':''}}"> 
                                        <textarea type="text" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="script[{{$connection['id']}}]" style="display: none;">{{$connection['script']}}</textarea>
                                    </div>   
                                </div>
                                @endforeach 
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2" href="{{$cancelButtonUrl}}">{{__('plans/broadband.discard_button')}}</a>
                                <button type="submit" class="btn btn-primary">{{__('plans/broadband.save_changes_button')}}</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
         
    </div>
</div>