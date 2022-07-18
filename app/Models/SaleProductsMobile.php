<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\SaleProduct\{CommonCrud,CommonRelation};
use App\Traits\Product\ { Relationship };

class SaleProductsMobile extends Model
{
    use HasFactory,CommonCrud,CommonRelation,Relationship;
    protected $table = 'sale_products_mobile';
    
    public  function getAssignedQa()
    {
		  return $this->hasMany('App\Models\SaleAssignedMobileQa','lead_id','lead_id');
	  } 
    public function planinfo()
    {
      return $this->belongsTo('App\Models\PlanMobile','plan_id','id');
    }
    public function provider()
    {
      return $this->belongsTo('App\Models\Providers','provider_id','user_id');
    }

    static function updateData($conditions, $data)
    {
        $isUpdated = self::where($conditions)->update($data);
        return $isUpdated;
    }
}
