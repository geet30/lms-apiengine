<x-base-layout>
    <div class="card mb-5 mb-xl-10">
        <form role="form" name="{{$name}}" id="add_handset_variant_form">
            <div class="card card-flush py-4">
                <div class="card-body pt-0">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('variants.vname') }}</label>
                        <div class="col-lg-8 fv-row variant_name">
                            <input type="text" name="variant_name" class="form-control form-control-lg form-control-solid" placeholder="{{ __('variants.vname') }}" value="{{ $variant->variant_name  ?? ''}}" />
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col ram">
                            <label class=" form-label mb-5 required">{{ __('variants.ram') }}</label>
                            <select name="ram" class="form-control form-control-solid form-select" data-control="select2"  data-placeholder="{{__('variants.ram')}}">
                                <option value="">{{ __('variants.ram') }}</option>
                                @foreach($capacity as $cap)
                                    @if($cap->id == @$variant->capacity_id)
                                        <option value="{{ $cap->id }}" selected> {{ $cap->capacity_name }}
                                    @else
                                        <option value="{{ $cap->id }}">{{ $cap->capacity_name }}
                                    @endif
                                @endforeach
                            </select>
                            <span class="error text-danger"></span>
                        </div>
                        <div class="col internal_storage">
                            <label class=" form-label mb-5 required">{{ __('variants.storage') }}</label>
                            <select name="internal_storage" class="form-control form-control-solid form-select" data-control="select2"  data-placeholder="{{__('variants.storage')}}">
                                <option value="">{{ __('variants.storage') }}</option>
                                @foreach($storage as $storages)
                                    @if($storages->id == @$variant->internal_stroage_id)
                                        <option value="{{ $storages->id }}" selected> {{ $storages->storage_name }}
                                    @else
                                        <option value="{{ $storages->id }}">{{ $storages->storage_name }}
                                    @endif
                                @endforeach
                            </select>
                            <span class="error text-danger"></span>
                        </div>
                        <div class="col color">
                            <label class="form-label mb-5 required">{{ __('variants.color') }}</label>
                            <select name="color" class="form-control form-control-solid form-select" data-control="select2"  data-placeholder="{{__('variants.color')}}">
                                <option value="">{{ __('variants.color') }}</option>
                                @foreach($colors as $color)
                                    @if($color->id == @$variant->color_id)
                                       <option value="{{$color->id}}" selected> {{ $color->title }}
                                    @else
                                        <option value="{{$color->id}}">{{ $color->title }}
                                    @endif
                                @endforeach
                            </select>
                            <span class="error text-danger"></span>
                        </div>
                    </div>
                    <?php $img_type = array('0' => 'Front Image','1' => 'Side Image','2' =>'Back Image'); ?>
                    @if(!empty($variant->all_images))
                        <div id="add_more_images" class="field_wrapper">
                            @for($i=1;$i<= count($variant->all_images) ;$i++)
                                <div class="row mb-6_{{ $i-1 }}">
                                    <div class="col s_no_{{ $i-1 }}">
                                        <label class=" form-label mb-5 required">{{ __('variants.image_order') }}</label>
                                        <input type="text" id="img_order[]" name="s_no[]" class="form-control form-control-lg form-control-solid" placeholder="" value="{{ $variant->all_images[$i-1]->sr_no}}"  />
                                        <input type="hidden" id="id_of_img" name="id_of_img[]" value="{{ $variant->all_images[$i-1]->id }}">
                                        <span class="error text-danger"></span>
                                    </div>

                                    <div class="col img_type_{{ $i-1 }}">
                                        <label class=" form-label mb-5 required">{{ __('variants.image_type') }}</label>
                                        <select name="img_type[]" class="form-control form-control-solid form-select"  data-placeholder="{{__('variants.storage')}}">
                                            <option value="">Select Image type</option>
                                            @foreach($img_type as $key => $value)
                                                @if($key == $variant->all_images[$i-1]->type)
                                                    <option value="{{ $key }}" selected> {{ $value }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>

                                    <div class="col sel_img_{{ $i-1 }}">
                                        <label class="form-label mb-5 required">{{ __('variants.select_image') }}</label>
                                        <img src="{{$variant->all_images[$i-1]->image}}" width="30px" height="60px" class="img-pop" style="cursor: pointer;">
                                        <input type="file" name="sel_img[]" class="form-control form-control-lg form-control-solid" />
                                        <span class="error text-danger"></span>
                                    </div>

                                    @if($i > 3)
                                        <a href="javascript:void(0);" data-id="{{ $i }}" data-img-id="{{ encryptGdprData($variant->all_images[$i-1]->id) }}" class="delrow"><i class="bi bi-trash fs-2 mx-1 text-primary"></i></a>
                                    @endif

                                </div>
                            @endfor
                        </div>
                    
                    @else

                        <div id="add_more_images" class="field_wrapper">
                            @for($i=1;$i<=3;$i++)
                            <div class="row mb-6">
                                <div class="col s_no_{{ $i-1 }}">
                                    <label class=" form-label mb-5 required">{{ __('variants.image_order') }}</label>
                                    <input type="text" id="img_order[]" name="s_no[]" class="form-control form-control-lg form-control-solid" placeholder="" value="{{ $i }}"  />
                                    <span class="error text-danger"></span>
                                </div>

                                <div class="col img_type_{{ $i-1 }}">
                                    <label class=" form-label mb-5 required">{{ __('variants.image_type') }}</label>
                                    <select name="img_type[]" class="form-control form-control-solid form-select"  data-placeholder="{{__('variants.storage')}}">
                                        <option value="">Select Image type</option>
                                        @foreach($img_type as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error text-danger"></span>
                                </div>

                                <div class="col sel_img_{{ $i-1 }}">
                                    <label class="form-label mb-5 required">{{ __('variants.select_image') }}</label>
                                    <input type="file" name="sel_img[]" class="form-control form-control-lg form-control-solid" />
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                            @endfor
                        </div>

                    @endif


                    <a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field">Add More</a>
                    <input type="hidden" name="handset_id" value="{{$handsetId }}">
                    <input type="hidden" name="id" value="{{ $variantId  ?? ''}}">
                    <div class="card-footer d-flex justify-content-end py-6 px-0 border-0">
                        <a href="{{ theme()->getPageUrl('/mobile/list-variant/'.$handsetId) }}" class="btn btn-white btn-active-light-primary me-2">{!! __('buttons.cancel') !!}</a>
                        <button type="submit" class="submit_button" class="btn btn-primary">
                            @include('partials.general._button-indicator', ['label' => __('buttons.save')])
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @section('scripts')
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/custom/js/breadcrumbs.js"></script>
    @include('pages.mobilesettings.variants.js');
    @include('pages.mobilesettings.variants.img-modal');
    @endsection
</x-base-layout>


