<?php

namespace App\Repositories\Settings\Distributor;


use App\Imports\DistributorPostCodesImport;
use App\Models\Distributor;
use App\Models\DistributorPostCode;
use App\Models\Postcode;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

trait BasicCrudMethods
{
    public static function index()
    {
        try {
            $post_codes = Postcode::distinct('postcode')->pluck('postcode');
            return view('pages.settings.distributors.list', compact('post_codes'));
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function getDistributor($energy_type=null, $with_postcodes=0)
    {
        try {
            $distributors = Distributor::where('distributors.is_deleted', 0)->orderBy('id', 'desc');
            if(isset($energy_type)){
                $distributors = $distributors->where('energy_type', $energy_type)->where('status',1);
            }
            $distributors = $distributors->get();
            if($with_postcodes){
                $distributors->transform(function($distributor) {
                    $distributor->postcodes = DB::table('distributor_post_codes')->where('distributor_id', $distributor)->get();
                    return $distributor;
                });
            }
            return response()->json(['status' => '1', 'distributors' => $distributors]);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function getDistributorPostCodes($distributor_id)
    {
        try {
            $distributor_post_codes = DB::table('distributor_post_codes')->where('distributor_id', $distributor_id)->pluck('post_code')->toArray();
            $distributor_post_codes = implode(',', $distributor_post_codes);
            return response()->json(['status' => '1', 'distributor_post_codes' => $distributor_post_codes]);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function postDistributor($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->distributor_name,
                'energy_type' => $request->energy_type,
                'service_id' => 1,
                'status' => 1,
            ];

            if (isset($request->distributor_id)) {
                $data['updated_at'] = now();
                $message = 'Distributor updated successfully.';
                $error_message = 'Unable to update distributor.';
            } else {
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $message = 'Distributor added successfully.';
                $error_message = 'Unable to add distributor.';
            }

            $distributor = Distributor::updateOrCreate(['id' => $request->distributor_id], $data);

            DistributorPostCode::where('distributor_id', $distributor->id)->delete();
            if (count($request->post_codes)) {
                foreach ($request->post_codes as $post_code) {
                    DistributorPostCode::create([
                        'distributor_id' => $distributor->id,
                        'post_code' => $post_code,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            DB::commit();
            return response()->json(['status' => '1', 'message' => $message]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json(['status' => '0', 'message' => $error_message, 'exception' => $err->getMessage()], 500);
        }
    }

    public static function deleteDistributor($distributor_id)
    {
        try {
            Distributor::find($distributor_id)->update(['is_deleted' => 1]);
            return response()->json(['status' => '1', 'message' => 'Distributor deleted successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function changeDistributorStatus($distributor_id)
    {
        try {
            $status = DB::table('distributors')->whereId($distributor_id)->pluck('status');
            DB::table('distributors')->whereId($distributor_id)->update(['status' => !$status[0]]);
            return response()->json(['status' => '1', 'message' => 'Status updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => 'Unable to update status.', 'exception' => $err->getMessage()], 500);
        }
    }

    public static function importDistributorPostCodes($request)
    {
        try {
            Excel::import(new DistributorPostCodesImport($request->distributor_id), $request->file('file'));
            return response()->json(['status' => '1', 'message' => 'Post codes imported successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function getDistributorWithPostcodes($energyType, $providerId)
    {
        return self::where('status', 1)->where('is_deleted', 0)->where('energy_type', (int)$energyType)->with(['postCodes', 'providerPostCodes' => function ($q) use ($providerId) {
            $q->where('provider_id', decryptGdprData($providerId));
        }])->get();
    }
}
