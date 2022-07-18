<?php

namespace App\Repositories\Reports\SalesQaReport;

use App\Models\SalesQaLog;
use App\Models\{User, SaleAssignedEnergyQa, SaleAssignedMobileQa, SaleAssignedBroadbandQa};
use AWS\CRT\HTTP\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\PseudoTypes\True_;

trait BasicCrudMethods
{
    public static function index($request)
    {
        try {
            // Getting Data:-
            $getData = SalesQaLog::orderBy('id', 'DESC')->get()->toArray();
            $getUserData = User::select('id', 'first_name')->where('status', 1)->get()->toArray();

            // QA & Collaborator Name:-
            foreach ($getData as $key => $val) {
                // QA Name:-
                $data = array_filter($getUserData, function ($a1) use ($val) {
                    if ($a1['id'] == $val['assign_user_id']) {
                        return $a1;
                    }
                });
                foreach ($data as $key1 => $value) {
                    $val['qa_name'] = decryptGdprData($value['first_name']);
                }

                // Collaborator Name:-
                $data1 = array_filter($getUserData, function ($a1) use ($val) {
                    if ($a1['id'] == $val['action_performed_by']) {
                        return $a1;
                    }
                });
                foreach ($data1 as $key1 => $value) {
                    $val['collaborator_name'] = decryptGdprData($value['first_name']);
                }

                // Format Created Date:-
                $val['created_at'] = Carbon::parse($val['created_at'])->format('d-m-Y H:i:s');

                // Set Value in $getData:-
                $getData[$key] = $val;
            }

            return $getData;
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function searchFilter($request)
    {
        try {
            // Search Filter:-
            $getUserData = User::select('id', 'first_name')->where('status', 1)->get()->toArray();
            $getData = new SalesQaLog;

            if (!empty($request->datePickerQa)) {
                $date = explode(" - ", $request->datePickerQa);
                $fromCreatedAt = date('Y-m-d', strtotime($date[0])) . " 00:00:00";
                $toCreatedAt = date('Y-m-d', strtotime($date[1])) . " 23:59:59";

                $getData =  $getData->whereBetween("created_at", [$fromCreatedAt, $toCreatedAt]);
            }
            if (isset($request->assignedQa)) {
                $getData =  $getData->whereIn('assign_user_id', $request->assignedQa);
            }
            if (isset($request->actionPerformedBy)) {
                $getData = $getData->whereIn('action_performed_by', $request->actionPerformedBy);
            }
            if (isset($request->qaAction)) {
                $getData = $getData->whereIn('action', $request->qaAction);
            }
            if (isset($request->saleId)) {
                $getData = $getData->where('lead_id', 'LIKE', '%' . $request->saleId . '%');
            }
            if (isset($request->referenceNumber)) {
                $getData = $getData->where('reference_no', 'LIKE', '%' . $request->referenceNumber . '%');
            }
            $getData = $getData->orderBy('id', 'desc')->get()->toArray();
            $finalData = [];

            foreach ($getData as $key => $val) {
                // Format Created Date:-
                $val['created_at'] = Carbon::parse($val['created_at'])->format('d-m-Y H:i:s');

                // Action Name:-
                $val['action'] = actionSalesQaLogs($val['action']);

                // QA Name:-
                $data = array_filter($getUserData, function ($a1) use ($val) {
                    if ($a1['id'] == $val['assign_user_id']) {
                        return $a1;
                    }
                });
                foreach ($data as $key1 => $value) {
                    $val['qa_name'] = decryptGdprData($value['first_name']);
                }

                // Collaborator Name:-
                $data1 = array_filter($getUserData, function ($a1) use ($val) {
                    if ($a1['id'] == $val['action_performed_by']) {
                        return $a1;
                    }
                });
                foreach ($data1 as $key1 => $value) {
                    $val['collaborator_name'] = decryptGdprData($value['first_name']);
                }

                // Set Value in $getData:-
                $getData[$key] = $val;
            }
            return $getData;
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function getList($request)
    {
        try {
            $getData = SalesQaLog::get()->toArray();
            $getUserData = User::select('id', 'first_name')->where('role', 4)->get()->toArray();

            // QA List:-
            $qaList = [];
            foreach ($getUserData as $key => $val) {
                $qaList[$key]['id'] = $val['id'];
                $qaList[$key]['name'] = decryptGdprData($val['first_name']);
            }

            return $qaList;
        } catch (\Exception $err) {
            return response()->json(['status' => '0', 'message' => $err->getMessage()], 500);
        }
    }

    public static function saveQaLogs($request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $action = '';
        $data = SaleAssignedEnergyQa::where(['lead_id' => $request->leadId, 'user_id' => $request->userId])->get();
        switch ($request->verticalId) {
            case "1":
                if ($request->isLocked == 1) {
                    SaleAssignedEnergyQa::where(['lead_id' => $request->leadId, 'user_id' => $request->userId])->update(['is_locked' => 0]);
                    $action = 6;
                }
                if ($request->isLocked == 0) {
                    SaleAssignedEnergyQa::where(['lead_id' => $request->leadId, 'user_id' => $request->userId])->update(['is_locked' => 1]);
                    $action = 5;
                }
                $salesQaData = SaleAssignedEnergyQa::where(['user_id' => $request->userId, 'type' => '1'])->get()->first();
                break;
            case "2":
                if ($request->isLocked == 1) {
                    SaleAssignedMobileQa::where(['lead_id' => $request->leadId, 'user_id' => $request->userId])->update(['is_locked' => 0]);
                    $action = 6;
                }
                if ($request->isLocked == 0) {
                    SaleAssignedMobileQa::where(['lead_id' => $request->leadId, 'user_id' => $request->userId])->update(['is_locked' => 1]);
                    $action = 5;
                }
                $salesQaData = SaleAssignedMobileQa::where(['user_id' => $request->userId, 'type' => '1'])->get()->first();

                break;
            case "3":
                if ($request->isLocked == 1) {
                    SaleAssignedBroadbandQa::where(['lead_id' => $request->leadId, 'user_id' => $request->userId])->update(['is_locked' => 0]);
                    $action = 6;
                }
                if ($request->isLocked == 0) {
                    SaleAssignedBroadbandQa::where(['lead_id' => $request->leadId, 'user_id' => $request->userId])->update(['is_locked' => 1]);
                    $action = 5;
                }
                $salesQaData = SaleAssignedBroadbandQa::where(['user_id' => $request->userId, 'type' => '1'])->get()->first();
                break;
            default:
                return "N/A";
        }
        SalesQaLog::insert(
            [
                'lead_id' => $request->leadId,
                'reference_no' => $request->referenceNo,
                'ip' => $ip,
                'action' => $action,
                'assign_user_id' => $request->userId,
                'action_performed_by' => $request->userId,
                'Comment' => $request->salesQaComment,
                'created_at' => now()
            ]
        );
        // return $salesQaData;
    }
}
