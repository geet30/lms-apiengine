<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\DiallerSetting;
use App\Http\Requests\Settings\DiallerIgnoreData\DiallerRequest;
use Illuminate\Http\Request;


class DiallerIgnoreDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return DiallerSetting::index($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DiallerRequest $request)
    {
        try {
            return DiallerSetting::create($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        try {
            return DiallerSetting::searchData($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $response = DiallerSetting::where('id', $request->id)->delete();
			return DiallerSetting::where('type', $request->type)->get();
		} catch (\Exception $e) {
			$status = 400;
			$result = [
				'exception_message' => $e->getMessage()
			];
			return response()->json($result, $status);
		}
       
    }
}
