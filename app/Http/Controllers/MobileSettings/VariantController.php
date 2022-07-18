<?php

namespace App\Http\Controllers\MobileSettings;

use App\Http\Controllers\Controller;
use App\Models\{Color,Capacity,InternalStorage,Variant,Providers,ProviderVariant,ProviderHandset,Handset};
use Illuminate\Http\Request;
use App\Http\Requests\MobileSettings\{VariantRequest,EditVariantRequest};
class VariantController extends Controller
{

    public function index(Request $request,$id = null){
        $colors = Color::getColorNames();
        $capacity = Capacity::getCapacity();
        $storage = InternalStorage::getStorage();
        if ($request->isMethod('post')) {
            $variants = Variant::getvariants($request,$request->id);
            return response()->json(['variants' => $variants], 200);
        }
        $variants = Variant::getvariants($request,$id);
        $handsetsProviders = ProviderHandset::where('handset_id',decryptGdprData($id))->pluck('provider_id')->toArray(); 
        $providers = Providers::where('service_id',2)->whereIn('user_id' ,$handsetsProviders)->select('user_id','legal_name')->get(); 

        $handsetId = $id;
        $handsetDetails = Handset::find(decryptGdprData($id));
        // dd($variants);
        return view('pages.mobilesettings.variants.index',compact('colors','capacity','storage','handsetId','variants','providers','handsetDetails'));
        
    }

    public function addVariant($id){
        $title = 'Add';
        $name = 'add_handset_variant_form';
        $handsetId = $id;
        $colors = Color::getColorNames();
        $capacity = Capacity::getCapacity();
        $storage = InternalStorage::getStorage();
        $handsetDetails = Handset::find(decryptGdprData($id));
        return view('pages.mobilesettings.variants.variant',compact('colors','capacity','storage','handsetId','title','name','handsetDetails'));
    }  
    
    public function store(VariantRequest $request){
        $res = Variant::createHandsetVariant($request);
        if($res['status']==200)
        {
            $response['status'] = $res['status'];
            $response['message'] = $res['message'];
            return response()->json(['status' => $res['status'], 'message' => $res['message']]);
        }
        return response()->json(['status' => $res['status'], 'message' => $res['message']]);  
    }

    public function updateStatus(Request $request){
        try {
            return Variant::changeStatus($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function editVariant($id,$variantId){
        $name = 'edit_handset_variant_form';
        $title = 'Edit';
        $variant = Variant::getvariantById($id,$variantId);
        $handsetId = $id;
        $colors = Color::getColorNames();
        $capacity = Capacity::getCapacity();
        $storage = InternalStorage::getStorage();
        $handsetDetails = Handset::find(decryptGdprData($id));
        return view('pages.mobilesettings.variants.variant',compact('colors','capacity','storage','handsetId','variant','title','name','variantId','handsetDetails'));
    }

    public function updateVariant(EditVariantRequest $request){
        $res = Variant::updateHandsetVariant($request);
        if($res['status']==200)
        {
            $response['status'] = $res['status'];
            $response['message'] = $res['message'];
            return response()->json(['status' => $res['status'], 'message' => $res['message']]);
        }
        return response()->json(['status' => $res['status'], 'message' => $res['message']]); 
    }

    public function deleteVariantimage($id){
        return Variant::deleteVariantImageMethod($id);
    }

    /**
     * Change the status of handset after confirming, in storage
     *
     */
    public function checkAssignProvider(Request $request)
    {
        $response = Variant::checkAssignProvider($request);  
        return response()->json($response,$response['http_status']);  
    }
    
    /**
     * Change the status of handset after confirming, in storage
     *
     */
    public function assignProvider(Request $request)
    {
        $data = [];
        $providerId = decryptGdprData($request->provider_id);
        foreach ($request->variant_ids as $handsetId) {
            $data[] = ['provider_id'=>$providerId,'handset_id'=>$request->handset_id,'variant_id'=>$handsetId,'status'=>0,'created_at'=>now()];
        }
        $response = ProviderVariant::assignProvider($data);  
        return response()->json($response,$response['http_status']);  
    }
}