<?php

namespace App\Http\Controllers\Addons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\{
    PlanAddonsMaster,
    Providers,
    ConnectionType,
};
use App\Http\Requests\Addons\AddonRequest;
use DB;
use Illuminate\Support\Facades\Session;

class AddonsController extends Controller
{
    public function index()
    {
        $category = explode('.', \Request::route()->getName())[1];
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        $permissionList = [
            'home-line-connection' => 'home_line_connection_action',
            'modem' => 'modem_action',
            'additional-addons' => 'additional_addons_action'
        ];
        $checkPermissions = isset($permissionList[$category])? $permissionList[$category]:'';
 
        if(!checkPermission($checkPermissions,$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/');
        } 

        $addon_data = PlanAddonsMaster::getAddons($category);
        return view('pages.addons.broadband.list', compact('addon_data', 'category','userPermissions','appPermissions'));
    }
    public function create($category)
    {
        $addonType = decryptGdprData($category); 
        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        $permissionList = [
            '3' => 'add_home_line_connection',
            '4' => 'add_modem',
            '5' => 'add_addons'
        ];
        $checkPermissions = isset($permissionList[$addonType])? $permissionList[$addonType]:'';
 
        if(!checkPermission($checkPermissions,$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/');
        } 
        $providers = PlanAddonsMaster::getProviders();
        $connections = ConnectionType::where('connection_type_id', '=', null)->get();
        return view('pages.addons.broadband.create_update.index', compact('addonType', 'providers', 'connections'));
    }
    public function edit($category, $id)
    {
        $addonType = decryptGdprData($category);

        $userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
        $permissionList = [
            '3' => 'edit_home_line_connection',
            '4' => 'edit_modem',
            '5' => 'edit_addons'
        ];
        $checkPermissions = isset($permissionList[$addonType])? $permissionList[$addonType]:'';
 
        if(!checkPermission($checkPermissions,$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/');
        } 

        $addon = PlanAddonsMaster::getEditAddon($id);
        $addonId = $addon->id;
        $connectionId = $addon->connection_type;
        $selectedTechnologies  = PlanAddonsMaster::getTechTypes($addonId);
        $technologies = PlanAddonsMaster::getTechnologiesType($connectionId);
        $providers = PlanAddonsMaster::getProviders();
        $connections = ConnectionType::where('connection_type_id', '=', null)->get();
        // echo var_dump($selectedTechnologies);
        return view('pages.addons.broadband.create_update.index', compact('addon', 'addonType', 'connections', 'providers', 'technologies', 'selectedTechnologies'));
    }
    public function store(AddonRequest $request, $id)
    {
        try {
            return PlanAddonsMaster::storeOrUpdateAddons($request, $id);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()],400);
        }
    }
    public function delete($id)
    {
        try {
            $response = PlanAddonsMaster::deleteAddons($id);

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
    public function updateStatus(Request $request){
        try{
            $response = PlanAddonsMaster::updateStatus($request);
            if($response['status'] != '200'){
                return response()->json(['status' => 422, 'errors' => $response],422);
            }
            return response()->json(['status' => 400, 'message' => "status changed"],200);
        }catch(\Exception $e){
            return response()->json(['status' => 400, 'message' => $e->getMessage()],400);
        }
    }
    public function getTechnologyType(Request $request)
    {
        try {
            $response = PlanAddonsMaster::getTechnologyType($request->id);
            return response()->json(['data' => $response], 200);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 400);
        }
    }
}
