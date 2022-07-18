<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Affiliates\{AffiliateRequest, PasswordResetRequest, Vertical, AffiliateParametersRequest,AffiliatePlanTypeRequest};
use App\Models\{Affiliate, AffiliateParamter, UserService,AffiliateParameters};
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Hash;

class AffiliateController extends Controller
{

    //Display a listing of Affiliates
    public function index(Request $request, $affiliateId = null)
    {   
        $info = 'sub-affiliates';
        $affId =  $affiliateId;
        $condtion = [];

        $affId = Affiliate::getAffiliateIdByUserId(decryptGdprData($affiliateId));
        if (!$affiliateId) {
            $info = 'affiliates';
            $affId = 0;
        }

        $condtion['parent_id'] = $affId;

        if ($request->isMethod('post')) {
            $request->merge(['email' => encryptGdprData($request->email)]);
            if ($request->has('subaffiliates')) {
                $affId = Affiliate::getAffiliateIdByUserId(decryptGdprData($request->subaffiliates));
                $condtion['parent_id'] = $affId;
            }

            if (isset($request->status)) {
                $condtion['status'] = $request->status;
            }

            if (isset($request->company_name)) {
                $condtion['company_name'] = $request->company_name;
            }

            $affiliateuser = Affiliate::getFilters($condtion, ['*'], ['user' => ['id', 'first_name', 'last_name', 'email', 'phone']], true, true);

            $getData = Affiliate::modifyResponse($affiliateuser, $info);
            return response()->json(['affiliates' => $getData], 200);
        }

        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        $affiliateuser = Affiliate::getFilters($condtion, ['*'], ['user' => ['id', 'first_name', 'last_name', 'email', 'phone']], false, false);
        return view('pages.affiliates.list', compact('info', 'affId', 'affiliateuser','userPermissions','appPermissions'));
    }

