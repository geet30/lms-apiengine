<div class="tab-pane fade show py-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Business Details</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Business Name</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                        {{ $saleDetail->vbd_business_legal_name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Business Phone Number</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                        N/A
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Number Of Employees</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                         N/A
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Business Address</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                        {{ $saleDetail->vbd_business_permise ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Industry Type</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                        {{ $saleDetail->vbd_business_company_type ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Business Registration Date</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                        {{ $saleDetail->vbd_created_at ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Position</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            N/A
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Authorized Representative</div>
                                        </td>
                                        <td class="fw-bolder text-end">N/A
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>

                    <!-- right side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Title</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->vie_joint_acc_holder_title ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">First Name</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->vie_joint_acc_holder_first_name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Middle Name</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->vie_joint_acc_holder_middle_name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Last Name</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->vie_joint_acc_holder_last_name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Email</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->vie_joint_acc_holder_email ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Contact Number</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->vie_joint_acc_holder_phone_no ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">DOB</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $saleDetail->vie_joint_acc_holder_dob ?? 'N/A' }}
                                        </td>
                                    </tr>

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>

                    </div>

                </div>
            </div>
            <!--end::Card body-->
        </div>

        <!--end::Documents-->
    </div>
</div>
