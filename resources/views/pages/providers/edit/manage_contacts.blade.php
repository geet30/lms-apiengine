<!--begin::Main column-->
<div class="d-flex flex-column gap-7 gap-lg-10">
    <div class="card card-flush">
        <div class="card-header">
            <div class="d-flex align-items-center position-relative gap-5 my-1 me-5">
            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                </svg>
            </span>

            <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search" id="search_contacts">
            <button type="button"  class="btn btn-primary" name="manage_contact_reset_button" id="manage_contact_reset_button">Reset</button>
        </div>
            <div class="pull-right card-toolbar">
                <button type="button" class="btn btn-light-primary me-3 add-contact-button" data-bs-toggle="modal" data-bs-target="#add_contact" data-action="add">+Add</button>
            </div>
        </div>
        <div class="card-body px-8 pt-0 table-responsive">
            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class provider_datatable" id="provider_contact_link_table">
                <thead>
                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                        <th class="text-capitalize text-nowrap">Sr. No.</th>
                        <th class="text-capitalize text-nowrap">Contact Name</th>
                        <th class="text-capitalize text-nowrap">Email</th>
                        <th class="text-capitalize text-nowrap">Designation</th>
                        <th class="text-center text-capitalize text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600" id="provider_contact_body">
                    @php
                        $inc = 0;
                    @endphp
                    @if(count($contacts)>0)
                    @foreach ($contacts as $contact)

                    <tr>
                        <td>{{ $inc+1 }}</td>
                        <td>{{ $contact['name'] }}</td>
                        <td>{{ $contact['email'] }}</td>
                        <td>{{ $contact['designation'] }}</td>
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
                                    <a type="button" class="menu-link px-3 edit-contact-button" data-action="edit" data-id="{{ $contact['id'] }}" data-name="{{ $contact['name'] }}" data-email="{{ $contact['email'] }}" data-designation="{{ $contact['designation'] }}" data-desc={{ $contact['description'] }}>Edit</a>
                                    <a type="button" data-user_id="{{ $contact['provider_id'] }}" data-id="{{ $contact['id'] }}" class="menu-link px-3 delete_contact">Delete</a>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    @php
                        $inc++
                    @endphp
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
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"  id="add_contact" tabindex="-1" role="dialog">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-750px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <form role="form" id="add_contact_form" class="add_contact_form" name="add_contact_form">
            @csrf
            <input type="hidden" name="contactId" value="">
            <input type="hidden" name="request_from" value="add_contact_form">
            <!--begin::Modal header-->
            <div class="modal-header bg-primary px-5 py-4">
                <!--begin::Modal title-->
                <h2 class="fw-bolder fs-12 text-white modal-title">Add Contact</h2>
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
                <div class="row mb-5">
                    <div class="col">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label required fw-bold fs-6">Contact Name</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12">
                        <input type="text" class="form-control form-control-lg form-control-solid h-50px border" id="contact_name" placeholder="e.g. Steve" name="contact_name">
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <div class="col">
                      <!--begin::Label-->
                      <label class="col-lg-12 col-form-label required fw-bold fs-6">Contact Email</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <div class="col-lg-12">
                          <input type="text" class="form-control form-control-lg form-control-solid h-50px border" id="email" placeholder="e.g. Cimetofficial@cimet.com.au" name="contact_email">
                          <span id="emailSpan" class="error text-danger"></span>
                      </div>
                      <!--end::Input-->
                </div>
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-5">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label required fw-bold fs-6">Contact Designation</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12">
                        <input type="text" class="form-control form-control-lg form-control-solid h-50px border" id="contact_designation" placeholder="e.g. Marketing Manager" name="contact_designation" >
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <div class="row mb-3">
                    <!--begin::Label-->
                    <label class="col-lg-12 col-form-label fw-bold fs-6">Description</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-12 col-xxl-12 contact_description">
                        <textarea type="text" id="contact_description" class="form-control form-control-lg form-control-solid ckeditor" tabindex="8" placeholder="" rows="5" name="contact_description" ></textarea>
                        <span class="error text-danger"></span>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <div class="text-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <!--begin::Button-->
                <button type="submit" id="contact_form_submit" class="btn btn-primary">
                    <span class="indicator-label save">Save Changes</span>
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





