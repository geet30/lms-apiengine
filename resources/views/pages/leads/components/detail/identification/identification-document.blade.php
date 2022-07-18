<div class="tab-pane fade show py-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden" id="id_document_show">
            <div class="card-header">
                <div class="card-title">
                    <h2>Identification Documents</h2>
                </div>
                <div class="my-auto me-4 py-3">
                    <a href="" class="fw-bolder text-primary update_section float-end"
                        data-lead_id={{ $saleDetail->l_lead_id }} data-service_id={{ $verticalId }}
                        data-for="id_document_edit" data-initial="id_document_show"><i
                            class="bi bi-pencil-square text-primary"></i> Edit</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                        <thead class="fw-bold text-gray-600">

                            <tr>
                                <th class="text-muted text-capitalize text-nowrap">Identification Type</th>
                                <th class="text-muted text-capitalize text-nowrap">Identification Documents</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            @if(isset($visitorDocuments) && count($visitorDocuments)>0)
                            @foreach($visitorDocumnets as $visitorDocument)
                            <tr>
                                <td class="fw-bolder text-capitalize">
                                   {{ $visitorDocument->document_type}}
                                </td>
                                <td class="fw-bolder id_document_td">
                                    @if (isset($visitorDocument->file_name))
                                        <a href="{{ $visitorDocument->path }}"
                                            target="_blank">{{ $visitorDocument->file_name }}</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                            </tr>
                            @endif
                        </tbody>

                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Documents-->

        <div class="card card-flush py-4 flex-row-fluid overflow-hidden w-50" id="id_document_edit"
            style="display:none;">
            <div class="card-header">
                <div class="card-title">
                    <h2>Identification Documents Edit</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <form role="form" name="id_document_form" id="id_document_form">
                    @csrf
                    <input type="hidden" name="visitorDocumentId" value={{ $visitorDocuments->id ?? '' }}>
                    <input type="hidden" name="leadId" value={{ $saleDetail->l_lead_id }}>
                    <input type="hidden" name="visitorId" value={{ $saleDetail->l_visitor_id }}>
                    <div class="row mb-6 text-gray-600">
                        <label class="col-lg-3 fw-bolder">Select Document Type:</label>
                        <div class="col-lg-9 fv-row">
                            <select data-control="select2" class="form-select-solid form-select" name="document_type"
                                id="upload_document_type">

                                <option value="">Select Document Type</option>
                                <option value="Driving License">Driving License</option>
                                <option value="passport">Passport</option>
                                <option value="medicare-card">Medicare Card</option>
                                <option value="old-bill">Old Bill</option>
                                <option value="call-recording">Call Recording</option>
                                <option value="verification-call-recording">Verification Call Recording</option>
                                <option value="concession-card">Concession Card</option>
                                <option value="QA Scorecard">QA Scorecard</option>
                                <option value="other">Other</option>
                            </select>
                            <span class="error text-danger"></span>
                        </div>

                    </div>
                    <div class="row mb-6 text-gray-600">
                        <label class="col-lg-3 fw-bolder">Select Document:</label>
                        <div class="col-lg-9 fv-row">
                            <input type="file" name="document" class="document" multiple
                                accept="application/msword,text/plain, application/pdf, image/*, .doc, .docx,.csv,.tsv,.xls,.xlsx,.xml,.ots,.ods,.fods,.uos"
                                id="id_document">
                        </div>

                    </div>
                    <div class="row mb-6 text-gray-600">
                        <label class="col-lg-3 fw-bolder">Comment :</label>
                        <div class="col-lg-9 fv-row">
                            <textarea class="form-control" rows="2" name="comment"></textarea>
                            <span class="help-block fw-bolder">Give your comment for this updation. </span>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a class="btn btn-light btn-active-light-primary me-2 close_section"
                            data-initial="id_document_edit" data-for="id_document_show">Cancel</a>
                        <button type="submit" class="update_document_button" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
