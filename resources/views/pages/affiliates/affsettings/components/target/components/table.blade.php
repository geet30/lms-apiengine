<div class="card-body pt-0 table-responsive " id="ReloadListing">
    <table class="table border table-hover table-row-dashed align-middle mx-0 fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="target_table">
        <thead>
            <tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
                <th class="text-capitalize text-nowrap">
                    {{ __('affiliates_label.table.sr_no') }}
                </th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.target_set') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.month') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.year') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.target_status') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.total_sales') }}</th>
                <th class="text-capitalize text-nowrap">{{ __('affiliates_label.table.actions') }}</th>
            </tr>
        </thead>
        @include('pages.affiliates.affsettings.components.target.components.filtertable')

    </table>

</div>
