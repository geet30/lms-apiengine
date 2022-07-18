<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\MobileSettings\colors\BasicCrudMethods;
class Color extends Model
{
    use  HasFactory,BasicCrudMethods;
    protected $fillable = ['title','hexacode','description','status','color_unique_id'];
    const STATUS_ACTIVE = 1;

    public static function getColorNames(){
       return self::where('status',self::STATUS_ACTIVE)->select('title','id')->get();
    } 
  
}
