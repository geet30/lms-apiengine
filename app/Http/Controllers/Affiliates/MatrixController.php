<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Requests\Affiliates\Idmatrix;
use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\User;
use App\Repositories\Common\CommonRepository;
use App\Models\Idmatrixs;
use Illuminate\Support\Facades\DB;

class MatrixController extends Controller
{
    use  CommonRepository;
    /*get matrix according to user_id**/
    public function getIdMatrix($userId)
    {
        $userId = decryptGdprData($userId);
        $services = DB::table('user_services')->select('services.id','services.service_title')
            ->join('services', 'services.id', 'user_services.service_id')
            ->where('services.status', 1)
            ->where('user_services.status', 1)
            ->where('user_services.user_id', $userId)
            ->get()
            ->toArray();
        $idMatrixArr['identification_options'] = CommonRepository::getIdentificationArr();
        $idMatrixArr['id_matrix'] = Idmatrixs::getMatrixById($userId);
        $idMatrixArr['services'] = $services;
        return $idMatrixArr;
    }
    /*save matrix according to user_id**/
    public function saveIdMatrix(Idmatrix $request)
    {
        try {
            $response = Idmatrixs::saveAffMatrix($request);
            return response()->json(['status' => $response['status'], 'message' => $response['message'], 'edit_id' => $response['edit_id']]);
        } catch (\Exception $err) {

            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
}
