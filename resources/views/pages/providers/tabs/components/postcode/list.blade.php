<div class="card mb-5 mb-xl-10">
    {{ theme()->getView('pages/providers/tabs/components/postcode/components/toolbar') }}
    {{ theme()->getView('pages/providers/tabs/components/postcode/components/postcodes', ['user_id'=>$providerdetails[0]['user_id']]) }}
</div>
