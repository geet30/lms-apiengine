<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class MoveInCalender extends Model{
	
    protected $table = 'move_in_calender';
    //use SoftDeletes;
	//protected $dates = ['deleted_at'];
    protected $fillable = ['year','date','holiday_type','state','holiday_title','holiday_content','created_by','updated_by','status','created_at','updated_at'];
}
