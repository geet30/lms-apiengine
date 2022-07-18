<div class="d-flex flex-column gap-7 gap-lg-10">
    <!--begin::General options-->
    @if($action == 'dmo_content')
    <form name="edit_plan_info" class="dmo_form" id="dmo_form" action="{{route('settings.dmovdo')}}">
    @else
    <form name="edit_plan_info" class="dmo_form" id="tele_form" action="{{route('settings.dmovdo')}}">
    @endif
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">

                <h2>{{$type}}</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="row mb-0">

                <label class="col-lg-4 col-form-label fw-bold fs-6">Enable {{$type}}</label>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="form-check form-check-solid form-switch fv-row">
                        <input type="hidden" name="dmo_content_status" value="0">
                        @if($action == 'dmo_content')
                            @php $contentstatusclass = 'dmo_checked_status'  @endphp
                        @else
                            @php $contentstatusclass = 'tele_checked_status'  @endphp
                        @endif
                        <input class="form-check-input w-45px h-30px {{$contentstatusclass}}" type="checkbox" id="dmo_content_status" name="dmo_content_status" value="1">
                        <label class="form-check-label" for="dmo_content_status"></label>
                    </div>
                </div>

            </div>
            @if($action == 'dmo_content')
            <div class="row mb-0 considermaster">
                <label class="col-lg-4 col-form-label fw-bold fs-6">Enable {{ __('plans/energyPlans.consider_master_content') }}</label>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="form-check form-check-solid form-switch fv-row">
                        <input type="hidden" name="consider_master_content" value="0">
                        <input class="form-check-input w-45px h-30px" type="checkbox" id="consider_master_content" name="consider_master_content" value="1">
                        <label class="form-check-label" for="consider_master_content"></label>
                    </div>
                </div>
            </div>
            @endif
            <div class="row mb-6">

                <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('plans/energyPlans.dmo_parameters') }}</label>

                <div class="col-lg-8 fv-row">
                    @php $setdmoclass = 'tele_dmo_parameter' @endphp
                    @if($action == 'dmo_content') @php $setdmoclass = 'dmo_parameters' @endphp  @endif
                    <select size="5"  name="dmo_parameter" class="form-select form-select-solid form-select-lg {{$setdmoclass}}" id="dmo_parameter">
                    @foreach(getEnergyContentAttributes(1,1) as $attributes )
                        <option value="{{$attributes->attribute}}">{{$attributes->attribute}}</option>
                    @endforeach
                </select>

                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('plans/energyPlans.enter_telesale_dmo') }}</label>

                <div class="col-lg-8 fv-row field-holder">
                    @if($action == 'dmo_content')
                    <textarea class="form-control form-control-lg form-control-solid ckeditor" value="" placeholder="Plan Bonus" id="dmo_content" name="dmo_content">{{$dmoContent['dmo_vdo_content']}}</textarea>
                    @else
                    <textarea class="form-control form-control-lg form-control-solid ckeditor" value="" placeholder="Plan Bonus" name="tele_dmo_content">{{$dmoContent['dmo_vdo_content']}}</textarea>
                    @endif
                    <span class="form_error_name form_error" style="color: red;"></span>
                </div>
            </div>
            <input type="hidden"name="action_type"value="{{$action}}">
        </div>
        <input type="hidden" name="type" value="1">
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            @if($action == 'dmo_content')
            <input type="hidden" name="variant" value="1">
            <input type="hidden" name="id" value="" class="dmo_pid">
        <button type="button" class="btn btn-primary submit_button " id="copy_dmo_btn">
            @else
            <input type="hidden" name="id" value="" class="tele_pid">
            <input type="hidden" name="variant" value="2">
            <button type="button" class="btn btn-primary submit_button " id="copy_telesale_btn">
          @endif
            <span class="indicator-label">
                {{ __('plans/energyPlans.copy_content') }}
            </span>
            <span class="indicator-progress">
                Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
        </div>
        <!--end::Card header-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="{{ theme()->getPageUrl('provider/plans/energy/plan-rates/'.encryptGdprData($editRate['plan_id']))}}" id="" class="btn btn-light me-5">{{ __('plans/energyPlans.cancel') }}</a>
            @if($action == 'dmo_content')
            <button type="button" class="btn btn-primary submit_button submit_dmo_btn" id="submit_dmo_btn">
            @else
              <button type="button" class="btn btn-primary submit_button submit_tele_btn" id="submit_vdo_btn">
            @endif
                <span class="indicator-label">
                    {{ __('plans/energyPlans.save_changes') }}
                </span>
                <span class="indicator-progress">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>

            </button>
        </div>
    </div>
    </form>

    <!--end::Pricing-->
</div>
