@php
//dd($saleDetail);
//dd($saleDetail);
//dd($saleDetail->l_lead_id);
@endphp
<div class="tab-pane fade show py-5" role="tab-panel">
    <div id="customer_note_show">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Note from the customer (Will be send to retailers)</h2>
                    </div>
                    <div class="my-auto me-4 py-3">
                        <a href="javascript:void(0);" class="fw-bolder me-6 text-primary show_history"
                            data-lead_id="{{ $saleDetail->l_lead_id ?? '' }}"
                            data-vertical_id="{{ $verticalId ?? '' }}" data-section='customer_note'
                            data-for="customer_note_history" data-initial="customer_note_show">Show
                            History</a>
                        <a href="" class="fw-bolder text-primary update_section float-end" data-for="customer_note_edit"
                            data-initial="customer_note_show"><i class="bi bi-pencil-square text-primary"></i> Edit</a>
                    </div>
                </div>
                @if ($verticalId == 1)
                    @php $productId=[]; @endphp
                    @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                        @php array_push($productId,$saleDetail->sale_product_product_type); @endphp
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted" style="width:400px;">
                                                <div class="d-flex align-items-center">Electricity Note:</div>
                                            </td>
                                            <td class="fw-bolder  electricityNote">
                                                {{ $saleDetail->sale_product_note ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    @endif
                    @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail))
                        @php
                            if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) {
                                $proId = $saleDetail->sale_product_product_type;
                                $gas_note = $saleDetail->sale_product_note;
                            } else {
                                $proId = $gasSaleDetail->sale_product_product_type;
                                $gas_note = $gasSaleDetail->sale_product_note;
                            }
                            array_push($productId, $proId);
                        @endphp
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="text-muted" style="width:400px;">
                                                <div class="d-flex align-items-center">Gas Note:</div>
                                            </td>
                                            <td class="fw-bolder  gasNote">{{ $gas_note ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted" style="width:400px;">
                                            <div class="d-flex align-items-center">Customer Note:</div>
                                        </td>
                                        <td class="fw-bolder customerNote">{{ $saleDetail->l_note ?? 'N/A' }}
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                @endif



                <!--end::Card body-->
            </div>

            <!--end::Documents-->
        </div>
    </div>
    <div id="customer_note_edit" style="display:none">
        <div class="d-flex flex-column flex-xl-row gap-7 mb-5 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Note from the customer (Will be send to retailers) Edit</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form name="customer_note_edit_form" id="customer_note_edit_form">
                        @csrf
                        <input type="hidden" name="lead_id" id="lead_id" value="{{ $saleDetail->l_lead_id }}" />
                        <input type="hidden" name="vertical_id" id="vertical_id" value="{{ $verticalId }}" />
                        @if ($verticalId == 1)
                            @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)

                                <div class="row mb-6 text-gray-600">
                                    <label class="col-lg-4 fw-bolder">Electricity Note:</label>
                                    <div class="col-lg-8 fv-row">
                                        <textarea class="form-control" rows="2"
                                            name="elec_note">{{ $saleDetail->sale_product_note }}</textarea>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            @endif
                            @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail))

                                @php
                                    if ($saleDetail->sale_product_product_type == 2) {
                                        $gasNote = $saleDetail->sale_product_note;
                                    } else {
                                        $gasNote = $gasSaleDetail->sale_product_note;
                                    }
                                @endphp
                                <div class="row mb-6 text-gray-600">
                                    <label class="col-lg-4 fw-bolder">Gas Note:</label>
                                    <div class="col-lg-8 fv-row">
                                        <textarea class="form-control" rows="2"
                                            name="gas_note">{{ $gasNote }}</textarea>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            @endif
                            @foreach ($productId as $id)
                                <input type="hidden" name="product_id[]" value="{{ $id }}">
                            @endforeach
                        @else
                        <div class="row mb-6 text-gray-600">
                            <label class="col-lg-4 fw-bolder">Customer Note:</label>
                            <div class="col-lg-8 fv-row">
                                <textarea class="form-control" rows="2"
                                    name="customer_note">{{ $saleDetail->l_note }}</textarea>
                                <span class="error text-danger"></span>
                            </div>
                        </div>
                        @endif
                        <div class="row mb-6 text-gray-600">
                            <label class="col-lg-4 fw-bolder">Comment</label>
                            <div class="col-lg-8 fv-row">
                                <textarea class="form-control comment" rows="2" name="comment"></textarea>
                                <span class="help-block fw-bolder">Give your comment for this updation. </span><br>
                                <span class="error text-danger"></span>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a class="btn btn-light btn-active-light-primary me-2 close_section"
                                data-initial="customer_note_edit" data-for="customer_note_show">Cancel</a>
                            <button type="submit" class="update_customer_note_button"
                                class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="customer_note_history" style="display:none;">
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Customer Note</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive customer_info_table">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                            <thead class="fw-bold text-gray-600">
                                <tr>
                                    <th class="text-muted text-capitalize text-nowrap">S No.</th>
                                    <th class="text-muted text-capitalize text-nowrap">User Name</th>
                                    <th class="text-muted text-capitalize text-nowrap">User role</th>
                                    <th class="text-muted text-capitalize text-nowrap">Comment</th>
                                    <th class="text-muted text-capitalize text-nowrap">Updated at</th>
                                    <th class="text-muted text-capitalize text-nowrap text-center">Show Update History
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="fw-bolder text-gray-600" id="customer_note_body">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="javascript:void(0);" type="button" class="btn btn-primary close_section"
                        data-initial="customer_note_history"
                        data-for="customer_note_show">{{ __('buttons.close') }}</a>
                </div>

                <!--end::Documents-->
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="show_customer_note_history_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">
            <div class="modal-header px-5 py-4">
                <h2 class="fw-bolder fs-12 modal-title">Customer Note Update History</h2>
                <div data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body px-5">
                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                    <tbody class="fw-bold text-gray-600">
                        @if($verticalId == 1)
                        @if (isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 1)
                            <tr>
                                <td class="text-muted" style="width:400px;">
                                    <div class="d-flex align-items-center">Electricity Note:</div>
                                </td>
                                <td class="fw-bolder electricityNote_history">
                                </td>
                            </tr>
                        @endif
                        @if ((isset($saleDetail->sale_product_product_type) && $saleDetail->sale_product_product_type == 2) || isset($gasSaleDetail))
                            <tr>
                                <td class="text-muted" style="width:400px;">
                                    <div class="d-flex align-items-center">Gas Note:</div>
                                </td>
                                <td class="fw-bolder gasNote_history">
                                </td>
                            </tr>
                        @endif
                        @else
                        <tr>
                            <td class="text-muted" style="width:400px;">
                                <div class="d-flex align-items-center">Customer Note:</div>
                            </td>
                            <td class="fw-bolder note_history">
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <!--end::Table body-->
                </table>
            </div>
        </div>

    </div>
</div>
