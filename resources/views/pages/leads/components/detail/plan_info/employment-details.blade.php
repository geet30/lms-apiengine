<div class="tab-pane fade show py-5" role="tab-panel">
    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    <h2>Employment Details</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                @php
                    $count = isset($employmentDetails) ? count($employmentDetails):0;
                    $inc = 0;
                @endphp
                @if(isset($employmentDetails))
                @foreach ($employmentDetails as $employmentDetail)
                @php
                $inc = $inc+1;
            @endphp
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-6 px-5">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Employer Name:</div>
                                        </td>
                                        <td class="fw-bolder text-end text-capitalize">{{ isset($employmentDetail->occupation_employer_name) ?  $employmentDetail->occupation_employer_name : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Occupation:</div>
                                        </td>
                                        <td class="fw-bolder text-end text-capitalize">{{ isset($employmentDetail->occupation) ? $employmentDetail->occupation : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Employment Duration:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $employmentDetail->occupation_started_yr ?? '0' }} Year(s), {{ $employmentDetail->occupation_started_month ?? '0' }} Month(s)
                                        </td>
                                        </td>
                                    </tr>
                                    @if($inc == 1)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Occupation Type:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            @foreach ($masterEmploymentDetails as $masterEmploymentDetail)
                                            @if ($masterEmploymentDetail->id == $employmentDetail->occupation_type)
                                                {{ $masterEmploymentDetail->name }}
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
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
                                    @if($inc != 1)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Occupation Type:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            @foreach ($masterEmploymentDetails as $masterEmploymentDetail)
                                            @if ($masterEmploymentDetail->id == $employmentDetail->occupation_type)
                                                {{ $masterEmploymentDetail->name }}
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Industry:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            @foreach ($masterEmploymentDetails as $masterEmploymentDetail)
                                            @if ($masterEmploymentDetail->id == $employmentDetail->occupation_industry)
                                                {{ $masterEmploymentDetail->name }}
                                            @endif
                                            @endforeach
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Employment Status:</div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            @foreach ($masterEmploymentDetails as $masterEmploymentDetail)
                                            @if ($masterEmploymentDetail->id == $employmentDetail->occupation_status)
                                                {{ $masterEmploymentDetail->name }}
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @if($inc == 1)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">Have Credit Card:</div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ isset($employmentDetail->user_have_cc) && $employmentDetail->user_have_cc == 1 ? 'Yes':'No' }}
                                    </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                </div>
                @if($inc < $count)
                <hr class="bg-gray-600 border-2 border-top border-gray-600">
                @endif
                @endforeach
                @endif
                @if ($count == 0)
                    <div class="row">
                        <div class="col-md-4 m-auto fw-bolder text-gray-600">
                            No Employment Details Found.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
