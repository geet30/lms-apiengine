<?php

namespace App\Repositories\Affiliate;  
use DB; 
use Illuminate\Support\Facades\Redis;  
use App\Models\{AffiliateKeys,AssignedUsers}; 

trait RedisOperations
{

	
    public static function updateRedisForMobileFilter($affId){
		$apiKeys=AffiliateKeys::select('api_key')->where('user_id',$affId)->get();
		$services = AssignedUsers::getUserServices($affId);
		if(!$apiKeys->isEmpty()){
			foreach($apiKeys as $key){
				foreach($services as $service){
					Redis::del('mobile:filters:0'.$service->service_id.encryptGdprData($key->api_key));
				    Redis::del('mobile:filters:1'.$service->service_id.encryptGdprData($key->api_key));
				  }
			}
		}	
	}
}