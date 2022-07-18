<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Affiliate\BasicCrudMethods;

class AffiliateParameters extends Model
{
    protected $fillable = ['user_id','service_id','key_local_id','value','parameter_group','key'];
    use BasicCrudMethods;
    public function journey()
    {
        return $this->hasOne('App\Models\UserService','user_id','user_id');
    }
}
