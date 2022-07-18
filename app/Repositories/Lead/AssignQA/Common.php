<?php

namespace App\Repositories\Lead\AssignQA;

trait Common
{
    public static function assginQaTOsale($request)
    {
        try {
            $authUser = auth()->user();
            $refNo = $request->ref_no;
            $ip = $_SERVER['REMOTE_ADDR'];
            $qaOldData = self::select('lead_id', 'user_id', 'type')->whereIn('lead_id', $request->sales_id)->get()->toArray();
            $oldQas = array_filter($qaOldData, function ($key) {
                if ($key['type'] == 1) {
                    return true;
                }
            });
            $oldCollb = array_filter($qaOldData, function ($key) {
                if ($key['type'] == 2) {
                    return true;
                }
            });
            self::whereIn('lead_id', $request->sales_id)->delete();
            $assginedQa = $request->qas;
            $collaboratorQa = $request->collaborator;
            $allLogsData = [];
            $newAssgin = [];
            $unassgined = [];
            $logData = [];
            $arr = [];
            $arrcb = [];
            $allDataAssginQa = [];
            if (!empty($assginedQa)) {
                $unassginLog = [];
                foreach ($assginedQa as $key => $qa) {
                    if (isset($qa[0])) {
                        foreach ($oldQas as $oldQa) {
                            if ($oldQa['lead_id'] == $key) {
                                $arr[] = $oldQa['user_id'];
                            }
                        }
                        $newAssgin = array_diff($qa, $arr);
                        $unassgined = array_diff($arr, $qa);
                        if (!empty($unassgined)) {
                            foreach ($unassgined as $un) {

                                $ref = isset($refNo[$key]) ? $refNo[$key] : null;
                                $unassginLog['lead_id'] = $key;
                                $unassginLog['reference_no'] = $ref;
                                $unassginLog['ip'] = $ip;
                                $unassginLog['action'] = 3;
                                $unassginLog['assign_user_id'] = $un;
                                $unassginLog['action_performed_by'] = $authUser->id;
                                $unassginLog['created_at'] = now();
                                if (count($unassginLog))
                                    $allLogsData[] = $unassginLog;
                            }
                            $unassgined = '';
                        }
                        $assginedQaSale[] = $key;
                        foreach ($qa as  $value) {
                            $qaData['lead_id'] = $key;
                            $qaData['user_id'] = $value;
                            $qaData['type'] = "1";
                            $qaData['assgined_by'] = $authUser->id;
                            $qaData['is_locked'] = 0;
                            $qaData['created_at'] = now();
                            $qaData['updated_at'] = now();

                            if (in_array($value, $newAssgin)) {
                                $ref = isset($refNo[$key]) ? $refNo[$key] : null;

                                $logData['lead_id'] = $key;
                                $logData['reference_no'] = $ref;
                                $logData['ip'] = $ip;
                                $logData['action'] = 1;
                                $logData['assign_user_id'] = $value;
                                $logData['action_performed_by'] = $authUser->id;
                                $logData['created_at'] = now();
                            }
                            $matchRecord['lead_id'] = $key;
                            $matchRecord['user_id'] = $value;
                            $allDataAssginQa[] = $qaData;
                            $allmatchRecord[] = $matchRecord;
                            if (count($logData))
                                $allLogsData[] = $logData;
                        }
                        $newAssgin = '';
                    }
                }
                if (count($allDataAssginQa))
                    self::insert($allDataAssginQa);
            }
            if (!empty($collaboratorQa)) {
                $unassginLog = [];
                foreach ($collaboratorQa as $key => $qa) {
                    if (isset($qa[0])) {
                        $assginedSaleCollab[] = $key;
                        foreach ($oldCollb as $collb) {
                            if ($collb['lead_id'] == $key) {
                                $arrcb[] = $collb['user_id'];
                            }
                        }
                        $newAssgincol = array_diff($qa, $arrcb);
                        $unassginedCol = array_diff($arrcb, $qa);

                        if (!empty($unassginedCol)) {

                            foreach ($unassginedCol as $un) {
                                $ref = isset($refNo[$key]) ? $refNo[$key] : null;
                                $unassginLog['lead_id'] = $key;
                                $unassginLog['reference_no'] = $ref;
                                $unassginLog['ip'] = $ip;
                                $unassginLog['action'] = 4;
                                $unassginLog['assign_user_id'] = $un;
                                $unassginLog['action_performed_by'] = $authUser->id;
                                $unassginLog['created_at'] = now();
                                if (count($unassginLog))
                                    $allLogsData[] = $unassginLog;
                            }
                        }
                        foreach ($qa as  $value) {
                            if (!empty($value)) {
                                $qaData['lead_id'] = $key;
                                $qaData['user_id'] = $value;
                                $qaData['type'] = "2";
                                $qaData['assgined_by'] = $authUser->id;
                                $qaData['is_locked'] = 0;
                                $qaData['created_at'] = now();
                                $qaData['updated_at'] = now();
                                $allDataCollaboratorQa[] = $qaData;
                                if (in_array($value, $newAssgincol)) {
                                    $ref = isset($refNo[$key]) ? $refNo[$key] : null;
                                    $logData['lead_id'] = $key;
                                    $logData['reference_no'] = $ref;
                                    $logData['ip'] = $ip;
                                    $logData['action'] = 2;
                                    $logData['assign_user_id'] = $value;
                                    $logData['action_performed_by'] = $authUser->id;
                                    $logData['created_at'] = now();
                                }
                                $allDataAssginQa[] = $qaData;
                                if (count($logData))
                                    $allLogsData[] = $logData;
                            }
                        }
                    }
                }
                if (count($allDataAssginQa))
                    self::insert($allDataAssginQa);
            }
            $unique = array_map("unserialize", array_unique(array_map("serialize", $allLogsData)));
            if (count($unique))
                \DB::connection('sale_logs')->table('sales_qa_logs')->insert($unique);
            return response()->json(['message' => "QA/collaborator assigned successfully", 'unique' => $unique, 'allDataAssginQa' => $allDataAssginQa,'allLogsData'=>$allLogsData], 200);
        } catch (\Exception $e) {

            $result = [
                'exception_message_front' => $e->getMessage(),
                'exception_message_line' => $e->getLine(),
                'exception_message_file' => $e->getFile(),
                'success' => 'false'
            ];
            return response()->json($result, 400);
        }
    }
}
