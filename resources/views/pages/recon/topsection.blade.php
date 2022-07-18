<div class="card-body pt-9 pb-0">
    <div class="d-flex flex-wrap flex-sm-nowrap mb-3">

        <div class="me-7 mb-4">
            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                <img src="/common/media/avatars/blank.png" alt="image">
                
                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-danger rounded-circle border border-4 border-white h-20px w-20px"></div>
                
            </div>
        </div>    

        <div class="flex-grow-1">
            

            <!--begin::Stats-->
            <div class="d-flex flex-wrap flex-stack">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-grow-1 pe-8">
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap">
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                {!! theme()->getSvgIcon("icons/duotune/arrows/arr066.svg", "svg-icon-3 svg-icon-success me-2") !!}
                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">0</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-bold fs-6 text-gray-400">{{ __('Earnings') }}</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                {!! theme()->getSvgIcon("icons/duotune/arrows/arr065.svg", "svg-icon-3 svg-icon-danger me-2") !!}
                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="75">0</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-bold fs-6 text-gray-400">{{ __('Projects') }}</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                {!! theme()->getSvgIcon("icons/duotune/arrows/arr066.svg", "svg-icon-3 svg-icon-success me-2") !!}
                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-bold fs-6 text-gray-400">{{ __('Success Rate') }}</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Progress-->
                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                        <span class="fw-bold fs-6 text-gray-400">{{ __('Profile Completion') }}</span>
                        <span class="fw-bolder fs-6">50%</span>
                    </div>

                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                        <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end::Progress-->
            </div>
            <!--end::Stats-->
        </div>

    </div>
</div>
