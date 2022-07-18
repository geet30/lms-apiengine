<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\MasterTariffCode\MasterTariffCodeImportRequest;
use App\Http\Requests\Settings\MasterTariffCode\MasterTariffCodeRequest;
use App\Models\MasterTariffCode;
use Illuminate\Http\Request;

class MasterTariffCodeController extends Controller
{
    public function index()
    {
        try {
            return MasterTariffCode::index();
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function getMasterTariffCode(Request $request)
    {
        try {
            return MasterTariffCode::getMasterTariffCode($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function changeMasterTariffCodeStatus($master_tariff_code_id)
    {
        try {
            return MasterTariffCode::changeMasterTariffCodeStatus($master_tariff_code_id);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function changeMasterTariffCodeStatusBulk(Request $request)
    {
        try {
            return MasterTariffCode::changeMasterTariffCodeStatusBulk($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function postMasterTariffCode(MasterTariffCodeRequest $request, $dmo_vdo_id = null)
    {
        try {
            return MasterTariffCode::postMasterTariffCode($request, $dmo_vdo_id);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function importMasterTariffCode(MasterTariffCodeImportRequest $request)
    {
        try {
            return MasterTariffCode::importMasterTariffCode($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function deleteMasterTariffCode($dmo_vdo_id)
    {
        try {
            return MasterTariffCode::deleteMasterTariffCode($dmo_vdo_id);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function downloadMasterTariffCodeSampleSheet(){
        $file = public_path('downloads/MasterTariffCodeImportSample.csv');
        return response()->download($file);
    }
}
