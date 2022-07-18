<?php

namespace App\Repositories\Settings\DmoVdo;

use App\Imports\DmoVdoPriceImport;
use App\Models\DmoVdo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


trait BasicCrudMethods
{
    public static function index()
    {
        try {
            $states = DB::table('states')->select('state_id', 'state_code')->get();
            $dmo_states = DB::table('dmo_states')->pluck('state_id')->toArray();
            $distributors = DB::table('distributors')->where(['is_deleted' => 0, 'status' => 1, 'energy_type' => 1])->get();
            $tariff_types = DB::table('tariff_types')->get();
            return view('pages.settings.dmo-vdo.list', compact('distributors', 'tariff_types', 'states', 'dmo_states'));
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function getDmoVdo($request)
    {
        try {
            $dmo_vdo = DmoVdo::select('dmo_vdo_price.*', 'distributors.id as distributor_id', 'distributors.name as distributor_name', 'tariff_types.id as tariff_id', 'tariff_types.tariff_types as tariff_types')
                ->join('distributors', 'distributors.id', 'dmo_vdo_price.distributor_id')
                ->join('tariff_types', 'tariff_types.id', 'dmo_vdo_price.tariff_type')
                ->orderBy('id', 'desc')
                ->get();
            return response()->json(['status' => '1', 'dmo_vdo' => $dmo_vdo]);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function postDmoVdo($request, $dmo_vdo_id)
    {
        try {
            $data = [
                'distributor_id' => $request->distributor,
                'property_type' => $request->property_type,
                'tariff_type' => $request->tariff_type,
                'tariff_name' => $request->tariff_name,
                'offer_type' => $request->offer_type,
                'annual_price' => $request->annual_price,
                'peak_only' => $request->peak_only,
                'peak_offpeak_peak' => $request->peak_offpeak_peak,
                'peak_offpeak_offpeak' => $request->peak_offpeak_offpeak,
                'peak_shoulder_peak' => $request->peak_shoulder_peak,
                'peak_shoulder_offpeak' => $request->peak_shoulder_offpeak,
                'peak_shoulder_shoulder' => $request->peak_shoulder_shoulder,
                'peak_shoulder_1_2_peak' => $request->peak_shoulder_1_2_peak,
                'peak_shoulder_1_2_offpeak' => $request->peak_shoulder_1_2_offpeak,
                'peak_shoulder_1_2_shoulder_1' => $request->peak_shoulder_1_2_shoulder_1,
                'peak_shoulder_1_2_shoulder_2' => $request->peak_shoulder_1_2_shoulder_2,
                'control_load_1' => $request->control_load_1,
                'control_load_2' => $request->control_load_2,
                'control_load_1_2_1' => $request->control_load_1_2_1,
                'control_load_1_2_2' => $request->control_load_1_2_2,
                'annual_usage' => $request->annual_usage,
            ];

            if (isset($dmo_vdo_id)) {
                $data['updated_at'] = now();
                $message = 'Dmo vdo updated successfully.';
                $error_message = 'Unable to update dmo vdo.';
            } else {
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $message = 'Dmo vdo added successfully.';
                $error_message = 'Unable to add dmo vdo.';
            }

            DmoVdo::updateOrCreate(['id' => $dmo_vdo_id], $data);
            return response()->json(['status' => '1', 'message' => $message]);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $error_message, 'exception' => $err->getMessage()], 500);
        }
    }

    public static function deleteDmoVdo($dmo_vdo_id)
    {
        try {
            DmoVdo::find($dmo_vdo_id)->delete();
            return response()->json(['status' => '1', 'message' => 'DMO VDO deleted successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function postDmoVdoStates($request)
    {
        try {
            foreach ($request->states as $key => $state) {
                $data[$key]['state_id'] = $state;
            }
            DB::table('dmo_states')->truncate();
            DB::table('dmo_states')->insert($data);
            return response()->json(['status' => '1', 'message' => 'DMO VDO states updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function importDmoVdo($request){
        try {
            Excel::import(new DmoVdoPriceImport(), $request->file('file'));
            return response()->json(['status' => '1', 'message' => 'DMO VDO imported successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }
}
