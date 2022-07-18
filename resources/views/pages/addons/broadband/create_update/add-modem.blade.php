<div class="card mb-5 mb-xl-10">
    <form role="form" name="add_modem_form" id="add_modem_form">
        @csrf
        <input type="hidden" name="category" value={{ $addonType }}>
        <input type="hidden" name="addon_id" value={{ isset($addon) ? encryptGdprData($addon['id']) : '' }}>
        <div class="card card-flush py-4">
            <div class="card-header">
                @if (isset($addon) && $addon['category'] == 4)
                    <div class="card-title">
                        <h2>Edit Modem</h2>
                    </div>
                @else
                    <div class="card-title">
                        <h2>Add Modem</h2>
                    </div>
                @endif

            </div>
            <div class="card-body">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Modem Modal Name</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="name" class="form-control form-control-lg form-control-solid"
                            placeholder="Enter Modem Modal Name"
                            value="{{ old('name') ? old('name') : (isset($addon) ? $addon['name'] : '') }}" />
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Connection Type</label>
                    <div class="col-lg-8 fv-row">
                        <select data-control="select2" id="connection_type"
                            class="form-select-solid form-select" name="connection_type"
                            class="connection_type_event">
                            <option value="">Select Connection Type</option>
                            @foreach ($connections as $connection)
                                <option value="{{ $connection['id'] }}"
                                    {{ isset($addon) && $addon['connection_type'] == $connection['id'] ? 'selected' : '' }}>
                                    {{ $connection['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Technology Type</label>
                    <div class="col-lg-8 fv-row">
                        <select name="tech_type[]" aria-label="Select Technology Type" data-control="select2"
                            data-placeholder="Select Technology Type"
                            class="form-select form-select-solid form-select-lg tech_type_event" multiple="multiple">
                            @if (isset($technologies))
                                @foreach ($technologies as $technology)
                                        <option value="{{ $technology->id }}"
                                            {{ isset($selectedTechnologies) && in_array($technology->id,array_column($selectedTechnologies,'tech_type')) ? 'selected' : '' }}>
                                            {{ $technology->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="error text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Order</label>
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="order" class="form-control form-control-lg form-control-solid"
                            placeholder="Order"
                            value="{{ old('order') ? old('order') : (isset($addon) ? $addon['order'] : '') }}"  min="1"/>
                        <span class="error text-danger"></span>
                    </div>

                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Description</label>
                    <div class="col-lg-8 fv-row">
                        <textarea type="text" id="description" class="form-control form-control-lg ckeditor"
                            tabindex="8" placeholder="" rows="5" name="description"
                            style="display: none;">{{ old('description') ? old('description') : (isset($addon) ? $addon['description'] : '') }}</textarea>
                        <span class="error text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a class="btn btn-light btn-active-light-primary me-2" href="{{ theme()->getPageUrl('addons/modem/list') }}">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

    </form>
</div>
