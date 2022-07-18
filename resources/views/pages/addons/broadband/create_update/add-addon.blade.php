<div class="card mb-5 mb-xl-10">
    <form role="form" name="add_addon_from" id="add_addon_form">
        @csrf
        <input type="hidden" name="category" value={{ $addonType }}>
        <input type="hidden" name="addon_id" value={{ (isset($addon)? encryptGdprData($addon['id']):'') }}>
        <div class="card card-flush py-4">
            <div class="card-header">
                @if (isset($addon) && $addon['category'] == 5)
                    <div class="card-title">
                        <h2>Edit Additional Addons</h2>
                    </div>
                @else
                    <div class="card-title">
                        <h2>Add Additional Addons</h2>
                    </div>
                @endif

            </div>
            <div class="card-body">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Addon Title</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="name" class="form-control form-control-lg form-control-solid"
                            placeholder="Enter Addon Title"
                            value="{{old('name')? old('name'):(isset($addon)?$addon['name']:'')}}"/>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Order</label>
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="order" class="form-control form-control-lg form-control-solid" placeholder="Order" value="{{old('order')? old('order'):(isset($addon)?$addon['order']:'')}}"  min="1"/>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Specifications</label>
                    <div class="col-lg-8 fv-row">
                        <textarea type="text" class="form-control form-control-lg ckeditor" tabindex="8" placeholder="" rows="5" name="description" style="display: none;">{{old('description')? old('description'):(isset($addon)?$addon['description']:'')}}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a class="btn btn-light btn-active-light-primary me-2" href="{{ theme()->getPageUrl('addons/additional-addons/list') }}">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

    </form>
</div>
