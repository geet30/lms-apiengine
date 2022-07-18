<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Crypt;
use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Requests\Providers\{AddPasswordProtectedProviderSaleSubmissionRequest,
    AddProviderSaleSubmissionRequest,
    AddSftpLogsRequest,
    AddSftpRequest,
    AddSuburbRequest,
    ProviderRequest,
    CheckboxRequest,
    SuburbPostcodesImportRequest,
    UserRequest,
    AssignPostcodeRequest,
    SuburbRequest,
    ProviderMovin,
    CustomFieldRequest,
    DebitCsvInfoRequest,
    ProviderLogoRequest};
//use App\Repositories\Provider\ProviderRepository;
use App\Models\{ProviderPermission, ProviderConcessions,concessionContents,User, Providers, Services, Distributor, ProviderPostcode, UserStates, UserSuburb, UserPostcode, Postcode, States,ProviderContent,ConnectionType};
use App\Repositories\Common\CommonRepository;
use Illuminate\Support\Facades\Session;

class ProviderController extends Controller
{
    // public $provider;

    // public function __construct(ProviderRepository $provider)
    // {
    //     $this->provider = $provider;
    // }

    public function index(Request $request)
    {
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('show_providers',$userPermissions,$appPermissions) || !checkPermission('users_action',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/');
        }
        $info = 'providers';
        $condtion = []; 
        $services = Providers::getAssignedServices();
        if ($request->isMethod('post')) {
            $request->merge(['email' => $request->email, 'legal_name' => $request->legal_name]);
            $condtion['is_deleted'] = 0;
            if (isset($request->id)) {
                $condtion['user_id'] = $request->id;
            }

            if (isset($request->status)) {
                $condtion['status'] = $request->status;
            }

            if (isset($request->legal_name)) {
                $condtion['legal_name'] = strtolower($request->legal_name);
            }
            if (isset($request->service)) {
                $condtion['service_id'] = $request->service;
            }
            $provideruser = Providers::getProviderList(
                $condtion,
                ['*'],
                [
                    'getProviderServices' => ['user_id', 'user_type', 'service_id'],
                    'providersLogo' => ['*'],
                ],
            );

            $getData = Providers::modifyProviderResponse($provideruser, $info);
            return response()->json(['providers' => $getData,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions], 200);
        } else {
            $provideruser = Providers::getProviderList(
                ['is_deleted' => 0, 'service_id' => 2],
                ['*'],
                [
                    'user' => ['id', 'email', 'phone'],
                    'getProviderServices' => ['user_id', 'user_type', 'service_id'],
                    'getUserAddress' => ['user_id', 'address', 'address_type'],
                    'providersLogo' => ['*'],
                ],
                true
            );
        }
        return view('pages.providers.list', compact('info', 'services', 'provideruser','userPermissions','appPermissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAjax($providerId)
    {
        $provider = Providers::getFilters(
            ['user_id' => decryptGdprData($providerId)],
            ['*'],
            [
                'user' => ['id', 'email', 'phone'],
                'getUserAddress' => ['user_id', 'address'],
            ],
            false,
            false
        );
        $provider = $provider[0];
        return view('pages.providers.components.provider-details', compact('provider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('show_providers',$userPermissions,$appPermissions) || !checkPermission('users_action',$userPermissions,$appPermissions) || !checkPermission('add_provider',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/provider/list');
        }
        $action = 'create';
        $info = auth()->user()->info;
        $services = Providers::getServices();
        return view('pages.providers.edit.index', compact('info', 'services', 'action'));
    }

    /**
     * Save the data for creating a new provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderRequest $request)
    {
        try {
            $response = Providers::insertProvider($request);
            if ($response['status']) {
                return response()->json(['status' => $response['status'], 'message' => $response['message']]);
            } else {
                return response()->json(['status' => $response['status'], 'message' => $response['message']]);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Show the form for creating/updatig a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($provider_Id = null, $service_id = null)
    {
        $plan_connection_types=[];
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('show_providers',$userPermissions,$appPermissions) || !checkPermission('users_action',$userPermissions,$appPermissions) || !checkPermission('edit_provider',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/provider/list');
        }
        $action = 'update';
        $info = auth()->user()->info;
        // $services = Services::where('status',1)->select('id','service_title')->get();
        $services = Providers::getServices();
        $states = Providers::getStates(); //    dd(decryptGdprData($service_id),decryptGdprData($provider_Id));
        $lifesupport = CommonRepository::getLifeSupportList();
        $provider_details = Providers::getProviderDetails(
            ['user_id' => decryptGdprData($provider_Id), 'service_id' => decryptGdprData($service_id)],
            ['*'],
            [
                'user' => ['id', 'email', 'phone'],
                'getProviderServices' => ['id', 'user_id', 'service_id'],
                'getUserAddress' => ['user_id', 'address'],
                'getProviderContent.providerContentCheckbox' => ['*'],
                'getProviderSection.getSectionOption.getSectionSubOption' => ['*'],
                'getCustomField.customPlanSection' => ['*'],
                'getConnectionCustomField'  => ['*'],
                'getDirectDebitSettings.getContentCheckbox' => ['*'],
                'getPermissions.getPermissionCheckbox' => ['*'],
                'getOutboundLinks' => ['*'],
                'getProviderContacts' => ['*'],
                'getDetokenizationSettings' => ['*'],
                'providersLogo' => ['*'],
            ],
            false
        );
        $provider_details[0]['get_provider_equipments'] = Providers::getProviderEquipments(($provider_Id))->toArray();
        $provider_details[0]['get_all_equipments'] = Providers::getAllEquipments()->toArray();
        $provider_logo = Providers::getProviderLogo(decryptGdprData($provider_Id));
        $master_personal_details = config('app.personal_details');
        $master_connection_details = config('app.connection_details');
        $master_identification_details = config('app.identification_details');
        $master_employment_details = config('app.employment_details');
        $master_connection_address = config('app.connection_address');
        $master_billing_address = config('app.billing_address');
        $master_delivery_address = config('app.delivery_address');
        $t_and_c_types = config('app.terms_and_conditions_types');
        $whereArray=['1','2','3','4','5','6','7','8','9'];
        $typesData=ProviderContent::select('type')->where(['provider_id'=>decryptGdprData($provider_Id)])->whereIn('type',$whereArray)->distinct()->get()->toArray();
        $typesArray=[];
        foreach($typesData as $data){
           array_push($typesArray,$data['type']);
        }
        // 23-05-2022
        $content_attribute = getEnergyContentAttributes
        (3,1);

        $concession_data = ProviderConcessions::where('provider_id',$provider_details[0]['id'])->pluck('state_id')->toArray();

        $plan_connection_types=ConnectionType::select('local_id','name')->where(['service_id' => 2,'connection_type_id'=> 8, 'status' => 1,'is_deleted' => 0])->get()->toArray();

        return view('pages.providers.edit.index', compact('plan_connection_types','concession_data','info', 'provider_Id', 'services', 'provider_details', 'states', 'master_personal_details', 'master_connection_details', 'master_identification_details', 'master_employment_details', 'master_connection_address', 'master_billing_address', 'master_delivery_address', 't_and_c_types', 'lifesupport', 'provider_logo','action','typesArray','content_attribute'));
    }

    /**
     * Edit provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request)
    {
        try {
            return Providers::updateProviderDetail($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }



    /**
     * Show the form for creating/updating a provider move-in detail.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating/updating assign users to provider detail.
     *
     * @return \Illuminate\Http\Response
     */

    //  24-05-2022
    public function showConcessionDataAjax(Request $request)
    {
        try {
            return  concessionContents::getConcessionDetails($request);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    // 24-05-2022
    public function getAssignUserToProvider($providerId)
    { 
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        if(!checkPermission('provider_action',$userPermissions,$appPermissions) || !checkPermission('provider_settings',$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/provider/list');
        }
        $request = new Request([
            'id'   => $providerId,
            'providerservice' => 1,
            'type'  => 2,
            'providertype'  => 1
        ]);

        $users = Providers::getUserServiceById($request);
        $providerdetails = Providers::getProviderDetails(
            ['user_id' => decryptGdprData($providerId)],
            ['*'],
            [
                'user' => ['id', 'email', 'phone'],
                'providersLogo' => ['user_id','name','category_id'],
            ],
            false
        );
        $assignedProviders = Providers::getAssignedProviders(1, '', '', decryptGdprData($providerId));
        $states = Providers::states(decryptGdprData($providerId));
        $assignedStates = Providers::providerassignedStates(decryptGdprData($providerId));
        $userStates = UserStates::where('user_id', decryptGdprData($providerId))->with('userSubrubs', 'state')->get();
        $assignedSubrubs = UserSuburb::where('user_id', decryptGdprData($providerId))->with('subrubs')->get();
        $assignedPostcodes = UserPostcode::where('user_id', decryptGdprData($providerId))->get();
        $distributors = Providers::getMoveinDistributors($providerId);
        $submit_sale_api = ProviderPermission::where('user_id', decryptGdprData($providerId))->pluck('is_submit_sale_api')->toArray();
        return view('pages.providers.assign-users', compact('providerdetails', 'users', 'providerId', 'assignedProviders', 'states', 'assignedStates', 'assignedSubrubs', 'assignedPostcodes', 'userStates', 'distributors','submit_sale_api'));
    }

    public function postProviderAffiliates(UserRequest $request)
    {
        try {
            return  Providers::assginProvidersWithService($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    // store or update provider contact data
    public function storeContact(ProviderRequest $request)
    {
        try {
            $result = Providers::storeOrUpdateContact($request);
            if ($result['status'] == true) {
                if (!empty($result['contactdata'])) {
                    return response()->json(['contactdata' => $result['contactdata'], 'status' => $result['status'], 'message' => $result['message']]);
                }
                return response()->json(['contactdata' => '', 'status' => $result['status'], 'message' => $result['message']]);
            }
            return response()->json(['contactdata' => $result['contactdata'], 'status' => $result['status'], 'message' => $result['message']]);
        } catch (\Exception $err) {
            $result = [
                'exception_message' => $err->getMessage()
            ];
            $status = 400;

            return response()->json($result, $status);
        }
    }
    //delete provider contact
    public function deleteContact(Request $request, $id)
    {
        try {
            $response = Providers::deleteContact($request, $id);
            if ($response['status'] == true) {
                return response()->json(['data' => $response['data'], 'status' => $response['status'], 'message' => $response['message']]);
            }
            return response()->json(['data' => $response['data'], 'status' => $response['status'], 'message' => $response['message']]);
        } catch (\Exception $err) {
            $result = [
                'exception_message' => $err->getMessage()
            ];
            $status = 400;

            return response()->json($result, $status);
        }
    }
    //

    /**
     * get provider data on change of selectbox.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function getSpecificTermData(Request $request)
    {
        try {
            return  Providers::getSpecificTermData($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Store or update checkbox of provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdateCheckbox(CheckboxRequest $request)
    {
        try {
            $res =  Providers::storeOrUpdateCheckbox($request);
            return $res;
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Remove checkbox of provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function removeCheckbox(Request $request)
    {
        try {
            return  Providers::removeCheckbox($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Store or update IP settings of provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function  postManageIps(Request $request)
    {
        try {
            return  Providers::postManageIps($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Get IP's settings of provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function  getManageIps(Request $request)
    {
        try {
            return  Providers::getManageIps($request);
        } catch (\Exception $e) {
            return  $result = [
                'exception_message' => $e->getMessage()
            ];
        }
    }

    /**
     * Store detokenization token of provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function  postManageToken(Request $request)
    {
        try {
            $response =  Providers::postManageToken($request);
            return $response;
            return response()->json(['status' => $response['status'], 'message' => $response['message'], 'token' => $response['token']], 200);
        } catch (\Exception $e) {
            return  $result = [
                'exception_message' => $e->getMessage()
            ];
        }
    }

    /*
     *
     *
     */
    public function  setDebitInfoIp(DebitCsvInfoRequest $request)
    {
        try {
            $response =  Providers::setDebitInfoIp($request);
            if ($response['status'] != '200') {
                return response()->json(['status' => 422, 'errors' => $response['errors']], 422);
            }
            return response()->json(['status' => $response['status'], 'message' => $response['message']], 200);
        } catch (\Exception $e) {
            return  $result = [
                'exception_message' => $e->getMessage()
            ];
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $response = Providers::updateStatus($request);
            if ($response['status'] != '200') {
                return response()->json(['status' => 422, 'errors' => $response], 422);
            }
            return response()->json(['status' => $response['status'], 'message' => $response['message']], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $response['status'], 'message' => $e->getMessage()], 400);
        }
    }

    public function deleteOutBoundLink(Request $request, $id)
    {
        try {
            return Providers::deleteOutboundLink($request, $id);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function getStateOrTeleData(Request $request)
    {
        try {
            return Providers::getStateOrTeleData($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getDistributors(Request $request)
    {
        try {
            return  Distributor::getDistributorWithPostcodes($request->energyType, $request->providerId);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateSftpLog(AddSftpLogsRequest $request)
    {
        try {
            return Providers::updateSftpLog($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function assignPostcodes(AssignPostcodeRequest $request)
    {
        try {
            return Providers::assignPostcodes($request);
        } catch (\Exception $err) {
            return response()->json(['message' => 'Unable to assign postcodes.', 'exception' => $err->getMessage()], 500);
        }
    }

    public function getSuburbs(Request $request)
    {
        try {
            return Providers::getSuburbs($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public function getPostcodeSuburbs(Request $request)
    {
        try {
            return Providers::getPostcodeSuburbs($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public function getPostcodePostcodes(Request $request)
    {  //dd($request);
        try {
            return Providers::getPostcodePostcodes($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }



    public function assignSuburbs(SuburbRequest $request)
    {
        try {
            return Providers::assignSuburbs($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function addSuburbs(AddSuburbRequest $request, $user_id)
    {
        try {
            return Providers::addSuburbs($request, $user_id);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function importSuburbPostcodes(SuburbPostcodesImportRequest $request)
    {
        try {
            return Providers::importSuburbPostcodes($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function downloadSuburbPostcodesSampleSheet(){
        $file = public_path('downloads/suburb_postcodes_import_sample.csv');
        return response()->download($file);
    }

    public function changeSuburbStatus(Request $request)
    {
        try {
            return Providers::changeSuburbStatus($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function changeSuburbStatusBulk(Request $request)
    {
        try {
            return Providers::changeSuburbStatusBulk($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function deleteSuburb(Request $request)
    {
        try {
            return Providers::deleteSuburb($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function postSaleSubmission(AddProviderSaleSubmissionRequest $request)
    {
        try {
            return Providers::postSaleSubmission($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function postPasswordProtectedSaleSubmission(AddPasswordProtectedProviderSaleSubmissionRequest $request)
    {
        try {
            return Providers::postPasswordProtectedSaleSubmission($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function addSftp(AddSftpRequest $request)
    {
        try {
            if (isset($request->sftp_id))
                return Providers::updateSftp($request);
            else
                return Providers::addSftp($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getSftps($provider_id)
    {
        try {
            return Providers::getSftps($provider_id);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function deleteSftp($sftp_id)
    {
        try {
            return Providers::deleteSftp($sftp_id);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function changeSftpStatus($sftp_id)
    {
        try {
            return Providers::changeSftpStatus($sftp_id);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function changeProviderSftpStatus($user_id)
    {
        try {
            return Providers::changeProviderSftpStatus($user_id);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getSaleSubmission($provider, $type)
    {
        try {
            return Providers::getSaleSubmission($provider, $type);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }



    public function providerMovinData(ProviderMovin $request)
    {
        try {
            return Providers::providerMovinData($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function getProviderMovinDetail(Request $request)
    {
        try {
            return Providers::getProviderMovinDetail($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function saveEicContentData(Request $request)
    {
        try {
            return Providers::saveEicContentData($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    public function getMovinDistributors(Request $request)
    {
        try {
            return Providers::getMoveinDistributors($request->provider_id, $request->energy_type);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    /**
     * Store or update custom fields.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function saveEditCustomField(CustomFieldRequest $request)
    {
        try {
            return Providers::saveEditCustomField($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    /**
     * delete custom fields.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function deleteCustomField(Request $request)
    {
        try {
            return Providers::deleteEditCustomField($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    /**
     * get plan according to provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function getPlans(Request $request)
    {
        try {
            return Providers::getPlans($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    public function assignPlanToField(Request $request)
    {
        try {
            return Providers::assignPlanToField($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function deleteEquipment(Request $request, $id)
    {
        try {
            return Providers::deleteEquipment($request, $id);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    public function getCategory(Request $request)
    {
        try {
            return Providers::getCategory($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function changeEquipmentStatus($id)
    {
        try {
            return Providers::changeEquipmentStatus($id);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    public function saveProviderLogo(ProviderLogoRequest $request)
    {
        try {
            return Providers::saveProviderLogo($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    public function checkUserGetPermission(Request $request){
        try {
            return Providers::checkUserGetPermission($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    public function removeDecryption(Request $request){
        //    $basic = \DB::table('providers')->select('id','name','legal_name','support_email','complaint_email')->get();
        //    $data =[];
        //    foreach($basic as $row){
        //       $data = [
        //                'name' => decryptGdprData($row->name),
        //                'legal_name' => decryptGdprData($row->legal_name),
        //                'support_email' => decryptGdprData($row->support_email),
        //                'complaint_email' => decryptGdprData($row->complaint_email)
        //               ];
        //       Providers::where('id',$row->id)->update($data);
        //    }

        //provider_sale_submissions
        $provider_sale_submissions = \DB::table('provider_sale_submissions')->select('id','from_name')->get();
            foreach($provider_sale_submissions as $row){
            $data = [
                    'from_name' => decryptGdprData($row->from_name),
                    ];
            \DB::table('provider_sale_submissions')->where('id',$row->id)->update($data);
        }
        //providers_ips
        $providers_ips = \DB::table('providers_ips')->select('id','token')->get();
            foreach($providers_ips as $row){
                $data = [
                        'token' => encryptGdprData($row->token),
                        ];
                \DB::table('providers_ips')->where('id',$row->id)->update($data);
            }
        //provider_sale_emails
        $provider_sale_emails = \DB::table('provider_sale_emails')->select('id','from_email')->get();
            foreach($provider_sale_emails as $row){
                $data = [
                        'from_email' => encryptGdprData($row->from_email),
                        ];
                \DB::table('provider_sale_emails')->where('id',$row->id)->update($data);
            }
    }
}
