<?php

namespace App\Http\Controllers\MobileSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MobileSettings\{StorageRequest};
use App\Models\{InternalStorage};

class StorageController extends Controller
{   
    protected $storage;

	public function __construct()
	{
		$this->storage = new InternalStorage();
		
	}

 
    public function index(Request $request)
	{
		try {
	
            $storageRecords = [];
			$response = $this->storage->getMobileStorage($request);
			if (isset($response["storage"])) {
				$storageRecords = $response["storage"];
			}
			$userPermissions = getUserPermissions(); 
			$appPermissions = getAppPermissions();
			$add_per= false;
			$action_per=false;
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_interanl_storage',$userPermissions,$appPermissions) &&checkPermission('add_interanl_storage',$userPermissions,$appPermissions)){
				$add_per = true;
			}
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_interanl_storage',$userPermissions,$appPermissions) &&checkPermission('interanl_storage_action',$userPermissions,$appPermissions)){
				$action_per=true;
			}
            return response()->json(['storageRecords' => $storageRecords,'add_per'=>$add_per,'action_per'=>$action_per], 200);
		} catch (\Exception $e) {
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, 400);
		}
	}
    public function store(StorageRequest $request)
	{
		try {
			$response = $this->storage->storeStorage($request);
			if ($response['status'] == true) {
				return response()->json(['status' => $response['status'], 'message' => $response['message'], 'edit_id' => $response['edit_id']]);
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
    
 
    /**
     * Delete Brand
     *
     */
    public function destroy($id){
        try {
			$response = $this->storage->deleteStorage($id);
			return $response;
		} catch (\Exception $e) {
			$status = 400;
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, $status);
		}

    }
    public function changeStoragestatus(Request $request)
    {
        try {
            $response = $this->storage->changeStatus($request->all());
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
