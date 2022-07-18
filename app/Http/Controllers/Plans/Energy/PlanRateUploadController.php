<?php

namespace App\Http\Controllers\Plans\Energy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plan\Energy\PlanRateUploadRequest;  
use App\Models\Plans\{EnergyPlanRate};
class PlanRateUploadController extends Controller
{
    /**
     * upload plan rates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPlanRateList(PlanRateUploadRequest $request)
	{
        try
        {
            \DB::beginTransaction();
            $csv = $request->file('upload_plan_rate');
            $type = $request->type; 
            if ($type == 'electricity') {
                $data = EnergyPlanRate::readPlanRateCSV($csv); 
                if ($data == 'invalid') {
                    return response()->json(array('success' => 'false', 'errors' => array('upload_plan_rate' => __('plans/energyPlans.upload_plan_file_validation'))), 422);
                }   
                $response = EnergyPlanRate::genratePlanRateData($data,$request);
            }
            else if ($type == 'gas') {
                $data = EnergyPlanRate::readGasPlanRateCSV($csv); 
                if ($data == 'invalid') {
                    return response()->json(array('success' => 'false', 'errors' => array('upload_plan_rate' => __('plans/energyPlans.upload_plan_file_validation'))), 422);
                }   
                $response = EnergyPlanRate::genrateGasPlanRateData($data,$request);
            }  
            else if ($type == 'lpg') {
                $data = EnergyPlanRate::readLpgPlanRateCSV($csv); 
                if ($data == 'invalid') {
                    return response()->json(array('success' => 'false', 'errors' => array('upload_plan_rate' => __('plans/energyPlans.upload_plan_file_validation'))), 422);
                }   
                $response = EnergyPlanRate::genrateLpgPlanRateData($data,$request);
            }  
            \DB::commit();
            return response()->json(mb_convert_encoding($response, 'UTF-8', 'UTF-8'),200);
        }
        catch (\Exception $err) {
            \DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }

    /**
     * upload missing plan rates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadMissingPlanRateList(Request $request)
	{
        try
        {
            \DB::beginTransaction();
            $type = $request->type;
            $data = null;
            if ($type == 'electricity') {
                $response = EnergyPlanRate::genratePlanRateData($data,$request);
            }
            else if ($type == 'gas') {
                $response = EnergyPlanRate::genrateGasPlanRateData($data,$request);
            }
            else if ($type == 'lpg') {
                $response = EnergyPlanRate::genrateLpgPlanRateData($data,$request);
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
     * @return \Illuminate\Http\JsonResponse
     */
	public function downloadPlanRateList(Request $request)
    {
        try
        {
            $path = config('app.upload_plan_rates_path'); 
            if($request->type == 'gas')
            {
                $path = config('app.gas_upload_plan_rates_path');
            } 
            else if($request->type == 'lpg'){
                $path = config('app.lpg_upload_plan_rates_path');
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
            throw $err;
        }
    }
}
