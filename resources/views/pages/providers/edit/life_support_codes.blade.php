<div class="d-flex flex-column gap-7 gap-lg-10">
    <div class="card card-flush py-4">  
        <div class="card-header">
            <div class="card-title">
                <h2>Life Support Equipment</h2>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="d-flex flex-column gap-7 gap-lg-10">
                <div class="card card-flush">
                    <div class="card-header">
                        <h2></h2>
                        <div class="pull-right card-toolbar">
                            <button type="button" class="btn btn-light-primary me-3 add_edit_equipment" data-bs-toggle="modal" data-bs-target="#life_support_equipments_modal" data-action="add">+Assign Equipments</button>
                        </div>
                    </div>
                    <div class="card-body px-8 pt-0 table-responsive">
                        <table class="table border table-hover align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="life_support_equipments_table">
                            <thead>
                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                <th class="text-capitalize text-nowrap">Sr. No.</th>
                                <th class="text-capitalize text-nowrap">Title</th>
                                <th class="text-capitalize text-nowrap">Status</th>
                                <th class="text-capitalize text-nowrap">Order</th>
                                <th class="text-center text-capitalize text-nowrap">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600" id="life_support_equipments_body">
                                @forelse($provider_equipments as $key => $value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->title}}</td>
                                    <td><span>
                                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status"><input class="form-check-input change-life-support-status" data-id="{{$value->id}}" type="checkbox" data-status="{{$value->status}}" title="{{$value->status ? 'Click to disable' : 'Click to enable'}}" name="notifications" {{$value->status== 1 ? 'checked' : ''}}></div>
                                        </span></td>
                                    <td>{{$value->order}}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a type="button" class="menu-link px-3 add_edit_equipment" data-bs-toggle="modal" data-bs-target="#life_support_equipments_modal" data-status="{{$value->status}}" data-order="{{$value->order}}" data-title="{{$value->title}}" data-action="edit" data-id="{{$value->id}}" data-equipment_id="{{$value->life_support_equipment_id}}">Edit</a>
                                                <a type="button" class="menu-link px-3 delete_equipment" data-provider_id="{{$value->provider_id}}" data-id="{{$value->id}}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td valign="top" colspan="6" class="text-center">There are no records to show</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="life_support_equipments_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered mw-500px">
                    <div class="modal-content">
                        <form role="form" id="life_support_equipments_form" class="life_support_equipments_form" name="life_support_equipments_form">
                            @csrf
                            <input type="hidden" class="status" id="status" name="status" value="0">
                            <input type="hidden" class="action_type" id="action_type" name="action_type" value="">
                            <input type="hidden" class="equipment_id" id="equipment_id" name="equipment_id" value="">
                            <div class="modal-header bg-primary px-5 py-4">
                                <h2 class="fw-bolder fs-12 text-white">Assign Equipments</h2>
                                <div id="add_provider_close" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill" data-bs-dismiss="modal">
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-body scroll-y">
                                <div class="fv-row mb-5">
                                    <label class="fs-5 fw-bold form-label mb-1">Equipment</label>
                                    <div class="fv-row equipment">
                                        <select class="form-control form-control-solid form-select p-4" id="equipment" name="equipment" data-placeholder="Select">
                                            <option value="">Select</option>
                                            @forelse($all_equipments as $equipment)
                                            <option value="{{$equipment->id}}">{{$equipment->title}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-1">Order</label>
                                    <div class="fv-row order">
                                        <input type="number" class="form-control form-control-lg form-control-solid h-50px border" id="order" placeholder="" name="order" min="1">
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" id="life_support_equipments_submit" class="btn btn-primary">
                                        <span class="indicator-label">Save Changes</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-flush py-4">  
        <div class="card-header">
            <div class="card-title">
                <h2>Life Support Codes</h2>
            </div>
        </div>
        <div class="card-body p-0">
            <form role="form" id="life_support_form" class="life_support_form" name="life_support_form">
                @csrf
                <input type="hidden" name="life_support_code_id" value="">
                <input id="code_provider_id" type="hidden" name="provider_id" value="{{$provider_details[0]['user_id']}}">
                <div class="card card-flush">
                    <div class="card-body px-8">
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label required fw-bold fs-6 ">{{__('providers.lifesupport.lifesupportid.label')}}:</label>
                            <div class="col-lg-9 life_support_equip_id">
                                <select data-control="select2" class="form-select form-select-solid" name="life_support_equip_id" id="life_support_equip_id" data-placeholder="{{__('providers.lifesupport.lifesupportid.placeHolder')}}">
                                    <option value=""></option>
                                    @foreach($lifesupport as $data )
                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                    @endforeach
                                </select>
                                <span class="error text-danger"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label required fw-bold fs-6 ">{{__('providers.lifesupport.code.label')}}:</label>
                            <div class="col-lg-9 code">
                            <input type="text" class="form-control form-control-lg form-control-solid" placeholder="{{__('providers.lifesupport.code.placeHolder')}}" name="code">
                            <span class="error text-danger"></span>
                        </div>
                        </div>
                    </div>
                    <div class="card-footer px-8 pt-0">
                        <div class="pull-right">
                            <a type="reset" href="{{ theme()->getPageUrl('provider/list') }}" class="btn btn-light me-3">{!! __('buttons.cancel') !!}</a>
                            <button type="submit" class="submit_button" class="btn btn-primary">
                                @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
