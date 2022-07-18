<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Plan\ { Methods };

class PlanTag extends Model
{
    use Methods;
    
    protected $table ='plan_tags';
    protected $fillable = ['plan_id','tag_id','is_deleted'];
}
