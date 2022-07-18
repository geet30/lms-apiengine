<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\MobileSettings\Variants\{BasicCrudMethods};
use App\Models\ProviderVariant;
class Variant extends Model
{
   use BasicCrudMethods;

   protected $table = 'handset_variant';

   protected $fillable = ['handset_id','variant_name','capacity_id','internal_stroage_id','color_id','status'];

    public function color()
    {
        return $this->hasOne('App\Models\Color','id','color_id');
    }

    public function capacity()
    {
        return $this->hasOne('App\Models\Capacity','id','capacity_id');
    }

    public function internal()
    {
        
        return $this->hasOne('App\Models\InternalStorage','id','internal_stroage_id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Variant_images','variant_id','id')->orderBy('sr_no')->limit(1);
    }

    public function all_images()
    {
        return $this->hasMany('App\Models\Variant_images','variant_id','id')->orderBy('sr_no')->whereNull('deleted_at');
    }

    public function vhacode()
    {
        return $this->hasOne('App\Models\ProviderVariant','variant_id','id');
    }
    public function getvhacode()
    {
        return $this->hasOne('App\Models\ProviderVariant','variant_id','id');
    }

    // common method trigger while deleting variant. this will delete all related relational data.
    public static function boot() {
        parent::boot();
       
        static::deleting(function($variant) { // before delete() method call this
            $variant->all_images()->delete();
        });
    }


    /******************Relation Used For API purpose To overcome Encrypted ID********************/
    public function api_capacity(){
        return $this->hasOne('App\Models\Capacity','capacity_unique_id','capacity_id');
    }
    public function api_internal(){
        return $this->hasOne('App\Models\InternalStorage','storage_unique_id','internal_stroage_id');
    }
    public function api_handset(){
        return $this->belongsTo('App\Models\Handset','handset_id','id');
    }
    public function api_color(){
        return $this->belongsTo('App\Models\Color','color_id','color_unique_id');
    }

    public static function checkAssignProvider($request) {
        $handsets= self::select('id','variant_name','handset_id')->whereIn('id',$request->variant_ids)->get();
        $providerHandsets= ProviderVariant::checkAssignProvider($request->provider_id,$request->variant_ids);
		$providerAssignedHandsets = [];
		$providerNotAssignedHandsets = [];
		foreach ($handsets as $handset) {
			if(in_array($handset['id'],$providerHandsets)){
				$providerAssignedHandsets[] = $handset;
			}else{
				$providerNotAssignedHandsets[] = $handset;
			}
		}
		$response['http_status'] = 200;
		$response['assigned_handsets'] = $providerAssignedHandsets;
		$response['not_assigned_Handsets'] = $providerNotAssignedHandsets;
        return $response;
    }
    

}
