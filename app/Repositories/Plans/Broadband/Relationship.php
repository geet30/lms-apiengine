<?php
namespace App\Repositories\Plans\Broadband;

trait Relationship
{
    public function connectionData()
    {
        return $this->belongsTo('App\Models\ConnectionType','connection_type','id');
    }

    public function technologies()
    {
        return $this->belongsToMany('App\Models\ConnectionType','plans_broadband_technologies','plan_id','technology_id');
        //return $this->hasMany('App\Models\PlansBroadbandTechnology','plan_id','id');
    }

    public function terms(){
    	return $this->hasMany('App\Models\PlansTelcoContent','plan_id')->whereNotNull('slug');
    }

    public function planEicContents(){
        return $this->hasOne('App\Models\PlansBroadbandEicContent','plan_id','id');
    }

    function planEicContentCheckbox() {
    	return $this->hasMany('App\Models\PlansBroadbandContentCheckbox','plan_id','id');
    }

    function planFees() {
    	return $this->hasMany('App\Models\PlansTelcoFee','plan_id','id')->where('service_id',3);
    }
}
