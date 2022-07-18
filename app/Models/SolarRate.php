<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\PlansEnergy\{
    PlanSolarRate, PlanCrud
};

class SolarRate extends Model
{
    use HasFactory, PlanSolarRate, PlanCrud;

    protected $fillable = ['plan_id', 'solar_price', 'solar_description', 'is_show_frontend', 'status', 'deleted_at', 'type', 'charge','solar_rate_price_description','solar_supply_charge_description'];
}
