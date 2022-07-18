<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Plans\MobileHandset\{ BasicCrudMethods, Relationship, Accessor, Mutators };

class PlanMobileHandset extends Model
{
    use BasicCrudMethods, Relationship, Accessor, Mutators;
    
    protected $table ='plans_mobile_handsets';
}
