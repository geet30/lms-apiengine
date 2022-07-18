<?php

namespace App\Http\Controllers\Settings;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Plans\{
        EnergyTariffInfo 
    }; 
use App\Http\Requests\Settings\ImportDemandRate; 
use App\Exports\ExportMasterTariff;
class ImportTariffRateController extends Controller
{ 
    /**
     * import demand tariff info and rates using csv file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function postImportDemandTarrif(ImportDemandRate $request)
    {
        try
        {
            return EnergyTariffInfo::importDemandTariffRates($request);
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }


    /**
     * it return private path of s3 bucket sample file.
     *
     * @return \Illuminate\Http\Response
     */
	public function getDemandTarrif(Request $request)
    {
        try
        {
            $path = config('app.tariff_upload_sheet_path');
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

    /**
     * Generate tariff id's 
     */
    function genrateTariffIds()
    {
        try
        {
            return Excel::download(new ExportMasterTariff,'Tariff-ID.xlsx');
        } 
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }
}
