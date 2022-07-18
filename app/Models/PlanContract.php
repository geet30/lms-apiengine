<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanContract extends Model
{
    protected $table='plans_mobile_contracts';

    protected $fillable=['plan_variant_id','plan_id','contract_id','contract_cost','contract_type','description','status'];

    public function contract_data()
    {
        return $this->belongsTo('App\Models\Contract','contract_id','contract_unique_id');
        
    }
}
