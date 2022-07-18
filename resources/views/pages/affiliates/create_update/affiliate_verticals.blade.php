<div class="px-8 py-2">
    <div class="d-flex align-items-top position-relative gap-5 my-1">
        <div class="col-lg-6 fv-row service">
            <select  name="service[]" id="service" class="fav_clr form-control form-control-lg form-control-solid" multiple="" tabindex="-1" aria-hidden="true">
            <option value="select_all">{{ __('Select All') }}</option>
                @foreach($services as $row)
                <option value="{{ $row->id }}">
                    {{$row->service_title}}
                </option>
                @endforeach
            </select>
            <span class="error text-danger"></span>

        </div>
        <div class="col-lg-6 px-5" style="text-align:right;">
        <input type="hidden" class="request_form" value="{{$type }}"/>
        <input type="hidden" class="affiliate_user_id" value="{{@encryptGdprData($affiliateuser[0]['user_id'])}}">
        <button type="submit" class="submit_button submitVertical btn btn-light-primary">
            @include('partials.general._button-indicator', ['label' => __('+Assign')])
        </button>
        </div>
    </div>
</div>
@include("pages.affiliates.create_update.verticals_listing")
