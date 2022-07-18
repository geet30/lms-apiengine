<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderEquipment extends Model
{
    use HasFactory;
    protected $table = 'provider_equipments';

    protected $fillable = ['provider_id','order','life_support_equipment_id','status','is_deleted'];

}
