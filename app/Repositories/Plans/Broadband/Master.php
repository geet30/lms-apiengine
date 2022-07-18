<?php
namespace App\Repositories\Plans\Broadband;
use App\Models\{ 
    ConnectionType,
    Contract,
    CostType,
    Fee,
    PlanAddonsMaster
};
trait Master
{ 
    /**
     * get list of technology by selected connection type.
     *
     * @param  int  $connId
     * @return \Illuminate\Http\Response
     */
    public static function getTechType($connId)
    {
        return ConnectionType::where('connection_type_id',$connId)->where('service_id',3)->where('is_deleted','0')->where('status','1')->whereNotNull('name')->whereNotNull('connection_type_id')->select('id','name')->get(); 
    }
    
    /**
     * get list of all connection type.
     * 
     * @return \Illuminate\Http\Response
     */
    public static function getConnectionType()
    {
        return ConnectionType::select('id','name')->where('service_id', 3)->where('is_deleted','0')->where('status','1')->whereNull('connection_type_id')->get(); 
    }
    
    /**
     * get list of all contract.
     *
     * @param  int  $planId
     * @return \Illuminate\Http\Response
     */
    public static function getContracts()
    {
        return Contract::select('id','validity','contract_name')->where('status', 1)->orderBy("validity",'ASC')->get(); 
    }

    /**
     * get list of all fees
     *
     * @param  int  $planId
     * @return \Illuminate\Http\Response
     */
    public static function getCostTypes()
    {
        return CostType::select('id','cost_name')->where('status','1')->where('is_deleted','0')->orderBy('order','asc')->get();
    }

    /**
     * get list of all cost type
     *
     * @param  int  $planId
     * @return \Illuminate\Http\Response
     */
    public static function getFeeTypes()
    {
        return Fee::select('id','fee_name')->where('status','1')->where('is_deleted','0')->orderBy('order','asc')->get();
    }

    /**
     * get list of all Phone home line connection
     *
     * @param  int  $planId
     * @return \Illuminate\Http\Response
     */
    public static function getHomeConnection($providerId)
    {
        return PlanAddonsMaster::select('id','name')->where('status','1')->where('category','3')->where('is_deleted','0')->where('provider_id',$providerId)->orderBy('id', 'asc')->get();
    }

    /**
     * get list of all Modem
     *
     * @param  int  $planId
     * @return \Illuminate\Http\Response
     */
    public static function getModems($connectionType,$assignedTechnolgy)
    {  
        $addonMaster = PlanAddonsMaster::select('id','name')->where('status','1')->where('category','4')->where('connection_type', $connectionType)->where('is_deleted','0')->orderBy('id', 'asc');
        if(isset($assignedTechnolgy) && count($assignedTechnolgy) > 0)
        {
            $addonMaster = $addonMaster->whereHas('technologies', function($q) use($assignedTechnolgy){
                $q->whereIn('tech_type', $assignedTechnolgy);
            });
        }
        //dd($addonMaster->get()->toArray());
        return $addonMaster->get();
    }

    /**
     * get list of all Addon
     * 
     * @param  int  $planId
     * @return \Illuminate\Http\Response
     */
    public static function getAddons()
    {
        return PlanAddonsMaster::select('id','name')->where('status','1')->where('category','5')->where('is_deleted','0')->orderBy('id', 'asc')->get();
    }
}
