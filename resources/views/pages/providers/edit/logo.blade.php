<div class="d-flex flex-column">
    <div class="gy-12 gx-xl-12 card all-table-title-css px-8">
        <div class="card-header border-0 pt-0 px-0">
            <div class="card-title">
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <button type="button" class="btn btn-light-primary me-3" id="add_providers_logo">+Add Logo</button>
                </div>
            </div>
        </div>
        <div class="pt-0 table-responsive">
            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="provider_data_table">
                <thead>
                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                        <th class="text-capitalize text-nowrap" data-priority="1">Sr. No.</th>
                        <th class="text-capitalize text-nowrap">Image</th>
                        <th class="text-capitalize text-nowrap">Description</th>
                        <th class="text-capitalize text-nowrap">Category</th>
                        <th class="text-center text-capitalize text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600" id="provider_logo_body">
                    <?php
                    $i = 0;
                    ?>

                    @if(isset($provider_logo)&& !empty($provider_logo))
                    @foreach($provider_logo as $row)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>
                            <img src="{{$row['name']}}" alt="1st Energy logo" width="50px">
                        </td>
                        <td>{{$row['description']?$row['description']: 'N/A'}}</td>
                        <td>{{$row['title']}}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a class="menu-link px-3 provider_logo_edit" data-id='{{$row["id"]}}' data-url='{{$row["name"]}}' data-description='{{$row["description"]}}' data-category='{{$row["category_id"]}}' data-title='{{$row["title"]}}'>Edit</a>
                                    <a href="" class="menu-link px-3">Delete</a>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    @endforeach
                    @else

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--begin::Modal - Adjust Balance-->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="add_provider_logo_modal" tabindex="-1" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white">Add Provider Logo</h2>
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
            <!--begin::Form-->
            <form role="form" id="provider_logo_form" name="provider_logo_form">
                @csrf
                <!--begin::Modal body-->
                <div class="modal-body">

                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-bold fs-6 mb-5">Upload Logo</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-8 fv-row Logo mb-10">
                            <!-- <input type="file" class="form-control d-md-inline-flex w-md-50" placeholder="" name="support_email" tabindex="5" > -->
                            <div class="image-input image-input-outline" id="abcd" data-kt-image-input="true" style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }})">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }})"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="Logo" accept=".png" />
                                    <input type="hidden" name="Logo_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" id="logo_cancel" title="Cancel">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" id="logo_remove" title="Remove Logo">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                            <div class="form-text">Allowed file types: png.</div>
                            <div class="form-text logo_dimensions"></div>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-bold fs-6 mb-5">Category </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-8 fv-row category_id">
                            <!--begin::Input-->
                            <select class="logo_category_id" data-control="select2" data-placeholder="Select Category" name="category_id" id="category_id" class="form-select form-select-solid h-50px border">
                            </select>
                            <!--end::Input-->
                            <span class="error text-danger category_id_error"></span>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-3">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-bold fs-6 mb-5 logo_description">Logo Description</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="col-lg-8 fv-row logo_description">
                            <textarea type="text" id="logo_description" class="form-control form-control-lg form-control-solid" tabindex="8" placeholder="For e.g. Latest Cimet logo" rows="3" name="logo_description"></textarea>
                            <span class="error text-danger"></span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="provider_logo_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
                <!--end::Modal body-->

            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->
@section('scripts')
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
    const dataTable = $("#provider_data_table").DataTable({
        responsive: false,
        searching: true,
        "sDom": "tipr"
    });

    $('#search_leads').keyup(function() {
        console.log($(this).val());
        dataTable.search($(this).val()).draw();
    })

    $('#discard_btn').click(function() {
        $("#add_provider_modal").modal('hide');
    });
</script>
@endsection
