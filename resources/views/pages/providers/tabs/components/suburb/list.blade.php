<div class="card mb-5 mb-xl-10">
    {{ theme()->getView('pages/providers/tabs/components/suburb/components/toolbar') }}
    {{ theme()->getView('pages/providers/tabs/components/suburb/components/filter-form', ['userStates' => $userStates]) }}
    {{ theme()->getView('pages/providers/tabs/components/suburb/components/table', ['assignedSubrubs' => $assignedSubrubs, 'userStates' => $userStates]) }}
    {{ theme()->getView('pages/providers/tabs/components/suburb/components/modals', ['userStates' => $userStates]) }}
</div>
