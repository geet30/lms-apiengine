<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Distributor\DistributorRequest;
use App\Http\Requests\Settings\Distributor\DistributorPostCodesImportRequest;
use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        try {
            return Distributor::index();
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function getDistributor()
    {
        try {
            return Distributor::getDistributor();
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function getDistributorPostCodes($distributor_id)
    {
        try {
            return Distributor::getDistributorPostCodes($distributor_id);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function changeDistributorStatus($distributor_id)
    {
        try {
            return Distributor::changeDistributorStatus($distributor_id);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function postDistributor(DistributorRequest $request)
    {
        try {
            return Distributor::postDistributor($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function importDistributorPostCodes(DistributorPostCodesImportRequest $request)
    {
        try {
            return Distributor::importDistributorPostCodes($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function deleteDistributor($distributor_id)
    {
        try {
            return Distributor::deleteDistributor($distributor_id);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function downloadPostCodesSampleSheet(){
        $file = public_path('downloads/distributor_post_code.csv');
        return response()->download($file);
    }
}
