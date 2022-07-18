<x-base-layout>

    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            {{ theme()->getView('pages/plans/common/header',['selectedProvider' => $selectedProvider]) }}
        </div>
    </div>
  
    {{ theme()->getView('pages/plans/energy/planRate/demand/add_edit_demand_model', array('demandList' => $demandList,'rateId'=>$rateId,'distributorId'=>$distributorId,'property_type'=>$propertyType))}}
    {{ theme()->getView('pages/providers/components/modal') }}
    <!--begin::Row-->
        <div class="row gy-12 gx-xl-12 card mt-3">
            {{ theme()->getView('pages/plans/energy/planRate/demand/toolbar')}}
            {{ theme()->getView('pages/plans/energy/planRate/demand/demand_listing', array('demandList' => $demandList,'rateId'=>$rateId,'url'=>$url,'selectedProvider' => $selectedProvider,'selectedPlan' => $selectedPlan, 'selectedPlanRate' => $selectedPlanRate, 'propertyType' => $propertyType)) }}


        </div>

        <!--end::Row-->




</x-base-layout>

