<?php

namespace App\Repositories\Settings\MasterTariffCode;

use App\Imports\MasterTariffCodesImport;
use App\Models\Distributor;
use App\Models\MasterTariffCode;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


trait BasicCrudMethods
{
    public static function index()
    {
        try {
            $distributors = Distributor::where(['energy_type' => 1, 'status' => 1, 'is_deleted' => 0])->get();

            return view('pages.settings.master-tariff-codes.list', compact('distributors'));
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function getMasterTariffCode($request)
    {
        try {
            $master_tariffs = MasterTariffCode::select('master_tariffs.*', 'distributors.id as distributor_id', 'distributors.name as distributor_name')
                ->join('distributors', 'distributors.id', 'master_tariffs.distributor_id')
                ->where('master_tariffs.is_deleted', 0)
                ->orderBy('id', 'desc')
                ->get();
            return response()->json(['status' => '1', 'master_tariffs' => $master_tariffs]);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function postMasterTariffCode($request, $master_tariff_code_id)
    {
        try {
            $data = [
                'distributor_id' => $request->distributor,
                'property_type' => $request->property_type,
                'tariff_type' => $request->tariff_type,
                'tariff_code' => $request->tariff_code,
                'master_tariff_ref_id' => 1,
                'units_type' => $request->units_type,
                'status' => $request->status,
            ];

            if (isset($master_tariff_code_id)) {
                $data['updated_at'] = now();
                $message = 'Master tariff updated successfully.';
                $error_message = 'Unable to update master tariff.';
            } else {
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $message = 'Master tariff added successfully.';
                $error_message = 'Unable to add master tariff.';
            }

            MasterTariffCode::updateOrCreate(['id' => $master_tariff_code_id], $data);
            return response()->json(['status' => '1', 'message' => $message]);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $error_message, 'exception' => $err->getMessage()], 500);
        }
    }

    public static function deleteMasterTariffCode($master_tariff_code_id)
    {
        try {
            MasterTariffCode::find($master_tariff_code_id)->update(['is_deleted' => 1]);
            return response()->json(['status' => '1', 'message' => 'Master tariff deleted successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function changeMasterTariffCodeStatus($master_tariff_code_id)
    {
        try {
            $status = DB::table('master_tariffs')->whereId($master_tariff_code_id)->pluck('status');
            DB::table('master_tariffs')->whereId($master_tariff_code_id)->update(['status' => !$status[0]]);
            return response()->json(['status' => '1', 'message' => 'Status updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => 'Unable to update status.', 'exception' => $err->getMessage()], 500);
        }
    }

    public static function changeMasterTariffCodeStatusBulk($request)
    {
        try {
            $ids = explode(',', $request->ids);
            DB::table('master_tariffs')->whereIn('id', $ids)->update(['status' => $request->status]);
            return response()->json(['status' => '1', 'message' => 'Status updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => 'Unable to update status.', 'exception' => $err->getMessage()], 500);
        }
    }

    public static function importMasterTariffCode($request)
    {
        try {
            Excel::import(new MasterTariffCodesImport($request->method), $request->file('file'));
            return response()->json(['status' => '1', 'message' => 'Master tariff imported successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }
}
