<?php

namespace App\Repositories\Settings\DiallerIgnoreList;

use App\Models\DiallerSetting;
use AWS\CRT\HTTP\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


trait BasicCrudMethods
{
    public static function index($request)
    {
        try {
            $dialler_ignore_data = DiallerSetting::orderBy('type', 'asc')->simplePaginate(15);
            $dialler_ignore_data_name = DiallerSetting::where('type', 'name')->simplePaginate(15);
            $dialler_ignore_data_email = DiallerSetting::where('type', 'email')->simplePaginate(15);
            $dialler_ignore_data_phone = DiallerSetting::where('type', 'phone')->simplePaginate(15);
            $dialler_ignore_data_domain = DiallerSetting::where('type', 'domain')->simplePaginate(15);
            $dialler_ignore_data_ip = DiallerSetting::where('type', 'ip')->simplePaginate(15);
            $dialler_ignore_data_ip_range = DiallerSetting::where('type', 'ip_range')->simplePaginate(15);
            if ($request->ajax()) {
                if ($request->type == 1) {
                    return response()->json(['status' => '1', 'data' => $dialler_ignore_data_name], 200);
                }
                if ($request->type == 2) {
                    return response()->json(['status' => '1', 'data' => $dialler_ignore_data_email], 200);
                }
                if ($request->type == 3) {
                    return response()->json(['status' => '1', 'data' => $dialler_ignore_data_phone], 200);
                }
                if ($request->type == 4) {
                    return response()->json(['status' => '1', 'data' => $dialler_ignore_data_domain], 200);
                }
                if ($request->type == 5) {
                    return response()->json(['status' => '1', 'data' => $dialler_ignore_data_ip], 200);
                }
                if ($request->type == 6) {
                    return response()->json(['status' => '1', 'data' => $dialler_ignore_data_ip_range], 200);
                }
                // return response()->json(['status' => '1', 'data' => $dialler_ignore_data], 200);
            }
            return view('pages.settings.dialler-Ignore-data.list', compact('dialler_ignore_data_name', 'dialler_ignore_data_email', 'dialler_ignore_data_phone', 'dialler_ignore_data_domain', 'dialler_ignore_data_ip', 'dialler_ignore_data_ip_range'));
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function create($request)
    {
        try {
            if ($request->type == 1) {
                $request->type = 'name';
            }
            if ($request->type == 2) {
                $request->type = 'email';
            }
            if ($request->type == 3) {
                $request->type = 'phone';
            }
            if ($request->type == 4) {
                $request->type = 'domain';
            }
            if ($request->type == 5) {
                $request->type = 'ip';
            }
            if ($request->type == 6) {
                $request->type = 'ip_range';
            }

            if ($request->comment == NULL) {
                $comment = '';
                $request->comment = $comment;
            }

            $data = [
                'type' => $request->type,
                'type_value' => $request->content_name,
                'comment' => $request->comment,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // DB::table('dialler_settings')->insert([$data]);
            // dd($request->data_id);
            // $data = [
            //     'type' => 'name',
            //     'type_value' => 'TESTING NAME',
            //     'comment' => "TESTING COMMENTS",
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ];
            DiallerSetting::updateOrCreate(['id' => $request->data_id], $data);

            $data = DiallerSetting::where('type', $request->type)->get();
            return $data;
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function searchData($request)
    {
        try {
            if($request->type == 1){
                $type = 'name';
            }
            if($request->type == 2){
                $type= 'email';
            }
            if($request->type == 3){
                $type= 'phone';
            }
            if($request->type == 4){
                $type= 'domain';
            }
            if($request->type == 5){
                $type= 'ip';
            }
            if($request->type == 6){
                $type= 'ip_range';
            }
            $dialler_ignore_data = DiallerSetting::where('type', $type)->where('type_value', 'like','%'.$request->name.'%')->get();
            return $dialler_ignore_data;
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }
}
