<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\SaleProduct\{CommonCrud,CommonRelation};
use App\Traits\Product\{EnergyMethods,Relationship};

class SaleProductsEnergy extends Model
{
    use HasFactory,CommonCrud,CommonRelation, EnergyMethods,Relationship;

    protected $table ='sale_products_energy';

    public  function getAssignedQa(){
      return $this->hasMany('App\Models\SaleAssignedEnergyQa','lead_id','lead_id');
    }

    public  function providers(){
      return $this->hasMany('App\Models\Providers','user_id','provider_id');
    }
    public  function services(){
      return $this->hasMany('App\Models\Services','id','service_id');
    }
    
}
