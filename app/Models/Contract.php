<?php

namespace App\Models;

use App\Repositories\MobileSettings\contract\BasicCrudMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use  HasFactory, BasicCrudMethods;

    protected $table = 'contract';

    protected $fillable = ['contract_unique_id', 'contract_name', 'validity', 'description', 'status', 'created_at', 'updated_at', 'deleted_at'];

}
