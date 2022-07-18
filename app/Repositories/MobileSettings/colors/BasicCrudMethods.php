<?php

namespace App\Repositories\MobileSettings\colors;

use App\Models\{Color};


trait BasicCrudMethods
{


    /**
     * create or update edit color
     */
    public function storeColors($requestArr)
    {
        $editID = '';
        if ($requestArr->hidden_edit_id) {
            $editID = $requestArr->hidden_edit_id; //table id
        }
        $recordArr = [
            'title' => $requestArr->title,
            'hexacode' => $requestArr->hexacode,
            'description' => $requestArr->description,

        ];


        $result = self::updateOrCreate(['id' => $editID], $recordArr);


        return ['status' => true, 'message' => trans('mobile_settings.success_message'), 'edit_id' => $result['id']];
    }

    public function getMobileColors($request)
    {
        $colorsRecord = [];
        $colorsRecord['colors'] = self::orderBy('created_at', 'desc')->Paginate(20);
        return $colorsRecord;
    }


    public static function deleteColors($id)
    {
        Color::destroy($id);
        $result = [
            'status' => true,
            'message' => trans('mobile_Settings.delete_success'),
        ];
        return $result;

    }

    public function changeStatus($requestArr)
    {

        $status = Self::where('id', ($requestArr['id']))
            ->update(['status' => $requestArr['status']]);
        if ($status) {
            return ['status' => true, 'message' => trans('mobile_settings.colorPage.color_status_success')];
        }
        return ['status' => false, 'message' => trans('mobile_settings.colorPage.color_error')];
    }


}
