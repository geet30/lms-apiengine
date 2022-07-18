<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatingSystem extends Model
{
    use HasFactory;
    protected $table = 'operating_systems';

    const STATUS_ACTIVE = 1;
    
    public static function getOperatingSystemNames(){
        return self::where('status',self::STATUS_ACTIVE)->pluck('title','id')->toArray();
     } 
}
