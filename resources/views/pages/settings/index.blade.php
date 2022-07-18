<x-base-layout>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="tab-content ">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-body pt-0">
                                 <div class="row mb-6">
                                     <label class="col-lg-4 col-form-label   fw-bold fs-6">{{ __('settings.dmotype') }}</label>
                                     <div class="col-lg-8 fv-row">
                                        <select  id="dmoselection" class="fav_clr form-control form-control-lg form-control-solid form-select"  tabindex="-1" aria-hidden="true" data-placeholder="Select DMO" data-control="select2">
                                            <option value="withoutcondtionaldiscount">{{ __('settings.withoutcondtionaldiscount') }}</option>
                                            <option value="withpayontimediscount">{{ __('settings.withpayontimediscount') }}</option>
                                            <option value="withdirectdebitdiscount">{{ __('settings.withdirectdebitdiscount') }}</option>
                                            <option value="withbothpayontimeanddirectdebitdiscount">{{ __('settings.withbothpayontimeanddirectdebitdiscount') }}</option>
                                        </select>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="withoutcondtionaldiscount" role="tab-panel">
                            @include('pages.settings.dmo_vdo_content',array('action'=>'withoutcondtionaldiscount'))
                        </div>
                        <div class="tab-pane fade show " id="withpayontimediscount" role="tab-panel">
                            @include('pages.settings.dmo_vdo_content',array('action'=>'withpayontimediscount'))
                        </div>
                        <div class="tab-pane fade show " id="withdirectdebitdiscount" role="tab-panel">
                            @include('pages.settings.dmo_vdo_content',array('action'=>'withdirectdebitdiscount'))
                        </div>
                        <div class="tab-pane fade show " id="withbothpayontimeanddirectdebitdiscount" role="tab-panel">
                            @include('pages.settings.dmo_vdo_content',array('action'=>'withbothpayontimeanddirectdebitdiscount'))
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @section('scripts')
    @include('pages.settings.js')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script>
         const breadArray = [{
            title: 'Dashboard',
            link: '/',
            active: false
        },
        {
            title: 'DMO/VDO content',
            link: '#',
            active: false
        },
       
    ];
    const breadInstance = new BreadCrumbs(breadArray);
    breadInstance.init();
    </script>
    @endsection
</x-base-layout>

