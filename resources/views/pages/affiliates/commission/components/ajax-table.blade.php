<div class="pt-0  table-responsive">
    <table class="table main-table table-hover align-middle fs-7 gy-2 gs-4 all-table-css-class" id="affiliate_table">
        <thead>
        @if(count($providers))
            <tr class="text-start text-gray-400 fw-bold">
                <th class="align-top text-capitalize text-nowrap" style=" padding-top: 5px!important;padding-bottom: 5px!important">
                    Providers <i class="fa fa-arrow-right"></i>
                </th>
                @foreach($providers as $provider)
                    <th class="text-center" style=" padding-top: 5px!important;padding-bottom: 5px!important;font-size: 15px;">{{ucwords($provider['name'])}}
                        <table class="table sub-table text-center align-bottom">
                            <tr>
                                <th width="33%" class="pb-0 pt-0 text-capitalize text-nowrap">Select</th>
                                <th width="33%" class="pb-0 pt-0 text-capitalize text-nowrap">Price</th>
                                <th width="33%" class="pb-0 pt-0 text-capitalize text-nowrap">Action</th>
                            </tr>
                        </table>
                    </th>
                @endforeach
            </tr>
        @endif
        </thead>
        <tbody id="affiliatebody">
        @if(count($providers))
            @forelse($rows as $key => $value)
                <tr>
                    <td class="fw-bold text-nowrap" style="font-size: 15px;">{{$key}}</td>
                    @foreach($providers as $prov)
                        <td class="text-center text-gray-600" data-provider_id="{{$prov['id']}}" data-commission_struc_type="{{$key}}" data-commission_year="" data-commission_month="">
                            @php
                                $data  = $value->where('provider_id', decryptGdprData($prov['id']))->first();
                            @endphp

                            @if($data)
                                <table class="table">
                                    <tr>
                                        <td class="align-baseline" width="33%"><input type="checkbox"></td>
                                        <td class="align-baseline" width="33%">{{$data->amount}}</td>
                                        <td class="align-baseline" width="33%"><i class="fa fa-pencil edit-commission"></i></td>
                                    </tr>
                                </table>
                            @else
                                <p><span class="here">Click Here</span> <br>to add commission</p>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <td colspan="{{count($providers)+1}}}">Data not found</td>
            @endforelse
        @else
            <tr>
                <td>Data not found</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
