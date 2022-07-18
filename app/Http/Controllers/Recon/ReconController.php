<?php

namespace App\Http\Controllers\Recon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Recon\{ReconRequest,ReconNotificationRequest};
use App\Models\{AffiliateRecon};
class ReconController extends Controller
{
    /**
     * Recon View
     *
     */
    public function index(Request $request){
        try {
            $result = AffiliateRecon::getReconAffiliates($request);
            $masterpermissions =   AffiliateRecon::getMasterReconPermissions();
            $affiliates = AffiliateRecon::getAffiliates();
            $template = AffiliateRecon::getReconTemplate();
            if ($request->isMethod('post')) {
                return response()->json(['affiliates' => $result], 200);
            }
            return view('pages.recon.list',compact('result','masterpermissions','affiliates','template'));
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * Return sub affiliates
     *
     */
    public function getSubaffiliates(Request $request){
        try{
            $subaffiliates = AffiliateRecon::getAffiliates($request->id);
            return response()->json(['status' => 200, 'result' => $subaffiliates]);
        }
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Recon Permission
     *
     */
    public function addReonPermission(ReconRequest $request){
        try{
            return AffiliateRecon::store($request);
        }catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Update Recon Template Status
     *
     */
    public function manageRecon(ReconNotificationRequest $request){
        try{
            return AffiliateRecon::updateTemplate($request);
        }catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


}
