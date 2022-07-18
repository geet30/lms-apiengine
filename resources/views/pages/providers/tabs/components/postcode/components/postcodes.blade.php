<div class="px-8 assigned_postcodes mb-5">
    <form name="postcodes_assign_form" id="postcodes_assign_form">
        <input class="user_id" type="hidden" name="user_id" value="{{$user_id}}">
        <div class="col-md-12 distributors my-1 my-md-0">
            <select id="provider_postcodes" class="form-control form-control-solid form-select select2-hidden-accessible min-h-45px" data-control="select2" multiple tabindex="-1" aria-hidden="true" name="provider_postcodes[]" data-select2-id="select2-data-provider_postcodes" data-placeholder="Select postcodes" data-allow-clear="true">
                <option value=""></option>
            </select>
            <span class="errors text-danger"></span>
        </div>

        <div class="row mt-3">
            <div class="col-md-12 text-end">
                <a href="{{route('provider.list')}}" id="" class="btn btn-light me-3">Cancel</a>
                <button type="button" class="btn btn-light-primary postcodes_assign_form_submit_btn">Save Changes</button>
            </div>
        </div>
    </form>
</div>
