@php //dd($salesHistory); @endphp
<div class="card card-flush py-0 px-0">
 
    <div class="card-body px-8 pt-0 table-responsive">
        
        <table class="table border table-hover table-row-dashed align-middle mx-0 fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class recon_history_datatable" id="recon_history_table">
            <thead>
                <tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
                    <th class="text-capitalize text-nowrap">
                        {{ __('settings.recon_history.table.sr_no') }}
                    </th>
                    <th class="text-capitalize text-nowrap">{{ __('settings.recon_history.table.recon_ref_no') }}</th>
                    <th class="text-capitalize text-nowrap">{{ __('settings.recon_history.table.recon_created_date_time') }}</th>
                    <th class="text-capitalize text-nowrap">{{ __('settings.recon_history.table.recon_reset_date_time') }}</th>
                    <th class="text-capitalize text-nowrap">{{ __('settings.recon_history.table.recon_status') }}</th>
                    <th class="text-capitalize text-nowrap">{{ __('settings.recon_history.table.recon_action') }}</th>
              
              
                </tr>
            </thead>
            <tbody class="target_table_data_body fw-bold text-gray-600" id="">
                @php   $inc = 0; @endphp
                @if(!empty($salesHistory))
                    @foreach ($salesHistory as $sale)
                        <tr>
                         <td>{{ $inc+1}}</td>
                        <td>	
                        {{ $sale['recon_reference_no'] ?? ''}}</td>
                        <td>{{ $sale['recon_created_date'] ?? ''}}</td>
                        <td>{{ $sale['recon_reset_date'] ?? ''}}</td>
                        @php
                        $status='Invalid'; 
                        if($sale['status']==1){
                            $status='Valid';
                        }
                        @endphp
                        <td>{{ $status ??''}}</td>
                        <td>  <a class="menu-link px-3"><i class="bi bi-eye"></i></a></td>
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
