<?php

namespace App\Repositories\Providers\MobileHandset;

use App\Models\{ 
    Brand, 
    Handset, 
    PlanMobileHandset,
    PlanMobileVariant,
    Providers, 
    ProviderHandset,
    ProviderVariant,
    Color,
    Capacity,
    InternalStorage,
    Variant,  
    PlanMobile
};

trait BasicCrudMethods
{  
     /**
     * Display a listing of the resource.
     *
     * @return string|mixed
     */
    public static function getHandsetListing($request)
    {
        try 
        {   
            $providerId = decryptGdprData($request->providerId);      
            $assignHandset = new ProviderHandset; 
            $assignHandset = self::planHandsetFilter($assignHandset,$request);
            $assignHandset = $assignHandset->where('provider_id',$providerId)->get();
            $providerName = Providers::where('id',$providerId)->value('legal_name'); 
            $brands = Brand::orderBy("title")->get();
            $filterVars = $request->all(); 
            $selectedProvider = Providers::with([
                'providersLogo' => function($query){
                    $query->select('user_id','name','category_id');
                },
            ])->where('user_id',$providerId)->first();
            return compact('assignHandset','providerId','providerName','filterVars','brands','selectedProvider');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
    *  Purpose: filter plan handsets listing based on filter selected.
    */
    public static function planHandsetFilter($model, $request)
    { 
        $handset = new Handset;
        $status = $request->status;
        if($status == 2)
        {
            $status = null;
        } 
        if(isset($status))
        {
            $model = $model->where('status', $status);
        } 
        if (isset($request->handset_name)) {
            $handsetID = $handset->where('name', 'like', "%" . $request->handset_name . "%")->pluck("id");
            $model = $model->whereIn('handset_id', $handsetID);
        } 
        if (isset($request->brand)) {
            $handsetBrand = $handset->where('brand_id', $request->brand)->pluck("id");
            $model = $model->whereIn('handset_id', $handsetBrand);
        }
        return $model;
    }


    public static function getAssignedHandsets($providerId,$handsetIds)
    {
        try 
        {
            return self::select('handset_id')->where('provider_id',decryptGdprData($providerId))->whereIn('handset_id',$handsetIds)->get()->pluck('handset_id')->toArray();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function assignHandsets($request)
    {
        try 
        {
            $data = [];
            $providerId = decryptGdprData($request->provider_id);
            foreach ($request->handset_ids as $handsetId) {
                $data[] = ['provider_id'=>$providerId,'handset_id'=>$handsetId,'status'=>1,'created_at'=>now()];
            }
            $variants = Variant::select('handset_id','id')->whereIn('handset_id',$request->handset_ids)->get();
            $variantData = [];
            foreach ($variants as $variant) {
                $variantData[] = ['provider_id'=>$providerId,'handset_id'=>$variant->handset_id,'variant_id'=>$variant->id,'status'=>0,'created_at'=>now()];
            }
            if(count($variantData))
                ProviderVariant::assignProvider($variantData);
            return self::insert($data);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * change status
     *
     * @return array
     */
    public static function changePhoneStatus($request)
    { 
        $id = decryptGdprData($request->id);
        $providerHandset = ProviderHandset::find($id);
        $status = $request->get('status');
        $resp = ProviderHandset::where('id', $id)->update(['status' => $request->get('status')]);
        if($resp){
        	// change status of all handsets which are assign to provider's plan.
        	$planIds = PlanMobile::where('provider_id',$providerHandset->provider_id)->pluck('id')->toArray();
            PlanMobileHandset::whereIn('plan_id',$planIds)->where('handset_id',$providerHandset->handset_id)->update(['provider_status'=>$status]); 
            $response['status'] = 200;
            $response['message'] = "Phone Updated Successfully.";
            return $response;   
        } 
        $response['status'] = 400;
        $response['message'] = "Phone status not updated. Please try again later."; 
        return $response; 
    }

    /**
     * delete assigned handset 
     *
     * @return array
     */
    public static function deleteHandsetProvider($request){
        $providerId = decryptGdprData($request->providerId);
        $handsetId = decryptGdprData($request->id);
        $planId = PlanMobile::where('provider_id', $providerId)->pluck('id')->toArray(); 
        $check = PlanMobileHandset::whereIn('plan_id', $planId)->where('handset_id', $handsetId)->count();
        if( $check){ 
            $response['status'] = 422;
            $response['message'] = '"Phone cannot be deleted as it is assigned to some of the plans';
            return $response;
        }
        if(self::deleteHandsetAndVariantForProvider($providerId,$handsetId)) { 
            $response['status'] = 200;
            $response['message'] = "Phone and its associated variants(if any) deleted successfully.";
            return $response;
        } 
        $response['status'] = 400;
        $response['message'] = 'Phone is not deleted';
        return $response;
    }

    /**
     * delete assigned handset and its variants
     *
     * @return boolean
     */
    public static function deleteHandsetAndVariantForProvider($pid, $hid){
        $res1 =  ProviderHandset::where('provider_id',$pid)->where('handset_id',$hid)->delete();
        $res2 =   ProviderVariant::where('provider_id',$pid)->where('handset_id',$hid)->delete();
        if($res1 || $res2)
        {
           return true;
        }
        return false; 
   }

   /**
     * return variant listintg
     *
     * @return array|mixed
     */
   public static function getVariantListing($request)
   { 
        $handsetId = decryptGdprData($request->handsetId);
        $providerId = decryptGdprData($request->providerId); 
        $inputs = $request->all();
        $providerVariant = ProviderVariant::where('provider_id',$providerId)->where('handset_id',$handsetId);
        $allVariants = $providerVariant->pluck('variant_id');
        $variant = new Variant;
        $variant = $variant->join('provider_variants','handset_variant.id','=','provider_variants.variant_id')
                    ->where('provider_variants.handset_id',$handsetId)
                    ->where('provider_variants.provider_id',$providerId)
                    ->whereIn('handset_variant.id',$allVariants)
                    ->select([
                        'handset_variant.variant_id AS variant_unique_id',
                        'handset_variant.variant_name',
                        'provider_variants.status AS provider_variant_status',
                        'provider_variants.vha_code',
                        'provider_variants.id AS provider_variant_table_id',
                        'provider_variants.provider_id',
                        'handset_variant.capacity_id',
                        'handset_variant.color_id',
                        'handset_variant.internal_stroage_id',
                        'handset_variant.id AS handset_variant_table_id',
                        'handset_variant.handset_id']);
        $variant = self::variantFilter($variant,$request->all(),$providerVariant);
        $variants = $variant->where('handset_variant.handset_id',$handsetId)->get(20); 
        $assginvariants = ProviderVariant::where('provider_id',$providerId)->whereNotNull('variant_id'); 
        $providers = Providers::select('legal_name','id')->whereStatus(1)->get();
        $colors = Color::get(); 
        $capacities = Capacity::get(); 
        $interStorages = InternalStorage::get();
        $handsetName = Handset::where('id', $handsetId)->value('name'); 
        $filterVars = $request->all();
        $selectedProvider = Providers::with([
            'providersLogo' => function($query){
                $query->select('user_id','name','category_id');
            },
        ])->where('user_id',$providerId)->first();
        return compact('variants','providers','colors','capacities','interStorages','handsetName','assginvariants','selectedProvider','providerId','handsetId','filterVars');
   }

   /*
    *  Purpose: filter plan handsets listing based on filter selected.
    */
    public static function variantFilter($variant, $inputs,$providerVariant)
    { 
        if(isset($inputs['variant_id'])){
            $variant = $variant->where('handset_variant.variant_id','like', '%'.$inputs['variant_id'].'%');
        }
        if(isset($inputs['variant_name'])){
            $variant = $variant->where('handset_variant.variant_name','like', '%'.$inputs['variant_name'].'%');
        }
        if(!empty($inputs['color'])){
            $variant = $variant->where('handset_variant.color_id',$inputs['color']);
        }
        //Filter according to given brand
        if(isset($inputs['ram'])){
            $variant = $variant->where('handset_variant.capacity_id',$inputs['ram']);
        }
        if(isset($inputs['internal'])){
            $variant = $variant->where('handset_variant.internal_stroage_id',$inputs['internal']);
        }
        if(isset($inputs['status']) && $inputs['status'] == 2)
        {
            $inputs['status'] = null;
        }
        if(isset($inputs['status'])){  
            $filtervariants = $providerVariant->where('provider_variants.status',$inputs['status'])->pluck('provider_variants.variant_id');
            $variant = $variant->whereIn('handset_variant.id',$filtervariants); 
        }
        if(isset($inputs['vha_code'])){
            $vha = $providerVariant->where('provider_variants.vha_code', $inputs['vha_code'])->pluck('provider_variants.variant_id');
            $variant = $variant->whereIn('handset_variant.id',$vha);
        }
        return $variant;
    }

    /**
     * change variant status
     * 
     */
    public static function changeProviderVariantStatus($request)
    { 
        $id = decryptGdprData($request->get('id')); 
        $status = $request->get('status');
        $providerVariant =   ProviderVariant::where('id',$id)->first();
        // check if vha code is entered or not.
        if(!isset($providerVariant) || $providerVariant->vha_code=='' || $providerVariant->vha_code==null){
            $response['status'] = 402;
            $response['message'] = "Please enter SKU code.";
            return  $response;
        }
        $providerId = $providerVariant->provider_id;
        $handsetId = $providerVariant->handset_id;
        $variantId = $providerVariant->variant_id;
        $res= ProviderVariant::where('id',$id)->update(["status" => $status]);
        if($res){
            $planIds = PlanMobile::where('provider_id',$providerId)->pluck('id')->toArray();
            // change status of all variant which are assign to particular plan
            PlanMobileVariant::whereIn('plan_id',$planIds)->where('handset_id',$handsetId)->where('variant_id',$variantId)->update(['provider_status'=>$status]);
            $response['status'] = 200;
            $response['message'] = "Variant status changed Successfully.";
            return  $response;
        } 
        $response['status'] = 400;
        $response['message'] = "Variant status not updated. Please try again later.";
        return  $response;
    }

    /**
     * delete provider variant
     * 
     */
    public static function deleteProviderVariant($request){ 
        if(ProviderVariant::where('id', decryptGdprData($request->input('id')))->delete())
        {
            $response['status'] = 200;
            $response['message'] = "Variant Deleted Successfully.";
            return  $response;
        }
        $response['status'] = 400;
        $response['message'] = "Variant not deleted. Please try again later.";
        return  $response;
    }

    /**
     * store vha code
     * 
     */
    public static function storeVHACode($request){ 
        $res = ProviderVariant::where('id',$request->provider_variant_table_id)->update(['vha_code'=>$request->vha_code]);
        if($res){
            $response['status'] = 200;
            $response['message'] = "SKU Code saved Successfully!";
            return $response; 
        } 
        $response['status'] = 400;
        $response['message'] = "SKU Code not saved. Please try again later.";
        return $response; 
    }  

     /**
     * show images
     * note:- common method used to display variant images
     * 
     */
    public static function showVariantImages($request){
        $html = '';
        $variant_data = new Variant();
        $data = $variant_data::find(decryptGdprData($request->variantId));
        foreach ($data->all_images as $img_table )
        {
            $html = $html . "<a class='img-pop' href=".$img_table->image." data-toggle='tooltip' title=".ucfirst(str_replace("_"," ",$img_table->type))."> <img style='width:30px' src=".$img_table->image."></a>";
        }
        $response['status'] = 200;
        $response['data'] = $data;
        $response['var_img'] =  $html;  
        return $response;
    }
}
