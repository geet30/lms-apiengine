<div class="card mb-5 mb-xl-10">
    <form role="form" name="add_home_connection_form" id="add_home_connection_form" >
        @csrf
        <input type="hidden" name="category" value={{ $addonType }}>
        <input type="hidden" name="addon_id" value={{ (isset($addon)? encryptGdprData($addon['id']):'') }}>
        <div class="card card-flush py-4">
            <div class="card-header">
                @if (isset($addon) && $addon['category'] == 3)
                
                <div class="card-title">
                    <h2>Edit Home Connection</h2>
                </div>
                @else
                <div class="card-title">
                    <h2>Add Home Connection</h2>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Provider</label>
                    <div class="col-lg-8 fv-row">
                        <select data-control="select2" class="form-select-solid form-select" name="provider_id">
                            <option value="">Select Provider</option>
                            @foreach ($providers as $provider)
                            <option value="{{ $provider['user_id'] }}" {{(isset($addon) && $addon['provider_id'] == $provider['user_id'])?'selected':''}}>{{ $provider['legal_name'] }}</option>
                            @endforeach
                        </select>
                        <span class="error text-danger"></span>

                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Call Plan Name</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="Enter Call Plan Name" value="{{old('name') ? old('name'):(isset($addon)?$addon['name']:'')}}"/>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Call Plan Cost Type</label>
                    <div class="col-lg-8 fv-row">
                        <select data-control="select2" class="form-select-solid form-select" name="cost_type_id">
                            <option value="">Select Cost Type</option>
                            <option value="1" {{(isset($addon) && $addon['cost_type_id'] == 1)?'selected':''}}>Monthly</option>
                            <option value="2" {{(isset($addon) && $addon['cost_type_id'] == 2)?'selected':''}}>Upfront</option>
                        </select>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Call Plan Cost</label>
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="cost" class="form-control form-control-lg form-control-solid" placeholder="Enter Call Plan Cost" value="{{old('cost')? old('cost'):(isset($addon)? $addon['cost']:'')}}"  min="0" step="any"/>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Order</label>
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="order" id="order" class="form-control form-control-lg form-control-solid" placeholder="Order" value="{{old('order')? old('order'):(isset($addon)?$addon['order']:'')}}"  min="1"/>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Call Plan Inclusions</label>
                    <div class="col-lg-8 fv-row">
                        <textarea type="text" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="inclusion" style="display: none;">{{old('inclusion')? old('inclusion'):(isset($addon)?$addon['inclusion']:'')}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Calling Plan Detail</label>
                    <div class="col-lg-8 fv-row">
                        <textarea type="text"  class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="description" style="display: none;">{{old('description')? old('description'):(isset($addon)?$addon['description']:'')}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Script</label>
                    <div class="col-lg-8 fv-row">
                        <textarea type="text" id="script" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="script" style="display: none;">{{old('script')? old('script'):(isset($addon)?$addon['script']:'')}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a class="btn btn-light btn-active-light-primary me-2" href="{{ theme()->getPageUrl('addons/home-line-connection/list') }}">Cancel</a>
                    <button type="submit" class="submit_button" class="btn btn-primary">Save</button>
                </div>
        </div>

    </form>
</div>