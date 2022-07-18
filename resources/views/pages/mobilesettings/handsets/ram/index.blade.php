<!--begin::Content-->
{{ theme()->getView('pages/mobilesettings/handsets/ram/components/filtertoolbar', array('modal_id'=>'#mobile_ram_modal', 'capacityArr'=>$capacityArr)) }}
{{ theme()->getView('pages/mobilesettings/handsets/ram/components/modal', array('capacityArr'=>$capacityArr)) }}
{{ theme()->getView('pages/mobilesettings/handsets/ram/components/table')}}
<!--end::Content-->

