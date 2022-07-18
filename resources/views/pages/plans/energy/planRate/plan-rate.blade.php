<x-base-layout>
    <!--begin::Row-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            @include('pages.plans.common.header')
        </div>
    </div>

    {{ theme()->getView('pages/plans/energy/planRate/editRate/upload-planrate-modal',['planId' =>$planId ,'energyType' => $energyType])}}
    {{ theme()->getView('pages/providers/components/modal') }}
        <div class="row gy-12 gx-xl-12 card mt-3">

            {{ theme()->getView('pages/plans/energy/planRate/toolbar_plan_rates',['energyType' => $energyType])}}
            {{ theme()->getView('pages/plans/energy/planRate/plan-rate-list',array('planRates' => $planRates,'url'=>$url,'plan'=>$plan,'energyType'=>$energyType,'selectedProvider'=>$selectedProvider)) }}

        </div>
        <!--end::Row-->
</x-base-layout>
