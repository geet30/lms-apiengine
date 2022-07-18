<?php

namespace App\Models;

use App\Repositories\Settings\LifeSupportEquipments;
use Illuminate\Database\Eloquent\Model;

class LifeSupportEquipment extends Model
{
    use LifeSupportEquipments;

    protected $table = 'life_support_equipments';

    protected $fillable = ['title', 'status', 'energy_type', 'is_deleted'];

    protected $dates = ['created_at', 'updated_at'];
}
