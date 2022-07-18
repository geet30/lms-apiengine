<div class="d-flex flex-column gap-7 gap-lg-10">
    @if($action == 'withoutcondtionaldiscount')
        <form name="edit_plan_info"  id="dmo_form">
    @elseif($action == 'withpayontimediscount')
        <form name="edit_plan_info1" id="dmo_form1" >
    @elseif($action == 'withdirectdebitdiscount')
        <form name="edit_plan_info2" id="dmo_form2" >
    @else
        <form name="edit_plan_info3" id="dmo_form3" >
    @endif
        <div class="card card-flush py-4">
            <div class="card-body pt-0">
                @php $wcd = '' @endphp
                @php $wcdId = '' @endphp
                @php $wptd = '' @endphp
                @php $wptdId = '' @endphp
                @php $wddd = '' @endphp
                @php $wdddId = '' @endphp
                @php $wbp = '' @endphp
                @php $wbpId = '' @endphp
                @if(count($result)>0)
                @foreach($result as $data )
                    @if($data->variant == 1)
                        @php $wcd = $data->dmo_vdo_content  @endphp
                        @php $wcdId = $data->id @endphp
                    @endif

                    @if($data->variant == 2)
                        @php $wptd = $data->dmo_vdo_content  @endphp
                        @php $wptdId = $data->id @endphp
                    @endif

                    @if($data->variant == 3)
                        @php $wddd = $data->dmo_vdo_content  @endphp
                        @php $wdddId = $data->id @endphp
                    @endif

                    @if($data->variant == 3)
                        @php $wbp = $data->dmo_vdo_content  @endphp
                        @php $wbpId = $data->id @endphp
                    @endif

                @endforeach

                @endif
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('plans/energyPlans.dmo_parameters') }}</label>
                    <div class="col-lg-8 fv-row">
                        <input type="hidden" name="action_type" value="{{$action}}" >
                        <input type="hidden" name="type" value="2">
                        @if($action == 'withoutcondtionaldiscount')
                        <input type="hidden" name="variant" value="1">
                        <input type="hidden" value="{{$wcdId}}" name="id" class="dmofirst">
                         @php $setdmoclass = 'dmo_parameters' @endphp  
                        @elseif($action == 'withpayontimediscount')
                        <input type="hidden" name="variant" value="2">
                        <input type="hidden" value="{{$wptdId}}" name="id" class="dmosecond">
                         @php $setdmoclass = 'dmo_parameters1' @endphp 
                        @elseif($action == 'withdirectdebitdiscount')
                        @php $setdmoclass = 'dmo_parameters2' @endphp 
                        <input type="hidden" name="variant" value="3">
                        <input type="hidden" value="{{$wdddId}}" name="id" class="dmothird">
                        @else
                        @php $setdmoclass = 'dmo_parameters3' @endphp 
                        <input type="hidden" name="variant" value="4">
                        <input type="hidden" value="{{$wbpId}}" name="id" class="dmofourth">
                        @endif

                        <select size="5"  name="dmo_parameter" class="form-select form-select-solid form-select-lg {{$setdmoclass}}" id="dmo_parameter">
                        @foreach(getEnergyContentAttributes(2,1) as $attributes )
                            <option value="{{$attributes->attribute}}">{{$attributes->attribute}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required  fw-bold fs-6">{{ __('settings.dmocontent') }}</label>
                    <div class="col-lg-8 fv-row field-holder">
                        @if($action == 'withoutcondtionaldiscount')
                        <textarea class="form-control form-control-lg form-control-solid ckeditor"  placeholder="Plan Bonus" id="dmo_content" name="dmo_content" >{{$wcd}}</textarea>
                        @elseif($action == 'withpayontimediscount')
                        <textarea class="form-control form-control-lg form-control-solid ckeditor" value="" placeholder="Plan Bonus" id="withpayontimediscount" name="withpayontimediscount">{{$wptd}}</textarea>
                        @elseif($action == 'withdirectdebitdiscount')
                        <textarea class="form-control form-control-lg form-control-solid ckeditor" value="" placeholder="Plan Bonus" id="withdirectdebitdiscountcontent" name="withdirectdebitdiscountcontent">{{$wddd}}</textarea>
                        @else
                        <textarea class="form-control form-control-lg form-control-solid ckeditor" value="" placeholder="Plan Bonus" id="withbothpayontimeanddirectdebitdiscount" name="withbothpayontimeanddirectdebitdiscount">{{$wbp}}</textarea>
                        @endif
                        <span class="form_error_name form_error" style="color: red;"></span>
                    </div>
                </div>
                
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="" id="" class="btn btn-light me-5">{{ __('buttons.cancel') }}</a>
                    @if($action == 'withoutcondtionaldiscount')
                        <button type="button" class="btn btn-primary submit_button submit_dmo_btn">
                    @elseif($action == 'withpayontimediscount')
                        <button type="button" class="btn btn-primary submit_button submit_dmo_btn1">
                    @elseif($action == 'withdirectdebitdiscount')
                        <button type="button" class="btn btn-primary submit_button submit_dmo_btn2"> 
                    @else
                        <button type="button" class="btn btn-primary submit_button submit_dmo_btn3">
                    @endif
                    

                    <span class="indicator-label">
                        {{ __('buttons.save') }}
                    </span>
                    <span class="indicator-progress">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>

                </button>
            </div>
            
        </div>
    </form>
</div>
