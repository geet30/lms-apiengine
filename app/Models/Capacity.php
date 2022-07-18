<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\MobileSettings\ram\BasicCrudMethods;
class Capacity extends Model
{
    use  HasFactory,BasicCrudMethods;

    protected $fillable = ['value','unit','description','status','created_at','updated_at','deleted_at','capacity_unique_id'] ;

    const STATUS_ACTIVE = 1;

    protected $appends = ['capacity_name'];

    public function getCapacityNameAttribute(){

        $value =$this->value;

        switch ($this->unit) {
            case '0':
                $value =$value.' MB';
                break;

            case '1':
                $value =$value.' GB';
                break;

            case '2':
                $value =$value.' TB';
                break;

            default:
                $value ='Invalid';
                break;
        }
        return  $value;
    }
    public static function capacityArr(){
        $arr = [0 => 'MB', 1 => 'GB'] ;
        return $arr;
    }

    public static function getCapacity(){
       return self::where('status',self::STATUS_ACTIVE)->select('value','id','unit')->get();
    }



}
