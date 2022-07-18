<?php

namespace App\Repositories\MobileSettings\contract;

use App\Models\{Contract};


trait BasicCrudMethods
{


    /**
     * create or update edit contract
     */
    public function storeContract($requestArr)
    {
        $editID = '';
        if ($requestArr->hidden_edit_id) {
            $editID = $requestArr->hidden_edit_id; //table id
        }
        $recordArr = [
            'contract_name' => $requestArr->contract_name,
            'validity' => $requestArr->validity,
            'description' => $requestArr->description,

        ];


        $result = self::updateOrCreate(['id' => $editID], $recordArr);


        return ['status' => true, 'message' => trans('mobile_settings.success_message'), 'edit_id' => $result['id']];
    }

    public function getMobileContract($request)
    {
        $contractRecord = [];
        $contractRecord['contract'] = self::orderBy('created_at', 'desc')->Paginate(20);
        return $contractRecord;
    }


    public static function deleteContract($id)
    {
        Contract::destroy($id);
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
            return ['status' => true, 'message' => trans('mobile_settings.contractPage.contract_status_success')];
        }
        return ['status' => false, 'message' => trans('mobile_settings.contractPage.contract_error')];
    }


}
