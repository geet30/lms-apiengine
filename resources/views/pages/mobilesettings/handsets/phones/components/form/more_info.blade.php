<div class="tab-pane fade" id="more_info" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('handset.formPage.more_info.sectionTitle')}}</h3>
            </div>
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                <button type="button" class="btn btn-light-primary collapsible collapsed me-3 add_more_info" id="add_more_info" data-bs-toggle="modal"  data-bs-target="#add_more_info_modal" >+{{ __ ('handset.formPage.more_info.addMoreInfoButton')}}</button>

            </div>
        </div>

        <div class="card-body pt-0 table-responsive " id="">
            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class"
                id="phones_more_info_table">
                <thead>
                    <tr class="fw-bolder fs-7 text-gray-800 px-7">

                        <th class="text-capitalize text-nowrap">Sr.No.</th>
                        <th class="text-capitalize text-nowrap">Title</th>
                        <th class="text-nowrap">URL</th>
                        <th class="text-capitalize text-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600" id="phones_more_info_tbody">
                  @foreach($handsetInfoList as $list)
                    <tr>
                        <td>{{ $list->s_no }}</td>
                        <td>{{ $list->title }}</td>
                        <td>
                            <a href="{{$list->image}}" target="_blank" rel="noopener noreferrer">
                                <span class="text-sky-800 text-hover-primary fs-5 fw-bolder">View</span>
                            </a>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{ __ ('mobile.formPage.planRef.actions')}}

                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>

                            </a>

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">

                                <div class="menu-item px-3">
                                    <a href="javascript:void(0)" class="menu-link px-3 edit-handset-info-modal" data-id="{{$list->id}}" data-s_no="{{$list->s_no}}" data-title="{{$list->title}}" data-image="{{ $list->image }}" data-linktype="{{ $list->linktype }}">{{ __ ('buttons.edit')}}</a>
                                </div>

                                <div class="menu-item px-3">
                                    <a href="javascript:void(0)" class="menu-link px-3 delete-handset-info-modal" data-id="{{$list->id}}" data-kt-ecommerce-order-filter="delete_row">{{ __ ('buttons.delete')}}</a>
                                </div>

                            </div>

                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
<!--end::Content-->
