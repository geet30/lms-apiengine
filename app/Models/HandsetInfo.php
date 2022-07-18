<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandsetInfo extends Model
{
    protected $table = "hanset_more_infos";
    const STATUS_ACTIVE = '1';

    protected $fillable =['handset_id','image','title','s_no','status','linktype'];

    public function handset()
    {
        return $this->belongsTo('App\Models\Handset','handset_id','id');
    }

    public static function getHandsetInfo($id){
        return self::where(['status' => self::STATUS_ACTIVE, 'handset_id' => $id])->orderBy('s_no','asc')->get();
     } 
}
