<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\SaleProduct\{CommonCrud,CommonRelation};
use App\Traits\Product\ { Relationship };
class SaleProductsBroadband extends Model
{
    use HasFactory,CommonCrud,CommonRelation,Relationship;
    protected $table = 'sale_products_broadband';
    
      
    public  function getAssignedQa(){
		return $this->hasMany('App\Models\SaleAssignedBroadbandQa','lead_id','lead_id');
	}
}
