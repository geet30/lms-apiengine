<?php

namespace App\Http\Controllers\Plans\Energy;
use App\Http\Controllers\Controller; 
use App\Http\Requests\Plan\Energy\UploadPlanRequest;   
use Illuminate\Http\Request;
use App\Models\{PlanEnergy};
class PlanUploadController extends Controller
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
            if ($type == 'electricity') {
                $data = PlanEnergy::readPlanCSV($csv); 
                if ($data == 'invalid') {
                    return response()->json(array('success' => 'false', 'errors' => array('upload_plan' => __('plans/energyPlans.upload_plan_file_validation'))), 422);
                }
                $response = PlanEnergy::genratePlanData($data, $providerId,$type);
            }
            else if ($type == 'gas') {
                $data = PlanEnergy::readgasPlanCSV($csv); 
                if ($data == 'invalid') {
                    return response()->json(array('success' => 'false', 'errors' => array('upload_plan' => __('plans/energyPlans.upload_plan_file_validation'))), 422);
                }  
                $response = PlanEnergy::genratePlanData($data, $providerId,$type);
            } 
            else if ($type == 'lpg') {
                $data = PlanEnergy::readlpgPlanCSV($csv); 
                
                if ($data == 'invalid') {
                    return response()->json(array('success' => 'false', 'errors' => array('upload_plan' => __('plans/energyPlans.upload_plan_file_validation'))), 422);
                }  
                $response = PlanEnergy::genratePlanData($data, $providerId,$type);
            }   
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
            $path = config('app.upload_plan_path');
            if($request->type == 'gas')
            {
                $path = config('app.gas_upload_plan_path');
            }else if($request->type == 'lpg'){
                $path = config('app.lpg_upload_plan_path');
            }

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
