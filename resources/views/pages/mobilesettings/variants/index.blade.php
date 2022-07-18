<x-base-layout>

    <div class="gy-12 gx-xl-12 card mt-0 mx-0 px-8 all-table-title-css">
        {{ theme()->getView('pages/mobilesettings/variants/modal',['providers'=>$providers]) }}
        {{ theme()->getView('pages/mobilesettings/variants/listingtoolbar',array('colors' => $colors,'capacity' => $capacity,'storage' => $storage,'handsetId' =>$handsetId)) }}
        {{ theme()->getView('pages/mobilesettings/variants/table',array('colors' => $colors,'capacity' => $capacity,'storage' => $storage,'handsetId' =>$handsetId,'variants'=> $variants,'handsetDetails' => $handsetDetails)) }}
        
    </div>
   
</x-base-layout>