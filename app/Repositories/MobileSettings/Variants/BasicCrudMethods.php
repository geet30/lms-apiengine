<?php

namespace App\Repositories\MobileSettings\Variants;
use App\Models\{Variant,Variant_images};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


trait BasicCrudMethods
{
	public static function createHandsetVariant($request)
    { 
    	DB::beginTransaction();
    	try{
    		$response=[];
            $status=false;
            $handsetvariant = new Variant();
	        $handsetId= decryptGdprData($request->input('handset_id'));
	    	$handsetvariant->handset_id = $handsetId;
	    	$combinationFound = $handsetvariant::where('handset_id', $handsetId)->where('capacity_id', $request->input('ram'))->where('internal_stroage_id', $request->input('internal_storage'))->where('color_id', $request->input('color'))->count(); 
	    	if ($combinationFound > 0) {
	    		$response['status'] = 400;
	    		$response['message'] = trans('variants.duplicate_variant_exists');
	    		return $response;
            }

            // check variant name already exits or not
            $checkname = Variant::where('handset_id', $handsetId)->where('variant_name', $request->input('variant_name'))->count();
            if($checkname){
            	$response['status'] = 400;
	    		$response['message'] = trans('variants.already');
	    		return $response;
            }

	        $handsetvariant->variant_name = $request->input('variant_name');
	        $handsetvariant->capacity_id = $request->input('ram');
	        $handsetvariant->internal_stroage_id = $request->input('internal_storage');
	        $handsetvariant->color_id = $request->input('color');
	        $handsetvariant->status = 1;
	        $handsetvariant->save();
	    	// newly created variant
	        $varId = $handsetvariant->id;
	        $imagesdata = [];
	        $srno = $request->input("s_no");
	        $imgtype = $request->input("img_type");
	        $imgfile = $request->file("sel_img");

	        foreach ($srno as $key => $value) {
	        	$s3fileName = 'mobile/handset/variant/' . $varId . '/images/';
	        	if ($imgfile[$key] != null) {
	        		$file = $imgfile[$key];
	        		$name = time() . $file->getClientOriginalName();
	        		$name=str_replace(' ', '', $name);
	        		$filePath = config('env.DEV_FOLDER') . $s3fileName.$name;
	        	}

				uploadFile($filePath, file_get_contents($file), 'public');
	            $url = config('env.Public_BUCKET_ORIGIN').config('env.DEV_FOLDER'). $s3fileName . $name;

	        	array_push($imagesdata, [
	        		'handset_id' 	=> $handsetId,
	        		'variant_id' 	=> $varId,
	            	'sr_no' 		=> $value,
	            	'type' 			=> $imgtype[$key],
	            	'status' 		=> 1,
	            	'image'         => $url
	            ]);
	        }
	       
	        $storeimages = Variant_images::insert($imagesdata); 
	        if($storeimages){

	        	DB::commit();
	        	$response['status'] = 200;
	    		$response['message'] = trans('variants.success');
	    		return $response;
	        }

	        DB::rollback();
	        $response['status'] = 400;
    		$response['message'] = trans('variants.notsave');
    		return $response;
    	}
    	catch(\Exception $e){
            DB::rollback();
            $response['status'] = 400;
    		$response['message'] = $e->getMessage();
    		return $response;
        }
    }

    public static function getvariants($request,$id){
    	if ($request->isMethod('post')) {
    		$variant = new Variant;
    		
	        if(isset($request->variant_name)){
	            $variant = $variant->where('variant_name','like', '%'.$request->variant_name.'%');
	        }
	        if(!empty($request->variant_color)){
	            $variant = $variant->whereIn('color_id',$request->variant_color);
	        }
	        if(isset($request->variant_ram)){
	            $variant = $variant->whereIn('capacity_id',$request->variant_ram);
	        }
	        if(isset($request->variant_storage)){
	            $variant = $variant->whereIn('internal_stroage_id',$request->variant_storage);
	        }
	        if(isset($request->status)){
	            $variant = $variant->where('status',$request->status);
	        }
	        
	        $variants = $variant->where('handset_id',decryptGdprData($id))->with(["color","capacity","internal","images"])->orderBy('id','desc')->get();
	        return self::modifyResult($variants );
    	}
    	return Variant::where('handset_id',decryptGdprData($id))
    	->with(["color","capacity","internal","all_images" => function($q) {
		    // $q->select('id','title','hexacode');
		    // $q->select('id','value','unit');
		   }])
    	->orderBy('id','desc')->get();
    }

    public static function modifyResult($variants){
    	$data = [];
    	foreach ($variants as $index => $variant) {
    		
    		$ramvalue = self::getType($variant->capacity->unit);
    		$internalvalue = self::getType($variant->internal->unit);
    		$image = asset(theme()->getMediaUrlPath() . 'avatars/blank.png');
    		if(count($variant->images) > 0){
    			$image = $variant->images[0]->image;
    		}

    		array_push($data,[
    			'sno' => $index+1,
    			'variant_name' => $variant->variant_name,
    			'color' => $variant->color->hexacode,
    			'colortitle' => $variant->color->title,
    			'capacity' => $variant->capacity->value.$ramvalue,
    			'internal' => $variant->internal->value.$internalvalue,
    			'status'  => $variant->status,
    			'id' => $variant->id,
    			'encrypt' => encryptGdprData($variant->id),
    			'image' => $image
    		]);
    	}

    	return $data;
    }

