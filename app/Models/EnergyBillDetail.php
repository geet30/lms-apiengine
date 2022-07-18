<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyBillDetail extends Model
{
    use HasFactory;

    protected $table = 'energy_bill_details';

    protected $guarded = [];
}
