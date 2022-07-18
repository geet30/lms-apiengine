<?php
namespace App\Repositories\Plans\MobileHandset;

trait Relationship
{
	public function plan()
    {
        return $this->belongsTo(Plan::class,'id','plan_id');
    }

    public function handset(){
        return $this->belongsTo( 'App\Models\Handset','handset_id');
    }
 
    public function scopeApiStatus($query)
    {
        return $query->where('master_status',1)->where('provider_status',1)->where('status',1);
    }

    public function providerVariant(){
        return $this->hasMany( 'App\Models\ProviderVariant','handset_id','handset_id');
    }
}
