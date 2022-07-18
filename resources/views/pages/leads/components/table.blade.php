<!--begin::Card body-->
<div class="pt-0 table-responsive">
    <!--begin::Table-->
    <table
        class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class"
        id="lead_data_table">
        <!--begin::Table head-->
        <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                @if ($saleType == 'sales')
                  <th class="w-10px pe-2 text-capitalize text-nowrap">
                      <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                          <input class="form-check-input master-checkbox" type="checkbox" data-kt-check="true"
                              data-kt-check-target="#lead_data_table .form-check-input" value="1" />
                      </div>
                  </th>
                @endif
                  <th class="min-w-50px text-capitalize text-nowrap">ID</th>
                  @if ($saleType == 'sales')
                    <th class="min-w-50 text-capitalize text-nowrap">Ref No.</th>
                  @elseif ($saleType == 'visits')
                    <th class="min-w-50 text-capitalize text-nowrap">Browser</th>
                  @endif

                  @if ($saleType == 'sales' || $saleType == 'leads')
                      <th class="min-w-100px text-capitalize text-nowrap">Name</th>
                      @if($serviceId == 1)
                          <th class="min-w-100px energy_heading text-capitalize text-nowrap">Type</th>
                          <th class="min-w-100px mobile_heading d-none text-capitalize text-nowrap">Conn. Type</th>
                          <th class="min-w-100px broadband_heading d-none text-capitalize text-nowrap">Plan Type</th>
                      @elseif($serviceId == 2)
                          <th class="min-w-100px energy_heading d-none text-capitalize text-nowrap">Type</th>
                          <th class="min-w-100px mobile_heading text-capitalize text-nowrap">Conn. Type</th>
                          <th class="min-w-100px broadband_heading text-capitalize text-nowrap">Plan Type</th>
                      @elseif($serviceId == 3)
                      <th class="min-w-100px energy_heading d-none text-capitalize text-nowrap">Type</th>
                      <th class="min-w-100px mobile_heading text-capitalize text-nowrap">Conn. Type</th>
                      <th class="min-w-100px broadband_heading d-none text-capitalize text-nowrap">Plan Type</th>
                      @endif
                  @endif
                <th class="min-w-125px text-capitalize text-nowrap">Affiliate</th>

                <th class="min-w-100px text-capitalize text-nowrap">Sub-Aff</th>
                @if ($saleType == 'sales')
                    <th class="min-w-100px text-capitalize text-nowrap">Provider</th>
                    <th class="min-w-150px text-capitalize text-nowrap">QA</th>
                    <th class="min-w-150px text-capitalize text-nowrap">Collabrator</th>
                    <th class="min-w-30px text-capitalize text-nowrap">Status</th>
                    <th class="min-w-150px text-capitalize text-nowrap moving_date d-none">Movin Date</th>
                @elseif($saleType == 'leads')
                    <th class="min-w-150px text-capitalize text-nowrap moving_date d-none">Movin Date</th>
                    <th class="min-w-150px text-capitalize text-nowrap">Journey Completed</th>
                    <th class="min-w-150px text-capitalize text-nowrap">Duplicate</th>
                @endif
                <th class="min-w-150px text-capitalize text-nowrap">Created Date</th>
                <th class="text-end min-w-70px text-capitalize text-nowrap">Actions</th>
            </tr>
            <!--end::Table row-->
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody class="fw-bold text-gray-600" class="lead_table_data_body">

            @foreach ($leads as $leadData)
              @php

                  $lead = $leadData[0];
                  $count = count($leadData);
              @endphp
                  <tr>
                      @if ($saleType == 'sales')
                      <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input row-checkbox" type="checkbox" value="{{ $lead->LeadId }}" data-id="{{ $lead->LeadId }}" data-affiliate_id="{{ $lead->AffiliateId }}" data-sale_created_dt="{{$lead->SalesCreatedDate}}" data-reference_no="{{ $lead->reference_no }}" data-name="{{ decryptGdprData($lead->VisitorFirstName)  }}" data-affiliate_name="{{ ucwords($lead->AffiliateLegalName) }}" data-assigned_qa="{{ $lead->AssignedUser }}"/>
                        </div>
                      </td>
                      @endif
                      <td>
                          {{ $lead->LeadId }}
                      </td>
                      @if ($saleType == 'sales')
                          <td>
                              {{ $lead->reference_no }}<br>
                              @if($count > 1 && $leadData[0]->ProviderId != $leadData[1]->ProviderId)
                                  {{ $leadData[1]->reference_no }}
                              @endif
                          </td>
                      @elseif ($saleType == 'visits')
                          <td class="min-w-50">{{ $leadData[0]->browser }}</td>
                      @endif

                      @if ($saleType == 'sales' || $saleType == 'leads')
                          <td>{{ decryptGdprData($lead->VisitorFirstName) }}</td>
                          @if($serviceId == 1)
                              <td>
                                  @if($count >= 1)
                                      both
                                  @else
                                      {{ $lead->ProductTypeDescription }}
                                  @endif
                              </td>
                          @elseif($serviceId == 2)
                              <td>
                                  {{ $lead->ConnectionName }}
                              </td>
                              <td>
                                  {{ $lead->PlanName }}
                              </td>
                          @elseif($serviceId == 3)
                          <td>
                              {{ $lead->ConnectionName }}
                          </td>
                          @endif
                      @endif

                      <td>{{ ucwords($lead->AffiliateLegalName) }}</td>
                      <td>{{ isset($lead->SubAffiliateName)?$lead->SubAffiliateName: "N/A" }}</td>
                      @if ($saleType == 'sales')
                          <td>{{ ucwords($lead->ProiderName) }}</td>
                          <td>{{ ucwords(decryptGdprData($lead->AssignedUserName)) }}</td>
                          <td>
                            @isset($collabratorLeads[$lead->LeadId])
                                @foreach(array_column($collabratorLeads[$lead->LeadId],'user_id') as $val)
                                    @if($loop->iteration != 1)
                                        ,
                                    @endif
                                     {{ decryptGdprData($collabratorName[$val][0]['first_name']) }}
                                @endforeach
                            @endif
                          </td>
                          <td class="min-w-30px" id="status_{{$lead->LeadId}}">
                          <div class="badge badge-light-success">
                          {{ isset($statuses[$leadData[0]->SaleStatus]) ?$statuses[$leadData[0]->SaleStatus]:'--' }}
                          </div>
                          <br>
                          @if($count > 1)
                              <div class="badge badge-light-success">{{ isset($statuses[$leadData[1]->SaleStatus]) ?$statuses[$leadData[1]->SaleStatus] :'--' }}</div>
                          @endif
                      </td>
                          @if($serviceId == 1)
                              <td>{{isset($lead->MovingDate)?dateTimeFormat($lead->MovingDate):'No'}}</td>
                          @endif
                          <td>{{$lead->SalesCreatedDate}}</td>
                      @elseif($saleType == 'leads')
                          @if($serviceId == 1)
                              <td>{{isset($lead->MovingDate)?dateTimeFormat($lead->MovingDate):'N/A'}}</td>
                          @endif
                          <td>{{ $lead->JourneyCompleted ?? '0' }}</td>
                          <td>{{isset($lead->IsDuplicate)?$lead->IsDuplicate:'No'}}</td>
                          <td>{{isset($lead->LeadCreatedDate) ? dateTimeFormat($lead->LeadCreatedDate):'N/A'}}</td>
                      @elseif($saleType == 'visits')
                          <td>{{isset($lead->LeadCreatedDate)? dateTimeFormat($lead->LeadCreatedDate) :'N/A'}}</td>
                      @endif


                      <td class="text-end">
                            <a href="/{{ $saleType }}/detail/{{$userServices[0]->service_id}}/{{ encryptGdprData($lead->LeadId) }}" title="Detail">
                                <i class="bi bi-eye fs-2 mx-1 text-primary"></i>
                            </a>
                        @if ($saleType == 'leads')
                            <a href="" title="Remove Lead">
                                <i class="bi bi-trash fs-2 mx-1 text-danger"></i>
                            </a>
                        @elseif($saleType == 'sales')
                            <a role="button" onclick="openSchemaModal('{{$lead->LeadId}}')">
                                <i class="bi bi-filetype-csv fs-2 mx-1 text-success"></i>
                            </a>
                        @endif
                      </td>
                  </tr>
            @endforeach
        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->
