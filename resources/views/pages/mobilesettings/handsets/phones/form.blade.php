<x-base-layout>
    <!--begin::Content-->
    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0">
                        <!--begin::Navs-->
                        @include('pages.mobilesettings.handsets.phones.components.form.tabs-nav')
                        <!--begin::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->

                <!-- Tabs -->
                <div class="tab-content">
                    @include('pages.mobilesettings.handsets.phones.components.form.basic-details')
                    @if(isset($phone))
                    @include('pages.mobilesettings.handsets.phones.components.form.specifications')
                    @include('pages.mobilesettings.handsets.phones.components.form.features')
                    @include('pages.mobilesettings.handsets.phones.components.form.more_info')
                    @endif
                </div>
                <!-- End Tabs -->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
        @if(isset($phone))
        @include('pages.mobilesettings.handsets.phones.components.form.add_more_info_modal')
        @endif
    </div>
    @section('scripts')
    <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script> 
    @include('pages.mobilesettings.handsets.phones.components.js')
    <script>
        let phoneId = "{{isset($phone) ? encryptGdprData($phone->id) : ''}}";
    const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                },
                {
                    title: 'Handsets',
                    link: `{{ '/mobile/handsets' }}`,
                    active: false
                },
            ];
            let newArr = [];
            if(phoneId){
                newArr = [
                        {
                            title: "{{ isset($phone) ? ucwords($phone->name) : '' }}",
                            link: `{{ '/mobile/handsets' }}`,
                            active: false
                        },
                        {
                            title: phoneId == '' ? 'Add' : 'Edit',
                            link: '#',
                            active: true
                        },
                    ];
                    for(i=0; i < newArr.length ; i++){
                        breadArray.push(newArr[i]);
                    }
            }else{
                newArr = [
                    {
                        title: phoneId == '' ? 'Add' : 'Edit',
                        link: '#',
                        active: true
                    },
                ];
                breadArray.push(newArr[0]);
            }

            const breadInstance = new BreadCrumbs(breadArray);
            breadInstance.init();
    </script>
    @endsection
    <!--end::Content-->
</x-base-layout>