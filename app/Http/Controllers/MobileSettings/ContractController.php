<?php

namespace App\Http\Controllers\MobileSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MobileSettings\{ContractRequest};
use App\Models\{Contract};

class ContractController extends Controller
{
    protected $contract;

	public function __construct()
	{
		$this->contract = new Contract();

	}


    public function index(Request $request)
	{
		try {

            $contractRecords = [];
			$response = $this->contract->getMobileContract($request);
			if (isset($response["contract"])) {
				$contractRecords = $response["contract"];
			}
			$userPermissions = getUserPermissions(); 
			$appPermissions = getAppPermissions();
			$add_per = false;
			$action_per=false;
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_contracts',$userPermissions,$appPermissions) &&checkPermission('add_contracts',$userPermissions,$appPermissions)){
				$add_per = true;
			}
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_contracts',$userPermissions,$appPermissions) &&checkPermission('contracts_action',$userPermissions,$appPermissions)){
				$action_per=true;
			}
            return response()->json(['contractRecords' => $contractRecords,'add_per' => $add_per,'action_per'=>$action_per], 200);
		} catch (\Exception $e) {
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, 400);
		}
	}
    public function store(ContractRequest $request)
	{
		try {
			$response = $this->contract->storeContract($request);
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
			$response = $this->contract->deleteContract($id);
			return $response;
		} catch (\Exception $e) {
			$status = 400;
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, $status);
		}

    }
    public function changeContractstatus(Request $request)
    {
        try {
            $response = $this->contract->changeStatus($request->all());
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
