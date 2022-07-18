<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="d-flex flex-column gap-7 gap-lg-10">
    <div class="card card-flush py-0">
        <div class="card-body px-0 pt-0">
            <div class="mb-5 detail_options">
                <ul class="flex-nowrap nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fw-bold mb-n2">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="ms-md-4 nav-link text-active-primary pb-4 dialler-tab active" data-bs-toggle="tab" data-id="1" data-name="Name" href="#name_dialler_ignore">Name</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="ms-md-4 nav-link text-active-primary pb-4 dialler-tab" data-bs-toggle="tab" data-id="2" data-name="Email" href="#email_dialler_ignore">Email</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="ms-md-4 nav-link text-active-primary pb-4 dialler-tab" data-bs-toggle="tab" data-id="3" data-name="Phone" href="#phone_dialler_ignore">Phone</a>
                    </li>
                    <li class="nav-item">
                        <a class="ms-md-4 nav-link text-active-primary pb-4 dialler-tab" data-bs-toggle="tab" data-id="4" data-name="Domain" href="#domain_dialler_ignore">Domain</a>
                    </li>
                    <li class="nav-item">
                        <a class="ms-md-4 nav-link text-active-primary pb-4 dialler-tab" data-bs-toggle="tab" data-id="5" data-name="IP Adress" href="#ips_dialler_ignore">Ips</a>
                    </li>
                    <li class="nav-item">
                        <a class="ms-md-4 nav-link text-active-primary pb-4 dialler-tab" data-bs-toggle="tab" data-id="6" data-name="IP Range" href="#iprange_dialler_ignore">Ip Range</a>
                    </li>
                </ul>
            </div>
            <div class="mb-5">
                <div class="tab-content" id="table-tab-01">
                    <div class="tab-pane fade show active" id="name_dialler_ignore" role="tab-panel">
                        <div class="pt-0 table-responsive">
                            <table class="table border table-hover table-row-dashed align-middle mx-0 fs-7 gy-2 gs-4 dt-bootstrap all-table-css-class" id="tags_table1">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 gs-0">
                                        <th class="text-capitalize text-nowrap">Sr.No.</th>
                                        <th class="text-capitalize text-nowrap">Name</th>
                                        <th class="text-capitalize text-nowrap">Comment</th>
                                        <th class="text-capitalize text-nowrap">Created On</th>
                                        <th class="text-capitalize text-nowrap">Update On</th>
                                        <th class="text-capitalize text-nowrap">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600" class="lead_table_data_body" id="tag_body_1">
                                    <?php $inc = 1; ?>
                                    @foreach($diallerDataName as $key => $val)
                                    <!-- if($val['type'] == 'name') -->
                                    <tr>
                                        <td>{{ $inc }}</td>
                                        <td>{{ $val->type_value }}</td>
                                        <td>{{ $val->comment }}</td>
                                        <td>{{ $val->created_at->format('d-m-Y h:i:s') }}</td>
                                        <td>{{ $val->updated_at->format('d-m-Y h:i:s') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
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
                                                        <span class="menu-link edit_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-action="edit" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}"><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a type="button" data-id="{{ $val->id }}" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}" class="menu-link px-3 delete_btn_dialler"><i class="bi bi-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $inc++; ?>
                                    <!-- endif -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2 customPaginationBtn" style="float: right;">
                            <button type="submit" class="btn btn-primary previous_btn paginationBtn p-2 btn-sm" data-page="{{$diallerDataName->count()}}" data-type="1" @if($diallerDataName->previousPageUrl()) data-value="{{$diallerDataName->previousPageUrl()}}" @else data-value="0" @endif>Previous</button>

                            <button type="submit" class="btn btn-primary next_btn paginationBtn p-2 btn-sm" data-page="{{ $diallerDataName->count() }}" data-type="1" @if($diallerDataName->nextPageUrl()) data-value="{{$diallerDataName->nextPageUrl()}}" @else data-value="0" @endif @if($diallerDataName->hasMorePages()) data-haspage="1" @else data-haspage="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="email_dialler_ignore" role="tab-panel">
                        <div class="pt-0 table-responsive">
                            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="tags_table2">
                                <thead>
                                    <tr class="fw-bolder fs-7 text-gray-800 px-7">
                                        <th class="text-capitalize text-nowrap">Sr.No.</th>
                                        <th class="text-capitalize text-nowrap">Email</th>
                                        <th class="text-capitalize text-nowrap">Comment</th>
                                        <th class="text-capitalize text-nowrap">Created On</th>
                                        <th class="text-capitalize text-nowrap">Update On</th>
                                        <th class="text-capitalize text-nowrap">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600" class="lead_table_data_body" id="tag_body_2">
                                    <?php $inc = 1; ?>
                                    @foreach($diallerDataEmail as $key => $val)
                                    <!-- if($val['type'] == 'email') -->
                                    <tr>
                                        <td>{{ $inc }}</td>
                                        <td>{{ $val->type_value }}</td>
                                        <td>{{ $val->comment }}</td>
                                        <td>{{ $val->created_at->format('d-m-Y h:i:s') }}</td>
                                        <td>{{ $val->updated_at->format('d-m-Y h:i:s') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
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
                                                        <span class="menu-link edit_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-action="edit" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}"><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a type="button" data-id="{{ $val->id }}" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}" class="menu-link px-3 delete_btn_dialler"><i class="bi bi-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $inc++; ?>
                                    <!-- endif -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2" style="float: right;">
                            <button type="submit" class="btn btn-primary previous_btn paginationBtn p-2 btn-sm" data-page="{{$diallerDataEmail->count()}}" data-type="2" @if($diallerDataEmail->previousPageUrl()) data-value="{{$diallerDataEmail->previousPageUrl()}}" @else data-value="0" @endif>Previous</button>

                            <button type="submit" class="btn btn-primary next_btn paginationBtn p-2 btn-sm" data-page="{{ $diallerDataEmail->count() }}" data-type="2" @if($diallerDataEmail->nextPageUrl()) data-value="{{$diallerDataEmail->nextPageUrl()}}" @else data-value="0" @endif @if($diallerDataEmail->hasMorePages()) data-haspage="1" @else data-haspage="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="phone_dialler_ignore" role="tab-panel">
                        <div class="pt-0 table-responsive">
                            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="tags_table3">
                                <thead>
                                    <tr class="fw-bolder fs-7 text-gray-800 px-7">
                                        <th class="text-capitalize text-nowrap">Sr.No.</th>
                                        <th class="text-capitalize text-nowrap">Phone</th>
                                        <th class="text-capitalize text-nowrap">Comment</th>
                                        <th class="text-capitalize text-nowrap">Created On</th>
                                        <th class="text-capitalize text-nowrap">Update On</th>
                                        <th class="text-capitalize text-nowrap">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600" class="lead_table_data_body" id="tag_body_3">
                                    <?php $inc = 1; ?>
                                    @foreach($diallerDataPhone as $key => $val)
                                    <!-- if($val['type'] == 'phone') -->
                                    <tr>
                                        <td>{{ $inc }}</td>
                                        <td>{{ $val->type_value }}</td>
                                        <td>{{ $val->comment }}</td>
                                        <td>{{ $val->created_at->format('d-m-Y h:i:s') }}</td>
                                        <td>{{ $val->updated_at->format('d-m-Y h:i:s') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <span class="menu-link edit_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-action="edit" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}"><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a type="button" data-id="{{ $val->id }}" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}" class="menu-link px-3 delete_btn_dialler"><i class="bi bi-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                                <!--  -->
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $inc++; ?>
                                    <!-- endif -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2" style="float: right;">
                            <button type="submit" class="btn btn-primary previous_btn paginationBtn p-2 btn-sm" data-page="{{$diallerDataPhone->count()}}" data-type="3" @if($diallerDataPhone->previousPageUrl()) data-value="{{$diallerDataPhone->previousPageUrl()}}" @else data-value="0" @endif>Previous</button>

                            <button type="submit" class="btn btn-primary next_btn paginationBtn p-2 btn-sm" data-page="{{ $diallerDataPhone->count() }}" data-type="3" @if($diallerDataPhone->nextPageUrl()) data-value="{{$diallerDataPhone->nextPageUrl()}}" @else data-value="0" @endif @if($diallerDataPhone->hasMorePages()) data-haspage="1" @else data-haspage="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="domain_dialler_ignore" role="tab-panel">
                        <div class="pt-0 table-responsive">
                            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" class="tags_table">
                                <thead>
                                    <tr class="fw-bolder fs-7 text-gray-800 px-7">
                                        <th class="text-capitalize text-nowrap">Sr.No.</th>
                                        <th class="text-capitalize text-nowrap">Domain</th>
                                        <th class="text-capitalize text-nowrap">Comment</th>
                                        <th class="text-capitalize text-nowrap">Created On</th>
                                        <th class="text-capitalize text-nowrap">Update On</th>
                                        <th class="text-capitalize text-nowrap">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600" class="lead_table_data_body" id="tag_body_4">
                                    <?php $inc = 1; ?>
                                    @foreach($diallerDataDomain as $key => $val)
                                    <!-- if($val['type'] == 'domain') -->
                                    <tr>
                                        <td>{{ $inc }}</td>
                                        <td>{{ $val->type_value }}</td>
                                        <td>{{ $val->comment }}</td>
                                        <td>{{ $val->created_at->format('d-m-Y h:i:s') }}</td>
                                        <td>{{ $val->updated_at->format('d-m-Y h:i:s') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
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
                                                        <span class="menu-link edit_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-action="edit" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}"><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a type="button" data-id="{{ $val->id }}" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}" class="menu-link px-3 delete_btn_dialler"><i class="bi bi-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $inc++; ?>
                                    <!-- endif -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2" style="float: right;"> 
                            <button type="submit" class="btn btn-primary previous_btn paginationBtn p-2 btn-sm" data-page="{{$diallerDataDomain->count()}}" data-type="4" @if($diallerDataDomain->previousPageUrl()) data-value="{{$diallerDataDomain->previousPageUrl()}}" @else data-value="0" @endif>Previous</button>

                            <button type="submit" class="btn btn-primary next_btn paginationBtn p-2 btn-sm" data-page="{{ $diallerDataDomain->count() }}" data-type="4" @if($diallerDataDomain->nextPageUrl()) data-value="{{$diallerDataDomain->nextPageUrl()}}" @else data-value="0" @endif @if($diallerDataDomain->hasMorePages()) data-haspage="1" @else data-haspage="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="ips_dialler_ignore" role="tab-panel">
                        <div class="pt-0 table-responsive">
                            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="tags_table4">
                                <thead>
                                    <tr class="fw-bolder fs-7 text-gray-800 px-7">
                                        <th class="text-capitalize text-nowrap">Sr.No.</th>
                                        <th class="text-capitalize text-nowrap">IPS</th>
                                        <th class="text-capitalize text-nowrap">Comment</th>
                                        <th class="text-capitalize text-nowrap">Created On</th>
                                        <th class="text-capitalize text-nowrap">Update On</th>
                                        <th class="text-capitalize text-nowrap">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600" class="lead_table_data_body" id="tag_body_5">
                                    <?php $inc = 1; ?>
                                    @foreach($diallerDataIp as $key => $val)
                                    <!-- if($val['type'] == 'ip') -->
                                    <tr>
                                        <td>{{ $inc }}</td>
                                        <td>{{ $val->type_value }}</td>
                                        <td>{{ $val->comment }}</td>
                                        <td>{{ $val->created_at->format('d-m-Y h:i:s') }}</td>
                                        <td>{{ $val->updated_at->format('d-m-Y h:i:s') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
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
                                                        <span class="menu-link edit_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-action="edit" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}"><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a type="button" data-id="{{ $val->id }}" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}" class="menu-link px-3 delete_btn_dialler"><i class="bi bi-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $inc++; ?>
                                    <!-- endif -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2" style="float: right;">
                            <button type="submit" class="btn btn-primary previous_btn paginationBtn p-2 btn-sm" data-page="{{$diallerDataIp->count()}}" data-type="5" @if($diallerDataIp->previousPageUrl()) data-value="{{$diallerDataIp->previousPageUrl()}}" @else data-value="0" @endif>Previous</button>

                            <button type="submit" class="btn btn-primary next_btn paginationBtn p-2 btn-sm" data-page="{{ $diallerDataIp->count() }}" data-type="5" @if($diallerDataIp->nextPageUrl()) data-value="{{$diallerDataIp->nextPageUrl()}}" @else data-value="0" @endif @if($diallerDataIp->hasMorePages()) data-haspage="1" @else data-haspage="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="iprange_dialler_ignore" role="tab-panel">
                        <div class="pt-0 table-responsive">
                            <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" class="tags_table5">
                                <thead>
                                    <tr class="fw-bolder fs-7 text-gray-800 px-7">
                                        <th class="text-capitalize text-nowrap">Sr.No.</th>
                                        <th class="text-capitalize text-nowrap">IP Range</th>
                                        <th class="text-capitalize text-nowrap">Comment</th>
                                        <th class="text-capitalize text-nowrap">Created On</th>
                                        <th class="text-capitalize text-nowrap">Update On</th>
                                        <th class="text-capitalize text-nowrap">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600" class="lead_table_data_body" id="tag_body_6">
                                    <?php $inc = 1; ?>
                                    @foreach($diallerDataIpRange as $key => $val)
                                    <!-- if($val['type'] == 'ip_range') -->
                                    <tr>
                                        <td>{{ $inc }}</td>
                                        <td>{{ $val->type_value }}</td>
                                        <td>{{ $val->comment }}</td>
                                        <td>{{ $val->created_at->format('d-m-Y h:i:s') }}</td>
                                        <td>{{ $val->updated_at->format('d-m-Y h:i:s') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
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
                                                        <span class="menu-link edit_btn_popup" data-bs-toggle="modal" data-bs-target="#dialler_ignore_data_modal" data-action="edit" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}"><i class="bi bi-pencil-square"></i> {{ __('buttons.edit') }}</span>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a type="button" data-id="{{ $val->id }}" data-type="{{ $val->type }}" data-value="{{ $val->type_value  }}" data-comment="{{ $val->comment  }}" class="menu-link px-3 delete_btn_dialler"><i class="bi bi-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $inc++; ?>
                                    <!-- endif -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2" style="float: right;">
                            <button type="submit" class="btn btn-primary previous_btn paginationBtn p-2 btn-sm" data-page="{{$diallerDataIpRange->count()}}" data-type="6" @if($diallerDataIpRange->previousPageUrl()) data-value="{{$diallerDataIpRange->previousPageUrl()}}" @else data-value="0" @endif>Previous</button>

                            <button type="submit" class="btn btn-primary next_btn paginationBtn p-2 btn-sm" data-page="{{ $diallerDataIpRange->count() }}" data-type="6" @if($diallerDataIpRange->nextPageUrl()) data-value="{{$diallerDataIpRange->nextPageUrl()}}" @else data-value="0" @endif @if($diallerDataIpRange->hasMorePages()) data-haspage="1" @else data-haspage="0" @endif>Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('styles')
<link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/custom/js/loader.js"></script>
<script src="/custom/js/breadcrumbs.js"></script>
@include('pages.settings.dialler-Ignore-data.components.js');
<script>
    KTMenu.createInstances();
    // let dataTable = $("#tags_table1, #tags_table2, #tags_table4, #tags_table5, #tags_table6").DataTable({
    //     responsive: false,
    //     searching: true,
    //     "sDom": "tipr",
    // });
</script>
@endsection