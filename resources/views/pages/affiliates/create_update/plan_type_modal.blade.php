<div class="modal fade" id="planTypePopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-950px">
        <div class="modal-content">


            <div class="modal-header bg-primary px-5 py-4">
                  
            <h2 class="fw-bolder fs-12 text-white">{{ __('affiliates.verticalheading') }}<span class="selectedcompany"></span></h2>
                    <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary badge-light-primary rounded-pill">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                    </div>
            </div>
            <div class="modal-body px-5">
            <div class="card">
                        <div class="card-body pt-0 px-0 pb-5">
                            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                                <div class="d-flex overflow-auto h-55px">
                                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                                        <li class="nav-item ">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#mobile_plan_type">{{ __('affiliates.planTypeheading') }}</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#mobile_connection_type">{{ __('affiliates.connectionTypeheading') }}</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#lead_popup">{{ __('affiliates.leadPopupHeading') }}</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="mobile_plan_type" role="tab-panel">
                            @include("pages.affiliates.create_update.mobile_plan_type_form")
                    </div>
                    <div class="tab-pane fade show " id="mobile_connection_type" role="tab-panel">
                            @include("pages.affiliates.create_update.connection_type_form")
                    </div>
                    <div class="tab-pane fade show" id="lead_popup" role="tab-panel">
                    
                            @include("pages.affiliates.create_update.lead_signup_form")
                    
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>
                   