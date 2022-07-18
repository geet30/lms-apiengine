<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Providers\{StateRequest};
use App\Models\{Providers};

class StatesController extends Controller
{   
    /**
     * Assign States to providers
     *
     */
    public function index(StateRequest $request){
        try {
            return Providers::assginStatesToProviders($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Change State Status
     *
     */
    public function changeStatus(Request $request){
        try {
            return Providers::updateStateStatus($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Retention Alloweded?
     *
     */
    public function retentionAlloweded(Request $request){
        try {
            return Providers::updateRetention($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }    

    /**
     * Delete state
     *
     */
    public function deleteState(Request $request){
        try{
            return Providers::deleteState($request);
        }catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

}
