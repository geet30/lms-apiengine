<x-base-layout>
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/affiliates/commission/components/modal',['providers'=>$providers]) }}
        {{ theme()->getView('pages/affiliates/commission/components/toolbar',['states'=>$states, 'providers'=>$providers, 'services'=>$services, 'affiliate'=>$affiliate]) }}
        {{ theme()->getView('pages/affiliates/commission/components/table') }}
    </div>
</x-base-layout>
