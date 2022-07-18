<x-base-layout>
    <div class="card mb-5 mb-xl-10">
    @include('pages.recon.topsection')
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="tab-content">
            @include('pages.recon.listingtoolbar')
            @include('pages.recon.table')
            @include('pages.recon.modal')
            @include('pages.recon.editmodal')
        </div>
    </div>
</x-base-layout>