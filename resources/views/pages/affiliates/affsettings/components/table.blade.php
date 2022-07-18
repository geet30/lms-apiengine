<div class="card-body pt-0 table-responsive " id="">
    <table class="table border table-hover table-row-dashed align-middle fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class mx-0" id="affiliatekeys_table">
        <thead>
            <tr class="fw-bolder fs-6 text-gray-800 px-7">

                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.sr_no') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.api_key.name') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.api_key.page_url') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.api_key') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.created_on') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.status') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.actions') }}</th>
            </tr>
        </thead>
        <tbody class="fw-bold text-gray-600" id="affiliatekeys_table_body">
            @if($headArr['requestFrom'])
            <tr>
                <td>1</td>
                <td><span>{{$records->affiliate['referral_code_title'] ? $records->affiliate['referral_code_title'] : 'N/A' }}</span></td>

                <td>
                    <span>{{$records->affiliate['referral_code_url'].'?rc='.$records->affiliate['referal_code']}}</span>
                </td>

                <td>----</td>
                <td>----</td>
                <td>----</td>
                <td>----</td>
            </tr>
            @endif
            <?php
            if (isset($records['ApiKeys']) && !empty($records['ApiKeys'])) {
                $i = 1;
                if ($headArr['requestFrom']) {
                    $i = 2;
                }
                foreach ($records['ApiKeys'] as $frame_key => $frame_value) {
                    $page_url = $frame_value->page_url;
                    if (Request::segment(2) == 'sub-affiliates') {
                        $page_url = $frame_value->page_url . '?rc=' . $frame_value->rc_code;
                    }
            ?>
                    <tr>
                        <td>
                            {{ $i}}
                        </td>
                        <td>
                            <span>{{$frame_value->name}}</span>
                        </td>

                        <td>
                            <span>{{$page_url}}</span>
                        </td>

                        <td>
                            <i class=" fa fa-eye-slash" class="toggleKey" data-id="{{$frame_value->api_key}}" data-bs-target="#apikeyshow" style='font-size:25px;cursor: pointer;' aria-hidden=" true"></i>
                        </td>
                        <td>
                            <span>{{ \Carbon\Carbon::parse($frame_value->created_at)->format('d-m-Y H:i:s') }}</span>

                        </td>

                        <td>
                            @if($frame_value->status && $frame_value->status==1)
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                                <input class="form-check-input changeAffStatus" id="aff_statusfeild" data-check="{{$frame_value->status}}" data-id="{{ ($frame_value->id ??'') }}" type="checkbox" data-status="0" title="Disable" value="1" name="notifications" checked="{{$frame_value->status ? 'checked' : ''}}">
                            </div>
                            @else
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                                <input class="form-check-input changeAffStatus" data-check="{{$frame_value->status}}" data-id="{{ ($frame_value->id ??'') }}" id="aff_statusfeild" type="checkbox" data-status="1" title="enable" value="0" name="notifications">
                            </div>
                            @endif

                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <div class="menu-item ">
                                    <span class="menu-link api_popup" data-id="{{$frame_value->id}}" data-name="{{$frame_value->name}}" data-page="{{$frame_value->page_url}}" data-origin="{{$frame_value->origin_url}}">{{ __('buttons.edit') }}</span>
                                </div>
                                <div class=" menu-item ">
                                    <span class=" menu-link ">{{ __('buttons.delete') }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
            <?php
                    $i++;
                }
            } ?>


        </tbody>
    </table>
</div>

@section('styles')
<link href=" /common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<link href="/common/plugins/custom/flatpickr/flatpickr.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/custom/js/breadcrumbs.js"></script>
@include('pages.affiliates.affsettings.components.js');
@endsection
