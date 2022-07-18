<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class UserService extends Model
{
	protected $fillable = ['user_id','service_id','user_type'];

	public function serviceName()
    {
        return $this->hasOne(\App\Models\Services::class,'id','service_id');
    }
}