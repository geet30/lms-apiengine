<?php

namespace App\Repositories\Affiliate;

use App\Models\{
    User,
    Affiliate,
};

trait ManageApiKeys
{
    public function storeApiKey($requestArr)
    {
       
        if ($requestArr) {
            $userId = decryptGdprData($requestArr->user_id);
            $id = '';
            $msg = trans('affiliates.api_key_created');
            if (isset($requestArr->id) && $requestArr->id != "") {
                $id = $requestArr->id; //table id
                $msg = trans('affiliates.api_key_updated');
            }
            $randomString = randomAffiliateKey();
            $randomString = encryptGdprData($randomString);
            //for sub-affiliate
            if (isset($requestArr->request_from)) {
                if (!isset($requestArr->create_api_key)) {
                    $randomString = "";
                }
            }



            if($requestArr->has('id') && $requestArr->id != ''){
                $recordArr = [
                    'user_id' => $userId,
                    'name' => encryptGdprData($requestArr->name),
                    'page_url' => $requestArr->page_url,
                    'origin_url' => $requestArr->origin_url
                ];
            }else{
                $recordArr = [
                    'user_id' => $userId,
                    'name' => encryptGdprData($requestArr->name),
                    'api_key' => $randomString,
                    'page_url' => $requestArr->page_url,
                    'origin_url' => $requestArr->origin_url,
                    'rc_code' => mt_rand(100, 100000),
                    'status' => !empty($requestArr->status) ? $requestArr->status : 1
                ];
            }

            self::updateOrCreate(['id' => $id], $recordArr);

            return ['status' => true, 'message' => $msg];
        }
    }
    public function getKeylist($userId, $request)
    {
        $status = 1;
        if ($request->has('filter_status')) {
            $status = $request->filter_status;
        }
        if ($request->has('filter_status') && ($request->filter_status == 'all')) {
            $records =  User::select('first_name', 'last_name', 'email', 'phone', 'id', 'status')->with([
                'ApiKeys' => function ($query) {
                    $query->where('is_deleted', '=', 0)
                        ->orderBy('id', 'asc')->Paginate(20);
                },
                'affiliate' => function ($q) {
                    $q->select('id', 'user_id', 'referral_code_title', 'referral_code_url', 'parent_id', 'referal_code', 'logo', 'company_name');
                }
            ])->where('id', decryptGdprData($userId))->first();
            return $records;
        }
        $records = User::select('first_name', 'last_name', 'email', 'phone', 'id', 'status')->with([
            'ApiKeys' => function ($query) use ($status) {
                $query->where('is_deleted', '=', 0)
                    ->where('status', $status)
                    ->orderBy('id', 'asc')->Paginate(20);
            },
            'affiliate' => function ($q) {
                $q->select('id', 'user_id', 'referral_code_title', 'referral_code_url', 'parent_id', 'referal_code', 'logo', 'company_name');
            }
        ])->where('id', decryptGdprData($userId))->first();

        $records['user_address'] = Affiliate::getUserAddr($userId)->address;
        //$dataa = response()->json(['apikey' => $abc]);

        return $records;
    }
    public function changeStatus($requestArr)
    {
        //if (User::find(decryptGdprData($requestArr['user_id']))->status == 1) {
        $status = Self::where('id', ($requestArr['id']))
            ->update(['status' => $requestArr['status']]);
        if ($status) {
            return ['status' => true, 'message' => trans('affiliates.affkey_status_success')];
        }
        return ['status' => false, 'message' => trans('affiliates.aff_error')];
        //}
        //return ['status' => false, 'message' => trans('affiliates.affkey_status_error')];
    }
}
