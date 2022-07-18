<?php

namespace App\Repositories\Settings;

use Illuminate\Support\Facades\DB;

trait LifeSupportEquipments
{
    /**
     * Author: Prakash Poudel(12-April-2022)
     * index
     */
    public static function index()
    {
        try {
            return view('pages.settings.life-support-equipments.list');
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     * index
     */
    public static function getLifeSupportData()
    {
        try {
            $life_support = DB::table('life_support_equipments')->orderBy('id', 'desc')->get();
            $master_life_support_content = DB::table('settings')->where(['type' => 'master_life_support_content', 'key' => 'master_life_support_content'])->first();
            return response()->json(['status' => 200, 'life_support' => $life_support, 'master_life_support_content' => $master_life_support_content]);
        } catch (\Exception $err) {
            return response()->json(['status' => 500, 'message' => $err->getMessage()], 500);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     * index
     */
    public static function addUpdate($request, $life_support_id)
    {
        $error_message = 'Something went wrong';
        try {
            $data = [
                'id' => $life_support_id,
                'title' => $request->title,
                'energy_type' => $request->energy_type,
                'status' => $request->status,
                'is_deleted' => 0,
            ];

            if (isset($life_support_id)) {
                $data['updated_at'] = now();
                $message = 'Life support equipment updated successfully.';
                $error_message = 'Unable to update life support equipment.';
            } else {
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $message = 'Life support equipment added successfully.';
                $error_message = 'Unable to add life support equipment.';
            }

            DB::table('life_support_equipments')->upsert($data, 'id');

            return response()->json(['status' => '1', 'message' => $message]);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $error_message, 'exception' => $err->getMessage()], 500);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public static function deleteLifeSupportEquipment($life_support_id)
    {
        try {
            DB::table('life_support_equipments')->whereId($life_support_id)->delete();
            return response()->json(['status' => '1', 'message' => 'Life support equipment deleted successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => 'Unable to delete life support equipment.', 'exception' => $err->getMessage()], 500);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public static function changeLifeSupportEquipmentStatus($life_support_id)
    {
        try {
            $status = DB::table('life_support_equipments')->whereId($life_support_id)->pluck('status');
            DB::table('life_support_equipments')->whereId($life_support_id)->update(['status' => !$status[0]]);
            return response()->json(['status' => '1', 'message' => 'Status updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => 'Unable to update status.', 'exception' => $err->getMessage()], 500);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public static function postMasterLifeSupportContent($request)
    {
        try {
            if (DB::table('settings')->where('key', 'master_life_support_content')->count() == 0) {
                DB::table('settings')->insert([
                    [
                        'key' => 'master_life_support_content',
                        'value' => $request->content,
                        'user_id' => null,
                        'name' => 'Master Life Support Content',
                        'status' => 1,
                        'type' => 'master_life_support_content',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            } else {
                DB::table('settings')->where(['type' => 'master_life_support_content', 'key' => 'master_life_support_content'])->update(['value' => $request->content]);
            }
            return response()->json(['status' => '1', 'message' => 'Content updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => 'Unable to update content.', 'exception' => $err->getMessage()], 500);
        }
    }
}
