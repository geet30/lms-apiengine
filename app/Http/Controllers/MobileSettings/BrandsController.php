<?php

namespace App\Http\Controllers\MobileSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MobileSettings\{BrandRequest};
use App\Models\{Brand};

class BrandsController extends Controller
{   
    protected $brand;

	public function __construct()
	{
		$this->brand = new Brand();
	}

 
    public function index(Request $request)
	{
		try {
	
            $brandRecords = [];
            // if($request->filter_status){

            // }
			$response = $this->brand->getMobileBrands($request);

			if (isset($response["brand"])) {
				$brandRecords = $response["brand"];
			}
			$userPermissions = getUserPermissions(); 
			$appPermissions = getAppPermissions();
			$add_brand = false;
			$brand_action=false;
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_brands',$userPermissions,$appPermissions) &&checkPermission('add_brand',$userPermissions,$appPermissions)){
				$add_brand = true;
			}
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_brands',$userPermissions,$appPermissions) &&checkPermission('brands_action',$userPermissions,$appPermissions)){
				$brand_action=true;
			}
			return response()->json(['brandRecords' => $brandRecords,"add_brand"=>$add_brand,"brand_action"=>$brand_action], 200);
		} catch (\Exception $e) {
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, 400);
		}
	}
    public function store(BrandRequest $request)
	{
		try {
			$response = $this->brand->storeBrand($request);
			if ($response['status'] == true) {
				return response()->json(['status' => $response['status'], 'message' => $response['message'], 'edit_id' => $response['edit_id']]);
			}
			return response()->json(['status' => $response['status'], 'message' => $response['message']]);
			// return $this->send_response($response, $http_status);
		} catch (\Exception $err) {
			$result = [
				'exception_message' => $err->getMessage()
			];
			$status = 400;

			return response()->json($result, $status);
		}
	}
    
 
    /**
     * Delete Brand
     *
     */
    public function destroy($id){
        try {
			$response = $this->brand->deleteBrand($id);
			return $response;
		} catch (\Exception $e) {
			$status = 400;
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, $status);
		}

    }
    public function changeBrandstatus(Request $request)
    {
        try {
            $response = $this->brand->changeStatus($request->all());
            if ($response['status'] == true) {
                return response()->json(['status' => $response['status'], 'message' => $response['message']]);
            }
            return response()->json(['status' => $response['status'], 'message' => $response['message']]);
        } catch (\Exception $err) {
            $result = [
                'exception_message' => $err->getMessage()
            ];
            $status = 400;

            return response()->json($result, $status);
        }
    }
}
