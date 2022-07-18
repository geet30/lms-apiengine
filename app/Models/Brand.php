<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\MobileSettings\Brands\BasicCrudMethods;
class Brand extends Model
{
    use  HasFactory,BasicCrudMethods;
    protected $fillable = ['title','status','created_at','updated_at','deleted_at','os_name'] ;
    const STATUS_ACTIVE = 1;

    public static function getBrandNames(){
       return self::where('status',self::STATUS_ACTIVE)->pluck('title','id')->toArray();
    } 
}
