<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\PlansEnergy\{
    Accessor
};
class EnergyPlanRateLimit extends Model
{
    use HasFactory,Accessor;
    protected $fillable= ['plan_rate_id','limit_type','limit_level','limit_desc','limit_daily','limit_year','limit_charges','limit_charges_description','status','is_deleted'];
}
