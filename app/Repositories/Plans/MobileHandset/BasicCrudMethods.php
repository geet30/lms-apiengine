<?php

namespace App\Repositories\Plans\MobileHandset;

use App\Models\{ 
    Brand,
    Contract,
    Handset, 
    PlanContract,
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
    /*
    *  Purpose: get all handsets
    */
	public static function getHandsetListing($request)
    {
        $providerId = decryptGdprData($request->providerId);
        $planId = decryptGdprData($request->planId);
 
        $brands = Brand::get();
        $assignHandset = PlanMobileHandset::where('plan_id',$planId)->with('handset');
        $assignHandset = self::planHandsetFilter($assignHandset,$request);
        $assignHandset = $assignHandset->get();
        $filterVars = $request->all();

        $selectedProvider = Providers::with([
            'providersLogo' => function($query){
                $query->select('user_id','name','category_id');
            },
        ])->where('user_id',$providerId)->first();

        return compact('brands','assignHandset','providerId','planId','filterVars','selectedProvider');
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
        // Filter based on handset name
        if (isset($request->handset_name)) {
            $handsetID = $handset->where('name', 'like', "%" . $request->handset_name . "%")->pluck("id");
            $model = $model->whereIn('handset_id', $handsetID);
        }
        //Filter according to given brand
        if (isset($request->brand)) {
            $handsetBrand = $handset->where('brand_id', $request->brand)->pluck("id");
            $model = $model->whereIn('handset_id', $handsetBrand);
        }
        return $model;
    }

    /*
    * purpose: fetch all handsets to assign plan.
    */
    public static function gethandsetsToAssign($request)
    {
        $providerId = $request->providerId;
        $planId = $request->planId;
        $handsetIDs = PlanMobileHandset::join('plans_mobile', 'plans_mobile.id', '=', 'plans_mobile_handsets.plan_id')
            ->where('plans_mobile.provider_id', $providerId)
            ->where("plan_id", $planId)->pluck('handset_id')->toArray();

        $notAssignedHandsets = ProviderHandset::whereNotIn("handset_id", $handsetIDs)->where('provider_id', $providerId)->whereStatus(1)->pluck('handset_id')->toArray();
        $response = Handset::select("id", "name")->whereIn('id', $notAssignedHandsets)->whereStatus(1)->get();
        return $response;
    }

    public static function postAssignPhones($request){ 
        $providerID = $request->provider_id;
        $planId = $request->plan_id; 
        $allHandsetIds = $request->select_assign_handset;

        $existHandsetRecords = PlanMobileHandset::where("plan_id", $planId)->get()->toArray();  
        $existHandsetIds = array_column($existHandsetRecords,'handset_id');
        
        $providerVariants = ProviderVariant::where('provider_id', $providerID)->get()->groupBy('handset_id')->toArray();  
        $masterStatus = Handset::pluck('status','id')->toArray();
        $providerStatus = ProviderHandset::where('provider_id', $providerID)->pluck('status','handset_id')->toArray(); 
        $variantStatus = Variant::pluck('status','id')->toArray();
        $insertHandsetIds = array_diff($allHandsetIds,$existHandsetIds); 
        $insertVariantData = $insertHandsetData= [];  
        foreach($insertHandsetIds as $handsetId)
        {  
            $insertHandsetData[] = [
                'plan_id' => $planId,
                'handset_id' => $handsetId,
                'master_status' => isset($masterStatus[$handsetId]) ?$masterStatus[$handsetId] :0,
                'provider_status' => isset($providerStatus[$handsetId]) ?$providerStatus[$handsetId] :0,
                'status' => '0'
            ]; 
            if (isset($providerVariants[$handsetId]) && count($providerVariants[$handsetId]) > 0) {
                $variants = $providerVariants[$handsetId];
                foreach ($variants as $variant) { 
                    $insertVariantData[] = [
                        'plan_id' => $planId,
                        'handset_id' => $handsetId,
                        'variant_id' => $variant['variant_id'],
                        'master_status' => isset($variantStatus[$variant['variant_id']]) ?$variantStatus[$variant['variant_id']] :0,
                        'provider_status' => $variant['status'],
                        'status' => '0'
                    ];  
                }
            }
        }  
        PlanMobileHandset::insert($insertHandsetData);  
        PlanMobileVariant::insert($insertVariantData); 
        $assignHandset = PlanMobileHandset::where('plan_id',$planId)->with(['handset','handset.brand'])->get()->toArray();  
        $assignHandset = array_map(function ($handset) {
            $handset['id'] = encryptGdprData($handset['id']);
            $handset['handset_id'] = encryptGdprData($handset['handset_id']);
            return $handset;
        },$assignHandset);
        $response['handsets'] = $assignHandset;
        $response['message'] = "Handset assigned successfully.";
        return $response;  
    }

    public static function changePhoneStatus($request){
        $id = decryptGdprData($request->id);
        $status = $request->status;
        $planHandset = PlanMobileHandset::find($id);
        $handsetStatus = Handset::where('id', $planHandset->handset_id)->value('status');
        if ($handsetStatus == 0 && $status == 1) { 
			$response['status'] = 400;
            $response['message'] = "Please enable Phone from master Phone(s) list first.";
            return $response;
        }
        $resp = PlanMobileHandset::where('id', $id)->update(['status' => $status]); 
        if ($resp) {
			$response['status'] = 200;
            $response['message'] = "Phone Status Updated Successfully.";
            return $response;
        }
		$response['status'] = 400;
        $response['message'] = "Phone status not updated. Please try again later.";
        return $response;
    }

    /*
    * purpose: fetch all handsets to assign plan.
    */
    public static function getVariantListing($request)
    {
        $providerId = decryptGdprData($request->providerId);
        $planId = decryptGdprData($request->planId);
        $handsetId = decryptGdprData($request->handsetId);
        $inputs = $request->all();
        $variants = PlanMobileVariant::where('plan_id',$planId)->where('handset_id',$handsetId);
        $variants = self::planVariantFilter($variants,$request->all()); 
        $variants = $variants->orderBy('id','desc')->get();
        $colors = Color::get();
        $capacities = Capacity::get();
        $interStorages = InternalStorage::get();
        $planHandsetStatus = PlanMobileHandset::where('plan_id',$planId)->where('handset_id',$handsetId)->value('status');
        $handsetName = Handset::where('id', $handsetId)->value('name');
        $providerName = Providers::where('id', $providerId)->value('legal_name');
        $planName = PlanMobile::where('id', $planId)->value('name');
        $filterVars = $request->all();
        return compact('providerId','planId','handsetId','colors','variants','capacities','interStorages','handsetName','providerName','planName','filterVars');
    }

    /*
    *  Purpose: filter plan handsets listing based on filter selected.
    */
    public static function planVariantFilter($model, $inputs)
    {
        $variant = new Variant;
        if (isset($inputs['variant_id'])) {
            $variant_id = $variant->where('variant_id', 'like', '%' . $inputs['variant_id'] . '%')->pluck('id')->toArray();
            $model = $model->whereIn('variant_id', $variant_id);
        }
        if (isset($inputs['variant_name'])) {
            $variant_name = $variant->where('variant_name', 'like', '%' . $inputs['variant_name'] . '%')->pluck('id')->toArray();
            $model = $model->whereIn('variant_id', $variant_name);
        } 
        if (!empty($inputs['color'])) {
            $color_id = $variant->where('color_id', $inputs['color'])->pluck('id')->toArray();
            $model = $model->whereIn('variant_id', $color_id);
        } 
        if (isset($inputs['ram'])) {
            $ram = $variant->where('capacity_id', $inputs['ram'])->pluck('id')->toArray();
            $model = $model->whereIn('variant_id', $ram);
        }
        if (isset($inputs['internal'])) {
            $internal = $variant->where('internal_stroage_id', $inputs['internal'])->pluck('id')->toArray();
            $model = $model->whereIn('variant_id', $internal);
        }
        if(isset($inputs['status']) && $inputs['status'] == 2)
        {
            $inputs['status'] = null;
        }
        if (isset($inputs['status'])) {
            $model = $model->where('status', $inputs['status']);
        } 
        return $model;
    }


    public static function getEditPhoneVariant($request)
    {
        $providerId = decryptGdprData($request->providerId);
        $planId = decryptGdprData($request->planId);
        $handsetId = decryptGdprData($request->handsetId);
        $variantId = decryptGdprData($request->variantId);
        $variantData = PlanMobileVariant::where('id',$variantId)->firstOrFail();
        $variant_contracts = PlanContract::where('plan_variant_id',$variantId)->get()->toArray();
        $variant_own_contracts = [];
        $variant_lease_contracts = [];
        foreach ($variant_contracts as $key => $value) {
            if($value['contract_type']==0){
                $variant_own_contracts[] = $value;
            }else{
                $variant_lease_contracts[] = $value;
            }
        }
        $contracts = Contract::orderBy('validity')->where('status',1)->get(['*']);
        return compact( 'variantData','planId','handsetId','variantId','contracts','variant_own_contracts','variant_lease_contracts','providerId');
    }

    public static function changeVariantStatus($request){
        $id = decryptGdprData($request->id); 
        $status = $request->get('status');
        $isCount = PlanContract::where('plan_variant_id', $id)->count();
        $res = PlanMobileVariant::where('id', $id)->first();
        $variantId = $res->variant_id;
        $handsetId = $res->handset_id; 
        $providerId = $request->providerId; 
        $vhaCode = ProviderVariant::where('provider_id', $providerId)->where("handset_id", $handsetId)->where('variant_id', $variantId)->value('vha_code'); 
        if($vhaCode == '' || $vhaCode == null){ 
			$response['status'] = 400;
            $response['message'] = "Variant is disabled for Provider. Please enable variant in provider first.";
            return $response;
        }
        
        $handsetStatus = PlanMobileHandset::where('handset_id', $res->handset_id)->where('plan_id', $res->plan_id)->value('status');

        if ($handsetStatus == 1)
        {
            if ($isCount == 0) { 
				$response['status'] = 400;
                $response['message'] = "Please Add Variant Contract details.";
                return $response;
            } 
            $res->status = $status;
            $res->save(); 
			$response['status'] = 200;
            $response['message'] = "Variant status changed Successfully.";
            return $response;
            
        }   
		$response['status'] = 400;
        $response['message'] = "Please Enable Phone First."; 
        return $response;
    } 
	
	public static function updateAssignedPlanVariantDetails($request)
    { 
        $data = [
                'own' => 0 ,
                'lease' => 0,
                'own_cost' => 0,
                'lease_cost' => 0
            ];
        if(isset($request->own) && $request->own == 1)
        {
            $data['own'] = $request->own;
            $data['own_cost'] = $request->own_cost ?? 0;
        }
        if(isset($request->lease) && $request->lease == 1)
        {
            $data['lease'] = $request->lease;
            $data['lease_cost'] = $request->lease_cost ?? 0;
        } 
 
        if (!PlanMobileVariant::where('id', $request->input('plan_variant_id'))->update($data)) {
            return false;
        } 

        // delete existing variant entries.
        PlanContract::where('plan_variant_id', $request->input('plan_variant_id'))->delete();
        $contractOwnCost = $contractOwnDesc = $contractLeaseCost = $contractLeaseDesc = [];

        $contractOwnSelected = isset($request->checkbox_own_contract)?$request->checkbox_own_contract :[];
        $contractLeaseSelected = isset($request->checkbox_lease_contract) ? $request->checkbox_lease_contract :[];

        if(isset($contractOwnSelected) && count($contractOwnSelected)){ 
            $contractOwnCost = $request->contract_own_cost; 
            $contractOwnDesc = $request->contract_own_desc; 
        } 

        if(isset($contractLeaseSelected) && count($contractLeaseSelected)){ 
            $contractLeaseCost = $request->contract_lease_cost; 
            $contractLeaseDesc = $request->contract_lease_desc; 
        }
        $contractData =[];
        foreach ($contractOwnSelected as $key => $value) {
            $contractData[] = [
                'plan_variant_id' => $request->input('plan_variant_id'),
                'contract_id' => $value,
                'plan_id' =>  decryptGdprData($request->plan_id),
                'contract_cost' => $contractOwnCost[$value],
                'description' => $contractOwnDesc[$value],
                'contract_type' => 0,
                'status' => 1,
            ];
        }    
 
        foreach ($contractLeaseSelected as $key => $value) {
            $contractData[] = [
                'plan_variant_id' => $request->input('plan_variant_id'),
                'contract_id' => $value,
                'plan_id' =>  decryptGdprData($request->plan_id),
                'contract_cost' => $contractLeaseCost[$value],
                'description' => $contractLeaseDesc[$value],
                'contract_type' => 1,
                'status' => 1,
            ];
        }  
        PlanContract::insert($contractData);    

        $result['message']= 'Variant updated successfully.';
        return response()->json($result,200);
    }
}
