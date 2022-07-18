<div class="pt-0  table-responsive">
    <table class="table border table-hover table-hov$info == 'sub-affiliates'er align-middle table-row-dashed fs-7 gy-2 gs-4 all-table-css-class" id="affiliate_table">
        <thead>
            <tr class="text-start text-gray-400 fw-bolder fs-7">
                <th class="w-10px pe-2" data-orderable="false">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input check-all" type="checkbox" data-kt-check="true" data-kt-check-target="#affiliate_table .check-all" value="1" />
                    </div>
                </th>
                <th class="text-capitalize text-nowrap">{{__('variants.srno')}}</th>
                <th class="text-capitalize text-nowrap">{{__('variants.vname')}}</th>
                <th class="text-capitalize text-nowrap">{{__('variants.color')}}</th>
                <th class="text-capitalize text-nowrap">{{__('variants.ram')}}</th>
                <th class="text-capitalize text-nowrap">{{__('variants.storage')}}</th>
                <th class="text-capitalize text-nowrap">{{__('variants.status')}}</th>
                <th class="text-capitalize text-nowrap">{{__('variants.images')}}</th>
                <th class="text-capitalize text-nowrap">{{__('variants.actions')}}</th>
            </tr>
        </thead>
        <tbody id="dynamicContent">
            @forelse ($variants as $index => $variant)
            <tr>
                <td>
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input check-all row-checkbox" type="checkbox" value="{{ $variant->id }}" data-name="{{ $variant->variant_name }}"   />
                    </div>
                </td>
                <td>{{$index+1}}</td>
                <td>{{$variant->variant_name}}</td>
                <td>
                    <span class="fa fa-square" style="color:{{ $variant->color->hexacode }} "></span>
                    {{$variant->color->title}}
                </td>
                <td>
                    {{$variant->capacity->value}}
                    @switch ($variant->capacity->unit)
                    @case (0)
                        MB
                        @break
                    @case (1)
                        GB
                        @break
                    @case (2)
                        TB
                        @break
                    @default
                        Invalid
                    @endswitch
                </td>
                <td>
                    {{$variant->internal->value}}
                    @switch ($variant->internal->unit)
                    @case (0)
                        MB
                        @break
                    @case (1)
                        GB
                        @break
                    @case (2)
                        TB
                        @break
                    @default
                        Invalid
                    @endswitch
                </td>
                <td>
                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" title="Change Status">
                        <input class="form-check-input variantstatus change-status" type="checkbox" name="notifications" @if ($variant->status) checked @endif data-id="{{$variant->id}}">
                    </div>
                </td>
                <td>
                    @if(count($variant->images) > 0)
                        <img src="{{$variant->all_images[0]->image}}" width="25px" height="51px" class="img-pop">
                    @else
                        <img src="{{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }}" width="32px" height="31px" class="img-pop">
                    @endif
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{__('variants.actions')}}
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                        <div class="menu-item">
                            <a href="{{ route('edit.variant', ['id' => $handsetId ,'variantid' => encryptGdprData($variant->id), 'mode' => theme()->getCurrentMode() ]) }}" class="menu-link "><i class="bi bi-pencil-square"></i>{{__('variants.edit')}}</a>
                        </div>
                        <div class="menu-item">
                            <a href="" class="menu-link "><i class="bi bi-trash"></i>{{__('variants.delete')}}</a>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="10" align="center">{{ __('variants.norecord') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@section('scripts')
<script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/custom/js/breadcrumbs.js"></script>
@include('pages.mobilesettings.variants.table_js');
@endsection
