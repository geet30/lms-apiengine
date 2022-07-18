<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Affiliates\ManageApiKey;
use App\Models\{Affiliate, AffiliateKeys,UserService};
use Config;

class ApikeyController extends Controller
{
    protected $apiKeys;
    public function __construct()
    {
        $this->apiKeys = new AffiliateKeys();
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index($id, Request $request)
    {
        $headArr = [];
        $headArr['title'] = 'Affiliates';
        $headArr['requestFrom'] = "";
        $headArr['redirect_link']
            = URL('/affiliates/list/');
        $headArr['settingTitle'] = "Settings";
        $userType = '';
        if ($request->segment(2) == 'sub-affiliates') {
            $userType = 4;
            $headArr['title'] = 'Sub Affiliates';
            $headArr['requestFrom'] = 'sub-affiliates';
            $headArr['settingTitle'] = "Settings";
            $userId
                = $this->apiKeys::getAffiliateIdByParentId(decryptGdprData($id));
            $headArr['redirect_link']
                =
                URL('affiliates/sub-affiliates/' . encryptGdprData($userId));
        }

        $affiliate = Affiliate::select('id','user_id','life_support_content','life_support_status')
            ->where('user_id', decryptGdprData($id))
            ->first();

        $verticals = $this->apiKeys::getUserServices(decryptGdprData($id), '', $userType);
        $activeVerticals = array_values(collect($verticals)->where('status',1)->toArray());
        $allStatus = config::get('planData.statusList');
        $activeStatus = 1;

        if ($request->has('filter_status'))
            $activeStatus = $request->filter_status;
        $records = $this->apiKeys->getKeylist($id, $request);
        $records['address'] = $records->user_address;
        $records['logo'] = $records->affiliate->logo;
        if ($request->isMethod('post')) {

            return response()->json(['records' => $records, 'requestFrom' => $request->requestFrom], 200);
        }
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();

       $energyServiceStatus=UserService::where(['user_id'=>decryptGdprData($id),'user_type' => 1,'status' =>1,'service_id' => 1])->get();
       
        return view('pages.affiliates.affsettings.list', compact('records', 'headArr', 'allStatus', 'activeStatus', 'verticals', 'affiliate','userPermissions','appPermissions','activeVerticals','energyServiceStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *  store key a/c to user_id
     * @param  \App\Http\Requests\Affiliates\ManageApiKey  $request
     * @return \Illuminate\Http\JsonResponse.
     */
    public function store(ManageApiKey $request)
    {
        try {
            $response = $this->apiKeys->storeApiKey($request);
            if ($response['status'] == true) {
                return response()->json(['status' => $response['status'], 'message' => $response['message']]);
            }
            return response()->json(['status' => $response['status'], 'message' => $response['message']]);
            // return $this->send_response($response, $http_status);
        } catch (\Exception $err) {
            $result = [
                'exception_message' => $err->getMessage()
            ];
            $status = 400;

            return response()->json($result, $status);
        }
    }
    /* chnage  key status a/c to user_id*/

    public function changeAffstatusKey(Request $request)
    {
        try {
            $response = $this->apiKeys->changeStatus($request->all());
            if ($response['status'] == true) {
                return response()->json(['status' => $response['status'], 'message' => $response['message']]);
            }
            return response()->json(['status' => $response['status'], 'message' => $response['message']]);
        } catch (\Exception $err) {
            $result = [
                'exception_message' => $err->getMessage()
            ];
            $status = 400;

            return response()->json($result, $status);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy($id)
    {
        //
    }*/
}
