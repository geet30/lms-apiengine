<!--begin::Modal - Adjust Balance-->
<div class="modal fade export_modal" id="sales_export_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-950px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
                     
                <div class="modal-header bg-primary px-5 py-4">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">Select data for Export</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y">
                    <form class="form" action="#" name="export_sales" class="export_modal">  
                        <input type="hidden" value="sales" class="saleType" name="saleType" />
                        <input type="hidden" value="2" class="vertical_id_field" name="verticalId" />
                        <input type="hidden" value="" class="s" name="s" />
                        <div class="energySale" style="display:none;">
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input sale_info_chk_all_boxes" type="checkbox" value="1" name="selectAll" />
                                <span class="form-check-label text-gray-600 fw-bold">All</span>
                            </label>
                            <div class="row mt-12">
                                <div class="col-lg-3 mb-12 mb-lg-0">
                                @php $i=1 @endphp
                                @php $exportArray = config('lead_export_fields.energy_sale_fields')@endphp                      
                                @foreach($exportArray as $key=>$coloumns)
                                    <label class="fs-7 fw-bold form-label mb-1">{{$key}}</label>
                                    <div class="d-flex flex-column">
                                        @foreach($coloumns as $val)
                                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                <input class="form-check-input sale_listing_export" type="checkbox" value="1" name="selected_data[{{$val}}]" />
                                                <span class="form-check-label text-gray-600 fw-bold">{{$val}}</span>
                                            </label>
                                        @endforeach
                                    </div>        
                                    @php $i++ @endphp        
                                @if($i % 3 == 0)
                                </div><div class="col-lg-3">    
                                @endif
                                @endforeach
                                </div>
                            </div>  
                        </div>
                        <div class="mobileSale">
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input sale_info_chk_all_boxes_2" type="checkbox" value="1" name="selectAll" />
                                <span class="form-check-label text-gray-600 fw-bold">All</span>
                            </label>
                            <div class="row mt-12">
                                <div class="col-lg-3 mb-12 mb-lg-0">
                                @php $i=0 @endphp
                                @php $exportArray = config('lead_export_fields.mobile_sale_fields')@endphp                      
                                @foreach($exportArray as $key=>$coloumns)
                                    <label class="fs-7 fw-bold form-label mb-1">{{$key}}</label>
                                    <div class="d-flex flex-column">
                                        @foreach($coloumns as $val)
                                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                <input class="form-check-input sale_listing_export_2" type="checkbox" value="1" name="selected_data[{{$val}}]" />
                                                <span class="form-check-label text-gray-600 fw-bold">{{$val}}</span>
                                            </label>
                                        @endforeach
                                    </div>        
                                    @php $i++ @endphp        
                                @if($i % 2 == 0)
                                </div><div class="col-lg-3">    
                                @endif
                                @endforeach
                                </div>
                            </div> 
                        </div>         
                    </form>
                            <div class="text-end">
                                <button type="submit" id="sale_csv_select_submit" class="btn btn-primary energySale" style="display:none">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <button type="submit" id="sale_csv_select_submit_2" class="btn btn-primary mobileSale">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                           
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->
<!--begin::Modal - Adjust Balance-->
<div class="modal fade export_modal" id="leads_export_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-950px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
                     
                <div class="modal-header bg-primary px-5 py-4">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">Select data for Export</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y">
                    <form class="form" action="#" name="export_leads" id="filter_sales">  
                        <input type="hidden" value="leads" class="saleType" name="saleType" />
                        <input type="hidden" value="2" class="vertical_id_field" name="verticalId" />
                        <input type="hidden" value="" class="s" name="s" />
                        <div class="energySale" style="display:none;">
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input lead_info_chk_all_boxes" type="checkbox" value="1" name="selectAll" />
                                <span class="form-check-label text-gray-600 fw-bold">All</span>
                            </label>
                            <div class="row mt-12">
                                @php $i=1 @endphp
                                @php $exportArray = config('lead_export_fields.energy_lead_fields')@endphp
                                @foreach($exportArray as $key=>$coloumns)
                                    <div class="col-lg-4 mb-12 mb-lg-0">
                                        @foreach($coloumns as $val) 
                                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                <input class="form-check-input lead_listing_export" type="checkbox" value="1" name="selected_data[{{$val}}]" />
                                                <span class="form-check-label text-gray-600 fw-bold">{{$val}}</span>
                                            </label>
                                            @php $i++ @endphp  
                                            @if($i % 18 == 0)
                                </div><div class="col-lg-4">
                                @endif
                                        @endforeach
                                        
                                    </div>        
                                        
                            
                                @endforeach
                            </div>  
                        </div>   
                        <div class="mobileSale">
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input lead_info_chk_all_boxes_2" type="checkbox" value="1" name="selectAll" />
                                <span class="form-check-label text-gray-600 fw-bold">All</span>
                            </label>
                            <div class="row mt-12">
                                <div class="col-lg-3 mb-12 mb-lg-0">
                                @php $i=0 @endphp
                                @php $exportArray = config('lead_export_fields.mobile_lead_fields')@endphp                      
                                @foreach($exportArray as $key=>$coloumns)
                                    <label class="fs-7 fw-bold form-label mb-1">{{$key}}</label>
                                    <div class="d-flex flex-column">
                                        @foreach($coloumns as $val)
                                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                <input class="form-check-input lead_listing_export_2" type="checkbox" value="1" name="selected_data[{{$val}}]" />
                                                <span class="form-check-label text-gray-600 fw-bold">{{$val}}</span>
                                            </label>
                                        @endforeach
                                    </div>        
                                    @php $i++ @endphp        
                                @if($i % 2 == 0)
                                </div><div class="col-lg-3">    
                                @endif
                                @endforeach
                                </div>
                            </div> 
                        </div>      
                    </form>
                            <div class="text-end">
                                <button type="submit" id="lead_csv_select_submit" class="btn btn-primary energySale" style="display:none">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <button type="submit" id="lead_csv_select_submit_2" class="btn btn-primary mobileSale">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                           
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->
<!--begin::Modals-->
<!--begin::Modal - Customers - Add-->
<div class="modal fade" id="kt_assign_sale_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="assigned_user_form">
                <!--begin::Modal header-->
                <div class="modal-header px-5 py-4" id="kt_modal_assigned_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12">Assign QA</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_assigned_user_header" data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">

                        <div class="row mb-4" style="display:none ;">
                            <div class="col-md-3">
                                <label class="form-label">QA</label>
                                <select class="form-select mb-2 qa-list assigned_qas_list h-50px border" id="master-qa" data-control="select2" data-hide-search="true" data-placeholder="Select QA">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Collaborators</label>
                                <select class="form-select mb-2 qa-list assigned_qas_list h-50px border" id="master-collaborators" data-control="select2" data-hide-search="true" data-placeholder="Select Collaborator" multiple>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button type="button" id="apply-master-dropdown" class="btn btn-light-primary web-margin-top-25px">
                                    <span class="indicator-label">Apply</span>
                                </button>
                            </div>
                        </div>

                        <!--begin::Card body-->
                        <div class="pt-0 table-responsive">
                            <!--begin::Table-->
                            <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="assigned_user_data_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px text-capitalize text-nowrap">Reference Number</th>
                                        <th class="min-w-100px text-capitalize text-nowrap">Name</th>
                                        <th class="min-w-100px text-capitalize text-nowrap">Affiliate</th>
                                        <th class="min-w-30px text-capitalize text-nowrap">Status</th>
                                        @if(checkPermission('sale_assign_qa_section',$userPermissions,$appPermissions) && checkPermission('sale_assign_qa_to_sale',$userPermissions,$appPermissions))
                                            <th class="min-w-30px text-capitalize text-nowrap">Assigned QA</th>
                                        @endif
                                        
                                        @if(checkPermission('sale_assign_qa_section',$userPermissions,$appPermissions) && checkPermission('sale_assign_collaborator_to_sale',$userPermissions,$appPermissions))
                                            <th class="min-w-30px text-capitalize text-nowrap">Assigned Collaborator</th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600" class="assigned_user_table_data_body">
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Scroll-->
                    <div class="text-end">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_assigned_user_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="kt_modal_assigned_user_submit" class="btn btn-primary" onclick="assignUsers()">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->

            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Customers - Add-->