    public static function getType($type){
    	$capacityvalue = '';
		switch ($type) {
        case '0':
            $capacityvalue =$capacityvalue.' MB';
            break;

        case '1':
            $capacityvalue =$capacityvalue.' GB';
            break;

        case '2':
            $capacityvalue =$capacityvalue.' TB';
            break;
        
        default:
            $capacityvalue ='Invalid';
            break;
    	}
    	return $capacityvalue;
    }

   
   	public static function changeStatus($request)
	{
		DB::beginTransaction();
		try {
			$status = 'false';
			$httpStatus = 400;
			
			$query = Variant::where('id', $request['id'])->update(['status' => $request['status']]);
			if ($query) {
				$status = 'true';
			}

			if ($status == 'true') {
				DB::commit();
				$httpStatus = 200;
				$message = trans('affiliates.affiliate_status_update');
				return response()->json(['status' => $httpStatus, 'message' => $message]);
			}
			DB::rollback();
			$message = trans('affiliates.affiliate_status_notupdate');


			return response()->json(['status' => $httpStatus, 'message' => $message]);
		} catch (\Exception $err) {
			DB::rollback();
			return response()->json(['status' => 400, 'message' => $err->getMessage()]);
		}
	}

	public static function getvariantById($handestId,$variantId){
		$res = Variant::find(decryptGdprData($variantId));
		$images = $res->all_images;
		return $res;
	}

	public static function updateHandsetVariant($request){
		DB::beginTransaction();
		try{

			$responsestatus=false;
	        $data = false;
			$varId =  decryptGdprData($request->input('id'));
			$handsetId =  decryptGdprData($request->input('handset_id'));
			$handsetvariant = new Variant();

			$combinationFound = $handsetvariant::where('handset_id', $handsetId)->where('capacity_id', $request->input('ram'))->where('internal_stroage_id', $request->input('internal_storage'))->where('color_id', $request->input('color'))->where('id','!=',$varId)->count();
			if ($combinationFound > 0) {
				$response['status'] = 400;
	    		$response['message'] = trans('variants.duplicate_variant_exists');
	    		return $response;
			}
			// check variant name already exits or not
			$checkname = Variant::where('id','!=',$varId)->where('handset_id', $handsetId)->where('variant_name', $request->input('variant_name'))->count();
			if($checkname){
	            $response['status'] = 400;
	    		$response['message'] = trans('variants.already');
	    		return $response;
	        }

			
			$var = $handsetvariant->find($varId);
	      	$var->variant_name = $request->input('variant_name');
	        $var->capacity_id = $request->input('ram');
	        $var->internal_stroage_id = $request->input('internal_storage');
	        $var->color_id = $request->input('color');
	        $data = $var->update();

			$previousids = $request->input('id_of_img'); 
			$srno = $request->input("s_no") ? $request->input("s_no") : [];
	        $imgtype = $request->input("img_type");
	        $imgfile = $request->file("sel_img");
	        $setimage = $request->file("set_img");
			for ($i = 0; $i < count($srno); $i++) 
	        {	
	        	$newdata = [];
	        	$newdata['variant_id'] = $varId;
	            $newdata['handset_id'] = $handsetId;
	            $newdata['sr_no'] = $srno[$i];
	            $newdata['type'] = $imgtype[$i];
	            $newdata['status'] = 1;


	            $s3fileName = 'mobile/handset/variant/' . $varId . '/images/';
	        	if (isset($imgfile[$i]) && $imgfile != null) {
	        		$file = $imgfile[$i];
	        		$name = time() . $file->getClientOriginalName();
	        		$filePath = config('env.DEV_FOLDER') . $s3fileName.$name;
					uploadFile($filePath, file_get_contents($file), 'public');
	        		$newdata['image'] =  config('env.Public_BUCKET_ORIGIN').config('env.DEV_FOLDER'). $s3fileName . $name;
	        	}

	        	$data = Variant_images::updateOrCreate(['id' => $previousids[$i]], $newdata); 
	        	if($data){
                    $responsestatus=true;
                }else{
                    $responsestatus=false;
                }
	        }
	       
	        if($responsestatus){
                DB::commit();
                $response['status']=200;
                $response['message']=trans('variants.update');
                return $response;
            }

            DB::rollback();
	        $response['status'] = 400;
    		$response['message'] = trans('variants.notsave');
    		return $response;
		}
		catch(\Exception $e){
            DB::rollback();
            $response['status'] = 400;
    		$response['message'] = $e->getMessage();
    		return $response;
        }
	
	}


	public static function deleteVariantImageMethod($id){
		try {
			Variant_images::where('id', decryptGdprData($id))->delete();
        	return response()->json(['status' => 200, 'message' => trans('variants.successdelete')]);
        }catch (\Exception $err) {
			return response()->json(['status' => 400, 'message' => $err->getMessage()]);
		}
	}

}
