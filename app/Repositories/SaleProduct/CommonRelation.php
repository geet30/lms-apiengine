<?php

namespace App\Repositories\SaleProduct;

trait CommonRelation
{
    public  function statusHierarchies(){
		return $this->hasMany('App\Models\StatusHierarchy','status_id','sale_status')->where('type',1);
	}
}