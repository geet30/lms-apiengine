<x-base-layout>
    <!--begin::Basic info-->
    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/users/components/form',compact('user','idVal','affiliates','selectedAffiliates','whitelist_ip','bdmDateRange','selectedSubAff','selectedMasterAff','allSubAffiliatesData')) }} 
    </div>
    
    @section('scripts')
    <script src="/custom/js/breadcrumbs.js"></script>
    <script src="/custom/js/users.js"></script> 
    <script src="/custom/js/tagify.min.js"></script>
    <script>
        var type = 'Manage User';
        const breadArray = [{
                    title: 'Dashboard',
                    link: '/',
                    active: false
                }, 
                {
                    title: type,
                    link: '#',
                    active: true
                },
            ];
        const breadInstance = new BreadCrumbs(breadArray,'Plans');
        breadInstance.init(); 

        // The DOM elements you wish to replace with Tagify
        var input1 = document.querySelector("#kt_tagify_1"); 
        new Tagify(input1);  

        $("#date_range_checkbox").change(function() {
            var ischecked= $(this).is(':checked');
            if(!ischecked){
                $('#date_range_to').attr('disabled',false);
            }else{
                $('#date_range_to').attr('disabled',true);
                $('#date_range_to').val('');
            }
        });

        $("#date_range_from").daterangepicker({
            autoApply: true,
            autoUpdateInput: false,
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: true,
            locale: {
                format: 'MM/DD/YYYY'
            },
        });

        $('#date_range_from,#date_range_to').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY'));
        });

        $("#date_range_to").daterangepicker({
            autoApply: true,
            autoUpdateInput: false,
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: true,
            locale: {
                format: 'MM/DD/YYYY'
            },
        });
         
    </script> 
    @endsection
</x-base-layout>