<x-base-layout>

    <div class="row gy-12 gx-xl-12 card mt-3">
        {{ theme()->getView('pages/affiliates/email-templates/components/listingtoolbar', array('affiliate_id' => $affiliate_id,'services'=>$services)) }}
        {{ theme()->getView('pages/affiliates/email-templates/components/table', array('affiliateData'=>$affiliateData,'affiliate_id' => $affiliate_id)) }}
    </div>
</x-base-layout>