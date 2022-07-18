<?php

namespace App\Repositories\Affiliate;

use DB;


trait MatrixRepo
{
    public static function getMatrixById($userId)
    {
        return DB::table('affiliate_idmatrix')->where('status', 1)->select('id', 'matrix_content_key_enable', 'matrix_content', 'medicare_card', 'foreign_passport', 'driver_license', 'australian_passport', 'id_matrix_enable','secondary_identification_allow', 'services')->where('user_id', '=', $userId)->first();
    }
    public static function saveAffMatrix($request)
    {
        if ($request) {
            $requiredArray =   ['medicare_card', 'foreign_passport', 'driver_license', 'australian_passport'];
            foreach ($requiredArray as $field) {
                if (!$request->exists($field) && !$request->{$field}) {
                    $request[$field] = 0;
                }
            }

            $userId = decryptGdprData($request->user_id);

            $editID = '';
            $msg = trans('affiliates.matrix.matrix_success_created');
            if (isset($request->edit_id) && $request->edit_id != "") {
                $editID = $request->edit_id; //table id
                $msg = trans('affiliates.matrix.matrix_success_updated');
            }

            $services = ($request->has('services') && count($request->services)) ? implode(',', $request->services) : null;

            $recordArr = [
                'user_id' => $userId,
                'foreign_passport' => $request['foreign_passport'],
                'medicare_card' => $request['medicare_card'],
                'driver_license' => $request['driver_license'],
                'australian_passport' => $request['australian_passport'],
                'matrix_content_key_enable' => $request['matrix_content_key_enable'],
                'matrix_content' => $request['matrix_content'],
                'secondary_identification_allow' => $request['secondary_identification_allow'],
                'id_matrix_enable' => $request['id_matrix_enable'],
                'services' => $services,
                'status' => 1,
            ];

            $matrix = self::updateOrCreate(['id' => $editID], $recordArr);

            return ['status' => true, 'message' => $msg, 'edit_id' => $matrix['id']];
        }
    }
}
