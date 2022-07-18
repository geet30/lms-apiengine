<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Addons\
                                {
                                    BasicCrud, 
                                    Relationship,
                                };

class PlanAddonsMaster extends Model
{
    use HasFactory;
    use Relationship,BasicCrud;
    protected $table = 'plan_addons_master';
    protected $fillable = ['category','provider_id','name','cost','cost_type_id','connection_type','order','is_deleted','inclusion','script','description','service_id','status'
       
    ];

    public function technologies()
    {
        return $this->hasMany('App\Models\PlanAddonMasterTechType','addon_id','id');
    }
}