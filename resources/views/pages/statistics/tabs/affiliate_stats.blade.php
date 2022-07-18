<div class="pb-5 pt-3">
    <div class="card shadow-sm">
        <div class="card-header collapsible cursor-pointer rotate collapsed" data-bs-toggle="collapse" data-bs-target="#kt_docs_card_collapsible">
            <h3 class="card-title">Affiliate Stats</h3>
            <div class="card-toolbar rotate-180">
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
                        <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor"></path>
                    </svg>
                </span>
            </div>
        </div>
        <?php $chartType = 'affiliate_stats_chart'; ?>
        <div id="kt_docs_card_collapsible" class="collapse">
            <!--begin::Card header-->
            <div class="card-header py-0 gap-2 gap-md-5 px-5 border-0"> 
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="p-5" data-kt-customer-table-toolbar="base"> 
                            
                            <div class="row mt-5 affiliate_section" id="{{ $chartType }}_affiliate_section">
                                <div class="input-group w-300px">
                                    <select data-placeholder="Affiliates" class="form-select form-select-solid " data-control="select2" data-hide-search="true"  name="affiliates" multiple>
                                        <option></option>
                                        <option value="1">Econnex</option> 
                                    </select>
                                </div> 

                                <div class="input-group w-300px">
                                    <select data-placeholder="Sub Affiliates" class="form-select form-select-solid " data-control="select2" data-hide-search="true" name="sub_affiliates" multiple>
                                        <option></option>
                                        <option value="1">Sub Affiliate</option>
                                    </select>
                                </div>
                            </div>
  
                            <!--end::Export-->
                        </div>
                        <!--end::Toolbar--> 
                        <div class="p-5 mt-5" data-kt-customer-table-toolbar="base"> 
                            <div class="input-group w-300px">
                                <select data-placeholder="Select Sale Type" class="form-select form-select-solid " data-control="select2" data-hide-search="true"  name="stat_type" multiple>
                                    <option></option>
                                    <option value="1">Total Visits</option> 
                                    <option value="1">Total Leads</option> 
                                    <option value="1">Total Sales</option> 
                                    <option value="1">Total Unique Leads</option>  
                                    <option value="1">Total Pending Sales</option>
                                    <option value="1">Total Paid Sales</option> 
                                    <option value="1">Total Cancelled Sales</option> 
                                </select>
                            </div> 
                        </div>

                        <div class="p-5 mt-5" data-kt-customer-table-toolbar="base"> 
                        <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter" id="apply_lead_filters">Apply</button>
                        </div>
                    </div>
                    <!--end::Card toolbar-->
            </div>
 
            <div class="card-body">
                <div class="card card-bordered">
                    <div class="card-body">
                        <div id="kt_apexcharts_1" style="height: 350px; overflow-x: scroll;" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>