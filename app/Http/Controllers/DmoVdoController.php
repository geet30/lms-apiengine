<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\DmoVdoPriceImportRequest;
use App\Http\Requests\Settings\DmoVdoPriceRequest;
use App\Http\Requests\Settings\DmoVdoPriceStateRequest;
use App\Models\DmoVdo;
use Illuminate\Http\Request;

class DmoVdoController extends Controller
{
    public function index()
    {
        try {
            return DmoVdo::index();
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function getDmoVdo(Request $request)
    {
        try {
            return DmoVdo::getDmoVdo($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function postDmoVdo(DmoVdoPriceRequest $request, $dmo_vdo_id = null)
    {
        try {
            return DmoVdo::postDmoVdo($request, $dmo_vdo_id);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function importDmoVdo(DmoVdoPriceImportRequest $request)
    {
        try {
            return DmoVdo::importDmoVdo($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function postDmoVdoStates(DmoVdoPriceStateRequest $request)
    {
        try {
            return DmoVdo::postDmoVdoStates($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function deleteDmoVdo($dmo_vdo_id)
    {
        try {
            return DmoVdo::deleteDmoVdo($dmo_vdo_id);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function downloadDmoVdoSampleSheet(){
        $file = public_path('downloads/DmoVdoImportSample.csv');
        return response()->download($file);
    }
}
