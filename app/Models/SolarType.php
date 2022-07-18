<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolarType extends Model
{
     protected $table = 'solar_plan_type';
     protected $fillable = ['state_code', 'is_premium', 'is_normal'];
}
