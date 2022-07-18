<?php

namespace App\Repositories\MobileSettings\storage;

use App\Models\{InternalStorage, Variant};


trait BasicCrudMethods
{


    /**
     * create or update edit storage
     */
    public function storeStorage($requestArr)
    {
        $editID = '';
        if ($requestArr->hidden_edit_id) {
            $editID = $requestArr->hidden_edit_id; //table id
        }
        $recordArr = [
            'value' => $requestArr->value,
            'unit' => $requestArr->unit,
            'description' => $requestArr->description,

        ];


        $result = self::updateOrCreate(['id' => $editID], $recordArr);


        return ['status' => true, 'message' => trans('mobile_settings.success_message'), 'edit_id' => $result['id']];
    }

    public function getMobileStorage($request)
    {
        $storageRecord = [];
        $storageRecord['storage'] = self::orderBy('created_at', 'desc')->Paginate(20);
        return $storageRecord;
    }


    public static function deleteStorage($id)
    {
        $found = Variant::where('capacity_id', $id)->count();

        if ($found > 0) {
            $result = [
                'status' => false,
                'message' => trans('mobile_Settings.delete_error'),
            ];
        } else {
            InternalStorage::destroy($id);
            $result = [
                'status' => true,
                'message' => trans('mobile_Settings.delete_success'),
            ];
        }
        return $result;

    }

    public function changeStatus($requestArr)
    {

        $status = Self::where('id', ($requestArr['id']))
            ->update(['status' => $requestArr['status']]);
        if ($status) {
            return ['status' => true, 'message' => trans('mobile_settings.storagePage.storage_status_success')];
        }
        return ['status' => false, 'message' => trans('mobile_settings.storagePage.storage_error')];
    }


}
