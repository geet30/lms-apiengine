<style>
    .checker
    {
        width: 200px;
    }
</style>
<div class="card">
    <div class="d-flex flex-column gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Affiliate BDM
                        </h2>
                    </div>
                </div>
                <input type="hidden" value="{{$headArr['requestFrom']}}" id="affiliate_bdm_affiliate_role_info">
                @include('pages.affiliates.affsettings.components.permissions.components.affiliateBdmToolbar') 
                <div class="card-body pt-5">
                    <div class="pt-0 table-responsive px-8">
                        <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
                                    <th class="min-w-50px text-capitalize text-nowrap">Sr. No</th>
                                    <th class="min-w-50px text-capitalize text-nowrap">Name</th>
                                    <th class="min-w-50px text-capitalize text-nowrap">Email</th>
                                    <th class="min-w-50px text-capitalize text-nowrap">Status</th>
                                    <th class="text-end min-w-70px text-capitalize text-nowrap">Actions</th>
                                </tr>
                            </thead> 
                            <tbody class="fw-bold text-gray-600 affiliateBdmUsers">
                            </tbody>
                        </table>

                    </div>
                </div>  
            </div> 
    </div>
</div> 