<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="kt_customers_assign_search_id" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">Assign searchLeadId</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y ">
                <!--begin::Form-->
                <form id="kt_customers_export_form" class="form" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Select Export Format:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select h-50px border form-select-solid">
                            <option value="excell">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="cvs">CVS</option>
                            <option value="zip">ZIP</option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Select Date Range:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid h-50px border" placeholder="Pick a date" name="date" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Row-->
                    <div class="row fv-row mb-0">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Payment Type:</label>
                        <!--end::Label-->
                        <!--begin::Radio group-->
                        <div class="d-flex flex-column">
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="1" checked="checked" name="payment_type" />
                                <span class="form-check-label text-gray-600 fw-bold">All</span>
                            </label>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="2" checked="checked" name="payment_type" />
                                <span class="form-check-label text-gray-600 fw-bold">Visa</span>
                            </label>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="3" name="payment_type" />
                                <span class="form-check-label text-gray-600 fw-bold">Mastercard</span>
                            </label>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid">
                                <input class="form-check-input" type="checkbox" value="4" name="payment_type" />
                                <span class="form-check-label text-gray-600 fw-bold">American Express</span>
                            </label>
                            <!--end::Radio button-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                    <div class="text-end">
                        <button type="reset" id="kt_customers_export_cancel" class="btn btn-light me-3">Discard</button>
                        <button type="submit" id="kt_customers_export_submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                    </div>
                    <!--end::Row-->

                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
