<?php

namespace App\Repositories\MobileSettings\Brands;

use App\Models\{Brand, Handset};


trait BasicCrudMethods
{

    /**
     * create or update edit brands
     */
    public function storeBrand($requestArr)
    {
        $editID = '';
        if ($requestArr->hidden_edit_id) {
            $editID = $requestArr->hidden_edit_id; //table id
        }
        $recordArr = [
            'title' => $requestArr->title,
            'os_name' => $requestArr->os_name,

        ];


        $result = self::updateOrCreate(['id' => $editID], $recordArr);


        return ['status' => true, 'message' => trans('mobile_settings.success_message'), 'edit_id' => $result['id']];
    }

    public static function getMobileBrands($request)
    {
        $brandRecord = [];
        $brandRecord['brand'] = self::orderBy('created_at', 'desc')->Paginate(20);
        return $brandRecord;
    }


    public static function deleteBrand($id)
    {
        // $id = encryptGdprData($id);
        // delete cases.
        // 1. check if brand assigned to some handsets or not.
        $found = Handset::where('brand_id', $id)->count();
        if ($found > 0) {
            $result = [
                'status' => false,
                'message' => trans('mobile_settings.delete_error'),
            ];
        } else {
            Brand::destroy($id);
            $result = [
                'status' => true,
                'message' => trans('mobile_settings.delete_success'),
            ];

        }
        return $result;

    }

    public function changeStatus($requestArr)
    {
        //if (User::find(decryptGdprData($requestArr['user_id']))->status == 1) {
        $status = Self::where('id', ($requestArr['id']))
            ->update(['status' => $requestArr['status']]);
        if ($status) {
            return ['status' => true, 'message' => trans('mobile_settings.brandPage.brand_status_success')];
        }
        return ['status' => false, 'message' => trans('mobile_settings.brandPage.brand_error')];
    }


}
