<?php

namespace App\Repositories\SaleDetail;

trait Relationship
{
    public  function getStatuses(){
		return $this->hasOne('App\Models\Status','id','status');
	}
    public  function getUser(){
		return $this->hasOne('App\Models\User','id','user_id');
	}
}