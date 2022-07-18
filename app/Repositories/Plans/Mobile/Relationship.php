<?php
namespace App\Repositories\Plans\Mobile;

trait Relationship
{
	public function connectionType()
	{
		return $this->hasOne('App\Models\ConnectionType', 'local_id', 'connection_type')->where('service_id',2);
	}

	public function planMobileReferences()
	{
		return $this->hasMany('App\Models\PlanMobileReference', 'plan_id', 'id')->orderBy('s_no');
	}

	public function planMobileTerms()
	{
		return $this->hasMany('App\Models\PlansTelcoContent', 'plan_id', 'id')->where('service_id',2)->whereNotNull('slug');
	}

	public function planMobileOtherInfo()
	{
		return $this->hasMany('App\Models\PlansTelcoContent', 'plan_id', 'id')->where('service_id',2)->whereNull('slug');
	}

	function planFees() {
    	return $this->hasMany('App\Models\PlansTelcoFee','plan_id','id')->where('service_id',2);
    }
}
