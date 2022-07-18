<div class="tab-pane fade show active" id="demad-tariff-section" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __('plans/energyPlans.manage_demand_tariff_rates') }} </h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->
        <div id="kt_account_special_offer_price" class="collapse show">
                <!--begin::Form-->
                <div class="d-flex justify-content-end py-6 px-9 border-top">
                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#upload_tariff_code_file_modal">
                        {{ __('plans/energyPlans.tariff_import') }}
                    </button> 
                    <button type="button" class="btn btn-success me-2 download_sample">
                    {{ __('plans/energyPlans.download_demand_tariff_rate_sheet') }} 
                    </button>
                    <a type="button" class="btn btn-info" href="{{ route('settings.master.settings.get.tarridId')}}">
                    {{ __('plans/energyPlans.get_tariff_ids') }} 
                    </a>
                </div> 
        </div>
    </div>
</div>