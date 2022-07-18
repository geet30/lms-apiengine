<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Affiliate\{ManageUsers, GeneralMethods, ManageRetention};

class AssignedUsers extends Model
{
    use ManageUsers, GeneralMethods, ManageRetention;
    protected $fillable = ['source_user_id', 'relational_user_id', 'relation_type', 'status','service_id','assigned_by'];
    public function providers()
    {

        return $this->belongsTo(\App\Models\Providers::class, 'relational_user_id', 'id')->select('name', 'id')->where('status', 1)->where('is_deleted', 0);
    }


    public function relatedSubaffiliates()
    {
        return $this->belongsTo(\App\Models\Affiliate::class, 'relational_user_id', 'user_id')->select('company_name', 'user_id', 'id');
    }
    public function userservices()
    {
        return $this->belongsTo(\App\Models\Affiliate::class, 'source_user_id', 'user_id')->select('company_name', 'user_id', 'id');
    }

    public function userData()
    {
        return $this->hasOne(\App\Models\User::class,'id','relational_user_id');
    }
}
