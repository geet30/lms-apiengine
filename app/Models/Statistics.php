<?php

namespace App\Models;

use App\Repositories\Statistics\TopWorstPlans\Accessor;
use App\Repositories\Statistics\TopWorstPlans\BasicCrud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    use HasFactory, BasicCrud, Accessor;
    protected $table = 'statistics';
    protected $guarded = [];

    const TYPE_NET_SALES = 3;
}
