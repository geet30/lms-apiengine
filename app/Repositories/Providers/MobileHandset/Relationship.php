<?php
namespace App\Repositories\Providers\MobileHandset;

trait Relationship
{ 
    public function handset(){
		return $this->hasOne('App\Models\Handset', 'id', 'handset_id');
	}

    public function provider(){
   		return $this->hasOne('App\Models\Provider', 'id', 'provider_id');
   	}

    public function provider_variants(){
        return $this->hasMany('App\Models\ProviderVariant', 'provider_id', 'provider_id');
    }
}
