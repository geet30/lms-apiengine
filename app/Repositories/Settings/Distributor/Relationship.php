<?php

namespace App\Repositories\Settings\Distributor;

trait Relationship
{
	public function postCodes()
	{
		return $this->hasMany('App\Models\DistributorPostCode');
	}
	public function providerPostCodes()
	{
		return $this->hasMany('App\Models\ProviderPostcode');
	}
}
