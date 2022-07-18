<?php

namespace App\Models;

use App\Repositories\Settings\MasterTariffCode\Accessor;
use App\Repositories\Settings\MasterTariffCode\BasicCrudMethods;
use App\Repositories\Settings\MasterTariffCode\Mutators;
use App\Repositories\Settings\MasterTariffCode\Relationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTariffCode extends Model
{
    use HasFactory, BasicCrudMethods, Relationship, Accessor, Mutators;

    protected $table = 'master_tariffs';

    protected $fillable = ['id', 'tariff_type', 'tariff_code', 'master_tariff_ref_id', 'property_type', 'distributor_id', 'units_type', 'status', 'is_deleted', 'created_at', 'updated_at'];
}
