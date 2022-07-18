<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="pt-0 table-responsive">
    @if ($category == 'home-line-connection')
    @php $setnav = 'Home Line Connection' @endphp
    @elseif ($category == 'modem')
    @php $setnav = 'Modem' @endphp
    @elseif ($category == 'additional-addons')
    @php $setnav = 'Additional Addons' @endphp
    @endif
    <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class"
        id="addons_table">
        <thead>
            <tr class="fw-bolder fs-7 text-gray-800 px-7">
                <th class="text-capitalize text-nowrap">Sr.No.</th>
                <th class="text-capitalize text-nowrap">Order</th>
                @if ($category == 'home-line-connection')
                @php $setnav = 'Home Line Connection' @endphp
                    <th class="text-capitalize text-nowrap">Plan Name</th>
                    <th class="text-capitalize text-nowrap">Provider Name</th>
                @elseif ($category == 'modem')
                    <th class="text-capitalize text-nowrap">Modem Name</th>
                    <th class="text-capitalize text-nowrap">Connection Name</th>
                @elseif ($category == 'additional-addons')
                    <th class="text-capitalize text-nowrap">Addons Title</th>
                @endif
                <th class="text-capitalize text-nowrap">Status</th>
                <th class="text-capitalize text-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody class="fw-bold text-gray-600" class="lead_table_data_body">
            <?php $inc = 1; ?>
            @foreach ($addon_data as $addon)
                @if ($addon->category == '3')
                    <tr>
                        <td>{{ $inc }}</td>
                        <td>{{ $addon->order }}</td>
                        <td class="text-capitalize">{{ $addon->name }}</td>
                        <td class="text-capitalize">{{ decryptGdprData($addon->legal_name) }}</td>
                        <td>
                            @if(checkPermission('home_line_connection_change_status',$userPermissions,$appPermissions))
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid"
                                    title="Change Status">
                                    <input class="form-check-input sweetalert_demo change-status" type="checkbox" value=""
                                        name="notifications" {{ $addon->status == 1 ? 'checked' : '' }}
                                        data-status="{{ $addon->id }}">
                                </div>
                            @else
                                --
                            @endif
                        </td>
                        <td class="text-capitalize">
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                            fill="black" />
                                    </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                @if(checkPermission('edit_home_line_connection',$userPermissions,$appPermissions))
                                    <div class="menu-item ">
                                        <a href="{{ route('addons.edit', [encryptGdprData(3), encryptGdprData($addon->id)]) }}"
                                            class="menu-link px-3"><i class="bi bi-pencil-square"></i> Edit</a>
                                    </div>
                                @endif
                                @if(checkPermission('delete_home_line_connection',$userPermissions,$appPermissions))
                                    <div class="menu-item ">
                                        <a data-id="{{ encryptGdprData($addon->id) }}" class="menu-link delete_addon px-3"><i class="bi bi-trash3"></i> Delete</a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <?php $inc++; ?>
                @elseif ($addon->category == 4)
                    <tr>
                        <td>{{ $inc }}</td>
                        <td>{{ $addon->order }}</td>
                        <td class="text-capitalize">{{ $addon->name }}</td>
                        <td class="text-capitalize">{{ $addon->connection_name }}</td>
                        <td>
                            @if(checkPermission('modem_change_status',$userPermissions,$appPermissions))
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid"
                                    title="Change Status">
                                    <input class="form-check-input sweetalert_demo change-status" type="checkbox" value=""
                                        name="notifications" {{ $addon->status == 1 ? 'checked' : '' }}
                                        data-status="{{ $addon->id }}">
                                </div>
                            @else
                                --
                            @endif
                        </td>
                        <td class="text-capitalize">
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                            fill="black" />
                                    </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                @if(checkPermission('edit_modem',$userPermissions,$appPermissions))
                                    <div class="menu-item ">
                                        <a href="{{ route('addons.edit', [encryptGdprData(4), encryptGdprData($addon->id)]) }}"
                                            class="menu-link px-3"><i class="bi bi-pencil-square"></i> Edit</a>
                                    </div>
                                @endif
                                @if(checkPermission('delete_modem',$userPermissions,$appPermissions))
                                    <div class="menu-item ">
                                        <a data-id="{{ encryptGdprData($addon->id) }}" class="menu-link delete_addon px-3"><i class="bi bi-trash3"></i> Delete</a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <?php $inc++; ?>
                @elseif ($addon->category == 5)
                    <tr>
                        <td>{{ $inc }}</td>
                        <td>{{ $addon->order }}</td>
                        <td class="text-capitalize">{{ $addon->name }}</td>
                        <td>
                            @if(checkPermission('addons_change_status',$userPermissions,$appPermissions))
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid"
                                    title="Change Status">
                                    <input class="form-check-input sweetalert_demo change-status" type="checkbox" value=""
                                        name="notifications" {{ $addon->status == 1 ? 'checked' : '' }}
                                        data-status="{{ $addon->id }}">
                                </div>
                            @else
                                --
                            @endif
                        </td>
                        <td class="text-capitalize">
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                            fill="black" />
                                    </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                @if(checkPermission('edit_addons',$userPermissions,$appPermissions))
                                    <div class="menu-item ">
                                        <a href="{{ route('addons.edit', [encryptGdprData(5), encryptGdprData($addon->id)]) }}"
                                            class="menu-link px-3"><i class="bi bi-pencil-square"></i> Edit</a>
                                    </div>
                                @endif
                                @if(checkPermission('delete_addons',$userPermissions,$appPermissions))
                                    <div class="menu-item ">
                                        <a data-id="{{ encryptGdprData($addon->id) }}" class="menu-link delete_addon px-3"><i class="bi bi-trash3"></i> Delete</a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <?php $inc++; ?>
                @endif
            @endforeach


        </tbody>

    </table>
</div>
@section('styles')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/custom/js/addons.js"></script>
    <script>
         KTMenu.createInstances();
        let dataTable = $("#addons_table").DataTable({
            responsive: false,
            searching: true,
            "sDom": "tipr",
        });
        var type= '{{ $setnav }}'
        const breadArray = [{
                title: 'Dashboard',
                link: '/',
                active: false
            },
            {
                title: type,
                link: '#',
                active: true
            },
        ];
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();
    </script>
@endsection
