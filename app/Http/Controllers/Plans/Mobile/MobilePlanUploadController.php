<?php

namespace App\Http\Controllers\Plans\Mobile;
use App\Http\Controllers\Controller; 
use App\Http\Requests\Plan\Mobile\UploadPlanRequest;   
use Illuminate\Http\Request;
use App\Models\{PlanMobile};
class MobilePlanUploadController extends Controller
{
    /**
     * upload plans.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadPlans(UploadPlanRequest $request)
    {
       
        try{
            \DB::beginTransaction();
            $providerId = $request->providerId;
            $csv = $request->file('upload_plan');
            $type = $request->type;
           
            $data = PlanMobile::readPlanCSV($csv); 
            if ($data == 'invalid') {
                return response()->json(array('success' => 'false', 'errors' => array('upload_plan' => __('plans/mobile.upload_plan_file_validation'))), 422);
            }
            $response = PlanMobile::genratePlanData($data, $providerId,$type);
          
           
            \DB::commit();
            return response()->json($response,200);
        } 
        catch (\Exception $err) {
            \DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    } 

	/**
     * it return private path of s3 bucket sample file.
     *
     * @return \Illuminate\Http\Response
     */
	public function downloadPlans(Request $request)
    {
        try{
            $path = config('app.mobile_upload_plan_path');
           

            $disk = \Storage::disk('s3');
            $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
                'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
                'Key' => $path,
                'ResponseContentDisposition' => 'attachment;'
            ]);
            $request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+' . env('s3_TIMEOUT', 5) . ' minutes');
            return response()->json(['status' => true, 'url' => (string) $request->getUri()],200);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }
}
