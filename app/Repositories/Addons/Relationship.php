<?php
namespace App\Repositories\Addons;
use App\Models\{
    PlanAddonsMaster,
    Providers,
    ConnectionType,
    PlanAddonMasterTechType,

};
use DB;
trait Relationship
{
    public static function getAddons($category){
        if($category == 'home-line-connection'){
        return PlanAddonsMaster::join('providers', 'plan_addons_master.provider_id', '=', 'providers.user_id')->where('category', 3)->select('plan_addons_master.*', 'providers.legal_name')->orderBY('created_at','desc')->get();
        }
        elseif($category == 'modem'){
            return PlanAddonsMaster::join('connection_types', 'plan_addons_master.connection_type', '=', 'connection_types.id')->where('category', 4)->select('plan_addons_master.*', 'connection_types.name as connection_name')->orderBY('created_at','desc')->get();
        }
        else{
            return PlanAddonsMaster::where('category','=',5)->orderBY('created_at','desc')->get();
        }

    }
    public static function getProviders(){
        return Providers::all();
    }
    public static function getEditAddon($id){
        return PlanAddonsMaster::find(decryptGdprData($id));

    }
    public static function getTechnologiesType($connectionId){
        return ConnectionType::where('connection_type_id',$connectionId)->get();
    }
    public static function getTechTypes($addonId){
        return PlanAddonMasterTechType::where('addon_id','=',$addonId)->select('id','tech_type')->get()->toArray();
    }
    public static function getTechnologyType($connId)
    {
        return ConnectionType::where('connection_type_id',$connId)->where('service_id',3)->where('status','1')->whereNotNull('name')->whereNotNull('connection_type_id')->select('id','name')->get();
    }
}
