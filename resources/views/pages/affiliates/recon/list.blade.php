<x-base-layout>

    <div class="d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="">
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                    @php $setnav = 'Add';
                    @endphp
                    @php $diff_aff = '/affiliates/list' @endphp
                    @php $aff_head = 'Affiliates' @endphp
                    @php
                    $records=$affiliateuser[0]['user'];
                    $records['status']=$affiliateuser[0]['status'];
                    $records['address']=$affiliateuser[0]['getuseradress']['address'];

                    $records['logo']=$affiliateuser[0]['logo'];
                  
                    @endphp
                    <div class="card">
                        @include("pages.affiliates.recon.details")
                        @include('pages.affiliates.recon.components.modal')
                  
                    </div>
                   
                    <div class="tab-content">
                    
                        <div class="tab-pane fade show active" id="reconciliation" role="tab-panel"> 
                            @include("pages.affiliates.recon.reconciliation")
                            
                        </div>
                        <div class="tab-pane fade" id="reconciliation_history" role="tab-panel">
                            <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
                                @include('pages.affiliates.recon.components.history_toolbar')

                                @include("pages.affiliates.recon.reconciliation_history")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('styles')
        <link href="/common/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    @endsection
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/common/plugins/custom/flatpickr/flatpickr.bundle.js"></script>
    <script src="/custom/js/loader.js"></script>
    <script src="/common/plugins/custom/datatables/datatables.bundle.js"></script>
=
    @include('pages.affiliates.recon.components.js')
    <script>
        var type = '{{$setnav}}';
        var diff_aff = '{{$diff_aff}}';
        var aff_head = '{{$aff_head}}';
        var info = '{{request()->segment(2)}}';
        
        const breadArray = [{
            title: 'Dashboard',
            link: '/',
            active: false
            },
        ];
        KTMenu.createInstances();
        // let dataTable = $("#recon_history_table").DataTable({
        //     responsive: false,
        //     searching: true,
        //     "sDom": "tipr",
        // });
        if(info == 'sub-affiliates'){
            breadArray.push(
                {
                    title: 'Affiliates',
                    link: '/affiliates/list',
                    active: false
                },
            );
        }

        breadArray.push(
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
        );
        const breadInstance = new BreadCrumbs(breadArray);
        breadInstance.init();
    </script>
    
    @endsection
</x-base-layout>