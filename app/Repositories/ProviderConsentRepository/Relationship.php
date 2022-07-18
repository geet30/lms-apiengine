<?php

namespace App\Repositories\ProviderConsentRepository;

use DB;

trait Relationship
{
	public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

	public static function getStates()
	{
		return DB::table('provider_states')->where('status', 1)->select('id', 'name')->get();
	}
	public function getProviderServices()
	{
		return $this->hasMany('App\Models\UserService', 'user_id', 'user_id');
	}

	public function getUserAddress()
	{
		return $this->hasOne('App\Models\UserAddress', 'user_id', 'user_id');
	}

	public  function getContentCheckbox()
	{
		return $this->hasMany('App\Models\ProviderContentCheckbox', 'provider_content_id', 'id');
	}

	public  function getProviderContent()
	{
		return $this->hasMany('App\Models\ProviderContent', 'provider_id', 'user_id');
	}

	public  function getProviderSection()
	{
		return $this->hasMany('App\Models\ProviderSection', 'user_id', 'user_id');
	}

	public  function getDirectDebitSettings(){
		return $this->hasMany('App\Models\ProviderDirectDebit','user_id','user_id');
	}

	public  function getPermissions()
	{
		return $this->hasMany('App\Models\ProviderPermission', 'user_id', 'user_id');
	}

	public  function getOutboundLinks()
	{
		return $this->hasMany('App\Models\ProviderOutboundLink', 'user_id', 'user_id');
	}
	public  function getProviderContacts()
	{
		return $this->hasMany('App\Models\ProviderContact', 'provider_id', 'user_id');
	}

	public  function getDetokenizationSettings()
	{
		return $this->hasMany('App\Models\ProvidersIp', 'user_id', 'user_id');
	}
	public function getCustomField()
	{
		return $this->hasMany('App\Models\SectionCustomFields', 'user_id', 'user_id')->where('section_id', 1);
	}
	public function getConnectionCustomField()
	{
		return $this->hasMany('App\Models\SectionCustomFields', 'user_id', 'user_id')->where('section_id', 2);
	}
	public function providersLogo()
	{
		return $this->hasOne('App\Models\ProviderLogo', 'user_id', 'user_id')->where('category_id',9);
	}
}
