<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\PlansEnergy\{
    DemandRate,Accessor,Relationship
};

use App\Repositories\Settings\TariffInfo\{ImportTariffInfoRate};

class EnergyTariffInfo extends Model
{
    use HasFactory,DemandRate,Accessor,Relationship,ImportTariffInfoRate;
    
    protected $table="tariff_infos";
    protected $fillable = ['tariff_code_ref_id','tariff_code_aliases','tariff_discount','tariff_daily_supply','tariff_supply_discount','daily_supply_charges_description','discount_on_usage_description','discount_on_supply_description','plan_rate_ref_id','status','is_deleted'];
}
