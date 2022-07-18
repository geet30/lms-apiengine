<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="pt-0 table-responsive">
    <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class"
        id="tags_table">
        <thead>
            <tr class="fw-bolder fs-7 text-gray-800 px-7">
                <th class="text-capitalize text-nowrap">Sr.No.</th>
                <th class="text-capitalize text-nowrap">Tag Title</th>
                <th class="text-capitalize text-nowrap">Tag Highlight</th>
                <th class="text-capitalize text-nowrap">Top <span class="text-lowercase text-nowrap">on the list</span></th>
                <th class="text-capitalize text-nowrap">One <span class="text-lowercase text-nowrap">in a state</span></th>
                <th class="text-capitalize text-nowrap">Created On</th>
                <th class="text-capitalize text-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody class="fw-bold text-gray-600" class="lead_table_data_body" id="tag_body">
        <?php $inc = 1; ?>
            @foreach($tagsData as $tagData)
            <tr>
                <td>{{ $inc }}</td>
                <td>{{ $tagData->name }}</td>
                <td class="text-center">
                    @if($tagData->is_highlighted == 1)
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>
                            @else
                    <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>
                    @endif
                </td>
                <td class="text-center">
                @if($tagData->is_top_of_list == 1)
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>
                            <input size="1" readonly="readonly" name="animal" type="text" value={{ $tagData->rank }}>
                            @else
                            <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>
                            @endif
                </td>
                <td class="text-center">
                @if($tagData->is_one_in_state == 1)
                    <a><i class="fa fa-check text-success"
                            style="font-size:26px;color: green;cursor: default;"></i></a>
                            @else
                    <a><i class="fa fa-close" style="font-size: 26px;color: red;cursor: default;"></i></a>
                    @endif

                </td>
                <td>{{ $tagData->created_at->format('Y-m-d h:i:s')}}</td>
                <td>
                    <div class="dropdown">
                    <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">Actions
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item">
                            <span class="menu-link api_popup" data-action="edit" data-count=5 data-id="{{$tagData->id}}" data-name="{{$tagData->name}}" data-highlighted="{{$tagData->is_highlighted}}" data-toplist="{{$tagData->is_top_of_list}}" data-onestate="{{$tagData->is_one_in_state}}"  data-rank="{{$tagData->rank}}"><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                        </div>
                        <div class="menu-item ">
                            <a type="button" data-id="{{ $tagData->id }}" class="menu-link px-3 delete_tag"><i class="bi bi-trash"></i> Delete</a>
                        </div>
                    </div>
                </div>
                </td>
            </tr>
            <?php $inc++; ?>
@endforeach
        </tbody>

    </table>
</div>
@section('styles')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/custom/js/loader.js"></script>
    <script src="/custom/js/breadcrumbs.js"></script>
    @include('pages.settings.tags.components.js');
    <script>
        KTMenu.createInstances();
        let dataTable = $("#tags_table").DataTable({
            responsive: false,
            searching: true,

            "sDom": "tipr",
        });

        const breadArray = [{
                title: 'Dashboard',
                link: '/',
                active: false
            },
            {
                title: 'Manage Tags',
                link: '#',
                active: true
            },
        ];
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();
    </script>

@endsection
