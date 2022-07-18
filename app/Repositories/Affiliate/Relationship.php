<?php

namespace App\Repositories\Affiliate;

trait Relationship
{

	public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

	public function getaffiliateservices()
	{
		return $this->hasMany('App\Models\UserService', 'user_id', 'user_id');
	}

	public function getunsubscribesources()
	{
		return $this->hasMany('App\Models\AffiliateUnsubscribeSource', 'user_id', 'user_id');
	}

	public function affiliateunsubscribesource()
	{
		return $this->hasMany('App\Models\AffiliateUnsubscribeSource', 'user_id', 'user_id')->where('status', 1);
	}

	public function getuseradress()
	{
		return $this->hasOne('App\Models\UserAddress', 'user_id', 'user_id');
	}
	public function getaffRetension()
	{
		return $this->hasone('App\Models\AffiliateRetension', 'user_id', 'user_id');
	}

	public function getthirdpartyapi()
	{
		return $this->hasOne('App\Models\AffiliateThirdPartyApi', 'user_id', 'user_id')->where('third_party_platform', 1)->where('status', 1);
	}
}
