<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderVariant extends Model
{
   protected $table = 'provider_variants';

   protected $fillable = ['provider_id','handset_id','variant_id','type','vha_code','status'];    

   public function handset(){

   	return $this->hasOne('App\Models\Handset', 'id', 'handset_id');

   }   
    public function provider(){

   	return $this->hasOne('App\Models\Provider', 'id', 'provider_id');

   } 

   public static function checkAssignProvider($providerId,$handsetIds){
      try 
        {
            return self::select('variant_id')->where('provider_id',decryptGdprData($providerId))->whereIn('variant_id',$handsetIds)->get()->pluck('variant_id')->toArray();
        } catch (\Throwable $th) {
            throw $th;
        }
   }
   
   public static function assignProvider($data){
      try 
      {
         self::insert($data);
         return ['http_status'=>200, 'message'=>'Varaint assigned to selected provider.'];
      } catch (\Throwable $th) {
          throw $th;
      }
   }

}
