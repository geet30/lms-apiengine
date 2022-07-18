<?php

namespace App\Repositories\Affiliate;

use App\Models\{
    User,
    AffiliateTarget
};
use Datetime, Response;

trait ManageTargets
{
    public function storeTarget($requestArr)
    {
        $editID = '';
        if ($requestArr->hidden_edit_id) {
            $editID = $requestArr->hidden_edit_id; //table id
        }
        $userId = decryptGdprData($requestArr->user_id);
        $comment = $requestArr->comment;
        $targetDate = $requestArr->target_date;
        $datearr = explode('-', $targetDate);
        $status = 0;
        $recordArr = [
            'user_id' => $userId,
            'target_value' => $requestArr->target_value,
            'sales' => 0,
            'comment' => $comment,
            'status' => $status,
            'target_month' => $datearr[0],
            'target_year' => $datearr[1]
        ];
        $result = self::updateOrCreate(['id' => $editID], $recordArr);
        // if affiliate target record save saved then return response.
        return ['status' => true, 'message' => trans('affiliates.target.success_message'), 'edit_id' => $result['id']];
    }
    //get target listing with and without filter
    public function getTargetlist($requestArr, $userId = null)
    {
        if (isset($userId) && $userId != "") {
            $userId = decryptGdprData($userId);
        }
        if (isset($requestArr['user_id']) && $requestArr['user_id'] != "") {
            $userId = decryptGdprData(
                $requestArr['user_id']
            );
        }
        $targetRecord = [];
        $targetRecord['userData'] = User::select('id')->with([
            'affiliate' => function ($q) {
                $q->select('id', 'user_id', 'company_name');
            }
        ])->where('status', '!=', 2)->where('id', $userId)->first();
        $affTargetRecord = self::where('user_id', $userId);
        if (isset($requestArr['sort_month'])) {
            $affTargetRecord = $affTargetRecord->where('target_month', $requestArr['sort_month']);
        }
        if (isset($requestArr['sort_year'])) {
            $affTargetRecord = $affTargetRecord->where('target_year', $requestArr['sort_year']);
        }
        if (isset($requestArr['status_sort_type'])) {
            $affTargetRecord = $affTargetRecord->where('status', $requestArr['status_sort_type']);
        }
        //get all affiliate's target dates.
        $targetRecord['target'] = $affTargetRecord->orderBy('id', 'asc')->Paginate(20);
        $targetRecord['target_dates']
            = $this->targetDates($targetRecord['target']);
        //$targetRecord['search_values'] = $searchValue;
        return $targetRecord;
    }
    public function targetExport($requestArr)
    {
        $userId = decryptGdprData($requestArr['unique_aff_id']); //encrypt affiliate id
        $affiliateTarget = AffiliateTarget::where('user_id', $userId);
        if ($requestArr['sort_month'] != "") {
            $affiliateTarget->where('target_month', $requestArr['sort_month']);
        }
        if (!empty($requestArr['sort_year'])) {
            $affiliateTarget->where('target_year', $requestArr['sort_year']);
        }
        if ($requestArr['status_sort_type']) {
            $affiliateTarget->where('status', $requestArr['status_sort_type']);
        }
        //get all data of affiliate target based on requested filtered data.
        $affiliateTarget = $affiliateTarget->get();
        if (count($affiliateTarget) > 0) {
            $order =  array('Sr.No', 'Target Value', 'Target Month', 'Target Year', 'Sales', 'Target Status');
            $table = $this->getTableData($affiliateTarget);
            $tempDirString = base_path() . '/uploads/targets/';
            //creadting the directory of adding csv
            if (!file_exists($tempDirString)) {
                mkdir($tempDirString, 0777, true); //create directory
            }
            $filename = $tempDirString . "targets.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, $order);
            foreach ($table as $row) {
                fputcsv($handle, array($row['s_no'], $row['target_value'], $row['target_month'], $row['target_year'], $row['sales'], $row['status']));
            }
            //close file after write content.
            fclose($handle);
            //file content type
            $headers = array('Content-Type' => 'text/csv');
            //return file for download
            return Response::download($filename, 'targets.csv', $headers);
        }
    }
    function targetDates($targetRecord)
    {
        $affiliate_target_dates = [];
        foreach ($targetRecord as  $target) {
            $affiliate_target_dates[] = $target['target_year'] . '-' . $target['target_month'];
        }
        return $affiliate_target_dates;
    }
    function deleteTarget($id)
    {
        $affiliate_target = self::find($id);
        if ($affiliate_target) {
            if ($affiliate_target->delete()) {
                $result = [
                    'status' => true,
                    'message' => trans('affiliates.target.delete_success')
                ];
            } else {
                // if record not saved then return error.
                $result = [
                    'status' => false,
                    'message' => trans('affiliates.target.delete_error')
                ];
            }
        } else {
            // if record not found then return error.
            $result = [
                'status' => false,
                'message' => trans('affiliates.target.infomation_match_error')
            ];
        }

        return $result;
    }
    function  getTableData($affiliateTarget)
    {
        $table = [];
        $status = "";
        $i = 1;
        foreach ($affiliateTarget as $row) {
            if ($row->status == 0) {
                $status = 'In Progess';
            }
            if ($row->status == 1) {
                $status = 'Achieved';
            }
            if ($row->status == 2) {
                $status = 'Not Achieved';
            }
            $dateObj   = DateTime::createFromFormat('!m', $row->target_month);
            $table[$i]['s_no'] = $i;
            $table[$i]['target_value'] = $row->target_value;
            $table[$i]['target_month'] = $dateObj->format('F');
            $table[$i]['target_year'] = $row->target_year;
            $table[$i]['sales'] = $row->sales;
            $table[$i]['status'] = $status;
            $i++;
        }
        return $table;
    }
}
