<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Providers\AssignPostcodesRequest;
use App\Models\UserPostcode;

class PostCodeController extends Controller
{
    public function getPostcodes($user_id, $distributor_id, $energy_type){
        try {
            return UserPostcode::getPostcodes($user_id, $distributor_id, $energy_type);
        } catch (\Exception $err) {
            return response()->json(['message' => 'Unable to get postcodes.', 'exception' => $err->getMessage()], 500);
        }
    }

    public function assignPostcodes(AssignPostcodesRequest $request)
    {
        try {
            return UserPostcode::assignPostcodes($request);
        } catch (\Exception $err) {
            return response()->json(['message' => 'Unable to assign postcodes.', 'exception' => $err->getMessage()], 500);
        }
    }

    public function getDistributorsByEnergyType($user_id, $energy_type){
        try {
            return UserPostcode::getDistributorsByEnergyType($user_id, $energy_type);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
