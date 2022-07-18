<?php

namespace App\Http\Controllers\MobileSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MobileSettings\{ColorsRequest};
use App\Models\{Color};

class ColorsController extends Controller
{
    protected $colors;

	public function __construct()
	{
		$this->colors = new Color();

	}


    public function index(Request $request)
	{
		try {

            $colorsRecords = [];
			$response = $this->colors->getMobileColors($request);
			if (isset($response["colors"])) {
				$colorsRecords = $response["colors"];
			}
			$userPermissions = getUserPermissions(); 
			$appPermissions = getAppPermissions();
			$add_per = false;
			$action_per=false;
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_colors',$userPermissions,$appPermissions) && checkPermission('add_color',$userPermissions,$appPermissions)){
				$add_per = true;
			}
			if(checkPermission('show_handsets',$userPermissions,$appPermissions) && checkPermission('manage_colors',$userPermissions,$appPermissions) && checkPermission('color_action',$userPermissions,$appPermissions)){
				$action_per=true;
			}
            return response()->json(['colorsRecords' => $colorsRecords,'add_per' => $add_per,'action_per'=>$action_per], 200);
		} catch (\Exception $e) {
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, 400);
		}
	}
    public function store(ColorsRequest $request)
	{
		try {
			$response = $this->colors->storeColors($request);
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
     * Delete Color
     *
     */
    public function destroy($id){
        try {
			$response = $this->colors->deleteColors($id);
			return $response;
		} catch (\Exception $e) {
			$status = 400;
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, $status);
		}

    }
    public function changeColorstatus(Request $request)
    {
        try {
            $response = $this->colors->changeStatus($request->all());
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
