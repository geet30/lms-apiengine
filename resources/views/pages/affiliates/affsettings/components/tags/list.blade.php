    <div class="card mb-0">

        <div id="kt_affliate_form_details" class="">

            <div class=" card-body border-top p-9">
                <form class="" method="post" action='/affiliates/savetags' id="aff_tag_form">
                    <input type="hidden" value="{{encryptGdprData($records['id'])}}" id="tag_user_id" name="user_id">
                    @csrf
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label  fs-6">{{__('affiliates_label.tags.select_tag')}}</label>
                        <div class="col-lg-8 fv-row">
                            <select data-control="select2" id="tagselect" class="form-control form-control-solid form-select" name="tag_id">
                                <option>Select Tag </option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label  fs-6">{{__('affiliates_label.tags.select_role')}}</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <div class="form-check form-switch form-check-custom form-check-solid">

                                    <input class="form-check-input" type="checkbox" id="is_any_time" name="is_any_time" value="1">
                                    <span class=" ps-2 fs-6 form-check ">
                                        {{__('affiliates_label.tags.any_time_on_system')}}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <div class="form-check form-switch form-check-custom form-check-solid">

                                    <input class="form-check-input" type="checkbox" id="is_remarketing" name="is_remarketing" value="1">
                                    <span class=" ps-2 fs-6 form-check ">
                                        {{__('affiliates_label.tags.remarketing_allow')}}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <div class="form-check form-switch form-check-custom form-check-solid">

                                    <input class="form-check-input" type="checkbox" id="is_advertisement" name="is_advertisement" value="1">
                                    <span class=" ps-2 fs-6 form-check ">
                                        {{__('affiliates_label.tags.advertise_allow')}}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <div class="form-check form-switch form-check-custom form-check-solid">

                                    <input class="form-check-input" type="checkbox" id="is_cookies" name="is_cookies" value="1">
                                    <span class=" ps-2 fs-6 form-check ">
                                        {{__('affiliates_label.tags.cookies_allow')}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9 border-0">
                <a href="{{ theme()->getPageUrl('affiliates/list') }}" class="btn btn-white btn-active-light-primary me-2">{{ __('buttons.cancel') }}</a>
                <button type="submit" class="btn btn-primary submit_button" id="aff_tag_btn">
                    <span class=" indicator-label">
                        {{ __('buttons.save') }}
                    </span>
                </button>
            </div>
        </div>
    </div>