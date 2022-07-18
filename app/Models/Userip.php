<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Affiliate\{ManageUsers, GeneralMethods,IpWhitelist};

class Userip extends Model
{
    use ManageUsers, GeneralMethods, IpWhitelist;
    protected $table = 'user_ips'; 
    protected $fillable = ['user_id', 'ips', 'assigned_by','type'];
}
