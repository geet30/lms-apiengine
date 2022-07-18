<?php

namespace App\Models;

use App\Repositories\SaleProduct\CommonCrud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProductEnergyOtherInfo extends Model
{
    use HasFactory, CommonCrud;

    protected $table = 'sale_product_energy_other_info';

    protected $guarded = [];

}
