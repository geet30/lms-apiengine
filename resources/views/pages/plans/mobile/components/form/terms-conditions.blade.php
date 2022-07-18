<div class="tab-pane fade" id="terms-condition" role="tab-panel">
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" data-bs-toggled="collapse" data-bs-targetd="#terms_condition_section">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __ ('mobile.formPage.tnc.sectionTitle')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="terms_condition_section" class="collapse show">
            <!--begin::Card body-->
            <div class="card-body p-9" id="dynamic_terms_condition_data">
                @foreach($plan->planMobileTerms as $planTerm)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-gray-800">{{$planTerm->title}}</label>
                    <div class="col-lg-8">
                        <span class="fw-bolder fs-6 text-gray-800" class="edit-plan-term" data-id="{{$planTerm->id}}" data-title="{{$planTerm->title}}" data-desc="{{$planTerm->description}}" style="cursor:pointer;">{{ __ ('mobile.formPage.tnc.edit')}} <i class="bi bi-pencil-square"></i></span>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Content-->
    </div>
</div>