</div>


<div class="modal fade" tabindex="-1" id="manual_schema_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send schema manually</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
            <input type="hidden" id="schema_lead_id"/>
               <input type="text" id="email_for_sale_schema" class="form-control" placeholder="Enter email address"/>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="send_sale_schema" class="btn btn-primary">
                    <span class="indicator-label">Send</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!-- <button type="button" class="btn btn-primary" id="send_sale_schema">Send</button> -->
            </div>
        </div>
    </div>
</div>
<!--  -->
<div class="modal" id="leads_email_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="width: 70%;">
        <div class="modal-content">
            <form id="leads_email_form" class="form">
                @csrf
                <input type="hidden" name="leadId" value="{{ $saleDetail->l_lead_id ?? ''}}">
                <div class="modal-header py-3 px-4">
                    <h4 class="modal-title">Enter Email Content</h4>
                    <!--begin::Close-->
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="row pb-3">
                        <div class="col-lg-6">
                            <label class="form-label required">From</label>
                            <div class="col-lg-12 fv-row">
                                <input type="text" id="emailFrom" name="emailFrom" class="form-control" placeholder="Enter email address" />
                            </div>
                            <span class="text-danger" id="emailFrom_error"></span>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">To</label>
                            <div class="col-lg-12 fv-row">
                                <input type="text" id="emailTo" name="emailTo" class="form-control" value="{{ isset($saleDetail->v_email)? strtolower(decryptGdprData($saleDetail->v_email)) : '' }}" placeholder="Enter email address" readonly="readonly" style="    cursor: not-allowed;" />
                            </div>
                            <span class="text-danger"></span>
                        </div>

                    </div>
                    <div class="row py-3">
                        <div class="col-lg-6">
                            <label class="form-label">CC</label>
                            <div class="col-lg-12 fv-row">
                                <input type="text" id="emailCC" name="emailCC" class="form-control" placeholder="CC" />
                            </div>
                            <span class="text-danger" id="emailCC_error"></span>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">BCC</label>
                            <div class="col-lg-12 fv-row">
                                <input type="text" id="emailBcc" name="emailBcc" class="form-control" placeholder="BCC" />
                            </div>
                            <span class="text-danger" id="emailBcc_error"></span>
                        </div>

                    </div>
                    <div class="row py-3">
                        <div class="col-lg-12">
                            <label class="form-label required">From Name</label>
                            <div class="col-lg-12 fv-row">
                                <input type="text" id="emailFromName" name="emailFromName" class="form-control" placeholder="Please Enter Your Name" />
                            </div>
                            <span class="text-danger" id="emailFromName_error"></span>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-lg-12">
                            <label class="form-label required">Subject</label>
                            <div class="col-lg-12 fv-row">
                                <input type="text" name="emailSubject" id="emailSubject" class="form-control" placeholder="Please Enter Your Name" />
                                <!-- <textarea class="form-control"  rows="10"></textarea> -->
                            </div>
                            <span class="text-danger" id="emailSubject_error"></span>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-lg-12">
                            <label class="form-label required">Content</label>
                            <div class="col-lg-12 fv-row">
                                <textarea name="emailContent" id="emailContent" class="form-control form-control-lg form-control-solid ckeditor"></textarea>
                            </div>
                            <span class="text-danger" id="emailContent_error"></span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer py-3 px-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="leads_email_submit_btn" class="btn btn-primary">
                        <span class="indicator-label">Send</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!-- <button type="button" class="btn btn-primary" id="send_sale_schema">Send</button> -->
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="leads_sms_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="leads_sms_form" class="form">
                @csrf
                <input type="hidden" name="leadId" value="{{ $saleDetail->l_lead_id ?? ''}}">
                <input type="hidden" name="userId" id="userId" value="{{ $saleDetail->a_user_id ?? ''}}">
                <input type="hidden" name="serviceId" value="{{ $saleDetail->p_service_id ?? ''}}">
                <input type="hidden" name="senderId" value="{{ $saleDetail->a_sender_id ?? ''}}">
                <input type="hidden" name="smsType" value="plivo">
                <div class="modal-header py-3 px-4">
                    <h4 class="modal-title">Enter SMS Content</h4>
                    <!--begin::Close-->
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="row py-4">
                        <div class="col-lg-6">
                            <label class="form-label required">To</label>
                            <div class="col-lg-12 fv-row">
                                <input type="text" id="sms_to" name="sms_to" value="{{ isset($saleDetail->v_phone)? (decryptGdprData($saleDetail->v_phone)) : '' }}" class="form-control form-control-solid" readonly="readonly" style="cursor:not-allowed;" />
                            </div>
                            <span class="text-danger" id="sms_to_error"></span>
                        </div>


                    </div>

                    <div class="row py-4">
                        <div class="col-lg-12">
                            <label class="form-label required">Sender ID Method</label>
                            <div class="col-lg-12 fv-row">
                                <input name="sender_id_method" type="radio" class="form-check-input sender_id_method" value="1">

                                <label class="form-label px-2">Default(Affilate Sender Id)</label>

                                <input name="sender_id_method" type="radio" class="form-check-input sender_id_method" value="2">

                                <label class="form-label px-2">Custom</label>

                                <input name="sender_id_method" class="form-check-input sender_id_method" type="radio" value="3">

                                <label class="form-label px-2">2-Way</label>

                            </div>
                            <span class="text-danger" id="sender_id_method_error"></span>
                        </div>
                    </div>

                    <!--  -->
                    <div class="row py-3 sender_custom_id" style="display:none;">
                        <div class="col-lg-12">
                            <label class="form-label required">Sender ID Content</label>
                            <div class="col-lg-12 fv-row">
                                <input type="text" id="method_content" placeholder="Enter Custom Sender ID*" name="method_content" class="form-control form-control-solid" />
                            </div>
                            <span class="text-danger" id="method_content_error"></span>
                        </div>
                    </div>

                    <div class="row py-3 sender_plivo" style="display:none;">
                        <div class="col-lg-12">
                            <label class="form-label required">Sender ID Content</label>
                            <div class="col-lg-12 fv-row">
                                <select name="plivo_number" id="plivo_number" class="form-select form-select-solid">
                                    <option value="" selected="selected">Please select</option>
                                </select>
                                <span class="error" id="plivo_number_error"></span>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                    <div class="row py-3">
                        <div class="col-lg-12">
                            <label class="form-label required">Message</label>
                            <div class="col-lg-12 fv-row">
                                <textarea name="message" id="message" class="form-control form-control-lg" rows="10"></textarea>
                            </div>
                            <span class="text-danger" id="message_error"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer py-3 px-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="leads_sms_submit_btn" class="btn btn-primary">
                        <span class="indicator-label">Send</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!-- <button type="button" class="btn btn-primary" id="send_sale_schema">Send</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!--  -->
