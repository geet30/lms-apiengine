<x-base-layout>
<link rel="stylesheet" href="{{ URL::asset('custom/css/sale.css') }}">
<link rel="stylesheet" href="{{ URL::asset('cimet/plugins/custom/datatables/datatables.bundle.css') }}">
<script type="text/javascript" href="{{ URL::asset('cimet/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('cimet/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}">
<script type="text/javascript" href="{{ URL::asset('cimet/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    {{ theme()->getView('pages/leads/components/modal',compact('userPermissions','appPermissions')) }}
    	<!--begin::Row-->
        <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
            {{ theme()->getView('pages/leads/components/toolbar',array('userServices'=> $userServices, 'saleType' =>$saleType, 'affiliates' => $affiliates ,'subAffiliates' => $subAffiliates ,'providers' => $providers ,'serviceId' => $serviceId ,'states' => $states ,'connectionTypes' => $connectionTypes, 'userRole' => $userRole,'user' => $user, 'qaList' => $qaList, 'userPermissions' => $userPermissions,'appPermissions' => $appPermissions)) }}
            
            {{ theme()->getView('pages/leads/components/table', array('userServices'=> $userServices, 'saleType' =>$saleType,'leads' =>$leads ,'serviceId' => $serviceId ,'connectionTypes' => $connectionTypes,'statuses' => $statuses ,'user' => $user,'collabratorLeads' => $collabratorLeads,'collabratorName'=> $collabratorName , 'userPermissions' => $userPermissions,'appPermissions' => $appPermissions)) }}
        </div>
        <!--end::Row-->
</x-base-layout>
    
