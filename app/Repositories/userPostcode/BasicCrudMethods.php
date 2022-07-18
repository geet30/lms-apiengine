<?php

namespace App\Repositories\userPostcode;


use App\Models\Distributor;
use App\Models\DistributorPostCode;
use App\Models\Postcode;
use App\Models\UserPostcode;
use Illuminate\Support\Facades\DB;

trait BasicCrudMethods
{
    public static function getPostCodes($user_id, $distributor_id, $energy_type, $message = null)
    {
        try {
            $postcodes = Distributor::select('distributor_post_codes.post_code')
                ->join('distributor_post_codes', 'distributor_post_codes.distributor_id', 'distributors.id')
                ->where('distributors.id', $distributor_id)
                ->where('distributors.energy_type', $energy_type)
                ->get();

            $provider_postcodes = UserPostcode::where(['user_id' => $user_id, 'energy_type' => $energy_type])->pluck('post_code')->toArray();

            $postcodes->transform(function ($postcode, $index) use ($provider_postcodes) {
                if (in_array($postcode->post_code, $provider_postcodes, true)) {
                    $postcode->selected = 1;
                } else {
                    $postcode->selected = 0;
                }
                return $postcode;
            });
            return response()->json(['status' => 1, 'message' => $message, 'postcodes' => $postcodes]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to get postcodes.', 'exception' => $e->getMessage()], 500);
        }
    }

    public static function assignPostcodes($request)
    {
        try {
            UserPostcode::where(['user_id' => $request->user_id, 'distributor_id' => $request->distributor_id, 'energy_type' => $request->energy_type])->delete();
            if (count($request->provider_postcodes)) {
                $data = [];
                foreach ($request->provider_postcodes as $postcode) {
                    $data[] = [
                        'user_id' => $request->user_id,
                        'distributor_id' => $request->distributor_id,
                        'energy_type' => $request->energy_type,
                        'post_code' => $postcode,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                UserPostcode::insert($data);
            }
            return self::getPostCodes($request->user_id, $request->distributor_id, $request->energy_type, 'Postcodes assigned successfully.');
        } catch (\Exception $err) {
            return response()->json(['status' => 0, 'message' => 'Unable to assign postcodes.', 'exception' => $err->getMessage()], 500);
        }
    }

    public static function getDistributorsByEnergyType($user_id, $energy_type)
    {
        try {
            $distributors = Distributor::where('distributors.is_deleted', 0)->orderBy('id', 'desc')
                ->where('energy_type', $energy_type)->where('status', 1)
                ->get();

            return response()->json(['status' => '1', 'distributors' => $distributors]);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }
}
