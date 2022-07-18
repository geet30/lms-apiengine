<div class="tab-pane fade show mb-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Status</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                @if(checkPermission('sale_status_history',$userPermissions,$appPermissions))
                    <div class="row">
                        @if ($verticalId == 1)
                            @if (isset($saleProduct))
                                <div class="mb-5 col-md-6">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <span class="text-dark fw-bolder fs-6">Electricity:</span>
                                        </div>
                                        @if (isset($saleProduct) && checkPermission('sale_change_sale_status',$userPermissions,$appPermissions))
                                            <div class="col-md-6">
                                                <select class="form-select fsorm-select-transsparent change-status"
                                                    data-product_id="{{ encryptGdprData($saleProduct->id) }}"
                                                    data-lead_id="{{ encryptGdprData($saleProduct->lead_id) }}"
                                                    data-product_type="{{ $saleProduct->product_type ?? '' }}"
                                                    name="electricity_status" data-control="select2"
                                                    data-hide-search="false" aria-label="Change Status"
                                                    data-placeholder="Change Status">
                                                    <option value=""></option>
                                                    @foreach ($saleProduct->statusHierarchies as $statusHierarchy)
                                                        <option value="{{ $statusHierarchy->assigned_status_id }}">
                                                            {{ $statusHierarchy->getStatus->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="timeline-label timeline-box">
                                        @if (isset($statuses))
                                            @foreach ($statuses as $status)
                                                <div class="timeline-item">
                                                    <div class="timeline-left fw-bolder text-gray-800 fs-6 w-200px">
                                                        <p class="me-4 float-end">
                                                            {{ $status->created_at->format('d-m-Y') }} <span
                                                                class="text-primary">
                                                                {{ $status->created_at->format('h:i A') }}</span></p>
                                                        <span
                                                            class="font-weight-bold fs-12 float-end text-primary namespan mx-3">
                                                            {{ isset($status->getUser->first_name) ? ucfirst(decryptGdprData($status->getUser->first_name)) : '' }}
                                                            {{ isset($status->getUser->last_name) ? ucfirst(decryptGdprData($status->getUser->last_name)) : '' }}({{ isset($status->getUser) &&  isset($status->getUser->getRoleNames()[0]) ? ucfirst($status->getUser->getRoleNames()[0]) : '' }})
                                                        </span>
                                                    </div>

                                                    <div class="timeline-badge">
                                                        <i
                                                            class="fa fa-genderless text-{{ $status->status_class }} fs-1"></i>
                                                    </div>
                                                    <div class="fw-normal timeline-content text-muted ps-3 w-50">
                                                        <div class="timeline">
                                                            <p
                                                                class="badge badge-light-{{ $status->status_class }} my-0">
                                                                {{ $status->getStatuses->title }} </p>
                                                            {{-- @if (isset($status) && $status->type == 2)
                                                <small class="fw-normal text-muted">Resubmitted By Admin</small>

                                                @endif --}}
                                                        </div>
                                                        <p class="mb-0 mt-4">
                                                            {{ $status->comment }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                </div>
                            @endif
                        @else
                            <div class="mb-5 col-md-6">
                                <div class="row mb-4">
                                    <div class="col-md-6">

                                        @switch($verticalId)
                                            @case(2)
                                                <span class="text-dark fw-bolder fs-6">Mobile:</span>
                                            @break

                                            @default
                                                <span class="text-dark fw-bolder fs-6">Broadband:</span>
                                        @endswitch
                                    </div>
                                    @if (isset($saleProduct) && checkPermission('sale_change_sale_status',$userPermissions,$appPermissions))
                                        <div class="col-md-6">
                                            <select class="form-select fsorm-select-transsparent change-status"
                                                data-product_id="{{ encryptGdprData($saleProduct->id) }}"
                                                data-product_type="{{ $saleProduct->product_type ?? '' }}"
                                                name="electricity_status" data-control="select2" data-hide-search="false"
                                                aria-label="Change Status" data-placeholder="Change Status">
                                                <option value=""></option>
                                                @foreach ($saleProduct->statusHierarchies as $statusHierarchy)
                                                    <option value="{{ $statusHierarchy->assigned_status_id }}">
                                                        {{ $statusHierarchy->getStatus->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                </div>

                                <div class="timeline-label timeline-box">
                                    @if (isset($statuses))
                                        @foreach ($statuses as $status)
                                            <div class="timeline-item">
                                                <div class="timeline-left fw-bolder text-gray-800 fs-6 w-200px">
                                                    <p class="me-4 float-end">
                                                        {{ $status->created_at->format('d-m-Y') }} <span
                                                            class="text-primary">
                                                            {{ $status->created_at->format('h:i A') }}</span></p>
                                                    <span
                                                        class="font-weight-bold fs-12 float-end text-primary namespan mx-3">
                                                        {{ isset($status->getUser->first_name) ? ucfirst(decryptGdprData($status->getUser->first_name)) : '' }}
                                                            {{ isset($status->getUser->last_name) ? ucfirst(decryptGdprData($status->getUser->last_name)) : '' }}({{ isset($status->getUser) &&  isset($status->getUser->getRoleNames()[0]) ? ucfirst($status->getUser->getRoleNames()[0]) : '' }})
                                                    </span>
                                                </div>

                                                <div class="timeline-badge">
                                                    <i
                                                        class="fa fa-genderless text-{{ $status->status_class }} fs-1"></i>
                                                </div>
                                                <div class="fw-normal timeline-content text-muted ps-3 w-50">
                                                    <div class="timeline">
                                                        <p class="badge badge-light-{{ $status->status_class }} my-0">
                                                            {{ $status->getStatuses->title }} </p>
                                                        {{-- @if (isset($status) && $status->type == 2)
                                                <small class="fw-normal text-muted">Resubmitted By Admin</small>

                                                @endif --}}
                                                    </div>
                                                    <p class="mb-0 mt-4">
                                                        {{ $status->comment }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        @endif
                        @if (isset($gasSaleProduct))
                            <div class="mb-5 col-md-6">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <span class="text-dark fw-bolder fs-6">Gas:</span>
                                    </div>
                                    <div class="col-md-6">
                                        @if (isset($gasSaleProduct) && checkPermission('sale_change_sale_status',$userPermissions,$appPermissions))
                                            <select class="form-select fsorm-select-transsparent change-status"
                                                data-product_id="{{ encryptGdprData($gasSaleProduct->id) }}"
                                                data-product_type="{{ $gasSaleProduct->product_type ?? '' }}"
                                                name="gas_status" data-control="select2" data-hide-search="false"
                                                aria-label="Change Status" data-placeholder="Change Status">
                                                <option value=""></option>
                                                @foreach ($gasSaleProduct->statusHierarchies as $statusHierarchy)
                                                    <option value="{{ $statusHierarchy->assigned_status_id }}">
                                                        {{ $statusHierarchy->getStatus->title }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="timeline-label timeline-box">
                                    @if (isset($gasStatuses))
                                        @foreach ($gasStatuses as $status)
                                            <div class="timeline-item">
                                                <div class="timeline-left fw-bolder text-gray-800 fs-6 w-200px">
                                                    <p class="me-4 float-end">
                                                        {{ $status->created_at->format('d-m-Y') }}
                                                        <span class="text-primary">
                                                            {{ $status->created_at->format('h:i A') }}</span>
                                                    </p>
                                                    <span
                                                        class="font-weight-bold fs-12 float-end text-primary namespan mx-3">
                                                        {{ isset($status->getUser->first_name) ? ucfirst(decryptGdprData($status->getUser->first_name)) : '' }}
                                                        {{ isset($status->getUser->last_name) ? ucfirst(decryptGdprData($status->getUser->last_name)) : '' }}({{ isset($status->getUser) &&  isset($status->getUser->getRoleNames()[0]) ? ucfirst($status->getUser->getRoleNames()[0]) : '' }})
                                                    </span>
                                                </div>

                                                <div class="timeline-badge">
                                                    <i
                                                        class="fa fa-genderless text-{{ $status->status_class }} fs-1"></i>
                                                </div>
                                                <div class="fw-normal timeline-content text-muted ps-3 w-50">
                                                    <div class="timeline">
                                                        <p class="badge badge-light-{{ $status->status_class }} my-0">
                                                            {{ $status->getStatuses->title }} </p>
                                                    </div>
                                                    <p class="mb-0 mt-4">
                                                        {{ $status->comment }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal fade" id="change_sale_status_pop_up" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form id="change_sale_status_form" class="form">
                <!--begin::Modal header-->
                <div class="modal-header bg-primary px-5 py-4" id="kt_modal_assigned_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder fs-12 text-white">Change Status</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_close"
                        class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill"
                        data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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
                <div class="modal-body">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_assigned_user_scroll" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_assigned_user_header"
                        data-kt-scroll-wrappers="#kt_modal_assigned_user_scroll" data-kt-scroll-offset="300px">

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label required">Sub Status</label>
                                <select class="form-select fsorm-select-transsparent" name="sub_status" id="sub_status"
                                    data-control="select2" data-hide-search="false" aria-label="Sub Status"
                                    data-placeholder="Sub Status">
                                    <option value=""></option>
                                </select>
                                <span class="text-danger errors" id="term_title_content_error"></span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">Comment</label>
                                <textarea name="comment" id="comment"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="e.g. Sale need to cancel due to mis-match of info" rows="4"></textarea>
                                <span class="text-danger errors" id="term_content_error"></span>
                            </div>
                        </div>
                    </div>
                    <!--end::Scroll-->

                    <!--begin::Modal footer-->
                    <div class="text-end">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_assigned_user_cancel" data-bs-dismiss="modal"
                            class="btn btn-light me-3">Discard</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="button" id="change_sale_status_form_submit_btn"
                            class="btn btn-primary" data-lead_id="{{ encryptGdprData($saleDetail->l_lead_id) }}">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->

                </div>
                <!--end::Modal body-->

            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