</div>
<!--end::Card body-->

@section('scripts')
<script>
 
  let connectionTypes = <?php echo json_encode($connectionTypes->toArray()) ?>;
  let userPermissions = <?php echo json_encode($userPermissions) ?>;
  let appPermissions = <?php echo json_encode($appPermissions) ?>; 
  var mobileConnectionTypes = broadbandConnectionTypes = '<option></option>';

  $(connectionTypes).each(function (i, connectionType) {
      if(connectionType.service_id == 2 && connectionType.connection_type_id == 1)
      {
          mobileConnectionTypes += `<option data-id="mobile" value="${connectionType.local_id}">${connectionType.name }</option>`;
      }
      else if((connectionType.service_id == 3 && connectionType.connection_type_id != 0) && (connectionType.connection_type_id == null || connectionType.connection_type_id == ''))
      {
          broadbandConnectionTypes += `<option data-id="broadband" value="${connectionType.local_id}">${ connectionType.name }</option>`;
      }

  });
  /** Send schema **/
  function openSchemaModal(leadId) {
        $('#schema_lead_id').val(leadId);
        $('#manual_schema_modal').modal('show');
    }
    $(document).on('click', '#send_sale_schema', function(e) {
      let submitButton = document.querySelector('#send_sale_schema');
      submitButton.setAttribute('data-kt-indicator', 'on');
      submitButton.disabled = true;

        axios.post('/provider/send-schema/' + $('#schema_lead_id').val(), {
                email: $('#email_for_sale_schema').val()
            })
            .then(function(response) {
              submitButton.setAttribute('data-kt-indicator', 'off');
              submitButton.disabled = false;
              $('#manual_schema_modal').modal('hide');
              toastr.success(response.data.message)
            })
            .catch(function(error) {
              submitButton.setAttribute('data-kt-indicator', 'off');
              submitButton.disabled = false;
              toastr.error(error.response.data.error)
            });
    });
</script>
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script type="text/javascript" src="{{ URL::asset('common/plugins/custom/flatpickr/flatpickr.bundle.js') }}"></script>
    <script src="/custom/js/permission.js"></script>
    <script type="text/javascript" src="{{ URL::asset('custom/js/sale.js') }}"></script>
@endsection
