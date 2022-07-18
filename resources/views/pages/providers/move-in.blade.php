<x-base-layout>
    <!--begin::Content-->
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="card">
                <!--begin::Form-->
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="../../demo8/dist/apps/ecommerce/catalog/products.html">

                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <!-- Start section's -->
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Manage movein grace period and content for : 1st Energy</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->

                                <!--start::Card body-->
                                <div class="card-body px-8 pt-0 table-responsive">
                                    <!--begin::Input group-->
                                    <div class="row mb-5">
                                        <!--begin::Label-->
                                        <!-- <label class="col-lg-3 col-form-label required fw-bold fs-6">Energy type</label> -->
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-3 fv-row">
                                            <select data-control="select2" class="form-select form-control-solid" name="move_in_energy_type" id="move_in_energy_type">
                                                <option value="" class="">Select Service Type</option>
                                                <option value="1" class="">Electricity</option>
                                                <option value="2" class="">Gas</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <!-- <label class="col-lg-3 col-form-label required fw-bold fs-6">Distributor</label> -->
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="col-lg-3 fv-row" id="elec_distributor_div">
                                            <select data-control="select2" class="form-select form-control-solid" name="move_in_elec_distributor" id="move_in_elec_distributor">
                                                <option value="null">Other distributor(Default)</option>

                                            </select>
                                        </div>
                                        <!--end::Input-->
                                        <!--begin::Input-->
                                        <div class="col-lg-3 fv-row" id="gas_distributor_div" style="display:none;">
                                            <select data-control="select2" class="form-select" name="move_in_gas_distributor" id="move_in_gas_distributor">
                                                <option value="null">Other distributor(Default)</option>
                                                <option value="7">AGN Adelaide Metro Zone</option>

                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class mx-0 " id="provider_ackn_checkbox_table">
                                        <thead>
                                            <tr class="fw-bolder fs-6 text-gray-600 px-7">
                                                <th class="text-capitalize text-nowrap">Distributor</th>
                                                <th class="text-capitalize text-nowrap">Property Type</th>
                                                <th class="text-capitalize text-nowrap">Energy Type</th>
                                                <th class="text-capitalize text-nowrap">Days Interval</th>
                                                <th class="text-capitalize text-nowrap">Move-in Content</th>
                                                <th class="text-capitalize text-nowrap">Move-in EIC Content</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600">
                                            <tr>
                                                <td>Other Distributor</td>
                                                <td>SME</td>
                                                <td>Electricity</td>
                                                <td>
                                                    <select class="form-control form-control-lg form-control-solid service_id" name="post_submission_service_type" id="post_submission_service_type">
                                                        <option value="" selected="selected">Please select</option>
                                                        <option value="0">0</option><option value="1">1</option><option value="2" >2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                                    </select>
                                                </td>
                                                <td><i class="fa fa-comment"></i></td>
                                                <td><i class="fa fa-comment"></i></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Residential</td>
                                                <td>Electricity</td>
                                                <td class="w-125px">
                                                    <select class="form-control form-control-lg form-control-solid service_id" name="post_submission_service_type" id="post_submission_service_type">
                                                        <option value="" selected="selected">Please select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                                    </select>
                                                </td>
                                                <td><i class="fa fa-comment"></i></td>
                                                <td><i class="fa fa-comment"></i></td>
                                            </tr>
                                        </tbody>
                                        <tbody style="display:none;">
                                            <tr>
                                                <td rowspan="2">Other Distributor</td>
                                                <td>SME</td>
                                                <td>Gas</td>
                                                <td>
                                                    <select class="form-control form-control-lg form-control-solid service_id" name="post_submission_service_type" id="post_submission_service_type">
                                                        <option value="">Please select</option><option value="1">1</option><option value="2" selected="selected">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                                    </select>
                                                </td>
                                                <td><i class="fa fa-comment"></i></td>
                                                <td><i class="fa fa-comment"></i></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Residential</td>
                                                <td>Gas</td>
                                                <td>
                                                    <select class="form-control form-control-lg form-control-solid service_id" name="post_submission_service_type" id="post_submission_service_type">
                                                        <option value="">Please select</option><option value="1">1</option><option value="2" selected="selected">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                                    </select>
                                                </td>
                                                <td><i class="fa fa-comment"></i></td>
                                                <td><i class="fa fa-comment"></i></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Card body-->
                                <div class="card-footer text-end pt-0">
                                <!--begin::Button-->
                                <a href="list" id="" class="btn btn-light me-5">Cancel</a>
                                <!--end::Button-->
                                <!--begin::Button-->
                                <button type="submit" id="billing_delivery_detail_submit" class="btn btn-primary">
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
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
    @section('scripts')
        <script src="/custom/js/provider.js"></script>
        <script src="/custom/js/breadcrumbs.js"></script>
            <script>
                const breadArray = [{
                        title: 'Dashboard',
                        link: '/',
                        active: false
                    },
                    {
                        title: 'Provider',
                        link: `{{ theme()->getPageUrl('provider/list') }}`,
                        active: false
                    },
                    {
                        title: 'Provider move-in',
                        link: '#',
                        active: true
                    },
                ];
                const breadInstance = new BreadCrumbs(breadArray);
                breadInstance.init();
            </script>
    @endsection
</x-base-layout>

