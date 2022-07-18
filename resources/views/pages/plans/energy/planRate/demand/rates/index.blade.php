<x-base-layout>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            @include('pages.plans.common.header')
        </div>
    </div>
    {{ theme()->getView('pages/plans/energy/planRate/demand/rates/add_edit_rate',array('rateId'=>$rateId,'demandRateTypes'=>$demandRateTypes))}}
    {{ theme()->getView('pages/providers/components/modal') }}
    {{-- {{ theme()->getView('pages/plans/planRate/demand/add-edit-demand-model') }} --}}
    <!--begin::Row-->
        <div class="row gy-12 gx-xl-12 card mt-3">
            {{ theme()->getView('pages/plans/energy/planRate/demand/rates/toolbar')}}
            {{ theme()->getView('pages/plans/energy/planRate/demand/rates/rate_list', array('demandRates' => $demandRates,'rateId'=>$rateId,'url'=> $url,'selectedPlan' => $selectedPlan, 'selectedProvider' => $selectedProvider, 'selectedPlanRate' => $selectedPlanRate, 'planRateId' => $planRateId, 'propertyType' => $propertyType)) }}

        </div>
        <!--end::Row-->
</x-base-layout>
