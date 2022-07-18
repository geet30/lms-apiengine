<?php


namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use App\Http\Requests\Affiliates\TargetRequest;
use App\Models\{
	AffiliateTarget
};

class TargetController extends Controller
{
	protected $target;

	public function __construct()
	{
		$this->target = new AffiliateTarget();
	}
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function index($userId = null)
	{
		try {
			$headArr = [];
			$headArr['link'] = '/affiliates/list';
			$headArr['title'] = 'Affiliates';
			$headArr['requestFrom'] = "";
			if (\Request::segment(2) == 'sub-affiliates') {
				$headArr['title'] = 'Sub Affiliates';
				$headArr['requestFrom'] = 'sub-affiliates';
			}

			$defaultYears = [\Carbon::now()->format('Y'), \Carbon::now()->addYear()->format('Y')];
			$targetRecords = [];
			$response = $this->target->getTargetlist(\Request::all(), $userId);

			if (isset($response["target"])) {
				$targetRecords = $response["target"];
			}
			$targetDates
				= $response["target_dates"];
			return response()->json(['targetRecords' => $targetRecords, 'targetDates' => $targetDates, 'defaultYears' => $defaultYears], 200);
		} catch (\Exception $e) {
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, 400);
		}
	}




	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Affiliates\TargetRequest  $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(TargetRequest $request)
	{
		try {
			$response = $this->target->storeTarget($request);
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
	public function getTargetExport()
	{
		try {
			$response = $this->target->targetExport(\Request::all());
			return $response;
		} catch (\Exception $e) {
			$status = 400;
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, $status);
		}
	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			$response = $this->target->deleteTarget($id);
			return $response;
		} catch (\Exception $e) {
			$status = 400;
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, $status);
		}
	}
}
