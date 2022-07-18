<?php

namespace App\Models;

use App\Repositories\Settings\Distributor\{Mutators};
use App\Repositories\Settings\Distributor\Accessor;
use App\Repositories\Settings\Distributor\BasicCrudMethods;
use App\Repositories\Settings\Distributor\Relationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Distributor extends Model
{
    use HasFactory, Accessor, BasicCrudMethods, Mutators, Relationship;

    protected $fillable = ['name', 'energy_type', 'service_id', 'status', 'is_deleted'];

}
