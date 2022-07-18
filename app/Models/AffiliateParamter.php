<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateParamter extends Model
{
    protected $fillable = ['user_id','service_id','plan_listing','plan_detail','remarketing','slug','terms'];

    public function journey()
    {
        return $this->hasOne('App\Models\UserService','user_id','user_id');
    }
}
