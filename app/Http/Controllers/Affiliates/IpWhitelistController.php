<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Affiliates\{WhiteListIpRequest};
use App\Models\{
    Userip
};

class IpWhitelistController extends Controller
{

    public function index(Request $request){
        try {
            $result = Userip::getAssignedIps($request);
            return response()->json(['status' => 200, 'result' => $result]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


    public function assignWhitelistIp(WhiteListIpRequest $request)
    {
        try {
            Userip::assginWhiteListIp($request);
            return response()->json(['status' => 200, 'message' => trans('affiliates.ipsuccess')]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


    public function deleteWhiteListIp(Request $request)
    {
        try {
            Userip::deleteIpById($request);
            return response()->json(['status' => 200, 'message' => trans('affiliates.delete')]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    
}
