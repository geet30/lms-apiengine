<form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="../../demo8/dist/apps/ecommerce/catalog/products.html">

    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
        <div class="d-flex flex-column gap-7 gap-lg-10">
            <!-- Start section's -->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header row">
                    <div class="card-title col-md-6 m-0">
                        <h3 class="fw-bolder m-0">Manage Movein Grace Period and Content </h3>
                    </div>
                    <div class="card-toolbar col-md-6 row">
                        <div class="col-6 pe-3">
                            <select data-control="select2" class="form-select form-control-solid" name="move_in_energy_type" id="move_in_energy_type">
                                <option value="1" class="">Electricity</option>
                                <option value="2" class="">Gas</option>
                            </select>
                        </div>
                        <div class="col-6 p-0">
                            <select data-control="select2" class="form-select form-control-solid" name="move_in_elec_distributor" id="move_in_elec_distributor">
                                <option value="0">Other distributor(Default)</option>
                                @foreach($distributors['distributor'] as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="sme_id" id="sme_id" value="{{isset($distributors['sme'][0]['id'])?$distributors['sme'][0]['id']:''}}">
                        <input type="hidden" name="residence_id" id="residence_id" value="{{isset($distributors['residence'][0]['id'])?$distributors['residence'][0]['id']:''}}">
                    </div>
                </div>
                <!--end::Card header-->

                <!--start::Card body-->
                <div class="card-body px-8 table-responsive">
                    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class mx-0 " id="provider_ackn_checkbox_table">
                        <thead>
                        <tr class="fw-bolder fs-6 text-gray-600 px-7">
                            <th class="text-capitalize text-nowrap">Distributor</th>
                            <th class="text-capitalize text-nowrap">Property Type</th>
                            <th class="text-capitalize text-nowrap">Energy Type</th>
                            <th class="text-capitalize text-nowrap">Days Interval</th>
                            <th class="text-capitalize text-nowrap">Cutt Off Time</th>
                            <th class="text-capitalize text-nowrap">Move-in Content</th>
                            <th class="text-capitalize text-nowrap">Move-in EIC Content</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600">
                        <tr>
                            <td id="selected_distributor">Other Distributor</td>
                            <td>SME</td>
                            <td class="td_energy_type">Electricity</td>
                            <td>
                                <select class="form-control form-control-lg form-control-solid service_id" name="day_interval_bussiness" id="day_interval_bussiness">
                                    <option value="">Please select</option>
                                    <?php
                                    $i = 0
                                    ?>
                                    @if(isset($distributors['sme'][0]['grace_day']))
                                        @while ($i<30) <option value="{{$i}}" @if($i==$distributors['sme'][0]['grace_day']) selected @endif>{{$i}}</option>
                                        {{$i++}}
                                        @endwhile
                                    @else
                                        @while ($i<30) <option value="{{$i}}" @if($i=='') selected @endif>{{$i}}</option>
                                        {{$i++}}
                                        @endwhile
                                    @endif


                                </select>
                            </td>
                            <td>
                                <input class="form-control mt-4 form-control-solid" id="restrict_bussiness_time" name="restrict_bussiness_time" type="text" readonly value="{{isset($distributors['sme'][0]['restricted_start_time'])?$distributors['sme'][0]['restricted_start_time']:'0:00'}}">
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="moveincontent" data-type="move_in_content" data-prop="2"><i class="fa fa-comment"></i></a>
                            </td>
                            <!-- ------- movin EIC content -------- -->
                            <td>
                                <a href="javascript:void(0)" class="moveincontent" data-type="move_in_eic_content" data-prop="2"><i class="fa fa-comment"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Residential</td>
                            <td class="td_energy_type">Electricity</td>
                            <td>
                                <select class="form-control form-control-lg form-control-solid service_id" name="day_interval_residence" id="day_interval_residence">
                                    <option value="">Please select</option>
                                    <?php
                                    $i = 0
                                    ?>
                                    @if(isset($distributors['residence'][0]['grace_day']))
                                        @while ($i<30) <option value="{{$i}}" @if($i==$distributors['residence'][0]['grace_day']) selected @endif>{{$i}}</option>
                                        {{$i++}}
                                        @endwhile
                                    @else
                                        @while ($i<30) <option value="{{$i}}" @if($i=='') selected @endif>{{$i}}</option>
                                        {{$i++}}
                                        @endwhile
                                    @endif
                                </select>
                            </td>
                            <td>
                                <input class="form-control mt-4 form-control-solid" id="restrict_residence_time" name="restrict_residence_time" type="text" readonly value="{{isset($distributors['residence'][0]['restricted_start_time'])?$distributors['residence'][0]['restricted_start_time']:'0:00'}}">
                            </td>
                            <!-- ------- movin content -------- -->
                            <td>
                                <a href="javascript:void(0)" class="moveincontent" data-type="move_in_content" data-prop="1"><i class="fa fa-comment"></i></a>
                            </td>
                            <!-- ------- movin EIC content -------- -->
                            <td>
                                <a href="javascript:void(0)" class="moveincontent" data-type="move_in_eic_content" data-prop="1"><i class="fa fa-comment"></i></a>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>
                <!--end::Card body-->
                <div class="card-footer text-end p-6">
                    <!--begin::Button-->
                    <a href="list" id="" class="btn btn-light me-5">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="grace_day" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <!-- End section's -->
            <!-- Start action -->

            <!-- End action -->
        </div>
    </div>
    <!--end::Main column-->
</form>
<!--end::Form-->
<!--begin::Modal - Adjust Balance-->
<!-- ------- Modal popup for movein content --------- -->
<!--begin::Modal - Adjust Balance-->
<div class="modal fade moveincontent_modal" data-bs-backdrop="static" data-bs-keyboard="false" id="moveincontent" tabindex="-1" aria-modal="true" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="row" style="margin-left:5px;margin-right:5px;">
                    <input type="hidden" id="modal_type"/>
                    <input type="hidden" id="move_in_content_value"/>
                    <input type="hidden" id="move_in_eic_content_value"/>

                    <div class="col-md-8">
                        <div class="form-group">
                            <!--begin::Input-->
                            <div class="col-lg state_eic_content_checkbox_required">
                                <label class="form-check form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" name="movin_status" id="movin_status_yes" type="radio" value="1"  />
                                    <span class="fw-bold ps-2 fs-6">
                                        Enable
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label class="form-check form-check-inline form-check-solid">
                                    <input class="form-check-input " name="movin_status" id="movin_status_no" type="radio" value="0"/>
                                    <span class="fw-bold ps-2 fs-6">
                                        Disable
                                    </span>
                                </label>
                                <p><span class="error text-danger"></span></p>
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="form-group">
                            <div class="field-holder">
                                <textarea class="form-control ckeditor" placeholder="Move-in Content" id="move_in_content" name="move_in_content" cols="50" rows="10"></textarea>
                                <span class="form_error" id="move_in_content_error" style="color:red"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="field-holder" id="attributes_movin">
                                <select id="move_in_attribute" class="form-control" style="height:300px;" multiple="multiple" name="movin_attributes">
                                    <option value="@Provider-Name@">@Provider-Name@</option>
                                    <option value="@Provider-Term-And-Conditions@">@Provider-Term-And-Conditions@</option>
                                    <option value="@Provider-Logo@">@Provider-Logo@</option>
                                    <option value="@Plan-Name@">@Plan-Name@</option>
                                    <option value="@Provider-Phone-Number@">@Provider-Phone-Number@</option>
                                    <option value="@Provider-Email@">@Provider-Email@</option>
                                    <option value="@Affiliate-Name@">@Affiliate-Name@</option>
                                    <option value="@Affiliate-Logo@">@Affiliate-Logo@</option>
                                    <option value="@Customer-Full-Name@">@Customer-Full-Name@</option>
                                    <option value="@Customer-Mobile-Number@">@Customer-Mobile-Number@</option>
                                    <option value="@Customer-Email@">@Customer-Email@</option>
                                    <option value="@Connection-Fee@">@Connection-Fee@</option>
                                    <option value="@Disconnection-Fee@">@Disconnection-Fee@</option>
                                    <option value="@distributor_name@">@distributor_name@</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">

                <button type="button" id="save_movin_content" class="submit-button btn btn-primary">Save</button>
                <button type="button" class="cancel-button btn" data-bs-dismiss="modal">Cancel</button>
            </div>
            <div class="card card-flush py-0 px-0">
                <div class="card-header border-0 pt-0 px-8">
                    <div class="card-title">
                        <h2>EIC Checkboxes</h2>
                    </div>
                    <div class="pull-left card-toolbar">
                        <button type="button" class="btn btn-light-primary me-3" id="add_movein_eic_content">+Add Checkbox</button>

                    </div>
                </div>
                <div class="card-body  pt-0 table-responsive">
                    <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class"
                           id="provider_state_eic_content_checkbox_table">
                        <thead>
                        <tr class="fw-bolder fs-6 text-gray-600 px-7">
                            <th class="text-capitalize text-nowrap">Sr. No.</th>
                            <th class="text-capitalize text-nowrap">Required</th>
                            <th class="text-capitalize text-nowrap">Content</th>
                            <!-- <th>Status</th> -->
                            <th class="text-left text-capitalize text-nowrap">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600" id="movein_eic_list">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!--end::Modal content-->

    </div>
    <!--end::Modal dialog-->
</div>

<!--begin::Modal - EIC checkbox-->
<div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false"  id="add_movein_eic_content_checkbox" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">EIC Checkbox</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                  transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                  fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y">
                <!--begin::Form-->
                <form id="movein_provider_eic_content_checkbox_form" class="form">
                    @csrf
                    <input type="hidden" id="action" name="action" value="add">
                    <input type="hidden" id="form_type_movein">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-6 required fw-bold fs-6 mb-5">Does this checkbox is required? </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 movein_eic_content_checkbox_required">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input" name="movein_eic_content_checkbox_required"
                                       id="movein_checkbox_required_yes" type="radio" value="1" />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <input class="form-check-input" id="movein_checkbox_required_no"
                                       name="movein_eic_content_checkbox_required" type="radio" value="0" checked/>
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                            <p><span class="error"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-8 validation_message">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label fw-bold fs-6">Validation Message</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 movein_eic_content_validation_msg">
                            <textarea type="text" id="movein_eic_content_validation_msg"
                                      class="form-control form-control-lg form-control-solid ckeditor" tabindex="8"
                                      placeholder="" rows="3" name="movein_eic_content_validation_msg"></textarea>
                            <span class="error"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-6 required fs-5 fw-bold mb-1">Save Checkbox Status in Database?</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-6 movein_eic_content_checkbox_save_status">
                            <label class="form-check form-check-inline form-check-solid me-5">

                                <input class="form-check-input" name="movein_eic_content_checkbox_save_status"
                                       id="movein_save_status_yes" type="radio" value="1"  />
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('Yes') }}
                                </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <label class="form-check form-check-inline form-check-solid">
                                <!-- <input type="hidden" name="state_eic_content_checkbox_save_status" value="0"> -->
                                <input class="form-check-input" id="movein_save_status_no"
                                       name="movein_eic_content_checkbox_save_status" type="radio" value="0" checked/>
                                <span class="fw-bold ps-2 fs-6">
                                    {{ __('No') }}
                                </span>
                            </label>
                            <p><span class="error"></span></p>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-6 col-form-label required fs-5 fw-bold mb-1">Order </label>

                        <div class="col-lg-6 order">
                            <input type="number" class="form-control form-control-lg form-control-solid h-50px border" id="movein_checkbox_order" placeholder="e.g. 5" name="order">
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label required fs-5 fw-bold mb-1">Checkbox Content
                                                                                           Parameters:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 col-xxl-12">
                            <!-- <select data-control="select2" data-placeholder="" data-hide-search="true"
                            name="statewise_select_checkbox" id="move_in_attribute"
                            class="form-select move_in_attribute" data-id="move_in_attribute"
                            size="14"> -->

                            <select id="move_in_checkbox_parameter" class="form-control" style="height:300px;" multiple="multiple" name="movein_select_checkbox">
                                <option value="@Provider-Name@">@Provider-Name@</option>
                                <option value="@Provider-Term-And-Conditions@">@Provider-Term-And-Conditions@</option>
                                <option value="@Provider-Logo@">@Provider-Logo@</option>
                                <option value="@Plan-Name@">@Plan-Name@</option>
                                <option value="@Provider-Phone-Number@">@Provider-Phone-Number@</option>
                                <option value="@Provider-Email@">@Provider-Email@</option>
                                <option value="@Affiliate-Name@">@Affiliate-Name@</option>
                                <option value="@Affiliate-Logo@">@Affiliate-Logo@</option>
                                <option value="@Customer-Full-Name@">@Customer-Full-Name@</option>
                                <option value="@Customer-Mobile-Number@">@Customer-Mobile-Number@</option>
                                <option value="@Customer-Email@">@Customer-Email@</option>
                                <option value="@Connection-Fee@">@Connection-Fee@</option>
                                <option value="@Disconnection-Fee@">@Disconnection-Fee@</option>
                                <option value="@distributor_name@">@distributor_name@</option>
                            </select>

                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-12 col-form-label required fs-5 fw-bold mb-1">Checkbox Content</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-12 movein_eic_content_checkbox_content">
                            <textarea type="text" id="movein_eic_content_checkbox_content"
                                      class="form-control form-control-lg form-control-solid ckeditor" tabindex="8"
                                      placeholder="" rows="3" name="movein_eic_content_checkbox_content"></textarea>
                            <span class="error"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="movin_eic_content_checkbox_submit" class="btn btn-primary">Save changes</button>
                    </div>

                    <!--end::Input group-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
            <!--end::Modal content-->
        </div>

    </div>
    <!--end::Modal - EIC checkbox-->

    <!-- END CONTENT -->

</div>
