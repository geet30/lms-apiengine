<?php

namespace App\Http\Controllers\MobileSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MobileSettings\{RamRequest};
use App\Models\{Capacity};

class RamController extends Controller
{   
    protected $capacity;

	public function __construct()
	{
		$this->capacity = new Capacity();
		
	}

 
    public function index(Request $request)
	{
		try {
	
            $ramRecords = [];
            // if($request->filter_status){

            // }
			$response = $this->capacity->getMobileRam($request);
			if (isset($response["ram"])) {
				$ramRecords = $response["ram"];
			}
			$userPermissions = getUserPermissions(); 
			$appPermissions = getAppPermissions();
			$add_per= false;
			$action_per=false;
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_rams',$userPermissions,$appPermissions) &&checkPermission('add_ram',$userPermissions,$appPermissions)){
				$add_per = true;
			}
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_rams',$userPermissions,$appPermissions) &&checkPermission('ram_action',$userPermissions,$appPermissions)){
				$action_per=true;
			}
            return response()->json(['ramRecords' => $ramRecords,'add_per' => $add_per,'action_per'=>$action_per], 200);
		} catch (\Exception $e) {
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, 400);
		}
	}
    public function store(RamRequest $request)
	{
		try {
			$response = $this->capacity->storeRam($request);
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
			$response = $this->capacity->deleteRam($id);
			return $response;
		} catch (\Exception $e) {
			$status = 400;
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, $status);
		}

    }
    public function changeRamstatus(Request $request)
    {
        try {
            $response = $this->capacity->changeStatus($request->all());
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
