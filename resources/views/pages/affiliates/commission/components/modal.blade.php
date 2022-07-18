<div class="modal fade" id="add-commission-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary px-5 py-4">
                <h4 class="fw-bolder fs-12 text-white">Add Commission</h4>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                    <span class="svg-icon svg-icon-1 hideapkipopup">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <form id="add-commission-form" data-select2-id="select2-data-sale_submission_form">
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6 required">Select Year:</label>
                        <div class="col-lg-4 fv-row">
                            <select id="add-commission-year" data-placeholder="Year" class="form-select form-select-solid" name="year" data-control="select2" data-hide-search="true">
                                <option></option>
                                <option value="{{date('Y', strtotime('-1 year'))}}">{{date('Y', strtotime('-1 year'))}}</option>
                                <option value="{{date('Y')}}" selected>{{date('Y')}}</option>
                                <option value="{{date('Y', strtotime('+1 year'))}}">{{date('Y', strtotime('+1 year'))}}</option>
                            </select>
                            <span class="form_error" style="color: red; display: none;"></span>
                        </div>
                        @php $months = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec']  @endphp
                        <label class="col-lg-2 col-form-label fw-bold fs-6 required">Month:</label>
                        <div class="col-lg-4 fv-row">
                            <select id="add-commission-month" data-placeholder="Month" class="form-select form-select-solid" name="month" data-control="select2" data-hide-search="true">
                                @foreach($months as $key=>$month)
                                    <option value="{{$key}}" {{ $key== date('m') ?'selected' : ''}}>{{$month}}</option>
                                @endforeach
                            </select>
                            <span class="form_error" style="color: red; display: none;"></span>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6 required">Select Providers:</label>
                        <div class="col-lg-10 fv-row">
                            <select id="providers" data-placeholder="Providers" class="form-select form-select-solid providers" name="providers[]" data-control="select2" data-hide-search="true" multiple="multiple">
                                <option></option>
                                @foreach($providers as $provider)
                                    <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                @endforeach
                            </select>
                            <span class="form_error" style="color: red; display: none;"></span>
                        </div>
                    </div>

                    <div id="energy-box">
                        <div class="row mb-5">
                            <div class="col-md-12 pt-md-0 py-3">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Electricity</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Ele-Residential-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Ele-Res-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Ele-Residential-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Ele-Res-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Ele-Business-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Ele-Bus-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Ele-Business-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Ele-Bus-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 pt-md-0 py-3">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Gas</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Gas-Residential-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Gas-Res-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Gas-Residential-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Gas-Res-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Gas-Business-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Gas-Bus-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Gas-Business-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Gas-Bus-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 pt-md-0 py-3">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">LPG</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">LPG-Residential-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="LPG-Res-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">LPG-Residential-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="LPG-Res-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">LPG-Business-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="LPG-Bus-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">LPG-Business-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="LPG-Bus-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="mobile-box">
                        <div class="row mb-5">
                            <div class="col-md-12 pt-md-0 pt-3 pb-0 mx-auto">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Mobile</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Mob-Residential-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Mob-Res-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Mob-Residential-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Mob-Res-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Mob-Business-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Mob-Bus-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Mob-Business-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Mob-Bus-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="broadband-box">
                        <div class="row mb-5">
                            <div class="col-md-12 pt-md-0 pt-3 pb-0 mx-auto">
                                <div class="card" style="border: 1px solid #0000001F!important;">
                                    <div class="card-header" style="min-height:50px!important;">
                                        <div class="card-title">Broadband</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Bro-Residential-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Bro-Res-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Bro-Residential-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Bro-Res-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Bro-Business-Ret</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Bro-Bus-Ret" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                            <label class="col-lg-4 col-form-label fw-bold fs-6 required">Bro-Business-Aq</label>
                                            <div class="col-lg-2 fv-row">
                                                <input type="number" min="0" step="1" class="form-control form-control-lg form-control-solid" placeholder="" name="Bro-Bus-Aq" tabindex="6" value="">
                                                <span class="form_error" style="color: red; display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">Comment:</label>
                        <div class="col-lg-10 fv-row">
                            <textarea autocomplete="off" name="comment" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Comment" rows="2"></textarea>
                            <span class="form_error" style="color: red; display: none;"></span>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-lg-2 fv-row m-auto">
                            <label class="form-check form-check-custom form-check-solid me-20 pull-right">
                                <input class="form-check-input h-20px w-20px" type="checkbox" name="donot_update_existing" value="1">
                            </label>
                        </div>
                        <div class="col-lg-10 fv-row">
                            <span class="form-check-label fw-bold">Please check this checkbox if you don't want to update the existing commission structure if already added. This will add the commission structure only for those cells in which the commission structure is not added yet. If this checkbox is not checked then it will replace the existing commission structure if already added by the admin.</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                <button class="btn btn-primary" id="save-commission-button">Save</button>
            </div>
        </div>
    </div>
</div>

