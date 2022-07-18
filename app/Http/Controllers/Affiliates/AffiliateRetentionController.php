<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    AssignedUsers,
};
use App\Http\Requests\Affiliates\{RetentionRequest};

class AffiliateRetentionController extends Controller
{
    //function to get services on tab retention tab click.
    public function getRetention($userId, Request $request)
    {
        try {
            $response = [];
            $userId = decryptGdprData($userId);
            $response['user_services'] = AssignedUsers::getUserServices($userId);
            if ($request->user == 'sub-affiliates') {
                $affId = AssignedUsers::getAffiliateIdByParentId($userId);
                $response['user_services'] = AssignedUsers::getUserServices($affId);
            }
            return   $response;
        } catch (\Exception $err) {

            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    //get assinged provider according to service selected
    public function  getProvidersByserviceId(Request $request)
    {
        try {
            $providerArr = [];
            $providerArr = AssignedUsers::getAssignedProviders(1, decryptGdprData($request->user_id), $request->service_id);

            return $providerArr;
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /*get subaffiliates with retention status and provider resale status a/c to 
    providerid, service id, and its aff*/
    public function getProviderStatusSubaff(Request $request)
    {
        try {
            $responseArr =
                [];
            $providerArr =
                AssignedUsers::getProviderSubaff($request);
            $responseArr['edit_providerLink'] = $providerArr['edit_providerLink'];

            if (isset($providerArr['resale_status']['getPermissions'][0])) {
                $responseArr['resale_status'] = $providerArr['resale_status']['getPermissions'][0];
            }

            $responseArr['retention_data'] = $providerArr['retention_data'];
            if (isset($providerArr['sub_affilaites'])) {
                $responseArr['sub_affilaites'] = $providerArr['sub_affilaites'];
            }
            return $responseArr;
        } catch (\Exception $err) {

            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /*save retension a/c to service and provider id*/
    public function  SaveRetention(RetentionRequest $request)
    {
        try {

            $response =
                AssignedUsers::saveRetenstiondata($request);

            if ($response['status'] == true) {
                return response()->json(['status' => $response['status'], 'message' => $response['message']]);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
}