<div class="modal fade" id="sales_qa_start" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sales_qa_start_label" aria-hidden="true">
    <div class="modal-dialog">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white" id="sales_qa_start_label">Start QA on sale</h2>
                <!--end::Modal title-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y">
                <form id="sales_qa_logs" class="form">
                    @csrf
                    <input type="hidden" name="referenceNo" value="{{isset($saleDetail->sale_product_reference_no)?$saleDetail->sale_product_reference_no:''}}">
                    <h4>To start QA on this sale please click on start button</h4>
                    <textarea name="salesQaComment" id="salesQaComment" rows="6" class="form-control form-control-solid rounded rounded-end-0 my-5" placeholder="Add Note (optional)"></textarea>
                </form>
                <div class="text-end">
                    <button type="submit" id="salesQaStart" class="btn btn-primary salesQaBtn">
                        <span class="indicator-label">Start QA</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
</div>
<div class="modal fade" id="sales_qa_end" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sales_qa_end_label" aria-hidden="true">
    <div class="modal-dialog">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white" id="sales_qa_end_label">End QA on sale</h2>
                <!--end::Modal title-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y">
                <form id="sales_qa_logs" class="form">
                    @csrf
                    <input type="hidden" name="referenceNo" value="{{ $saleDetail->sale_product_reference_no ?? '' }}">
                    <textarea name="salesQaComment" id="salesQaComment" rows="6" class="form-control form-control-solid rounded rounded-end-0 my-5" placeholder="Add Note (optional)"></textarea>
                </form>
                <div class="text-end">
                    <button type="submit" id="salesQaEND" class="btn btn-primary salesQaBtn">
                        <span class="indicator-label">End QA</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
</div>