    public function filters(Request $request)
    {
        try {
            $request->merge(['email' => encryptGdprData($request->email)]);
            $condtion = [
                'parent_id' => 0
            ];
            if (isset($request->status)) {
                $condtion['status'] = $request->status;
            }
            if (isset($request->company_name)) {
                $condtion['company_name'] = encryptGdprData($request->company_name);
            }

            return Affiliate::getFilters($condtion, ['*'], ['user' => ['id', 'first_name', 'last_name', 'email', 'phone']], true, true);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getCreateUpdate(
        $affId = null
    ) {
        $type = request()->segment(2);
        $opr = request()->segment(3);
        $userId = '';
        if ($type == 'sub-affiliates') {
            $userId = Affiliate::getAffiliateIdById(decryptGdprData($affId));
            $userId = encryptGdprData($userId);
        }
        $services = [];
        $verticals = [];
        return view('pages.affiliates.create_update.index', compact('affId', 'type', 'opr', 'userId', 'services', 'verticals'));
    }


    //Save Affiliates and SubAffiliates
    public function store(AffiliateRequest $request, PasswordBroker $broker)
    {
        try {
            return Affiliate::insertAffiliate($request, $broker);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function show($affId = null)
    {
        $type = request()->segment(2);
        $opr = request()->segment(3);
        $userId = '';
        $planType='';
        if ($type == 'sub-affiliates') {
            $userId = Affiliate::getAffiliateIdByParentId(decryptGdprData($affId));
            $userId = encryptGdprData($userId);

            $verticals = Affiliate::getVerticals(decryptGdprData($affId));
            $checkservices = [];
            foreach ($verticals as $key) {
                $checkservices[] = $key->service_id;
            }

            $assignedServices = Affiliate::getUserServices(decryptGdprData($userId), $checkservices);
            $services = $assignedServices;

            $affiliateuser = Affiliate::getFilters(['user_id' => decryptGdprData($affId)], ['*'], ['user' => ['id', 'first_name', 'last_name', 'email', 'phone'], 'getaffiliateservices' => ['id', 'user_id', 'service_id'], 'getunsubscribesources' => ['id', 'user_id', 'unsubscribe_source'], 'affiliateunsubscribesource' => ['user_id', 'unsubscribe_source', 'status'], 'getuseradress' => ['user_id', 'address'], 'getthirdpartyapi' => ['user_id', 'api_key']], false, false);
            return view('pages.affiliates.create_update.index', compact('affId', 'type', 'opr', 'services', 'affiliateuser', 'userId', 'verticals'));
        }
        $energyServiceStatus=UserService::where(['user_id'=>decryptGdprData($affId),'user_type' => 1,'status' =>1,'service_id' => 1])->get();
       
        $assignedServices = Affiliate::getVerticalAssignedServices(decryptGdprData($affId));
        $services = Affiliate::getServices($assignedServices);
        $verticals = Affiliate::getVerticals(decryptGdprData($affId));
       
        $planType=AffiliateParameters::select('parameter_group','key_local_id','value')->where(['user_id' => decryptGdprData($affId) ,'service_id' => 2 ,'parameter_group' => 2])->get()->toArray();

        $connectionType=AffiliateParameters::select('parameter_group','key_local_id','value')->where(['user_id' => decryptGdprData($affId) ,'service_id' => 2 ,'parameter_group' => 4])->get()->toArray();

        $leadPopupInfo=AffiliateParameters::select('parameter_group','key_local_id','value')->where(['user_id' => decryptGdprData($affId) ,'service_id' => 2 ,'parameter_group' => 3])->get()->toArray();
        
        
        $planTypes=[];
        $connectionTypes=[];
        $leadPopupData=[];
        if(!empty($planType)){
           foreach($planType as $plan){
                $planTypes[$plan['parameter_group']][$plan['key_local_id']]=$plan['value'];
                }
            }
        if(!empty($connectionType)){
            foreach($connectionType as $conn){
                    $connectionTypes[$conn['parameter_group']][$conn['key_local_id']]=$conn['value'];
                    }
            }
        if(!empty($leadPopupInfo)){
            foreach($leadPopupInfo as $leadInfo){
                $leadPopupData[$leadInfo['parameter_group']][$leadInfo['key_local_id']] = $leadInfo['value'];
            }
        }
        //dd($planTypes);
        $affiliateuser = Affiliate::getFilters(['user_id' => decryptGdprData($affId)], ['*'], ['user' => ['id', 'first_name', 'last_name', 'email', 'phone'], 'getaffiliateservices' => ['id', 'user_id', 'service_id'], 'getunsubscribesources' => ['id', 'user_id', 'unsubscribe_source'], 'affiliateunsubscribesource' => ['user_id', 'unsubscribe_source', 'status'], 'getuseradress' => ['user_id', 'address'], 'getthirdpartyapi' => ['user_id', 'api_key']], false, false);
        return view('pages.affiliates.create_update.index', compact('affId', 'type', 'opr', 'services', 'affiliateuser', 'userId', 'verticals','energyServiceStatus','planTypes','connectionTypes','leadPopupData'));
    }

    public function update(AffiliateRequest $request)
    {
        try {
            return Affiliate::updateAffiliate($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


    public function changeStatus(Request $request, PasswordBroker $broker)
    {
        try {
            return Affiliate::affiliateChangeStatus($request,$broker);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getGeneratePassword($token = null)
    {
        if($token){
           $data = explode('+', decryptGdprData($token));
           if(count($data)!=2){
            return redirect()->route('login')->with('error', trans('affiliates.invalid_token'));              
           }
           $current=time();
           if($data[0]<$current){
            return redirect()->route('login')->with('error', trans('affiliates.invalid_token'));  
           }
           $token = $data[1];
        }
        $user = Affiliate::getUserByToken($token);

        if($user)
            return view('pages.affiliates.create_update.generate_password')->with('user', $user);
        else
            return redirect()->route('login')->with('error', trans('affiliates.invalid_token'));
    }

    public function updatePassword(PasswordResetRequest $request){
        Affiliate::updatePassword($request);
        return redirect()->route('login')->with('success', trans('affiliates.password_generated'));
    }



    public function retentionSale()
    {
        return view('pages.affiliates.retention.list');
    }

    public function sendResetPasswordMail(Request $request, PasswordBroker $broker){
        try {
            return Affiliate::resetPasswordMail($request,$broker);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


    public function getPreview($affiliate_id = "", $template_id = "", $sub_affiliate="")
    {
        return view('pages.affiliates.email-templates.components.preview', compact('affiliate_id', 'template_id', 'sub_affiliate'));
    }

    public function verticalStatus(Request $request)
    {
        try {
            return Affiliate::verticalChangeStatus($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function storeVerticalServices(Vertical $request)
    {
        // dd($request->all());
        try {
            $result =  Affiliate::storeServices($request);
            if ($request->type == 'sub-affiliates') {

                $userId = Affiliate::getAffiliateIdByParentId(decryptGdprData($request->id));
                $userId = encryptGdprData($userId);

                $checkservices = [];
                foreach ($result as $key) {
                    $checkservices[] = $key['service_id'];
                }
                $assignedServices = Affiliate::getUserServices(decryptGdprData($userId), $checkservices);
                $services = $assignedServices;

                $array = ['services' => $services, 'data' => $result];
                return response()->json(['status' => 200, 'message' => trans('affiliates.usersuccess'), 'result' => $array]);
            }

            $assignedServices = Affiliate::getVerticalAssignedServices(decryptGdprData($request->id));
            $services = Affiliate::getServices($assignedServices);
            $array = ['services' => $services, 'data' => $result];
            return response()->json(['status' => 200, 'message' => trans('affiliates.usersuccess'), 'result' => $array]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function deleteVertical(Request $request)
    {
        try {
            return Affiliate::deleteVerticalById($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function updateParameters(AffiliateParametersRequest $request){
        try {
            return Affiliate::createUpdateParameter($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getserviceParameter(Request $request){
        try {
            return Affiliate::getParameterByServiceId($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public function getPlanType(Request $request){
        try {
            return Affiliate::getPlanType($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public function updatePlanType(AffiliatePlanTypeRequest $request){
        try {
            return Affiliate::updatePlanType($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
}
