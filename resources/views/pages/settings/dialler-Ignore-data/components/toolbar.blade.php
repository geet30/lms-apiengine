<!--begin::Card header-->
<div class="card-header border-0 pt-0 px-0">
    <div class="card-title">
        <form id="tag_filters" name="tag_filters" accept-charset="UTF-8" class="tag_filters">
            <div class="d-flex align-items-center position-relative gap-5 my-1">

                @csrf
                <div class="d-flex align-items-center position-relative gap-5 my-1 me-5">
                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                        </svg>
                    </span>

                    <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search" id="search_tag" name="name" />

                </div>
                <button type="button" class="btn btn-light btn-active-light-primary me-2 resetbutton" id="reset_btn">Reset</button>
                <button type="submit" class="btn btn-primary" id="apply_search_filter">Apply</button>
            </div>

        </form>

    </div>
    <!--begin::Card toolbar-->
    <div class="card-toolbar flex-row-fluid justify-content-end">
        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-light-primary me-3 add_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-count=8>+Add</button>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Card toolbar-->
</div>