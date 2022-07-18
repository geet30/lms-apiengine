<?php
namespace App\Repositories\PlansEnergy;

use App\Models\Distributor;
use App\Models\PlanEnergy;
use App\Models\Plans\EnergyMasterTariff;

trait Relationship
{
    function distributors(){
        return $this->belongsTo(Distributor::class,'distributor_id','id');
    }
    function energyPlan(){
        return $this->belongsTo(PlanEnergy::class,'plan_id','id')->select('id','name','provider_id','energy_type');
    }
    function tariffName(){
        return $this->belongsTo(EnergyMasterTariff::class,'tariff_code_ref_id','id')->select('id','tariff_code');
    }
    public function provider(){
		return $this->belongsTo('App\Models\Providers','provider_id','user_id');
	}
}
