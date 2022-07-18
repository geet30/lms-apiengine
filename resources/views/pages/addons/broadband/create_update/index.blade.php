<x-base-layout>
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="">
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    @if ($addonType == 3)
                        @php $diff_aff = '/addons/home-line-connection/list' @endphp
                        @php $aff_head = 'Home Line Connection' @endphp
                        @if (isset($addon) && $addon['category'] == 3)
                            @php $setnav = 'Edit' @endphp
                        @else
                            @php $setnav = 'Add' @endphp
                        @endif
                    @elseif($addonType == 4)
                        @php $diff_aff = '/addons/modem/list' @endphp
                        @php $aff_head = 'Modem' @endphp
                        @if (isset($addon) && $addon['category'] == 4)
                            @php $setnav = 'Edit' @endphp
                        @else
                            @php $setnav = 'Add' @endphp
                        @endif
                    @elseif($addonType == 5)
                        @php $diff_aff = '/addons/additional-addons/list' @endphp
                        @php $aff_head = 'Additional Addons' @endphp
                        @if (isset($addon) && $addon['category'] == 5)
                            @php $setnav = 'Edit' @endphp
                        @else
                            @php $setnav = 'Add' @endphp
                        @endif
                    @endif
                    <div class="tab-content card">
                        @if ($addonType == 3)
                            @include(
                                'pages.addons.broadband.create_update.add-home-connection'
                            )
                        @elseif ($addonType == 4)
                            @include(
                                'pages.addons.broadband.create_update.add-modem'
                            )
                        @elseif ($addonType == 5)
                            @include(
                                'pages.addons.broadband.create_update.add-addon'
                            )
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="/custom/js/addons.js"></script>
        <script src="/custom/js/breadcrumbs.js"></script>
        <script src="/common/plugins/custom/flatpickr/flatpickr.bundle.js"></script>
        <script>
            var type = '{{ $setnav }}';
            var diff_aff = '{{ $diff_aff }}';
            var aff_head = '{{ $aff_head }}';

            const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: aff_head,
                    link: diff_aff,
                    active: false
                },
                {
                    title: type,
                    link: '#',
                    active: true
                },
            ];
            const breadInstance = new BreadCrumbs(breadArray);
            breadInstance.init();
        </script>
    @endsection
</x-base-layout>
