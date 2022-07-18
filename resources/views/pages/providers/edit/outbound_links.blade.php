<!--begin::Main column-->
<div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="card card-flush">
            <div class="card-header">
                <h2></h2>
                <div class="pull-right card-toolbar">
                    <button type="button" class="btn btn-light-primary me-3 add_edit_link" data-bs-toggle="modal" data-bs-target="#add_provider_outbound_link" data-action="add" >+Add</button>
                </div>
            </div>
            <div class="card-body px-8 pt-0 table-responsive">
                <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class provider_datatable" id="provider_outbound_link_table">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class="text-capitalize text-nowrap">Sr. No.</th>
                            <th class="text-capitalize text-nowrap">Title</th>
                            <th class="text-capitalize text-nowrap">URL</th>
                            <th class="text-capitalize text-nowrap">Order</th>
                            <th class="text-center text-capitalize text-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600" id="outbound_link_body">
                        @php //dd($outbound_links); @endphp
                        @if(count($outbound_links) > 0)
                            @foreach($outbound_links as $key => $value)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$value["link_title"]}}</td>
                                <td>{{$value["link_url"]}}</td>
                                <td>{{$value["order"]}}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon--></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a type="button" class="menu-link px-3 add_edit_link" data-bs-toggle="modal" data-bs-target="#add_provider_outbound_link"  data-order="{{$value["order"]}}" data-title="{{$value["link_title"]}}" data-url="{{$value["link_url"]}}" data-action="edit" data-id="{{$value["id"]}}" >Edit</a>
                                            <a type="button" class="menu-link px-3 delete_link" data-user_id="{{$value["user_id"]}}" data-id="{{$value["id"]}}">Delete</a>
                                        </div>
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Pricing-->
</div>
<!--end::Main column-->

<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="add_provider_outbound_link"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <form role="form" id="provider_outbound_link_form" class="provider_outbound_link_form" name="provider_outbound_link_form">
                @csrf
                <input type="hidden" class="link_id" id="link_id" name="link_id" value="">
                <input type="hidden" class="action_type" id="action_type" name="action_type" value="">
                <!--begin::Modal header-->
                <div class="modal-header bg-primary px-5 py-4">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">Outbound Links</h2>
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
                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Title</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="fv-row link_title">
                            <input type="text" class="form-control form-control-lg form-control-solid h-50px border" id="link_title" placeholder="e.g. Cimet's latest discounts" name="link_title">
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">URL</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="fv-row link_url">
                            <input type="text" class="form-control form-control-lg form-control-solid h-50px border" id="link_url" placeholder="e.g. https://cimet.discounts.com.au" name="link_url">
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label mb-1">Order</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="fv-row order">
                            <input type="number" class="form-control form-control-lg form-control-solid h-50px border" id="link_order" placeholder="e.g. 5" name="order">
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="text-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <!--begin::Button-->
                    <button type="submit" id="outbound_link_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                </div>
                <!--end::Modal body-->

            </form>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>


