<x-base-layout>



    {{ theme()->getView('pages/providers/edit/settings/_profile-details', array('class' => 'mb-5 mb-xl-10', 'info' => $info)) }}

    {{ theme()->getView('pages/providers/edit/settings/_signin-method', array('class' => 'mb-5 mb-xl-10', 'info' => $info)) }}
    {{ theme()->getView('pages/providers/edit/settings/manage_logo', array('class' => 'mb-5 mb-xl-10', 'info' => $info)) }}

</x-base-layout>
