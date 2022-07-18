<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\MobileSettings\storage\BasicCrudMethods;
class InternalStorage extends Model
{
    use  HasFactory,BasicCrudMethods;
    protected $fillable = ['value','unit','description','status','created_at','updated_at','deleted_at','storage_unique_id'] ;
    const STATUS_ACTIVE = 1;
    protected $appends = ['storage_name'];

    public function getStorageNameAttribute(){

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
    public static function internalStorageArr(){
        $arr = [0 =>'MB', 1 => 'GB', 2 => 'TB'] ;
        return $arr;
     }

    public static function getStorage(){
       return self::where('status',self::STATUS_ACTIVE)->select('value','id','unit')->get();
    } 
}
